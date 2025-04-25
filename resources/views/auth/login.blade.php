<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DentalCare') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 1200px;
            margin: 2rem;
            display: flex;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border-radius: 1rem;
            overflow: hidden;
            background: white;
        }

        .login-image {
            flex: 1.2;
            background: url('{{ asset("images/dental-checkup.jpg") }}') center/cover;
            position: relative;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(14, 165, 233, 0.2), rgba(56, 189, 248, 0.1));
        }

        .login-image-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .login-image-content h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .login-image-content p {
            font-size: 1.1rem;
            max-width: 80%;
            margin: 0 auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .login-form {
            flex: 0.8;
            padding: 3rem;
            max-width: 480px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h1 {
            color: #0f172a;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s;
            max-width: 100%;
            width: 360px;
        }

        .form-input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
            outline: none;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
        }

        .forgot-link {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 500;
        }

        .login-button {
            width: 100%;
            padding: 0.75rem;
            background: #0ea5e9;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .login-button:hover {
            background: #0284c7;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #e2e8f0;
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .social-login {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-button {
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }

        .social-button:hover {
            background: #f8fafc;
            border-color: #0ea5e9;
        }

        .register-link {
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }

        .register-link a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-image {
                min-height: 200px;
            }

            .login-form {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <div class="login-header">
                <h1>Welcome Back!</h1>
                <p>Please sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-input @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}"
                           placeholder="Email address" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-input @error('password') is-invalid @enderror"
                           name="password" placeholder="Password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="login-button">Sign In</button>
            </form>

            <div class="divider">
                <span class="or">or continue with</span>
            </div>

            <div class="social-login">
                <a href="#" class="social-button">
                    <i class="fab fa-google"></i>
                    <span>Google</span>
                </a>
                <a href="#" class="social-button">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </a>
            </div>

            <div class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Sign up</a>
            </div>
        </div>
        <div class="login-image">
            <div class="login-image-content">
                <h2>Expert Dental Care</h2>
                <p>Providing quality dental services with modern technology and experienced professionals</p>
            </div>
        </div>
    </div>
</body>
</html>
