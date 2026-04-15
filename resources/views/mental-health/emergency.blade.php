<x-app-layout>
    <section class="emergency-hero rounded-5 p-4 p-lg-5 mb-4 overflow-hidden position-relative">
        <div class="row align-items-center g-4 position-relative">
            <div class="col-lg-8">
                <span class="badge bg-white text-danger rounded-pill px-3 py-2 mb-3">Immediate Support</span>
                <h2 class="display-5 text-white mb-3">You are not alone, and support is available right now.</h2>
                <p class="text-white-50 lead mb-0">If you feel overwhelmed, unsafe, or in crisis, use one of the contacts below immediately and reach out to someone nearby you trust.</p>
            </div>
        </div>
    </section>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <section class="surface-card rounded-5 p-4 text-center h-100">
                <div class="icon-pill bg-danger-subtle text-danger mx-auto mb-3"><i class="bi bi-telephone-plus-fill"></i></div>
                <h3 class="h4 mb-2">GZU Campus Security</h3>
                <p class="text-muted mb-4">24/7 rapid response support if you are in immediate danger.</p>
                <a href="tel:+263392266611" class="btn btn-danger rounded-pill px-4 py-3 w-100">Call +263 39 2266611</a>
            </section>
        </div>
        <div class="col-md-6">
            <section class="surface-card rounded-5 p-4 text-center h-100">
                <div class="icon-pill bg-info-subtle text-info mx-auto mb-3"><i class="bi bi-chat-dots-fill"></i></div>
                <h3 class="h4 mb-2">Natasha Youth Line</h3>
                <p class="text-muted mb-4">Free counselling and emotional support when you need someone to talk to quickly.</p>
                <a href="tel:0800110022" class="btn btn-info text-white rounded-pill px-4 py-3 w-100">Call 0800 11 00 22</a>
            </section>
        </div>
    </div>

    <section class="surface-card rounded-5 p-4 p-lg-5 mb-4">
        <div class="section-header">
            <div>
                <span class="section-kicker">Clinics & Crisis Support</span>
                <h3 class="h4 mb-1">University and local resources</h3>
                <p class="text-muted mb-0">These services can support you confidentially and without judgment.</p>
            </div>
        </div>

        <div class="d-grid gap-3">
            @foreach($clinics as $clinic)
                <article class="soft-panel p-4">
                    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                        <div>
                            <h4 class="h5 mb-1">{{ $clinic->name }}</h4>
                            <p class="text-muted mb-1">{{ $clinic->description }}</p>
                            @if($clinic->phone)
                                <div class="small fw-semibold text-dark"><i class="bi bi-phone me-1"></i>{{ $clinic->phone }}</div>
                            @endif
                        </div>
                        @if($clinic->phone)
                            <a href="tel:{{ $clinic->phone }}" class="btn btn-outline-dark rounded-pill px-4">Dial Now</a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <div class="alert alert-light border-0 shadow-sm rounded-5 p-4 text-center mb-0">
        <i class="bi bi-shield-lock-fill text-success fs-3"></i>
        <p class="mt-2 mb-0 text-muted"><strong>Private & Confidential:</strong> Reaching out is a sign of strength. These resources are here to help you through difficult moments safely.</p>
    </div>

    <style>
        .emergency-hero {
            background:
                radial-gradient(circle at top right, rgba(251, 191, 36, 0.18), transparent 28%),
                radial-gradient(circle at bottom left, rgba(239, 68, 68, 0.2), transparent 28%),
                linear-gradient(135deg, #7f1d1d 0%, #b91c1c 45%, #ef4444 100%);
            box-shadow: 0 30px 70px rgba(127, 29, 29, 0.2);
        }
    </style>
</x-app-layout>
