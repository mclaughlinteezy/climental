<x-admin-layout pageTitle="Organizations">
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <div>
                <div class="admin-kicker">Resource Directory</div>
                <h3 class="h4 mb-1">Organizations and services</h3>
                <p class="text-muted mb-0">Manage the clinics, crisis lines, NGOs, and campus services available to users.</p>
            </div>
            <a href="{{ route('admin.organizations.create') }}" class="btn btn-admin-success"><i class="bi bi-plus-circle me-1"></i> Add Organization</a>
        </div>

        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>Website</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($organizations as $org)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $org->name }}</td>
                            <td>
                                <span class="badge
                                    {{ $org->type === 'clinic' ? 'bg-info text-dark' : '' }}
                                    {{ $org->type === 'crisis_line' ? 'bg-danger' : '' }}
                                    {{ $org->type === 'ngo' ? 'bg-success' : '' }}
                                    {{ $org->type === 'campus' ? 'bg-primary' : '' }}
                                ">{{ str_replace('_', ' ', ucfirst($org->type)) }}</span>
                            </td>
                            <td class="small text-muted">{{ $org->phone ?? '-' }}</td>
                            <td class="small">
                                @if($org->website)
                                    <a href="{{ $org->website }}" target="_blank" class="text-primary">Open link <i class="bi bi-box-arrow-up-right"></i></a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.organizations.edit', $org->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">Edit</a>
                                <form action="{{ route('admin.organizations.destroy', $org->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete {{ $org->name }}?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-3">{{ $organizations->links() }}</div>
    </div>
</x-admin-layout>
