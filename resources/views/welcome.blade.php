<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dental Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                        secondary: {
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                        },
                        accent: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease forwards',
                        'fade-in-right': 'fadeInRight 0.8s ease forwards',
                        'fade-in-left': 'fadeInLeft 0.8s ease forwards',
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'spin-slow': 'spin 8s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeInRight: {
                            '0%': { opacity: '0', transform: 'translateX(-20px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        fadeInLeft: {
                            '0%': { opacity: '0', transform: 'translateX(20px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'hero-pattern': "url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%239CA3AF\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')",
                    },
                },
            },
        }
    </script>

    <style>
        /* Base Styles */
        :root {
            --primary: #0ea5e9;
            --primary-light: #38bdf8;
            --primary-dark: #0284c7;
            --secondary: #6366f1;
            --secondary-dark: #4f46e5;
            --accent: #f59e0b;
            --gray-light: #f3f4f6;
            --gray-medium: #9ca3af;
            --gray-dark: #1f2937;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--gray-dark);
            overflow-x: hidden;
        }

        /* Animated Background Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(14, 165, 233, 0.15), rgba(99, 102, 241, 0.15));
            z-index: 0;
        }

        .shape-blur {
            filter: blur(70px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            background-color: #f5f5f5;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background: linear-gradient(var(--primary), var(--secondary));
        }

        ::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #f5f5f5;
        }

        /* Animated Underline Effect */
        .hover-underline {
            position: relative;
            text-decoration: none;
            cursor: pointer;
        }

        .hover-underline::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform-origin: right;
            transform: scaleX(0);
            transition: transform 0.3s ease-out;
        }

        .hover-underline:hover::after {
            transform-origin: left;
            transform: scaleX(1);
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(14, 165, 233, 0.4);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-primary::after {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 25%;
            width: 50%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transform: skewX(-25deg);
            transition: all 0.4s ease;
            opacity: 0;
        }

        .btn-primary:hover::after {
            opacity: 1;
            left: -10%;
            width: 120%;
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-outline {
            border: 2px solid;
            border-image: linear-gradient(135deg, var(--primary), var(--secondary)) 1;
            background-origin: border-box;
            background-clip: content-box, border-box;
            position: relative;
            color: var(--primary);
            transition: all 0.3s ease;
            z-index: 1;
        }

        .btn-outline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            transition: all 0.3s ease;
            z-index: -1;
            opacity: 0;
        }

        .btn-outline:hover {
            color: white;
            border-image: none;
            border-color: transparent;
        }

        .btn-outline:hover::before {
            width: 100%;
            opacity: 1;
        }

        /* Card Styles */
        .feature-card {
            position: relative;
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
            z-index: 1;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            opacity: 0;
            z-index: -1;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .feature-card:hover::before {
            opacity: 0.02;
        }

        /* Service Card Icon */
        .service-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.2), rgba(99, 102, 241, 0.2));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--primary);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .service-icon {
            transform: rotateY(180deg);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        /* Testimonial Card */
        .testimonial-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .testimonial-card:hover {
            transform: scale(1.03);
        }

        .testimonial-card::after {
            content: '"';
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 8rem;
            font-family: Georgia, serif;
            color: rgba(14, 165, 233, 0.1);
            line-height: 1;
        }

        /* Team Member Card */
        .team-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .team-card:hover {
            transform: translateY(-5px);
        }

        .team-card img {
            transition: all 0.8s ease;
        }

        .team-card:hover img {
            transform: scale(1.05);
        }

        .social-links {
            position: absolute;
            bottom: -40px;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            padding: 15px 0 10px;
            transition: all 0.3s ease;
        }

        .team-card:hover .social-links {
            bottom: 0;
        }

        /* Ripple Button Effect */
        .ripple-btn {
            position: relative;
            overflow: hidden;
        }

        .ripple-btn::after {
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

        .ripple-btn:active::after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }

        /* Floating Animation */
        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Staggered Animation Delays */
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }

        /* Custom Glow Effect */
        .glow-effect {
            position: relative;
        }

        .glow-effect::before {
            content: '';
            background: linear-gradient(45deg,
                var(--primary),
                var(--secondary),
                var(--accent),
                var(--primary)
            );
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 400%;
            z-index: -1;
            filter: blur(10px);
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            animation: glowing 20s linear infinite;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            border-radius: inherit;
        }

        .glow-effect:hover::before {
            opacity: 0.7;
        }

        @keyframes glowing {
            0% { background-position: 0 0; }
            50% { background-position: 400% 0; }
            100% { background-position: 0 0; }
        }

        /* Counter Animation */
        .counter-value {
            transition: all 0.3s ease;
        }

        /* Section Styles */
        .section-heading {
            position: relative;
            display: inline-block;
        }

        .section-heading::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 3px;
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }

        /* Navigation Styles */
        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.5s ease;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .active-link::after {
            transform: scaleX(1);
        }

        /* Enhanced Mobile Navigation */
        .mobile-nav {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            transform: translateX(100%);
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
            z-index: 50;
        }

        .mobile-nav.open {
            transform: translateX(0);
        }

        .mobile-nav-link {
            position: relative;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .mobile-nav-link:hover, .mobile-nav-link.active {
            background-color: rgba(14, 165, 233, 0.05);
            border-left: 3px solid var(--primary);
        }

        .mobile-nav-link i {
            transition: transform 0.3s ease;
        }

        .mobile-nav-link:hover i {
            transform: translateX(5px);
        }

        /* Hamburger Menu Animation */
        .hamburger {
            width: 24px;
            height: 20px;
            position: relative;
            cursor: pointer;
            display: inline-block;
        }

        .hamburger span {
            display: block;
            position: absolute;
            height: 2px;
            width: 100%;
            background: var(--gray-dark);
            border-radius: 2px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }

        .hamburger span:nth-child(1) {
            top: 0px;
        }

        .hamburger span:nth-child(2), .hamburger span:nth-child(3) {
            top: 9px;
        }

        .hamburger span:nth-child(4) {
            top: 18px;
        }

        .hamburger.open span:nth-child(1) {
            top: 9px;
            width: 0%;
            left: 50%;
        }

        .hamburger.open span:nth-child(2) {
            transform: rotate(45deg);
            background: var(--primary);
        }

        .hamburger.open span:nth-child(3) {
            transform: rotate(-45deg);
            background: var(--primary);
        }

        .hamburger.open span:nth-child(4) {
            top: 9px;
            width: 0%;
            left: 50%;
        }

        /* Backdrop Filter */
        .backdrop-blur {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* 3D Feature Card */
        .card-3d {
            perspective: 1000px;
            transform-style: preserve-3d;
            transition: all 0.3s ease;
        }

        .card-3d:hover {
            transform: rotateY(5deg) rotateX(5deg);
        }

        .card-3d-img {
            transform: translateZ(20px);
            transition: all 0.3s ease;
        }

        .card-3d:hover .card-3d-img {
            transform: translateZ(30px);
        }

        /* Rotating Gear Animation */
        .gear-icon {
            transition: transform 2s ease;
        }

        .feature-card:hover .gear-icon {
            transform: rotate(180deg);
        }

        /* Parallax Effect */
        .parallax {
            transition: transform 0.5s cubic-bezier(0, 0, 0.2, 1);
        }

        /* Gallery Image Hover */
        .gallery-img {
            transition: all 0.3s ease;
        }

        .gallery-img:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        /* Progress Bar Animation */
        .progress-bar {
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.5) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        /* Enhanced Mobile Styles */
        .mobile-menu-header {
            position: relative;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            background: linear-gradient(to right, rgba(14, 165, 233, 0.05), rgba(99, 102, 241, 0.05));
        }

        .mobile-menu-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(229, 231, 235, 0.5);
            background: linear-gradient(to right, rgba(14, 165, 233, 0.05), rgba(99, 102, 241, 0.05));
        }

        .mobile-menu-body {
            padding: 1.5rem;
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        /* Sticky Header Effect */
        .sticky-header {
            transition: all 0.3s ease;
        }

        .sticky-header.scrolled {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.95);
        }

        /* Pulse Animation for Notification */
        .notification-pulse {
            position: relative;
        }

        .notification-pulse::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background-color: var(--accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(245, 158, 11, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
            }
        }

        /* Rotating Animation */
        .rotate-animation {
            animation: spin-slow 8s linear infinite;
        }

        /* Gradient Border */
        .gradient-border {
            position: relative;
            border-radius: 0.5rem;
            padding: 1px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        .gradient-border-content {
            background: white;
            border-radius: 0.4rem;
            padding: 1rem;
        }

        /* Floating Badges Enhanced */
        .floating-badge {
            position: absolute;
            background: white;
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            z-index: 10;
            animation: float 6s ease-in-out infinite;
        }

        .floating-badge::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 0.85rem;
            z-index: -1;
            opacity: 0.2;
        }

        /* Enhanced Responsive Styles */
        @media (max-width: 1023px) {
            .hero-section {
                padding-top: 6rem;
            }

            .floating-badge {
                transform: scale(0.85);
            }

            .hero-buttons {
                flex-direction: column;
                width: 100%;
                gap: 0.75rem;
            }

            .hero-buttons a {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .hero-heading {
                font-size: 2.25rem;
                line-height: 1.2;
            }

            .section-heading {
                font-size: 1.75rem;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .social-links {
                bottom: 0;
            }

            .contact-info {
                flex-direction: column;
            }

            .floating-badge {
                position: relative;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                margin: 1rem 0;
                width: 100%;
                transform: none !important;
            }

            .stats-card {
                position: relative !important;
                transform: none !important;
                margin: 1.5rem 0;
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .hero-heading {
                font-size: 2rem;
            }

            .section-heading {
                font-size: 1.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .hero-buttons a {
                width: 100%;
                margin: 0.5rem 0;
            }

            .testimonial-card::after {
                font-size: 5rem;
            }
        }

        /* New Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.5s ease-out forwards;
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-zoom-in {
            animation: zoomIn 0.5s ease-out forwards;
        }

        /* Scroll Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Gradient Overlay for Images */
        .gradient-overlay {
            position: relative;
        }

        .gradient-overlay::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.7));
            z-index: 1;
        }

        /* Enhanced Mobile Navigation Icons */
        .mobile-nav-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(99, 102, 241, 0.1));
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .mobile-nav-link:hover .mobile-nav-icon {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            transform: scale(1.1);
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <!-- Shape Elements -->
    <div class="shape shape-blur w-[300px] h-[300px] top-[-100px] right-[-100px] opacity-20"></div>
    <div class="shape shape-blur w-[400px] h-[400px] bottom-[20%] left-[-200px] opacity-10"></div>

    <!-- Navbar -->
    <header id="sticky-header" class="sticky-header fixed w-full bg-white/90 backdrop-blur shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#" class="flex items-center space-x-2">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center">
                            <i class="fas fa-tooth text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">DentalCare</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-6 xl:space-x-10">
                    <a href="#home" class="nav-link active-link text-sm font-medium text-gray-700 hover:text-primary-500 transition-colors px-2 py-1">Home</a>
                    <a href="#services" class="nav-link text-sm font-medium text-gray-700 hover:text-primary-500 transition-colors px-2 py-1">Services</a>
                    <a href="#about" class="nav-link text-sm font-medium text-gray-700 hover:text-primary-500 transition-colors px-2 py-1">About</a>
                    <a href="#testimonials" class="nav-link text-sm font-medium text-gray-700 hover:text-primary-500 transition-colors px-2 py-1">Testimonials</a>
                    <a href="#contact" class="nav-link text-sm font-medium text-gray-700 hover:text-primary-500 transition-colors px-2 py-1">Contact</a>
                </nav>

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        <div class="hidden sm:flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-primary py-2 px-4 rounded-lg text-sm font-medium text-white">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-outline py-2 px-4 rounded-lg text-sm font-medium">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-primary py-2 px-4 rounded-lg text-sm font-medium text-white">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif

                    <!-- Mobile menu button -->
                    <button id="menu-toggle" class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary-500 focus:outline-none" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <div class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="mobile-nav fixed top-0 right-0 bottom-0 w-[280px] bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out overflow-hidden lg:hidden">
            <div class="mobile-menu-header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center">
                            <i class="fas fa-tooth text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">DentalCare</span>
                    </div>
                    <button id="close-menu" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="fas fa-times text-gray-500 text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="mobile-menu-body">
                <div class="space-y-1">
                    <a href="#home" class="mobile-nav-link flex items-center px-4 py-3 rounded-lg">
                        <div class="mobile-nav-icon">
                            <i class="fas fa-home text-primary-500"></i>
                        </div>
                        <span class="font-medium">Home</span>
                    </a>
                    <a href="#services" class="mobile-nav-link flex items-center px-4 py-3 rounded-lg">
                        <div class="mobile-nav-icon">
                            <i class="fas fa-tooth text-primary-500"></i>
                        </div>
                        <span class="font-medium">Services</span>
                    </a>
                    <a href="#about" class="mobile-nav-link flex items-center px-4 py-3 rounded-lg">
                        <div class="mobile-nav-icon">
                            <i class="fas fa-info-circle text-primary-500"></i>
                        </div>
                        <span class="font-medium">About</span>
                    </a>
                    <a href="#testimonials" class="mobile-nav-link flex items-center px-4 py-3 rounded-lg">
                        <div class="mobile-nav-icon">
                            <i class="fas fa-star text-primary-500"></i>
                        </div>
                        <span class="font-medium">Testimonials</span>
                    </a>
                    <a href="#contact" class="mobile-nav-link flex items-center px-4 py-3 rounded-lg">
                        <div class="mobile-nav-icon">
                            <i class="fas fa-envelope text-primary-500"></i>
                        </div>
                        <span class="font-medium">Contact</span>
                    </a>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex flex-col space-y-3">
                        <a href="tel:+11234567890" class="flex items-center px-4 py-3 text-primary-500 hover:bg-primary-50 rounded-lg transition-colors">
                            <div class="mobile-nav-icon">
                                <i class="fas fa-phone-alt text-primary-500"></i>
                            </div>
                            <span class="font-medium">Call Us</span>
                        </a>
                        <a href="mailto:info@dentalcare.com" class="flex items-center px-4 py-3 text-primary-500 hover:bg-primary-50 rounded-lg transition-colors">
                            <div class="mobile-nav-icon">
                                <i class="fas fa-envelope text-primary-500"></i>
                            </div>
                            <span class="font-medium">Email Us</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mobile-menu-footer">
                @if (Route::has('login'))
                    <div class="space-y-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block w-full text-center btn-primary py-3 px-4 rounded-lg text-sm font-medium text-white">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center btn-outline py-3 px-4 rounded-lg text-sm font-medium">
                                <i class="fas fa-sign-in-alt mr-2"></i> Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block w-full text-center btn-primary py-3 px-4 rounded-lg text-sm font-medium text-white">
                                    <i class="fas fa-user-plus mr-2"></i> Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

                <div class="mt-6 flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-primary-500 transition-colors">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary-500 transition-colors">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary-500 transition-colors">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Overlay for mobile menu -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out lg:hidden"></div>

    <!-- Hero Section -->
    <section id="home" class="hero-section relative pt-28 md:pt-32 pb-16 md:pb-24 bg-hero-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="lg:w-1/2 mb-10 lg:mb-0">
                    <h1 class="hero-heading text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-gray-900 mb-6 animate-fade-in-up">
                        Professional <span class="gradient-text">Dental Care</span> for Your Perfect Smile
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed animate-fade-in-up stagger-1">
                        Experience top-quality dental services with our team of experienced professionals dedicated to your oral health and beautiful smile.
                    </p>
                    <div class="hero-buttons flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0 animate-fade-in-up stagger-2">
                        <a href="#appointment" class="ripple-btn btn-primary py-3 px-8 rounded-lg text-base font-medium text-white flex items-center justify-center">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Book Appointment
                        </a>
                        <a href="#services" class="ripple-btn btn-outline py-3 px-8 rounded-lg text-base font-medium flex items-center justify-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Learn More
                        </a>
                    </div>

                    <div class="mt-10 flex items-center animate-fade-in-up stagger-3">
                        <div class="flex -space-x-2 mr-4">
                            <img src="{{ asset('images/avatar-1.jpg') }}" alt="Patient" class="w-10 h-10 rounded-full border-2 border-white" onerror="this.src='https://via.placeholder.com/40?text=P'">
                            <img src="{{ asset('images/avatar-2.jpg') }}" alt="Patient" class="w-10 h-10 rounded-full border-2 border-white" onerror="this.src='https://via.placeholder.com/40?text=P'">
                            <img src="{{ asset('images/avatar-3.jpg') }}" alt="Patient" class="w-10 h-10 rounded-full border-2 border-white" onerror="this.src='https://via.placeholder.com/40?text=P'">
                            <img src="{{ asset('images/avatar-4.jpg') }}" alt="Patient" class="w-10 h-10 rounded-full border-2 border-white" onerror="this.src='https://via.placeholder.com/40?text=P'">
                        </div>
                        <div>
                            <div class="flex items-center mb-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="ml-2 text-gray-600 font-medium">5.0</span>
                            </div>
                            <p class="text-sm text-gray-500">Trusted by 10,000+ happy patients</p>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 relative">
                    <div class="relative rounded-xl overflow-hidden shadow-2xl animate-fade-in-right">
                        <img src="{{ asset('images/dental-hero.jpg') }}" alt="Dental Care" class="w-full h-auto" onerror="this.src='https://via.placeholder.com/600x400?text=Dental+Care'">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-600/20 to-transparent"></div>
                    </div>

                    <!-- Floating Badges -->
                    <div class="floating-badge top-6 -left-6 animate-float stagger-1 hidden sm:block">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-3 rounded-full mr-3">
                                <i class="fas fa-check text-green-500"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Modern Equipment</h3>
                                <p class="text-xs text-gray-500">State-of-the-art technology</p>
                            </div>
                        </div>
                    </div>

                    <div class="floating-badge bottom-6 -right-6 animate-float stagger-2 hidden sm:block">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full mr-3">
                                <i class="fas fa-certificate text-primary-500"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Certified Experts</h3>
                                <p class="text-xs text-gray-500">Professional dentists</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary-500 font-semibold text-sm tracking-wider uppercase">Why Choose Us</span>
                <h2 class="section-heading text-3xl md:text-4xl font-bold text-gray-900 mt-2">Features that set us apart</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-6 rounded-xl shadow-lg card-3d animate-fade-in-up reveal">
                    <div class="service-icon">
                        <i class="fas fa-tooth gear-icon"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Advanced Technology</h3>
                    <p class="text-gray-600 mb-4">We utilize the latest dental technology to ensure precise diagnostics and comfortable treatments.</p>
                    <a href="#" class="text-primary-500 hover:text-primary-600 flex items-center font-medium hover-underline">
                        Learn more
                        <i class="fas fa-arrow-right ml-1 text-sm"></i>
                    </a>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card p-6 rounded-xl shadow-lg card-3d animate-fade-in-up stagger-1 reveal">
                    <div class="service-icon">
                        <i class="fas fa-user-md gear-icon"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Expert Dentists</h3>
                    <p class="text-gray-600 mb-4">Our team consists of experienced specialists dedicated to providing exceptional dental care.</p>
                    <a href="#" class="text-primary-500 hover:text-primary-600 flex items-center font-medium hover-underline">
                        Meet our team
                        <i class="fas fa-arrow-right ml-1 text-sm"></i>
                    </a>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card p-6 rounded-xl shadow-lg card-3d animate-fade-in-up stagger-2 reveal">
                    <div class="service-icon">
                        <i class="fas fa-calendar-check gear-icon"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Convenient Scheduling</h3>
                    <p class="text-gray-600 mb-4">Easy online booking and flexible appointment times to accommodate your busy schedule.</p>
                    <a href="#" class="text-primary-500 hover:text-primary-600 flex items-center font-medium hover-underline">
                        Book now
                        <i class="fas fa-arrow-right ml-1 text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary-500 font-semibold text-sm tracking-wider uppercase">Our Services</span>
                <h2 class="section-heading text-3xl md:text-4xl font-bold text-gray-900 mt-2">Comprehensive Dental Solutions</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    We offer a wide range of dental services to meet all your oral health needs in one convenient location.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl reveal">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/service-general-dentistry.jpg') }}" alt="General Dentistry" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" onerror="this.src='https://via.placeholder.com/400x300?text=General+Dentistry'">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">General Dentistry</h3>
                        <p class="text-gray-600 mb-4">Comprehensive examinations, cleanings, fillings, and preventive care for patients of all ages.</p>
                        <a href="#" class="inline-block text-primary-500 hover:text-primary-600 font-medium hover-underline">
                            Learn more <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl reveal">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/service-cosmetic-dentistry.jpg') }}" alt="Cosmetic Dentistry" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" onerror="this.src='https://via.placeholder.com/400x300?text=Cosmetic+Dentistry'">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Cosmetic Dentistry</h3>
                        <p class="text-gray-600 mb-4">Teeth whitening, veneers, bonding, and other services to enhance your smile's appearance.</p>
                        <a href="#" class="inline-block text-primary-500 hover:text-primary-600 font-medium hover-underline">
                            Learn more <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl reveal">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/service-orthodontics.jpg') }}" alt="Orthodontics" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" onerror="this.src='https://via.placeholder.com/400x300?text=Orthodontics'">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Orthodontics</h3>
                        <p class="text-gray-600 mb-4">Traditional braces, clear aligners, and other treatments to straighten teeth and correct bite issues.</p>
                        <a href="#" class="inline-block text-primary-500 hover:text-primary-600 font-medium hover-underline">
                            Learn more <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl reveal">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/service-dental-implants.jpg') }}" alt="Dental Implants" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" onerror="this.src='https://via.placeholder.com/400x300?text=Dental+Implants'">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Dental Implants</h3>
                        <p class="text-gray-600 mb-4">Permanent, natural-looking tooth replacements to restore function and aesthetics.</p>
                        <a href="#" class="inline-block text-primary-500 hover:text-primary-600 font-medium hover-underline">
                            Learn more <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl reveal">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/service-pediatric-dentistry.jpg') }}" alt="Pediatric Dentistry" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" onerror="this.src='https://via.placeholder.com/400x300?text=Pediatric+Dentistry'">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Pediatric Dentistry</h3>
                        <p class="text-gray-600 mb-4">Specialized, gentle dental care for children in a comfortable, kid-friendly environment.</p>
                        <a href="#" class="inline-block text-primary-500 hover:text-primary-600 font-medium hover-underline">
                            Learn more <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 6 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl reveal">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/service-emergency-dentistry.jpg') }}" alt="Emergency Dentistry" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" onerror="this.src='https://via.placeholder.com/400x300?text=Emergency+Dentistry'">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Emergency Dentistry</h3>
                        <p class="text-gray-600 mb-4">Prompt care for dental emergencies such as toothaches, broken teeth, or lost fillings.</p>
                        <a href="#" class="inline-block text-primary-500 hover:text-primary-600 font-medium hover-underline">
                            Learn more <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="lg:w-1/2 mb-10 lg:mb-0 relative">
                    <div class="relative rounded-xl overflow-hidden shadow-2xl animate-fade-in-left reveal">
                        <img src="{{ asset('images/dental-clinic.jpg') }}" alt="Our Dental Clinic" class="w-full" onerror="this.src='https://via.placeholder.com/600x400?text=Dental+Clinic'">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-600/20 to-transparent"></div>
                    </div>

                    <div class="stats-card absolute -bottom-6 -right-6 bg-white rounded-lg shadow-lg p-5 animate-fade-in-up stagger-1 hidden sm:block">
                        <div class="flex items-center space-x-4">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-primary-500 counter-value" data-value="15">15</span>
                                <span class="text-gray-500 text-sm">Years</span>
                            </div>
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-primary-500 counter-value" data-value="20">20</span>
                                <span class="text-gray-500 text-sm">Dentists</span>
                            </div>
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-primary-500 counter-value" data-value="10000">10K+</span>
                                <span class="text-gray-500 text-sm">Patients</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 lg:pl-10 reveal">
                    <span class="text-primary-500 font-semibold text-sm tracking-wider uppercase">About Us</span>
                    <h2 class="section-heading text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-6">Your Trusted Dental Care Partner</h2>

                    <p class="text-gray-600 mb-4 leading-relaxed">
                        For over 15 years, our dental practice has been providing exceptional care to patients of all ages. Our mission is to deliver personalized dental services that prioritize your comfort, health, and satisfaction.
                    </p>

                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Our team of highly skilled dentists and friendly staff are committed to staying at the forefront of dental advancements to offer you the most effective treatments available in a comfortable, state-of-the-art environment.
                    </p>

                    <div class="mb-8">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-check-circle text-primary-500 mr-3"></i>
                            <span class="text-gray-700">Personalized treatment plans for each patient</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-check-circle text-primary-500 mr-3"></i>
                            <span class="text-gray-700">Cutting-edge dental technology and techniques</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-check-circle text-primary-500 mr-3"></i>
                            <span class="text-gray-700">Comfortable, relaxing environment</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-primary-500 mr-3"></i>
                            <span class="text-gray-700">Transparent pricing and payment options</span>
                        </div>
                    </div>

                    <a href="#contact" class="ripple-btn btn-primary py-3 px-8 rounded-lg text-base font-medium text-white inline-flex items-center">
                        <i class="fas fa-phone-alt mr-2"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary-500 font-semibold text-sm tracking-wider uppercase">Testimonials</span>
                <h2 class="section-heading text-3xl md:text-4xl font-bold text-gray-900 mt-2">What Our Patients Say</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Don't just take our word for it - hear what our satisfied patients have to say about their experiences.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card bg-white rounded-xl shadow-md p-6 relative reveal">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/patient-1.jpg') }}" alt="Patient" class="w-12 h-12 rounded-full mr-4" onerror="this.src='https://via.placeholder.com/48?text=P'">
                        <div>
                            <h4 class="font-semibold text-gray-800">Sarah Johnson</h4>
                            <p class="text-sm text-gray-500">Regular Patient</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 italic">"I've been coming to this dental practice for years, and I'm always impressed by the professionalism and care I receive. The staff is friendly, and my appointments are always on time."</p>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card bg-white rounded-xl shadow-md p-6 relative reveal">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/patient-2.jpg') }}" alt="Patient" class="w-12 h-12 rounded-full mr-4" onerror="this.src='https://via.placeholder.com/48?text=P'">
                        <div>
                            <h4 class="font-semibold text-gray-800">Michael Thompson</h4>
                            <p class="text-sm text-gray-500">Cosmetic Dentistry Patient</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 italic">"The cosmetic dental work I received completely transformed my smile. The results exceeded my expectations, and the procedure was much more comfortable than I anticipated."</p>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card bg-white rounded-xl shadow-md p-6 relative reveal">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/patient-3.jpg') }}" alt="Patient" class="w-12 h-12 rounded-full mr-4" onerror="this.src='https://via.placeholder.com/48?text=P'">
                        <div>
                            <h4 class="font-semibold text-gray-800">Jennifer Davis</h4>
                            <p class="text-sm text-gray-500">Parent of Pediatric Patient</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 italic">"As a parent, I appreciate how patient and gentle the staff is with my children. They've made dental visits a positive experience, and my kids actually look forward to their appointments!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary-500 font-semibold text-sm tracking-wider uppercase">Get In Touch</span>
                <h2 class="section-heading text-3xl md:text-4xl font-bold text-gray-900 mt-2">Contact Us</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Have questions or ready to schedule an appointment? Reach out to our friendly team today.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-gray-50 rounded-xl shadow-md p-8 reveal">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Send us a message</h3>
                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 transition-all">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 transition-all">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 transition-all">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 transition-all"></textarea>
                        </div>
                        <button type="submit" class="ripple-btn btn-primary py-3 px-6 rounded-lg text-base font-medium text-white w-full">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>

                <div class="reveal">
                    <div class="mb-10">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Contact Information</h3>
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="bg-primary-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-map-marker-alt text-primary-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 mb-1">Address</h4>
                                    <p class="text-gray-600">123 Dental Care Street<br>Health District, City 12345</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-phone-alt text-primary-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 mb-1">Phone</h4>
                                    <p class="text-gray-600">(123) 456-7890</p>
                                    <p class="text-gray-600">(123) 456-7891</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-envelope text-primary-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 mb-1">Email</h4>
                                    <p class="text-gray-600">info@dentalcare.com</p>
                                    <p class="text-gray-600">appointments@dentalcare.com</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-clock text-primary-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 mb-1">Office Hours</h4>
                                    <p class="text-gray-600">Monday - Friday: 8:00 AM - 6:00 PM</p>
                                    <p class="text-gray-600">Saturday: 9:00 AM - 2:00 PM</p>
                                    <p class="text-gray-600">Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Google Map Embed -->
                    <div class="rounded-xl overflow-hidden shadow-md h-[300px]">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369674829017!3d40.71277287932888!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a23e28c1191%3A0x49324989e1d54767!2s123%20Broadway%2C%20New%20York%2C%20NY%2010007!5e0!3m2!1sen!2sus!4v1651234567890!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 bg-gradient-to-r from-primary-600 to-secondary-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Schedule Your Appointment?</h2>
            <p class="text-lg mb-8 max-w-3xl mx-auto">
                Take the first step towards a healthier smile. Our team is ready to provide you with exceptional dental care.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#appointment" class="ripple-btn bg-white text-primary-600 hover:bg-gray-100 py-3 px-8 rounded-lg text-base font-medium inline-flex items-center justify-center">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Book Appointment
                </a>
                <a href="tel:+11234567890" class="ripple-btn border-2 border-white bg-transparent hover:bg-white/10 py-3 px-8 rounded-lg text-base font-medium inline-flex items-center justify-center">
                    <i class="fas fa-phone-alt mr-2"></i>
                    Call Us Now
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center space-x-2 mb-6">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center">
                            <i class="fas fa-tooth text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold">DentalCare</span>
                    </div>
                    <p class="text-gray-400 mb-6">
                        Providing quality dental care with a focus on patient comfort and satisfaction. Our modern practice combines advanced technology with personalized attention.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition-colors hover-underline">Home</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition-colors hover-underline">Services</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors hover-underline">About Us</a></li>
                        <li><a href="#testimonials" class="text-gray-400 hover:text-white transition-colors hover-underline">Testimonials</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors hover-underline">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6">Services</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors hover-underline">General Dentistry</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors hover-underline">Cosmetic Dentistry</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors hover-underline">Orthodontics</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors hover-underline">Dental Implants</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors hover-underline">Pediatric Dentistry</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-400"></i>
                            <span class="text-gray-400">123 Dental Care Street<br>Health District, City 12345</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-primary-400"></i>
                            <span class="text-gray-400">(123) 456-7890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary-400"></i>
                            <span class="text-gray-400">info@dentalcare.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-gray-800 mb-8">

            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} DentalCare. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors hover-underline">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors hover-underline">Terms of Service</a>
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors hover-underline">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a id="back-to-top" href="#" class="fixed bottom-6 right-6 bg-primary-500 text-white rounded-full p-3 shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-primary-600">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('overlay');
        const closeMenu = document.getElementById('close-menu');
        const hamburger = document.querySelector('.hamburger');

        function toggleMenu() {
            mobileMenu.classList.toggle('open');
            overlay.classList.toggle('opacity-50');
            overlay.classList.toggle('pointer-events-none');
            hamburger.classList.toggle('open');
            document.body.classList.toggle('overflow-hidden');
        }

        menuToggle.addEventListener('click', toggleMenu);
        closeMenu.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // Smooth Scrolling for Navigation Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                // Close mobile menu if open
                if (mobileMenu.classList.contains('open')) {
                    toggleMenu();
                }

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Back to Top Button
        const backToTopButton = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }

            // Sticky Header Effect
            const header = document.getElementById('sticky-header');
            if (window.pageYOffset > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Animation for Counter Values
        const counters = document.querySelectorAll('.counter-value');

        const animateCounter = (counter) => {
            const targetValue = parseInt(counter.getAttribute('data-value'));
            const duration = 2000; // 2 seconds
            const startTime = performance.now();
            let currentValue = 0;

            function updateCounter(currentTime) {
                const elapsedTime = currentTime - startTime;
                const progress = Math.min(elapsedTime / duration, 1);

                // Easing function: easeOutCubic
                const easedProgress = 1 - Math.pow(1 - progress, 3);

                currentValue = Math.floor(easedProgress * targetValue);
                counter.textContent = currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = targetValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }

            requestAnimationFrame(updateCounter);
        };

        // Scroll Reveal Animation
        const revealElements = document.querySelectorAll('.reveal');
        
        function checkReveal() {
            const windowHeight = window.innerHeight;
            const revealPoint = 150;

            revealElements.forEach(element => {
                const revealTop = element.getBoundingClientRect().top;

                if (revealTop < windowHeight - revealPoint) {
                    element.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', checkReveal);
        window.addEventListener('load', checkReveal);

        // Intersection Observer for Counters
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });

        // Add parallax effect to images
        window.addEventListener('mousemove', (e) => {
            const parallaxElements = document.querySelectorAll('.parallax');

            parallaxElements.forEach(element => {
                const speed = element.getAttribute('data-speed') || 0.1;
                const x = (window.innerWidth - e.pageX * speed) / 100;
                const y = (window.innerHeight - e.pageY * speed) / 100;

                element.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });
        });

        // Active link highlighting
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

        function highlightNavLink() {
            const scrollY = window.pageYOffset;

            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 100;
                const sectionId = section.getAttribute('id');

                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    // Desktop nav
                    navLinks.forEach(link => {
                        link.classList.remove('active-link');
                        if (link.getAttribute('href') === '#' + sectionId) {
                            link.classList.add('active-link');
                        }
                    });

                    // Mobile nav
                    mobileNavLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === '#' + sectionId) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        }

        window.addEventListener('scroll', highlightNavLink);
        window.addEventListener('load', highlightNavLink);
    </script>
</body>
</html>
