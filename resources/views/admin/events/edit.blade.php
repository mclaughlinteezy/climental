<x-admin-layout pageTitle="Edit Event">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">Edit Event</div>
                <h3 class="h4 mb-1">{{ $event->title }}</h3>
                <p class="text-muted mb-4">Refine event details, timing, and reward points without losing clarity for attendees.</p>

                <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.events._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin-primary">Update Event</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
