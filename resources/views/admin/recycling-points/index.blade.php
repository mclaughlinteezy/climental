<x-admin-layout pageTitle="Recycling Points">
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <div>
                <div class="admin-kicker">Climate Infrastructure</div>
                <h3 class="h4 mb-1">Recycling points</h3>
                <p class="text-muted mb-0">Manage the recycling stations shown across the climate and map experiences.</p>
            </div>
            <a href="{{ route('admin.recycling-points.create') }}" class="btn btn-admin-success"><i class="bi bi-plus-circle me-1"></i> Add Recycling Point</a>
        </div>

        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Materials</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recyclingPoints as $point)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $point->name }}</td>
                            <td class="small text-muted">{{ $point->location ?? '-' }}</td>
                            <td><span class="badge bg-success rounded-pill">{{ $point->type }}</span></td>
                            <td class="small text-muted">{{ $point->accepted_materials ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.recycling-points.edit', $point) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">Edit</a>
                                <form action="{{ route('admin.recycling-points.destroy', $point) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete {{ $point->name }}?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-3">{{ $recyclingPoints->links() }}</div>
    </div>
</x-admin-layout>
