<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Textiles Committee CMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background: linear-gradient(135deg, #2b0b15 0%, #721835 50%, #45091c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
        }
        .login-header {
            background: #fdf2f4;
            padding: 28px 24px;
            text-align: center;
            border-bottom: 2px solid #f1d4dc;
        }
        .login-body {
            padding: 30px;
        }
        .btn-login {
            background-color: #721835;
            border-color: #721835;
            color: #ffffff;
            font-weight: 700;
            padding: 12px;
            font-size: 15px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background-color: #5c1129;
            border-color: #5c1129;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('assets/images/emblem.jpeg') }}" alt="Emblem" style="height: 60px; width: auto;" onerror="this.src='{{ asset('assets/images/header_emblem_logo.png') }}'">
            <h3 class="fw-bold mt-3 mb-1" style="color: #721835; font-size: 19px;">Textiles Committee CMS</h3>
            <div class="text-secondary" style="font-size: 13px;">Ministry of Textiles | Government of India</div>
        </div>

        <div class="login-body">
            @if(session('error'))
                <div class="alert alert-danger py-2 fs-6 mb-3">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success py-2 fs-6 mb-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2 fs-6 mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">
                            <span class="material-symbols-outlined" style="font-size: 18px;">mail</span>
                        </span>
                        <input type="email" name="email" class="form-control" value="{{ old('email', 'admin@tcwebsite.gov.in') }}" required autofocus placeholder="admin@tcwebsite.gov.in">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">
                            <span class="material-symbols-outlined" style="font-size: 18px;">lock</span>
                        </span>
                        <input type="password" name="password" class="form-control" value="admin123" required placeholder="Enter password">
                    </div>
                </div>

                <div class="mb-4 form-check d-flex justify-content-between align-items-center">
                    <div>
                        <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                        <label class="form-check-label text-secondary small" for="rememberMe">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    Sign In
                </button>
            </form>

            <div class="mt-4 pt-3 border-top text-center text-muted small">
                Default Credentials:<br>
                <strong>admin@tcwebsite.gov.in</strong> / <strong>admin123</strong>
                <div class="mt-2">
                    <a href="{{ route('home') }}" class="text-decoration-none" style="color: #721835;">
                        &larr; Return to Main Website
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
