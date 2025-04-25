<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Admin Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="hidden space-x-8 sm:-my-px sm:flex">
                            <x-nav-link :href="route('admin.patient.index')" :active="request()->routeIs('admin.patient.*')">
                                {{ __('Patients') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.chart.index')" :active="request()->routeIs('admin.chart.*')">
                                {{ __('Reports') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.invoice.index')" :active="request()->routeIs('admin.invoice.*')">
                                {{ __('Invoice') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.appointments.index')" :active="request()->routeIs('admin.appointments.*')">
                                {{ __('Appointments') }}
                            </x-nav-link>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
