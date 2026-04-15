{{-- Reusable event form partial --}}
<div class="mb-3">
    <label for="title" class="form-label admin-label">Title</label>
    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $event->title ?? '') }}" required>
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label admin-label">Description</label>
    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $event->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="category" class="form-label admin-label">Category</label>
        <select id="category" name="category" class="form-select @error('category') is-invalid @enderror">
            <option value="mental_health" {{ old('category', $event->category ?? '') === 'mental_health' ? 'selected' : '' }}>Mental Health</option>
            <option value="climate" {{ old('category', $event->category ?? '') === 'climate' ? 'selected' : '' }}>Climate</option>
            <option value="mixed" {{ old('category', $event->category ?? '') === 'mixed' ? 'selected' : '' }}>Mixed</option>
        </select>
        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="points_reward" class="form-label admin-label">Points Reward</label>
        <input type="number" id="points_reward" name="points_reward" class="form-control @error('points_reward') is-invalid @enderror" value="{{ old('points_reward', $event->points_reward ?? 0) }}" min="0">
        @error('points_reward') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="event_date" class="form-label admin-label">Event Date & Time</label>
        <input type="datetime-local" id="event_date" name="event_date" class="form-control @error('event_date') is-invalid @enderror"
            value="{{ old('event_date', isset($event) ? \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') : '') }}" required>
        @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="location" class="form-label admin-label">Location</label>
        <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $event->location ?? '') }}" placeholder="e.g. University Hall, Online">
        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
