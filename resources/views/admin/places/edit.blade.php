<x-admin-layout pageTitle="Edit Map Place">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.places.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">Edit Place</div>
                <h3 class="h4 mb-1">{{ $place->name }}</h3>
                <p class="text-muted mb-4">Update this map location so users see the right category, description, and coordinates.</p>

                <form action="{{ route('admin.places.update', $place) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.places._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin-primary">Save Changes</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
