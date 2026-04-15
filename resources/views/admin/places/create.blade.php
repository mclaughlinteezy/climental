<x-admin-layout pageTitle="Add Map Place">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.places.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">New Place</div>
                <h3 class="h4 mb-1">Add a map place</h3>
                <p class="text-muted mb-4">Create a pinned location for the public map with the right label, category, and coordinates.</p>

                <form action="{{ route('admin.places.store') }}" method="POST">
                    @csrf
                    @include('admin.places._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin-success">Add Place</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
