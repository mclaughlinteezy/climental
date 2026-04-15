<x-app-layout>
    @php
        $badgeClass = match($event->category) {
            'mental_health' => 'bg-info-subtle text-info',
            'climate' => 'bg-success-subtle text-success',
            default => 'bg-primary-subtle text-primary',
        };
    @endphp

    <section class="surface-card rounded-5 p-4 p-lg-5 mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
            <div class="pe-lg-4">
                <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 mb-3">
                    {{ $event->category == 'mental_health' ? 'Mental Health' : ($event->category == 'climate' ? 'Climate Action' : 'Mixed') }}
                </span>
                <h2 class="display-6 mb-2">{{ $event->title }}</h2>
                <p class="text-muted lead mb-0">A focused gathering designed to strengthen connection, action, and student wellbeing.</p>
            </div>
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back to Events
            </a>
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
        <div class="col-lg-8">
            <section class="surface-card rounded-5 p-4 p-lg-5 h-100">
                <span class="section-kicker">About This Event</span>
                <h3 class="h4 mb-3">What to expect</h3>
                <p class="text-dark mb-0" style="white-space: pre-wrap;">{{ $event->description }}</p>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="surface-card rounded-5 p-4">
                <span class="section-kicker">Event Details</span>
                <div class="soft-panel p-3 mb-4">
                    <div class="small text-muted mb-2"><i class="bi bi-calendar-event me-2 text-primary"></i>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y · h:i A') }}</div>
                    <div class="small text-muted mb-2"><i class="bi bi-geo-alt me-2 text-success"></i>{{ $event->location ?? 'TBA' }}</div>
                    <div class="small text-muted mb-2"><i class="bi bi-people me-2 text-warning"></i>{{ $event->registrations_count }} attending</div>
                    <div class="small text-muted"><i class="bi bi-star-fill me-2 text-danger"></i>+{{ $event->points_reward }} reward points</div>
                </div>

                <form action="{{ route('events.rsvp', $event->id) }}" method="POST">
                    @csrf
                    @if($isRegistered)
                        <button type="submit" class="btn btn-outline-danger rounded-pill px-4 w-100">Cancel Registration</button>
                        <div class="small text-muted mt-2">You are currently attending this event.</div>
                    @else
                        <button type="submit" class="btn btn-blue rounded-pill px-4 w-100">Register Now</button>
                        <div class="small text-success mt-2">Earn {{ $event->points_reward }} points for showing up.</div>
                    @endif
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
