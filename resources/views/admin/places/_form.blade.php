<div class="mb-3">
    <label for="name" class="form-label admin-label">Place Name</label>
    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $place->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="category" class="form-label admin-label">Category</label>
    <input type="text" id="category" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $place->category ?? '') }}" placeholder="clinic, climate, library, hub" required>
    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label admin-label">Description</label>
    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $place->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="latitude" class="form-label admin-label">Latitude</label>
        <input type="number" step="0.00000001" id="latitude" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $place->latitude ?? '') }}" required>
        @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="longitude" class="form-label admin-label">Longitude</label>
        <input type="number" step="0.00000001" id="longitude" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $place->longitude ?? '') }}" required>
        @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
