<x-app-layout>
    <section class="rewards-hero rounded-5 p-4 p-lg-5 mb-4 overflow-hidden position-relative">
        <div class="row align-items-center g-4 position-relative">
            <div class="col-lg-7">
                <span class="badge bg-white text-warning rounded-pill px-3 py-2 mb-3">Rewards & Leaderboard</span>
                <h2 class="display-6 text-white mb-2">Progress should feel visible, motivating, and earned.</h2>
                <p class="text-white-50 lead mb-0">Track your points, protect your streak, and see how your actions compare across the Climental community.</p>
            </div>
            <div class="col-lg-5">
                <div class="reward-glass rounded-5 p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="reward-mini rounded-4 p-3 text-center">
                                <div class="small text-white-50">Points</div>
                                <div class="display-6 text-white fw-bold">{{ $profile->points }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="reward-mini rounded-4 p-3 text-center">
                                <div class="small text-white-50">Streak</div>
                                <div class="display-6 text-white fw-bold">{{ $profile->streak }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card rounded-5 p-4 mb-4">
                <div class="section-header">
                    <div>
                        <span class="section-kicker">Your Progress</span>
                        <h3 class="h4 mb-1">Momentum snapshot</h3>
                        <p class="text-muted mb-0">A quick look at the habits and actions shaping your reward journey.</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="soft-panel p-4 h-100">
                            <div class="icon-pill bg-warning-subtle text-warning mb-3"><i class="bi bi-star-fill"></i></div>
                            <div class="small text-uppercase text-muted fw-semibold">Total Points</div>
                            <div class="display-6 fw-bold">{{ $profile->points }}</div>
                            <p class="text-muted small mb-0">Earned from club participation, events, and mental wellbeing actions.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="soft-panel p-4 h-100">
                            <div class="icon-pill bg-danger-subtle text-danger mb-3"><i class="bi bi-fire"></i></div>
                            <div class="small text-uppercase text-muted fw-semibold">Day Streak</div>
                            <div class="display-6 fw-bold">{{ $profile->streak }}</div>
                            <p class="text-muted small mb-0">Consistency compounds. Small actions repeated over time matter.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="surface-card rounded-5 p-4">
                <div class="section-header">
                    <div>
                        <span class="section-kicker">Badges</span>
                        <h3 class="h4 mb-1">Earned achievements</h3>
                        <p class="text-muted mb-0">Milestones that reflect the kind of impact and consistency you are building.</p>
                    </div>
                </div>

                @if(count($badges) > 0)
                    <div class="row g-4">
                        @foreach($badges as $badge)
                            <div class="col-md-6">
                                <article class="badge-surface badge-theme-{{ $badge['theme'] ?? 'default' }} rounded-5 p-4 h-100 position-relative overflow-hidden">
                                    <div class="badge-shine"></div>
                                    <div class="d-flex justify-content-between align-items-start gap-3 position-relative">
                                        <span class="badge-ribbon rounded-pill px-3 py-2">{{ $badge['label'] ?? 'Achievement' }}</span>
                                        <div class="badge-medallion">
                                            <div class="badge-medallion-core">
                                                <i class="bi {{ $badge['icon'] }}"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <h4 class="h4 mb-2">{{ $badge['name'] }}</h4>
                                        <p class="badge-description mb-4">{{ $badge['description'] }}</p>
                                        <div class="badge-footer">
                                            <span class="badge-footer-chip rounded-pill px-3 py-2">Unlocked</span>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state text-center p-5">
                        <i class="bi bi-trophy fs-1 text-warning"></i>
                        <h3 class="h4 mt-3">No badges yet</h3>
                        <p class="text-muted mb-0">Keep checking in, joining clubs, and showing up to unlock your first achievements.</p>
                    </div>
                @endif
            </section>
        </div>

        <div class="col-xl-4">
            <section class="surface-card rounded-5 p-4">
                <div class="section-header">
                    <div>
                        <span class="section-kicker">Leaderboard</span>
                        <h3 class="h4 mb-1">Top performers</h3>
                        <p class="text-muted mb-0">A live snapshot of community momentum across the platform.</p>
                    </div>
                </div>

                <div class="d-grid gap-3">
                    @foreach($leaderboard as $idx => $rank)
                        <article class="leader-row rounded-4 p-3 {{ $rank->user->id === auth()->id() ? 'leader-row-active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="leader-rank">#{{ $idx + 1 }}</div>
                                    <div>
                                        <div class="fw-bold">{{ $rank->user->name }} @if($rank->user->id === auth()->id())<span class="small text-primary">(You)</span>@endif</div>
                                        <div class="small text-muted">Community participant</div>
                                    </div>
                                </div>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">{{ $rank->points }} pts</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>
    </div>

    <style>
        .rewards-hero {
            background:
                radial-gradient(circle at top right, rgba(253, 224, 71, 0.22), transparent 28%),
                radial-gradient(circle at bottom left, rgba(249, 115, 22, 0.18), transparent 26%),
                linear-gradient(135deg, #7c2d12 0%, #b45309 45%, #f59e0b 100%);
            box-shadow: 0 30px 70px rgba(146, 64, 14, 0.2);
        }

        .reward-glass,
        .reward-mini {
            background: rgba(255, 255, 255, 0.11);
            border: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(14px);
        }

        .badge-surface {
            min-height: 290px;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 22px 46px rgba(15, 23, 42, 0.08);
            transition: transform 0.24s ease, box-shadow 0.24s ease;
        }

        .badge-surface:hover {
            transform: translateY(-6px) rotate(-0.4deg);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.12);
        }

        .badge-theme-eco {
            background:
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.2), transparent 28%),
                linear-gradient(180deg, #f3fbf6 0%, #ffffff 100%);
        }

        .badge-theme-wellness {
            background:
                radial-gradient(circle at top right, rgba(244, 114, 182, 0.18), transparent 28%),
                linear-gradient(180deg, #fff4f7 0%, #ffffff 100%);
        }

        .badge-ribbon {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.14);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #475569;
            backdrop-filter: blur(8px);
        }

        .badge-medallion {
            width: 104px;
            height: 104px;
            border-radius: 30px;
            padding: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.55));
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9), 0 18px 36px rgba(15, 23, 42, 0.08);
        }

        .badge-theme-eco .badge-medallion {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        }

        .badge-theme-wellness .badge-medallion {
            background: linear-gradient(135deg, #ffe4ec, #fecdd3);
        }

        .badge-medallion-core {
            width: 100%;
            height: 100%;
            border-radius: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.3rem;
            color: #0f172a;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.75);
        }

        .badge-theme-eco .badge-medallion-core {
            color: #0f766e;
        }

        .badge-theme-wellness .badge-medallion-core {
            color: #db2777;
        }

        .badge-description {
            color: #475569;
            max-width: 28ch;
            font-size: 1rem;
            line-height: 1.65;
        }

        .badge-footer-chip {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: #334155;
            font-weight: 700;
        }

        .badge-shine {
            position: absolute;
            inset: -10% auto auto -12%;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.48);
            filter: blur(10px);
            opacity: 0.7;
        }

        .leader-row {
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .leader-row-active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(16, 185, 129, 0.08));
            border-color: rgba(59, 130, 246, 0.2);
        }

        .leader-rank {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            font-weight: 700;
            color: #64748b;
        }
    </style>
</x-app-layout>
