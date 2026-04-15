<x-app-layout>
    @php
        $currentUser = auth()->user();
        $isAdmin = $currentUser && $currentUser->role === 'admin';
    @endphp

    <div class="community-shell">
        <div class="row g-4 justify-content-center">
            <div class="col-xxl-8 col-xl-8">
                <section class="surface-card insta-top rounded-5 p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                        <div>
                            <span class="section-kicker">Community Feed</span>
                            <h2 class="h2 mb-2">{{ $communitySettings['title'] }}</h2>
                            <p class="text-muted mb-0">{{ $communitySettings['intro'] }}</p>
                        </div>
                        @if(in_array($currentUser->role, ['moderator', 'admin']))
                            <a href="{{ route('community.moderate') }}" class="btn btn-warning rounded-pill px-4">
                                <i class="bi bi-shield-check me-1"></i> Moderation Panel
                            </a>
                        @endif
                    </div>
                </section>

                <section class="surface-card rounded-5 p-3 p-md-4 mb-4">
                    <div class="d-flex gap-3 overflow-auto stories-strip">
                        @foreach($activeGroups as $group)
                            <a href="{{ route('mental-health.groups.show', $group->id) }}" class="story-card text-center flex-shrink-0">
                                <div class="story-ring">
                                    <div class="story-avatar">
                                        {{ strtoupper(substr($group->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="story-label">{{ \Illuminate\Support\Str::limit($group->name, 16) }}</div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="surface-card rounded-5 p-4 mb-4 composer-card">
                    <form action="{{ route('community.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="post-avatar">
                                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $currentUser->name }}</div>
                                <div class="small text-muted">Share something with the community</div>
                            </div>
                        </div>

                        <textarea
                            name="content"
                            class="form-control composer-input rounded-5 mb-3"
                            rows="4"
                            placeholder="{{ $communitySettings['composer_placeholder'] }}"
                        >{{ old('content') }}</textarea>

                        @if($communitySettings['enable_photos'])
                            <input
                                type="file"
                                name="image"
                                id="community-image-input"
                                accept="image/*"
                                class="d-none"
                            >
                        @endif

                        <div id="community-image-preview" class="composer-image-preview d-none mb-3">
                            <img src="" alt="Selected upload preview" id="community-image-preview-tag" class="composer-preview-image">
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                            @if($communitySettings['enable_photos'])
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <label for="community-image-input" class="btn btn-outline-secondary rounded-pill px-4 mb-0">
                                        <i class="bi bi-image me-1"></i> Add photo
                                    </label>
                                    <span id="community-image-name" class="small text-muted">No photo selected</span>
                                </div>
                            @else
                                <div class="small text-muted">Photo uploads are currently turned off by admin settings.</div>
                            @endif
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Post to feed</button>
                        </div>
                    </form>
                </section>

                @forelse($posts as $post)
                    @php
                        $likedByUser = $post->likes->contains('user_id', $currentUser->id);
                        $displayPost = $post->repostSource ?? $post;
                    @endphp
                    <article class="surface-card insta-post rounded-5 mb-4 overflow-hidden" data-post-id="{{ $post->id }}">
                        <div class="post-header d-flex justify-content-between align-items-center p-4 pb-3 gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="post-avatar">
                                    {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $post->user->name ?? 'Anonymous' }}</div>
                                    <div class="small text-muted">
                                        {{ $post->created_at->diffForHumans() }}
                                        @if($post->group)
                                            · {{ $post->group->name }}
                                        @elseif($post->repostSource)
                                            · reposted to community
                                        @else
                                            · community post
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                @if($isAdmin)
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editPostModal{{ $post->id }}"
                                    >
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>

                                    <form action="{{ route('community.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-trash3 me-1"></i> Delete
                                        </button>
                                    </form>
                                @endif

                                <button
                                    type="button"
                                    class="btn btn-link text-muted p-0 border-0 post-more"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reportModal{{ $post->id }}"
                                    title="Report Post"
                                >
                                    <i class="bi bi-three-dots"></i>
                                </button>
                            </div>
                        </div>

                        @if($post->repostSource)
                            <div class="px-4 pb-3">
                                <div class="repost-banner rounded-pill px-3 py-2 small">
                                    <i class="bi bi-repeat me-1"></i> Reposted from {{ $post->repostSource->user->name ?? 'another member' }}
                                </div>
                            </div>
                        @endif

                        @if($displayPost->content)
                            <div class="px-4 pb-3">
                                <div class="post-content-card rounded-4 p-4">
                                    <p class="mb-0 post-copy">{{ $displayPost->content }}</p>
                                </div>
                            </div>
                        @endif

                        @if($displayPost->image_path)
                            <div class="px-4 pb-3">
                                <div class="post-image-frame rounded-5 overflow-hidden">
                                    <img src="{{ route('community.posts.image', $displayPost->id) }}" alt="Post image" class="post-image">
                                </div>
                            </div>
                        @endif

                        <div class="px-4 pb-4">
                            <div class="post-actions d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    @if($communitySettings['enable_likes'])
                                        <form action="{{ route('community.posts.like', $post->id) }}" method="POST" class="js-like-form">
                                            @csrf
                                            <button type="submit" class="post-action-btn js-like-button {{ $likedByUser ? 'liked' : '' }}" aria-label="Like">
                                                <i class="bi js-like-icon {{ $likedByUser ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($communitySettings['enable_comments'])
                                        <button type="button" class="post-action-btn" aria-label="Comment" data-bs-toggle="modal" data-bs-target="#commentsModal{{ $post->id }}">
                                            <i class="bi bi-chat"></i>
                                        </button>
                                    @endif
                                    @if($communitySettings['enable_reposts'])
                                        <form action="{{ route('community.posts.repost', $post->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="post-action-btn" aria-label="Repost">
                                                <i class="bi bi-repeat"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="small text-muted js-post-stats">
                                    @if($communitySettings['enable_likes'])<span class="js-likes-count">{{ $post->likes_count }}</span> likes @endif
                                    @if($communitySettings['enable_comments'])· <span class="js-comments-count">{{ $post->comments_count }}</span> comments @endif
                                    @if($communitySettings['enable_reposts'])· <span class="js-reposts-count">{{ $post->reposts_count }}</span> reposts @endif
                                </div>
                            </div>

                            <div class="post-meta mt-3">
                                <div class="fw-semibold text-dark mb-2">{{ $post->user->name ?? 'Anonymous' }}</div>
                                @if($communitySettings['enable_comments'])
                                    <div class="small text-muted">Tap the comment icon to open the full conversation.</div>
                                @endif
                            </div>
                        </div>
                    </article>

                    @if($isAdmin)
                        <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" aria-labelledby="editPostModalLabel{{ $post->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 rounded-5 shadow-lg">
                                    <form action="{{ route('community.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-0 px-4 pt-4">
                                            <div>
                                                <h5 class="modal-title mb-1" id="editPostModalLabel{{ $post->id }}">Edit Community Post</h5>
                                                <div class="small text-muted">Update the caption or replace the photo for this post.</div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body px-4">
                                            <label for="editPostContent{{ $post->id }}" class="form-label fw-semibold">Caption</label>
                                            <textarea
                                                id="editPostContent{{ $post->id }}"
                                                name="content"
                                                class="form-control rounded-4 mb-3"
                                                rows="5"
                                                placeholder="Update what this post says..."
                                            >{{ old('content', $post->content) }}</textarea>

                                            @if($post->image_path)
                                                <div class="mb-3">
                                                    <div class="small fw-semibold text-dark mb-2">Current photo</div>
                                                    <div class="admin-post-image-preview rounded-4 overflow-hidden">
                                                        <img src="{{ route('community.posts.image', $post->id) }}" alt="Current post image" class="w-100">
                                                    </div>
                                                </div>
                                            @endif

                                            <label for="editPostImage{{ $post->id }}" class="form-label fw-semibold">Replace photo</label>
                                            <input type="file" id="editPostImage{{ $post->id }}" name="image" class="form-control rounded-4 mb-3" accept="image/*">

                                            @if($post->image_path)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="removeImage{{ $post->id }}" name="remove_image">
                                                    <label class="form-check-label" for="removeImage{{ $post->id }}">
                                                        Remove the current photo from this post
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4">
                                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="modal fade" id="reportModal{{ $post->id }}" tabindex="-1" aria-labelledby="reportModalLabel{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-5 shadow-lg">
                                <form action="{{ route('reports.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-header border-0 px-4 pt-4">
                                        <h5 class="modal-title" id="reportModalLabel{{ $post->id }}">Report Content</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-4">
                                        <input type="hidden" name="reportable_id" value="{{ $post->id }}">
                                        <input type="hidden" name="reportable_type" value="App\Models\SupportPost">
                                        <label for="reason{{ $post->id }}" class="form-label">Reason for reporting</label>
                                        <textarea class="form-control rounded-4" id="reason{{ $post->id }}" name="reason" rows="4" required placeholder="Describe why this post should be reviewed..."></textarea>
                                    </div>
                                    <div class="modal-footer border-0 px-4 pb-4">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">Submit Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($communitySettings['enable_comments'])
                        <div class="modal fade" id="commentsModal{{ $post->id }}" tabindex="-1" aria-labelledby="commentsModalLabel{{ $post->id }}" aria-hidden="true" data-post-id="{{ $post->id }}">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content comments-modal">
                                    <div class="modal-header comments-modal-header">
                                        <div class="w-100 text-center fw-bold fs-4" id="commentsModalLabel{{ $post->id }}">Comments</div>
                                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-4" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body comments-modal-body">
                                        @if($post->comments->count() > 0)
                                            <div class="d-grid gap-4 js-comments-list">
                                                @foreach($post->comments as $comment)
                                                    <article class="comment-item">
                                                        <div class="d-flex gap-3 align-items-start">
                                                            <div class="comment-avatar">
                                                                {{ strtoupper(substr($comment->user->name ?? 'A', 0, 1)) }}
                                                            </div>

                                                            <div class="flex-grow-1">
                                                                <div class="d-flex justify-content-between align-items-start gap-3">
                                                                    <div>
                                                                        <div class="comment-meta">
                                                                            <span class="comment-user">{{ $comment->user->name }}</span>
                                                                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                                                        </div>
                                                                        <div class="comment-text mt-1">{{ $comment->content }}</div>
                                                                    </div>
                                                                    <div class="comment-side-actions">
                                                                        <button type="button" class="comment-icon-btn" aria-label="Like comment">
                                                                            <i class="bi bi-heart"></i>
                                                                        </button>
                                                                        <button type="button" class="comment-icon-btn" aria-label="Reply to comment">
                                                                            <i class="bi bi-reply"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <div class="comment-subactions mt-3">
                                                                    <button type="button" class="comment-subaction">Reply</button>
                                                                    <button type="button" class="comment-subaction">See translation</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-5 js-comments-empty">
                                                <i class="bi bi-chat-square-heart fs-1 text-secondary"></i>
                                                <h4 class="mt-3 text-white">No comments yet</h4>
                                                <p class="text-secondary mb-0">Start the conversation for this post.</p>
                                            </div>
                                            <div class="d-grid gap-4 js-comments-list d-none"></div>
                                        @endif
                                    </div>

                                    <div class="comments-reactions">
                                        <button type="button">❤️</button>
                                        <button type="button">🙌</button>
                                        <button type="button">🔥</button>
                                        <button type="button">👏</button>
                                        <button type="button">😢</button>
                                        <button type="button">😍</button>
                                        <button type="button">😮</button>
                                        <button type="button">😂</button>
                                    </div>

                                    <div class="comments-modal-footer">
                                        <form action="{{ route('community.posts.comments.store', $post->id) }}" method="POST" class="comment-entry-form js-comment-form">
                                            @csrf
                                            <div class="comment-avatar comment-avatar-sm">
                                                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                                            </div>
                                            <input
                                                type="text"
                                                id="comment-input-{{ $post->id }}"
                                                name="content"
                                                class="comment-entry-input"
                                                placeholder="What do you think of this?"
                                                required
                                            >
                                            <button type="submit" class="comment-post-btn js-comment-submit">Post</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="empty-state text-center p-5">
                        <i class="bi bi-chat-square-heart fs-1 text-primary"></i>
                        <h3 class="h4 mt-3">No recent community activity yet</h3>
                        <p class="text-muted mb-0">Be the first to post a photo, reflection, or update to the feed.</p>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            </div>

            <div class="col-xxl-4 col-xl-4">
                <section class="surface-card rounded-5 p-4 sticky-xl-top community-sidebar" style="top: 2rem;">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="profile-avatar-lg">
                            {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $currentUser->name }}</div>
                            <div class="small text-muted">{{ ucfirst($currentUser->role) }} · Open social feed</div>
                        </div>
                    </div>

                    <div class="soft-panel p-3 mb-4">
                        <div class="small text-uppercase text-muted fw-semibold mb-2">Feed rules</div>
                        <div class="fw-semibold text-dark mb-1">Post kindly, support openly, report harmful content.</div>
                        <p class="small text-muted mb-0">This space now behaves like a social media feed, but it should still feel safe and respectful.</p>
                    </div>

                    <div class="section-header mb-3">
                        <div>
                            <span class="section-kicker">Suggested Groups</span>
                            <h3 class="h5 mb-0">Trending now</h3>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        @foreach($activeGroups as $group)
                            <article class="soft-panel p-3">
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="group-avatar-sm">
                                            {{ strtoupper(substr($group->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $group->name }}</div>
                                            <div class="small text-muted">{{ $group->posts_count }} posts</div>
                                        </div>
                                    </div>
                                    <a href="{{ route('mental-health.groups.show', $group->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Open</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>

    <style>
        .community-shell {
            max-width: 1320px;
            margin: 0 auto;
        }

        .insta-top {
            background:
                radial-gradient(circle at top right, rgba(236, 72, 153, 0.08), transparent 25%),
                radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.08), transparent 25%),
                rgba(255, 255, 255, 0.95);
        }

        .stories-strip {
            scrollbar-width: none;
        }

        .stories-strip::-webkit-scrollbar {
            display: none;
        }

        .story-card {
            width: 92px;
            color: inherit;
        }

        .story-ring {
            width: 76px;
            height: 76px;
            margin: 0 auto 0.75rem;
            padding: 3px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ec4899, #f59e0b, #10b981, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .story-avatar,
        .profile-avatar-lg,
        .group-avatar-sm,
        .post-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
        }

        .story-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 4px solid white;
            font-size: 1.1rem;
        }

        .story-label {
            font-size: 0.77rem;
            font-weight: 600;
            color: #475569;
            line-height: 1.3;
        }

        .composer-card {
            max-width: 760px;
            margin-left: auto;
            margin-right: auto;
        }

        .composer-input {
            min-height: 120px;
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            resize: vertical;
        }

        .composer-image-preview {
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: #f8fafc;
            border-radius: 24px;
            overflow: hidden;
        }

        .composer-preview-image {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            display: block;
        }

        .insta-post {
            max-width: 760px;
            margin-left: auto;
            margin-right: auto;
            background: rgba(255, 255, 255, 0.97);
        }

        .post-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            font-size: 1rem;
            box-shadow: 0 10px 24px rgba(14, 165, 233, 0.2);
        }

        .post-more {
            font-size: 1.1rem;
        }

        .repost-banner {
            background: rgba(14, 165, 233, 0.08);
            color: #0369a1;
            border: 1px solid rgba(14, 165, 233, 0.12);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .post-content-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .post-copy {
            font-size: 1rem;
            line-height: 1.8;
            color: #1e293b;
            white-space: pre-wrap;
        }

        .post-image-frame {
            border: 1px solid rgba(148, 163, 184, 0.14);
            background: #f8fafc;
        }

        .post-image {
            width: 100%;
            max-height: 640px;
            object-fit: cover;
            display: block;
        }

        .admin-post-image-preview {
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: #f8fafc;
        }

        .admin-post-image-preview img {
            max-height: 320px;
            object-fit: cover;
            display: block;
        }

        .post-actions {
            padding-top: 0.25rem;
            border-top: 1px solid rgba(148, 163, 184, 0.14);
        }

        .post-action-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 0;
            background: transparent;
            color: #0f172a;
            font-size: 1.1rem;
            transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
        }

        .post-action-btn:hover {
            background: #f8fafc;
            color: #ec4899;
            transform: translateY(-2px);
        }

        .post-action-btn.liked {
            color: #ec4899;
        }

        .comment-line {
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .comments-modal {
            background: #171a1d;
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            overflow: hidden;
        }

        .comments-modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem 1.5rem;
            background: #171a1d;
            position: relative;
        }

        .comments-modal-body {
            padding: 1.5rem;
            background: #171a1d;
        }

        .comment-item {
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .comment-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .comment-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            color: white;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .comment-avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }

        .comment-meta {
            display: flex;
            gap: 0.6rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .comment-user {
            font-weight: 700;
            color: #f8fafc;
        }

        .comment-time {
            color: #9ca3af;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .comment-text {
            color: #f1f5f9;
            font-size: 1.05rem;
            line-height: 1.5;
            white-space: pre-wrap;
        }

        .comment-side-actions {
            display: flex;
            gap: 0.45rem;
            flex-shrink: 0;
        }

        .comment-icon-btn {
            background: transparent;
            color: #d1d5db;
            border: 0;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .comment-icon-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        .comment-subactions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .comment-subaction {
            background: transparent;
            border: 0;
            color: #9ca3af;
            font-size: 0.95rem;
            font-weight: 700;
            padding: 0;
        }

        .comments-reactions {
            display: flex;
            gap: 0.35rem;
            overflow-x: auto;
            padding: 0.85rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: #111418;
        }

        .comments-reactions button {
            background: transparent;
            border: 0;
            font-size: 1.8rem;
            line-height: 1;
        }

        .comments-modal-footer {
            padding: 1rem;
            background: #171a1d;
        }

        .comment-entry-form {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .comment-entry-input {
            flex: 1;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: #22262b;
            color: #f8fafc;
            border-radius: 999px;
            padding: 0.9rem 1rem;
            outline: none;
        }

        .comment-entry-input::placeholder {
            color: #9ca3af;
        }

        .comment-post-btn {
            background: transparent;
            border: 0;
            color: #3b82f6;
            font-weight: 700;
            padding: 0 0.3rem;
        }

        .profile-avatar-lg {
            width: 58px;
            height: 58px;
            border-radius: 20px;
            font-size: 1.2rem;
        }

        .group-avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            font-size: 0.95rem;
        }

        @media (max-width: 1199.98px) {
            .community-sidebar {
                position: static !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('community-image-input');
            const fileName = document.getElementById('community-image-name');
            const previewWrapper = document.getElementById('community-image-preview');
            const previewImage = document.getElementById('community-image-preview-tag');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (fileInput && fileName && previewWrapper && previewImage) {
                fileInput.addEventListener('change', function (event) {
                    const [file] = event.target.files || [];

                    if (!file) {
                        fileName.textContent = 'No photo selected';
                        previewWrapper.classList.add('d-none');
                        previewImage.src = '';
                        return;
                    }

                    fileName.textContent = file.name;

                    const reader = new FileReader();
                    reader.onload = function (loadEvent) {
                        previewImage.src = loadEvent.target?.result || '';
                        previewWrapper.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                });
            }

            document.querySelectorAll('.js-like-form').forEach(function (form) {
                form.addEventListener('submit', async function (event) {
                    event.preventDefault();

                    const postCard = form.closest('[data-post-id]');
                    const button = form.querySelector('.js-like-button');
                    const icon = form.querySelector('.js-like-icon');
                    const likesCount = postCard?.querySelector('.js-likes-count');

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        });

                        if (!response.ok) {
                            throw new Error('Like request failed');
                        }

                        const data = await response.json();

                        if (likesCount) {
                            likesCount.textContent = data.likes_count;
                        }

                        if (button && icon) {
                            button.classList.toggle('liked', data.liked);
                            icon.classList.toggle('bi-heart-fill', data.liked);
                            icon.classList.toggle('bi-heart', !data.liked);
                        }
                    } catch (error) {
                        window.location.reload();
                    }
                });
            });

            document.querySelectorAll('.js-comment-form').forEach(function (form) {
                form.addEventListener('submit', async function (event) {
                    event.preventDefault();

                    const input = form.querySelector('input[name="content"]');
                    const submitButton = form.querySelector('.js-comment-submit');
                    const modal = form.closest('.modal');
                    const postId = modal?.getAttribute('data-post-id');
                    const postCard = postId ? document.querySelector(`[data-post-id="${postId}"]`) : null;
                    const modalContent = form.closest('.comments-modal');
                    const commentsCount = postCard?.querySelector('.js-comments-count');
                    const commentsList = modalContent?.querySelector('.js-comments-list');
                    const emptyState = modalContent?.querySelector('.js-comments-empty');

                    if (!input || !input.value.trim()) {
                        return;
                    }

                    const originalLabel = submitButton?.textContent;

                    try {
                        if (submitButton) {
                            submitButton.disabled = true;
                            submitButton.textContent = 'Posting...';
                        }

                        const formData = new FormData(form);
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: formData,
                        });

                        if (!response.ok) {
                            throw new Error('Comment request failed');
                        }

                        const data = await response.json();

                        if (commentsCount) {
                            commentsCount.textContent = data.comments_count;
                        }

                        if (emptyState) {
                            emptyState.classList.add('d-none');
                        }

                        if (commentsList) {
                            commentsList.classList.remove('d-none');
                            commentsList.insertAdjacentHTML('beforeend', `
                                <article class="comment-item">
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="comment-avatar">
                                            ${data.comment.user_name.charAt(0).toUpperCase()}
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start gap-3">
                                                <div>
                                                    <div class="comment-meta">
                                                        <span class="comment-user">${data.comment.user_name}</span>
                                                        <span class="comment-time">${data.comment.created_at_human}</span>
                                                    </div>
                                                    <div class="comment-text mt-1">${data.comment.content}</div>
                                                </div>
                                                <div class="comment-side-actions">
                                                    <button type="button" class="comment-icon-btn" aria-label="Like comment">
                                                        <i class="bi bi-heart"></i>
                                                    </button>
                                                    <button type="button" class="comment-icon-btn" aria-label="Reply to comment">
                                                        <i class="bi bi-reply"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="comment-subactions mt-3">
                                                <button type="button" class="comment-subaction">Reply</button>
                                                <button type="button" class="comment-subaction">See translation</button>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            `);
                        }

                        input.value = '';
                    } catch (error) {
                        window.location.reload();
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = originalLabel || 'Post';
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
