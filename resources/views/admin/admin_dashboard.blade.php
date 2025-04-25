<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DentalCare Pro') }}</title>

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
            /* Primary Color Palette */
            --primary: #0ea5e9;
            --primary-50: #f0f9ff;
            --primary-100: #e0f2fe;
            --primary-200: #bae6fd;
            --primary-300: #7dd3fc;
            --primary-400: #38bdf8;
            --primary-500: #0ea5e9;
            --primary-600: #0284c7;
            --primary-700: #0369a1;
            --primary-800: #075985;
            --primary-900: #0c4a6e;

            /* Secondary Color Palette */
            --secondary: #6366f1;
            --secondary-50: #eef2ff;
            --secondary-100: #e0e7ff;
            --secondary-200: #c7d2fe;
            --secondary-300: #a5b4fc;
            --secondary-400: #818cf8;
            --secondary-500: #6366f1;
            --secondary-600: #4f46e5;
            --secondary-700: #4338ca;
            --secondary-800: #3730a3;
            --secondary-900: #312e81;

            /* Success Color Palette */
            --success: #10b981;
            --success-50: #ecfdf5;
            --success-100: #d1fae5;
            --success-200: #a7f3d0;
            --success-300: #6ee7b7;
            --success-400: #34d399;
            --success-500: #10b981;
            --success-600: #059669;
            --success-700: #047857;
            --success-800: #065f46;
            --success-900: #064e3b;

            /* Warning Color Palette */
            --warning: #f59e0b;
            --warning-50: #fffbeb;
            --warning-100: #fef3c7;
            --warning-200: #fde68a;
            --warning-300: #fcd34d;
            --warning-400: #fbbf24;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            --warning-700: #b45309;
            --warning-800: #92400e;
            --warning-900: #78350f;

            /* Danger Color Palette */
            --danger: #ef4444;
            --danger-50: #fef2f2;
            --danger-100: #fee2e2;
            --danger-200: #fecaca;
            --danger-300: #fca5a5;
            --danger-400: #f87171;
            --danger-500: #ef4444;
            --danger-600: #dc2626;
            --danger-700: #b91c1c;
            --danger-800: #991b1b;
            --danger-900: #7f1d1d;

            /* Info Color Palette */
            --info: #06b6d4;
            --info-50: #f0fdff;
            --info-100: #ccfeff;
            --info-200: #99f6ff;
            --info-300: #5eecff;
            --info-400: #2bd9fc;
            --info-500: #06b6d4;
            --info-600: #0891b2;
            --info-700: #0e7490;
            --info-800: #155e75;
            --info-900: #164e63;

            /* Neutrals */
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
            --black: #020617;

            /* Dental-specific colors */
            --mint: #20c997;
            --lavender: #9333ea;
            --pale-blue: #93c5fd;
            --pale-green: #86efac;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes slideInLeft {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
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
            box-shadow: 0 1px 15px rgba(0, 0, 0, 0.05);
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
            transition: all 0.3s ease;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo-icon {
            height: 36px;
            width: 36px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .sidebar-logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-800);
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-logo-text {
            display: none;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--gray-500);
            cursor: pointer;
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .sidebar-toggle:hover {
            background-color: var(--gray-100);
            color: var(--primary-500);
        }

        .sidebar-menu {
            padding: 1.5rem 0;
            overflow-y: auto;
            height: calc(100vh - 80px);
        }

        .sidebar-group {
            margin-bottom: 1.5rem;
            animation: fadeIn 0.5s ease forwards;
        }

        .sidebar-group-header {
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gray-500);
        }

        .sidebar.collapsed .sidebar-group-header {
            display: none;
        }

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--gray-600);
            font-weight: 500;
            transition: all 0.2s;
            border-radius: 0.5rem;
            margin: 0.25rem 0.75rem;
            position: relative;
            text-decoration: none;
        }

        .sidebar-menu-item:hover {
            background-color: var(--primary-50);
            color: var(--primary-600);
            transform: translateX(4px);
        }

        .sidebar-menu-item.active {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: var(--white);
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2);
        }

        .sidebar-menu-item.active:hover {
            transform: translateX(0);
        }

        .sidebar-menu-item i {
            min-width: 24px;
            margin-right: 1rem;
            font-size: 1.1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar-menu-item span {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-menu-item {
            justify-content: center;
            padding: 0.75rem;
        }

        .sidebar.collapsed .sidebar-menu-item i {
            margin-right: 0;
            font-size: 1.25rem;
        }

        .sidebar.collapsed .sidebar-menu-item span {
            display: none;
        }

        .sidebar-tooltip {
            position: absolute;
            left: 80px;
            background-color: var(--gray-800);
            color: var(--white);
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
            pointer-events: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 50;
            white-space: nowrap;
        }

        .sidebar-tooltip::before {
            content: '';
            position: absolute;
            left: -4px;
            top: 50%;
            transform: translateY(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: transparent var(--gray-800) transparent transparent;
        }

        .sidebar.collapsed .sidebar-menu-item:hover .sidebar-tooltip {
            opacity: 1;
            visibility: visible;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            background-color: var(--white);
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease forwards;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-toggler {
            background: none;
            border: none;
            color: var(--gray-600);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            margin-right: 1rem;
        }

        .navbar-toggler:hover {
            background-color: var(--gray-100);
            color: var(--primary-500);
        }

        .navbar-search {
            position: relative;
            margin-right: 1rem;
        }

        .navbar-search input {
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-700);
            width: 240px;
            transition: all 0.2s;
        }

        .navbar-search input:focus {
            border-color: var(--primary-400);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
            outline: none;
        }

        .navbar-search i {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 0.875rem;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-notifications {
            position: relative;
        }

        .navbar-notifications-btn {
            background: none;
            border: none;
            color: var(--gray-600);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .navbar-notifications-btn:hover {
            background-color: var(--gray-100);
            color: var(--primary-500);
        }

        .navbar-notifications-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--danger-500);
            color: var(--white);
            font-size: 0.7rem;
            font-weight: 600;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--white);
        }

        .navbar-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
        }

        .navbar-profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--gray-200);
        }

        .navbar-profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navbar-profile-info {
            display: flex;
            flex-direction: column;
        }

        .navbar-profile-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .navbar-profile-role {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .navbar-profile-menu {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background-color: var(--white);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 200px;
            z-index: 50;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
        }

        .navbar-profile:hover .navbar-profile-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .navbar-profile-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--gray-700);
            font-size: 0.875rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .navbar-profile-menu-item:hover {
            background-color: var(--gray-50);
            color: var(--primary-600);
        }

        .navbar-profile-menu-item i {
            margin-right: 0.75rem;
            font-size: 1rem;
            color: var(--gray-500);
        }

        .navbar-profile-menu-divider {
            height: 1px;
            background-color: var(--gray-100);
            margin: 0.5rem 0;
        }

        .navbar-profile-menu-logout {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--danger-600);
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
        }

        .navbar-profile-menu-logout:hover {
            background-color: var(--danger-50);
        }

        .navbar-profile-menu-logout i {
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        .page-header {
            margin-bottom: 2rem;
            animation: fadeIn 0.5s ease forwards;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1rem;
            color: var(--gray-500);
        }

        /* Modern Cards */
        .card {
            background-color: var(--white);
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            animation: fadeIn 0.6s ease forwards;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 0.375rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 0.625rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
        }

        .btn-icon-sm {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
            border-radius: 0.375rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-600) 100%);
            color: var(--white);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid var(--primary-500);
            color: var(--primary-600);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-50);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary-500) 0%, var(--secondary-600) 100%);
            color: var(--white);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, var(--secondary-600) 0%, var(--secondary-700) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        }

        .btn-outline-secondary {
            background-color: transparent;
            border: 1px solid var(--secondary-500);
            color: var(--secondary-600);
        }

        .btn-outline-secondary:hover {
            background-color: var(--secondary-50);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-500) 0%, var(--success-600) 100%);
            color: var(--white);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--success-600) 0%, var(--success-700) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-500) 0%, var(--warning-600) 100%);
            color: var(--white);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, var(--warning-600) 0%, var(--warning-700) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-500) 0%, var(--danger-600) 100%);
            color: var(--white);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, var(--danger-600) 0%, var(--danger-700) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);
        }

        .btn-outline-danger {
            background-color: transparent;
            border: 1px solid var(--danger-500);
            color: var(--danger-600);
        }

        .btn-outline-danger:hover {
            background-color: var(--danger-50);
        }

        /* Stats Cards */
        .stats-card {
            border-radius: 1rem;
            padding: 1.5rem;
            color: white;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 50%);
            z-index: -1;
        }

        .stats-card::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            z-index: -1;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            margin-bottom: 1rem;
        }

        .stats-title {
            font-size: 0.875rem;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .stats-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stats-description {
            font-size: 0.75rem;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .stats-trend-up {
            color: var(--pale-green);
        }

        .stats-trend-down {
            color: var(--danger-300);
        }

        /* Tables */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 0.75rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: var(--gray-50);
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-700);
            text-align: left;
            border-bottom: 2px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table thead th:first-child {
            border-top-left-radius: 0.75rem;
        }

        .table thead th:last-child {
            border-top-right-radius: 0.75rem;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 0.75rem;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 0.75rem;
        }

        .table tbody tr:hover td {
            background-color: var(--gray-50);
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.25;
        }

        .badge-dot {
            position: relative;
            padding-left: 1.25rem;
        }

        .badge-dot::before {
            content: '';
            position: absolute;
            left: 0.375rem;
            top: 50%;
            transform: translateY(-50%);
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
        }

        .badge-success {
            background-color: var(--success-50);
            color: var(--success-700);
        }

        .badge-success.badge-dot::before {
            background-color: var(--success-500);
        }

        .badge-warning {
            background-color: var(--warning-50);
            color: var(--warning-700);
        }

        .badge-warning.badge-dot::before {
            background-color: var(--warning-500);
        }

        .badge-danger {
            background-color: var(--danger-50);
            color: var(--danger-700);
        }

        .badge-danger.badge-dot::before {
            background-color: var(--danger-500);
        }

        .badge-info {
            background-color: var(--info-50);
            color: var(--info-700);
        }

        .badge-info.badge-dot::before {
            background-color: var(--info-500);
        }

        .badge-secondary {
            background-color: var(--secondary-50);
            color: var(--secondary-700);
        }

        .badge-secondary.badge-dot::before {
            background-color: var(--secondary-500);
        }

        .badge-primary {
            background-color: var(--primary-50);
            color: var(--primary-700);
        }

        .badge-primary.badge-dot::before {
            background-color: var(--primary-500);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .navbar-search input {
                width: 180px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.show {
                transform: translateX(0);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .navbar-search {
                display: none;
            }

            .navbar-profile-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .navbar {
                padding: 0.75rem 1rem;
            }

            .navbar-notifications {
                display: none;
            }

            .stats-value {
                font-size: 1.5rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 1rem;
            }

            .card-header {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .card-header .btn-group {
                align-self: flex-start;
                width: 100%;
                display: flex;
                justify-content: space-between;
            }

            .card-body {
                padding: 1rem;
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
                <div class="sidebar-logo">
                    <div class="sidebar-logo-icon">DC</div>
                    <div class="sidebar-logo-text">DentalCare Pro</div>
                </div>
                <button class="sidebar-toggle" id="sidebarCollapseBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>

            <!-- Sidebar menu section -->
            <div class="sidebar-menu">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                    <div class="sidebar-tooltip">Dashboard</div>
                </a>

                <!-- Patient Management -->
                <div class="sidebar-group">
                    <div class="sidebar-group-header">Patient Management</div>
                    <a href="{{ route('admin.patient.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.patient.index') ? 'active' : '' }}">
                        <i class="fas fa-search"></i>
                        <span>Search Patient</span>
                        <div class="sidebar-tooltip">Search Patient</div>
                    </a>
                    <a href="{{ route('admin.patient.list') }}" class="sidebar-menu-item {{ request()->routeIs('admin.patient.list') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                        <div class="sidebar-tooltip">Patient List</div>
                    </a>
                    <a href="{{ route('admin.patient.create') }}" class="sidebar-menu-item {{ request()->routeIs('admin.patient.create') ? 'active' : '' }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Add New Patient</span>
                        <div class="sidebar-tooltip">Add New Patient</div>
                    </a>
                </div>

                <!-- Appointment Management -->
                <div class="sidebar-group">
                    <div class="sidebar-group-header">Appointments</div>
                    <a href="{{ route('admin.appointments.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.appointments.index') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>All Appointments</span>
                        <div class="sidebar-tooltip">All Appointments</div>
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Schedule Appointment</span>
                        <div class="sidebar-tooltip">Schedule Appointment</div>
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Today's Schedule</span>
                        <div class="sidebar-tooltip">Today's Schedule</div>
                    </a>
                </div>

                <!-- Treatment Management -->
                <div class="sidebar-group">
                    <div class="sidebar-group-header">Treatments</div>
                    <a href="#" class="sidebar-menu-item">
                        <i class="fas fa-tooth"></i>
                        <span>Treatment Plans</span>
                        <div class="sidebar-tooltip">Treatment Plans</div>
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Treatment History</span>
                        <div class="sidebar-tooltip">Treatment History</div>
                    </a>
                </div>

                <!-- Financial Management -->
                <div class="sidebar-group">
                    <div class="sidebar-group-header">Financial</div>
                    <a href="{{ route('admin.invoice.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.invoice.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Invoices</span>
                        <div class="sidebar-tooltip">Invoices</div>
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Payments</span>
                        <div class="sidebar-tooltip">Payments</div>
                    </a>
                    <a href="{{ route('admin.chart.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.chart.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                        <div class="sidebar-tooltip">Reports</div>
                    </a>
                </div>

                <!-- System Management -->
                <div class="sidebar-group">
                    <div class="sidebar-group-header">System</div>
                    <a href="#" class="sidebar-menu-item">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                        <div class="sidebar-tooltip">Settings</div>
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <i class="fas fa-user-md"></i>
                        <span>Staff Management</span>
                        <div class="sidebar-tooltip">Staff Management</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Navbar -->
            <div class="navbar">
                <div class="navbar-left">
                    <button class="navbar-toggler" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="navbar-search">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                </div>

                <div class="navbar-right">
                    <div class="navbar-notifications">
                        <button class="navbar-notifications-btn">
                            <i class="fas fa-bell"></i>
                            <span class="navbar-notifications-badge">3</span>
                        </button>
                    </div>

                    <div class="navbar-profile">
                        <div class="navbar-profile-img">
                            <img src="{{ asset('images/user.png') }}" alt="{{ Auth::user()->name }}">
                        </div>
                        <div class="navbar-profile-info">
                            <div class="navbar-profile-name">{{ Auth::user()->name }}</div>
                            <div class="navbar-profile-role">Administrator</div>
                        </div>

                        <div class="navbar-profile-menu">
                            <a href="{{ route('profile.edit') }}" class="navbar-profile-menu-item">
                                <i class="fas fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="#" class="navbar-profile-menu-item">
                                <i class="fas fa-cog"></i>
                                <span>Account Settings</span>
                            </a>
                            <div class="navbar-profile-menu-divider"></div>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="navbar-profile-menu-logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
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

    <!-- Scripts -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js')}}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');

            // Sidebar toggle for mobile view
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Sidebar collapse toggle
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

            // Check screen width and collapse sidebar by default on smaller screens
            function checkScreenSize() {
                if (window.innerWidth < 992) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');

                    const icon = sidebarCollapseBtn.querySelector('i');
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                }
            }

            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);

            // Add animation delay for sidebar menu items
            const menuItems = document.querySelectorAll('.sidebar-menu-item');
            menuItems.forEach((item, index) => {
                item.style.animationDelay = (index * 0.05) + 's';
            });
        });
    </script>

    <!-- Additional Scripts -->
    @yield('javascript')
</body>
</html>
