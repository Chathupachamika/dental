<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        .login-title {
            text-align: center;
            color: white;
            font-weight: bold;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 1.2px;
            position: relative;
            padding-bottom: 1rem;
        }

        .login-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #6eb884, #a4eaeb);
            border-radius: 2px;
        }

        .transparent-input {
            background-color: rgba(255, 255, 255, 0.5);
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.5px;
        }

        .transparent-input::placeholder {
            color: rgba(0, 0, 0, 0.5);
            transition: color 0.3s ease;
        }

        .transparent-input:focus::placeholder {
            color: rgba(0, 0, 0, 0.7);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #4a5568;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .input-with-icon {
            padding-left: 2.5rem;
        }

        .forgot-password-link {
            color: #ffffff;
            position: relative;
            overflow: hidden;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .forgot-password-link:hover {
            color: #6eb884;
        }

        .forgot-password-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #6eb884;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .forgot-password-link:hover::before {
            transform: translateX(0);
        }

        .register-link {
            color: #ffffff;
            position: relative;
            overflow: hidden;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .register-link:hover {
            color: #6e9cb8;
        }


        .input-type-label {
            color: #a4eaeb;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
            display: block;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .primary-button {
            transition: all 0.3s ease;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.025em;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #e3342f;
            color: white;
        }

        .primary-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #fff;
            color: #333;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .or-divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #fff;
            margin: 1rem 0;
        }

        .or-divider::before,
        .or-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #fff;
        }

        .or-divider::before {
            margin-right: .5em;
        }

        .or-divider::after {
            margin-left: .5em;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        form {
            animation: fadeInUp 0.5s ease-out;
        }

        @media (max-width: 768px) {
            .login-title {
                font-size: 2rem;
            }

            .login-title::after {
                width: 40px;
            }

            .transparent-input {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 480px) {
            .login-title {
                font-size: 1.75rem;
            }

            form {
                padding: 1.25rem;
            }

            .ms-3 {
                width: 100%;
                margin-top: 1rem;
            }

            .forgot-password-link,
            .register-link {
                display: block;
                text-align: center;
                margin-bottom: 1rem;
            }
        }
    </style>

    <form method="POST" action="{{ route('login') }}" class="p-6 rounded-lg space-y-6">
        @csrf

        <div class="login-title">
            Log In <i class="fas fa-sign-in-alt ml-2"></i>
        </div>

        <div class="mb-6">
            <span class="input-type-label">Email</span>
            <div class="relative">
                <i class="fas fa-envelope input-icon"></i>
                <x-text-input
                    id="email"
                    class="block mt-1 w-full transparent-input text-black input-with-icon"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter your email address"
                    title="Email Address"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-white" />
        </div>

        <div class="mb-6">
            <span class="input-type-label">Password</span>
            <div class="relative">
                <i class="fas fa-lock input-icon"></i>
                <x-text-input
                    id="password"
                    class="block mt-1 w-full transparent-input text-black input-with-icon pr-10"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    title="Password"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-white" />
        </div>

        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center text-white text-lg">
                <input id="remember_me" type="checkbox" class="rounded border-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm forgot-password-link rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 primary-button">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="or-divider">or</div>

        <div class="social-login">
            <a href="#" class="social-button">
                <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-button">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-button">
                <i class="fab fa-instagram"></i>
            </a>
        </div>

        <div class="text-center">
            <a href="{{ route('register') }}" class="register-link">
                {{ __("Don't have an account? Register") }}
            </a>
        </div>
    </form>
</x-guest-layout>
