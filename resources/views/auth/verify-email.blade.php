<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dental Management') }} - Verify Email</title>

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
            max-width: 500px;
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

        .btn-link {
            background: none;
            color: var(--primary);
            text-decoration: underline;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .btn-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-icon {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            line-height: 1.5;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-icon {
            font-size: 1.25rem;
            margin-top: 0.125rem;
        }

        /* Actions Container */
        .actions-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            gap: 1rem;
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

            .btn {
                padding: 0.75rem 1.25rem;
                font-size: 0.875rem;
            }

            .actions-container {
                flex-direction: column;
                gap: 1rem;
            }

            .actions-container .btn {
                width: 100%;
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

        /* Email Verification Illustration */
        .email-illustration {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .email-icon {
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
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(37, 99, 235, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
            }
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

    <div class="w-full max-w-lg mx-auto px-4">
        <div class="auth-card animate-fade-in">
            <div class="email-illustration animate-slide-up">
                <div class="email-icon">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="auth-heading animate-slide-up">Verify Your Email</div>
            <div class="auth-subheading animate-slide-up">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success animate-slide-up" role="alert">
                    <i class="fas fa-check-circle alert-icon"></i>
                    <div>A new verification link has been sent to the email address you provided during registration.</div>
                </div>
            @endif

            <div class="actions-container animate-slide-up">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fas fa-paper-plane btn-icon"></i> Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="btn btn-link w-full">
                        <i class="fas fa-sign-out-alt btn-icon"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add subtle animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('form, .alert');
            formElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    element.style.transition = 'all 0.5s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 300 + (index * 100));
            });
        });
    </script>
</body>
</html>
