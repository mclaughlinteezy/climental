<x-admin-layout pageTitle="Add Organization">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.organizations.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">New Resource</div>
                <h3 class="h4 mb-1">Add a new organization</h3>
                <p class="text-muted mb-4">Add a support service, clinic, NGO, or campus resource so students can find it quickly.</p>

                <form action="{{ route('admin.organizations.store') }}" method="POST">
                    @csrf
                    @include('admin.organizations._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin-success">Add Organization</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
