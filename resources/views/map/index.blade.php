<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <section class="surface-card rounded-5 p-4 p-lg-5 mb-4 map-hero">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="section-kicker">{{ $mapConfig['title'] }}</span>
                <h2 class="display-6 mb-2">Navigate support, sustainability, and learning spaces with confidence.</h2>
                <p class="text-muted lead mb-0">Filter the map to find clinics, climate resources, libraries, and community hubs around Masvingo and campus.</p>
            </div>
            <div class="col-lg-4">
                <form action="{{ route('map.index') }}" method="GET" class="d-grid gap-2">
                    <div class="chip-row justify-content-lg-end">
                        <button type="submit" name="category" value="all" class="btn {{ $category === 'all' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">All</button>
                        <button type="submit" name="category" value="clinic" class="btn {{ $category === 'clinic' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Clinics</button>
                        <button type="submit" name="category" value="climate" class="btn {{ $category === 'climate' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Climate</button>
                        <button type="submit" name="category" value="library" class="btn {{ $category === 'library' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Libraries</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="surface-card rounded-5 p-3 p-lg-4 mb-4 overflow-hidden">
        <div id="map" style="height: 560px; width: 100%; border-radius: 26px;"></div>
    </section>

    <section>
        <div class="section-header">
            <div>
                <span class="section-kicker">Resource Registry</span>
                <h3 class="h4 mb-1">Places currently on the map</h3>
                <p class="text-muted mb-0">Use the spotlight action to jump directly to a resource marker.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($places as $place)
                <div class="col-md-6 col-xl-4">
                    <article class="surface-card rounded-5 p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div>
                                <h4 class="h5 mb-1">{{ $place->name }}</h4>
                                <div class="small text-muted">{{ $place->description ?? 'No detailed description available.' }}</div>
                            </div>
                            @php
                                $badgeClass = match($place->category) {
                                    'clinic', 'crisis_line' => 'bg-info-subtle text-info',
                                    'recycling_point', 'climate' => 'bg-success-subtle text-success',
                                    default => 'bg-secondary-subtle text-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">{{ ucfirst(str_replace('_', ' ', $place->category)) }}</span>
                        </div>

                        <div class="soft-panel p-3 mb-3">
                            <div class="small text-muted">
                                <i class="bi bi-geo-alt me-2 text-danger"></i>{{ number_format($place->latitude, 4) }}, {{ number_format($place->longitude, 4) }}
                            </div>
                        </div>

                        <button class="btn btn-outline-success rounded-pill px-4" onclick="focusMap({{ $place->latitude }}, {{ $place->longitude }}, '{{ addslashes($place->name) }}')">
                            Spotlight on map
                        </button>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center p-5">
                        <i class="bi bi-search fs-1 text-muted"></i>
                        <h3 class="h4 mt-3">No resources found</h3>
                        <p class="text-muted mb-0">Try changing the filter to reveal more places around Masvingo.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <script>
        var defaultCenter = [{{ $mapConfig['default_latitude'] }}, {{ $mapConfig['default_longitude'] }}];
        var map = L.map('map').setView(defaultCenter, {{ $mapConfig['default_zoom'] }});

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var locations = [
            @foreach($places as $place)
            {
                name: "{{ $place->name }}",
                lat: {{ $place->latitude }},
                lng: {{ $place->longitude }},
                cat: "{{ $place->category }}",
                desc: "{{ addslashes($place->description ?? '') }}"
            },
            @endforeach
        ];

        var markers = [];

        locations.forEach(function(loc) {
            var marker = L.marker([loc.lat, loc.lng]).addTo(map);
            var popupContent = `
                <div class="p-1">
                    <strong class="text-success">${loc.name}</strong><br>
                    <small class="text-muted">${loc.cat.toUpperCase()}</small>
                    <hr class="my-2">
                    <p class="mb-0 small">${loc.desc}</p>
                </div>
            `;
            marker.bindPopup(popupContent);
            markers.push({marker: marker, lat: loc.lat, lng: loc.lng});
        });

        function focusMap(lat, lng, name) {
            map.setView([lat, lng], 16);
            markers.forEach(function(m) {
                if (m.lat === lat && m.lng === lng) {
                    m.marker.openPopup();
                }
            });
            document.getElementById('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>

    <style>
        .map-hero {
            background:
                radial-gradient(circle at top right, rgba(239, 68, 68, 0.08), transparent 24%),
                radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.1), transparent 25%),
                rgba(255, 255, 255, 0.92);
        }
    </style>
</x-app-layout>
