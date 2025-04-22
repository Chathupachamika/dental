<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 admin-header z-50">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="brand-logo text-4xl font-extrabold tracking-wider">CASONS</a>
            </div>

            <div class="flex items-center space-x-4">
                <button @click="open = ! open" class="mobile-menu-button md:hidden">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <nav class="nav-menu hidden md:flex md:items-center md:space-x-8" id="navMenu">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-gray-300 hover:text-white">Home</a>
                    <a href="{{ route('admin.vehicle-management') }}" class="nav-link text-gray-300 hover:text-white">Manage Cars</a>
                    <a href="{{ route('admin.driver-management') }}" class="nav-link text-gray-300 hover:text-white">Manage Drivers</a>
                    <a href="{{ route('admin.customer-management') }}" class="nav-link text-gray-300 hover:text-white">Manage Customer</a>
                    <a href="{{ route('admin.booking-management') }}" class="nav-link text-gray-300 hover:text-white">Manage Request</a>
                    <a href="{{ route('admin.reports') }}" class="nav-link text-gray-300 hover:text-white">Reports</a>

                    <div class="md:flex">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="logout-btn inline-flex items-center px-3 py-2 text-gray-300 hover:text-white font-medium transition-all duration-300 ease-in-out">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="md:hidden">
            <div class="mobile-menu space-y-2 py-4" id="mobileMenu">
                <a href="{{ route('admin.dashboard') }}" class="block nav-link text-gray-300 hover:text-white">Home</a>
                <a href="{{ route('admin.vehicle-management') }}" class="block nav-link text-gray-300 hover:text-white">Manage Cars</a>
                <a href="{{ route('admin.driver-management') }}" class="block nav-link text-gray-300 hover:text-white">Manage Drivers</a>
                <a href="{{ route('admin.customer-management') }}" class="block nav-link text-gray-300 hover:text-white">Manage Customer</a>
                <a href="{{ route('admin.booking-management') }}" class="block nav-link text-gray-300 hover:text-white">Manage Request</a>
                <a href="{{ route('admin.reports') }}" class="block nav-link text-gray-300 hover:text-white">Reports</a>

                <div class="pt-4 pb-1 border-t border-gray-700">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-300">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.edit')" class="block nav-link text-gray-300 hover:text-white">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block nav-link text-gray-300 hover:text-white">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    /* Header Container */
    .admin-header {
        background-color: #1a1a2e; /* Darker purple-blue for dark theme */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        top: 0;
        width: 100%;
        z-index: 1000;
    }

    /* Logo Styles */
    .brand-logo {
        font-family: 'Orbitron', sans-serif;
        background: linear-gradient(135deg, #e2e8f0 0%, #94a3b8 50%, #64748b 100%); /* Adjusted for dark theme */
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.05);
        letter-spacing: 0.1em;
        transform: scale(1);
        transition: all 0.3s ease;
        position: relative;
    }

    .brand-logo:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 50%, #94a3b8 100%); /* Slightly lighter on hover */
        -webkit-background-clip: text;
        background-clip: text;
    }

    .brand-logo::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        filter: blur(5px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .brand-logo:hover::after {
        opacity: 1;
    }

    /* Navigation Styles */
    .nav-link {
        position: relative;
        padding: 0.5rem 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Inter', sans-serif;
        font-weight: 500;
    }

    .nav-link::before {
        content: '';
        width: 0;
        position: absolute;
        height: 2px;
        bottom: 0;
        left: 50%;
        background: linear-gradient(90deg, #ff3366, #cc0033); /* Red gradient for dark theme */
        transition: all 0.3s ease;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .nav-link:hover::before {
        width: 100%;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(255,255,255,0.05) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        top: 0;
        left: 0;
    }

    .nav-link:hover::after {
        opacity: 1;
    }

    /* Logout Button */
    .logout-btn {
        position: relative;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        background: rgba(255, 255, 255, 0.03); /* Subtle transparency for dark theme */
        backdrop-filter: blur(4px);
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Mobile Menu Button */
    .mobile-menu-button {
        padding: 0.5rem;
        color: #d1d5db; /* Light gray for dark theme */
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .mobile-menu-button:hover {
        color: #ff6699; /* Pinkish-red for hover */
    }

    /* Mobile Menu */
    .mobile-menu {
        transition: all 0.3s ease-in-out;
        width: 100%;
        position: absolute;
        top: 80px;
        left: 0;
        background-color: #16213e; /* Slightly lighter than header for contrast */
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .mobile-menu-button {
            display: block;
        }

        .nav-menu {
            display: none;
        }

        .nav-menu[x-show="open"] {
            display: flex;
            flex-direction: column;
        }

        .brand-logo {
            font-size: 1.875rem;
        }

        .nav-link {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-link:last-child {
            border-bottom: none;
        }
    }

    html {
        scroll-behavior: smooth;
    }
</style>
