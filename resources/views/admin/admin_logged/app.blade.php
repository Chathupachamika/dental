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
            width: 80px;
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
            height: 60px; /* Increased from 40px */
            width: auto;
            transition: all 0.3s ease;
            object-fit: contain;
        }

        .sidebar.collapsed .sidebar-brand img {
            height: 45px; /* Increased from 35px */
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
            margin-left: 80px;
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
            transform: rotate(180deg);
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
            border-radius: var(--radius-lg);
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
            border-radius: var(--radius-lg);
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
            background-color: var(--success);
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
            color: var(--success);
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
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <div class="main-content" id="mainContent">
            <!-- Navbar -->
            <div class="navbar">
                <button class="navbar-toggler" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="navbar-profile">
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
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js')}}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show loader on page load
            const globalLoader = document.getElementById('global-loader');
            globalLoader.classList.add('show');

            // Hide loader when page is fully loaded
            window.addEventListener('load', function() {
                setTimeout(function() {
                    globalLoader.classList.remove('show');
                }, 500);
            });

            // Sidebar Toggle
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });

            if (sidebarCollapseBtn) {
                sidebarCollapseBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');

                    // Change icon direction
                    const icon = this.querySelector('i');
                    if (sidebar.classList.contains('collapsed')) {
                        icon.classList.remove('fa-chevron-left');
                        icon.classList.add('fa-chevron-right');
                    } else {
                        icon.classList.remove('fa-chevron-right');
                        icon.classList.add('fa-chevron-left');
                    }
                });
            }

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
                            tooltip.style.top = `${rect.top + rect.height/2}px`;
                            tooltip.style.left = `${rect.right + 10}px`;
                            tooltip.style.transform = 'translateY(-50%)';

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

                // Auto remove after 5 seconds
                setTimeout(() => {
                    toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 5000);

                // Close button
                const closeBtn = toast.querySelector('.toast-close');
                closeBtn.addEventListener('click', () => {
                    toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                });
            }

            // Sweet Alert helper functions
            window.showAlert = function(title, text, icon = 'success') {
                return Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }

            window.showConfirm = function(title, text, confirmText = 'Yes', cancelText = 'No', icon = 'warning') {
                return Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonText: confirmText,
                    cancelButtonText: cancelText,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-secondary'
                    },
                    buttonsStyling: false
                });
            }

            // Loader functions
            window.showLoader = function(message = 'Loading...') {
                const loader = document.getElementById('global-loader');
                const loaderText = loader.querySelector('.loader-text');
                loaderText.textContent = message;
                loader.classList.add('show');
            }

            window.hideLoader = function() {
                const loader = document.getElementById('global-loader');
                loader.classList.remove('show');
            }

            // Welcome notification
            setTimeout(() => {
                showToast('Welcome Back!', 'Your dashboard is ready', 'success');
            }, 1000);
        });
    </script>

    @yield('javascript')
</body>
</html>
