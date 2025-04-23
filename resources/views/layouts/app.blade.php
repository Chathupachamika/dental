<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Admin Navigation Header -->
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="hidden space-x-8 sm:-my-px sm:flex">
                                <a href="{{ route('admin.patient.index') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 
                                   {{ request()->routeIs('admin.patient.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500' }}
                                   text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition">
                                    Patients
                                </a>
                                <a href="{{ route('Chart.index') }}"
                                   class="inline-flex items-center px-1 pt-1 border-b-2
                                   {{ request()->routeIs('Chart.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500' }}
                                   text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition">
                                    Reports
                                </a>
                                <a href="{{ route('invoice.index') }}"
                                   class="inline-flex items-center px-1 pt-1 border-b-2
                                   {{ request()->routeIs('invoice.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500' }}
                                   text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition">
                                    Invoice
                                </a>
                                <a href="{{ route('Appointments.index') }}"
                                   class="inline-flex items-center px-1 pt-1 border-b-2
                                   {{ request()->routeIs('Appointments.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500' }}
                                   text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition">
                                    Appointments
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Heading -->
            @if(isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            <!-- Navigation -->
            <nav>
                <a class="nav-link" href="{{ route('admin.patient.index') }}">
                    <span class="menu-title">Search Patient</span>
                    <i class="mdi mdi-account-search menu-icon"></i>
                </a>
            </nav>
        </div>
    </body>
</html>
