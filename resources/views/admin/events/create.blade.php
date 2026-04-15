<x-admin-layout pageTitle="Create Event">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">New Event</div>
                <h3 class="h4 mb-1">Create a campus event</h3>
                <p class="text-muted mb-4">Add the details clearly so students understand what the event is, where it happens, and what they earn.</p>

                <form action="{{ route('admin.events.store') }}" method="POST">
                    @csrf
                    @include('admin.events._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin-success">Create Event</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
