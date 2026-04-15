<x-admin-layout pageTitle="Edit Organization">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.organizations.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">Edit Resource</div>
                <h3 class="h4 mb-1">{{ $organization->name }}</h3>
                <p class="text-muted mb-4">Update this organization’s details so the directory stays accurate and helpful.</p>

                <form action="{{ route('admin.organizations.update', $organization->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.organizations._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin-primary">Save Changes</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
