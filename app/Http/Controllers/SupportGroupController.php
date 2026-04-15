<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportGroup;
use App\Models\SupportPost;
use App\Models\SupportComment;
use Illuminate\Support\Str;

class SupportGroupController extends Controller
{
    public function index()
    {
        $groups = SupportGroup::withCount('posts')->get();
        return view('mental-health.groups', compact('groups'));
    }

    public function show(SupportGroup $group)
    {
        $posts = $group->posts()->with(['user', 'comments.user'])->latest()->get();
        return view('mental-health.group-show', compact('group', 'posts'));
    }

    public function storePost(Request $request, SupportGroup $group)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        SupportPost::create([
            'title' => Str::limit(trim($request->content), 60, ''),
            'support_group_id' => $group->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Post published successfully!');
    }

    public function storeComment(Request $request, SupportPost $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        SupportComment::create([
            'support_post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added.');
    }
}
