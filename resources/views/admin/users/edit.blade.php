<x-admin-layout pageTitle="Edit User">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">User Profile</div>
                <h3 class="h4 mb-1">Edit {{ $user->name }}</h3>
                <p class="text-muted mb-4">Update this user’s profile details and permission level.</p>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label admin-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label admin-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label admin-label">Role</label>
                        <select id="role" name="role" class="form-select @error('role') is-invalid @enderror">
                            @foreach(['student', 'moderator', 'manager', 'admin'] as $role)
                                <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-admin-primary">Save Changes</button>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
