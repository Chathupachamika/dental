@extends('layouts.user-layout')

@section('title', 'CASONS - Contact Us')

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

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #001219;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }



        /* Section Animations */
        section {
            animation: fadeIn 0.6s ease-out;
        }

        /* Card Hover Effects */
        .bg-[#001824] {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .bg-[#001824]:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* Icon Containers */
        .w-16.h-16 {
            animation: float 3s ease-in-out infinite;
        }

        /* Form Styles */
        input,
        textarea {
            transition: all 0.3s ease;
        }

        .scroll-indicator {
            opacity: 1;
            transition: opacity 0.5s ease;
            z-index: 10;
            position: relative;
            width: 40px;
            /* Added width to contain the arrows */
        }

        .scroll-indicator.hide {
            opacity: 0;
        }

        .arrow-1,
        .arrow-2,
        .arrow-3 {
            animation: fadeInOut 2s infinite;
            transform: translateX(0);
            position: absolute;
        }

        .arrow-1 {
            left: 0;
        }

        .arrow-2 {
            animation-delay: 0.2s;
            left: 15px;
            /* Increased spacing */
        }

        .arrow-3 {
            animation-delay: 0.4s;
            left: 30px;
            /* Increased spacing */
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateX(-15px);
                /* Increased animation distance */
            }

            50% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
                transform: translateX(15px);
                /* Increased animation distance */
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

        .hero-content {
            position: relative;
            z-index: 2;
        }

        input:focus,
        textarea:focus {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.1);
        }

        /* Button Styles */
        .bg-red-600 {
            position: relative;
            overflow: hidden;
        }

        .bg-red-600::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .bg-red-600:hover::after {
            width: 300px;
            height: 300px;
        }

        /* Review Slider */
        .swiper-container {
            overflow: hidden;
            padding: 20px 0;
        }

        .swiper-slide {
            transition: transform 0.3s ease;
        }

        .swiper-slide:hover {
            transform: scale(1.02);
        }

        /* Navigation Dots */
        .swiper-pagination-bullet {
    background-color: gray; /* Default color for the inactive dots */
}

/* Change the color of the active pagination dot */
.swiper-pagination-bullet-active {
    background-color: red; /* Red color for the active dot */
}

        /* Map Container */
        .rounded-xl.overflow-hidden {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .rounded-xl.overflow-hidden:hover {
            transform: scale(1.01);
        }

        /* Contact Info Icons */
        .fas {
            transition: transform 0.3s ease;
        }

        li:hover .fas {
            transform: scale(1.2);
            color: #ef4444;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }

            .grid {
                gap: 20px;
            }

            .text-3xl {
                font-size: 1.875rem;
            }
        }

        /* Loading Animation for Images */
        img {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        img.loaded {
            opacity: 1;
        }

        /* Form Validation Styles */
        input:invalid,
        textarea:invalid {
            border-color: #ef4444;
        }

        /* Custom Focus Styles */
        *:focus {
            outline: none;
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
                transition: none !important;
            }
        }

        .text-right {
            text-align: right;
        }

        @media (min-width: 768px) {
            .map-container {
                height: 100%;
            }
        }

        #button {
            background: linear-gradient(135deg, #fc1010, #380606);

        }

        #button:hover {
            background: linear-gradient(135deg, #b50c0c, #2a0404);
        }
    </style>
@endsection

@include('scroll-indicator.scroll-indicator')
@section('content')
    <div class="bg-[#001219] text-gray-100 ">
        <!-- Get in Touch Section -->
        <section class="py-16 mt-20 text-right">
            <div class="container mx-auto px-4 text-right">
                <div class="max-w-3xl mx-auto text-center mb-12">

                    <h2 class="text-3xl font-bold mb-4">Get In Touch</h2>
                    <p class="text-gray-400">Save time by browsing through our website for answers. If you did, but
                        you still need help, here's how you can reach us.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 text-right">
                    <!-- Support -->
                    <div class="bg-[#001824] p-8 rounded-xl">
                        <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-headset text-2xl text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-center mb-3">Support</h3>
                        <p class="text-gray-400 text-center text-sm mb-4">If the answer can't be found urgent,
                            please call us on our service line.</p>
                        <div class="text-center">
                            <a href="mailto:info@casonscars.com" class="text-sm text-gray-400">Email:
                                info@casonscars.com</a>
                        </div>
                    </div>

                    <!-- Help Center -->
                    <div class="bg-[#001824] p-8 rounded-xl">
                        <div class="w-16 h-16 bg-green-500/10 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-question-circle text-2xl text-green-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-center mb-3">Visit our Help Center</h3>
                        <p class="text-gray-400 text-center text-sm mb-4">Get any question and get answers right
                            away.</p>
                        <div class="text-center">
                            <button class="text-white px-6 py-2 rounded-lg transition-colors duration-300" id="button">
                                Ask
                            </button>
                        </div>
                    </div>

                    <!-- Cooperation -->
                    <div class="bg-[#001824] p-8 rounded-xl">
                        <div class="w-16 h-16 bg-purple-500/10 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-handshake text-2xl text-purple-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-center mb-3">Cooperation</h3>
                        <p class="text-gray-400 text-center text-sm mb-4">For any business inquires, please contact
                            us at the email address given.</p>
                        <div class="text-center">
                            <a href="mailto:info@casonscars.com" class="text-sm text-gray-400">Email:
                                info@casonscars.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Information & Map -->
        <section class="py-16 bg-[#001824] text-left">
            <div class="container mx-auto px-4 text-left">
                <div class="grid md:grid-cols-2 gap-8 text-left">
                    <!-- Contact Info -->
                    <div class="bg-black bg-opacity-70 rounded-3xl p-8 shadow-lg text-white space-y-6">
                        <!-- Company Name -->
                        <h2 class="text-2xl font-bold flex items-center gap-2">
                            <i class="fas fa-car text-yellow-400"></i> Casons Rent-A-Car (Pvt) Ltd
                        </h2>

                        <!-- Address -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-red-400"></i> Address
                                </h3>
                                <p class="text-gray-300">
                                    181, Gothami Gardens<br>
                                    Gothami Road, Rajagiriya,<br>
                                    Sri Lanka.
                                </p>
                            </div>

                            <!-- Contact Details -->
                            <div class="space-y-2">
                                <h3 class="text-lg font-semibold flex items-center gap-2">
                                    <i class="fas fa-phone-alt text-green-400"></i> Contact
                                </h3>
                                <p><span class="font-bold">Hotline:</span> <a href="tel:+94114377366"
                                        class="text-yellow-300 hover:underline">+94 11 4 377 366</a></p>
                                <p><span class="font-bold">Mobile:</span> <a href="tel:+94777312500"
                                        class="text-yellow-300 hover:underline">+94 777 312 500</a></p>
                                <p><span class="font-bold">Fax:</span> <a href="fax:+94114406544"
                                        class="text-yellow-300 hover:underline">+94 11 440 6544</a></p>
                                <p><span class="font-bold">Email:</span> <a href="mailto:info@casonsrentacar.com"
                                        class="text-blue-400 hover:underline">info@casonsrentacar.com</a></p>
                            </div>
                        </div>

                        <!-- Entrepreneur -->
                        <div class="border-t border-gray-600 pt-6">
                            <h3 class="text-lg font-semibold flex items-center gap-2">
                                <i class="fas fa-user-tie text-indigo-400"></i> Entrepreneur
                            </h3>
                            <div class="grid grid-cols-2 gap-6">
                                <p class="text-gray-300">M.C. Zakir Ahamed (A.M.I.M.I.) UK</p>
                                <div>
                                    <p><a href="tel:+94773220000" class="text-yellow-300 hover:underline"><i
                                                class="fas fa-phone-alt"></i> +94 773 220 000</a></p>
                                    <p><a href="mailto:zakir@casonsrentacar.com" class="text-blue-400 hover:underline"><i
                                                class="fas fa-envelope"></i> zakir@casonsrentacar.com</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- Director / CEO -->
                        <div class="border-t border-gray-600 pt-6">
                            <h3 class="text-lg font-semibold flex items-center gap-2">
                                <i class="fas fa-user text-purple-400"></i> Director / CEO
                            </h3>
                            <div class="grid grid-cols-2 gap-6">
                                <p class="text-gray-300">M.C. Zufer Ahamed</p>
                                <div>
                                    <p><a href="tel:+94777680000" class="text-yellow-300 hover:underline"><i
                                                class="fas fa-phone-alt"></i> +94 777 680 000</a></p>
                                    <p><a href="mailto:zufer@casonsglobal.com" class="text-blue-400 hover:underline"><i
                                                class="fas fa-envelope"></i> zufer@casonsglobal.com</a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7653848313903!2d79.88547137587116!3d6.918627818443727!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259971210bd7f%3A0xa94dd12870d5789d!2sCasons%20Rent%20A%20Car!5e0!3m2!1sen!2slk!4v1740558473096!5m2!1sen!2slk"
                            width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </section>

<!-- Customer Reviews Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">What Our Customers Say</h2>

        <div class="max-w-3xl mx-auto relative flex items-center gap-4">
            <!-- Reviews Slider -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- Single Review -->
                    @foreach ($rates as $rate )


                    <div class="swiper-slide bg-[#001824] p-8 rounded-xl">
                        <p class="text-gray-400 mb-6">{{$rate->rate_experience}}
                        </p>
                        <div class="flex items-center gap-4">

                                @for ($i=0; $i < $rate->rate_count; $i++)
                                <i class="fas fa-star text-2xl  text-yellow-400 "></i>

                                @endfor
                                <h4 class="font-semibold ml-20">{{$rate->customer_name}}</h4>
                                <p class="text-gray-400 text-sm">{{$rate->customer_email}}</p>

                        </div>
                    </div>

                    @endforeach


            </div>

                <!-- Pagination (This is where the round buttons will show up) -->
                <div  class="swiper-pagination"></div>
        </div>
    </div>
    <div class="text-center mt-12">
        <button type="submit" class="text-white px-8 py-3 rounded-lg transition-colors duration-300"
            id="button" onclick="showRateModal()">
            Rate us
        </button>
    </div>
</section>


        <!-- Contact Form -->
        <section class="py-16 bg-[#001824]">
            <div class="container mx-auto px-4">
                <div class="max-w-2xl mx-auto">
                    <h2 class="text-2xl font-bold text-center mb-8">If you have any other questions</h2>
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <input type="text" placeholder="Your Name"
                                    class="w-full px-4 py-3 bg-[#001219] border border-gray-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>
                            <div>
                                <input type="email" placeholder="Your Email"
                                    class="w-full px-4 py-3 bg-[#001219] border border-gray-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>
                        </div>
                        <div>
                            <input type="tel" placeholder="Your Contact Number"
                                class="w-full px-4 py-3 bg-[#001219] border border-gray-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>
                        <div>
                            <input type="text" placeholder="Select a subject"
                                class="w-full px-4 py-3 bg-[#001219] border border-gray-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>
                        <div>
                            <textarea placeholder="Question" rows="4"
                                class="w-full px-4 py-3 bg-[#001219] border border-gray-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="text-white px-8 py-3 rounded-lg transition-colors duration-300"
                                id="button">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Swiper
        const swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',  // This links to the pagination container
                clickable: true
            },
            autoplay: {
                delay: 4000
            }
        });
    });
</script>
@endsection
