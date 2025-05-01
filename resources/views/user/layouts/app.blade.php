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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Custom CSS -->
    <style>
        :root {
            /* Primary Colors - Matching admin layout */
            --primary: #0ea5e9;
            --primary-light: #38bdf8;
            --primary-dark: #0284c7;
            --primary-50: #f0f9ff;
            --primary-100: #e0f2fe;
            --primary-200: #bae6fd;

            /* Secondary Colors */
            --secondary: #6366f1;
            --secondary-light: #818cf8;
            --secondary-dark: #4f46e5;

            /* Accent Colors */
            --accent: #f59e0b;
            --accent-light: #fbbf24;
            --accent-dark: #d97706;

            /* Semantic Colors */
            --success: #10b981;
            --success-light: #34d399;
            --warning: #f59e0b;
            --warning-light: #fbbf24;
            --danger: #ef4444;
            --danger-light: #f87171;
            --info: #06b6d4;
            --info-light: #22d3ee;

            /* Neutral Colors */
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

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

            /* Border Radius */
            --radius-sm: 0.125rem;
            --radius: 0.25rem;
            --radius-md: 0.375rem;
            --radius-lg: 0.5rem;
            --radius-xl: 0.75rem;
            --radius-2xl: 1rem;
            --radius-3xl: 1.5rem;
            --radius-full: 9999px;

            /* Animation variables */
            --transition-fast: 0.2s;
            --transition-normal: 0.3s;
            --transition-slow: 0.5s;
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInLeft {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-slideIn {
            animation: slideInLeft 0.5s ease-out forwards;
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Add to the <style> section in app.blade.php */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .notification-panel {
            position: absolute;
            right: 0;
            top: 100%;
            width: 320px;
            background-color: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            margin-top: 10px;
            display: none;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            animation: fadeIn 0.3s ease-out forwards;
        }

        .notification-header {
            padding: 15px;
            border-bottom: 1px solid var(--gray-200);
            background-color: var(--gray-50);
        }

        .notification-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .notification-content {
            max-height: 300px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }

        .notification-item:hover {
            background-color: var(--gray-50);
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary-50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
        }

        .notification-item-content {
            flex: 1;
        }

        .notification-item-title {
            font-weight: 500;
            color: var(--gray-800);
            margin-bottom: 2px;
            font-size: 14px;
        }

        .notification-item-description {
            color: var(--gray-600);
            font-size: 12px;
        }

        .notification-footer {
            padding: 10px 15px;
            text-align: center;
            border-top: 1px solid var(--gray-200);
            background-color: var(--gray-50);
        }

        .notification-footer a {
            color: var(--primary);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .notification-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 0;
            color: var(--gray-400);
            font-size: 1.5rem;
        }

        .no-notifications {
            padding: 30px 15px;
            text-align: center;
            color: var(--gray-500);
            font-size: 14px;
        }

        .notification-item-time {
            font-size: 11px;
            color: var(--gray-500);
            margin-top: 2px;
        }
        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            transition: all var(--transition-normal) cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-lg);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: var(--radius-full);
        }

        .sidebar-brand {
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand img {
            height: 60px;
            width: auto;
            transition: all 0.3s ease;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .sidebar-brand:hover img {
            transform: scale(1.05);
        }

        .sidebar-menu {
            padding: 1.25rem 0;
        }

        .sidebar-menu-item {
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.85);
            transition: all 0.2s;
            border-radius: var(--radius-lg);
            margin: 0.25rem 0.75rem;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .sidebar-menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(255, 255, 255, 0.1);
            transition: width 0.2s ease;
            z-index: -1;
        }

        .sidebar-menu-item:hover::before {
            width: 100%;
        }

        .sidebar-menu-item:hover,
        .sidebar-menu-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
            text-decoration: none;
        }

        .sidebar-menu-item.active {
            font-weight: 500;
        }

        .sidebar-menu-item.active::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: white;
            border-radius: 0 var(--radius-full) var(--radius-full) 0;
        }

        .sidebar-menu-item i {
            width: 24px;
            margin-right: 1rem;
            font-size: 1.25rem;
            position: relative;
            z-index: 2;
        }

        .sidebar-menu-item span {
            position: relative;
            z-index: 2;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .sidebar-brand img {
            width: 40px;
        }

        .sidebar.collapsed .sidebar-menu-item span {
            display: none;
        }

        .sidebar.collapsed .sidebar-menu-item {
            padding: 0.875rem;
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-menu-item i {
            margin-right: 0;
            font-size: 1.4rem;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: all var(--transition-normal);
            background-color: var(--gray-50);
        }

        /* Navbar */
        .navbar {
            background-color: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .navbar:hover {
            box-shadow: var(--shadow-lg);
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-toggler {
            background: none;
            border: none;
            color: var(--gray-600);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius-lg);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-toggler:hover {
            background-color: var(--gray-100);
            color: var(--primary);
            transform: rotate(90deg);
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
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            overflow: hidden;
            border: 2px solid var(--primary-100);
        }

        .navbar-profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navbar-profile-text {
            font-weight: 500;
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
            border-radius: var(--radius-lg);
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
            background-color: var(--primary-50);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-lg);
            background: linear-gradient(135deg, var(--danger) 0%, var(--danger-light) 100%);
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
            background-color: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid var(--gray-100);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--white);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-title i {
            color: var(--primary);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-lg);
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform 0.5s, opacity 0.5s;
        }

        .btn:active::after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }

        .btn i {
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, var(--warning-light) 100%);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, var(--danger-light) 100%);
            color: white;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-outline-primary {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary-50);
        }

        .btn-outline-danger {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .btn-outline-danger:hover {
            background: var(--danger-50);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
            border-left: 4px solid transparent;
            display: flex;
            align-items: center;
            animation: fadeIn 0.5s ease-out;
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
            border-left-color: var(--primary);
            color: #0369a1;
        }

        .alert-info::before {
            content: "\f05a";
            color: var(--primary);
        }

        /* Sidebar Overlay */
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

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.show {
                transform: translateX(0);
                box-shadow: var(--shadow-lg);
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .navbar-toggler {
                display: block;
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

        /* Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E") center center;
            opacity: 0.2;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stats-card-content {
            position: relative;
            z-index: 2;
        }

        .stats-card-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-card-label {
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            opacity: 0.9;
        }

        .stats-card-trend {
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .stats-card-icon {
            font-size: 2.5rem;
            opacity: 0.15;
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-card-icon {
            opacity: 0.25;
            transform: translateY(-50%) scale(1.1);
        }

        /* Appointment Card */
        .appointment-card {
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .appointment-card:hover {
            border-left-color: var(--secondary);
        }

        .appointment-card.confirmed {
            border-left-color: var(--success);
        }

        .appointment-card.pending {
            border-left-color: var(--warning);
        }

        .appointment-card.cancelled {
            border-left-color: var(--danger);
        }

        .appointment-status {
            display: inline-flex;
            align-items: center;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: var(--radius-full);
        }

        .appointment-status.confirmed {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .appointment-status.pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .appointment-status.cancelled {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        /* Fade in animation for content */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* Professional Loader Styles */
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loader-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loader {
            position: relative;
            width: 60px;
            height: 60px;
        }

        .loader-circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 4px solid transparent;
            border-radius: 50%;
        }

        .loader-circle-1 {
            border-top-color: var(--primary);
            animation: spin 1s linear infinite;
        }

        .loader-circle-2 {
            border-right-color: var(--secondary);
            animation: spin 0.8s linear infinite reverse;
        }

        .loader-circle-3 {
            border-bottom-color: var(--accent);
            animation: spin 1.2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .loader-text {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 1rem;
            font-weight: 500;
            color: var(--primary);
            white-space: nowrap;
        }

        /* Fixed loader styles */
        .fixed-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .fixed-loader.show {
            opacity: 1;
            visibility: visible;
        }

        .fixed-loader-spinner {
            position: relative;
            height: 60px;
            width: 60px;
        }

        .fixed-loader-spinner .spinner-border {
            height: 100%;
            width: 100%;
            border: 4px solid transparent;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .fixed-loader-text {
            margin-top: 1rem;
            font-weight: 500;
            color: var(--primary);
        }
    </style>

    @yield('styles')
</head>
<body>
    <div id="app">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('user.dashboard') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </a>
            </div>
            <div class="sidebar-menu">
                <a href="{{ route('user.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
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
                <a href="{{ route('user.medical.history') }}" class="sidebar-menu-item {{ request()->routeIs('user.medical.history') ? 'active' : '' }}">
                    <i class="fas fa-notes-medical"></i>
                    <span>Medical History</span>
                </a>
                <a href="{{ route('user.invoices') }}" class="sidebar-menu-item {{ request()->routeIs('user.invoices') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>My Invoices</span>
                </a>
                <a href="{{ route('user.profile') }}" class="sidebar-menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span>My Profile</span>
                </a>
                <a href="{{ route('user.help') }}" class="sidebar-menu-item {{ request()->routeIs('user.help') ? 'active' : '' }}">
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
                        <div class="dropdown">
                            <button class="navbar-action-btn" id="notificationBtn">
                                <i class="fas fa-bell"></i>
                                <span id="notification-badge" class="notification-badge" style="display: none;">0</span>
                            </button>
                            <div id="notificationPanel" class="notification-panel">
                                <div class="notification-header">
                                    <h3>Confirmed Appointments</h3>
                                </div>
                                <div id="notification-content" class="notification-content">
                                    <div class="loading-spinner">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                </div>
                                <div class="notification-footer">
                                    <a href="{{ route('user.appointments') }}">View All Appointments</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-profile-text">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="navbar-profile-role">Patient</div>
                    </div>
                    <img src="{{ asset('images/user.jpg') }}" alt="User" class="navbar-profile-img">
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

        <!-- Professional Loader -->
        <div id="global-loader" class="loader-overlay">
            <div class="loader">
                <div class="loader-circle loader-circle-1"></div>
                <div class="loader-circle loader-circle-2"></div>
                <div class="loader-circle loader-circle-3"></div>
                <div class="loader-text">Loading...</div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global loader functions
            window.showLoader = function(message = 'Loading...') {
                const loader = document.getElementById('global-loader');
                const loaderText = loader.querySelector('.loader-text');
                loaderText.textContent = message;
                loader.classList.add('show');
            };

            window.hideLoader = function() {
                const loader = document.getElementById('global-loader');
                loader.classList.remove('show');
            };

            // Show loader on page load
            const globalLoader = document.getElementById('global-loader');
            globalLoader.classList.add('show');

            // Hide loader when page is fully loaded
            window.addEventListener('load', function() {
                setTimeout(() => globalLoader.classList.remove('show'), 500);
            });

            // Add loader to all form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    showLoader('Processing your request...');
                });
            });

            // Add loader to all links with data-loader attribute
            document.querySelectorAll('[data-loader]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const message = this.getAttribute('data-loader-message') || 'Loading...';
                    showLoader(message);
                    window.location.href = this.href;
                });
            });

            // Add loader to AJAX requests
            const originalFetch = window.fetch;
            window.fetch = function() {
                const fetchCall = originalFetch.apply(this, arguments);
                const url = arguments[0];

                // Only show loader for non-notification requests to avoid flickering
                if (!url.includes('confirmed-appointments')) {
                    showLoader();
                }

                return fetchCall.then(response => {
                    if (!url.includes('confirmed-appointments')) {
                        hideLoader();
                    }
                    return response;
                }).catch(error => {
                    hideLoader();
                    throw error;
                });
            };

            // Notification panel functionality
            const notificationBtn = document.getElementById('notificationBtn');
            const notificationPanel = document.getElementById('notificationPanel');
            const notificationContent = document.getElementById('notification-content');
            const notificationBadge = document.getElementById('notification-badge');

            let isNotificationPanelOpen = false;

            // Function to toggle notification panel
            function toggleNotificationPanel() {
                if (isNotificationPanelOpen) {
                    notificationPanel.style.display = 'none';
                } else {
                    notificationPanel.style.display = 'block';
                    fetchConfirmedAppointments();
                }
                isNotificationPanelOpen = !isNotificationPanelOpen;
            }

            // Function to fetch confirmed appointments
            function fetchConfirmedAppointments() {
                notificationContent.innerHTML = `
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                `;

                fetch('{{ route("user.appointments.confirmed") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayConfirmedAppointments(data.appointments);
                            updateNotificationBadge(data.appointments.length);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching appointments:', error);
                        notificationContent.innerHTML = `
                            <div class="no-notifications">
                                <p>Failed to load appointments</p>
                            </div>
                        `;
                    });
            }

            // Function to display confirmed appointments
            function displayConfirmedAppointments(appointments) {
                if (appointments.length === 0) {
                    notificationContent.innerHTML = `
                        <div class="no-notifications">
                            <p>No confirmed appointments</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                appointments.forEach(appointment => {
                    const appointmentDate = new Date(appointment.appointment_date);
                    const formattedDate = appointmentDate.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });

                    html += `
                        <div class="notification-item">
                            <div class="notification-item-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="notification-item-content">
                                <div class="notification-item-title">Appointment Confirmed</div>
                                <div class="notification-item-description">
                                    ${formattedDate} at ${appointment.appointment_time}
                                </div>
                                <div class="notification-item-time">
                                    ${appointment.notes ? appointment.notes : 'No additional notes'}
                                </div>
                            </div>
                        </div>
                    `;
                });

                notificationContent.innerHTML = html;
            }

            // Function to update notification badge
            function updateNotificationBadge(count) {
                if (count > 0) {
                    notificationBadge.style.display = 'flex';
                    notificationBadge.textContent = count;
                } else {
                    notificationBadge.style.display = 'none';
                }
            }

            // Load notification count on page load
            fetchConfirmedAppointments();

            // Event listeners
            notificationBtn.addEventListener('click', toggleNotificationPanel);

            // Close the notification panel when clicking outside
            document.addEventListener('click', function(event) {
                if (isNotificationPanelOpen &&
                    !notificationPanel.contains(event.target) &&
                    !notificationBtn.contains(event.target)) {
                    notificationPanel.style.display = 'none';
                    isNotificationPanelOpen = false;
                }
            });

            // Sidebar functionality
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.querySelector('.main-content');

            // Function to toggle sidebar
            function toggleSidebar() {
                if (window.innerWidth <= 992) {
                    // Mobile behavior
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                    if (sidebar.classList.contains('show')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                } else {
                    // Desktop behavior - collapse/expand
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');

                    // Store the state in localStorage
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                }
            }

            // Event listeners
            sidebarToggle.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);

            // Restore sidebar state on page load
            if (window.innerWidth > 992) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                }
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
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

            // Sweet Alert helper functions
            window.showAlert = function(title, text, icon = 'success') {
                return Swal.fire({
                    title, text, icon,
                    confirmButtonText: 'OK',
                    customClass: { confirmButton: 'btn btn-primary' },
                    buttonsStyling: false
                });
            };

            window.showConfirm = function(title, text, confirmText = 'Yes', cancelText = 'No', icon = 'warning') {
                return Swal.fire({
                    title, text, icon,
                    showCancelButton: true,
                    confirmButtonText, cancelButtonText,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-secondary'
                    },
                    buttonsStyling: false
                });
            };

            // Welcome notification
            setTimeout(() => {
                if (document.querySelector('.alert') === null) {
                    const welcomeMessage = document.createElement('div');
                    welcomeMessage.className = 'alert alert-info';
                    welcomeMessage.textContent = 'Welcome to your dental management dashboard!';
                    document.querySelector('.content').prepend(welcomeMessage);

                    setTimeout(() => {
                        welcomeMessage.style.opacity = '0';
                        setTimeout(() => welcomeMessage.remove(), 500);
                    }, 5000);
                }
            }, 1000);
        });
    </script>

    @yield('scripts')
</body>
</html>
