<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/climental-logo.png') }}" type="image/png">

    <title>{{ config('app.name', 'CLIMENTAL') }} - Wellbeing Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --climental-emerald: #10b981;
            --climental-emerald-dark: #047857;
            --climental-sky: #0ea5e9;
            --climental-slate: #eef5f3;
            --climental-ice: #f8fafc;
            --climental-dark: #0f172a;
            --climental-green: #2ecc71;
            --climental-border: rgba(15, 23, 42, 0.07);
            --sidebar-width: 286px;
            --shell-shadow: 0 24px 64px rgba(15, 23, 42, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(16, 185, 129, 0.09), transparent 24%),
                radial-gradient(circle at bottom right, rgba(14, 165, 233, 0.08), transparent 22%),
                linear-gradient(180deg, #f8fbfa 0%, #edf5f2 100%);
            font-family: 'Inter', sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--climental-dark);
            letter-spacing: -0.02em;
        }

        a {
            text-decoration: none;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(247, 251, 249, 0.98) 100%);
            border-right: 1px solid rgba(148, 163, 184, 0.16);
            padding: 2rem 1.4rem;
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(20px);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem 2.5rem 3rem;
            min-height: 100vh;
        }

        .page-shell {
            max-width: 1440px;
            margin: 0 auto;
        }

        .sidebar-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 2rem;
            color: var(--climental-dark);
            font-family: 'Outfit', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .sidebar-brand-mark {
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: linear-gradient(135deg, #10b981, #0f766e);
            color: #fff;
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.22);
        }

        .nav-category {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #94a3b8;
            margin-bottom: 0.85rem;
            margin-top: 1.65rem;
            font-weight: 700;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            border-radius: 16px;
            color: #475569;
            font-weight: 600;
            margin-bottom: 0.45rem;
            transition: all 0.22s ease;
        }

        .nav-link-custom i {
            font-size: 1.15rem;
            margin-right: 0.95rem;
            opacity: 0.82;
        }

        .nav-link-custom:hover {
            background-color: #f1f8f5;
            color: var(--climental-emerald-dark);
            transform: translateX(4px);
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.14), rgba(14, 165, 233, 0.1));
            color: var(--climental-emerald-dark);
            box-shadow: inset 0 0 0 1px rgba(16, 185, 129, 0.12);
        }

        .nav-link-custom.active i {
            opacity: 1;
        }

        .card-premium,
        .surface-card {
            border: 1px solid var(--climental-border);
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: var(--shell-shadow);
            transition: transform 0.24s ease, box-shadow 0.24s ease;
        }

        .card-premium {
            padding: 1.5rem;
        }

        .card-premium:hover,
        .surface-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 70px rgba(15, 23, 42, 0.11);
        }

        .soft-panel {
            background: linear-gradient(180deg, rgba(248, 250, 252, 0.95), rgba(255, 255, 255, 0.95));
            border: 1px solid rgba(148, 163, 184, 0.14);
            border-radius: 24px;
        }

        .btn-premium {
            border-radius: 999px;
            padding: 0.78rem 1.45rem;
            font-weight: 700;
            transition: all 0.24s ease;
        }

        .btn-emerald,
        .btn-green {
            background: linear-gradient(135deg, var(--climental-emerald), #059669);
            color: #fff;
            border: none;
            box-shadow: 0 14px 28px rgba(16, 185, 129, 0.18);
        }

        .btn-emerald:hover,
        .btn-green:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 18px 30px rgba(16, 185, 129, 0.24);
        }

        .btn-blue {
            background: linear-gradient(135deg, var(--climental-sky), #0369a1);
            color: white;
            border: none;
            box-shadow: 0 14px 28px rgba(14, 165, 233, 0.16);
        }

        .btn-blue:hover {
            color: white;
            transform: translateY(-2px);
        }

        .stat-icon,
        .icon-pill {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .page-intro {
            max-width: 720px;
        }

        .page-kicker {
            display: inline-block;
            margin-bottom: 0.35rem;
            color: var(--climental-emerald-dark);
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .page-title {
            margin-bottom: 0.35rem;
            font-size: clamp(1.65rem, 2vw, 2.15rem);
        }

        .page-subtitle {
            margin-bottom: 0;
            color: #64748b;
        }

        .user-pill {
            padding: 0.55rem 0.7rem 0.55rem 1rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 999px;
            display: flex;
            align-items: center;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.07);
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: inherit;
        }

        .user-pill:hover {
            background: #ffffff;
        }

        .alert {
            border-radius: 22px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 1rem;
            margin-bottom: 1.1rem;
            flex-wrap: wrap;
        }

        .section-kicker {
            display: inline-block;
            margin-bottom: 0.4rem;
            font-size: 0.74rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--climental-emerald-dark);
        }

        .empty-state {
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid var(--climental-border);
            box-shadow: var(--shell-shadow);
        }

        .chip-row {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .no-arrow::after {
            display: none !important;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1.25rem;
            }

            .top-header {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <span class="sidebar-brand-mark"><i class="bi bi-flower1"></i></span>
            <span>CLIMENTAL</span>
        </a>

        <div class="nav-category">Main Experience</div>
        <nav>
            <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Home Base
            </a>

            <div class="nav-category">Self Care</div>
            <a href="{{ route('mental-health.index') }}" class="nav-link-custom {{ request()->routeIs('mental-health.*') ? 'active' : '' }}">
                <i class="bi bi-heart-pulse-fill"></i> Mental Health
            </a>
            <a href="{{ route('gamification.index') }}" class="nav-link-custom {{ request()->routeIs('gamification.*') ? 'active' : '' }}">
                <i class="bi bi-trophy-fill"></i> My Rewards
            </a>

            <div class="nav-category">Collective Impact</div>
            <a href="{{ route('climate.index') }}" class="nav-link-custom {{ request()->routeIs('climate.*') ? 'active' : '' }}">
                <i class="bi bi-tree-fill"></i> Climate Action
            </a>
            <a href="{{ route('events.index') }}" class="nav-link-custom {{ request()->routeIs('events.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event-fill"></i> University Events
            </a>
            <a href="{{ route('community.index') }}" class="nav-link-custom {{ request()->routeIs('community.*') ? 'active' : '' }}">
                <i class="bi bi-chat-heart-fill"></i> Peace Forum
            </a>

            <div class="nav-category">Navigation</div>
            <a href="{{ route('map.index') }}" class="nav-link-custom {{ request()->routeIs('map.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill"></i> Nearby Map
            </a>

            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="nav-category">Management</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link-custom">
                    <i class="bi bi-gear-wide-connected text-warning"></i> Admin Panel
                </a>
            @endif

            <div class="mt-4 pt-2">
                <div class="soft-panel p-3">
                    <h6 class="text-danger fw-bold small mb-2"><i class="bi bi-exclamation-octagon-fill me-1"></i> Urgent Help?</h6>
                    <p class="small text-muted mb-3">If things feel overwhelming right now, tap below for immediate support options.</p>
                    <a href="{{ route('mental-health.emergency') }}" class="btn btn-danger btn-sm w-100 rounded-pill py-2 fw-bold">
                        Help Now
                    </a>
                </div>
            </div>
        </nav>

        <div class="mt-auto pt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link-custom border-0 bg-transparent w-100 text-start text-danger">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <div class="page-shell">
            <div class="top-header">
                <div class="page-intro">
                    <span class="page-kicker">Climental Platform</span>
                    <h1 class="page-title">@isset($pageTitle) {{ $pageTitle }} @else Well-being Hub @endisset</h1>
                    <p class="page-subtitle">{{ now()->format('l, F j, Y') }} · move gently, act boldly, and keep building your momentum.</p>
                </div>

                <div class="dropdown">
                    <button class="user-pill border-0 dropdown-toggle no-arrow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="me-2 text-end">
                            <div class="fw-bold small">{{ auth()->user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.72rem;">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                        <div class="stat-icon bg-light text-success shadow-sm">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> My Profile</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 text-info" href="{{ route('gamification.index') }}"><i class="bi bi-star me-2"></i> Reward History</a></li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item rounded-3 py-2 text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout System
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
            @endif

            @if(session('info'))
                <div class="alert alert-info border-0 shadow-sm mb-4">{{ session('info') }}</div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
