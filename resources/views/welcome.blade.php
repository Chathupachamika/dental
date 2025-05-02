<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dental Clinic</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="text-2xl font-bold text-sky-600">
                        <img src="{{ asset('images/logo.png') }}" alt="DentalCare" class="h-12">
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-600 hover:text-sky-600 transition">Home</a>
                    <a href="#services" class="text-gray-600 hover:text-sky-600 transition">Services</a>
                    <a href="#about" class="text-gray-600 hover:text-sky-600 transition">About</a>
                    <a href="#contact" class="text-gray-600 hover:text-sky-600 transition">Contact</a>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-sky-600 text-white px-6 py-2 rounded-full hover:bg-sky-700 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sky-600 hover:text-sky-700 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-sky-600 text-white px-6 py-2 rounded-full hover:bg-sky-700 transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-12 bg-gradient-to-b from-sky-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Your Smile, Our Passion
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Welcome to DentalCare, where we provide exceptional dental care with a gentle touch. Your oral health and beautiful smile are our top priorities.
                    </p>
                    <div class="space-x-4">
                        <a href="#appointment" class="bg-sky-600 text-white px-8 py-3 rounded-full hover:bg-sky-700 transition inline-block">
                            Book Appointment
                        </a>
                        <a href="#services" class="border border-sky-600 text-sky-600 px-8 py-3 rounded-full hover:bg-sky-50 transition inline-block">
                            Our Services
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=800" alt="Dental Care" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Services</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    We offer a comprehensive range of dental services to keep your smile healthy and beautiful.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">General Dentistry</h3>
                    <p class="text-gray-600">Comprehensive dental care including check-ups, cleanings, and preventive treatments.</p>
                </div>

                <!-- Service Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cosmetic Dentistry</h3>
                    <p class="text-gray-600">Enhance your smile with whitening, veneers, and other cosmetic procedures.</p>
                </div>

                <!-- Service Card 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Orthodontics</h3>
                    <p class="text-gray-600">Straighten your teeth with braces and modern alignment solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-sky-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="hidden md:block">
                    <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=800" alt="Dental Team" class="rounded-lg shadow-lg object-cover h-[500px] w-full">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">About Our Practice</h2>
                    <div class="space-y-4">
                        <p class="text-gray-600">
                            Welcome to DentalCare, where we've been creating beautiful smiles since 2010. Our state-of-the-art facility combines modern technology with comfortable care to provide you with the best dental experience possible.
                        </p>
                        <p class="text-gray-600">
                            Our team of experienced dentists and staff are dedicated to providing personalized care that meets your unique needs. We believe in preventive care and patient education to maintain optimal oral health.
                        </p>

                        <div class="grid grid-cols-2 gap-6 mt-8">
                            <div class="text-center p-4 bg-white rounded-lg shadow-md">
                                <div class="text-sky-600 text-2xl font-bold mb-2">15+</div>
                                <div class="text-gray-600">Years Experience</div>
                            </div>
                            <div class="text-center p-4 bg-white rounded-lg shadow-md">
                                <div class="text-sky-600 text-2xl font-bold mb-2">10k+</div>
                                <div class="text-gray-600">Happy Patients</div>
                            </div>
                            <div class="text-center p-4 bg-white rounded-lg shadow-md">
                                <div class="text-sky-600 text-2xl font-bold mb-2">98%</div>
                                <div class="text-gray-600">Satisfaction Rate</div>
                            </div>
                            <div class="text-center p-4 bg-white rounded-lg shadow-md">
                                <div class="text-sky-600 text-2xl font-bold mb-2">25+</div>
                                <div class="text-gray-600">Expert Doctors</div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-xl font-semibold mb-4">Why Choose Us?</h3>
                            <ul class="space-y-3">
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-sky-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Advanced Technology & Modern Facility
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-sky-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Experienced & Caring Team
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-sky-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Comfortable & Relaxing Environment
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-sky-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Personalized Treatment Plans
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-sky-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Contact Us</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Have questions? Get in touch with us for any inquiries or to schedule an appointment.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Get in Touch</h3>
                    <form>
                        <div class="mb-4">
                            <input type="text" placeholder="Your Name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div class="mb-4">
                            <input type="email" placeholder="Email Address" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div class="mb-4">
                            <textarea placeholder="Your Message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-sky-600 text-white px-6 py-3 rounded-md hover:bg-sky-700 transition">
                            Send Message
                        </button>
                    </form>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Contact Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-sky-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-gray-600">123 Dental Street, Medical City, 12345</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-sky-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <p class="text-gray-600">(555) 123-4567</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-sky-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-600">info@dentalcare.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-xl font-bold mb-4">DentalCare</h4>
                    <p class="text-gray-400">Providing quality dental care for your entire family.</p>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Services</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition">About</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Opening Hours</h4>
                    <ul class="space-y-2">
                        <li class="text-gray-400">Monday - Friday: 9:00 AM - 6:00 PM</li>
                        <li class="text-gray-400">Saturday: 9:00 AM - 4:00 PM</li>
                        <li class="text-gray-400">Sunday: Closed</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2025 DentalCare. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
