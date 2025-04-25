<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DentalCare') }} - Register</title>

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

        .register-container {
            width: 100%;
            max-width: 1200px;
            margin: 2rem;
            display: flex;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border-radius: 1rem;
            overflow: hidden;
            background: white;
        }

        .register-form {
            flex: 0.8;
            padding: 3rem;
            max-width: 480px;
        }

        .register-image {
            flex: 1.2;
            background: url('{{ asset("images/dental-consultation.jpg") }}') center/cover;
            position: relative;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(14, 165, 233, 0.2), rgba(56, 189, 248, 0.1));
        }

        .register-image-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .register-image-content h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .register-image-content p {
            font-size: 1.1rem;
            max-width: 80%;
            margin: 0 auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .register-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .register-header h1 {
            color: #0f172a;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .register-header p {
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
            max-width: 360px;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
            outline: none;
        }

        .register-button {
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
            margin-bottom: 1.5rem;
        }

        .register-button:hover {
            background: #0284c7;
        }

        .login-link {
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }

        .login-link a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }

            .register-image {
                min-height: 200px;
            }

            .register-form {
                padding: 2rem;
            }
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-form">
            <div class="register-header">
                <h1>Create Account</h1>
                <p>Join DentalCare to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" class="form-input @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}"
                           placeholder="Full Name" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-input @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}"
                           placeholder="Email Address" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-phone"></i>
                    <input type="tel" class="form-input @error('phone') is-invalid @enderror"
                           name="phone" value="{{ old('phone') }}"
                           placeholder="Phone Number">
                    @error('phone')
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

                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-input"
                           name="password_confirmation"
                           placeholder="Confirm Password" required>
                </div>

                <button type="submit" class="register-button">Create Account</button>

                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Sign in</a>
                </div>
            </form>
        </div>
        <div class="register-image">
            <div class="register-image-content">
                <h2>Join Our Dental Family</h2>
                <p>Experience world-class dental care with our team of expert professionals</p>
            </div>
        </div>
    </div>
</body>
</html>
