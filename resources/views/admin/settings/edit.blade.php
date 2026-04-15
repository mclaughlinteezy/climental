<x-admin-layout pageTitle="System Settings">
    <div class="row">
        <div class="col-xl-8">
            <section class="admin-card admin-form-card">
                <div class="admin-kicker">Platform Control</div>
                <h3 class="h4 mb-1">Global system settings</h3>
                <p class="text-muted mb-4">Control the platform name, default map setup, and community social feed behavior from one place.</p>

                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="platform_name" class="form-label admin-label">Platform Name</label>
                        <input type="text" id="platform_name" name="platform_name" class="form-control @error('platform_name') is-invalid @enderror" value="{{ old('platform_name', $settings['platform_name']) }}" required>
                        @error('platform_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="platform_tagline" class="form-label admin-label">Platform Tagline</label>
                        <input type="text" id="platform_tagline" name="platform_tagline" class="form-control @error('platform_tagline') is-invalid @enderror" value="{{ old('platform_tagline', $settings['platform_tagline']) }}">
                        @error('platform_tagline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="map_title" class="form-label admin-label">Map Title</label>
                        <input type="text" id="map_title" name="map_title" class="form-control @error('map_title') is-invalid @enderror" value="{{ old('map_title', $settings['map_title']) }}" required>
                        @error('map_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="map_default_latitude" class="form-label admin-label">Default Latitude</label>
                            <input type="number" step="0.00000001" id="map_default_latitude" name="map_default_latitude" class="form-control @error('map_default_latitude') is-invalid @enderror" value="{{ old('map_default_latitude', $settings['map_default_latitude']) }}" required>
                            @error('map_default_latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="map_default_longitude" class="form-label admin-label">Default Longitude</label>
                            <input type="number" step="0.00000001" id="map_default_longitude" name="map_default_longitude" class="form-control @error('map_default_longitude') is-invalid @enderror" value="{{ old('map_default_longitude', $settings['map_default_longitude']) }}" required>
                            @error('map_default_longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="map_default_zoom" class="form-label admin-label">Default Zoom</label>
                            <input type="number" id="map_default_zoom" name="map_default_zoom" class="form-control @error('map_default_zoom') is-invalid @enderror" value="{{ old('map_default_zoom', $settings['map_default_zoom']) }}" min="1" max="20" required>
                            @error('map_default_zoom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="admin-kicker">Community Feed</div>
                    <h4 class="h5 mb-3">Social media page settings</h4>

                    <div class="mb-3">
                        <label for="community_title" class="form-label admin-label">Community Title</label>
                        <input type="text" id="community_title" name="community_title" class="form-control @error('community_title') is-invalid @enderror" value="{{ old('community_title', $settings['community_title']) }}" required>
                        @error('community_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="community_intro" class="form-label admin-label">Community Intro</label>
                        <textarea id="community_intro" name="community_intro" class="form-control @error('community_intro') is-invalid @enderror" rows="3">{{ old('community_intro', $settings['community_intro']) }}</textarea>
                        @error('community_intro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="community_composer_placeholder" class="form-label admin-label">Composer Placeholder</label>
                        <input type="text" id="community_composer_placeholder" name="community_composer_placeholder" class="form-control @error('community_composer_placeholder') is-invalid @enderror" value="{{ old('community_composer_placeholder', $settings['community_composer_placeholder']) }}" required>
                        @error('community_composer_placeholder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="admin-soft p-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="community_enable_photos" name="community_enable_photos" value="1" {{ old('community_enable_photos', $settings['community_enable_photos']) === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="community_enable_photos">Enable photo uploads</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-soft p-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="community_enable_comments" name="community_enable_comments" value="1" {{ old('community_enable_comments', $settings['community_enable_comments']) === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="community_enable_comments">Enable comments</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-soft p-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="community_enable_likes" name="community_enable_likes" value="1" {{ old('community_enable_likes', $settings['community_enable_likes']) === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="community_enable_likes">Enable likes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-soft p-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="community_enable_reposts" name="community_enable_reposts" value="1" {{ old('community_enable_reposts', $settings['community_enable_reposts']) === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="community_enable_reposts">Enable reposts</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin-primary">Save Settings</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>
