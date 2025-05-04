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
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards',
                        'slide-right': 'slideRight 0.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideRight: {
                            '0%': { transform: 'translateX(-20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                    },
                },
            },
        }
    </script>
    <style>
        /* Animated Background */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(10px) rotate(-5deg); }
            75% { transform: translateY(-15px) rotate(3deg); }
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

        /* Form Input Animation */
        .form-input:focus + .input-icon {
            color: #0ea5e9;
            transform: translateY(-50%) scale(1.1);
        }

        /* Update the icon positioning to ensure proper vertical alignment */
        .input-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        /* Button Ripple Effect */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }

        .btn-ripple::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.3) 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform 0.5s, opacity 0.5s;
        }

        .btn-ripple:active::after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }

        /* Invalid Feedback */
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #ef4444;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-primary-400 to-primary-700 min-h-screen flex items-center justify-center p-4">
    <!-- Animated Background Shapes -->
    <div class="fixed inset-0 overflow-hidden -z-10">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <div class="w-full max-w-6xl mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row animate-fade-in">
            <!-- Login Form Section -->
            <div class="w-full md:w-2/5 p-8 md:p-12">
                <div class="text-center md:text-left mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 animate-slide-up" style="animation-delay: 0.1s">Welcome Back!</h1>
                    <p class="text-gray-500 text-sm md:text-base animate-slide-up" style="animation-delay: 0.2s">Please sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="relative animate-slide-up" style="animation-delay: 0.3s">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all duration-300 @error('email') border-red-500 @enderror"
                               name="email" value="{{ old('email') }}"
                               placeholder="Email address" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="relative animate-slide-up" style="animation-delay: 0.4s">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all duration-300 @error('password') border-red-500 @enderror"
                               name="password" placeholder="Password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between animate-slide-up" style="animation-delay: 0.5s">
                        <label class="flex items-center space-x-2 text-sm text-gray-500 cursor-pointer group">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition-all duration-300">
                            <span class="group-hover:text-primary-600 transition-colors duration-300">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors duration-300">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-primary-500 to-primary-700 text-white py-3 rounded-lg font-medium shadow-lg hover:shadow-primary-500/50 transform hover:-translate-y-0.5 transition-all duration-300 animate-slide-up" style="animation-delay: 0.6s">
                        Sign In
                    </button>
                </form>

                <div class="relative flex items-center justify-center my-6 animate-slide-up" style="animation-delay: 0.7s">
                    <div class="flex-grow h-px bg-gray-200"></div>
                    <span class="mx-4 text-sm text-gray-400">or continue with</span>
                    <div class="flex-grow h-px bg-gray-200"></div>
                </div>

                <div class="grid grid-cols-2 gap-4 animate-slide-up" style="animation-delay: 0.8s">
                    <a href="#" class="flex items-center justify-center gap-2 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300">
                        <i class="fab fa-google text-red-500"></i>
                        <span class="text-sm font-medium text-gray-700">Google</span>
                    </a>
                    <a href="#" class="flex items-center justify-center gap-2 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300">
                        <i class="fab fa-facebook-f text-blue-600"></i>
                        <span class="text-sm font-medium text-gray-700">Facebook</span>
                    </a>
                </div>

                <div class="text-center mt-8 text-sm text-gray-500 animate-slide-up" style="animation-delay: 0.9s">
                    Don't have an account? <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-800 transition-colors duration-300">Sign up</a>
                </div>
            </div>

            <!-- Image Section -->
            <div class="hidden md:block md:w-3/5 bg-primary-600 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600/80 to-primary-800/80 z-10"></div>
                <img src="{{ asset('images/dental-checkup.jpg') }}" alt="Dental Care" class="absolute inset-0 w-full h-full object-cover object-center scale-105 animate-fade-in" style="animation-delay: 0.3s">

                <div class="relative z-20 flex flex-col justify-center h-full p-12 text-white animate-slide-right" style="animation-delay: 0.5s">
                    <div class="mb-6 inline-block p-3 bg-white/10 backdrop-blur-sm rounded-2xl">
                        <i class="fas fa-tooth text-4xl"></i>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Expert Dental Care</h2>
                    <p class="text-white/80 text-lg mb-8 max-w-md">Providing quality dental services with modern technology and experienced professionals for your perfect smile.</p>

                    <div class="flex items-center space-x-4 mt-auto">
                        <div class="flex -space-x-2">
                            <img src="{{ asset('images/avatar-1.jpg') }}" alt="Patient" class="w-10 h-10 rounded-full border-2 border-white">
                            <img src="{{ asset('images/avatar-2.jpg') }}" alt="Patient" class="w-10 h-10 rounded-full border-2 border-white">
                            <img src="{{ asset('images/avatar-3.jpg') }}" alt="Patient" class="w-10 h-10 rounded-full border-2 border-white">
                        </div>
                        <div class="text-sm">
                            <p class="font-medium">Trusted by 10,000+ patients</p>
                            <div class="flex items-center mt-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="ml-1">5.0 (2,500+ reviews)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add subtle animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            // Check for mobile devices
            const isMobile = window.innerWidth < 768;

            // Add placeholder images if real images aren't available
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.onerror = function() {
                    this.src = `https://via.placeholder.com/${this.width}x${this.height}?text=Dental+Care`;
                };
            });

            // Add focus and blur events for form inputs
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    const icon = this.parentNode.querySelector('.fas');
                    if (icon) {
                        icon.classList.add('text-primary-500');
                    }
                });

                input.addEventListener('blur', function() {
                    if (!this.value) {
                        const icon = this.parentNode.querySelector('.fas');
                        if (icon) {
                            icon.classList.remove('text-primary-500');
                        }
                    }
                });
            });

            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('.btn-ripple');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const rect = button.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.width = '1px';
                    ripple.style.height = '1px';
                    ripple.style.borderRadius = '50%';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.style.animation = 'ripple 0.6s linear';

                    button.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
</body>
</html>
