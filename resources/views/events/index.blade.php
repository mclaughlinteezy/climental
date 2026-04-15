<x-app-layout>
    <section class="surface-card rounded-5 p-4 p-lg-5 mb-4 event-hero">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="section-kicker">Events & Volunteering</span>
                <h2 class="display-6 mb-2">Find gatherings that restore, energize, and connect.</h2>
                <p class="text-muted lead mb-0">Browse mental health sessions, climate activities, and mixed events designed to grow both wellbeing and community impact.</p>
            </div>
            <div class="col-lg-4">
                <div class="chip-row justify-content-lg-end">
                    <a href="{{ route('events.index') }}" class="btn {{ !$category ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">All</a>
                    <a href="{{ route('events.index', ['category' => 'mental_health']) }}" class="btn {{ $category === 'mental_health' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Mental Health</a>
                    <a href="{{ route('events.index', ['category' => 'climate']) }}" class="btn {{ $category === 'climate' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Climate</a>
                    <a href="{{ route('events.index', ['category' => 'mixed']) }}" class="btn {{ $category === 'mixed' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Mixed</a>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4">
        @forelse($events as $event)
            @php
                $badgeClass = match($event->category) {
                    'mental_health' => 'bg-info-subtle text-info',
                    'climate' => 'bg-success-subtle text-success',
                    default => 'bg-primary-subtle text-primary',
                };
            @endphp
            <div class="col-md-6 col-xl-4">
                <article class="surface-card rounded-5 p-4 h-100 event-card">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                        <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                            {{ $event->category == 'mental_health' ? 'Mental Health' : ($event->category == 'climate' ? 'Climate Action' : 'Mixed') }}
                        </span>
                        <span class="badge text-bg-light border rounded-pill px-3 py-2">+{{ $event->points_reward }} pts</span>
                    </div>

                    <h3 class="h4 mb-2">{{ $event->title }}</h3>
                    <p class="text-muted mb-4">{{ Str::limit($event->description, 110) }}</p>

                    <div class="event-meta soft-panel p-3 mb-4">
                        <div class="small text-muted mb-2"><i class="bi bi-calendar-event me-2 text-primary"></i>{{ \Carbon\Carbon::parse($event->event_date)->format('D, M d, Y · h:i A') }}</div>
                        <div class="small text-muted mb-2"><i class="bi bi-geo-alt me-2 text-success"></i>{{ $event->location ?? 'Online / TBA' }}</div>
                        <div class="small text-muted"><i class="bi bi-people me-2 text-warning"></i>{{ $event->registrations_count }} attending</div>
                    </div>

                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-blue rounded-pill px-4">Open event</a>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center p-5">
                    <i class="bi bi-calendar-x fs-1 text-primary"></i>
                    <h3 class="h4 mt-3">No upcoming events found</h3>
                    <p class="text-muted mb-0">Try another category or check back soon for fresh opportunities.</p>
                </div>
            </div>
        @endforelse
    </div>

    <style>
        .event-hero {
            background:
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.08), transparent 25%),
                radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.09), transparent 28%),
                rgba(255, 255, 255, 0.92);
        }

        .event-card .btn-blue {
            width: fit-content;
        }
    </style>
</x-app-layout>
