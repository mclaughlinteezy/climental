<section>
    <header>
        <h4 class="text-dark">
            {{ __('Profile Information') }}
        </h4>
        <p class="text-muted">
            {{ __("Update your account's profile information, avatar, and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('patch')

        <!-- Avatar -->
        <div class="mb-3">
            <label for="avatar" class="form-label">{{ __('Avatar') }}</label>
            @if ($user->profile && $user->profile->avatar)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="Avatar" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                </div>
            @endif
            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            @error('avatar') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Bio -->
        <div class="mb-3">
            <label for="bio" class="form-label">{{ __('Bio') }}</label>
            <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', $user->profile?->bio) }}</textarea>
            @error('bio') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            <button class="btn btn-blue" type="submit">{{ __('Save Changes') }}</button>

            @if (session('status') === 'profile-updated')
                <p class="text-success small mb-0">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
