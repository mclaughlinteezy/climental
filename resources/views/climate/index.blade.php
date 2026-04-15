<x-app-layout>
    @php
        $campaignCount = $campaigns->count();
        $clubCount = $clubs->count();
        $recyclingCount = $recyclingPoints->count();
        $articleCount = $articles->count();
    @endphp

    <div class="climate-hub py-2">
        <section class="climate-hero position-relative overflow-hidden rounded-5 p-4 p-lg-5 mb-4">
            <div class="row align-items-center g-4 position-relative">
                <div class="col-lg-7">
                    <span class="badge climate-badge px-3 py-2 rounded-pill mb-3">Climate Action Hub</span>
                    <h1 class="display-5 fw-bold text-white mb-3">Build a greener campus with visible impact.</h1>
                    <p class="lead text-white-50 mb-4">
                        Join environmental clubs, support active campaigns, learn practical climate solutions, and turn student energy into lasting change.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#environmental-clubs" class="btn btn-light btn-lg rounded-pill px-4">Join a Club</a>
                        <a href="#campaigns" class="btn btn-outline-light btn-lg rounded-pill px-4">Explore Campaigns</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="climate-hero-panel rounded-5 p-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="climate-orb">
                                <i class="bi bi-globe-americas"></i>
                            </div>
                            <div>
                                <div class="small text-uppercase text-white-50 fw-semibold">Momentum snapshot</div>
                                <div class="h4 text-white mb-0">Student-led environmental action</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="climate-mini-stat rounded-4 p-3">
                                    <div class="small text-white-50">Campaigns</div>
                                    <div class="h3 text-white mb-0">{{ $campaignCount }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="climate-mini-stat rounded-4 p-3">
                                    <div class="small text-white-50">Clubs</div>
                                    <div class="h3 text-white mb-0">{{ $clubCount }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="climate-mini-stat rounded-4 p-3">
                                    <div class="small text-white-50">Recycling points</div>
                                    <div class="h3 text-white mb-0">{{ $recyclingCount }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="climate-mini-stat rounded-4 p-3">
                                    <div class="small text-white-50">Fresh reads</div>
                                    <div class="h3 text-white mb-0">{{ $articleCount }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info border-0 rounded-4 shadow-sm mb-4">{{ session('info') }}</div>
        @endif

        <section class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="climate-stat-card rounded-5 p-4 h-100">
                    <div class="stat-icon-wrap bg-success-subtle text-success"><i class="bi bi-megaphone-fill"></i></div>
                    <div class="small text-uppercase text-muted fw-semibold mt-3">Active Campaigns</div>
                    <div class="display-6 fw-bold text-dark mb-1">{{ $campaignCount }}</div>
                    <p class="text-muted small mb-0">Visible projects giving students practical ways to participate.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="climate-stat-card rounded-5 p-4 h-100">
                    <div class="stat-icon-wrap bg-primary-subtle text-primary"><i class="bi bi-people-fill"></i></div>
                    <div class="small text-uppercase text-muted fw-semibold mt-3">Environmental Clubs</div>
                    <div class="display-6 fw-bold text-dark mb-1">{{ $clubCount }}</div>
                    <p class="text-muted small mb-0">Creative and action-focused groups helping campus culture shift.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="climate-stat-card rounded-5 p-4 h-100">
                    <div class="stat-icon-wrap bg-warning-subtle text-warning"><i class="bi bi-recycle"></i></div>
                    <div class="small text-uppercase text-muted fw-semibold mt-3">Recycling Points</div>
                    <div class="display-6 fw-bold text-dark mb-1">{{ $recyclingCount }}</div>
                    <p class="text-muted small mb-0">Places where everyday sustainable habits can become easier.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="climate-stat-card rounded-5 p-4 h-100">
                    <div class="stat-icon-wrap bg-info-subtle text-info"><i class="bi bi-journal-text"></i></div>
                    <div class="small text-uppercase text-muted fw-semibold mt-3">Climate Education</div>
                    <div class="display-6 fw-bold text-dark mb-1">{{ $articleCount }}</div>
                    <p class="text-muted small mb-0">Short reads that turn awareness into ideas and action.</p>
                </div>
            </div>
        </section>

        <section id="campaigns" class="mb-5">
            <div class="d-flex justify-content-between align-items-end mb-3 flex-wrap gap-3">
                <div>
                    <span class="section-kicker">Campaign Focus</span>
                    <h2 class="h3 mb-1">Active campaigns</h2>
                    <p class="text-muted mb-0">Track momentum and see where the next wave of student effort is heading.</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse($campaigns as $campaign)
                    @php
                        $goal = $campaign->goal ?? $campaign->goal_amount;
                        $progress = $campaign->current_progress ?? $campaign->current_amount ?? 0;
                        $percent = $goal ? min(100, round(($progress / $goal) * 100)) : 100;
                    @endphp
                    <div class="col-lg-4">
                        <article class="campaign-card rounded-5 p-4 h-100">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                                <div>
                                    <span class="badge text-bg-success-subtle text-success rounded-pill px-3 py-2 mb-3">Live campaign</span>
                                    <h3 class="h5 mb-2">{{ $campaign->title }}</h3>
                                    <p class="text-muted small mb-0">{{ Str::limit($campaign->description, 120) }}</p>
                                </div>
                                <div class="campaign-progress-ring" style="--progress: {{ $percent }};">
                                    <span>{{ $percent }}%</span>
                                </div>
                            </div>

                            <div class="campaign-progress-panel rounded-4 p-3 mb-3">
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Progress</span>
                                    <span>{{ $progress }} / {{ $goal ?? 'Open goal' }}</span>
                                </div>
                                <div class="progress rounded-pill" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="small text-muted">Campaigns like this help turn awareness into measurable campus action.</div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state rounded-5 p-5 text-center">
                            <i class="bi bi-cloud-sun fs-1 text-success"></i>
                            <h3 class="h5 mt-3">No active campaigns right now</h3>
                            <p class="text-muted mb-0">The next climate initiative will appear here as soon as it is launched.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <div class="row g-4 align-items-start">
            <div class="col-xl-8">
                <section class="mb-4">
                    <div class="d-flex justify-content-between align-items-end mb-3 flex-wrap gap-3">
                        <div>
                            <span class="section-kicker">Learn</span>
                            <h2 class="h3 mb-1">Climate education</h2>
                            <p class="text-muted mb-0">Quick reads with practical context for student climate action.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @forelse($articles as $article)
                            <div class="col-md-6">
                                <article class="education-card rounded-5 p-4 h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="badge text-bg-light text-success border border-success-subtle rounded-pill px-3 py-2">Climate education</span>
                                        <span class="small text-muted">{{ $article->reading_time ?? 5 }} min read</span>
                                    </div>
                                    <h3 class="h5 mb-3">{{ $article->title }}</h3>
                                    <p class="text-muted mb-4">{{ Str::limit($article->content, 155) }}</p>
                                    <div class="small text-muted fw-semibold">By {{ $article->author ?? 'Climental Team' }}</div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state rounded-5 p-5 text-center">
                                    <i class="bi bi-journal-x fs-1 text-primary"></i>
                                    <h3 class="h5 mt-3">No climate reads yet</h3>
                                    <p class="text-muted mb-0">Fresh educational content will show up here soon.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section>
                    <div class="d-flex justify-content-between align-items-end mb-3 flex-wrap gap-3">
                        <div>
                            <span class="section-kicker">Act Local</span>
                            <h2 class="h3 mb-1">Recycling points</h2>
                            <p class="text-muted mb-0">Simple, visible places to turn sustainability into everyday practice.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @forelse($recyclingPoints as $point)
                            <div class="col-md-6">
                                <article class="recycling-card rounded-5 p-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="recycling-icon mb-3"><i class="bi bi-geo-alt-fill"></i></div>
                                            <h3 class="h5 mb-2">{{ $point->name }}</h3>
                                            <p class="text-muted small mb-3">{{ $point->location ?? 'Campus collection point' }}</p>
                                        </div>
                                        <span class="badge text-bg-warning-subtle text-warning rounded-pill px-3 py-2">{{ ucfirst($point->type ?? 'mixed') }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <span class="small text-muted">
                                            Accepts: {{ $point->accepted_materials ?? 'Plastic, paper, cans, and mixed recyclables' }}
                                        </span>
                                        <a href="{{ route('map.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">View on map</a>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state rounded-5 p-5 text-center">
                                    <i class="bi bi-recycle fs-1 text-warning"></i>
                                    <h3 class="h5 mt-3">No recycling points listed</h3>
                                    <p class="text-muted mb-0">Add collection hubs to make climate action easier to navigate.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <div class="col-xl-4">
                <section id="environmental-clubs" class="club-panel rounded-5 p-4 sticky-xl-top">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <span class="section-kicker">Community</span>
                            <h2 class="h4 mb-1">Environmental clubs</h2>
                            <p class="text-muted mb-0">Join the groups shaping climate culture through action and creativity.</p>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        @forelse($clubs as $club)
                            <article class="club-card rounded-4 p-4">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                    <div>
                                        <h3 class="h5 mb-1">{{ $club->name }}</h3>
                                        <div class="small text-muted">{{ $club->members_count }} members</div>
                                    </div>
                                    <div class="club-icon">
                                        <i class="bi {{ $club->slug === 'green-voices' ? 'bi-mic-fill' : 'bi-tree-fill' }}"></i>
                                    </div>
                                </div>

                                <p class="text-muted small mb-3">{{ $club->description }}</p>
                                <div class="badge text-bg-light text-success border border-success-subtle rounded-pill px-3 py-2 mb-3">{{ $club->activities }}</div>

                                @if($club->members->contains(auth()->id()))
                                    <button class="btn btn-secondary rounded-pill px-4 w-100" disabled>Joined</button>
                                @else
                                    <form action="{{ route('climate.clubs.join', $club->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success rounded-pill px-4 w-100" type="submit">Join club</button>
                                    </form>
                                @endif
                            </article>
                        @empty
                            <div class="empty-state rounded-5 p-4 text-center">
                                <i class="bi bi-people fs-1 text-success"></i>
                                <h3 class="h6 mt-3">No clubs available yet</h3>
                                <p class="text-muted small mb-0">Clubs will appear here when they are ready for members.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>

    <style>
        .climate-hub {
            --climate-forest: #14532d;
            --climate-leaf: #16a34a;
            --climate-sun: #f59e0b;
            --climate-sky: #0f766e;
            --climate-mist: #f5f9f4;
        }

        .climate-hero {
            background:
                radial-gradient(circle at top right, rgba(253, 224, 71, 0.18), transparent 30%),
                radial-gradient(circle at bottom left, rgba(34, 197, 94, 0.28), transparent 38%),
                linear-gradient(135deg, #0f3d2e 0%, #14532d 42%, #1d7a46 100%);
            box-shadow: 0 30px 80px rgba(20, 83, 45, 0.22);
        }

        .climate-hero::before {
            content: "";
            position: absolute;
            inset: auto -10% -45% auto;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            filter: blur(6px);
        }

        .climate-badge {
            background: rgba(255, 255, 255, 0.12);
            color: #ecfdf5;
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .climate-hero-panel {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
        }

        .climate-orb,
        .stat-icon-wrap,
        .recycling-icon,
        .club-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            border-radius: 18px;
            font-size: 1.4rem;
        }

        .climate-orb {
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
        }

        .climate-mini-stat,
        .climate-stat-card,
        .campaign-card,
        .education-card,
        .recycling-card,
        .club-panel,
        .club-card,
        .empty-state {
            background: #fff;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        }

        .climate-mini-stat {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: none;
        }

        .climate-stat-card,
        .campaign-card,
        .education-card,
        .recycling-card,
        .club-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .climate-stat-card:hover,
        .campaign-card:hover,
        .education-card:hover,
        .recycling-card:hover,
        .club-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.1);
        }

        .section-kicker {
            display: inline-block;
            margin-bottom: 0.4rem;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--climate-leaf);
        }

        .campaign-progress-ring {
            --size: 72px;
            width: var(--size);
            height: var(--size);
            border-radius: 50%;
            background: conic-gradient(var(--climate-leaf) calc(var(--progress) * 1%), #e2e8f0 0);
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .campaign-progress-ring span {
            width: calc(var(--size) - 14px);
            height: calc(var(--size) - 14px);
            border-radius: 50%;
            background: #fff;
            display: grid;
            place-items: center;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--climate-forest);
        }

        .campaign-progress-panel {
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .club-panel {
            background:
                radial-gradient(circle at top right, rgba(34, 197, 94, 0.08), transparent 28%),
                #f8fbf8;
            top: 2rem;
        }

        .club-icon {
            background: #ecfdf5;
            color: var(--climate-leaf);
        }

        @media (max-width: 991.98px) {
            .climate-hero {
                padding: 2rem !important;
            }
        }
    </style>
</x-app-layout>
