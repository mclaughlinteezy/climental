<section>
    <header>
        <h4 class="text-dark">
            {{ __('Update Password') }}
        </h4>
        <p class="text-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input type="password" class="form-control" id="update_password_current_password" name="current_password" autocomplete="current-password">
            @error('current_password', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input type="password" class="form-control" id="update_password_password" name="password" autocomplete="new-password">
            @error('password', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            <button class="btn btn-blue" type="submit">{{ __('Save Password') }}</button>

            @if (session('status') === 'password-updated')
                <p class="text-success small mb-0">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
