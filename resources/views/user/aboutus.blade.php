@extends('layouts.user-layout')

@section('title', 'CASONS - About Us')

@section('styles')
<style>

    .container {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease-out forwards;
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

            #animated-heading {
                position: relative;
                border-right: 3px solid transparent;
                white-space: nowrap;
                overflow: hidden;
                animation: cursor-blink 1s step-end infinite;
            }

            #animated-subheading {
                position: relative;
                overflow: hidden;
                opacity: 0;
                transform: translateY(10px);
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            #animated-subheading.visible {
                opacity: 1;
                transform: translateY(0);
            }

            #view-fleet-btn {
                background: linear-gradient(135deg, #fc1010, #380606);

            }
            #view-fleet-btn:hover {
                background: linear-gradient(135deg, #b50c0c, #2a0404);
            }

            @keyframes cursor-blink {
                0%, 100% { border-color: transparent; }
                50% { border-color: #f8fafc; }
            }

            .section-fade-in {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.8s ease, transform 0.8s ease;
            }

            .section-fade-in.visible {
                opacity: 1;
                transform: translateY(0);
            }

            .feature-card {
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }

            .feature-card:hover {
                transform: translateY(-15px);
                box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            }

            .feature-card:hover i {
                transform: scale(1.2);
            }

            .feature-card i {
                transition: transform 0.3s ease;
            }

            .gradient-text {
                background: linear-gradient(45deg, #F06D6D, #EA2F2F, #A42121);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                display: inline-block;
            }

            .stat-highlight {
                position: relative;
                overflow: hidden;
            }

            .stat-highlight::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: linear-gradient(90deg, transparent, currentColor, transparent);
                transition: transform 0.3s ease;
                transform: scaleX(0);
            }

            .stat-highlight:hover::after {
                transform: scaleX(1);
            }

            .scroll-indicator {
                opacity: 1;
                transition: opacity 0.5s ease;
                z-index: 10;
                position: relative;
                width: 40px; /* Added width to contain the arrows */
            }

            .scroll-indicator.hide {
                opacity: 0;
            }

            .arrow-1, .arrow-2, .arrow-3 {
                animation: fadeInOut 2s infinite;
                transform: translateX(0);
                position: absolute;
            }

            .arrow-1 {
                left: 0;
            }

            .arrow-2 {
                animation-delay: 0.2s;
                left: 15px; /* Increased spacing */
            }

            .arrow-3 {
                animation-delay: 0.4s;
                left: 30px; /* Increased spacing */
            }

            @keyframes fadeInOut {
                0% {
                    opacity: 0;
                    transform: translateX(-15px); /* Increased animation distance */
                }
                50% {
                    opacity: 1;
                    transform: translateX(0);
                }
                100% {
                    opacity: 0;
                    transform: translateX(15px); /* Increased animation distance */
                }
            }

            /* Updated hide arrows animation with increased distance */
            .scroll-progress-33 .arrow-1 {
                opacity: 0;
                transform: translateX(15px);
            }

            .scroll-progress-66 .arrow-2 {
                opacity: 0;
                transform: translateX(15px);
            }

            .scroll-progress-100 .arrow-3 {
                opacity: 0;
                transform: translateX(15px);
            }

            /* Rest of the styles remain unchanged */
            .hero-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1;
            }

            .hero-content {
                position: relative;
                z-index: 2;
            }
            .hero-overlay {
                background: linear-gradient(to bottom, rgba(17, 24, 39, 0.7), rgba(17, 24, 39, 0.9));
                position: absolute;
                inset: 0;
                z-index: 1;
            }

            .hero-content {
                position: relative;
                z-index: 2;
            }
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
@endsection
@include('scroll-indicator.scroll-indicator')
@section('content')
<section class="relative h-[500px]">
    <div class="absolute inset-0">
        <img src="/images/user/carousel/3.png"
             alt="Luxury Cars"
             class="w-full h-full object-cover ">
    </div>

    <div class="relative mx-auto px-6 h-full flex items-center">
        <div>
            <h1 id="animated-heading" class="text-5xl font-bold mb-4"></h1>
            <p id="animated-subheading" class="text-xl text-gray-300"></p>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-10 bg-gray-800">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-12">
            <div class="text-center p-6 bg-gray-900 rounded-lg shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                <i class="fas fa-car-side text-4xl text-blue-500 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Premium Fleet</h3>
                <p class="text-gray-400">Extensive selection of luxury and premium vehicles for every occasion.</p>
            </div>
            <div class="text-center p-6 bg-gray-900 rounded-lg shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                <i class="fas fa-shield-alt text-4xl text-purple-500 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">100% Insured</h3>
                <p class="text-gray-400">Full coverage insurance for worry-free rentals and complete peace of mind.</p>
            </div>
            <div class="text-center p-6 bg-gray-900 rounded-lg shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                <i class="fas fa-headset text-4xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
                <p class="text-gray-400">Round-the-clock customer service to assist you whenever you need help.</p>
            </div>
        </div>
    </div>
</section>

<!-- Who We Are -->
<section class="py-10 bg-gray-900">
<div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-center mb-12">Who We Are</h2>
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg text-center">
        <p class="text-gray-400 max-w-3xl mx-auto">
            Founded in 1987 by <span class="font-bold text-yellow-400">Mr. M. C. Zakir Ahamed</span>, Casons Rent a Car is a family-run business and the leading car rental company in Sri Lanka. Offering a wide range of vehicles, from budget cars to luxury limousines, we cater to tourists, corporate clients, weddings, and VIP events.
            <br><br>
            In 1991, <span class="font-bold text-blue-400">Mr. M. C. Zufer Ahamed</span> joined as CEO, rapidly expanding our services. Inspired by their father, <span class="font-bold text-green-400">Mr. Mohamed Cassim</span>, the name "Casons" stands for "Cassim & Sons."
            <br><br>
            With a dedicated team and a motto of <span class="font-bold text-red-400">"Excellence Unmatched"</span>, we continuously strive to provide top-tier service. In 2017, we expanded to the <span class="font-bold text-yellow-400">Bandaranayake International Airport (BIA)</span>, reinforcing our reputation as pioneers in the industry.
        </p>
    </div>
</div>
</section>


<!-- Our Vision -->
<section class="py-10 bg-gray-900">
<div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-center mb-12">Our Vision</h2>
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg text-center">
        <div class="text-5xl text-yellow-400 mb-4">
            <i class="fas fa-lightbulb"></i>
        </div>
        <p class="text-gray-400 text-lg font-semibold max-w-2xl mx-auto">
            "To lead our industry by defining service excellence and building unmatched customer loyalty."
        </p>
    </div>
</div>
</section>

<!-- Our Strength -->
<section class="py-10 bg-gray-900">
<div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-center mb-12">Our Strength</h2>
    <div class="grid md:grid-cols-3 gap-8 text-center">
        <!-- Marketing & Operations Team -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="text-5xl text-yellow-400 mb-4">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-white">Marketing & Operations</h3>
            <p class="text-gray-400">A strong team of <span class="font-bold text-yellow-400">35 professionals</span> ensuring seamless service and strategic growth.</p>
        </div>
        <!-- Automobile Technicians -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="text-5xl text-blue-400 mb-4">
                <i class="fas fa-tools"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-white">Skilled Technicians</h3>
            <p class="text-gray-400">A dedicated team of <span class="font-bold text-blue-400">15 experts</span> keeping our fleet in top condition.</p>
        </div>
        <!-- Experienced Drivers -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="text-5xl text-green-400 mb-4">
                <i class="fas fa-car"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-white">Experienced Drivers</h3>
            <p class="text-gray-400">A reliable team of <span class="font-bold text-green-400">150 drivers</span>, fluent in all three national languages.</p>
        </div>
    </div>
    <p class="text-gray-400 text-center mt-12 max-w-3xl mx-auto">
        Our dedicated staff is the backbone of our success, ensuring efficient service in a dynamic business environment.
    </p>
</div>
</section>


<!-- Fleet Showcase -->
<section class="py-10 bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12">Our Premium Fleet</h2>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300">
                <img src="/images/user/luxury.png"
                     alt="Luxury Sedan"
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">Luxury Sedans</h3>
                    <p class="text-gray-400">Premium comfort for business and leisure</p>
                </div>
            </div>
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300">
                <img src="/images/user/sports.png"
                     alt="Sports Car"
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">Sports Cars</h3>
                    <p class="text-gray-400">Experience pure driving excitement</p>
                </div>
            </div>
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300">
                <img src="/images/user/suv.png"
                     alt="SUV"
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">Premium SUVs</h3>
                    <p class="text-gray-400">Spacious comfort for any adventure</p>
                </div>
            </div>
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300">
                <img src="/images/user/electric.png"
                     alt="Electric Vehicle"
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">Electric Vehicles</h3>
                    <p class="text-gray-400">Eco-friendly luxury transport</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-10 bg-gray-800">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-500 mb-2">
                    <i class="fas fa-car mb-4"></i>
                    <span class="ml-2">200+</span>
                </div>
                <p class="text-gray-400">Premium Vehicles</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-500 mb-2">
                    <i class="fas fa-smile-beam mb-4"></i>
                    <span class="ml-2">15K+</span>
                </div>
                <p class="text-gray-400">Happy Customers</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-green-500 mb-2">
                    <i class="fas fa-map-marker-alt mb-4"></i>
                    <span class="ml-2">25+</span>
                </div>
                <p class="text-gray-400">Locations</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-red-500 mb-2">
                    <i class="fas fa-star mb-4"></i>
                    <span class="ml-2">4.9</span>
                </div>
                <p class="text-gray-400">Average Rating</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-10 bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12">Why Choose Us</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="flex items-start p-6 bg-gray-800 rounded-lg">
                <i class="fas fa-clock text-3xl text-blue-500 mt-1 mr-4"></i>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Quick Booking Process</h3>
                    <p class="text-gray-400">Reserve your dream car in minutes with our streamlined booking system.</p>
                </div>
            </div>
            <div class="flex items-start p-6 bg-gray-800 rounded-lg">
                <i class="fas fa-dollar-sign text-3xl text-green-500 mt-1 mr-4"></i>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Competitive Pricing</h3>
                    <p class="text-gray-400">Best rates guaranteed with our price match promise.</p>
                </div>
            </div>
            <div class="flex items-start p-6 bg-gray-800 rounded-lg">
                <i class="fas fa-tools text-3xl text-purple-500 mt-1 mr-4"></i>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Regular Maintenance</h3>
                    <p class="text-gray-400">All vehicles undergo thorough maintenance checks.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Clients -->
<section class="py-10 bg-gray-900">
<div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-center mb-12">Our Clients</h2>
    <div class="grid md:grid-cols-3 gap-8 text-center">
        <!-- Individuals -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="text-5xl text-yellow-400 mb-4">
                <i class="fas fa-user"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Individuals</h3>
            <p class="text-gray-400">
                Serving both local and international travelers for business and leisure.
            </p>
        </div>

        <!-- Corporates & Organizations -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="text-5xl text-blue-400 mb-4">
                <i class="fas fa-building"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Corporates & Organizations</h3>
            <p class="text-gray-400">
                Partnering with businesses, government agencies, NGOs, and diplomatic missions.
            </p>
        </div>

        <!-- Hospitality & Travel Industry -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="text-5xl text-green-400 mb-4">
                <i class="fas fa-plane"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Hospitality & Travel</h3>
            <p class="text-gray-400">
                Trusted by hotels, airlines, travel agents, and tour operators across Sri Lanka.
            </p>
        </div>
    </div>

    <!-- Customer Appreciation -->
    <div class="mt-12 text-center">
        <p class="text-gray-400 text-lg max-w-3xl mx-auto">
            We take pride in the recognition and endorsements we receive from our valued clients. Their trust motivates us to continually enhance our services and deliver an unparalleled rental experience.
        </p>
    </div>
</div>
</section>


<!-- CTA Section -->
<section class="py-20 bg-gradient-to-b from-gray-800 to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-8">Ready to Hit the Road?</h2>
        <p class="text-xl text-gray-400 mb-8">Experience luxury driving with our premium rental service</p>
        <div class="flex justify-center gap-4">
            <a href="/cars" class="inline-block text-white px-8 py-4 rounded-lg font-semibold transition-colors duration-300" id="view-fleet-btn">
                View Our Fleet
                <i class="fas fa-car ml-2"></i>
            </a>
            <a href="/contact" class="inline-block bg-gray-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-gray-600 transition-colors duration-300">
                Contact Us
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Typing animation
        const headingText = "CASONS Rental Experience  ";
        const subheadingText = "Delivering luxury, comfort, and reliability on every journey since 2010";
        const headingElement = document.getElementById('animated-heading');
        const subheadingElement = document.getElementById('animated-subheading');

        let headingIndex = 0;
        let subheadingIndex = 0;
        let headingComplete = false;

        function typeHeading() {
            if (headingIndex < headingText.length) {
                headingElement.innerHTML += headingText.charAt(headingIndex);
                headingIndex++;
                setTimeout(typeHeading, 80);
            } else {
                headingComplete = true;
                setTimeout(() => {
                    // Fade in subheading instead of typing it character by character
                    subheadingElement.innerHTML = subheadingText;
                    subheadingElement.classList.add('visible');
                }, 500);
            }
        }

        setTimeout(typeHeading, 1000);

        // Scroll reveal animation
        const sections = document.querySelectorAll('section:not(:first-child)');

        // Add the section-fade-in class to all sections except hero
        sections.forEach(section => {
            section.classList.add('section-fade-in');
        });

        // Add feature-card class to all feature cards
        document.querySelectorAll('.bg-gray-900.rounded-lg.shadow-xl').forEach(card => {
            card.classList.add('feature-card');
        });

        // Add gradient text to main headings
        document.querySelectorAll('section h2').forEach(heading => {
            heading.classList.add('gradient-text');
        });

        // Add stat-highlight class to all stat containers
        document.querySelectorAll('.text-4xl.font-bold').forEach(stat => {
            stat.classList.add('stat-highlight');
        });

        // Reveal animations on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        // Observe all sections with fade-in class
        document.querySelectorAll('.section-fade-in').forEach(section => {
            observer.observe(section);
        });

        const heroSection = document.querySelector('section:first-child');
            const heroOverlay = document.createElement('div');
            heroOverlay.classList.add('hero-overlay');
            heroSection.insertBefore(heroOverlay, heroSection.firstChild);

            // Make hero content relative to the overlay
            const heroContent = heroSection.querySelector('.relative.container');
            heroContent.classList.add('hero-content');

            // Scroll indicator functionality
            const scrollIndicators = document.querySelectorAll('.scroll-indicator');
            const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

            window.addEventListener('scroll', () => {
                const scrollProgress = (window.scrollY / maxScroll) * 100;

                scrollIndicators.forEach(scrollIndicator => {
                    if (scrollProgress > 0) {
                        scrollIndicator.classList.add('scroll-progress-33');
                    }
                    if (scrollProgress > 33) {
                        scrollIndicator.classList.add('scroll-progress-66');
                    }
                    if (scrollProgress > 66) {
                        scrollIndicator.classList.add('scroll-progress-100');
                    }
                    if (scrollProgress > 90) {
                        scrollIndicator.classList.add('hide');
                    }
                    if (scrollProgress === 0) {
                        scrollIndicator.classList.remove(
                            'scroll-progress-33',
                            'scroll-progress-66',
                            'scroll-progress-100',
                            'hide'
                        );
                    }
                });
            });
        });
</script>
@endsection
