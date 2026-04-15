@props(['pageTitle' => 'Admin Panel'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ config('app.name', 'CLIMENTAL') }}</title>
    <link rel="icon" href="{{ asset('images/climental-logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --admin-navy: #0f172a;
            --admin-slate: #eaf0ef;
            --admin-panel: rgba(255, 255, 255, 0.92);
            --admin-border: rgba(15, 23, 42, 0.07);
            --admin-emerald: #10b981;
            --admin-cyan: #0891b2;
            --admin-amber: #f59e0b;
            --admin-red: #ef4444;
            --admin-sidebar-width: 292px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(16, 185, 129, 0.08), transparent 22%),
                radial-gradient(circle at bottom right, rgba(8, 145, 178, 0.07), transparent 24%),
                linear-gradient(180deg, #f7faf9 0%, var(--admin-slate) 100%);
            font-family: 'Inter', sans-serif;
            color: #334155;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
            color: var(--admin-navy);
            letter-spacing: -0.02em;
        }

        .admin-sidebar {
            width: var(--admin-sidebar-width);
            min-height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            background:
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.12), transparent 24%),
                linear-gradient(180deg, #08111f 0%, #0f172a 100%);
            color: white;
            padding: 1.7rem 1.25rem;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.4rem 0.5rem 1.25rem;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: white;
            text-decoration: none;
        }

        .admin-brand-mark {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #10b981, #06b6d4);
            box-shadow: 0 16px 32px rgba(16, 185, 129, 0.22);
        }

        .admin-brand-name {
            font-size: 1.22rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .admin-brand-sub {
            color: rgba(255, 255, 255, 0.62);
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-weight: 700;
        }

        .admin-category {
            margin: 1.5rem 0 0.75rem;
            padding: 0 0.55rem;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: rgba(255, 255, 255, 0.42);
            font-weight: 700;
        }

        .admin-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.92rem 1rem;
            color: rgba(255, 255, 255, 0.76);
            text-decoration: none;
            border-radius: 18px;
            font-weight: 600;
            transition: all 0.22s ease;
            margin-bottom: 0.35rem;
        }

        .admin-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .admin-link.active {
            color: white;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.22), rgba(8, 145, 178, 0.18));
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .admin-main {
            margin-left: var(--admin-sidebar-width);
            min-height: 100vh;
            padding: 1.8rem 2rem 2.5rem;
        }

        .admin-shell {
            max-width: 1500px;
            margin: 0 auto;
        }

        .admin-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.6rem;
        }

        .admin-topbar-card {
            background: var(--admin-panel);
            border: 1px solid var(--admin-border);
            border-radius: 28px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            padding: 1.3rem 1.4rem;
            flex: 1;
        }

        .admin-kicker {
            display: inline-block;
            margin-bottom: 0.35rem;
            color: var(--admin-cyan);
            font-size: 0.74rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .admin-page-title {
            font-size: clamp(1.5rem, 2vw, 2rem);
            margin-bottom: 0.25rem;
        }

        .admin-page-copy {
            margin: 0;
            color: #64748b;
        }

        .admin-user-chip {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            background: var(--admin-panel);
            border: 1px solid var(--admin-border);
            border-radius: 999px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.07);
            padding: 0.5rem 0.7rem 0.5rem 1rem;
        }

        .admin-user-avatar {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #10b981, #06b6d4);
            color: white;
            font-weight: 800;
        }

        .admin-surface,
        .admin-card {
            background: var(--admin-panel);
            border: 1px solid var(--admin-border);
            border-radius: 28px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        }

        .admin-card {
            padding: 1.35rem;
        }

        .admin-stat {
            padding: 1.35rem;
            border-radius: 24px;
            color: white;
            height: 100%;
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
        }

        .admin-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.16);
            font-size: 1.35rem;
        }

        .admin-table {
            --bs-table-bg: transparent;
            margin: 0;
        }

        .admin-table thead th {
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            font-weight: 800;
            border-bottom-color: rgba(148, 163, 184, 0.18);
            background: transparent;
            padding: 1rem 1.25rem;
        }

        .admin-table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom-color: rgba(148, 163, 184, 0.12);
            background: transparent;
        }

        .admin-table tbody tr:hover td {
            background: rgba(248, 250, 252, 0.8);
        }

        .admin-pill {
            border-radius: 999px;
            padding: 0.55rem 1rem;
            font-weight: 700;
        }

        .admin-soft {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
            border-radius: 22px;
        }

        .admin-form-card {
            padding: 1.6rem;
        }

        .admin-label {
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.45rem;
        }

        .form-control,
        .form-select,
        .form-control:focus,
        .form-select:focus {
            border-radius: 16px;
            box-shadow: none;
        }

        .btn-admin-primary,
        .btn-admin-success {
            border: 0;
            color: white;
            border-radius: 999px;
            padding: 0.8rem 1.35rem;
            font-weight: 700;
        }

        .btn-admin-primary {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            box-shadow: 0 16px 30px rgba(37, 99, 235, 0.2);
        }

        .btn-admin-success {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 16px 30px rgba(16, 185, 129, 0.2);
        }

        .btn-admin-primary:hover,
        .btn-admin-success:hover {
            color: white;
            transform: translateY(-1px);
        }

        @media (max-width: 992px) {
            .admin-sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }

            .admin-main {
                margin-left: 0;
                padding: 1.2rem;
            }

            .admin-topbar {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <span class="admin-brand-mark"><i class="bi bi-shield-lock-fill"></i></span>
            <span>
                <div class="admin-brand-name">CLIMENTAL</div>
                <div class="admin-brand-sub">Admin Control</div>
            </span>
        </a>

        <div class="admin-category">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="admin-category">Management</div>
        <a href="{{ route('admin.users.index') }}" class="admin-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Users
        </a>
        <a href="{{ route('admin.events.index') }}" class="admin-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-event-fill"></i> Events
        </a>
        <a href="{{ route('admin.organizations.index') }}" class="admin-link {{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}">
            <i class="bi bi-building-fill-gear"></i> Organizations
        </a>
        <a href="{{ route('admin.places.index') }}" class="admin-link {{ request()->routeIs('admin.places.*') ? 'active' : '' }}">
            <i class="bi bi-pin-map-fill"></i> Map Places
        </a>
        <a href="{{ route('admin.recycling-points.index') }}" class="admin-link {{ request()->routeIs('admin.recycling-points.*') ? 'active' : '' }}">
            <i class="bi bi-recycle"></i> Recycling Points
        </a>

        <div class="admin-category">Platform</div>
        <a href="{{ route('admin.settings.edit') }}" class="admin-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-sliders"></i> System Settings
        </a>

        <div class="admin-category">Safety</div>
        <a href="{{ route('community.moderate') }}" class="admin-link">
            <i class="bi bi-shield-fill-check"></i> Reports
        </a>

        <div class="mt-auto pt-4">
            <a href="{{ route('dashboard') }}" class="admin-link">
                <i class="bi bi-arrow-left-circle"></i> Back to Site
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="admin-link w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-right"></i> Log Out
                </button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <div class="admin-shell">
            <div class="admin-topbar">
                <div class="admin-topbar-card">
                    <span class="admin-kicker">Admin Workspace</span>
                    <h1 class="admin-page-title">{{ $pageTitle }}</h1>
                    <p class="admin-page-copy">Manage the platform clearly, confidently, and without losing sight of the user experience.</p>
                </div>

                <div class="admin-user-chip">
                    <div>
                        <div class="fw-bold small">{{ auth()->user()->name }}</div>
                        <div class="small text-muted">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                    <div class="admin-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">{{ session('error') }}</div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
