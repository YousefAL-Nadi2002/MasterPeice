<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo img {
            max-width: 150px;
        }
        .form-floating {
            margin-bottom: 1rem;
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
            <h4 class="text-center mb-4">تسجيل الدخول إلى لوحة التحكم</h4>
            
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
                    <label for="email">البريد الإلكتروني</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="كلمة المرور" required>
                    <label for="password">كلمة المرور</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        تذكرني
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> تسجيل الدخول
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 