@extends('layouts.user-layout')


@section('title', 'CASONS - My Bookings')

@section('styles')
    <style>
        .container {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Remove gradient border effect for booking cards */
        .gradient-border {
            position: relative;
            padding: 0;
            /* Remove padding */
            border-radius: 0;
            /* Remove border radius */
            background: none;
            /* Remove background gradient */
        }

        .booking-card {
            transition: transform 0.3s ease;
            border: 2px solid #5E1313;
            /* Add red border */
        }

        .gradient-border:hover .booking-card {
            transform: translateY(-2px);
        }


        .scroll-indicator {
            opacity: 1;
            transition: opacity 0.5s ease;
            z-index: 10;
            position: relative;
            width: 40px;
            /* Added width to contain the arrows */
        }

        .scroll-indicator.hide {
            opacity: 0;
        }

        .arrow-1,
        .arrow-2,
        .arrow-3 {
            animation: fadeInOut 2s infinite;
            transform: translateX(0);
            position: absolute;
        }

        .arrow-1 {
            left: 0;
        }

        .arrow-2 {
            animation-delay: 0.2s;
            left: 15px;
            /* Increased spacing */
        }

        .arrow-3 {
            animation-delay: 0.4s;
            left: 30px;
            /* Increased spacing */
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateX(-15px);
                /* Increased animation distance */
            }

            50% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
                transform: translateX(15px);
                /* Increased animation distance */
            }
        }

        /* Updated hide arrows animation with increased distance */
        .scroll-progress-33 .arrow-1 {
            opacity: 0;
            transform: translateX(15px);
        }

        .scroll-progress-66 .arrow-2 {
            opacity: 0;
            transform: translateX(15px);
        }

        .scroll-progress-100 .arrow-3 {
            opacity: 0;
            transform: translateX(15px);
        }

        /* Rest of the styles remain unchanged */
        .hero-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-overlay {
            background: linear-gradient(to bottom, rgba(17, 24, 39, 0.7), rgba(17, 24, 39, 0.9));
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        /* Custom form inputs */
        .input-dark {
            background-color: #1F2937;
            border: 2px solid #374151;
            color: #F3F4F6;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .input-dark:focus {
            border-color: #EA2F2F;
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .date-input {
            background-color: #1F2937;
            border: 2px solid #374151;
            color: #F3F4F6;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .date-input::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.5;
            cursor: pointer;
        }

        /* Filter checkboxes */
        .filter-checkbox:checked+label {
            background-color: #EA2F2F;
            border-color: #EA2F2F;
        }

        .filter-checkbox:checked+label i {
            opacity: 1;
        }

        /* Sort menu */
        .sort-menu {
            background-color: #1F2937;
            border: 1px solid #374151;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Status badge animations */
        .animate-pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        /* Modal styles */
        .modal-overlay {
            backdrop-filter: blur(4px);
            transition: opacity 0.3s ease;
        }

        /* Card image hover effect */
        .booking-card img {
            transition: transform 0.3s ease;
        }

        .booking-card:hover img {
            transform: scale(1.05);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1F2937;
        }

        ::-webkit-scrollbar-thumb {
            background: #4B5563;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6B7280;
        }

        /* Status tab transitions */
        .status-tab {
            transition: all 0.3s ease;
        }

        .status-tab:hover {
            transform: translateY(-1px);
        }

        /* Active status tab color change */
        .status-tab.active {
            background-color: #EA2F2F;
        }

        /* Filter button styles */
        button.filter-checkbox+label {
            transition: all 0.3s ease;
        }

        button.filter-checkbox+label:hover {
            background-color: #374151;
        }

        /* Loading animation for async operations */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        /* Sweet Alert custom styles */
        .swal2-popup {
            border: 1px solid #374151 !important;
        }

        .swal2-title,
        .swal2-html-container {
            color: #F3F4F6 !important;
        }

        .swal2-icon {
            border-color: #EA2F2F !important;
            color: #EA2F2F !important;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .gradient-border {
                margin: 0.5rem 0;
            }

            .booking-card {
                height: auto;
            }
        }

        /* Empty state animation */
        #emptyState i {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
@endsection

@section('content')
    @php
    date_default_timezone_set('Asia/Colombo');
        $bookedCount = count(
            array_filter($all->toArray(), function ($booking) {
                if($booking['status'] !== "cancelled") {
                    return strtotime($booking['pick_time_date']) > time();
                }

            }),
    );

    $activeCount = count(
        array_filter($all->toArray(), function ($booking) {
            if($booking['status'] !== "cancelled") {
            $pick_time = strtotime($booking['pick_time_date']);
            $return_time = strtotime($booking['return_time_date']);
            return $pick_time <= time() && $return_time >= time();
            }
            }),
    );

    $pastCount = count(
        array_filter($all->toArray(), function ($booking) {
            if($booking['status'] !== "cancelled") {
            $return_time = strtotime($booking['return_time_date']);
            return $return_time < time();
            }
            }),
    );
        $cancelledCount = count(
            array_filter($all->toArray(), function ($booking) {
                return $booking['status'] === 'cancelled';
            }),
        );
    @endphp

    <section class="py-8 mt-10 ml-10">
        <div class="container mx-auto p-4">
            <div class="flex flex-col sm:flex-row justify-between items-right mb-6 gap-4">
                <div class="text-left">
                    <h2
                        class="text-3xl sm:text-4xl font-bold pb-4 bg-clip-text text-transparent bg-gradient-to-r from-[#EA2F2F] to-[#A42121]">
                        My Bookings
                    </h2>
                    <p class="text-gray-400">Manage your car rental reservations</p>
                </div>

                <div class="flex flex-wrap gap-4 justify-right">
                    <div class="relative">

                        <button onclick="openFilterModal()"
                            class="px-4 py-2 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors flex items-center">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>

                </div>
            </div>
            <!-- Status Tabs -->

            </h1>

            <div class="flex flex-wrap justify-right gap-2 mb-6">
                <form action="{{ route('user.booking.booked') }}" method="GET">
                    @csrf
                <button
                    class="{{$value=='booked' ? 'status-tab px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center sm:px-6 sm:py-3' : 'status-tab px-4 py-2 bg-grey-700 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center sm:px-6 sm:py-3'}}"
                    data-status="booked">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Booked
                    <span class="ml-2 bg-red-700 px-2 py-0.5 rounded-full text-sm">{{ $bookedCount }}</span>
                </button>
                </form>
                <form action="{{ route('user.booking.active') }}" method="GET">
                    @csrf
                <button
                    class="{{$value=='active' ? 'status-tab px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center sm:px-6 sm:py-3' : 'status-tab px-4 py-2 bg-grey-700 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center sm:px-6 sm:py-3'}}"
                    data-status="active">
                    <i class="fas fa-car-side mr-2"></i>
                    Active
                    <span class="ml-2 bg-red-700 px-2 py-0.5 rounded-full text-sm">{{ $activeCount }}</span>
                </button>
                </form>

                <form action="{{ route('user.booking.past') }}" method="GET">
                    @csrf
                <button
                    class="{{$value=='past' ? 'status-tab px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center sm:px-6 sm:py-3' : 'status-tab px-4 py-2 bg-grey-700 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center sm:px-6 sm:py-3'}}"
                    data-status="past">
                    <i class="fas fa-history mr-2"></i>
                    Past
                    <span class="ml-2 bg-red-700 px-2 py-0.5 rounded-full text-sm">{{ $pastCount }}</span>
                </button>
                </form>

                <form action="{{ route('user.booking.cancelled') }}" method="GET">
                <button
                    class="{{$value=='cancelled' ? 'status-tab px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center sm:px-6 sm:py-3' : 'status-tab px-4 py-2 bg-grey-700 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center sm:px-6 sm:py-3'}}"
                    data-status="cancelled">
                    <i class="fas fa-ban mr-2"></i>
                    Cancelled
                    <span class="ml-2 bg-red-700 px-2 py-0.5 rounded-full text-sm">{{ $cancelledCount }}</span>
                </button>
                </form>
            </div>

        </div>
        </div>
        @include('scroll-indicator.scroll-indicator')
    </section>

    <!-- Bookings List -->

    <section class="py-6">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="bookingsGrid">




        @foreach ($bookings as $booking)
        <div class="booking-card-wrapper" data-status="{{ $booking->status }}"
            data-price="{{ $booking->vehicle->daily_rate }}"
            data-date="{{ $booking->pick_time_date }}">

            <div class="gradient-border">
                <div class="booking-card bg-gray-900 rounded-xl overflow-hidden h-full">
                    <div class="relative">
                        <img src="{{ asset('storage/' . json_decode($booking->vehicle->image, true)[0] ?? 'default.jpg') }}"
                            alt="{{ $booking->vehicle->model }}"
                            class="w-full h-48 object-cover">

                        @if ($booking->status === 'booked')
                            <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-calendar-check mr-1"></i> Booked
                            </div>
                        @elseif ($booking->status === 'active')
                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse-slow">
                                <i class="fas fa-car-side mr-1"></i> Active
                            </div>
                        @elseif ($booking->status === 'past')
                            <div class="absolute top-4 right-4 bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-check-circle mr-1"></i> Past
                            </div>
                        @elseif ($booking->status === 'cancelled')
                            <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-times-circle mr-1"></i> Cancelled
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold mb-2">{{ $booking->vehicle->model }}</h3>
                                <p class="text-gray-400 flex items-center">
                                    <i class="fas fa-hashtag mr-2 text-blue-400"></i>
                                    {{ $booking->booking_id }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-400">Total Amount</p>
                                <p class="text-xl font-semibold text-green-400">
                                    LKR {{ number_format($booking->vehicle->daily_rate, 2) }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-gray-300">
                                <i class="fas fa-calendar-alt w-6 text-blue-400"></i>
                                <span>{{ date('M d, Y', strtotime($booking->pick_time_date)) }} - {{ date('M d, Y', strtotime($booking->return_time_date)) }}</span>
                            </div>
                            <div class="flex items-center text-gray-300">
                                <i class="fas fa-map-marker-alt w-6 text-purple-400"></i>
                                <span>{{ $booking->location }}</span>
                            </div>
                            <div class="flex items-center text-gray-300">
                                <i class="fas fa-clock w-6 text-pink-400"></i>
                                <span>{{ date('h:i A', strtotime($booking->pick_time_date)) }}</span>
                            </div>
                        </div>

                        <button onclick="showBookingDetails({{$booking}})"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center">
                            <i class="fas fa-eye mr-2"></i>View Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach




            </div>
            @if (count($bookings) == 0)
                         <!-- Empty State -->
            <div  class="text-center py-20">
                <div class="text-gray-400 mb-6">
                    <i class="fas fa-calendar-xmark text-6xl mb-4 block"></i>
                    <h3 class="text-2xl font-semibold">No Bookings Found</h3>
                    <p class="text-gray-500 mt-2">No bookings match your current filters.</p>
                </div>
            </div>
        </div>
            @endif

    </section>

    <div id="filterModal"
        class="fixed inset-0 bg-black bg-opacity-50 modal-overlay hidden items-center justify-center z-50">
        <div class="bg-gray-900 rounded-xl p-6 w-full max-w-2xl mx-4">
            <div class="flex justify-between items-start mb-6">
                <h2 class="text-2xl font-bold text-white">Filter Bookings</h2>
                <button onclick="closeFilterModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="filterForm" class="space-y-6" action="{{route('user.booking.search')}}" method="GET" onsubmit="applyFilters(event)">
                <!-- Date Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Start Date</label>
                        <input type="date" name="startDate" class="w-full date-input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">End Date</label>
                        <input type="date" name="endDate" class="w-full date-input">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Booking Status</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="relative">
                            <input type="checkbox" id="status-active" name="status" value="active"
                                class="filter-checkbox hidden">
                            <label for="status-active"
                                class="flex items-center justify-center px-4 py-2 border-2 border-gray-600 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">
                                <i class="fas fa-check mr-2 opacity-0"></i>Active
                            </label>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="status-booked" name="status" value="booked"
                                class="filter-checkbox hidden">
                            <label for="status-booked"
                                class="flex items-center justify-center px-4 py-2 border-2 border-gray-600 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">
                                <i class="fas fa-check mr-2 opacity-0"></i>Booked
                            </label>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="status-completed" name="status" value="completed"
                                class="filter-checkbox hidden">
                            <label for="status-completed"
                                class="flex items-center justify-center px-4 py-2 border-2 border-gray-600 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">
                                <i class="fas fa-check mr-2 opacity-0"></i>Past
                            </label>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="status-cancelled" name="status" value="cancelled"
                                class="filter-checkbox hidden">
                            <label for="status-cancelled"
                                class="flex items-center justify-center px-4 py-2 border-2 border-gray-600 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">
                                <i class="fas fa-check mr-2 opacity-0"></i>Cancelled
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Vehicle Type</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div class="relative">
                            <input type="checkbox" id="type-sedan" name="vehicleType" value="sedan"
                                class="filter-checkbox hidden">
                            <label for="type-sedan"
                                class="flex items-center justify-center px-4 py-2 border-2 border-gray-600 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">
                                <i class="fas fa-check mr-2 opacity-0"></i>Sedan
                            </label>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="type-suv" name="vehicleType" value="suv"
                                class="filter-checkbox hidden">
                            <label for="type-suv"
                                class="flex items-center justify-center px-4 py-2 border-2 border-gray-600 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">
                                <i class="fas fa-check mr-2 opacity-0"></i>SUV
                            </label>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="type-luxury" name="vehicleType" value="luxury"
                                class="filter-checkbox hidden">
                            <label for="type-luxury"
                                class="flex items-center justify-center px-4 py-2 border-2 border-gray-600 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">
                                <i class="fas fa-check mr-2 opacity-0"></i>Luxury
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Price Range</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input type="number" name="minPrice" placeholder="Min Price" class="w-full input-dark">
                        </div>
                        <div>
                            <input type="number" name="maxPrice" placeholder="Max Price" class="w-full input-dark">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="button" onclick="resetFilters()"
                        class="flex-1 bg-gray-700 text-white py-2.5 rounded-lg hover:bg-gray-600 transition-colors">
                        Reset Filters
                    </button>

                        @csrf
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Filters
                    </button>

                </div>
            </form>
        </div>
    </div>
    <form id="deleteForm" action="{{route('user.booking.destroy', ["booking" => 2])}}" method="POST">
        @csrf
        @method("DELETE")
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const scrollIndicators = document.querySelectorAll('.scroll-indicator');
            const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

            window.addEventListener('scroll', () => {
                const scrollProgress = (window.scrollY / maxScroll) * 100;

                scrollIndicators.forEach(scrollIndicator => {
                    if (scrollProgress > 0) {
                        scrollIndicator.classList.add('scroll-progress-33');
                    }
                    if (scrollProgress > 33) {
                        scrollIndicator.classList.add('scroll-progress-66');
                    }
                    if (scrollProgress > 66) {
                        scrollIndicator.classList.add('scroll-progress-100');
                    }
                    if (scrollProgress > 90) {
                        scrollIndicator.classList.add('hide');
                    }
                    if (scrollProgress === 0) {
                        scrollIndicator.classList.remove(
                            'scroll-progress-33',
                            'scroll-progress-66',
                            'scroll-progress-100',
                            'hide'
                        );
                    }
                });
            });
        });



        // For booked bookings - show details with cancel option
        function showBookedBookingDetails(booking) {
           console.log(booking);
           const durationMs = new Date(booking.return_time_date) - new Date(booking.pick_time_date);
const days = Math.floor(durationMs / (1000 * 60 * 60 * 24));  // Convert to days
const hours = Math.floor((durationMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            Swal.fire({
                title: 'Booking Details',
                html: `
                                               <div class="text-left">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Booking Information</h3>
                                <p class="text-gray-300">Booking ID: ${booking.booking_id}</p>
                                <p class="text-gray-300">${booking.status}</p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Vehicle Details</h3>
                                <p class="text-gray-300">Model: ${booking.vehicle.model}</p>
                                <p class="text-gray-300">Color: ${booking.vehicle.color}</p>
                                <p class="text-gray-300">License Plate: ${booking.vehicle.number_plate}</p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Rental Period</h3>
                                <p class="text-gray-300">Start: ${new Date(booking.pick_date).toISOString().split("T")[0]} - ${booking.pick_time}</p>
                                <p class="text-gray-300">End: ${new Date(booking.return_date).toISOString().split("T")[0]} - ${booking.return_time}</p>
                                <p class="text-gray-300"> Duration: ${days} days ${hours} hours</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold mb-2">Payment Details</h3>
                                <p class="text-gray-300">Total Amount: LKR ${booking.vehicle.daily_rate * days*10}</p>
                            </div>
                        </div>
                    `,
                showCancelButton: true,
                confirmButtonText: 'Cancel Booking',
                cancelButtonText: 'Close',
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#4B5563',
                background: '#1F2937',
                color: '#FFFFFF',
                customClass: {
                    popup: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmCancellation(booking.booking_id);
                }
            });
        }

        function toggleSortMenu() {
            const menu = document.getElementById('sortMenu');
            menu.classList.toggle('hidden');
        }

        function sortBookings(criteria) {
            const grid = document.getElementById('bookingsGrid');
            const cards = Array.from(grid.children);

            cards.sort((a, b) => {
                const aValue = a.dataset[criteria];
                const bValue = b.dataset[criteria];

                if (criteria === 'date') {
                    return new Date(bValue) - new Date(aValue);
                }
                if (criteria === 'price') {
                    return parseFloat(bValue) - parseFloat(aValue);
                }
                return aValue.localeCompare(bValue);
            });

            cards.forEach(card => grid.appendChild(card));
            toggleSortMenu();
        }

        // Filter modal functionality
        function openFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function applyFilters(event) {


            closeFilterModal();

            // Show success message
            Swal.fire({
                title: 'Filters Applied',
                text: 'Your bookings have been filtered according to your preferences.',
                icon: 'success',
                background: '#1F2937',
                color: '#FFFFFF',
                confirmButtonColor: '#2563EB',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg'
                }
            });
            documentElement.getElementById('filterForm').submit();
        }

        function resetFilters() {
            const form = document.getElementById('filterForm');
            form.reset();

            // Reset any additional filter state here

            Swal.fire({
                title: 'Filters Reset',
                text: 'All filters have been cleared.',
                icon: 'info',
                background: '#1F2937',
                color: '#FFFFFF',
                confirmButtonColor: '#2563EB',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg'
                }
            });
        }


        // Close modals when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeFilterModal();
                }
            });
        });

        // Close modals and menus on escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeFilterModal();
                document.getElementById('sortMenu').classList.add('hidden');
            }
        });

        // For active bookings - show details without cancel option
        function showBookingDetails(booking) {
            if(booking.status=="booked"){
                this.showBookedBookingDetails(booking);
                return;
            }
            // const booking = JSON.parse(bookingJson);
            console.log(booking);
            const durationMs = new Date(booking.return_time_date) - new Date(booking.pick_time_date);
const days = Math.floor(durationMs / (1000 * 60 * 60 * 24));  // Convert to days
const hours = Math.floor((durationMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            Swal.fire({
                title: 'Booking Details',
                html: `
                        <div class="text-left">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Booking Information</h3>
                                <p class="text-gray-300">Booking ID: ${booking.booking_id}</p>
                                <p class="text-gray-300">${booking.status}</p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Vehicle Details</h3>
                                <p class="text-gray-300">Model: ${booking.vehicle.model}</p>
                                <p class="text-gray-300">Color: ${booking.vehicle.color}</p>
                                <p class="text-gray-300">License Plate: ${booking.vehicle.number_plate}</p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Rental Period</h3>
                                <p class="text-gray-300">Start: ${new Date(booking.pick_date).toISOString().split("T")[0]} - ${booking.pick_time}</p>
                                <p class="text-gray-300">End: ${new Date(booking.return_date).toISOString().split("T")[0]} - ${booking.return_time}</p>
                                <p class="text-gray-300"> Duration: ${days} days ${hours} hours</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold mb-2">Payment Details</h3>
                                <p class="text-gray-300">Total Amount: LKR ${booking.vehicle.daily_rate * days*10}</p>
                            </div>
                        </div>
                    `,
                confirmButtonText: 'Done',
                confirmButtonColor: '#4B5563',
                background: '#1F2937',
                color: '#FFFFFF',
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        }

        function showCompletedBookingDetails(bookingJson) {
            const booking = JSON.parse(bookingJson);
            const status = booking.status === 'past' ? 'Completed' : 'Cancelled';

            Swal.fire({
                title: 'Booking Details',
                html: `
                        <div class="text-left">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Booking Information</h3>
                                <p class="text-gray-300">Booking ID: ${booking.id}</p>
                                <p class="text-gray-300">Status: ${status}</p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Vehicle Details</h3>
                                <p class="text-gray-300">Model: ${booking.model}</p>
                                <p class="text-gray-300">Color: ${booking.color}</p>
                                <p class="text-gray-300">License Plate: ${booking.license_plate}</p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Rental Period</h3>
                                <p class="text-gray-300">Start: ${booking.start_date} ${booking.pickup_time}</p>
                                <p class="text-gray-300">End: ${booking.end_date} ${booking.pickup_time}</p>
                                <p class="text-gray-300">Duration: ${booking.duration}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold mb-2">Payment Details</h3>
                                <p class="text-gray-300">Total Amount: LKR ${booking.price}</p>
                                <p class="text-gray-300">Payment Status: ${booking.payment_status}</p>
                            </div>
                        </div>
                    `,
                confirmButtonText: 'Done',
                confirmButtonColor: '#4B5563',
                background: '#1F2937',
                color: '#FFFFFF',
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        }

        function confirmCancellation(bookingId) {
            Swal.fire({
                title: 'Cancel Booking?',
                text: "This action cannot be undone. Are you sure?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#4B5563',
                confirmButtonText: 'Yes, cancel booking',
                background: '#1F2937',
                color: '#FFFFFF',
                customClass: {
                    popup: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulate cancellation request
                    setTimeout(() => {
                        Swal.fire({
                            title: 'Booking Cancelled',
                            text: 'Your booking has been successfully cancelled.',
                            icon: 'success',
                            background: '#1F2937',
                            color: '#FFFFFF',
                            customClass: {
                                popup: 'rounded-xl'
                            }
                        }).then(() => {
                            const form = document.getElementById("deleteForm");
                            if (form) {
                                form.action = "/user/bookings/"+bookingId; // Set new action dynamically
                                form.submit(); // Submit the form
                            }
                        });
                    }, 1000);
                }
            });
        }
    </script>
@endsection
