<aside id="sidebar"
    class="fixed left-0 top-0 h-screen w-60 bg-gray-900 text-gray-100 flex flex-col transform -translate-x-full transition-all duration-300 ease-in-out border-r border-gray-800 shadow-xl">
    {{-- Logo Section --}}
    <div class="p-6">
        <div class="flex items-center gap-3">
            <span class="text-2xl font-bold text-white brand-logo">CASONS</span>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto custom-scrollbar">
        {{-- Home --}}
        <a href="{{ route('user.home') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-lg
    {{ request()->routeIs('user.home') ? 'bg-[#EA2F2F]/10 text-[#EA2F2F]' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}
    transition-all duration-200">
            <i class="fas fa-home text-lg w-5"></i>
            <span class="font-medium">Home</span>
        </a>

        {{-- Car Rental --}}
        <a href="{{ route('user.car-rental') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-lg
    {{ request()->routeIs('user.car-rental') ? 'bg-[#EA2F2F]/10 text-[#EA2F2F]' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}
    transition-all duration-200">
            <i class="fas fa-car text-lg w-5"></i>
            <span class="font-medium">Car Rental</span>
        </a>

        {{-- My Bookings --}}
        <a href="{{ route('user.booking') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-lg
        {{ request()->routeIs('user.booking') ? 'bg-[#EA2F2F]/10 text-[#EA2F2F]' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}
          transition-all duration-200">
            <i class="fas fa-bell text-lg w-5"></i>
            <span class="font-medium">My Bookings</span>
        </a>


        {{-- About Us --}}
        <a href="{{ route('user.aboutus') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-lg
        {{ request()->routeIs('user.aboutus') ? 'bg-[#EA2F2F]/10 text-[#EA2F2F]' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}
        transition-all duration-200">
            <i class="fas fa-info-circle text-lg w-5"></i>
            <span class="font-medium">About Us</span>
        </a>


        {{-- Rate Us --}}
        <a href="javascript:void(0);" onclick="showRateModal()"
            class="group flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-white/5 hover:text-white transition-all duration-200 rate-us-link">
            <i class="fas fa-star text-lg w-5"></i>
            <span class="font-medium">Rate Us</span>
        </a>

        {{-- Contact Us --}}
        <a href="{{ route('user.contactus') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-lg
        {{ request()->routeIs('user.contactus') ? 'bg-[#EA2F2F]/10 text-[#EA2F2F]' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}
        transition-all duration-200">
            <i class="fas fa-envelope text-lg w-5"></i>
            <span class="font-medium">Contact Us</span>
        </a>
    </nav>

    {{-- Logout Button --}}
    <div class="p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-white/5 text-gray-400 hover:bg-white/10 hover:text-white transition-all duration-200">
                <i class="fas fa-sign-out-alt text-lg w-5"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    .brand-logo {
        font-family: 'Orbitron', sans-serif;
        background: linear-gradient(135deg, #fff 0%, #e2e8f0 50%, #94a3b8 100%);
        -webkit-background-clip: text;
        background-clip: text;
        font-size: 2rem;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        letter-spacing: 0.1em;
        transform: scale(1);
        transition: all 0.3s ease;
        position: relative;
    }

    .brand-logo:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #fff 0%, #f1f5f9 50%, #cbd5e1 100%);
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
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        filter: blur(5px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .brand-logo:hover::after {
        opacity: 1;
    }

    /* Sidebar Base Styles */
    #sidebar {
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
        z-index: 1000;
    }

    /* Logo Section */
    .logo-container {
        position: relative;
        overflow: hidden;
    }

    .logo-container::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
    }

    nav a {
        position: relative;
        overflow: hidden;
    }

    nav a::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #ff0000, #000000);
        transition: width 0.3s ease;
        transform: translateX(-50%);
        border-radius: 2px;
        opacity: 0;
    }

    nav a:hover::before {
        width: 100%;
        opacity: 1;
    }

    /* Keep existing hover translations */
    nav a:hover i,
    nav a:hover span {
        transform: translateX(5px);
    }

    /* Update active link styles to include gradient */
    nav a.active,
    nav a.rate-us-active {
        background: linear-gradient(45deg, rgba(255, 0, 0, 0.1), rgba(0, 0, 0, 0.05));
        border-right: 3px solid #EA2F2F;
        color: #EA2F2F;
    }


    /* Ensure smooth transitions */
    nav a,
    nav a::before,
    nav a i,
    nav a span {
        transition: all 0.3s ease;
    }

    /* Logout Button */
    .logout-btn {
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
        transform: translateY(-2px);
    }

    /* Scrollbar Styles (for browsers that support it) */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #333 #0A0A0A;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #0A0A0A;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #333;
        border-radius: 20px;
        border: 2px solid #0A0A0A;
    }

    /* Hover Animation for Logo */
    .logo-container img {
        transition: transform 0.3s ease;
    }

    .logo-container:hover img {
        transform: scale(1.1);
    }

    /* Sidebar Open/Close Animation */
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
        }

        to {
            transform: translateX(0);
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-100%);
        }
    }

    #sidebar.open {
        animation: slideIn 0.3s forwards;
    }

    #sidebar.closed {
        animation: slideOut 0.3s forwards;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        #sidebar {
            width: 100%;
            max-width: 300px;
        }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
        * {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const threshold = 120;
        let isOpen = false;

        function toggleSidebar(open) {
            if (open && !isOpen) {
                sidebar.classList.remove('closed');
                sidebar.classList.add('open');
                isOpen = true;
            } else if (!open && isOpen) {
                sidebar.classList.remove('open');
                sidebar.classList.add('closed');
                isOpen = false;
            }
        }

        document.addEventListener('mousemove', function(event) {
            toggleSidebar(event.clientX < threshold);
        });

        sidebar.addEventListener('mouseenter', function() {
            toggleSidebar(true);
        });

        sidebar.addEventListener('mouseleave', function(event) {
            if (event.clientX > threshold) {
                toggleSidebar(false);
            }
        });

        // Add active class to current page link
        const currentPath = window.location.pathname;
        const navLinks = sidebar.querySelectorAll('nav a');
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });

    function showRateModal() {
        document.getElementById('rateModal').classList.remove('hidden');
        document.querySelector('.rate-us-link').classList.add('rate-us-active');
    }

    function closeRateModal() {
        document.getElementById('rateModal').classList.add('hidden');
        document.querySelector('.rate-us-link').classList.remove('rate-us-active');
    }
</script>
