<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — MeetMe Bato</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0C1016;
            -webkit-font-smoothing: antialiased;
        }

        /* Left Panel */
        .left-panel {
            width: 420px;
            min-width: 420px;
            background: linear-gradient(160deg, #0D1117 0%, #111827 100%);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(255,255,255,0.05);
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -60px; left: -60px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -40px; right: -40px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .brand { display: flex; align-items: center; gap: 0.75rem; position: relative; z-index: 1; }
        .brand-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366F1, #8B5CF6);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 16px rgba(99,102,241,0.4);
        }
        .brand-icon i { color: #fff; font-size: 1rem; }
        .brand-name { font-size: 1.25rem; font-weight: 800; letter-spacing: -0.025em; color: #F9FAFB; }
        .brand-name span { color: #A5B4FC; }

        .panel-body { position: relative; z-index: 1; }
        .panel-headline {
            font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;
            color: #F9FAFB; line-height: 1.2; margin-bottom: 0.75rem;
        }
        .panel-headline span { color: #A5B4FC; }
        .panel-desc { font-size: 0.875rem; color: #6B7280; line-height: 1.7; }

        .feature-list { display: flex; flex-direction: column; gap: 0.75rem; margin-top: 2rem; }
        .feature-item { display: flex; align-items: center; gap: 0.75rem; }
        .feature-dot { width: 24px; height: 24px; border-radius: 6px; background: rgba(99,102,241,0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .feature-dot i { color: #A5B4FC; font-size: 0.6rem; }
        .feature-text { font-size: 0.8125rem; color: #6B7280; font-weight: 500; }

        .panel-footer { position: relative; z-index: 1; font-size: 0.6875rem; color: #374151; }

        /* Right Panel */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F4F5F7;
            padding: 2rem;
        }
        .form-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            border: 1px solid #E5E7EB;
            box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 16px 48px rgba(0,0,0,0.08);
        }
        .form-title { font-size: 1.375rem; font-weight: 800; letter-spacing: -0.025em; color: #111827; margin-bottom: 0.375rem; }
        .form-sub { font-size: 0.8125rem; color: #6B7280; }

        .inp {
            width: 100%;
            background: #F9FAFB;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            color: #111827;
            transition: all 0.15s ease;
            outline: none;
        }
        .inp:focus { background: #fff; border-color: #6366F1; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }
        .inp::placeholder { color: #9CA3AF; }
        .inp.error-inp { border-color: #EF4444; }
        .inp.error-inp:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.12); }
        .lbl { display: block; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #6B7280; margin-bottom: 0.375rem; }
        .err-msg { font-size: 0.75rem; color: #EF4444; font-weight: 500; margin-top: 0.375rem; }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-size: 0.9375rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: 0 2px 8px rgba(99,102,241,0.3), 0 8px 24px rgba(99,102,241,0.15);
        }
        .btn-submit:hover { background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(99,102,241,0.4), 0 12px 32px rgba(99,102,241,0.2); }
        .btn-submit:active { transform: translateY(0); }

        .divider { display: flex; align-items: center; gap: 0.75rem; color: #D1D5DB; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; margin: 1.5rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #F3F4F6; }

        .link-p { color: #6366F1; font-weight: 700; text-decoration: none; }
        .link-p:hover { color: #4F46E5; text-decoration: underline; }

        @media (max-width: 768px) {
            .left-panel { display: none; }
        }

        /* Toast */
        #toast-wrap { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.625rem; }
        .toast-item {
            display: flex; align-items: flex-start; gap: 0.75rem;
            background: #fff; border-radius: 12px; border-left: 4px solid #10B981;
            box-shadow: 0 8px 32px rgba(0,0,0,0.16), 0 2px 8px rgba(0,0,0,0.08);
            padding: 0.875rem 1rem 0.875rem 0.875rem; min-width: 300px; max-width: 380px;
            animation: toastIn 0.3s cubic-bezier(0.34,1.56,0.64,1); position: relative; overflow: hidden;
        }
        .toast-item.t-error { border-left-color: #EF4444; }
        .toast-icon-wrap { width: 30px; height: 30px; border-radius: 8px; background: rgba(16,185,129,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.75rem; color: #10B981; }
        .toast-item.t-error .toast-icon-wrap { background: rgba(239,68,68,0.1); color: #EF4444; }
        .toast-msg { font-size: 0.8125rem; font-weight: 600; color: #111827; flex: 1; padding-top: 0.1rem; }
        .toast-close { background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 0; font-size: 0.75rem; flex-shrink: 0; margin-top: 0.15rem; }
        .toast-close:hover { color: #374151; }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 2px; background: #10B981; animation: progress 4s linear forwards; }
        .toast-item.t-error .toast-progress { background: #EF4444; }
        @keyframes toastIn { from { transform: translateX(32px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes progress { from { width: 100%; } to { width: 0%; } }
    </style>
</head>
@php $loginToast = session('toast_success') ?: session('toast_error'); $loginToastType = session('toast_error') ? 'error' : 'success'; @endphp
<body>
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon"><i class="fas fa-layer-group"></i></div>
            <div class="brand-name">MeetMe<span>Bato</span></div>
        </div>
        <div class="panel-body">
            <h2 class="panel-headline">Run better<br>meetings <span>together.</span></h2>
            <p class="panel-desc">A unified workspace for capturing minutes, tracking action items, and managing your team—all in one place.</p>
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-dot"><i class="fas fa-check"></i></div>
                    <div class="feature-text">Document meeting minutes in seconds</div>
                </div>
                <div class="feature-item">
                    <div class="feature-dot"><i class="fas fa-check"></i></div>
                    <div class="feature-text">Track action items and deadlines</div>
                </div>
                <div class="feature-item">
                    <div class="feature-dot"><i class="fas fa-check"></i></div>
                    <div class="feature-text">Manage board members with ease</div>
                </div>
            </div>
        </div>
        <div class="panel-footer">© {{ date('Y') }} MeetMe Bato. All rights reserved.</div>
    </div>

    <div class="right-panel">
        <div class="form-card">
            <div style="margin-bottom:2rem;">
                <div class="form-title">Welcome back</div>
                <div class="form-sub">Sign in to your workspace account</div>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <div>
                        <label class="lbl">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required class="inp {{ $errors->has('email') ? 'error-inp' : '' }}">
                        @error('email') <div class="err-msg">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.375rem;">
                            <label class="lbl" style="margin:0;">Password</label>
                        </div>
                        <input type="password" name="password" placeholder="••••••••" required class="inp">
                    </div>
                </div>

                <button type="submit" class="btn-submit" style="margin-top:1.5rem;">
                    Sign In
                </button>
            </form>

            <div class="divider">or</div>

            <p style="text-align:center;font-size:0.8125rem;color:#6B7280;">
                Don't have an account? <a href="{{ route('register') }}" class="link-p">Create one free</a>
            </p>
        </div>
    </div>

    <div id="toast-wrap"></div>
    <script>
    function showToast(msg, type = 'success') {
        const icon = type === 'error' ? 'fa-xmark' : 'fa-check';
        const el = document.createElement('div');
        el.className = `toast-item ${type === 'error' ? 't-error' : ''}`;
        el.innerHTML = `
            <div class="toast-icon-wrap"><i class="fas ${icon}"></i></div>
            <span class="toast-msg">${msg}</span>
            <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
            <div class="toast-progress"></div>`;
        document.getElementById('toast-wrap').appendChild(el);
        setTimeout(() => { el.style.transition = 'all 0.3s'; el.style.transform = 'translateX(20px)'; el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }, 4200);
    }
    document.addEventListener('DOMContentLoaded', () => {
        @if($loginToast)
            showToast(@json($loginToast), '{{ $loginToastType }}');
        @endif
    });
    </script>
</body>
</html>
