<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetMe Bato - Workspace Sign In</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #838996  1%, #ffcba4 50%, #fa8072 100%);
            background-attachment: fixed;
        }
        .brand-font { 
            font-family: 'Cabinet Grotesk', 'Inter', sans-serif;
            font-weight: 800;
            letter-spacing: -0.03em;
        }
        
        .custom-card {
            border-radius: 2.5rem !important;
            max-width: 500px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
        }
        
        .workspace-badge {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid #e2e8f0;
        }
        .badge-pulse {
            width: 6px;
            height: 6px;
            background-color: #E67E5A;
            border-radius: 50%;
        }
        
        .form-control-custom {
            padding: 0.95rem 1.2rem;
            border: 1px solid #cbd5e1;
            border-radius: 1rem !important;
            font-size: 0.95rem;
            font-weight: 500;
            color: #1e293b;
            background-color: #f8fafc;
            transition: all 0.2s ease-in-out;
        }
        .form-control-custom::placeholder {
            color: #94a3b8;
        }
        .form-control-custom:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.15);
            border-color: #1d4ed8;
            background-color: #fff;
        }
  
        .btn-custom {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            border-radius: 1rem !important;
            padding-top: 1rem;
            padding-bottom: 1rem;
            transition: all 0.2s ease-in-out;
        }
        .btn-custom:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%) !important;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(29, 78, 216, 0.3) !important;
        }
        .btn-custom:active {
            transform: translateY(1px);
        }
        .divider-container {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 2rem 0;
        }
        .divider-container::before, .divider-container::after {
            content: '';
            flex: 1;
            border-bottom: 1px dashed #e2e8f0;
        }
        .divider-container:not(:empty)::before { margin-right: 1rem; }
        .divider-container:not(:empty)::after { margin-left: 1rem; }
    </style>
</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center p-3">

    <div class="card custom-card border-0 shadow-2xl p-3 p-sm-4 p-md-5">
        <div class="card-body">
            
            <div class="text-center mb-4">
               
                
                <h1 class="brand-font display-4 mb-2" style="color: #1e293b;">
                    MeetMe<span style="color: #ff6347;">Bato</span>
                </h1>
                <p class="text-secondary small fw-medium mx-auto" style="max-width: 340px; line-height: 1.5;">
                    Access minutes, capture action items, and review strategic team decisions securely.
                </p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3.5">
                    <label class="form-label text-dark small fw-bold mb-2 text-uppercase tracking-wider" style="font-size: 11px;">Workspace Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email.com" required
                        class="form-control form-control-custom @error('email') is-invalid @enderror">
                    @error('email') 
                        <div class="invalid-feedback mt-1 fw-medium">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="mb-4 mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label text-dark small fw-bold mb-0 text-uppercase tracking-wider" style="font-size: 11px;">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small fw-semibold" style="color: #1d4ed8; font-size: 12px;">Forgot Account Key?</a>
                        @endif
                    </div>
                    <input type="password" name="password" placeholder="Enter Password" required
                        class="form-control form-control-custom">
                </div>

                <button type="submit" class="btn btn-custom w-100 text-white fw-bold fs-6 border-0 shadow mt-2">
                    Log In
                </button>
            </form>

            <div class="divider-container">Identity Management</div>

            <p class="text-center text-muted mb-0 small fw-medium">
                Need premium workspace access? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #1d4ed8;">Register Account</a>
            </p>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>