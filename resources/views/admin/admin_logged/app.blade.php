<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dental Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-light: #38bdf8;
            --primary-dark: #0284c7;
            --secondary: #6366f1;
            --secondary-light: #818cf8;
            --secondary-dark: #4f46e5;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
        }

        /* Sidebar Styles */
        .sidebar {
            background: var(--white);
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--gray-100);
        }

        .sidebar-brand img {
            height: 40px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-brand img {
            height: 30px;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu-item {
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            color: var(--gray-600);
            transition: all 0.2s;
            border-radius: 0.75rem;
            margin: 0.25rem 1rem;
        }

        .sidebar-menu-item:hover,
        .sidebar-menu-item.active {
            background-color: var(--primary-light);
            color: var(--white);
            transform: translateX(5px);
        }

        .sidebar-menu-item i {
            width: 24px;
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        .sidebar.collapsed .sidebar-menu-item span,
        .sidebar.collapsed .sidebar-group-header {
            display: none;
        }

        .sidebar.collapsed .sidebar-menu-item {
            padding: 0.875rem;
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-menu-item i {
            margin-right: 0;
        }

        /* Updated Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s ease;
            background-color: var(--gray-50);
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Modern Navbar */
        .navbar {
            background-color: var(--white);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-toggler {
            background: none;
            border: none;
            color: var(--gray-600);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .navbar-toggler:hover {
            background-color: var(--gray-100);
            color: var(--primary);
        }

        /* Modern Cards */
        .card {
            background-color: var(--white);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border: none;
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.2);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: white;
        }

        .btn-secondary:hover {
            background-color: var(--secondary-dark);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background-color: var(--gray-50);
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--gray-700);
            border-bottom: 2px solid var(--gray-200);
        }

        .table td {
            padding: 1rem 1.5rem;
            color: var(--gray-600);
            border-bottom: 1px solid var(--gray-100);
        }

        .table tr:hover td {
            background-color: var(--gray-50);
        }

        /* Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 1rem;
            padding: 1.5rem;
            color: white;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
        }

        /* Charts */
        .chart-container {
            position: relative;
            margin: 1rem 0;
            padding: 1rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .navbar-toggler {
                display: block;
            }
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div id="app">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo">
                </a>
            </div>
            <!-- Sidebar menu section -->
            <div class="sidebar-menu">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Patient Management -->
                <div class="sidebar-group">
                    <div class="sidebar-group-header">Patient Management</div>
                    <a href="{{ route('admin.patient.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.patient.*') ? 'active' : '' }}">
                        <i class="fas fa-search"></i>
                        <span>Search Patient</span>
                    </a>
                    <a href="{{ route('admin.patient.list') }}" class="sidebar-menu-item {{ request()->routeIs('admin.patient.list') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </div>

                <!-- Financial Management -->
                <div class="sidebar-group">
                    <div class="sidebar-group-header">Financial</div>
                    <a href="{{ route('admin.invoice.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.invoice.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Invoices</span>
                    </a>
                    <a href="{{ route('admin.chart.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.chart.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </div>

                <!-- Appointment Management -->
                <div class="sidebar-group">
                    <div class="sidebar-group-header">Appointments</div>
                    <a href="{{ route('admin.appointments.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>All Appointments</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <div class="navbar">
                <button class="navbar-toggler" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="navbar-profile">
                    <div class="navbar-profile-img">
                        <img src="{{ asset('images/user.png') }}" alt="User">
                    </div>
                    <div class="navbar-profile-text">
                        <p class="mb-0">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="dropdown">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
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
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });

            // Hover effect for collapsed sidebar
            if (sidebar) {
                const menuItems = sidebar.querySelectorAll('.sidebar-menu-item');

                menuItems.forEach(item => {
                    item.addEventListener('mouseenter', function() {
                        if (sidebar.classList.contains('collapsed')) {
                            const tooltip = document.createElement('div');
                            tooltip.className = 'sidebar-tooltip';
                            tooltip.textContent = this.querySelector('span').textContent;

                            const rect = this.getBoundingClientRect();
                            tooltip.style.top = `${rect.top}px`;
                            tooltip.style.left = `${rect.right + 10}px`;

                            document.body.appendChild(tooltip);
                        }
                    });

                    item.addEventListener('mouseleave', function() {
                        const tooltip = document.querySelector('.sidebar-tooltip');
                        if (tooltip) {
                            tooltip.remove();
                        }
                    });
                });
            }
        });
    </script>

    @yield('javascript')
</body>
</html>
