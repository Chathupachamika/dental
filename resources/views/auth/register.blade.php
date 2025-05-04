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
                        'slide-left': 'slideLeft 0.5s ease-out forwards',
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
                        slideLeft: {
                            '0%': { transform: 'translateX(20px)', opacity: '0' },
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

        /* Password Strength Meter */
        .password-strength {
            height: 4px;
            border-radius: 4px;
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
            background-color: #ef4444;
        }

        .strength-medium {
            width: 66.66%;
            background-color: #f59e0b;
        }

        .strength-strong {
            width: 100%;
            background-color: #10b981;
        }

        .password-feedback {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            color: #64748b;
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
            <!-- Image Section -->
            <div class="hidden md:block md:w-3/5 bg-primary-600 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600/80 to-primary-800/80 z-10"></div>
                <img src="{{ asset('images/dental-consultation.jpg') }}" alt="Dental Care" class="absolute inset-0 w-full h-full object-cover object-center scale-105 animate-fade-in" style="animation-delay: 0.3s">

                <div class="relative z-20 flex flex-col justify-center h-full p-12 text-white animate-slide-left" style="animation-delay: 0.5s">
                    <div class="mb-6 inline-block p-3 bg-white/10 backdrop-blur-sm rounded-2xl">
                        <i class="fas fa-user-plus text-4xl"></i>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Join Our Dental Family</h2>
                    <p class="text-white/80 text-lg mb-8 max-w-md">Experience world-class dental care with our team of expert professionals dedicated to your oral health.</p>

                    <div class="space-y-4 mt-auto">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-full">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span>Personalized treatment plans</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-full">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span>Online appointment booking</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-full">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span>Digital treatment records</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Register Form Section -->
            <div class="w-full md:w-2/5 p-8 md:p-12">
                <div class="text-center md:text-left mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 animate-slide-up" style="animation-delay: 0.1s">Create Account</h1>
                    <p class="text-gray-500 text-sm md:text-base animate-slide-up" style="animation-delay: 0.2s">Join DentalCare to get started</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="relative animate-slide-up" style="animation-delay: 0.3s">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all duration-300 @error('name') border-red-500 @enderror"
                               name="name" value="{{ old('name') }}"
                               placeholder="Full Name" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="relative animate-slide-up" style="animation-delay: 0.4s">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all duration-300 @error('email') border-red-500 @enderror"
                               name="email" value="{{ old('email') }}"
                               placeholder="Email Address" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="relative animate-slide-up" style="animation-delay: 0.5s">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="tel" class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all duration-300 @error('phone') border-red-500 @enderror"
                               name="phone" value="{{ old('phone') }}"
                               placeholder="Phone Number">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="relative animate-slide-up" style="animation-delay: 0.6s">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 input-icon"></i>
                        </div>
                        <input type="password" id="password" class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all duration-300 @error('password') border-red-500 @enderror"
                               name="password" placeholder="Password" required>



                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                    </div>

                    <div class="relative animate-slide-up" style="animation-delay: 0.7s">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 input-icon"></i>
                        </div>
                        <input type="password" id="password_confirmation" class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all duration-300"
                               name="password_confirmation"
                               placeholder="Confirm Password" required>
                    </div>

                    <div class="flex items-center animate-slide-up" style="animation-delay: 0.8s">
                        <input type="checkbox" id="terms" name="terms" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition-all duration-300">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-primary-600 hover:text-primary-800">Terms of Service</a> and <a href="#" class="text-primary-600 hover:text-primary-800">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-primary-500 to-primary-700 text-white py-3 rounded-lg font-medium shadow-lg hover:shadow-primary-500/50 transform hover:-translate-y-0.5 transition-all duration-300 animate-slide-up" style="animation-delay: 0.9s">
                        Create Account
                    </button>
                </form>

                <div class="text-center mt-8 text-sm text-gray-500 animate-slide-up" style="animation-delay: 1s">
                    Already have an account? <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-800 transition-colors duration-300">Sign in</a>
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
                    feedback.style.color = '#64748b';
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
