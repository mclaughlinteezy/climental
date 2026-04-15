<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="row mt-4">
        <div class="col-md-12 mb-4">
            <!-- Profile Info Form -->
            <div class="card card-custom p-4 mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Profile Password Form -->
            <div class="card card-custom p-4 mb-4">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete User Form -->
            <div class="card card-custom p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
