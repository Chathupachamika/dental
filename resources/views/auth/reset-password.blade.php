<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dental Management') }} - Reset Password</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #0ea5e9;
            --secondary-dark: #0284c7;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f3f4f6;
            --dark: #1f2937;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-image: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 400px;
            height: 400px;
            bottom: -200px;
            right: -200px;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            bottom: 30%;
            left: 10%;
            animation-delay: 4s;
        }

        .shape-4 {
            width: 150px;
            height: 150px;
            top: 20%;
            right: 10%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-20px) rotate(5deg);
            }
            50% {
                transform: translateY(10px) rotate(-5deg);
            }
            75% {
                transform: translateY(-15px) rotate(3deg);
            }
        }

        /* Card Styles */
        .auth-card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1),
                        0 20px 48px rgba(0, 0, 0, 0.1),
                        0 1px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            position: relative;
            z-index: 10;
            overflow: hidden;
            margin: 1.5rem;
            transition: all 0.3s ease;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        .auth-heading {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .auth-heading::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 3px;
        }

        .auth-subheading {
            color: #64748b;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
            background-color: white;
        }

        .form-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 1rem;
            color: #94a3b8;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus + .form-icon {
            color: var(--primary);
        }

        /* Button Styles */
        .btn {
            padding: 0.875rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            width: 100%;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform 0.5s, opacity 0.5s;
        }

        .btn:active::after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }

        .btn-primary {
            background-image: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2),
                        0 2px 4px -1px rgba(37, 99, 235, 0.1);
        }

        .btn-primary:hover {
            background-image: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2),
                        0 4px 6px -2px rgba(37, 99, 235, 0.1);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-icon {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        /* Validation Styles */
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: var(--danger);
            font-weight: 500;
        }

        .is-invalid {
            border-color: var(--danger);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ef4444' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.5em 1.5em;
        }

        .is-invalid:focus {
            border-color: var(--danger);
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 640px) {
            .auth-card {
                padding: 2rem;
                margin: 1rem;
            }

            .auth-heading {
                font-size: 1.5rem;
            }

            .auth-subheading {
                font-size: 0.875rem;
            }

            .form-control {
                padding: 0.75rem 1rem 0.75rem 2.75rem;
                font-size: 0.875rem;
            }

            .btn {
                padding: 0.75rem 1.25rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 380px) {
            .auth-card {
                padding: 1.5rem;
                margin: 0.75rem;
            }
        }

        /* Animation Utilities */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Reset Password Illustration */
        .reset-illustration {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .reset-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1);
            position: relative;
        }

        .reset-icon::before {
            content: '';
            position: absolute;
            width: 90%;
            height: 90%;
            border-radius: 50%;
            border: 2px dashed rgba(37, 99, 235, 0.3);
            animation: spin 10s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Password Strength Meter */
        .password-strength {
            height: 5px;
            border-radius: 5px;
            margin-top: 0.5rem;
            background-color: #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
        }

        .strength-weak {
            width: 33.33%;
            background-color: var(--danger);
        }

        .strength-medium {
            width: 66.66%;
            background-color: var(--warning);
        }

        .strength-strong {
            width: 100%;
            background-color: var(--success);
        }

        .password-feedback {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            color: #64748b;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-500 to-indigo-600">
    <div class="animated-bg">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <div class="w-full max-w-md mx-auto px-4">
        <div class="auth-card animate-fade-in">
            <div class="reset-illustration animate-slide-up">
                <div class="reset-icon">
                    <i class="fas fa-unlock-alt"></i>
                </div>
            </div>

            <div class="auth-heading animate-slide-up">Reset Password</div>
            <div class="auth-subheading animate-slide-up">
                Create a new secure password for your account.
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="animate-slide-up">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email', $request->email) }}"
                           placeholder="Email Address" required autofocus readonly>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope form-icon"></i>
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" id="password" placeholder="New Password" required>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock form-icon"></i>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                    <div class="password-feedback" id="passwordFeedback">Password strength</div>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control"
                           name="password_confirmation" id="password_confirmation"
                           placeholder="Confirm New Password" required>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock form-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-key btn-icon"></i> Reset Password
                </button>
            </form>

            <div class="mt-4 text-center text-sm text-gray-500 animate-slide-up">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Back to login
                </a>
            </div>
        </div>
    </div>

    <script>
        // Add subtle animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('.form-group, .btn');
            formElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    element.style.transition = 'all 0.5s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 300 + (index * 100));
            });

            // Password strength meter
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const feedback = document.getElementById('passwordFeedback');

            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                if (password.length >= 8) strength += 1;
                if (password.match(/[A-Z]/)) strength += 1;
                if (password.match(/[0-9]/)) strength += 1;
                if (password.match(/[^A-Za-z0-9]/)) strength += 1;

                // Update strength bar
                strengthBar.className = 'password-strength-bar';
                if (strength === 0) {
                    strengthBar.style.width = '0';
                    feedback.textContent = 'Password strength';
                } else if (strength <= 2) {
                    strengthBar.classList.add('strength-weak');
                    feedback.textContent = 'Weak password';
                    feedback.style.color = '#ef4444';
                } else if (strength === 3) {
                    strengthBar.classList.add('strength-medium');
                    feedback.textContent = 'Medium strength password';
                    feedback.style.color = '#f59e0b';
                } else {
                    strengthBar.classList.add('strength-strong');
                    feedback.textContent = 'Strong password';
                    feedback.style.color = '#10b981';
                }
            });

            // Password confirmation match
            const confirmInput = document.getElementById('password_confirmation');
            confirmInput.addEventListener('input', function() {
                if (passwordInput.value === this.value) {
                    this.style.borderColor = '#10b981';
                    this.style.boxShadow = '0 0 0 4px rgba(16, 185, 129, 0.1)';
                } else {
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                }
            });
        });
    </script>
</body>
</html>
