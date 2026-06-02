<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetMe Bato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;0,14..32,900&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 264px;
            --sidebar-bg: #0C1016;
            --sidebar-border: rgba(255,255,255,0.05);
            --sidebar-muted: #4B5563;
            --sidebar-text: #9CA3AF;
            --sidebar-hover-bg: rgba(255,255,255,0.04);
            --sidebar-active-bg: rgba(99,102,241,0.14);
            --sidebar-active-text: #A5B4FC;
            --sidebar-active-border: #6366F1;

            --bg: #F4F5F7;
            --surface: #FFFFFF;
            --surface-2: #F9FAFB;
            --border: #E5E7EB;
            --border-light: #F3F4F6;

            --primary: #6366F1;
            --primary-d: #4F46E5;
            --primary-dd: #4338CA;
            --primary-rgb: 99,102,241;

            --success: #10B981;
            --success-rgb: 16,185,129;
            --danger: #EF4444;
            --danger-rgb: 239,68,68;
            --warning: #F59E0B;
            --warning-rgb: 245,158,11;
            --info: #06B6D4;
            --info-rgb: 6,182,212;

            --t1: #111827;
            --t2: #374151;
            --t3: #6B7280;
            --t4: #9CA3AF;
            --t5: #D1D5DB;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: var(--bg); display: flex; overflow: hidden; color: var(--t1); -webkit-font-smoothing: antialiased; }

        /* ════════════════════ SIDEBAR ════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            min-width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            flex-shrink: 0;
            position: relative;
        }
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 40% at 50% 0%, rgba(99,102,241,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Brand */
        .sb-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid var(--sidebar-border);
            flex-shrink: 0;
        }
        .sb-logo { display: flex; align-items: center; gap: 0.625rem; }
        .sb-logo-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        }
        .sb-logo-icon i { color: #fff; font-size: 0.75rem; }
        .sb-logo-text { font-size: 1rem; font-weight: 800; letter-spacing: -0.025em; color: #F9FAFB; }
        .sb-logo-text span { color: #A5B4FC; }
        .sb-tagline { font-size: 0.625rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--sidebar-muted); margin-top: 0.25rem; padding-left: 2.5rem; }

        /* Nav */
        .sb-nav { padding: 1rem 0.75rem; flex: 1; }
        .sb-section { font-size: 0.6rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--sidebar-muted); padding: 0 0.5rem; margin: 1.25rem 0 0.375rem; }
        .sb-section:first-child { margin-top: 0; }

        .sb-link {
            display: flex; align-items: center; gap: 0.625rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            color: var(--sidebar-text);
            font-size: 0.8125rem; font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 2px;
            position: relative;
            border: 1px solid transparent;
        }
        .sb-link .sb-icon {
            width: 28px; height: 28px;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem;
            background: rgba(255,255,255,0.04);
            flex-shrink: 0;
            transition: all 0.15s ease;
        }
        .sb-link:hover { color: #E5E7EB; background: var(--sidebar-hover-bg); }
        .sb-link:hover .sb-icon { background: rgba(255,255,255,0.08); }
        .sb-link.active {
            color: var(--sidebar-active-text);
            background: var(--sidebar-active-bg);
            border-color: rgba(99,102,241,0.2);
        }
        .sb-link.active .sb-icon { background: rgba(99,102,241,0.2); color: #A5B4FC; }
        .sb-link.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            top: 50%; transform: translateY(-50%);
            width: 3px; height: 16px;
            background: var(--sidebar-active-border);
            border-radius: 0 3px 3px 0;
        }

        .sb-logout {
            display: flex; align-items: center; gap: 0.625rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            color: #F87171;
            font-size: 0.8125rem; font-weight: 500;
            background: none; border: none; width: 100%; text-align: left;
            cursor: pointer;
            transition: all 0.15s ease;
            margin-bottom: 2px;
        }
        .sb-logout .sb-icon { width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; background: rgba(239,68,68,0.08); flex-shrink: 0; transition: all 0.15s ease; }
        .sb-logout:hover { color: #FCA5A5; background: rgba(239,68,68,0.06); }
        .sb-logout:hover .sb-icon { background: rgba(239,68,68,0.15); }

        /* User card */
        .sb-user {
            padding: 0.875rem 1rem;
            border-top: 1px solid var(--sidebar-border);
            display: flex; align-items: center; gap: 0.75rem;
            flex-shrink: 0;
        }
        .sb-avatar {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, #6366F1, #8B5CF6);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.75rem; color: #fff;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(99,102,241,0.3);
        }
        .sb-user-name { font-size: 0.8rem; font-weight: 600; color: #E5E7EB; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb-user-email { font-size: 0.65rem; color: var(--sidebar-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 1px; }

        /* ════════════════════ MAIN ════════════════════ */
        .main { flex: 1; height: 100vh; overflow-y: auto; overflow-x: hidden; }

        /* ════════════════════ UTILITIES ════════════════════ */
        .page-wrap { padding: 2rem 2.25rem; max-width: 1320px; margin: 0 auto; }
        .page-title { font-size: 1.375rem; font-weight: 800; letter-spacing: -0.025em; color: var(--t1); }
        .page-desc { font-size: 0.8125rem; color: var(--t3); margin-top: 0.25rem; }

        /* Cards */
        .card-p {
            background: var(--surface);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.05);
        }
        .card-p-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-p-hover:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 12px 32px rgba(0,0,0,0.09); }

        /* Buttons */
        .btn-p {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8125rem; font-weight: 600;
            cursor: pointer; border: none;
            transition: all 0.15s ease;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary-p {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-d) 100%);
            color: #fff;
            box-shadow: 0 1px 3px rgba(var(--primary-rgb),0.3), 0 4px 12px rgba(var(--primary-rgb),0.15);
        }
        .btn-primary-p:hover { background: linear-gradient(135deg, var(--primary-d) 0%, var(--primary-dd) 100%); box-shadow: 0 2px 8px rgba(var(--primary-rgb),0.4), 0 8px 20px rgba(var(--primary-rgb),0.2); transform: translateY(-1px); color: #fff; }
        .btn-danger-p {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            color: #fff;
            box-shadow: 0 1px 3px rgba(var(--danger-rgb),0.3);
        }
        .btn-danger-p:hover { background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(var(--danger-rgb),0.35); color: #fff; }
        .btn-ghost-p {
            background: var(--surface);
            color: var(--t2);
            border: 1px solid var(--border);
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }
        .btn-ghost-p:hover { background: var(--surface-2); color: var(--t1); box-shadow: 0 2px 6px rgba(0,0,0,0.07); }

        /* Inputs */
        .inp-p, .sel-p {
            width: 100%;
            background: var(--surface-2);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 0.5625rem 0.875rem;
            font-size: 0.8125rem;
            font-family: 'Inter', sans-serif;
            color: var(--t1);
            transition: all 0.15s ease;
            outline: none;
        }
        .inp-p:focus, .sel-p:focus {
            background: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb),0.12);
        }
        .inp-p::placeholder { color: var(--t4); }
        .lbl-p {
            display: block;
            font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.05em;
            text-transform: uppercase; color: var(--t3);
            margin-bottom: 0.375rem;
        }

        /* Modal */
        .modal-content { border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.18); }
        .modal-backdrop { backdrop-filter: blur(4px); }
        .modal-premium-head { padding: 1.5rem 1.5rem 0; border: none; }
        .modal-premium-body { padding: 1rem 1.5rem; }
        .modal-premium-foot { padding: 0 1.5rem 1.5rem; border: none; display: flex; justify-content: flex-end; gap: 0.5rem; }
        .modal-premium-title { font-size: 1.0625rem; font-weight: 700; letter-spacing: -0.01em; color: var(--t1); }
        .modal-premium-sub { font-size: 0.75rem; color: var(--t4); margin-top: 0.2rem; }
        .modal .modal-dialog { animation: modalIn 0.2s ease; }
        @keyframes modalIn { from { transform: scale(0.97) translateY(8px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }

        /* Badge */
        .badge-p {
            display: inline-flex; align-items: center;
            font-size: 0.625rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
            padding: 0.2rem 0.6rem; border-radius: 99px;
        }
        .badge-primary { background: rgba(var(--primary-rgb),0.1); color: var(--primary-d); }
        .badge-success { background: rgba(var(--success-rgb),0.1); color: #059669; }
        .badge-danger { background: rgba(var(--danger-rgb),0.1); color: #DC2626; }

        /* Toast */
        #toast-wrap { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.625rem; }
        .toast-item {
            display: flex; align-items: flex-start; gap: 0.75rem;
            background: var(--surface);
            border-radius: 12px;
            border-left: 4px solid var(--success);
            box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
            padding: 0.875rem 1rem 0.875rem 0.875rem;
            min-width: 300px; max-width: 380px;
            animation: toastIn 0.3s cubic-bezier(0.34,1.56,0.64,1);
            position: relative; overflow: hidden;
        }
        .toast-item.t-error { border-left-color: var(--danger); }
        .toast-item.t-warning { border-left-color: var(--warning); }
        .toast-icon-wrap {
            width: 30px; height: 30px; border-radius: 8px;
            background: rgba(var(--success-rgb),0.1);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 0.75rem; color: var(--success);
        }
        .toast-item.t-error .toast-icon-wrap { background: rgba(var(--danger-rgb),0.1); color: var(--danger); }
        .toast-item.t-warning .toast-icon-wrap { background: rgba(var(--warning-rgb),0.1); color: var(--warning); }
        .toast-msg { font-size: 0.8125rem; font-weight: 600; color: var(--t1); flex: 1; padding-top: 0.1rem; }
        .toast-close { background: none; border: none; color: var(--t4); cursor: pointer; padding: 0; font-size: 0.75rem; flex-shrink: 0; margin-top: 0.15rem; transition: color 0.1s; }
        .toast-close:hover { color: var(--t2); }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 2px; background: var(--success); animation: progress 4s linear forwards; border-radius: 0 2px 2px 0; }
        .toast-item.t-error .toast-progress { background: var(--danger); }
        .toast-item.t-warning .toast-progress { background: var(--warning); }
        @keyframes toastIn { from { transform: translateX(32px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes progress { from { width: 100%; } to { width: 0%; } }

        /* Action chips */
        .chip-btn {
            display: inline-flex; align-items: center; gap: 0.3rem;
            font-size: 0.6875rem; font-weight: 600;
            padding: 0.3rem 0.625rem;
            border-radius: 6px; border: none; cursor: pointer;
            transition: all 0.12s ease;
        }
        .chip-edit { background: rgba(var(--primary-rgb),0.08); color: var(--primary-d); }
        .chip-edit:hover { background: rgba(var(--primary-rgb),0.16); }
        .chip-delete { background: rgba(var(--danger-rgb),0.08); color: #DC2626; }
        .chip-delete:hover { background: rgba(var(--danger-rgb),0.16); }

        /* Divider */
        .divider-p { height: 1px; background: var(--border-light); margin: 1.25rem 0; }

        /* Empty state */
        .empty-state { text-align: center; padding: 4rem 2rem; }
        .empty-icon { font-size: 2.5rem; color: var(--t5); margin-bottom: 1rem; }
        .empty-title { font-size: 0.9375rem; font-weight: 700; color: var(--t2); margin-bottom: 0.375rem; }
        .empty-desc { font-size: 0.8125rem; color: var(--t4); }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sb-brand">
        <div class="sb-logo">
            <div class="sb-logo-icon"><i class="fas fa-layer-group"></i></div>
            <div class="sb-logo-text">MeetMe<span>Bato</span></div>
        </div>
        <div class="sb-tagline">Workspace Management</div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Overview</div>
        <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="sb-icon"><i class="fas fa-chart-pie"></i></div>
            Dashboard
        </a>

        <div class="sb-section">Management</div>
        <a href="{{ route('users.index') }}" class="sb-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
            <div class="sb-icon"><i class="fas fa-users"></i></div>
            User Management
        </a>
        <a href="{{ route('notes.index') }}" class="sb-link {{ request()->routeIs('notes.index') ? 'active' : '' }}">
            <div class="sb-icon"><i class="fas fa-file-lines"></i></div>
            Meeting Notes
        </a>

        <div class="sb-section">Account</div>
        <a href="{{ route('profile') }}" class="sb-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <div class="sb-icon"><i class="fas fa-circle-user"></i></div>
            My Profile
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sb-logout">
                <div class="sb-icon"><i class="fas fa-right-from-bracket"></i></div>
                Log Out
            </button>
        </form>
    </nav>

    <div class="sb-user">
        <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div style="min-width:0;">
            <div class="sb-user-name">{{ auth()->user()->name }}</div>
            <div class="sb-user-email">{{ auth()->user()->email }}</div>
        </div>
    </div>
</aside>

<main class="main">
    @yield('content')
</main>

<div id="toast-wrap"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showToast(msg, type = 'success') {
    const icons = { success: 'fa-check', error: 'fa-xmark', warning: 'fa-triangle-exclamation' };
    const el = document.createElement('div');
    el.className = `toast-item ${type === 'error' ? 't-error' : type === 'warning' ? 't-warning' : ''}`;
    el.innerHTML = `
        <div class="toast-icon-wrap"><i class="fas ${icons[type] || icons.success}"></i></div>
        <span class="toast-msg">${msg}</span>
        <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
        <div class="toast-progress"></div>`;
    document.getElementById('toast-wrap').appendChild(el);
    setTimeout(() => {
        el.style.transition = 'all 0.3s ease';
        el.style.transform = 'translateX(20px)';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 300);
    }, 4200);
}

// Auto-show flashed session toasts on any page that uses this layout
document.addEventListener('DOMContentLoaded', () => {
    @if(session('toast_success'))
        showToast(@json(session('toast_success')), 'success');
    @endif
    @if(session('toast_error'))
        showToast(@json(session('toast_error')), 'error');
    @endif
    @if(session('toast_warning'))
        showToast(@json(session('toast_warning')), 'warning');
    @endif
});
</script>
</body>
</html>
