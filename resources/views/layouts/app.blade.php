<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetMe Bato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }
        body { font-family: 'Inter', sans-serif; background: #F1F5F9; display: flex; overflow: hidden; }

        /* ── Sidebar ── */
        .sidebar {
            width: 256px;
            min-width: 256px;
            height: 100vh;
            background: #0F172A;
            display: flex;
            flex-direction: column;
            padding: 0;
            overflow-y: auto;
            position: relative;
            z-index: 100;
        }
        .sidebar-top {
            padding: 1.75rem 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1;
            color: #fff;
        }
        .brand-logo span { color: #818CF8; }
        .brand-sub {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #475569;
            margin-top: 0.25rem;
        }

        .sidebar-nav { padding: 1rem 0.875rem; flex: 1; }
        .nav-section-label {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #334155;
            padding: 0 0.625rem;
            margin: 1.25rem 0 0.5rem;
        }
        .nav-section-label:first-child { margin-top: 0; }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.625rem;
            color: #94A3B8;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 0.125rem;
        }
        .nav-link-item i { width: 1rem; text-align: center; font-size: 0.8rem; }
        .nav-link-item:hover { background: #1E293B; color: #E2E8F0; }
        .nav-link-item.active { background: #4F46E5; color: #fff; font-weight: 600; }
        .nav-link-item.active i { color: #C7D2FE; }

        .logout-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.625rem;
            color: #F87171;
            font-size: 0.875rem;
            font-weight: 500;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: all 0.15s ease;
            margin-bottom: 0.125rem;
        }
        .logout-item:hover { background: rgba(239,68,68,0.08); color: #FCA5A5; }
        .logout-item i { width: 1rem; text-align: center; font-size: 0.8rem; }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4F46E5, #818CF8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            color: #fff;
            flex-shrink: 0;
        }
        .user-info { overflow: hidden; }
        .user-name { font-size: 0.8rem; font-weight: 600; color: #E2E8F0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.2; }
        .user-email { font-size: 0.7rem; color: #475569; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.2; margin-top: 0.1rem; }

        /* ── Main ── */
        .main-content { flex: 1; height: 100vh; overflow-y: auto; }

        /* ── Toast ── */
        .toast-premium {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            padding: 1rem 1.25rem;
            min-width: 300px;
            border-left: 4px solid #10B981;
            animation: slideIn 0.3s ease;
        }
        .toast-premium.toast-error { border-left-color: #EF4444; }
        .toast-premium.toast-warning { border-left-color: #F59E0B; }
        .toast-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: #D1FAE5;
            color: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
        }
        .toast-error .toast-icon { background: #FEE2E2; color: #DC2626; }
        .toast-warning .toast-icon { background: #FEF3C7; color: #D97706; }
        .toast-msg { font-size: 0.875rem; font-weight: 600; color: #1E293B; flex: 1; }
        .toast-close { background: none; border: none; color: #94A3B8; cursor: pointer; font-size: 1rem; padding: 0; line-height: 1; }
        .toast-close:hover { color: #475569; }
        @keyframes slideIn { from { transform: translateX(20px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* ── Utility ── */
        .btn-primary-custom {
            background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
            color: #fff;
            border: none;
            border-radius: 0.625rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: 0 1px 3px rgba(79,70,229,0.3);
        }
        .btn-primary-custom:hover { background: linear-gradient(135deg, #4338CA 0%, #3730A3 100%); box-shadow: 0 4px 12px rgba(79,70,229,0.4); transform: translateY(-1px); }
        .btn-danger-custom {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            color: #fff;
            border: none;
            border-radius: 0.625rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .btn-danger-custom:hover { background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%); transform: translateY(-1px); }
        .btn-ghost-custom {
            background: #F8FAFC;
            color: #475569;
            border: 1px solid #E2E8F0;
            border-radius: 0.625rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .btn-ghost-custom:hover { background: #F1F5F9; color: #334155; }
        .form-control-premium, .form-select-premium {
            background: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 0.625rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            color: #0F172A;
            transition: all 0.15s ease;
            width: 100%;
        }
        .form-control-premium:focus, .form-select-premium:focus {
            outline: none;
            border-color: #4F46E5;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .form-label-premium {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #64748B;
            display: block;
            margin-bottom: 0.4rem;
        }
        .modal-content { border: none; border-radius: 1rem; box-shadow: 0 25px 60px rgba(0,0,0,0.15); }
        .modal-header-premium {
            padding: 1.5rem 1.5rem 0;
            border: none;
        }
        .modal-title-premium { font-size: 1.125rem; font-weight: 700; color: #0F172A; }
        .modal-sub-premium { font-size: 0.75rem; color: #94A3B8; margin-top: 0.2rem; }
        .modal-body-premium { padding: 1.25rem 1.5rem; }
        .modal-footer-premium {
            padding: 0 1.5rem 1.5rem;
            border: none;
            display: flex;
            justify-content: flex-end;
            gap: 0.625rem;
        }
        .card-premium {
            background: #fff;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(0,0,0,0.04);
        }
        .page-title { font-size: 1.5rem; font-weight: 700; color: #0F172A; margin: 0; }
        .page-sub { font-size: 0.875rem; color: #64748B; margin: 0.25rem 0 0; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-top">
        <div class="brand-logo">MeetMe<span>Bato</span></div>
        <div class="brand-sub">Management System</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-link-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <div class="nav-section-label">Management</div>
        <a href="{{ route('users.index') }}" class="nav-link-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
            <i class="fas fa-users"></i> User Management
        </a>
        <a href="{{ route('notes.index') }}" class="nav-link-item {{ request()->routeIs('notes.index') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> Meeting Notes
        </a>

        <div class="nav-section-label">Account</div>
        <a href="{{ route('profile') }}" class="nav-link-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> My Profile
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-item">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </button>
        </form>
    </nav>

    <div class="sidebar-footer">
        <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-email">{{ auth()->user()->email }}</div>
        </div>
    </div>
</aside>

<main class="main-content">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast-premium ${type === 'error' ? 'toast-error' : type === 'warning' ? 'toast-warning' : ''}`;
        const icon = type === 'success' ? 'fa-check' : type === 'error' ? 'fa-times' : 'fa-exclamation';
        toast.innerHTML = `
            <div class="toast-icon"><i class="fas ${icon}"></i></div>
            <span class="toast-msg">${message}</span>
            <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>`;
        container.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateX(20px)'; toast.style.transition = 'all 0.3s'; setTimeout(() => toast.remove(), 300); }, 4000);
    }
</script>
<div id="toast-container" style="position:fixed;top:1.25rem;right:1.25rem;z-index:9999;display:flex;flex-direction:column;gap:0.625rem;"></div>
</body>
</html>
