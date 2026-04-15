<x-admin-layout pageTitle="Add Recycling Point">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.recycling-points.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">New Recycling Point</div>
                <h3 class="h4 mb-1">Add a recycling point</h3>
                <p class="text-muted mb-4">Create a new recycling location so it appears in both climate and map experiences.</p>

                <form action="{{ route('admin.recycling-points.store') }}" method="POST">
                    @csrf
                    @include('admin.recycling-points._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin-success">Add Recycling Point</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
