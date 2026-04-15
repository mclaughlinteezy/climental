<x-admin-layout pageTitle="Map Places">
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <div>
                <div class="admin-kicker">Map Setup</div>
                <h3 class="h4 mb-1">Custom places</h3>
                <p class="text-muted mb-0">Manage the manually configured locations that appear in the map experience.</p>
            </div>
            <a href="{{ route('admin.places.create') }}" class="btn btn-admin-success"><i class="bi bi-plus-circle me-1"></i> Add Place</a>
        </div>

        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($places as $place)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $place->name }}</td>
                            <td><span class="badge bg-secondary rounded-pill">{{ $place->category }}</span></td>
                            <td class="small text-muted">{{ $place->latitude }}</td>
                            <td class="small text-muted">{{ $place->longitude }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">Edit</a>
                                <form action="{{ route('admin.places.destroy', $place) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete {{ $place->name }}?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-3">{{ $places->links() }}</div>
    </div>
</x-admin-layout>
