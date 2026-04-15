<x-app-layout>
    <section class="surface-card rounded-5 p-4 p-lg-5 mb-4 groups-hero">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
            <div>
                <span class="section-kicker">Peer Support Groups</span>
                <h2 class="display-6 mb-2">Find the room that feels right for where you are.</h2>
                <p class="text-muted lead mb-0">Join anonymous or public support spaces where students share similar experiences and listen without judgment.</p>
            </div>
            <a href="{{ route('mental-health.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to Mental Health</a>
        </div>
    </section>

    <div class="row g-4">
        @if($groups->count() > 0)
            @foreach($groups as $group)
                <div class="col-md-6 col-xl-4">
                    <article class="surface-card rounded-5 p-4 h-100">
                        <div class="icon-pill bg-primary-subtle text-primary mb-3"><i class="bi bi-chat-heart-fill"></i></div>
                        <h3 class="h4 mb-2">{{ $group->name }}</h3>
                        <p class="text-muted mb-4">{{ Str::limit($group->description, 120) }}</p>
                        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                            <span class="badge text-bg-light text-secondary border rounded-pill px-3 py-2">{{ $group->posts_count }} {{ Str::plural('post', $group->posts_count) }}</span>
                            <a href="{{ route('mental-health.groups.show', $group->id) }}" class="btn btn-blue rounded-pill px-4">Enter Room</a>
                        </div>
                    </article>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="empty-state text-center p-5">
                    <i class="bi bi-chat-square-heart fs-1 text-primary"></i>
                    <h3 class="h4 mt-3">No active support groups right now</h3>
                    <p class="text-muted mb-0">Please check back later for new peer spaces.</p>
                </div>
            </div>
        @endif
    </div>

    <style>
        .groups-hero {
            background:
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.08), transparent 24%),
                radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.09), transparent 25%),
                rgba(255, 255, 255, 0.92);
        }
    </style>
</x-app-layout>
