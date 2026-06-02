<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — MeetMe Bato</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0D1117 0%, #111827 50%, #0D1117 100%);
            padding: 2rem;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: -100px; left: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -80px; right: -80px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 24px 80px rgba(0,0,0,0.4);
            position: relative; z-index: 1;
        }

        .brand { display: flex; align-items: center; gap: 0.625rem; margin-bottom: 1.75rem; }
        .brand-icon {
            width: 34px; height: 34px; border-radius: 8px;
            background: linear-gradient(135deg, #6366F1, #8B5CF6);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 3px 12px rgba(99,102,241,0.35);
        }
        .brand-icon i { color: #fff; font-size: 0.8rem; }
        .brand-name { font-size: 1rem; font-weight: 800; letter-spacing: -0.02em; color: #111827; }
        .brand-name span { color: #6366F1; }

        .form-title { font-size: 1.375rem; font-weight: 800; letter-spacing: -0.025em; color: #111827; margin-bottom: 0.25rem; }
        .form-sub { font-size: 0.8125rem; color: #6B7280; margin-bottom: 1.75rem; }

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
            margin-top: 0.25rem;
            box-shadow: 0 2px 8px rgba(99,102,241,0.3), 0 8px 24px rgba(99,102,241,0.15);
        }
        .btn-submit:hover { background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(99,102,241,0.4), 0 12px 32px rgba(99,102,241,0.2); }
        .btn-submit:active { transform: translateY(0); }
        .link-p { color: #6366F1; font-weight: 700; text-decoration: none; }
        .link-p:hover { text-decoration: underline; }

        /* Toast */
        #toast-wrap { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.625rem; }
        .toast-item {
            display: flex; align-items: flex-start; gap: 0.75rem;
            background: #fff; border-radius: 12px; border-left: 4px solid #EF4444;
            box-shadow: 0 8px 32px rgba(0,0,0,0.16), 0 2px 8px rgba(0,0,0,0.08);
            padding: 0.875rem 1rem 0.875rem 0.875rem; min-width: 300px; max-width: 380px;
            animation: toastIn 0.3s cubic-bezier(0.34,1.56,0.64,1); position: relative; overflow: hidden;
        }
        .toast-icon-wrap { width: 30px; height: 30px; border-radius: 8px; background: rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.75rem; color: #EF4444; }
        .toast-msg { font-size: 0.8125rem; font-weight: 600; color: #111827; flex: 1; padding-top: 0.1rem; }
        .toast-close { background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 0; font-size: 0.75rem; flex-shrink: 0; margin-top: 0.15rem; }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 2px; background: #EF4444; animation: progress 4s linear forwards; }
        @keyframes toastIn { from { transform: translateX(32px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes progress { from { width: 100%; } to { width: 0%; } }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <div class="brand-icon"><i class="fas fa-layer-group"></i></div>
            <div class="brand-name">MeetMe<span>Bato</span></div>
        </div>

        <div class="form-title">Create your account</div>
        <div class="form-sub">Join your team's workspace today</div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div style="display:flex;flex-direction:column;gap:0.875rem;">
                <div>
                    <label class="lbl">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" required class="inp">
                    @error('name') <div class="err-msg">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="lbl">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required class="inp">
                    @error('email') <div class="err-msg">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="lbl">Password</label>
                    <input type="password" name="password" placeholder="Minimum 8 characters" required class="inp">
                    @error('password') <div class="err-msg">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="lbl">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat your password" required class="inp">
                </div>
            </div>

            <button type="submit" class="btn-submit" style="margin-top:1.5rem;">
                Create Account
            </button>
        </form>

        <p style="text-align:center;font-size:0.8125rem;color:#6B7280;margin-top:1.5rem;">
            Already have an account? <a href="{{ route('login') }}" class="link-p">Sign in</a>
        </p>
    </div>

    <div id="toast-wrap"></div>
    <script>
    function showToast(msg) {
        const el = document.createElement('div');
        el.className = 'toast-item';
        el.innerHTML = `
            <div class="toast-icon-wrap"><i class="fas fa-xmark"></i></div>
            <span class="toast-msg">${msg}</span>
            <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
            <div class="toast-progress"></div>`;
        document.getElementById('toast-wrap').appendChild(el);
        setTimeout(() => { el.style.transition = 'all 0.3s'; el.style.transform = 'translateX(20px)'; el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }, 4200);
    }
    document.addEventListener('DOMContentLoaded', () => {
        @if($errors->any())
            showToast(@json($errors->first()));
        @endif
    });
    </script>
</body>
</html>
