<x-admin-layout pageTitle="Events Management">
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <div>
                <div class="admin-kicker">Programming</div>
                <h3 class="h4 mb-1">All events</h3>
                <p class="text-muted mb-0">Create, edit, and monitor campus events across wellbeing and climate action.</p>
            </div>
            <a href="{{ route('admin.events.create') }}" class="btn btn-admin-success"><i class="bi bi-plus-circle me-1"></i> Add Event</a>
        </div>

        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Points</th>
                        <th>RSVPs</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $event->title }}</td>
                            <td>
                                <span class="badge {{ $event->category === 'climate' ? 'bg-success' : ($event->category === 'mental_health' ? 'bg-info text-dark' : 'bg-primary') }}">
                                    {{ str_replace('_', ' ', ucfirst($event->category)) }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                            <td><span class="badge bg-warning text-dark rounded-pill">+{{ $event->points_reward }} pts</span></td>
                            <td class="small text-muted">{{ $event->registrations_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">Edit</a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete this event?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-3">{{ $events->links() }}</div>
    </div>
</x-admin-layout>
