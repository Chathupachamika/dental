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

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #0ea5e9;
            --secondary-dark: #0284c7;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
        }

        .verify-container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .verify-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 500px;
            padding: 3rem;
            position: relative;
            z-index: 10;
        }

        .verify-heading {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 0.5rem;
        }

        .verify-subheading {
            color: #64748b;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .btn {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-link {
            background: none;
            color: var(--primary);
            text-decoration: underline;
            padding: 0;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
        }

        .shape-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            left: -150px;
        }

        .shape-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -200px;
            right: -200px;
        }

        @media (max-width: 576px) {
            .verify-card {
                width: 90%;
                padding: 2rem;
            }

            .actions {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="shape-1"></div>
        <div class="shape-2"></div>

        <div class="verify-card">
            <div class="verify-heading">Verify Your Email</div>
            <div class="verify-subheading">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" role="alert">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="actions">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i> Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
