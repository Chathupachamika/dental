<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dental Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <!-- Custom CSS -->
    <style>
        :root {
            /* Primary Colors */
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

        @keyframes bellRing {
            0%, 100% { transform: rotate(0); }
            10%, 30%, 50%, 70%, 90% { transform: rotate(10deg); }
            20%, 40%, 60%, 80% { transform: rotate(-10deg); }
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

        .animate-bell {
            animation: bellRing 1s ease-in-out;
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            background-color: var(--gray-300);
            border-radius: var(--radius-full);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-brand {
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--gray-100);
            background: linear-gradient(to right, var(--primary-50), var(--white));
        }

        .sidebar-brand img {
            height: 60px;
            width: auto;
            transition: all 0.3s ease;
            object-fit: contain;
        }

        .sidebar.collapsed .sidebar-brand img {
            height: 45px;
        }

        .sidebar-menu {
            padding: 1.25rem 0;
        }

        .sidebar-group-header {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gray-500);
            margin-top: 1rem;
        }

        .sidebar-menu-item {
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            color: var(--gray-700);
            transition: all 0.2s;
            border-radius: var(--radius-lg);
            margin: 0.25rem 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(to right, var(--primary-100), transparent);
            transition: width 0.2s ease;
        }

        .sidebar-menu-item:hover::before {
            width: 100%;
        }

        .sidebar-menu-item:hover,
        .sidebar-menu-item.active {
            color: var(--primary);
            background-color: var(--primary-50);
            transform: translateX(5px);
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
            background: var(--primary);
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

        /* Sidebar Tooltip */
        .sidebar-tooltip {
            position: fixed;
            background-color: var(--gray-800);
            color: var(--white);
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            z-index: 1000;
            pointer-events: none;
            white-space: nowrap;
            box-shadow: var(--shadow-lg);
            animation: fadeIn 0.2s ease-out;
        }

        .sidebar-tooltip::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 50%;
            transform: translateY(-50%);
            border-width: 5px 5px 5px 0;
            border-style: solid;
            border-color: transparent var(--gray-800) transparent transparent;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: var(--gray-50);
        }

        .main-content.expanded {
            margin-left: 70px;
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
            display: none;
        }

        @media (min-width: 768px) {
            .navbar-profile-text {
                display: block;
            }

            .navbar-profile-text p {
                font-weight: 500;
                color: var(--gray-800);
                margin: 0;
            }
        }

        /* Dropdown */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 0.5rem);
            background: var(--white);
            border-radius: var (--radius-lg);
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            min-width: 180px;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--gray-700);
            border-radius: var(--radius-md);
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--gray-100);
            color: var(--primary);
        }

        .dropdown-item i {
            margin-right: 0.75rem;
            font-size: 1rem;
            width: 20px;
            text-align: center;
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
            color: var (--gray-800);
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
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rulesvg%3E%3C/svg%3E") center center;
            opacity: 0.2;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
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

        .btn-outline-primary.active {
            background: var(--primary);
            color: white;
        }

        .btn-outline-danger {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .btn-outline-danger:hover {
            background: var(--danger-50);
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
            border-radius: var (--radius-lg);
            font-size: 1rem;
            transition: all 0.2s;
            background-color: var(--white);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
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
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .table td {
            padding: 1rem 1.5rem;
            color: var(--gray-600);
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
        }

        .table tr:hover td {
            background-color: var(--gray-50);
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
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

        .bg-success {
            background-color: var (--success);
        }

        .bg-warning {
            background-color: var(--warning);
        }

        .bg-danger {
            background-color: var(--danger);
        }

        .text-white {
            color: var(--white);
        }

        /* Avatar */
        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-full);
            background-color: var(--gray-200);
            color: var(--gray-700);
            font-weight: 600;
            overflow: hidden;
        }

        .avatar-sm {
            width: 2rem;
            height: 2rem;
            font-size: 0.875rem;
        }

        /* Utilities */
        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mr-3 {
            margin-right: 0.75rem;
        }

        .d-none {
            display: none;
        }

        /* Loader */
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

            .main-content.expanded {
                margin-left: 0;
            }

            .navbar-toggler {
                display: block;
            }
        }

        /* Loader Animation */
        @keyframes loader-pulse {
            0%, 100% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1); opacity: 1; }
        }

        /* Sweet Alert Custom Styling */
        .swal2-popup {
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-xl);
        }

        .swal2-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .swal2-confirm {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
            border-radius: var(--radius-lg) !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 500 !important;
        }

        .swal2-cancel {
            background: var(--gray-200) !important;
            color: var(--gray-700) !important;
            border-radius: var(--radius-lg) !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 500 !important;
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }

        .toast {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            padding: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            min-width: 300px;
            max-width: 400px;
            animation: slideInRight 0.3s ease-out forwards;
            border-left: 4px solid var(--primary);
        }

        .toast-success {
            border-left-color: var(--success);
        }

        .toast-warning {
            border-left-color: var(--warning);
        }

        .toast-error {
            border-left-color: var(--danger);
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
        }

        .toast-success .toast-icon {
            background-color: var(--success-light);
            color: var (--success);
        }

        .toast-warning .toast-icon {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .toast-error .toast-icon {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .toast-close {
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            padding: 0.25rem;
            margin-left: 0.5rem;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: var(--gray-600);
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

        /* Notification Bell Styles */
        .notification-bell {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            background-color: var(--gray-100);
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.2s ease;
            margin-right: 1rem;
        }

        .notification-bell:hover {
            background-color: var(--primary-50);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .notification-bell.active {
            background-color: var(--primary-50);
            color: var(--primary);
        }

        .notification-bell i {
            font-size: 1.25rem;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            border-radius: var(--radius-full);
            background-color: var(--danger);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            box-shadow: var(--shadow-sm);
        }

        .notification-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: -100px;
            width: 350px;
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            z-index: 1000;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.95);
            transform-origin: top right;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: none;
        }

        .notification-bell.show .notification-dropdown {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
            backdrop-filter: none;
            background-color: var(--white);
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background: linear-gradient(to right, var(--primary-50), var(--white));
            border-bottom: 1px solid var(--gray-100);
        }

        .notification-title {
            font-weight: 600;
            color: var(--gray-800);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notification-title i {
            color: var(--primary);
        }

        .notification-actions {
            display: flex;
            gap: 0.5rem;
        }

        .notification-action {
            background: none;
            border: none;
            color: var(--gray-600);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: var(--radius-md);
            transition: all 0.2s;
        }

        .notification-action:hover {
            background-color: var(--gray-100);
            color: var(--primary);
        }

        .notification-body {
            max-height: 350px;
            overflow-y: auto;
        }

        .notification-body::-webkit-scrollbar {
            width: 5px;
        }

        .notification-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .notification-body::-webkit-scrollbar-thumb {
            background-color: var(--gray-300);
            border-radius: var(--radius-full);
        }

        .notification-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all 0.2s;
        }

        .notification-item:hover {
            background-color: var(--gray-50);
            opacity: 1;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            background-color: var(--primary-50);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-icon.warning {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .notification-content {
            flex: 1;
        }

        .notification-message {
            font-size: 0.875rem;
            color: var(--gray-700);
            margin-bottom: 0.25rem;
        }

        .notification-message strong {
            font-weight: 600;
            color: var(--gray-800);
        }

        .notification-time {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .notification-actions-item {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .notification-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: var(--radius-md);
            font-weight: 500;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .notification-btn-confirm {
            background-color: var(--primary-50);
            color: var(--primary);
        }

        .notification-btn-confirm:hover {
            background-color: var(--primary);
            color: white;
        }

        .notification-btn-cancel {
            background-color: var(--gray-100);
            color: var(--gray-600);
        }

        .notification-btn-cancel:hover {
            background-color: var(--gray-200);
            color: var(--gray-700);
        }

        .notification-footer {
            padding: 0.75rem 1.5rem;
            background-color: var(--gray-50);
            text-align: center;
            border-top: 1px solid var(--gray-100);
        }

        .notification-footer a {
            color: var(--primary);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .notification-footer a:hover {
            text-decoration: underline;
        }

        .notification-empty {
            padding: 2rem;
            text-align: center;
            color: var(--gray-500);
        }

        .notification-empty i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--gray-300);
        }

        .notification-empty p {
            font-size: 0.875rem;
        }
    </style>

    <!-- Scripts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // Load the Google Charts library
    google.charts.load('current', {
        'packages': ['corechart', 'calendar', 'bar']
    });

    // Set callback when the Google Charts library is loaded
    google.charts.setOnLoadCallback(initCharts);

    // Initialize all charts
    function initCharts() {
        loadMainChart('monthly');
        loadTreatmentChart();
        loadAppointmentStatusChart();
        loadRevenueChart();
        loadCalendarChart();

        // Set up event listeners for period selector buttons
        document.querySelectorAll('.period-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.period-btn').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Add active class to clicked button
                this.classList.add('active');

                // Load chart with selected period
                loadMainChart(this.dataset.period);
            });
        });
    }

    // Load the main overview chart
    function loadMainChart(period) {
        fetch(`{{ route('admin.chart.data') }}?period=${period}`)
            .then(response => response.json())
            .then(data => {
                const chartData = google.visualization.arrayToDataTable(data);

                const options = {
                    title: '',
                    hAxis: {title: period === 'daily' ? 'Day' : (period === 'monthly' ? 'Month' : 'Year')},
                    vAxis: {title: 'Amount', minValue: 0},
                    seriesType: 'bars',
                    series: {
                        0: {color: '#4e73df'},
                        1: {color: '#1cc88a'},
                        2: {type: 'line', color: '#f6c23e', targetAxisIndex: 1}
                    },
                    vAxes: {
                        0: {title: 'Amount ($)', format: '$#,###'},
                        1: {title: 'Appointments', format: '#,###'}
                    },
                    legend: {position: 'bottom'},
                    chartArea: {width: '85%', height: '70%'},
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                const chart = new google.visualization.ComboChart(document.getElementById('main_chart_div'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error loading chart data:', error));
    }

    // Load the treatment distribution chart
    function loadTreatmentChart() {
        fetch('{{ route('admin.chart.treatments') }}')
            .then(response => response.json())
            .then(data => {
                const chartData = google.visualization.arrayToDataTable(data);

                const options = {
                    title: '',
                    pieHole: 0.4,
                    colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69', '#f8f9fc', '#d1d3e2', '#b7b9cc'],
                    chartArea: {width: '90%', height: '80%'},
                    legend: {position: 'right', alignment: 'center'},
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                const chart = new google.visualization.PieChart(document.getElementById('treatment_chart_div'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error loading treatment chart data:', error));
    }

    // Load the appointment status chart
    function loadAppointmentStatusChart() {
        fetch('{{ route('admin.chart.appointments') }}')
            .then(response => response.json())
            .then(data => {
                const chartData = google.visualization.arrayToDataTable(data.statusData);

                const options = {
                    title: '',
                    pieHole: 0.4,
                    colors: ['#1cc88a', '#f6c23e', '#e74a3b'],
                    chartArea: {width: '90%', height: '80%'},
                    legend: {position: 'right', alignment: 'center'},
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                const chart = new google.visualization.PieChart(document.getElementById('appointment_status_chart'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error loading appointment status chart data:', error));
    }

    // Load the revenue chart
    function loadRevenueChart() {
        fetch('{{ route('admin.chart.revenue') }}')
            .then(response => response.json())
            .then(data => {
                const chartData = google.visualization.arrayToDataTable(data);

                const options = {
                    title: '',
                    hAxis: {title: 'Month'},
                    vAxis: {title: 'Revenue', format: '$#,###'},
                    colors: ['#4e73df', '#1cc88a'],
                    chartArea: {width: '80%', height: '70%'},
                    legend: {position: 'bottom'},
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                const chart = new google.visualization.ColumnChart(document.getElementById('revenue_chart_div'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error loading revenue chart data:', error));
    }

    // Load the calendar chart
    function loadCalendarChart() {
        fetch('{{ route('admin.chart.appointments') }}')
            .then(response => response.json())
            .then(data => {
                // Create a DataTable
                const dataTable = new google.visualization.DataTable();
                dataTable.addColumn({ type: 'date', id: 'Date' });
                dataTable.addColumn({ type: 'number', id: 'Appointments' });

                // Skip the header row (index 0) and add the data rows
                for (let i = 1; i < data.calendarData.length; i++) {
                    const row = data.calendarData[i];
                    const dateParts = row[0].split('-');
                    const year = parseInt(dateParts[0]);
                    const month = parseInt(dateParts[1]) - 1; // JavaScript months are 0-based
                    const day = parseInt(dateParts[2]);

                    dataTable.addRow([new Date(year, month, day), row[1]]);
                }

                const options = {
                    title: '',
                    height: 350,
                    calendar: {
                        cellSize: 13,
                        monthLabel: {
                            fontName: 'Times-Roman',
                            fontSize: 12,
                            color: '#1a1a1a',
                            bold: true
                        },
                        monthOutlineColor: {
                            stroke: '#4e73df',
                            strokeOpacity: 0.8,
                            strokeWidth: 2
                        },
                        unusedMonthOutlineColor: {
                            stroke: '#c0c0c0',
                            strokeOpacity: 0.8,
                            strokeWidth: 1
                        },
                        cellColor: {
                            stroke: '#f5f5f5',
                            strokeOpacity: 0.5,
                            strokeWidth: 1
                        },
                        focusedCellColor: {
                            stroke: '#4e73df'
                        }
                    },
                    colorAxis: {
                        colors: ['#e8f4f8', '#4e73df']
                    },
                    noDataPattern: {
                        backgroundColor: '#eeeeee',
                        color: '#eeeeee'
                    }
                };

                const chart = new google.visualization.Calendar(document.getElementById('calendar_chart'));
                chart.draw(dataTable, options);
            })
            .catch(error => {
                console.error('Error loading calendar chart data:', error);
                document.getElementById('calendar_chart').innerHTML = `
                    <div class="text-center text-gray-500 py-4">
                        <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                        <p>Failed to load calendar data</p>
                    </div>
                `;
            });
    }
</script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Visualization API and the controls package.
        google.charts.load('current', {'packages':['corechart', 'controls']});
        google.charts.setOnLoadCallback(drawDashboard);

        function drawDashboard() {
            fetch('/admin/chart/patient-ages')
                .then(response => response.json())
                .then(patientData => {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Patient');
                    data.addColumn('number', 'Age');
                    data.addRows(patientData);

                    var dashboard = new google.visualization.Dashboard(
                        document.getElementById('dashboard_div'));

                    var ageRangeSlider = new google.visualization.ControlWrapper({
                        'controlType': 'NumberRangeFilter',
                        'containerId': 'filter_div',
                        'options': {
                            'filterColumnLabel': 'Age',
                            'minValue': 0,
                            'maxValue': 100
                        }
                    });

                    var ageChart = new google.visualization.ChartWrapper({
                        'chartType': 'ColumnChart',
                        'containerId': 'chart_div',
                        'options': {
                            'width': '100%',
                            'height': 400,
                            'pieSliceText': 'value',
                            'legend': 'right',
                            'title': 'Patient Age Distribution',
                            'hAxis': {'title': 'Patients'},
                            'vAxis': {'title': 'Age'}
                        }
                    });

                    dashboard.bind(ageRangeSlider, ageChart);
                    dashboard.draw(data);
                })
                .catch(error => {
                    console.error('Error loading patient age data:', error);
                    document.getElementById('chart_div').innerHTML =
                        '<div class="text-center text-gray-500 py-4">Failed to load patient age data</div>';
                });
        }

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawTreatmentDistributionChart);

        function drawTreatmentDistributionChart() {
            fetch('/admin/chart/treatments')
                .then(response => response.json())
                .then(treatmentData => {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Treatment');
                    data.addColumn('number', 'Count');
                    treatmentData.forEach(item => {
                        data.addRow([item.treatment, item.count]);
                    });

                    var options = {
                        title: 'Treatment Distribution',
                        pieHole: 0.4,
                        sliceVisibilityThreshold: .05,
                        colors: ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444'],
                        chartArea: {width: '100%', height: '80%'},
                        legend: {position: 'bottom', alignment: 'center'}
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('treatmentDistributionChart'));
                    chart.draw(data, options);

                    window.addEventListener('resize', function() {
                        chart.draw(data, options);
                    });
                })
                .catch(error => {
                    console.error('Error loading treatment data:', error);
                    document.getElementById('treatmentDistributionChart').innerHTML = `
                        <div class="text-center text-gray-500 py-4">
                            Failed to load treatment data
                        </div>
                    `;
                });
        }

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawAppointmentsPieChart);

        function drawAppointmentsPieChart() {
            fetch('/admin/appointment?status=all&format=json')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(apiData => {
                    var data = google.visualization.arrayToDataTable([
                        ['Status', 'Count'],
                        ['Confirmed', parseInt(apiData.confirmed) || 0],
                        ['Pending', parseInt(apiData.pending) || 0],
                        ['Cancelled', parseInt(apiData.cancelled) || 0]
                    ]);

                    var options = {
                        pieHole: 0.4,
                        colors: ['#10b981', '#f59e0b', '#ef4444'],
                        chartArea: {width: '100%', height: '80%'},
                        legend: {position: 'bottom', alignment: 'center'},
                        pieSliceText: 'value',
                        fontSize: 12,
                        fontName: 'Poppins',
                        tooltip: {showColorCode: true},
                        animation: {startup: true, duration: 1000, easing: 'out'}
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('appointmentsPieChart'));
                    chart.draw(data, options);

                    window.addEventListener('resize', function() {
                        chart.draw(data, options);
                    });
                })
                .catch(error => {
                    console.error('Error loading appointment data:', error);
                    document.getElementById('appointmentsPieChart').innerHTML = `
                        <div class="flex flex-col items-center justify-center p-4 text-gray-500">
                            <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                            <p>Failed to load appointment data</p>
                            <button onclick="drawAppointmentsPieChart()" class="mt-2 text-sm text-blue-500 hover:text-blue-700">
                                <i class="fas fa-redo mr-1"></i> Try again
                            </button>
                        </div>
                    `;
                });
        }
    </script>
</head>
<body>
    <!-- Global Loader -->
    <div id="global-loader" class="loader-overlay">
        <div class="loader">
            <div class="loader-circle loader-circle-1"></div>
            <div class="loader-circle loader-circle-2"></div>
            <div class="loader-circle loader-circle-3"></div>
            <div class="loader-text">Loading...</div>
        </div>
    </div>

    <div id="app">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </a>
                <button id="sidebarCollapseBtn" class="d-none d-lg-block">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <div class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
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
        <div class="main-content" id="mainContent">
            <!-- Navbar -->
            <div class="navbar">
                <button class="navbar-toggler" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="navbar-profile">
                    <!-- Notification Bell -->
                    <div class="notification-bell" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        @if(isset($pendingAppointmentsCount) && $pendingAppointmentsCount > 0)
                            <span class="notification-badge">{{ $pendingAppointmentsCount }}</span>
                        @endif
                        <div class="notification-dropdown">
                            <div class="notification-header">
                                <div class="notification-title">
                                    <i class="fas fa-bell"></i>
                                    <span>Notifications</span>
                                    @if(isset($pendingAppointmentsCount) && $pendingAppointmentsCount > 0)
                                        <span class="badge bg-danger text-white">{{ $pendingAppointmentsCount }}</span>
                                    @endif
                                </div>
                                <div class="notification-actions">
                                    <button class="notification-action" id="markAllRead" title="Mark all as read">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                    <button class="notification-action" id="refreshNotifications" title="Refresh">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="notification-body" id="notificationBody">
                                <div class="notification-loading">
                                    <div class="d-flex justify-content-center p-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-footer">
                                <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}">View All Pending Appointments</a>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-profile-img">
                        <img src="{{ asset('images/user.jpg') }}" alt="User">
                    </div>
                    <div class="navbar-profile-text">
                        <p class="mb-0">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-user-circle"></i>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <hr class="dropdown-divider">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show loader on page load
            const globalLoader = document.getElementById('global-loader');
            globalLoader.classList.add('show');

            // Hide loader when page is fully loaded
            window.addEventListener('load', function() {
                setTimeout(() => globalLoader.classList.remove('show'), 500);
            });

            // Sidebar Toggle
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
            const isMobile = window.matchMedia("(max-width: 992px)").matches;

            function toggleSidebar() {
                if (isMobile) {
                    sidebar.classList.toggle('show');
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                    sidebarToggle.classList.toggle('rotated');
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                }
            }

            // Initialize sidebar state
            if (!isMobile && localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                sidebarToggle.classList.add('rotated');
            }

            // Event listeners for toggle buttons
            sidebarToggle.addEventListener('click', toggleSidebar);
            if (sidebarCollapseBtn) {
                sidebarCollapseBtn.addEventListener('click', toggleSidebar);
            }

            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', function(e) {
                if (isMobile && sidebar.classList.contains('show') &&
                    !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            });

            // Notification Bell Toggle
            const notificationBell = document.getElementById('notificationBell');
            if (notificationBell) {
                notificationBell.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('show');
                    if (this.classList.contains('show')) {
                        loadPendingAppointments();
                    }
                });

                // Close notification dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!notificationBell.contains(e.target)) {
                        notificationBell.classList.remove('show');
                    }
                });

                // Prevent closing when clicking inside dropdown
                const notificationDropdown = notificationBell.querySelector('.notification-dropdown');
                if (notificationDropdown) {
                    notificationDropdown.addEventListener('click', e => e.stopPropagation());
                }

                // Refresh notifications
                const refreshBtn = document.getElementById('refreshNotifications');
                if (refreshBtn) {
                    refreshBtn.addEventListener('click', function() {
                        loadPendingAppointments();
                        this.classList.add('animate-spin');
                        setTimeout(() => this.classList.remove('animate-spin'), 1000);
                    });
                }

                // Mark all as read
                const markAllReadBtn = document.getElementById('markAllRead');
                if (markAllReadBtn) {
                    markAllReadBtn.addEventListener('click', function() {
                        fetch('/admin/appointments/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Success', 'All notifications marked as read', 'success');
                                loadPendingAppointments();
                            } else {
                                showToast('Error', 'Failed to mark notifications as read', 'error');
                            }
                        })
                        .catch(() => showToast('Error', 'An error occurred', 'error'));
                    });
                }
            }

            // Load pending appointments via AJAX
            function loadPendingAppointments() {
                const notificationBody = document.getElementById('notificationBody');
                notificationBody.innerHTML = `
                    <div class="d-flex justify-content-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `;

                fetch('/admin/appointment?status=pending&format=json', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.appointments && data.appointments.length > 0) {
                        let html = '';
                        data.appointments.forEach(appointment => {
                            const date = new Date(appointment.appointment_date);
                            const formattedDate = date.toLocaleDateString('en-US', {
                                month: 'short', day: 'numeric', year: 'numeric'
                            });
                            const time = appointment.appointment_time ?
                                new Date(`2000-01-01T${appointment.appointment_time}`).toLocaleTimeString('en-US', {
                                    hour: '2-digit', minute: '2-digit'
                                }) : 'N/A';

                            html += `
                                <div class="notification-item">
                                    <div class="notification-icon warning">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-message">
                                            <strong>${appointment.user ? appointment.user.name : 'Unknown Patient'}</strong> has requested an appointment on <strong>${formattedDate}</strong>
                                        </div>
                                        <div class="notification-time">
                                            ${moment(appointment.created_at).fromNow()}
                                        </div>
                                        <div class="notification-actions-item">
                                            <button class="notification-btn notification-btn-confirm" data-id="${appointment.id}">
                                                <i class="fas fa-check"></i> Confirm
                                            </button>
                                            <button class="notification-btn notification-btn-cancel" data-id="${appointment.id}">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        notificationBody.innerHTML = html;

                        // Add event listeners for confirm and cancel buttons
                        document.querySelectorAll('.notification-btn-confirm').forEach(button => {
                            button.addEventListener('click', function() {
                                const id = this.dataset.id;
                                fetch(`/admin/appointment/${id}/confirm`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        showToast('Success', 'Appointment confirmed successfully', 'success');
                                        loadPendingAppointments();
                                    } else {
                                        showToast('Error', 'Failed to confirm appointment', 'error');
                                    }
                                })
                                .catch(() => showToast('Error', 'An error occurred', 'error'));
                            });
                        });

                        document.querySelectorAll('.notification-btn-cancel').forEach(button => {
                            button.addEventListener('click', function() {
                                const id = this.dataset.id;
                                fetch(`/admin/appointment/${id}/cancel`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        showToast('Success', 'Appointment cancelled successfully', 'success');
                                        loadPendingAppointments();
                                    } else {
                                        showToast('Error', 'Failed to cancel appointment', 'error');
                                    }
                                })
                                .catch(() => showToast('Error', 'An error occurred', 'error'));
                            });
                        });
                    } else {
                        notificationBody.innerHTML = `
                            <div class="notification-empty">
                                <i class="fas fa-check-circle"></i>
                                <h4>All caught up!</h4>
                                <p>No pending appointments to confirm.</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error fetching notifications:', error);
                    notificationBody.innerHTML = `
                        <div class="notification-empty">
                            <i class="fas fa-exclamation-circle"></i>
                            <h4>Oops!</h4>
                            <p>Failed to load notifications. Please try again.</p>
                        </div>
                    `;
                });
            }

            // Toast notification function
            window.showToast = function(title, message, type = 'success') {
                const toastContainer = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                const iconClass = type === 'success' ? 'fa-check-circle' :
                                 type === 'warning' ? 'fa-exclamation-triangle' :
                                 type === 'error' ? 'fa-times-circle' : 'fa-info-circle';

                toast.innerHTML = `
                    <div class="toast-icon">
                        <i class="fas ${iconClass}"></i>
                    </div>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                toastContainer.appendChild(toast);
                setTimeout(() => {
                    toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);

                toast.querySelector('.toast-close').addEventListener('click', () => {
                    toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
                    setTimeout(() => toast.remove(), 300);
                });
            };

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

            // Loader functions
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

            // Welcome notification
            setTimeout(() => {
                showToast('Welcome Back!', 'Your dashboard is ready', 'success');
            }, 1000);

            // Load pending appointments count
            fetch('/admin/appointment?status=pending&count=true', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.count && data.count > 0) {
                    const badge = notificationBell.querySelector('.notification-badge') || document.createElement('span');
                    badge.className = 'notification-badge';
                    badge.textContent = data.count;
                    notificationBell.appendChild(badge);
                    notificationBell.classList.add('animate-bell');
                    setTimeout(() => notificationBell.classList.remove('animate-bell'), 1000);
                }
            })
            .catch(error => console.error('Error fetching pending appointments count:', error));
        });
    </script>
</body>
</html>
