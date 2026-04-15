<div class="mb-3">
    <label for="name" class="form-label admin-label">Name</label>
    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $recyclingPoint->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="location" class="form-label admin-label">Location</label>
        <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $recyclingPoint->location ?? '') }}">
        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="type" class="form-label admin-label">Type</label>
        <input type="text" id="type" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $recyclingPoint->type ?? '') }}" placeholder="plastic, mixed, glass" required>
        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label for="accepted_materials" class="form-label admin-label">Accepted Materials</label>
    <input type="text" id="accepted_materials" name="accepted_materials" class="form-control @error('accepted_materials') is-invalid @enderror" value="{{ old('accepted_materials', $recyclingPoint->accepted_materials ?? '') }}" placeholder="Plastic, cans, paper">
    @error('accepted_materials') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="latitude" class="form-label admin-label">Latitude</label>
        <input type="number" step="0.00000001" id="latitude" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $recyclingPoint->latitude ?? '') }}">
        @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="longitude" class="form-label admin-label">Longitude</label>
        <input type="number" step="0.00000001" id="longitude" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $recyclingPoint->longitude ?? '') }}">
        @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
