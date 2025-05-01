@extends('user.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Page Header with Gradient Background -->
    <div class="relative mb-10">
        <div class="absolute inset-0 bg-gradient-to-r from-sky-100 to-blue-50 rounded-2xl opacity-70"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between py-8 px-6">
            <div class="mb-6 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-sky-500 text-white mr-3 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    My Appointments
                </h1>
                <p class="mt-2 text-lg text-gray-600 max-w-2xl">
                    View and manage all your dental appointments. Keep track of upcoming visits and your treatment history.
                </p>
            </div>
            <div class="flex">
                <a href="{{ route('user.book.appointment') }}"
                   class="group inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 shadow-md transition-all duration-300 ease-in-out transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Schedule Appointment
                </a>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="hidden lg:block absolute -bottom-4 right-10 w-20 h-20 bg-blue-50 rounded-full opacity-70"></div>
        <div class="hidden lg:block absolute -bottom-2 right-20 w-12 h-12 bg-sky-100 rounded-full opacity-70"></div>
        <div class="hidden lg:block absolute top-6 right-16 w-8 h-8 bg-sky-200 rounded-full opacity-50"></div>
    </div>

    <!-- Appointments Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-md">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 flex items-center transform transition-transform hover:scale-[1.02] hover:shadow-md">
                <div class="flex-shrink-0 bg-sky-100 rounded-lg p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Appointments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ count($appointments) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 flex items-center transform transition-transform hover:scale-[1.02] hover:shadow-md">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Upcoming</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $appointments->where('status', 'pending')->count() }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 flex items-center transform transition-transform hover:scale-[1.02] hover:shadow-md">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $appointments->where('status', 'completed')->count() }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-gray-50 border-b border-gray-200 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row justify-between gap-4">
                <!-- Filter Tabs -->
                <div class="flex overflow-x-auto pb-2 sm:pb-0 -mx-1 filter-tabs-container">
                    <button class="filter-tab active px-4 py-2.5 mx-1 text-sm font-medium rounded-md bg-white text-sky-600 shadow-sm border border-gray-100 transition-all duration-200" data-filter="all">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                            </svg>
                            All Appointments
                        </span>
                    </button>
                    <button class="filter-tab px-4 py-2.5 mx-1 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-100 transition-all duration-200" data-filter="upcoming">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Upcoming
                        </span>
                    </button>
                    <button class="filter-tab px-4 py-2.5 mx-1 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-100 transition-all duration-200" data-filter="completed">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Completed
                        </span>
                    </button>
                    <button class="filter-tab px-4 py-2.5 mx-1 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-100 transition-all duration-200" data-filter="cancelled">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancelled
                        </span>
                    </button>
                </div>

                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" class="search-input block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm transition-all duration-200" placeholder="Search appointments...">
                </div>
            </div>
        </div>

        @if(count($appointments) > 0)
            <!-- Appointments Table -->
            <div class="overflow-x-auto appointments-table-wrapper">
                <table class="min-w-full divide-y divide-gray-200 appointments-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Appointment Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Notes
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($appointments as $appointment)
                            @php
                                $statusClass = $appointment->status; // Use the status field for filtering

                                // Define status badge classes
                                $statusBadgeClasses = [
                                    'pending' => 'bg-sky-100 text-sky-800 border-sky-200',
                                    'upcoming' => 'bg-sky-100 text-sky-800 border-sky-200',
                                    'completed' => 'bg-green-100 text-green-800 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200'
                                ];

                                $badgeClass = $statusBadgeClasses[$statusClass] ?? 'bg-gray-100 text-gray-800 border-gray-200';

                                // Get appointment date components
                                $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date);
                                $month = $appointmentDate->format('M');
                                $day = $appointmentDate->format('d');
                                $weekday = $appointmentDate->format('l');
                                $time = $appointmentDate->format('h:i A');
                            @endphp
                            <tr data-status="{{ $statusClass }}" class="hover:bg-gray-50 transition-colors duration-150 appointment-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-14 w-14 bg-gradient-to-br from-sky-500 to-blue-600 text-white rounded-lg flex flex-col items-center justify-center mr-4 shadow-sm transform transition-transform hover:scale-110 hover:rotate-3">
                                            <span class="text-xs font-medium">{{ $month }}</span>
                                            <span class="text-xl font-bold leading-none">{{ $day }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $weekday }}
                                            </div>
                                            <div class="text-sm text-gray-500 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $time }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $badgeClass }}">
                                        {{ ucfirst($statusClass) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">
                                        @if($appointment->notes)
                                            <div class="flex items-start">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span>{{ $appointment->notes }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-500 italic">No notes</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('user.appointment.details', $appointment->id) }}"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-sky-700 bg-sky-100 hover:bg-sky-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="hidden sm:inline">View</span>
                                        </a>

                                        @if($appointment->status === 'pending')
                                            <form method="POST" action="{{ route('user.appointment.cancel', $appointment->id) }}" class="inline">
                                                @csrf
                                                <button type="button"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Cancel</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-medium">{{ $appointments->firstItem() ?? 0 }}</span> to
                        <span class="font-medium">{{ $appointments->lastItem() ?? 0 }}</span> of
                        <span class="font-medium">{{ $appointments->total() }}</span> appointments
                    </div>
                    <div>
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-16 px-4 sm:px-6 lg:px-8 text-center">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="h-32 w-32 rounded-full bg-sky-100 opacity-70 animate-pulse"></div>
                    </div>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <h2 class="mt-6 text-2xl font-bold text-gray-900">No Appointments Found</h2>
                <p class="mt-2 text-gray-600 mb-8 max-w-md">You don't have any appointments scheduled at the moment. Book your first appointment to get started.</p>
                <a href="{{ route('user.book.appointment') }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 shadow-md transition-all duration-300 ease-in-out transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Book Your First Appointment
                </a>
            </div>
        @endif
    </div>

    <!-- Help Card -->
    <div class="mt-8 bg-gradient-to-r from-sky-50 to-blue-50 rounded-xl shadow-sm border border-sky-100 p-6 flex flex-col md:flex-row items-center justify-between">
        <div class="mb-4 md:mb-0 md:mr-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Need help with your appointment?</h3>
            <p class="text-gray-600">Our team is ready to assist you with any questions or concerns.</p>
        </div>
        <div class="flex space-x-3">
            <a href="#" class="inline-flex items-center px-4 py-2 border border-sky-300 text-sm font-medium rounded-md text-sky-700 bg-white hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Contact Us
            </a>
            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                FAQ
            </a>
        </div>
    </div>
</div>

<!-- Add Tailwind CSS CDN if not already included in your layout -->
@push('styles')
<style>
    /* Custom animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .animate-slideInRight {
        animation: slideInRight 0.5s ease-out forwards;
    }

    .appointment-row {
        animation: fadeIn 0.5s ease-out forwards;
        animation-fill-mode: both;
    }

    /* Filter tabs container with custom scrollbar */
    .filter-tabs-container {
        scrollbar-width: thin;
        scrollbar-color: rgba(14, 165, 233, 0.5) rgba(241, 245, 249, 0.5);
    }

    .filter-tabs-container::-webkit-scrollbar {
        height: 6px;
    }

    .filter-tabs-container::-webkit-scrollbar-track {
        background: rgba(241, 245, 249, 0.5);
        border-radius: 10px;
    }

    .filter-tabs-container::-webkit-scrollbar-thumb {
        background-color: rgba(14, 165, 233, 0.5);
        border-radius: 10px;
    }

    /* Custom styles for filter tabs */
    .filter-tab {
        position: relative;
        overflow: hidden;
    }

    .filter-tab::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #0ea5e9;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .filter-tab:hover::after {
        width: 80%;
    }

    .filter-tab.active::after {
        width: 80%;
    }

    /* Custom styles for buttons */
    .btn-primary {
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transform: skewX(-25deg);
        transition: all 0.5s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    /* Responsive pagination styles */
    .pagination {
        @apply flex justify-center items-center space-x-1;
    }

    .pagination > .page-item > .page-link {
        @apply relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200;
    }

    .pagination > .page-item.active > .page-link {
        @apply z-10 bg-sky-50 border-sky-500 text-sky-600;
    }

    .pagination > .page-item.disabled > .page-link {
        @apply bg-white text-gray-300 cursor-not-allowed;
    }

    /* Card hover effects */
    .appointments-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .appointments-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Table row hover effect */
    tbody tr {
        position: relative;
    }

    tbody tr::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(14, 165, 233, 0.3), transparent);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    tbody tr:hover::after {
        transform: scaleX(1);
    }

    /* Custom focus styles */
    .ring-focus {
        @apply focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500;
    }

    /* Status badge pulse animation for pending appointments */
    tr[data-status="pending"] .status-badge {
        animation: pulse 2s infinite;
    }

    /* Add these styles to the existing <style> section */
    .search-highlight {
        background-color: rgba(245, 158, 11, 0.2);
        padding: 0 2px;
        border-radius: 2px;
    }

    .filter-empty-state,
    .search-empty-state {
        animation: fadeIn 0.3s ease-out;
    }

    .empty-state {
        padding: 2rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Status badge styles */
    .status-badge.pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .status-badge.completed {
        background-color: rgba(54, 179, 126, 0.1);
        color: var(--success);
    }

    .status-badge.cancelled {
        background-color: rgba(255, 86, 48, 0.1);
        color: var(--danger);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterTabs = document.querySelectorAll('.filter-tab');
        const appointmentRows = document.querySelectorAll('.appointments-table tbody tr');

        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Update active tab
                filterTabs.forEach(t => {
                    t.classList.remove('active');
                });
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                let visibleCount = 0;

                // Filter table rows with animation
                appointmentRows.forEach(row => {
                    const status = row.getAttribute('data-status');

                    if (filter === 'all' || (filter === 'upcoming' && status === 'pending') || status === filter) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show empty state if no visible rows
                const tableWrapper = document.querySelector('.appointments-table-wrapper');
                const existingEmptyState = document.querySelector('.filter-empty-state');

                if (visibleCount === 0) {
                    if (!existingEmptyState) {
                        const emptyState = document.createElement('div');
                        emptyState.className = 'filter-empty-state';
                        emptyState.innerHTML = `
                            <div class="empty-state" style="padding: 2rem;">
                                <div class="empty-icon">
                                    <i class="fas fa-filter"></i>
                                </div>
                                <h3 class="empty-title">No ${filter} appointments</h3>
                                <p class="empty-description">No appointments found with this filter.</p>
                            </div>
                        `;
                        tableWrapper.appendChild(emptyState);
                    }
                } else if (existingEmptyState) {
                    existingEmptyState.remove();
                }
            });
        });

        // Search functionality with highlighting
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                // Remove any existing filter-empty-state
                const existingEmptyState = document.querySelector('.filter-empty-state');
                if (existingEmptyState) {
                    existingEmptyState.remove();
                }

                // Remove any existing search-empty-state
                const existingSearchEmptyState = document.querySelector('.search-empty-state');
                if (existingSearchEmptyState) {
                    existingSearchEmptyState.remove();
                }

                // Remove previous highlights
                document.querySelectorAll('.search-highlight').forEach(el => {
                    el.outerHTML = el.innerHTML;
                });

                appointmentRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();

                    if (searchTerm === '') {
                        // If search is empty, respect the current filter
                        const activeFilter = document.querySelector('.filter-tab.active').getAttribute('data-filter');
                        const status = row.getAttribute('data-status');

                        if (activeFilter === 'all' || (activeFilter === 'upcoming' && status === 'pending') || status === activeFilter) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    } else if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;

                        // Highlight matching text
                        highlightText(row, searchTerm);
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show empty state if no results
                if (visibleCount === 0 && searchTerm !== '') {
                    const tableWrapper = document.querySelector('.appointments-table-wrapper');
                    const emptyState = document.createElement('div');
                    emptyState.className = 'search-empty-state';
                    emptyState.innerHTML = `
                        <div class="empty-state" style="padding: 2rem;">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="empty-title">No Results Found</h3>
                            <p class="empty-description">No appointments match your search for "${searchTerm}".</p>
                        </div>
                    `;
                    tableWrapper.appendChild(emptyState);
                }
            });
        }

        // Function to highlight text in search results
        function highlightText(element, term) {
            if (!term) return;

            const walker = document.createTreeWalker(
                element,
                NodeFilter.SHOW_TEXT,
                {
                    acceptNode: function(node) {
                        // Skip script tags
                        if (node.parentNode.tagName === 'SCRIPT') {
                            return NodeFilter.FILTER_REJECT;
                        }
                        return NodeFilter.FILTER_ACCEPT;
                    }
                }
            );

            const textNodes = [];
            let currentNode;

            while (currentNode = walker.nextNode()) {
                textNodes.push(currentNode);
            }

            textNodes.forEach(textNode => {
                const text = textNode.nodeValue;
                const lowerText = text.toLowerCase();
                const index = lowerText.indexOf(term);

                if (index >= 0) {
                    const before = document.createTextNode(text.substring(0, index));
                    const match = document.createElement('span');
                    match.className = 'search-highlight';
                    match.style.backgroundColor = 'rgba(245, 158, 11, 0.2)';
                    match.style.padding = '0 2px';
                    match.style.borderRadius = '2px';
                    match.appendChild(document.createTextNode(text.substring(index, index + term.length)));
                    const after = document.createTextNode(text.substring(index + term.length));

                    const parent = textNode.parentNode;
                    parent.replaceChild(after, textNode);
                    parent.insertBefore(match, after);
                    parent.insertBefore(before, match);
                }
            });
        }

        // Cancel appointment confirmation with SweetAlert2
        const cancelForms = document.querySelectorAll('form[action*="appointment.cancel"]');
        cancelForms.forEach(form => {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.type = 'button';
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Cancel Appointment?',
                        text: 'Are you sure you want to cancel this appointment? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b778c',
                        confirmButtonText: 'Yes, cancel it',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Processing...',
                                text: 'Cancelling your appointment',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit the form
                            form.submit();
                        }
                    });
                });
            }
        });
    });
</script>
@endpush
@endsection
