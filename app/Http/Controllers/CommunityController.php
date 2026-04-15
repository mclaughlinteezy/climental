<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\SupportComment;
use App\Models\SupportGroup;
use App\Models\SupportPost;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = SupportPost::with([
                'user',
                'comments.user',
                'group',
                'likes',
                'repostSource.user',
                'repostSource.group',
            ])
            ->withCount(['comments', 'likes', 'reposts'])
            ->latest()
            ->paginate(15);

        $activeGroups = SupportGroup::withCount('posts')->orderBy('posts_count', 'desc')->take(5)->get();

        $communitySettings = [
            'title' => SystemSetting::value('community_title', 'Open social space for the Climental system.'),
            'intro' => SystemSetting::value('community_intro', 'Share updates, photos, support moments, and ideas with the wider campus community.'),
            'composer_placeholder' => SystemSetting::value('community_composer_placeholder', 'What would you like to share today?'),
            'enable_photos' => SystemSetting::value('community_enable_photos', '1') === '1',
            'enable_comments' => SystemSetting::value('community_enable_comments', '1') === '1',
            'enable_likes' => SystemSetting::value('community_enable_likes', '1') === '1',
            'enable_reposts' => SystemSetting::value('community_enable_reposts', '1') === '1',
        ];

        return view('community.index', compact('posts', 'activeGroups', 'communitySettings'));
    }

    public function storePost(Request $request)
    {
        abort_unless(SystemSetting::value('community_enable_photos', '1') === '1' || !$request->hasFile('image'), 403);

        $validated = $request->validate([
            'content' => 'required_without:image|string|max:2000',
            'image' => 'nullable|image|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community', 'public');
        }

        SupportPost::create([
            'title' => Str::limit(trim($validated['content'] ?? 'Photo update'), 60, ''),
            'user_id' => auth()->id(),
            'support_group_id' => null,
            'content' => $validated['content'] ?? '',
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Your post is live.');
    }

    public function storeComment(Request $request, SupportPost $post)
    {
        abort_unless(SystemSetting::value('community_enable_comments', '1') === '1', 403);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = SupportComment::create([
            'support_post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Comment added.',
                'comment' => [
                    'id' => $comment->id,
                    'user_name' => $comment->user->name,
                    'content' => $comment->content,
                    'created_at_human' => $comment->created_at->diffForHumans(),
                ],
                'comments_count' => $post->comments()->count(),
            ]);
        }

        return back()->with('success', 'Comment added.');
    }

    public function toggleLike(Request $request, SupportPost $post)
    {
        abort_unless(SystemSetting::value('community_enable_likes', '1') === '1', 403);

        $existingLike = $post->likes()->where('user_id', auth()->id())->first();

        if ($existingLike) {
            $existingLike->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Like removed.',
                    'liked' => false,
                    'likes_count' => $post->likes()->count(),
                ]);
            }

            return back()->with('info', 'Like removed.');
        }

        $post->likes()->create([
            'user_id' => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Post liked.',
                'liked' => true,
                'likes_count' => $post->likes()->count(),
            ]);
        }

        return back()->with('success', 'Post liked.');
    }

    public function repost(SupportPost $post)
    {
        abort_unless(SystemSetting::value('community_enable_reposts', '1') === '1', 403);

        SupportPost::create([
            'title' => 'Repost: '.Str::limit(trim($post->content ?: 'Community post'), 50, ''),
            'user_id' => auth()->id(),
            'support_group_id' => null,
            'content' => $post->content,
            'image_path' => $post->image_path,
            'repost_of_id' => $post->id,
        ]);

        return back()->with('success', 'Post reposted to your feed.');
    }

    public function image(SupportPost $post)
    {
        abort_unless($post->image_path, 404);
        abort_unless(Storage::disk('public')->exists($post->image_path), 404);

        return Storage::disk('public')->response($post->image_path);
    }

    public function moderate()
    {
        if (!in_array(auth()->user()->role, ['moderator', 'admin'])) {
            return abort(403, 'Unauthorized access to Moderation Dashboard.');
        }

        $reports = Report::with(['user'])->latest()->get();

        $flaggedPosts = SupportPost::whereHas('reports')->with('reports')->get();

        return view('community.moderate', compact('reports', 'flaggedPosts'));
    }

    public function updatePost(Request $request, SupportPost $post)
    {
        if (auth()->user()->role !== 'admin') {
            return abort(403);
        }

        $validated = $request->validate([
            'content' => 'nullable|string|max:2000',
            'image' => 'nullable|image|max:5120',
            'remove_image' => 'nullable|boolean',
        ]);

        $content = trim((string) ($validated['content'] ?? ''));
        $removeImage = (bool) ($validated['remove_image'] ?? false);

        if ($content === '' && !$request->hasFile('image') && !$post->image_path && !$removeImage) {
            return back()->withErrors([
                'content' => 'A post needs text or an image.',
            ]);
        }

        if ($removeImage && $post->image_path && Storage::disk('public')->exists($post->image_path)) {
            Storage::disk('public')->delete($post->image_path);
            $post->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                Storage::disk('public')->delete($post->image_path);
            }

            $post->image_path = $request->file('image')->store('community', 'public');
        }

        $post->content = $content;
        $post->title = Str::limit($content !== '' ? $content : 'Photo update', 60, '');
        $post->save();

        return back()->with('success', 'Post updated successfully.');
    }

    public function deletePost(SupportPost $post)
    {
        if (!in_array(auth()->user()->role, ['moderator', 'admin']) && auth()->id() !== $post->user_id) {
            return abort(403);
        }

        $post->delete();
        return back()->with('success', 'Post removed successfully.');
    }
}
