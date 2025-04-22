{{-- resources/views/components/sidebar.blade.php --}}
<aside id="sidebar" class="fixed left-0 top-0 h-screen w-72 bg-gray-900 text-gray-100 flex flex-col transform -translate-x-full transition-all duration-300 ease-in-out border-r border-gray-800 shadow-xl">
    {{-- Logo Section --}}
    <div class="p-6 border-b border-gray-800">
        <div class="flex items-center gap-4">
            <img src="/images/logo.png" alt="{{ config('app.name') }} Logo" class="w-12 h-12 rounded-xl bg-gradient-to-br p-0.5 shadow-lg">
            <span class="text-2xl font-bold bg-gradient-to-r from-red-400 to-pink-500 text-transparent bg-clip-text">CASONS</span>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-800">
        <div class="space-y-1">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white' : 'hover:bg-gray-800/50 text-gray-300 hover:text-white' }} transition-all duration-200">
                <i class="fas fa-th-large w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            {{-- Drivers --}}
            <a href="{{ route('admin.driver-management') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('drivers.*') ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white' : 'hover:bg-gray-800/50 text-gray-300 hover:text-white' }} transition-all duration-200">
                <i class="fas fa-car w-5 h-5 {{ request()->routeIs('drivers.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                <span class="font-medium">Manage Drivers</span>
            </a>

            {{-- Vehicle Management --}}
            <a href="{{ route('admin.vehicle-management') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('vehicles.*') ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white' : 'hover:bg-gray-800/50 text-gray-300 hover:text-white' }} transition-all duration-200">
                <i class="fas fa-car w-5 h-5 {{ request()->routeIs('vehicles.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                <span class="font-medium">Manage Cars</span>
            </a>

            {{-- Customer Management --}}
            <a href="{{ route('admin.customer-management') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('customers.*') ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white' : 'hover:bg-gray-800/50 text-gray-300 hover:text-white' }} transition-all duration-200">
                <i class="fas fa-users w-5 h-5 {{ request()->routeIs('customers.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                <span class="font-medium">Manage Customer</span>
            </a>

            {{-- Booking Management --}}
            <a href="{{ route('admin.booking-management') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('bookings.*') ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white' : 'hover:bg-gray-800/50 text-gray-300 hover:text-white' }} transition-all duration-200">
                <i class="fas fa-book w-5 h-5 {{ request()->routeIs('bookings.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                <span class="font-medium">Manage Request</span>
            </a>

            {{-- Reports --}}
            <a href="{{ route('admin.reports') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white' : 'hover:bg-gray-800/50 text-gray-300 hover:text-white' }} transition-all duration-200">
                <i class="fas fa-chart-bar w-5 h-5 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                <span class="font-medium">Reports</span>
            </a>
        </div>
    </nav>

    {{-- Logout Button --}}
    <div class="p-4 border-t border-gray-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl bg-gray-800 hover:bg-gradient-to-r from-red-500 to-pink-600 text-gray-300 hover:text-white transition-all duration-300">
                <i class="fas fa-sign-out-alt w-5 h-5"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('mousemove', function(event) {
        const sidebar = document.getElementById('sidebar');
        const threshold = 100; // Increased detection area

        if (event.clientX < threshold || sidebar.matches(':hover')) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('shadow-2xl');
        } else {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('shadow-2xl');
        }
    });
</script>
