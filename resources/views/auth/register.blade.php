<x-guest-layout>
    <h2 class="auth-heading">Join Climental</h2>
    <p class="auth-subheading">Start your journey toward mindfulness and sustainability today.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="form-label font-heading text-secondary fw-semibold">Full Name</label>
            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label font-heading text-secondary fw-semibold">Email Address</label>
            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="john@example.com">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="row mb-4">
            <div class="col">
                <label for="password" class="form-label font-heading text-secondary fw-semibold">Password</label>
                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col">
                <label for="password_confirmation" class="form-label font-heading text-secondary fw-semibold">Confirm</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="btn btn-auth btn-green btn-lg shadow-sm">
            Create Account
        </button>

        <div class="text-center mt-4">
            <p class="text-secondary small">Already have an account? <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Sign in here</a></p>
        </div>
    </form>
</x-guest-layout>
