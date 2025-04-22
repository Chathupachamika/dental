<x-guest-layout>
    <style>
        /* Existing styles remain unchanged */
        .register-title {
            text-align: center;
            color: white;
            font-weight: bold;
            font-size: 2.2rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 1.2px;
            position: relative;
            padding-bottom: 1rem;
        }

        .register-title::after {
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
            font-size: 0.95rem;
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
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
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-with-icon {
            padding-left: 2.5rem;
        }

        .login-link {
            color: #ffffff;
            position: relative;
            overflow: hidden;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .login-link:hover {
            color: #6eb884;
        }

        .login-link::before {
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

        .login-link:hover::before {
            transform: translateX(0);
        }

        .input-type-label {
            color: #a4eaeb;
            font-size: 0.8rem;
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
            font-size: 1.1rem;
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
            .register-title {
                font-size: 1.8rem;
            }

            .transparent-input {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .register-title {
                font-size: 1.6rem;
            }

            form {
                padding: 1.25rem;
            }

            .ms-3 {
                width: 100%;
                margin-top: 1rem;
            }

            .login-link {
                display: block;
                text-align: center;
                margin-bottom: 1rem;
            }
        }

        .mb-6 {
            margin-bottom: 1rem;
        }

        form.space-y-6 {
            --tw-space-y-reverse: 0;
            margin-top: calc(1.25rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(1.25rem * var(--tw-space-y-reverse));
        }
    </style>

    <form method="POST" action="{{ route('register') }}" class="p-6 rounded-lg space-y-6">
        @csrf

        <div class="register-title">
            Register <i class="fas fa-user-plus ml-2"></i>
        </div>

        <div class="mb-6">
            <span class="input-type-label">Name</span>
            <div class="relative">
                <i class="fas fa-user input-icon"></i>
                <x-text-input
                    id="name"
                    class="block mt-1 w-full transparent-input text-black input-with-icon"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter your full name"
                />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-white" />
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
                    autocomplete="username"
                    placeholder="Enter your email address"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-white" />
        </div>

        <div class="mb-6">
            <span class="input-type-label">Mobile Number</span>
            <div class="relative">
                <i class="fas fa-phone input-icon"></i>
                <x-text-input
                    id="mobile_number"
                    class="block mt-1 w-full transparent-input text-black input-with-icon"
                    type="tel"
                    name="mobile_number"
                    :value="old('mobile_number')"
                    required
                    autocomplete="tel"
                    placeholder="Enter your mobile number"
                    pattern="[0-9]{10}"
                    title="Please enter a 10-digit mobile number"
                />
            </div>
            <x-input-error :messages="$errors->get('mobile_number')" class="mt-2 text-white" />
        </div>

        <div class="mb-6">
            <span class="input-type-label">Password</span>
            <div class="relative">
                <i class="fas fa-lock input-icon"></i>
                <x-text-input
                    id="password"
                    class="block mt-1 w-full transparent-input text-black input-with-icon"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Create a password"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-white" />
        </div>

        <div class="mb-6">
            <span class="input-type-label">Confirm Password</span>
            <div class="relative">
                <i class="fas fa-lock input-icon"></i>
                <x-text-input
                    id="password_confirmation"
                    class="block mt-1 w-full transparent-input text-black input-with-icon"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm your password"
                />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-white" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm login-link rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
                <i class="fas fa-long-arrow-right ml-1"></i>
                <span class="sr-only">{{ __('Login') }}</span>
            </a>

            <x-primary-button class="ms-3 primary-button">
                {{ __('Register') }}
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
    </form>
</x-guest-layout>
