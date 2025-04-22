<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Added Inter font which closely matches the image -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">


        <style>
            .logo-container {
                width: 90px;
                height: 90px;
                position: absolute;
                top: 1rem;
                left: 1rem;
                z-index: 10;
            }

            .main-container {
                min-height: 100vh;
                display: flex;
            }

            .car-section {
    width: 66.666667%;
    position: relative;
    overflow: hidden;
}

.car-image {
    width: 100%;
    height: 100vh;
    object-fit: cover;
    object-position: center;
}

/* Modern gradient overlay container */
.car-image-container {
    position: relative;
    width: 100%;
    height: 100vh;
}

/* Base image styles */
.car-image {
    width: 100%;
    height: 100vh;
    object-fit: cover;
    object-position: center;
    filter: brightness(0.9) contrast(1.1);
}

/* Gradient overlay */
.car-image-container::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0.7) 0%,
        rgba(0, 0, 0, 0.4) 50%,
        rgba(0, 0, 0, 0.8) 100%
    );
    pointer-events: none;
    z-index: 1;
}

/* Optional vignette effect */
.car-image-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(
        circle at center,
        transparent 50%,
        rgba(0, 0, 0, 0.4) 100%
    );
    z-index: 1;
    pointer-events: none;
}

            .description-container {
                position: absolute;
                bottom: 2rem;
                left: 2rem;
                z-index: 2;
                right: 2rem;
                color: white;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            }

            .description-line {
                font-size: 2rem;
                margin-bottom: 1rem;
                font-weight: 300;
                letter-spacing: 0.05em;
                opacity: 0;
            }

            .login-section {
                width: 33.333333%;
                position: relative;
                background: #000;
            }

            .login-section .relative.z-10 {
                margin-top: -2rem;  /* Add this line to move content up */
            }

            /* Star Animation Styles */
            .background {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                overflow: hidden;
                background: radial-gradient(circle, #120012, #000);
            }

            .star-layer {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                transform-style: preserve-3d;
                animation: rotate 120s linear infinite;
            }

            .star-layer:nth-child(1) { animation-duration: 160s; }
            .star-layer:nth-child(2) { animation-duration: 140s; }
            .star-layer:nth-child(3) { animation-duration: 180s; }
            .star-layer:nth-child(4) { animation-duration: 200s; }

            .star {
                position: absolute;
                background-color: white;
                border-radius: 50%;
                opacity: 0.8;
                animation: pulse 3s ease-in-out infinite;
            }

            @keyframes rotate {
                0% { transform: rotateY(0) rotateX(0); }
                100% { transform: rotateY(360deg) rotateX(360deg); }
            }

            @keyframes pulse {
                0%, 100% { transform: scale(0.8); opacity: 0.3; }
                50% { transform: scale(1.2); opacity: 0.8; }
            }

            .description-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
        }

        /* Typography */
        .description-line {
            margin: 0.5rem 0;
            line-height: 1.5;
            width: 100%;
            display: block;
        }

        .line-1 {
                font-family: 'Inter', sans-serif;
                font-size: 2.5rem;
                font-weight: 900;
                letter-spacing: -0.02em;
                text-shadow: 0 0 10px #a0c4ff, 0 0 20px #a0c4ff;
                color: #FFFFFF;
                margin: 0;
                text-align: right;
                padding-right: 1rem;
                text-transform: uppercase;
            }

            .line-2 {
                font-family: 'Inter', sans-serif;
                font-size: 4rem;
                font-weight: 900;
                background: linear-gradient(135deg, #FF4D8F, #B666FF);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                text-shadow: none;
                letter-spacing: -0.02em;
                margin: 0;
                text-align: right;
                padding-right: 1rem;
                text-transform: uppercase;
            }

            .line-3 {
                font-family: 'Inter', sans-serif;
                font-size: 1.2rem;
                font-weight: 400;
                color: #FFFFFF;
                margin-top: 0.5rem;
                text-shadow: 0 0 8px rgba(255,255,255,0.3);
                max-width: 800px;
                text-align: right;
                padding-right: 1rem;
            }
        /* Animation */
        @keyframes typewriter {
            from { width: 0; }
            to { width: 100%; }
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

        @keyframes neonPulse {
            0% { opacity: 0.8; }
            50% { opacity: 1; }
            100% { opacity: 0.8; }
        }

        .typing-text {
            overflow: hidden;
            white-space: nowrap;
            opacity: 0;
            animation:
                typewriter 4s steps(40) forwards,
                fadeInUp 1s forwards,
                neonPulse 2s infinite 4s;
            position: relative;
            margin: 0 auto;
            display: inline-block;
        }

        /* Responsive design */
        @media (min-width: 1200px) {
            .line-1 {
                font-size: 3rem;
            }
            .line-2 {
                font-size: 5rem;
            }
            .line-3 {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 992px) {
            .line-1 {
                font-size: 2.2rem;
            }
            .line-2 {
                font-size: 3.6rem;
            }
            .line-3 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 768px) {
            .description-container {
                padding: 1.5rem;
            }
            .line-1 {
                font-size: 1.8rem;
            }
            .line-2 {
                font-size: 3rem;
            }
            .line-3 {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .description-container {
                padding: 1rem;
            }
            .line-1 {
                font-size: 1.3rem;
                white-space: normal;
            }
            .line-2 {
                font-size: 2.2rem;
            }
            .line-3 {
                font-size: 0.9rem;
                white-space: normal;
            }
            .typing-text {
                white-space: normal;
            }
        }

        /* Custom animated elements */
        .car-icon {
            display: inline-block;
            animation: driveCar 2s ease-in-out infinite;
            margin-left: 8px;
            font-size: 3rem; /* Increased size */
        }

        @keyframes driveCar {
            0% { transform: translateX(0); }
            50% { transform: translateX(10px); }
            100% { transform: translateX(0); }
        }

        /* Visual enhancements */
        .accent-text {
            color: #ff0000;
            font-weight: 900;
            text-shadow: 0 0 15px rgba(255, 0, 0, 0.7);
        }

        .sparkle {
            animation: sparkle 1.5s ease-in-out infinite;
            display: inline-block;
            margin-left: 5px;
        }

        @keyframes sparkle {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">


        <div class="main-container">
            <div class="car-section">
                <div class="car-image-container">
                <img src="/images/background.png" alt="Luxury Car" class="car-image">
                <div class="description-container">
                    <div class="description-line line-1 typing-text" style="animation-delay: 0s">
                        Rent Your
                    </div>
                    <div class="description-line line-1 typing-text" style="animation-delay: 2s">
                        Perfect Ride With
                    </div>
                    <div class="description-line line-2 typing-text" style="animation-delay: 4s">
                        CASONS
                    </div>
                    <p class="description-line line-3 typing-text" style="animation-delay: 6s">
                        Journey that starts with ease! <span class="car-icon">🚗</span>
                    </p>
                </div></div>
            </div>

            <div class="login-section">
                <div class="background" id="background">
                    <div class="star-layer" id="starLayer1"></div>
                    <div class="star-layer" id="starLayer2"></div>
                    <div class="star-layer" id="starLayer3"></div>
                    <div class="star-layer" id="starLayer4"></div>
                </div>
                <div class="relative z-10 m-0">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
            function createStars(layerId, color, count, maxSize) {
                const layer = document.getElementById(layerId);

                for (let i = 0; i < count; i++) {
                    const star = document.createElement('div');
                    star.classList.add('star');

                    star.style.left = `${Math.random() * 100}%`;
                    star.style.top = `${Math.random() * 100}%`;

                    const size = Math.random() * maxSize + 1;
                    star.style.width = `${size}px`;
                    star.style.height = `${size}px`;

                    star.style.backgroundColor = color;
                    star.style.animationDelay = `${Math.random() * 3}s`;

                    layer.appendChild(star);
                }
            }

            window.onload = function() {
                createStars('starLayer1', '#ff00ff', 100, 2);
                createStars('starLayer2', '#00ffff', 100, 2);
                createStars('starLayer3', '#ff3366', 100, 2);
                createStars('starLayer4', '#33ff33', 100, 2);
            }

            let tick = 0;
            function animateBackground() {
                tick += 0.1;
                const x = Math.sin(tick * 0.05) * 10;
                const y = Math.cos(tick * 0.05) * 10;

                document.querySelectorAll('.star-layer').forEach(layer => {
                    layer.style.transform = `perspective(1000px) rotateX(${y}deg) rotateY(${x}deg)`;
                });

                requestAnimationFrame(animateBackground);
            }

            animateBackground();
        </script>
    </body>
</html>
