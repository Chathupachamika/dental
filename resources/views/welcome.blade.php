<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CASONS - The Best Car Rental</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .brand-logo {
            font-family: 'Orbitron', sans-serif;
            background: linear-gradient(135deg, #fff 0%, #e2e8f0 50%, #94a3b8 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            letter-spacing: 0.1em;
            transform: scale(1);
            transition: all 0.3s ease;
            position: relative;
        }

        .brand-logo:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #fff 0%, #f1f5f9 50%, #cbd5e1 100%);
            -webkit-background-clip: text;
            background-clip: text;
        }

        .brand-logo::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            filter: blur(5px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .brand-logo:hover::after {
            opacity: 1;
        }

        .gradient-overlay {
            background: linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.4));
        }

        .car-card {
            background: rgba(17, 25, 40, 0.75);
            backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(236, 72, 153, 0.3);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(236, 72, 153, 0.3);
        }

        .process-card {
            background: rgba(17, 25, 40, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .process-card:hover {
            transform: scale(1.02);
            border-color: rgba(236, 72, 153, 0.3);
        }

        .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.5) !important;
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: linear-gradient(to right, #ec4853, #500101) !important;
            width: 24px;
            border-radius: 5px;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: white !important;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            display: none;
        }

        .gradient-text {
            background: linear-gradient(to right, #ed354d, #500101);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(to right, #ed354d, #500101);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .custom-shape-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .custom-shape-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 150px;
        }

        .custom-shape-divider .shape-fill {
            fill: #111827;
        }

        .scroll-indicator {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-gray-900/90 backdrop-blur-lg border-b border-white/10">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-12">
                    <a href="/" class="brand-logo text-4xl font-extrabold tracking-wider">CASONS</a>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#featured-cars" class="nav-link text-gray-300 hover:text-white text-base font-medium">Cars</a>
                        <a href="#features" class="nav-link text-gray-300 hover:text-white text-base font-medium">Features</a>
                        <a href="#process" class="nav-link text-gray-300 hover:text-white text-base font-medium">How It Works</a>
                        <a href="#contact" class="nav-link text-gray-300 hover:text-white text-base font-medium">Contact</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/login" class="text-gray-300 hover:text-white">Login</a>
                    <a href="/register" class="px-6 py-2 bg-gradient-to-r from-red-500 to-red-900 rounded-full font-semibold hover:opacity-90 transition-all duration-300">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <div class="swiper-container heroSwiper h-screen">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="/images/guest/luxurycar.png"
                         alt="Luxury Car"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-start px-8 lg:px-24">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl lg:text-7xl font-bold mb-6 text-white leading-tight">
                            Drive Your <span class="gradient-text">Dreams</span>
                        </h1>
                        <p class="text-xl text-gray-200 mb-8 max-w-2xl">
                            Experience luxury and performance with our premium car collection
                        </p>
                        <div class="flex gap-4">
                            <a href="#browse-cars"
                               class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-500 to-red-900 text-white rounded-full font-semibold hover:opacity-90 transition-all duration-300">
                                <span>Explore Cars</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                            <a href="#how-it-works"
                               class="group inline-flex items-center px-8 py-4 bg-white/10 text-white rounded-full font-semibold hover:bg-white/20 backdrop-blur-sm transition-all duration-300">
                                <span>How It Works</span>
                                <i class="fas fa-info-circle ml-2 group-hover:rotate-12 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Scroll Indicator -->
                <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 scroll-indicator">
                    <i class="fas fa-chevron-down text-white/70 text-2xl"></i>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="/images/guest/sportscar.png"
                         alt="Sports Car"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-start px-8 lg:px-24">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl lg:text-7xl font-bold mb-6 text-white leading-tight">
                            Luxury at Your <span class="gradient-text">Fingertips</span>
                        </h1>
                        <p class="text-xl text-gray-200 mb-8 max-w-2xl">
                            Choose from our extensive collection of premium vehicles
                        </p>
                        <div class="flex gap-4">
                            <a href="#featured-cars"
                               class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-500 to-red-900 text-white rounded-full font-semibold hover:opacity-90 transition-all duration-300">
                                <span>View Collection</span>
                                <i class="fas fa-car ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="/images/guest/luxury.png"
                         alt="Luxury Interior"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-start px-8 lg:px-24">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl lg:text-7xl font-bold mb-6 text-white leading-tight">
                            Experience Pure <span class="gradient-text">Luxury</span>
                        </h1>
                        <p class="text-xl text-gray-200 mb-8 max-w-2xl">
                            Premium vehicles with exceptional service
                        </p>
                        <div class="flex gap-4">
                            <a href="#contact"
                               class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-500 to-red-900 text-white rounded-full font-semibold hover:opacity-90 transition-all duration-300">
                                <span>Contact Us</span>
                                <i class="fas fa-phone ml-2 group-hover:rotate-12 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Custom Navigation -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 flex items-center gap-4">
            <button class="swiper-button-prev w-12 h-12 backdrop-blur-sm flex items-center justify-center hover:bg-white/20 transition-all duration-300">

            </button>
            <div class="swiper-pagination"></div>
            <button class="swiper-button-next w-12 h-12 backdrop-blur-sm flex items-center justify-center hover:bg-white/20 transition-all duration-300">

            </button>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                    Why Choose <span class="gradient-text">CASONS</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-purple-600 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="feature-card rounded-xl p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-red-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-car-side text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Premium Fleet</h3>
                    <p class="text-gray-400">Luxury and sports cars maintained to perfection</p>
                </div>

                <div class="feature-card rounded-xl p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-red-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">24/7 Support</h3>
                    <p class="text-gray-400">Round-the-clock assistance for your convenience</p>
                </div>

                <div class="feature-card rounded-xl p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-red-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Fully Insured</h3>
                    <p class="text-gray-400">Comprehensive coverage for peace of mind</p>
                </div>

                <div class="feature-card rounded-xl p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-red-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Flexible Pickup</h3>
                    <p class="text-gray-400">Convenient locations for your comfort</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Cars Section -->
    <section id="featured-vehicles" class="py-20 bg-gray-800/50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 slide-in">
                <h2 class="text-4xl font-bold">Our Top <span class="text-red-500">Vehicles</span></h2>
                <p class="text-gray-400 mt-2">Explore the most popular cars from our fleet</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($vehicles ?? [] as $vehicle)
                    <div class="vehicle-card bg-gray-900/50 backdrop-blur-lg rounded-xl overflow-hidden border border-gray-800/50 hover:border-red-500/50 transition-all duration-300 hover:transform hover:-translate-y-2 group">
                        <div class="relative">
                            <img src="{{ asset('storage/' . (json_decode($vehicle->image)[0] ?? 'cars/default.jpg')) }}"
                                 alt="{{ $vehicle->model }}"
                                 class="w-full h-56 object-cover transform group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent opacity-80"></div>
                            <span class="absolute top-4 right-4 px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                {{ $vehicle->car_type }}
                            </span>
                            <div class="absolute bottom-4 left-4">
                                <span class="px-2 py-1 bg-gray-900/70 text-white text-xs rounded-full">
                                    {{ $vehicle->transmission_type }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-1">{{ $vehicle->model }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $vehicle->category }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-red-500 font-bold">${{ number_format($vehicle->daily_rate, 2) }}</p>
                                    <p class="text-gray-500 text-xs">per day</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center gap-2 text-gray-300">
                                    <i class="fas fa-user-friends text-red-500"></i>
                                    <span>{{ $vehicle->number_of_passenger }} Seats</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <i class="fas fa-gas-pump text-red-500"></i>
                                    <span>{{ $vehicle->fuel }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <i class="fas fa-road text-red-500"></i>
                                    <span>{{ $vehicle->free_mileage }}km/day</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <i class="fas fa-calendar text-red-500"></i>
                                    <span>{{ $vehicle->year }}</span>
                                </div>
                            </div>
                            <div class="pt-4">
                                <a href="/login" class="block w-full text-center bg-gradient-to-r from-red-600 to-red-800 text-white py-3 rounded-lg font-semibold hover:from-red-700 hover:to-red-900 transform hover:scale-[1.02] transition-all duration-300 shadow-lg hover:shadow-red-500/25">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-car-side text-4xl text-gray-600 mb-4"></i>
                        <p class="text-gray-500">No vehicles available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="process" class="py-20 bg-gray-900 relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                    How It <span class="gradient-text">Works</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-purple-600 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="process-card rounded-xl p-8 text-center relative">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-gradient-to-r from-red-500 to-purple-600 rounded-full flex items-center justify-center text-2xl font-bold">1</div>
                    <div class="mb-6">
                        <i class="fas fa-search text-4xl text-red-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Choose Your Car</h3>
                    <p class="text-gray-400">Browse our collection and select your perfect ride</p>
                </div>

                <div class="process-card rounded-xl p-8 text-center relative">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-gradient-to-r from-red-500 to-purple-600 rounded-full flex items-center justify-center text-2xl font-bold">2</div>
                    <div class="mb-6">
                        <i class="fas fa-calendar-alt text-4xl text-red-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Make Reservation</h3>
                    <p class="text-gray-400">Select your dates and complete the booking</p>
                </div>

                <div class="process-card rounded-xl p-8 text-center relative">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-gradient-to-r from-red-500 to-purple-600 rounded-full flex items-center justify-center text-2xl font-bold">3</div>
                    <div class="mb-6">
                        <i class="fas fa-key text-4xl text-red-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Enjoy Your Ride</h3>
                    <p class="text-gray-400">Pick up your car and enjoy the luxury experience</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-900/50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                    Get in <span class="gradient-text">Touch</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-purple-600 mx-auto"></div>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="car-card rounded-xl p-8">
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-300 mb-2">Name</label>
                                <input type="text" class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-red-500 transition-colors duration-300">
                            </div>
                            <div>
                                <label class="block text-gray-300 mb-2">Email</label>
                                <input type="email" class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-red-500 transition-colors duration-300">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Message</label>
                            <textarea rows="4" class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-red-500 transition-colors duration-300"></textarea>
                        </div>
                        <button type="submit" class="w-full px-8 py-4 bg-gradient-to-r from-red-500 to-purple-600 text-white rounded-full font-semibold hover:opacity-90 transition-all duration-300">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold gradient-text mb-4">CASONS</h3>
                    <p class="text-gray-400">Experience luxury and performance with our premium car collection.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Services</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Cars</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Contact Info</h4>
                    <ul class="space-y-2">
                        <li class="text-gray-400"><i class="fas fa-map-marker-alt mr-2 text-red-500"></i> 123 Luxury Street, CA 90210</li>
                        <li class="text-gray-400"><i class="fas fa-phone mr-2 text-red-500"></i> +1 234 567 8900</li>
                        <li class="text-gray-400"><i class="fas fa-envelope mr-2 text-red-500"></i> info@casons.com</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2025 CASONS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Hero Swiper
        new Swiper(".heroSwiper", {
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        // Cars Swiper
        new Swiper(".carSwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
                1280: {
                    slidesPerView: 4,
                },
            },
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar Scroll Effect
        const navbar = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 0) {
                navbar.classList.add('border-b', 'border-white/10');
            } else {
                navbar.classList.remove('border-b', 'border-white/10');
            }
        });
    </script>
</body>
</html>
