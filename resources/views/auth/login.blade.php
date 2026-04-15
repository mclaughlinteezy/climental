<x-guest-layout>
    <h2 class="auth-heading">Sign In</h2>
    <p class="auth-subheading">Access your dashboard to continue your wellness journey.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label font-heading text-secondary fw-semibold">Email</label>
            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label font-heading text-secondary fw-semibold">Password</label>
            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password"
                name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label text-secondary small fw-semibold">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-success text-decoration-none small fw-bold" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-auth btn-green btn-lg shadow-sm">
            Sign In to Climental
        </button>

        <div class="text-center mt-4">
            <p class="text-secondary small">Don't have an account? <a href="{{ route('register') }}"
                    class="text-success fw-bold text-decoration-none underline">Sign up</a></p>
        </div>
    </form>
</x-guest-layout>