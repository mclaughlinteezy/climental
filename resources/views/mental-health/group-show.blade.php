<x-app-layout>
    <section class="surface-card rounded-5 p-4 p-lg-5 mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
            <div>
                <span class="section-kicker">Support Group</span>
                <h2 class="display-6 mb-2">{{ $group->name }}</h2>
                <p class="text-muted lead mb-0">{{ $group->description }}</p>
            </div>
            <a href="{{ route('mental-health.groups.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to Groups</a>
        </div>
    </section>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <section class="surface-card rounded-5 p-4 sticky-xl-top" style="top: 2rem;">
                <div class="section-header">
                    <div>
                        <span class="section-kicker">Share</span>
                        <h3 class="h4 mb-1">Start a conversation</h3>
                        <p class="text-muted mb-0">Post a thought, question, or supportive reflection for the group.</p>
                    </div>
                </div>

                <form action="{{ route('mental-health.groups.posts.store', $group->id) }}" method="POST">
                    @csrf
                    <textarea name="content" class="form-control rounded-4 mb-3" rows="5" placeholder="Share your thoughts or ask for support here..." required></textarea>
                    <button type="submit" class="btn btn-blue rounded-pill px-4 w-100">Post to Group</button>
                </form>
            </section>
        </div>

        <div class="col-lg-7">
            <div class="section-header">
                <div>
                    <span class="section-kicker">Recent Discussions</span>
                    <h3 class="h4 mb-1">What people are saying</h3>
                </div>
            </div>

            @forelse($posts as $post)
                <article class="surface-card rounded-5 p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                        <div class="fw-bold text-primary">{{ $post->user->name ?? 'Anonymous' }}</div>
                        <div class="small text-muted">{{ $post->created_at->diffForHumans() }}</div>
                    </div>

                    <p class="mb-4">{{ $post->content }}</p>

                    <div class="soft-panel p-3">
                        <div class="small text-muted mb-3"><i class="bi bi-chat-left-text me-1"></i> {{ $post->comments->count() }} comments</div>

                        @foreach($post->comments as $comment)
                            <div class="comment-row d-flex gap-3 mb-3">
                                <div class="comment-avatar">{{ substr($comment->user->name, 0, 1) }}</div>
                                <div class="flex-grow-1">
                                    <div class="bg-white border rounded-4 p-3">
                                        <div class="fw-semibold small mb-1">{{ $comment->user->name }}</div>
                                        <div class="small">{{ $comment->content }}</div>
                                    </div>
                                    <div class="small text-muted mt-1">{{ $comment->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach

                        <form action="{{ route('mental-health.posts.comments.store', $post->id) }}" method="POST" class="d-flex gap-2 flex-wrap">
                            @csrf
                            <input type="text" name="content" class="form-control rounded-pill" placeholder="Write a reply..." required>
                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4">Reply</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="empty-state text-center p-5">
                    <i class="bi bi-chat-heart fs-1 text-primary"></i>
                    <h3 class="h4 mt-3">No posts yet in this group</h3>
                    <p class="text-muted mb-0">Be the first to start a supportive conversation here.</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .comment-avatar {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #10b981, #0ea5e9);
            color: white;
            font-weight: 700;
            flex-shrink: 0;
        }
    </style>
</x-app-layout>
