<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ config('app.name', 'CLIMENTAL') }}</title>
    <link rel="icon" href="{{ asset('images/climental-logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-green: #2ecc71;
            --primary-blue: #3498db;
            --sidebar-bg: #1a1a2e;
            --sidebar-hover: #16213e;
        }
        body { display: flex; min-height: 100vh; background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .admin-sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .admin-sidebar .brand {
            padding: 1.4rem 1.5rem;
            font-weight: 700;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #fff;
            background: var(--sidebar-hover);
            border-left-color: var(--primary-green);
        }
        .admin-sidebar .nav-category {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.35);
            padding: 1rem 1.5rem 0.4rem;
        }
        .admin-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 0.85rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-content { padding: 1.5rem; flex: 1; }
        .stat-card {
            border-radius: 14px;
            border: none;
            padding: 1.4rem;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .btn-admin-primary { background-color: var(--primary-blue); color: #fff; border: none; }
        .btn-admin-primary:hover { background-color: #2980b9; color: #fff; }
        .btn-admin-success { background-color: var(--primary-green); color: #fff; border: none; }
        .btn-admin-success:hover { background-color: #27ae60; color: #fff; }
        .table thead th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #6c757d; font-weight: 600; border-bottom-width: 1px; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="admin-sidebar">
        <div class="brand d-flex align-items-center">
            <img src="{{ asset('images/climental-logo.png') }}" alt="Climental" height="30" class="me-2">
            CLIMENTAL <span class="badge bg-warning text-dark ms-1" style="font-size:0.6rem;">Admin</span>
        </div>
        <div class="mt-2">
            <div class="nav-category">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="nav-category">Manage</div>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Users
            </a>
            <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event-fill"></i> Events
            </a>
            <a href="{{ route('admin.organizations.index') }}" class="nav-link {{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}">
                <i class="bi bi-building-fill-add"></i> Organizations
            </a>

            <div class="nav-category">Moderation</div>
            <a href="{{ route('community.moderate') }}" class="nav-link">
                <i class="bi bi-shield-fill-check"></i> Reports
            </a>

            <div class="nav-category mt-3"></div>
            <a href="{{ route('dashboard') }}" class="nav-link mt-2">
                <i class="bi bi-box-arrow-left"></i> Back to Site
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <h6 class="mb-0 fw-semibold text-muted">{{ $pageTitle ?? 'Admin Panel' }}</h6>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">Log Out</button>
                </form>
            </div>
        </div>

        <!-- Alerts -->
        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm py-2 px-3">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm py-2 px-3">{{ session('error') }}</div>
            @endif
        </div>

        <!-- Page Body -->
        <div class="admin-content">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
