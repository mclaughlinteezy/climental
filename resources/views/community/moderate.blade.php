<x-admin-layout pageTitle="Moderation Dashboard">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Back to Admin
        </a>
    </div>

    <section class="admin-card">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <div>
                <div class="admin-kicker">Safety Queue</div>
                <h3 class="h4 mb-1">Pending reports</h3>
                <p class="text-muted mb-0">Review flagged content, remove harmful posts, and clear reports that do not need further action.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th>Reported By</th>
                        <th>Item Details</th>
                        <th>Reason</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $report->user->name ?? 'Unknown' }}</td>
                            <td>
                                @if($report->reportable_type === 'App\Models\SupportPost')
                                    <span class="badge bg-primary rounded-pill px-3 py-2">Post #{{ $report->reportable_id }}</span>
                                @elseif($report->reportable_type === 'App\Models\SupportComment')
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Comment #{{ $report->reportable_id }}</span>
                                @else
                                    <span class="badge bg-dark rounded-pill px-3 py-2">{{ class_basename($report->reportable_type) }} #{{ $report->reportable_id }}</span>
                                @endif
                            </td>
                            <td class="text-muted small" style="max-width: 340px; white-space: pre-wrap;">{{ $report->reason }}</td>
                            <td class="small text-muted">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                @if($report->reportable_type === 'App\Models\SupportPost')
                                    <form method="POST" action="{{ route('community.posts.destroy', $report->reportable_id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 me-1" onclick="return confirm('Remove this post completely?');">
                                            Delete Content
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('reports.resolve', $report->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">Dismiss Report</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">No pending reports to moderate right now.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-admin-layout>
