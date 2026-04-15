<x-app-layout>
    @php
        $points = auth()->user()->profile->points ?? 0;
        $role = ucfirst(auth()->user()->role);
    @endphp

    @if(session('mood_tip'))
        <div class="modal fade" id="dashboardMoodTipModal" tabindex="-1" aria-labelledby="dashboardMoodTipModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-5 shadow-lg">
                    <div class="modal-body p-4 p-md-5 text-center">
                        <div class="display-4 mb-3">{{ session('mood_tip')['emoji'] }}</div>
                        <span class="badge text-bg-success-subtle text-success rounded-pill px-3 py-2 mb-3">Mood tip notification</span>
                        <h4 id="dashboardMoodTipModalLabel" class="mb-3">{{ session('mood_tip')['title'] }}</h4>
                        <p class="text-muted mb-4">{{ session('mood_tip')['tip'] }}</p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('mental-health.index') }}" class="btn btn-outline-primary rounded-pill px-4" data-bs-dismiss="modal">More support</a>
                            <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <section class="dashboard-hero rounded-5 p-4 p-lg-5 mb-4 overflow-hidden position-relative">
        <div class="row align-items-center g-4 position-relative">
            <div class="col-lg-7">
                <span class="badge hero-badge rounded-pill px-3 py-2 mb-3">{{ $role }} journey</span>
                <h2 class="display-6 text-white mb-3">A calmer mind and a greener campus can grow together.</h2>
                <p class="text-white-50 lead mb-4">
                    Track your wellbeing, build your points, join purposeful communities, and keep momentum across climate and mental health actions.
                </p>
                <div class="chip-row">
                    <a href="{{ route('mental-health.index') }}" class="btn btn-light btn-lg rounded-pill px-4">Check in</a>
                    <a href="{{ route('climate.index') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">Explore climate action</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="soft-glass rounded-5 p-4">
                    <div class="small text-uppercase text-white-50 fw-semibold mb-2">Current standing</div>
                    <div class="display-5 text-white fw-bold mb-3">{{ number_format($points) }}</div>
                    <div class="text-white-50 mb-4">Activity points earned through check-ins, clubs, and events.</div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hero-mini rounded-4 p-3">
                                <div class="small text-white-50">Mood rhythm</div>
                                <div class="h5 text-white mb-0">Positive</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-mini rounded-4 p-3">
                                <div class="small text-white-50">This week</div>
                                <div class="h5 text-white mb-0">2 events</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="surface-card rounded-5 p-4 h-100">
                <div class="icon-pill bg-success-subtle text-success mb-3"><i class="bi bi-stars"></i></div>
                <div class="small text-uppercase text-muted fw-semibold">Reward level</div>
                <h3 class="h4 mb-2">Eco-Champion</h3>
                <p class="text-muted mb-0">You are building a strong foundation through steady participation.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="surface-card rounded-5 p-4 h-100">
                <div class="icon-pill bg-info-subtle text-info mb-3"><i class="bi bi-emoji-smile-fill"></i></div>
                <div class="small text-uppercase text-muted fw-semibold">Mood average</div>
                <h3 class="h4 mb-2">Positive 4.2/5</h3>
                <p class="text-muted mb-0">Gentle daily check-ins help you notice your emotional patterns earlier.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="surface-card rounded-5 p-4 h-100">
                <div class="icon-pill bg-warning-subtle text-warning mb-3"><i class="bi bi-calendar-check-fill"></i></div>
                <div class="small text-uppercase text-muted fw-semibold">Upcoming focus</div>
                <h3 class="h4 mb-2">2 events this week</h3>
                <p class="text-muted mb-0">Small moments of participation can unlock momentum across the platform.</p>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-5">
            <section class="surface-card rounded-5 p-4 h-100">
                <div class="section-header">
                    <div>
                        <span class="section-kicker">Pulse Check</span>
                        <h3 class="h4 mb-1">How are you feeling today?</h3>
                        <p class="text-muted mb-0">Choose a mood and record your check-in to keep your wellness rhythm going.</p>
                    </div>
                </div>

                <form action="{{ route('mental-health.mood.store') }}" method="POST">
                    @csrf
                    <div class="mood-grid mb-4">
                        @foreach([1 => '😫', 2 => '😨', 3 => '🙂', 4 => '😄', 5 => '🤩'] as $moodValue => $emoji)
                            <label class="mood-tile">
                                <input type="radio" name="mood_score" value="{{ $moodValue }}" class="btn-check" id="mood{{ $moodValue }}" required>
                                <span class="mood-face" for="mood{{ $moodValue }}">{{ $emoji }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-emerald btn-premium w-100">Record Mood Check-in</button>
                </form>
            </section>
        </div>

        <div class="col-xl-7">
            <section class="surface-card rounded-5 p-4 h-100">
                <div class="section-header">
                    <div>
                        <span class="section-kicker">Fresh Reads</span>
                        <h3 class="h4 mb-1">Ideas to keep you moving</h3>
                        <p class="text-muted mb-0">Short reads and activities that connect sustainability with wellbeing.</p>
                    </div>
                    <a href="{{ route('climate.index') }}" class="btn btn-outline-success rounded-pill px-4">Open Climate Hub</a>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <article class="soft-panel p-4 h-100">
                            <span class="badge text-bg-light text-success border border-success-subtle rounded-pill px-3 py-2 mb-3">8 min read</span>
                            <h4 class="h5 mb-2">Drought resilience for agriculture</h4>
                            <p class="text-muted mb-0">A grounded look at sustainable farming responses that matter in the local context.</p>
                        </article>
                    </div>
                    <div class="col-md-6">
                        <article class="soft-panel p-4 h-100">
                            <span class="badge text-bg-light text-info border border-info-subtle rounded-pill px-3 py-2 mb-3">4 min read</span>
                            <h4 class="h5 mb-2">5 plastic-free campus hacks</h4>
                            <p class="text-muted mb-0">Simple adjustments that make your daily routine lighter on the environment.</p>
                        </article>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-12">
            <section class="surface-card rounded-5 p-4">
                <div class="section-header">
                    <div>
                        <span class="section-kicker">Upcoming Activities</span>
                        <h3 class="h4 mb-1">Good things to join next</h3>
                        <p class="text-muted mb-0">Choose an activity that supports your wellbeing, your campus, or both.</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-primary rounded-pill px-4">Explore all events</a>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <article class="soft-panel p-4 h-100">
                            <span class="badge bg-danger rounded-pill px-3 py-2 mb-3">+25 pts</span>
                            <div class="small text-muted mb-2">Mental Health · In 5 days</div>
                            <h4 class="h5 mb-3">Mindfulness & Meditation</h4>
                            <p class="text-muted small mb-4">A gentle guided session to reset and manage stress during busy periods.</p>
                            <a href="{{ route('events.index', ['category' => 'mental_health']) }}" class="btn btn-outline-success rounded-pill px-4">View event</a>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="soft-panel p-4 h-100">
                            <span class="badge bg-success rounded-pill px-3 py-2 mb-3">+50 pts</span>
                            <div class="small text-muted mb-2">Climate · In 10 days</div>
                            <h4 class="h5 mb-3">Campus Clean-up Drive</h4>
                            <p class="text-muted small mb-4">Join peers working together to care for shared spaces and reduce waste.</p>
                            <a href="{{ route('events.index', ['category' => 'climate']) }}" class="btn btn-outline-success rounded-pill px-4">View event</a>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="community-promo rounded-5 p-4 h-100">
                            <div class="icon-pill bg-white text-success mb-3"><i class="bi bi-chat-heart-fill"></i></div>
                            <h4 class="h5 mb-2 text-white">Build your legacy</h4>
                            <p class="text-white-50 mb-4">Find people who care about peace, support, and campus action just as much as you do.</p>
                            <a href="{{ route('community.index') }}" class="btn btn-light rounded-pill px-4">Browse forum</a>
                        </article>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <style>
        .dashboard-hero {
            background:
                radial-gradient(circle at top right, rgba(56, 189, 248, 0.22), transparent 28%),
                radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.26), transparent 30%),
                linear-gradient(135deg, #0f172a 0%, #134e4a 52%, #10b981 100%);
            box-shadow: 0 30px 70px rgba(15, 23, 42, 0.18);
        }

        .hero-badge,
        .hero-mini,
        .soft-glass {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);
        }

        .community-promo {
            background: linear-gradient(135deg, #0f766e, #10b981);
            box-shadow: 0 24px 52px rgba(16, 185, 129, 0.2);
        }

        .mood-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .mood-face {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 72px;
            border-radius: 24px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.18);
            font-size: 2rem;
            cursor: pointer;
            transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease;
        }

        .btn-check:checked + .mood-face {
            background: linear-gradient(135deg, #10b981, #0f766e);
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 18px 30px rgba(16, 185, 129, 0.2);
        }

        @media (max-width: 767.98px) {
            .mood-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
    </style>

    @if(session('mood_tip'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const moodTipModalElement = document.getElementById('dashboardMoodTipModal');

                if (moodTipModalElement) {
                    const moodTipModal = new bootstrap.Modal(moodTipModalElement);
                    moodTipModal.show();
                }
            });
        </script>
    @endif
</x-app-layout>
