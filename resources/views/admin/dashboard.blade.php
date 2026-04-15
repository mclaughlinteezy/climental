<x-admin-layout pageTitle="Dashboard Overview">
    @php
        $statItems = [
            ['label' => 'Total Users', 'value' => $stats['total_users'], 'icon' => 'bi-people-fill', 'bg' => 'linear-gradient(135deg, #0ea5e9, #2563eb)'],
            ['label' => 'Total Events', 'value' => $stats['total_events'], 'icon' => 'bi-calendar-event-fill', 'bg' => 'linear-gradient(135deg, #10b981, #059669)'],
            ['label' => 'Organizations', 'value' => $stats['total_organizations'], 'icon' => 'bi-building', 'bg' => 'linear-gradient(135deg, #06b6d4, #0891b2)'],
            ['label' => 'Campaigns', 'value' => $stats['total_campaigns'], 'icon' => 'bi-tree-fill', 'bg' => 'linear-gradient(135deg, #84cc16, #16a34a)'],
            ['label' => 'Clubs', 'value' => $stats['total_clubs'], 'icon' => 'bi-diagram-3-fill', 'bg' => 'linear-gradient(135deg, #8b5cf6, #6366f1)'],
            ['label' => 'Reports', 'value' => $stats['total_reports'], 'icon' => 'bi-flag-fill', 'bg' => 'linear-gradient(135deg, #ef4444, #dc2626)'],
            ['label' => 'Forum Posts', 'value' => $stats['total_posts'], 'icon' => 'bi-chat-square-fill', 'bg' => 'linear-gradient(135deg, #475569, #1e293b)'],
            ['label' => "Today's Check-ins", 'value' => $stats['checkins_today'], 'icon' => 'bi-emoji-smile-fill', 'bg' => 'linear-gradient(135deg, #f59e0b, #d97706)'],
            ['label' => 'Map Places', 'value' => $stats['total_places'], 'icon' => 'bi-pin-map-fill', 'bg' => 'linear-gradient(135deg, #14b8a6, #0f766e)'],
            ['label' => 'Recycling Points', 'value' => $stats['total_recycling_points'], 'icon' => 'bi-recycle', 'bg' => 'linear-gradient(135deg, #22c55e, #15803d)'],
            ['label' => 'System Settings', 'value' => $stats['total_settings'], 'icon' => 'bi-sliders', 'bg' => 'linear-gradient(135deg, #f97316, #ea580c)'],
        ];
    @endphp

    <div class="row g-4 mb-4">
        @foreach($statItems as $stat)
            <div class="col-md-6 col-xl-3">
                <article class="admin-stat" style="background: {{ $stat['bg'] }};">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <div class="small text-uppercase fw-semibold opacity-75 mb-2" style="letter-spacing: 0.08em;">{{ $stat['label'] }}</div>
                            <div class="display-6 fw-bold">{{ $stat['value'] }}</div>
                        </div>
                        <div class="admin-stat-icon"><i class="bi {{ $stat['icon'] }}"></i></div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-4">
            <section class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="admin-kicker">Recent Signups</div>
                        <h3 class="h5 mb-0">New users</h3>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">View all</a>
                </div>

                <div class="d-grid gap-3">
                    @foreach($recentUsers as $user)
                        <div class="admin-soft p-3 d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </div>
                            <span class="badge rounded-pill {{ $user->role === 'admin' ? 'bg-danger' : 'bg-secondary' }}">{{ $user->role }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="col-xl-4">
            <section class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="admin-kicker">Calendar</div>
                        <h3 class="h5 mb-0">Upcoming events</h3>
                    </div>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Manage</a>
                </div>

                <div class="d-grid gap-3">
                    @foreach($upcomingEvents as $event)
                        <div class="admin-soft p-3">
                            <div class="fw-semibold text-dark">{{ $event->title }}</div>
                            <div class="d-flex justify-content-between mt-2 small text-muted">
                                <span>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                                <span>{{ $event->registrations_count }} attending</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="col-xl-4">
            <section class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="admin-kicker">Moderation</div>
                        <h3 class="h5 mb-0">Pending reports</h3>
                    </div>
                    <a href="{{ route('community.moderate') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">Review</a>
                </div>

                @if($pendingReports->count() === 0)
                    <div class="admin-soft p-4 text-center">
                        <i class="bi bi-check-circle-fill text-success fs-2 d-block mb-2"></i>
                        <div class="fw-semibold text-dark">No pending reports</div>
                        <div class="small text-muted">The moderation queue is currently clear.</div>
                    </div>
                @else
                    <div class="d-grid gap-3">
                        @foreach($pendingReports as $report)
                            <div class="admin-soft p-3">
                                <div class="fw-semibold text-dark small">Reported by {{ $report->user->name }}</div>
                                <div class="small text-muted mt-1">{{ Str::limit($report->reason, 90) }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-admin-layout>
