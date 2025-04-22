@extends('layouts.user-layout')

@section('title', 'Home Page')

@section('styles')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #e2e8f0;
        }

        .scroll-indicator {
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .scroll-indicator.hide {
            opacity: 0;
        }

        .arrow-large {
            font-size: 2.8rem;
            /* text-3xl equivalent */
            animation: fadeInArrow 2s infinite;
            /* First arrow starts immediately */
        }

        .arrow-medium {
            font-size: 2rem;
            /* text-2xl equivalent */
            animation: fadeInArrow 2s infinite 0.2s;
            /* Delayed by 0.2s */
        }

        .arrow-small {
            font-size: 1.45rem;
            /* text-xl equivalent */
            animation: fadeInArrow 2s infinite 0.4s;
            /* Delayed by 0.4s */
        }

        .arrow-small,
        .arrow-medium,
        .arrow-large {
            animation: fadeInOut 2s infinite;
            transform: translateY(0);
        }

        .arrow-medium {
            animation-delay: 0.15s;
            /* Reduced from 0.2s */
            margin-top: -8px;
            /* Added negative margin to bring arrows closer */
        }

        .arrow-large {
            animation-delay: 0.3s;
            /* Reduced from 0.4s */
            margin-top: -8px;
            /* Added negative margin to bring arrows closer */
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(-5px);
                /* Reduced from -10px for tighter animation */
            }

            50% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(5px);
                /* Reduced from 10px for tighter animation */
            }
        }

        /* Updated colors for dark theme */
        .fas.fa-chevron-down {
            color: rgba(255, 255, 255, 0.85);
            /* Brighter base color */
        }

        .arrow-small {
            opacity: 0.9;
        }

        .arrow-medium {
            opacity: 0.7;
        }

        .arrow-large {
            opacity: 0.5;
        }

        /* Hide arrows based on scroll position */
        .scroll-progress-33 .arrow-small {
            opacity: 0;
            transform: translateY(5px);
            /* Reduced from 10px */
        }

        .scroll-progress-66 .arrow-medium {
            opacity: 0;
            transform: translateY(5px);
            /* Reduced from 10px */
        }

        .scroll-progress-100 .arrow-large {
            opacity: 0;
            transform: translateY(5px);
            /* Reduced from 10px */
        }

        .carousel-item {
            opacity: 0;
            transform: scale(1.1) translateY(10px);
            transition: all 1s cubic-bezier(0.65, 0, 0.35, 1);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .carousel-item.active {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        .carousel-item img {
            filter: brightness(0.5) saturate(1.3) contrast(1.1);
            transition: all 0.8s ease;
        }

        .carousel-item:hover img {
            filter: brightness(0.85) saturate(1.4) contrast(1.15);
            transform: scale(1.02);
        }

        /* Modern typing animation */
        .typed-text {
            font-family: "Arial Black", "Helvetica Black", sans-serif;
            font-weight: 800;
            font-size: 3rem;
            letter-spacing: -0.02em;
            text-shadow: 0 4px 8px rgb(186, 218, 247);
            background: linear-gradient(to right, rgba(255, 255, 255, 0.95), rgb(255, 255, 255));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeIn 0.8s ease-out;
            text-transform: uppercase;
            line-height: 1.1;
        }

        @media (max-width: 768px) {
            .typed-text {
                font-size: 3rem;
            }
        }


        .typed-text::after {
            content: '|';
            -webkit-text-fill-color: rgba(255, 255, 255, 0.994);
            animation: blink 0.8s infinite, pulse 2s infinite;
        }

        /* Enhanced navigation arrows */
        .nav-arrow {
            backdrop-filter: blur(8px);
            background: rgba(0, 0, 0, 0.3);

            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s ease;
        }

        .nav-arrow:hover {
            background: rgba(0, 0, 0, 0.5);
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        /* Enhanced dot navigation */
        .dot-nav {
            backdrop-filter: blur(8px);
            padding: 10px 20px;
            border-radius: 30px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dot {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modern animations */
        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced gradient overlay */
        .gradient-overlay {
            background: linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.2) 0%,
                    rgba(0, 0, 0, 0.7) 100%);
            backdrop-filter: blur(2px);
        }

        /* Loading animation */
        .loading {
            animation: shimmer 2s infinite linear;
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.738) 50%,
                    rgba(255, 255, 255, 0) 100%);
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-150%);
            }

            100% {
                transform: translateX(150%);
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .typed-text {
                font-size: 2rem;
                text-align: center;
            }

            button.group {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
        }

        /* Enhanced button styles */
        button.group {
            background: rgba(255, 255, 255, 0.854);
            /* Slightly transparent */
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.893);
            box-shadow: 0 4px 15px rgb(193, 236, 247);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        button.group::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            transition: 0.5s;
        }

        button.group:hover {
            transform: translateY(-3px) scale(1.02);
            background: rgb(255, 255, 255);
        }


        /* New widget style */
        .widget {
            background: rgba(255, 255, 255, 0.861);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .widget:hover {
            background: rgba(255, 255, 255, 0.815);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        /* Modal Animation */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes modalBackdropFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Modal Styles */
        #getCarModal {
            backdrop-filter: blur(8px);
            transition: all 0.3s ease-in-out;
        }

        #getCarModal.flex {
            animation: modalBackdropFadeIn 0.3s ease-out;
        }

        #getCarModal>div {
            animation: modalFadeIn 0.3s ease-out;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            background: linear-gradient(145deg, #0A2A3B, #1a3a4b);
        }

        /* Form Elements Styling */
        #bookingForm input[type="radio"] {
            cursor: pointer;
            position: relative;
            appearance: none;
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid #EA2F2F;
            border-radius: 50%;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.1);
        }

        #bookingForm input[type="radio"]:checked {
            background: #EA2F2F;
            border-color: #EA2F2F;
        }

        #bookingForm input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.5rem;
            height: 0.5rem;
            background: rgba(33, 108, 46, 0.315);
            border-radius: 50%;
        }

        #bookingForm input[type="text"],
        #bookingForm input[type="date"],
        #bookingForm input[type="time"],
        #bookingForm select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(89, 178, 241, 0.733);
            transition: color 0.3s ease;
        }

        #bookingForm input[type="text"]:focus,
        #bookingForm input[type="date"]:focus,
        #bookingForm input[type="time"]:focus,
        #bookingForm select:focus {
            color: black;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.5);
            border-color: #EA2F2F;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        #bookingForm input[type="date"]::-webkit-calendar-picker-indicator,
        #bookingForm input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.7;
            cursor: pointer;
        }

        /* Button Styles */
        #bookingForm button[type="submit"] {
            background: linear-gradient(135deg, #EA2F2F, #5E1313);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        #bookingForm button[type="submit"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            background: linear-gradient(135deg, #fc1010, #380606);
        }

        #bookingForm button[type="refresh"] {
            background: linear-gradient(135deg, #888888, #4B4B4B);
            backdrop-filter: blur(4px);
            transition: all 0.3s ease;
        }

        #bookingForm button[type="refresh"]:hover {
            background: linear-gradient(135deg, #686868, #333333);
            transform: translateY(-1px);
        }

        /* Close Button Animation */
        #getCarModal button[onclick="closeModal()"] {
            transition: all 0.3s ease;
        }

        #getCarModal button[onclick="closeModal()"]:hover {
            transform: rotate(90deg);
            color: #ef4444;
        }

        /* Custom Scrollbar */
        #getCarModal::-webkit-scrollbar {
            width: 8px;
        }

        #getCarModal::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        #getCarModal::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.249);
            border-radius: 4px;
        }

        #getCarModal::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Placeholder Styling */
        #bookingForm input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Select Dropdown Styling */
        #bookingForm select option {
            background: #0d2938;
            color: rgba(255, 255, 255, 0.381);
        }

        /* Form Focus Styles */
        #bookingForm .space-y-3:focus-within {
            color: #2563eb;
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

        .bg-teal-500 {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .flex.items-start:hover .bg-teal-500 {
            transform: rotate(5deg) scale(1.1);
        }

        .text-3xl {
            background: linear-gradient(to right, #fff, #EA2F2F);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            background-size: 200% 100%;
            animation: shimmer 3s infinite linear;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% center;
            }

            100% {
                background-position: -200% center;
            }
        }

        .bg-teal-500::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .flex.items-start:hover .bg-teal-500::after {
            opacity: 1;
            transform: rotate(45deg) translate(50%, 50%);
        }

        .flex.items-start {
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .flex.items-start:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Modal Header Animation */
        #getCarModal h2 {
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shimmer 2s infinite linear;
            background-size: 200% 100%;
        }

        .text-teal-400 {
            opacity: 0;
            animation: fadeIn 0.8s ease-out 0.4s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Feature Icons Animation */
        .fas {
            transition: all 0.3s ease;
        }

        .flex.items-start:hover .fas {
            transform: scale(1.2);
        }

        html {
            scroll-behavior: smooth;
        }

        .flex.items-start:hover h4 {
            color: #EA2F2F;
            transition: color 0.3s ease;
        }

        /* Shadow Effects */
        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: box-shadow 0.3s ease;
        }

        .relative:hover .shadow-2xl {
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.6);
        }

        .bg-gradient-to-br {
            background-size: 200% 200%;
            animation: gradientMove 15s ease infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 1024px) {
            .container {
                padding: 2rem;
            }

            .flex.items-start {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .text-3xl {
                font-size: 1.875rem;
            }

            .text-2xl {
                font-size: 1.5rem;
            }
        }

        .space-y-4>div:nth-child(1) {
            animation-delay: 0.1s;
        }

        .space-y-4>div:nth-child(2) {
            animation-delay: 0.2s;
        }

        .space-y-4>div:nth-child(3) {
            animation-delay: 0.3s;
        }

        .space-y-4>div:nth-child(4) {
            animation-delay: 0.4s;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
@endsection
@section('scripts')
    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll('.carousel-item');
        const dots = document.querySelectorAll('.absolute.bottom-8 button');
        let isAutoPlaying = true;
        let interval;
        let typingInterval;

        function typeText(element, text, index = 0) {
            if (index < text.length) {
                element.textContent += text.charAt(index);
                typingInterval = setTimeout(() => typeText(element, text, index + 1), 100);
            }
        }

        function showSlide(index) {
            slides[currentIndex].classList.remove('active');
            dots[currentIndex].classList.remove('w-8', 'bg-white');
            dots[currentIndex].classList.add('bg-white/50');

            currentIndex = (index + slides.length) % slides.length;

            slides[currentIndex].classList.add('active');
            dots[currentIndex].classList.add('w-8', 'bg-white');
            dots[currentIndex].classList.remove('bg-white/50');

            // Clear previous typing and start new typing animation
            clearTimeout(typingInterval);
            const typedElement = slides[currentIndex].querySelector('.typed-text');
            typedElement.textContent = '';
            typeText(typedElement, typedElement.dataset.text);
        }

        function goToSlide(index) {
            showSlide(index);
            resetAutoPlay();
        }

        function goToPrevious() {
            showSlide(currentIndex - 1);
            resetAutoPlay();
        }

        function goToNext() {
            showSlide(currentIndex + 1);
            resetAutoPlay();
        }

        function resetAutoPlay() {
            clearInterval(interval);
            if (isAutoPlaying) {
                startAutoPlay();
            }
        }

        function startAutoPlay() {
            interval = setInterval(goToNext, 8000); // Increased to 8 seconds to allow for typing
        }

        window.addEventListener('scroll', function () {
            const carouselContainer = document.getElementById('carouselContainer');
            const scrollPosition = window.scrollY;
            const windowHeight = window.innerHeight;

            if (scrollPosition > windowHeight * 0.3) {
                carouselContainer.style.transform = `translateY(${(scrollPosition - windowHeight * 0.3) * 0.5}px)`;
                carouselContainer.style.opacity = Math.max(1 - (scrollPosition - windowHeight * 0.3) / (
                    windowHeight * 0.7), 0);
            } else {
                carouselContainer.style.transform = 'translateY(0)';
                carouselContainer.style.opacity = 1;
            }

            if (scrollPosition > windowHeight) {
                carouselContainer.classList.add('carousel-hidden');
            } else {
                carouselContainer.classList.remove('carousel-hidden');
            }
        });

        // Smooth scroll function
        function smoothScroll(target, duration) {
            const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
            const startPosition = window.pageYOffset;
            const distance = targetPosition - startPosition;
            let startTime = null;

            function animation(currentTime) {
                if (startTime === null) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const run = ease(timeElapsed, startPosition, distance, duration);
                window.scrollTo(0, run);
                if (timeElapsed < duration) requestAnimationFrame(animation);
            }

            function ease(t, b, c, d) {
                t /= d / 2;
                if (t < 1) return c / 2 * t * t + b;
                t--;
                return -c / 2 * (t * (t - 2) - 1) + b;
            }

            requestAnimationFrame(animation);
        }

        // Initial typing for the first slide
        document.addEventListener('DOMContentLoaded', function () {
            const firstTypedElement = slides[0].querySelector('.typed-text');
            typeText(firstTypedElement, firstTypedElement.dataset.text);
            startAutoPlay();

            const getCarButtons = document.querySelectorAll('button');
            getCarButtons.forEach(button => {
                if (button.textContent.trim() === 'Get Your Car') {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        openModal();
                        smoothScroll(document.getElementById('getCarModal'), 1000);
                    });
                }
            });
        });

        // Modal functions
        function openModal() {
            const modal = document.getElementById('getCarModal');
            if (!modal) {
                console.error('Modal element not found');
                return;
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('getCarModal');
            if (!modal) {
                console.error('Modal element not found');
                return;
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Form functions
        function updateAddressField() {
            const addressField = document.getElementById('addressField');
            const withDriverOption = document.getElementById('withDriver');
            if (!addressField || !withDriverOption) return;

            addressField.placeholder = withDriverOption.checked ? 'Address' : 'Pick-up Location';
        }

        function refreshForm() {
            const form = document.getElementById('bookingForm');
            const addressField = document.getElementById('addressField');
            if (!form || !addressField) return;

            form.reset();
            addressField.placeholder = 'Address';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const scrollIndicator = document.querySelector('.scroll-indicator');
            const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

            window.addEventListener('scroll', () => {
                const scrollProgress = (window.scrollY / maxScroll) * 100;

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

                // Reset classes when scrolling back to top
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

        async function saveBooking(event) {
            event.preventDefault();
            const form = document.getElementById('bookingForm');
            const formData = new FormData(form);

            try {
                const response = await fetch('/bookings/save', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                const result = await response.json();
                if (result.success) {
                    alert(result.message);
                    window.location.href = '{{ route("user.car-rental") }}';
                } else {
                    alert(result.message);
                }
            } catch (err) {
                console.error('Error saving booking:', err);
                alert('Failed to save booking. Please try again.');
            }
        }
    </script>
@endsection

@section('content')
    <div class="relative h-screen w-full overflow-hidden">
        <!-- Carousel container -->
        <div id="carouselContainer" class="relative h-full w-full">
            @php
                $images = [
                    '/images/user/carousel/1.png',
                    '/images/user/carousel/2.png',
                    '/images/user/carousel/3.png',
                    '/images/user/carousel/4.png',
                ];
                $quotes = [
                    'Drive Your Dreams',
                    'Adventure Awaits on Four Wheels',
                    'Luxury Meets Performance',
                    'The Perfect Ride for Every Journey',
                ];
            @endphp

            @foreach ($images as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <a href="#">
                        <img src="{{ $image }}" alt="Slide {{ $index + 1 }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-black/50"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
                            <h2 class="mb-6 text-5xl font-bold tracking-wider typed-text" data-text="{{ $quotes[$index] }}">
                            </h2>
                            <button onclick="openModal()"
                                class="group flex items-center gap-2  rounded-full px-8 py-4 text-lg font-semibold text-black transition-all hover:bg-opacity-90">
                                <i class="fas fa-car-side h-6 w-6 transition-transform group-hover:scale-110"></i>
                                Get Your Car
                            </button>
                        </div>
                    </a>
                </div>
            @endforeach
            <div
                class="absolute bottom-20 left-1/2 transform -translate-x-1/2 scroll-indicator flex flex-col items-center gap-1">
                <i class="fas fa-chevron-down text-white/70 text-2xl arrow-small"></i>
                <i class="fas fa-chevron-down text-white/60 text-2xl arrow-medium"></i>
                <i class="fas fa-chevron-down text-white/50 text-2xl arrow-large"></i>
            </div>
        </div>

        <!-- Navigation arrows -->
        <button onclick="goToPrevious()"
            class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/30 p-2 text-white transition-all hover:bg-black/50">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button onclick="goToNext()"
            class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/30 p-2 text-white transition-all hover:bg-black/50">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Dots navigation -->
        <div class="absolute bottom-8 left-1/2 flex -translate-x-1/2 gap-2">
            @foreach ($images as $index => $image)
                <button onclick="goToSlide({{ $index }})"
                    class="h-2 w-2 rounded-full transition-all {{ $index === 0 ? 'w-8 bg-white' : 'bg-white/50 hover:bg-white/75' }}"></button>
            @endforeach
        </div>
    </div>

    <div id="getCarModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-[#0A2A3B] rounded-lg p-8 max-w-md w-full mx-4 relative">
            <button onclick="closeModal()" class="absolute right-4 top-4 text-white hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h2 class="text-white text-2xl font-semibold mb-6">
                Just a quick step away from getting your car
            </h2>
            <form id="bookingForm" class="space-y-6" onsubmit="saveBooking(event)">
                @csrf
                <input type="hidden" name="car_id" id="carIdInput">
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <input type="radio" id="withDriver" name="driver_option" value="with" class="w-4 h-4"
                            onchange="updateAddressField()" required>
                        <label for="withDriver" class="text-white">With Driver</label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="radio" id="withoutDriver" name="driver_option" value="without" class="w-4 h-4"
                            onchange="updateAddressField()">
                        <label for="withoutDriver" class="text-white">Without Driver</label>
                    </div>
                </div>
                <div>
                    <input type="text" id="nic_number" name="nic_number"
                        class="w-full rounded-md px-4 py-2 focus:outline-none focus:ring-2" placeholder="Enter NIC Number">
                </div>
                <div>
                    <select name="request_type" class="w-full rounded-md px-4 py-2 focus:outline-none" required>
                        <option value="" disabled selected>Purpose</option>
                        <option value="Wedding Car">Wedding Car</option>
                        <option value="Travel & Tourism">Travel & Tourism</option>
                        <option value="Business & Executive">Business & Executive</option>
                        <option value="Economy & Budget Rentals">Economy & Budget Rentals</option>
                        <option value="Special Needs">Special Needs</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div>
                    <input type="text" id="location" name="location"
                        class="w-full rounded-md px-4 py-2 focus:outline-none focus:ring-2" placeholder="Address" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm mb-1 text-white">Pick-up date</label>
                        <input type="date" name="pick_date"
                            class="w-full rounded-md px-4 py-2 focus:outline-none focus:ring-2" required>
                    </div>
                    <div>
                        <label class="block text-sm mb-1 text-white">Time</label>
                        <input type="time" name="pick_time"
                            class="w-full rounded-md px-4 py-2 focus:outline-none focus:ring-2" required>
                    </div>
                    <div>
                        <label class="block text-sm mb-1 text-white">Drop-off date</label>
                        <input type="date" name="return_date"
                            class="w-full rounded-md px-4 py-2 focus:outline-none focus:ring-2" required>
                    </div>
                    <div>
                        <label class="block text-sm mb-1 text-white">Time</label>
                        <input type="time" name="return_time"
                            class="w-full rounded-md px-4 py-2 focus:outline-none focus:ring-2" required>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <button type="button" onclick="refreshForm()"
                        class="flex-1 text-white bg-gray-600 hover:bg-gray-700 rounded-md py-2 transition-colors">
                        Refresh
                    </button>
                    <button type="submit"
                        class="flex-1 text-white bg-red-500 hover:bg-red-600 rounded-md py-2 transition-colors">
                        Select Car
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 py-16">
        <!-- Why Choose Us Section -->
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Car Image -->
                <div class="relative">
                    <img src="/images/user/redcar.png" alt="Luxury Audi R8" class="w-full rounded-lg shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/50 to-transparent rounded-lg"></div>
                </div>

                <!-- Right Side - Features -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">WHY CHOOSE US</h2>
                        <h3 class="text-2xl text-[#CEDBDF] mb-6">We offer the best experience with our rental deals</h3>
                    </div>

                    <!-- Feature Cards -->
                    <div class="space-y-4">
                        <!-- Price Match -->
                        <div class="flex items-start space-x-4 bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                            <div class="bg-[#A42121] p-3 rounded-lg">
                                <i class="fas fa-tags text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Best Price Guarantee</h4>
                                <p class="text-gray-300">Find a lower price? We'll refund you 100% of the difference.</p>
                            </div>
                        </div>

                        <!-- Experienced Drivers -->
                        <div class="flex items-start space-x-4 bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                            <div class="bg-[#A42121] p-3 rounded-lg">
                                <i class="fas fa-user-tie text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Experienced Drivers</h4>
                                <p class="text-gray-300">Don't have driver? Don't worry, we have many experienced driver for
                                    you.</p>
                            </div>
                        </div>

                        <!-- Door to Door -->
                        <div class="flex items-start space-x-4 bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                            <div class="bg-[#A42121] p-3 rounded-lg">
                                <i class="fas fa-truck text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Free Door Delivery</h4>
                                <p class="text-gray-300">Book your car anytime and we will deliver it directly to you.</p>
                            </div>
                        </div>

                        <!-- 24/7 Support -->
                        <div class="flex items-start space-x-4 bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                            <div class="bg-[#A42121] p-3 rounded-lg">
                                <i class="fas fa-headset text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">24/7 Support</h4>
                                <p class="text-gray-300">Have a question? Contact live support any time when you have
                                    problem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mt-12">
                <!-- Left Side - Car Image -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">HOW IT WORKS</h2>
                        <h3 class="text-2xl text-[#CEDBDF] mb-6">Simple Steps to Your Dream Ride</h3>
                    </div>

                    <!-- Steps Cards -->
                    <div class="space-y-4">
                        <!-- Step 1 -->
                        <div class="flex items-start space-x-4 bg-white/20 p-4 rounded-lg backdrop-blur-sm">
                            <div class="bg-[#A42121] p-3 rounded-lg">
                                <i class="fas fa-search text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-lg">Browse and Select</h4>
                                <p class="text-gray-200">Choose from our wide range of premium cars, select the pickup and
                                    return dates and locations that suit you best.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex items-start space-x-4 bg-white/20 p-4 rounded-lg backdrop-blur-sm">
                            <div class="bg-[#A42121] p-3 rounded-lg">
                                <i class="fas fa-calendar-check text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-lg">Book and Confirm</h4>
                                <p class="text-gray-200">Book your desired car with just a few clicks and receive an instant
                                    confirmation via email or SMS.</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex items-start space-x-4 bg-white/20 p-4 rounded-lg backdrop-blur-sm">
                            <div class="bg-[#A42121] p-3 rounded-lg">
                                <i class="fas fa-car text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-lg">Enjoy Your Ride</h4>
                                <p class="text-gray-200">Pick up your car at the designated location and enjoy your premium
                                    driving experience with our top-quality service.</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex items-start space-x-4 bg-white/20 p-4 rounded-lg backdrop-blur-sm">
                            <div class="bg-[#A42121] p-3 rounded-lg">
                                <i class="fas fa-star text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-lg">Rate Your Experience</h4>
                                <p class="text-gray-200">Share your feedback and help us maintain our premium service
                                    standards for all customers.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Features -->
                <div class="relative">
                    <img src="/images/user/whychooseus.png" alt="Luxury Audi R8" class="w-full rounded-lg shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-r from-teal-900/50 to-transparent rounded-lg"></div>
                </div>

            </div>


        </div>
    </div>
@endsection
