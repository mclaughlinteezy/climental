{{-- Reusable organization form partial --}}
<div class="mb-3">
    <label for="name" class="form-label admin-label">Organization Name</label>
    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $organization->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="type" class="form-label admin-label">Type</label>
    <select id="type" name="type" class="form-select @error('type') is-invalid @enderror">
        @foreach(['clinic' => 'Campus Clinic', 'crisis_line' => 'Crisis / Toll-Free Line', 'ngo' => 'Local NGO', 'campus' => 'Campus Service'] as $val => $label)
            <option value="{{ $val }}" {{ old('type', $organization->type ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="phone" class="form-label admin-label">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $organization->phone ?? '') }}" placeholder="+254-800-000-000">
        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="website" class="form-label admin-label">Website URL</label>
        <input type="url" id="website" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $organization->website ?? '') }}" placeholder="https://...">
        @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label admin-label">Description</label>
    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Brief description of services offered...">{{ old('description', $organization->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="latitude" class="form-label admin-label">Latitude</label>
        <input type="number" step="0.00000001" id="latitude" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $organization->latitude ?? '') }}" placeholder="-20.09880000">
        @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="longitude" class="form-label admin-label">Longitude</label>
        <input type="number" step="0.00000001" id="longitude" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $organization->longitude ?? '') }}" placeholder="30.73050000">
        @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
