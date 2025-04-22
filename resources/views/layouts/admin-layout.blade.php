<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Rent a Car')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles') {{-- Dynamic CSS will be injected here --}}
</head>

<body class="bg-gray-900 text-white font-hanken-grotesk">
    @include('admin.navigation')

    @yield('content') {{-- Main content goes here --}}

    @yield('scripts') {{-- Dynamic JS will be injected here --}}

    @include('admin.sidebar') {{-- Sidebar component --}}
    @include('admin.footer') {{-- Footer component --}}
</body>

</html>
