<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dental Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #06b6d4;
            --primary-dark: #0891b2;
            --secondary: #0ea5e9;
            --secondary-dark: #0284c7;
            --accent: #2563eb;
            --accent-light: #60a5fa;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            /* Animation variables */
            --transition-fast: 0.2s;
            --transition-normal: 0.3s;
            --transition-slow: 0.5s;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
            transition: background-color var(--transition-normal);
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 60%, var(--secondary-dark) 100%);
            color: white;
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            transition: all var(--transition-normal) cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 20px;
        }

        .sidebar-brand {
            padding: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .sidebar-brand::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 10%;
            width: 80%;
            height: 1px;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(255, 255, 255, 0.3) 50%, 
                rgba(255, 255, 255, 0) 100%);
        }

        .sidebar-brand img {
            height: 50px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            transition: transform var(--transition-normal);
        }

        .sidebar-brand:hover img {
            transform: scale(1.05);
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .sidebar-menu-item {
            padding: 0.85rem 1.75rem;
            margin: 0.5rem 1rem;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.85);
            transition: all var(--transition-fast);
            border-radius: 12px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0) 100%);
            transition: width var(--transition-normal);
            z-index: -1;
        }

        .sidebar-menu-item:hover, .sidebar-menu-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .sidebar-menu-item:hover::before {
            width: 100%;
        }

        .sidebar-menu-item.active {
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0.2) 0%, 
                rgba(255, 255, 255, 0.05) 100%);
            font-weight: 500;
        }

        .sidebar-menu-item i {
            margin-right: 0.85rem;
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            transition: transform var(--transition-fast);
        }

        .sidebar-menu-item:hover i, .sidebar-menu-item.active i {
            transform: scale(1.1);
        }

        .sidebar-menu-item span {
            position: relative;
        }

        .sidebar-menu-item.active span::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0.8) 0%, 
                rgba(255, 255, 255, 0) 100%);
            border-radius: 2px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 1.5rem;
            min-height: 100vh;
            transition: all var(--transition-normal);
            background-color: var(--gray-50);
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 0.85rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all var(--transition-normal);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .navbar:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-toggler {
            display: none;
            background: none;
            border: none;
            color: var(--gray-600);
            font-size: 1.5rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-fast);
        }

        .navbar-toggler:hover {
            background-color: var(--gray-100);
            color: var(--primary);
        }

        .navbar-title {
            font-weight: 600;
            font-size: 1.25rem;
            margin-left: 1rem;
            color: var(--gray-800);
            display: none;
        }

        .navbar-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-profile-img {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--gray-200);
            transition: all var(--transition-fast);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar-profile:hover .navbar-profile-img {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .navbar-profile-text {
            font-weight: 600;
            color: var(--gray-800);
        }

        .navbar-profile-role {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--gray-100);
            color: var(--gray-600);
            border: none;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .navbar-action-btn:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--danger) 0%, #ff6b6b 100%);
            color: white;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-fast);
            text-decoration: none;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Cards */
        .card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all var(--transition-normal);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to right, rgba(6, 182, 212, 0.05), transparent);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-fast);
            cursor: pointer;
            border: none;
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(6, 182, 212, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(6, 182, 212, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--secondary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(14, 165, 233, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        .btn-outline-danger {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .btn-outline-danger:hover {
            background-color: var(--danger);
            color: white;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid transparent;
            display: flex;
            align-items: center;
            animation: slideIn var(--transition-normal) ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert::before {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-left-color: var(--success);
            color: #065f46;
        }

        .alert-success::before {
            content: "\f058";
            color: var(--success);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-left-color: var(--danger);
            color: #b91c1c;
        }

        .alert-danger::before {
            content: "\f057";
            color: var(--danger);
        }

        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            border-left-color: var(--warning);
            color: #b45309;
        }

        .alert-warning::before {
            content: "\f071";
            color: var(--warning);
        }

        .alert-info {
            background-color: rgba(14, 165, 233, 0.1);
            border-left-color: var(--secondary);
            color: #0369a1;
        }

        .alert-info::before {
            content: "\f05a";
            color: var(--secondary);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
            }

            .main-content {
                margin-left: 0;
            }

            .navbar-toggler {
                display: flex;
            }

            .navbar-title {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0.75rem 1rem;
            }

            .navbar-profile-text {
                display: none;
            }

            .navbar-actions {
                gap: 0.5rem;
            }

            .logout-btn span {
                display: none;
            }

            .logout-btn {
                width: 40px;
                padding: 0;
                justify-content: center;
            }

            .card-header {
                padding: 1.25rem;
            }

            .card-body {
                padding: 1.25rem;
            }
        }

        /* Overlay for mobile when sidebar is open */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-normal);
            backdrop-filter: blur(3px);
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Animations */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(6, 182, 212, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(6, 182, 212, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(6, 182, 212, 0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn var(--transition-normal) ease-out;
        }

        .pulse {
            animation: pulse 2s infinite;
        }
    </style>

    @yield('styles')
</head>
<body>
    <div id="app">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('user.user_dashboard') }}">
                    <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo">
                </a>
            </div>
            <div class="sidebar-menu">
                <a href="{{ route('user.user_dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('user.user_dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('user.book.appointment') }}" class="sidebar-menu-item {{ request()->routeIs('user.book.appointment') ? 'active' : '' }}">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Book Appointment</span>
                </a>
                <a href="{{ route('user.appointments') }}" class="sidebar-menu-item {{ request()->routeIs('user.appointments') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Appointments</span>
                </a>
                <a href="{{ route('user.profile') }}" class="sidebar-menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span>My Profile</span>
                </a>
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-tooth"></i>
                    <span>Dental Records</span>
                </a>
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-file-medical"></i>
                    <span>Treatment Plans</span>
                </a>
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Billing & Payments</span>
                </a>
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-question-circle"></i>
                    <span>Help & Support</span>
                </a>
            </div>
        </div>

        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <div class="navbar">
                <div class="navbar-left">
                    <button class="navbar-toggler" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="navbar-title">Dental Management</div>
                </div>
                <div class="navbar-profile">
                    <div class="navbar-actions">
                        <button class="navbar-action-btn">
                            <i class="fas fa-bell"></i>
                        </button>
                        <button class="navbar-action-btn">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                    <div class="navbar-profile-text">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="navbar-profile-role">Patient</div>
                    </div>
                    <img src="{{ asset('images/user.png') }}" alt="User" class="navbar-profile-img">
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Content -->
            <div class="content fade-in">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{ asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{ asset('assets/js/misc.js')}}"></script>
    <script src="{{ asset('assets/js/todolist.js')}}"></script>

    <script>
        // Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Function to toggle sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
                
                // Prevent body scrolling when sidebar is open on mobile
                if (sidebar.classList.contains('show')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
            
            // Event listeners
            sidebarToggle.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);
            
            // Close sidebar on window resize if screen becomes larger
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992 && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            
            // Add animation to menu items
            const menuItems = document.querySelectorAll('.sidebar-menu-item');
            menuItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-10px)';
                
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, 100 + (index * 50));
            });
        });
    </script>

    @yield('scripts')
</body>
</html>