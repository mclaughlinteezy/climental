<x-app-layout>
    <div class="row mt-4 g-4">
        <div class="col-lg-8">
            <div class="card card-premium border-0 h-30">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div>
                        <span class="badge text-bg-success-subtle text-success mb-3 px-3 py-2 rounded-pill">Daily
                            support</span>
                        <h2 class="h3 mb-2">Mental Health & Wellness</h2>
                        <p class="text-muted mb-0">Check in with yourself, learn something helpful, and reach support
                            quickly when you need it.</p>
                    </div>
                    <a href="{{ route('mental-health.groups.index') }}"
                        class="btn btn-outline-primary rounded-pill px-4">
                        Peer Support Groups
                    </a>
                </div>

                <div class="mt-4 p-4 rounded-4 bg-success-subtle border border-success-subtle">
                    <h5 class="text-success mb-3"><i class="bi bi-lightbulb me-2"></i>Daily Tip</h5>
                    <p class="mb-0 text-muted">
                        {{ $dailyTip->content ?? 'Take a deep breath and remind yourself that doing your best is always enough.' }}
                    </p>
                </div>
            </div>

            <div class="card card-premium border-0 mt-4">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div>
                        <span class="badge text-bg-info-subtle text-info mb-3 px-3 py-2 rounded-pill">Did you
                            know?</span>
                        <h4 class="mb-2">Mental health and climate are connected</h4>
                        <p class="text-muted mb-0">Small facts like these can help people understand why support,
                            community, and safe spaces matter.</p>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    @foreach($didYouKnowFacts as $fact)
                        <div class="col-md-4">
                            <div class="h-100 p-4 rounded-4 border bg-light">
                                <h6 class="fw-bold mb-2">{{ $fact['title'] }}</h6>
                                <p class="text-muted small mb-0">{{ $fact['content'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card card-premium border-0 mt-4" id="resource-directory">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
                    <div>
                        <h4 class="mb-2">Support Services Available</h4>
                        <p class="text-muted mb-0">Find campus clinics, toll-free support lines, and local organisations
                            you can contact.</p>
                    </div>
                    <a href="{{ route('mental-health.emergency') }}" class="btn btn-outline-danger rounded-pill px-4">
                        Emergency Help
                    </a>
                </div>

                <ul class="nav nav-tabs mb-3" id="resourceTabs" role="tablist">
                    @foreach(['clinic' => 'Campus Clinics', 'crisis_line' => 'Toll-Free Services', 'ngo' => 'Local NGOs'] as $type => $label)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $type }}-tab"
                                data-bs-toggle="tab" data-bs-target="#{{ $type }}-pane" type="button" role="tab"
                                aria-controls="{{ $type }}-pane" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $label }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="resourceTabsContent">
                    @foreach(['clinic', 'crisis_line', 'ngo'] as $type)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $type }}-pane"
                            role="tabpanel" aria-labelledby="{{ $type }}-tab" tabindex="0">
                            @if(isset($organizations[$type]) && $organizations[$type]->count() > 0)
                                <div class="row">
                                    @foreach($organizations[$type] as $org)
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100 border-0 bg-light p-3 rounded-4">
                                                <h6 class="text-primary mb-1">{{ $org->name }}</h6>
                                                <p class="small text-muted mb-3">{{ Str::limit($org->description, 90) }}</p>
                                                <div class="mt-auto d-flex gap-2 flex-wrap">
                                                    @if($org->phone)
                                                        <a href="tel:{{ $org->phone }}"
                                                            class="badge text-bg-secondary text-decoration-none p-2">{{ $org->phone }}</a>
                                                    @endif
                                                    @if($org->website)
                                                        <a href="{{ $org->website }}" target="_blank"
                                                            class="badge text-bg-primary text-decoration-none p-2">Website</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted py-3 mb-0">No {{ str_replace('_', ' ', $type) }} resources listed yet.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-premium border-0 mb-4">
                <div class="card-body p-0">
                    <h5 class="card-title text-primary mb-2"><i class="bi bi-emoji-smile me-2"></i>Daily Check-in</h5>

                    @if($checkedInToday)
                        <div class="alert alert-success rounded-4 mt-3 mb-0">
                            You've already checked in today. <strong>+10 points earned.</strong>
                        </div>
                    @else
                        <p class="small text-muted mb-3">Tap the emoji that feels closest to your mood and we will show a
                            message, a gentle prompt, and support options.</p>

                        <form action="{{ route('mental-health.mood.store') }}" method="POST" id="mood-checkin-form">
                            @csrf
                            <input type="hidden" name="emoji" id="selected-emoji" value="">

                            <div class="d-grid gap-2">
                                @foreach($moodGuidance as $mood)
                                    <button type="button"
                                        class="btn btn-outline-{{ $mood['button_style'] }} rounded-4 mood-option text-start p-3"
                                        data-mood='@json($mood)'>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="fs-2 lh-1">{{ $mood['emoji'] }}</span>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ ucfirst($mood['key']) }}</div>
                                                <div class="small text-muted">{{ $mood['title'] }}</div>
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>

                            <div class="rounded-4 border bg-light p-4 mt-3 d-none" id="mood-response-card">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="display-6 mb-0" id="response-emoji">🙂</span>
                                    <div>
                                        <h6 class="mb-1" id="response-title">Select a mood</h6>
                                        <p class="small text-muted mb-0">Your response will appear here.</p>
                                    </div>
                                </div>

                                <p class="mb-3 text-muted" id="response-message"></p>

                                <div class="p-3 rounded-4 bg-white border mb-3">
                                    <div class="fw-semibold small text-uppercase text-secondary mb-2">Reflection prompt
                                    </div>
                                    <p class="mb-0 small" id="response-prompt"></p>
                                </div>

                                <div class="p-3 rounded-4 bg-white border">
                                    <div class="fw-semibold mb-1" id="response-support-title"></div>
                                    <p class="small text-muted mb-3" id="response-support-text"></p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="#resource-directory"
                                            class="btn btn-sm btn-outline-primary rounded-pill">View services</a>
                                        <a href="{{ route('mental-health.groups.index') }}"
                                            class="btn btn-sm btn-outline-success rounded-pill">Talk to peers</a>
                                        <a href="{{ route('mental-health.emergency') }}"
                                            class="btn btn-sm btn-outline-danger rounded-pill">Urgent help</a>
                                    </div>
                                </div>
                            </div>

                            <label for="note" class="form-label mt-3">Private note</label>
                            <textarea name="note" id="note" class="form-control rounded-4" rows="3"
                                placeholder="You can write what is helping, what is heavy, or what support you may need.">{{ old('note') }}</textarea>

                            <button type="submit" class="btn btn-primary rounded-pill px-4 mt-3 w-100"
                                id="save-checkin-button" disabled>
                                Save my check-in
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="card card-premium border-0 mb-4">
                <div class="card-header bg-success text-white border-0 py-3 rounded-top-4">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Wellness Clubs</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($wellnessClubs as $club)
                            <li class="list-group-item py-3">
                                <h6 class="text-dark fw-bold">{{ $club->name }}</h6>
                                <p class="small text-muted mb-2">{{ $club->description }}</p>
                                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap mt-3">
                                    <span class="badge text-bg-light text-secondary">{{ $club->members_count }}
                                        Members</span>
                                    <span class="badge text-bg-success-subtle text-success">{{ $club->activities }}</span>
                                    @if($club->members->contains(auth()->id()))
                                        <button class="btn btn-sm btn-secondary" disabled>Joined</button>
                                    @else
                                        <form action="{{ route('mental-health.clubs.join', $club->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-green" type="submit">Join</button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card card-premium border-0">
                <h6 class="card-title mb-3">Recent Check-ins</h6>
                @if($moodHistory->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($moodHistory as $history)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 small">
                                <span class="text-muted">{{ $history->created_at->format('M d, Y') }}</span>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fs-5">{{ $history->emoji }}</span>
                                    @if($history->note)
                                        <span class="badge text-bg-light text-secondary" title="{{ $history->note }}">
                                            <i class="bi bi-card-text"></i> note
                                        </span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted small mb-0">No history found yet.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(!$checkedInToday)
                const moodButtons = document.querySelectorAll('.mood-option');
                const responseCard = document.getElementById('mood-response-card');
                const responseEmoji = document.getElementById('response-emoji');
                const responseTitle = document.getElementById('response-title');
                const responseMessage = document.getElementById('response-message');
                const responsePrompt = document.getElementById('response-prompt');
                const responseSupportTitle = document.getElementById('response-support-title');
                const responseSupportText = document.getElementById('response-support-text');
                const selectedEmojiInput = document.getElementById('selected-emoji');
                const saveButton = document.getElementById('save-checkin-button');

                moodButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        const mood = JSON.parse(button.dataset.mood);

                        moodButtons.forEach(function (item) {
                            item.classList.remove('active', 'shadow-sm');
                        });

                        button.classList.add('active', 'shadow-sm');
                        selectedEmojiInput.value = mood.emoji;

                        responseEmoji.textContent = mood.emoji;
                        responseTitle.textContent = mood.title;
                        responseMessage.textContent = mood.message;
                        responsePrompt.textContent = mood.prompt;
                        responseSupportTitle.textContent = mood.support_title;
                        responseSupportText.textContent = mood.support_text;

                        responseCard.classList.remove('d-none');
                        saveButton.disabled = false;
                    });
                });
            @endif
        });
    </script>
</x-app-layout>