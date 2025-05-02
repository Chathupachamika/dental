@extends('admin.admin_logged.app')

@section('styles')
<style>
    /* Custom animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideInUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    .slide-in {
        animation: slideInUp 0.5s ease-in-out;
    }

    /* Status badge pulse animation */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(14, 165, 233, 0); }
        100% { box-shadow: 0 0 0 0 rgba(14, 165, 233, 0); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    /* Hover effects */
    .hover-scale {
        transition: transform 0.2s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    /* Custom scrollbar for tables */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Modal animations */
    .modal-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
    }

    .modal-container {
        transform: translateY(-20px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-container.active {
        transform: translateY(0);
        opacity: 1;
    }

    /* Badge styles */
    .badge-dot {
        position: absolute;
        top: -2px;
        right: -2px;
        height: 8px;
        width: 8px;
        border-radius: 50%;
        background-color: #ef4444;
    }

    /* Enhanced notification button */
    .notify-btn {
        position: relative;
        overflow: hidden;
    }

    .notify-btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }

    .notify-btn:focus:not(:active)::after {
        animation: ripple 1s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        20% {
            transform: scale(25, 25);
            opacity: 0.5;
        }
        100% {
            opacity: 0;
            transform: scale(40, 40);
        }
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 slide-in">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Appointments Management
            </h1>
            <p class="text-gray-600 mt-1">View, manage, and track all patient appointments</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="#" onclick="openNewAppointmentModal()" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Appointment
            </a>

            <a href="#" onclick="openTodayScheduleModal()" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Today's Schedule
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 fade-in">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-sky-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900" id="pending-count">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-emerald-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500">Confirmed</p>
                    <p class="text-2xl font-semibold text-gray-900" id="confirmed-count">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500">Cancelled</p>
                    <p class="text-2xl font-semibold text-gray-900" id="cancelled-count">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-amber-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500">Today</p>
                    <p class="text-2xl font-semibold text-gray-900" id="today-count">0</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to fetch and update counts
        function updateAppointmentCounts() {
            fetch('/admin/appointments/counts')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('pending-count').textContent = data.pending;
                    document.getElementById('confirmed-count').textContent = data.confirmed;
                    document.getElementById('cancelled-count').textContent = data.cancelled;
                    document.getElementById('today-count').textContent = data.today;
                });
        }

        // Update counts when page loads
        updateAppointmentCounts();

        // Update counts every 30 seconds
        setInterval(updateAppointmentCounts, 30000);

        // Add this after your existing scripts
        function loadTodaySchedule() {
            fetch('/admin/appointment/today-schedule')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const tbody = document.getElementById('todayAppointmentsList');
                        document.getElementById('todayAppointmentCount').textContent = data.count;

                        if (data.appointments.length === 0) {
                            document.getElementById('noAppointmentsToday').classList.remove('hidden');
                            return;
                        }

                        tbody.innerHTML = data.appointments.map(appointment => `
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${appointment.time}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${appointment.patient_name}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${appointment.status_class}">
                                        ${appointment.status}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    ${appointment.notes}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" onclick="openNotifyModal(${appointment.id})" class="text-sky-600 hover:text-sky-900">
                                        Notify
                                    </a>
                                </td>
                            </tr>
                        `).join('');
                    }
                })
                .catch(error => {
                    console.error('Error loading today\'s schedule:', error);
                });
        }

        // Add function to handle modal
        function openTodayScheduleModal() {
            document.getElementById('todayScheduleModal').classList.remove('hidden');
            loadTodaySchedule();
        }

        function closeTodayScheduleModal() {
            document.getElementById('todayScheduleModal').classList.add('hidden');
        }
    </script>

    <!-- Main Content Card -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden fade-in">
        <!-- Card Header with Filters -->
        <div class="bg-gradient-to-r from-sky-50 to-white p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Filter Tabs -->
                <div class="flex p-1 bg-sky-50 rounded-full">
                    <a href="{{ route('admin.appointments.index') }}"
                       class="relative font-medium transition-all flex items-center gap-2 whitespace-nowrap text-sm py-2 px-4 rounded-full {{ !request('status') ? 'bg-white text-sky-600 shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-sky-100' }}">
                        All Appointments
                    </a>
                    <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}"
                       class="relative font-medium transition-all flex items-center gap-2 whitespace-nowrap text-sm py-2 px-4 rounded-full {{ request('status') === 'pending' ? 'bg-white text-sky-600 shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-sky-100' }}">
                        <span class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                        Pending
                    </a>
                    <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}"
                       class="relative font-medium transition-all flex items-center gap-2 whitespace-nowrap text-sm py-2 px-4 rounded-full {{ request('status') === 'confirmed' ? 'bg-white text-sky-600 shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-sky-100' }}">
                        Confirmed
                    </a>
                    <a href="{{ route('admin.appointments.index', ['status' => 'cancelled']) }}"
                       class="relative font-medium transition-all flex items-center gap-2 whitespace-nowrap text-sm py-2 px-4 rounded-full {{ request('status') === 'cancelled' ? 'bg-white text-sky-600 shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-sky-100' }}">
                        Cancelled
                    </a>
                </div>

                <!-- Date Filter -->
                <div class="flex items-center gap-3">
                    <form action="{{ route('admin.appointments.index') }}" method="GET" class="flex items-center">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" name="date" value="{{ request('date') }}"
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                                   onchange="this.form.submit()">
                        </div>

                        @if(request('date'))
                            <a href="{{ route('admin.appointments.index', request()->except('date')) }}"
                               class="ml-2 text-sm text-sky-600 hover:text-sky-800 transition-colors">
                                Clear
                            </a>
                        @endif
                    </form>

                    <div class="relative">
                        <input type="text" id="search-input" placeholder="Search appointments..."
                               class="pl-4 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($appointments->count() > 0)
            <!-- Appointments Table -->
            <div class="overflow-x-auto custom-scrollbar">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Patient
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($appointments as $appointment)
                            @php
                                $statusClass = '';
                                $statusIcon = '';

                                if ($appointment->status === 'pending') {
                                    $statusClass = 'bg-amber-100 text-amber-800';
                                    $statusIcon = '<svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                                } elseif ($appointment->status === 'confirmed') {
                                    $statusClass = 'bg-emerald-100 text-emerald-800';
                                    $statusIcon = '<svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                                } elseif ($appointment->status === 'cancelled') {
                                    $statusClass = 'bg-red-100 text-red-800';
                                    $statusIcon = '<svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
                                }

                                // Format date components
                                $date = \Carbon\Carbon::parse($appointment->appointment_date);
                                $isToday = $date->isToday();
                                $isTomorrow = $date->isTomorrow();
                                $isPast = $date->isPast();

                                $formattedDate = $date->format('M d, Y');
                                if ($isToday) {
                                    $formattedDate = 'Today';
                                } elseif ($isTomorrow) {
                                    $formattedDate = 'Tomorrow';
                                }

                                $time = $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A';

                                // Store contact info for modal
                                $contactNumber = $appointment->patient->mobileNumber ?? $appointment->user->mobile_number ?? 'N/A';
                                $patientName = $appointment->patient->name ?? $appointment->user->name ?? 'Unknown';
                            @endphp

                            <tr class="hover:bg-gray-50 transition-colors appointment-row" data-patient-name="{{ $patientName }}" data-contact="{{ $contactNumber }}" data-appointment-id="{{ $appointment->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-sky-600 text-white rounded-full flex items-center justify-center">
                                            <span class="font-semibold">{{ substr($appointment->user->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $appointment->user->name ?? 'Unknown' }}</div>
                                            <div class="text-xs text-gray-500">ID: #{{ str_pad($appointment->user->id ?? '0', 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 {{ $isToday ? 'bg-sky-600' : ($isPast ? 'bg-gray-500' : 'bg-sky-500') }} text-white rounded-lg flex flex-col items-center justify-center mr-3">
                                            <span class="text-xs font-medium">{{ $date->format('M') }}</span>
                                            <span class="text-xl font-bold">{{ $date->format('d') }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $formattedDate }}</div>
                                            <div class="text-sm text-gray-500">{{ $time }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }} {{ $appointment->status === 'pending' ? 'pulse' : '' }}">
                                        {!! $statusIcon !!}
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        @if($appointment->status === 'pending')
                                            <form action="{{ route('admin.appointments.confirm', $appointment->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure you want to confirm this appointment?')"
                                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-emerald-700 bg-emerald-100 hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Confirm</span>
                                                </button>
                                            </form>
                                        @endif

                                        @if($appointment->status !== 'cancelled')
                                            <form action="{{ route('admin.appointments.cancel', $appointment->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure you want to cancel this appointment?')"
                                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Cancel</span>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.appointments.edit', $appointment->id) }}"
                                           class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-sky-700 bg-sky-100 hover:bg-sky-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </a>

                                        <button type="button" onclick="openNotifyModal({{ $appointment->id }})"
                                           class="notify-btn inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                            <span class="hidden sm:inline">Notify</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-white border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500 mb-4 sm:mb-0">
                        Showing
                        <span class="font-medium text-gray-700">{{ $appointments->firstItem() }}</span>
                        to
                        <span class="font-medium text-gray-700">{{ $appointments->lastItem() }}</span>
                        of
                        <span class="font-medium text-gray-700">{{ $appointments->total() }}</span>
                        appointments
                    </div>

                    <div class="pagination-controls">
                        @if ($appointments->hasPages())
                            <div class="flex items-center space-x-1">
                                <!-- Previous Page Link -->
                                @if ($appointments->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $appointments->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-sky-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endif

                                <!-- Pagination Elements -->
                                @foreach ($appointments->getUrlRange(1, $appointments->lastPage()) as $page => $url)
                                    @if ($page == $appointments->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-sky-600 bg-sky-50 border border-sky-300 rounded-md">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-sky-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($appointments->hasMorePages())
                                    <a href="{{ $appointments->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-sky-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16 px-6">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-sky-100 text-sky-600 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No Appointments Found</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">There are no appointments matching your current filters.</p>
                <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset Filters
                </a>
            </div>
        @endif
    </div>
</div>

<!-- New Appointment Modal (Hidden by default) -->
<div id="newAppointmentModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-sky-600 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-medium text-white">Schedule New Appointment</h3>
            <button type="button" onclick="closeNewAppointmentModal()" class="text-white hover:text-gray-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.appointments.store') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Select Patient</label>
                <select id="patient_id" name="patient_id" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                    <option value="">Select a patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->mobileNumber }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" id="appointment_date" name="appointment_date" required
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                </div>
                <div>
                    <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                    <input type="time" id="appointment_time" name="appointment_time" required
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                </div>
            </div>

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea id="notes" name="notes" rows="3"
                          class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                          placeholder="Add any notes or special instructions"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeNewAppointmentModal()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                    Cancel
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                    Schedule Appointment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/admin/appointment/api/store', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                closeNewAppointmentModal();

                // Show success message with SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Appointment has been created successfully',
                    showConfirmButton: false,
                    timer: 1500,
                    position: 'top-end',
                    toast: true
                }).then(() => {
                    // Refresh page to show new appointment
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message || 'Error creating appointment',
                    position: 'top-end',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again.',
                position: 'top-end',
                toast: true,
                showConfirmButton: false,
                timer: 3000
            });
        });
    });
</script>

<!-- Notify Modal -->
<div id="notifyModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="modal-overlay absolute inset-0"></div>
    <div class="modal-container bg-white rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden relative">
        <div class="bg-sky-600 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-medium text-white">Patient Notification</h3>
            <button type="button" onclick="closeNotifyModal()" class="text-white hover:text-gray-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-12 w-12 bg-sky-600 text-white rounded-full flex items-center justify-center mr-4">
                        <span id="patientInitial" class="text-xl font-bold">P</span>
                    </div>
                    <div>
                        <h4 id="patientName" class="text-lg font-medium text-gray-900">Patient Name</h4>
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span id="contactNumber">Contact Number</span>
                        </div>
                    </div>
                </div>

                <div class="bg-sky-50 rounded-lg p-4 border border-sky-100 mb-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-700">
                                We recommend contacting this patient to remind them about their upcoming appointment. You can use the following message as a template:
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-700 text-sm">
                        "Hello <span id="messagePatientName">Patient</span>, this is a friendly reminder about your upcoming dental appointment scheduled at <span id="appointmentTime">time</span>. Please arrive 10 minutes early to complete any necessary paperwork. If you need to reschedule, please call us at your earliest convenience. Thank you!"
                    </p>
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                <div class="flex justify-between space-x-3">
                    <button type="button" onclick="copyMessage()"
                            class="flex-1 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Copy Message
                    </button>
                    <a href="#" id="callPatientBtn" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Call Patient
                    </a>
                </div>
                <div class="flex justify-between space-x-3">
                    <a href="#" id="sendSMSBtn" onclick="sendSMS()" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Send SMS
                    </a>
                    <a href="#" id="sendWhatsAppBtn" onclick="sendWhatsApp()" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function sendSMS() {
    const number = document.getElementById('contactNumber').textContent;
    const message = document.querySelector('.bg-white.rounded-lg.p-4 p').textContent;
    const encodedMessage = encodeURIComponent(message);
    window.open(`sms:${number}?body=${encodedMessage}`);
}

function sendWhatsApp() {
    const number = document.getElementById('contactNumber').textContent;
    const message = document.querySelector('.bg-white.rounded-lg.p-4 p').textContent;
    const encodedMessage = encodeURIComponent(message);
    window.open(`https://wa.me/${number}?text=${encodedMessage}`);
}
</script>

<!-- Today's Schedule Modal -->
<div id="todayScheduleModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="modal-overlay absolute inset-0" onclick="closeTodayScheduleModal()"></div>
    <div class="modal-container bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 overflow-hidden relative">
        <div class="bg-sky-600 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-medium text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Today's Schedule - {{ \Carbon\Carbon::now()->format('F d, Y') }}
            </h3>
            <button type="button" onclick="closeTodayScheduleModal()" class="text-white hover:text-gray-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-4 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    <span id="todayAppointmentCount" class="font-medium text-gray-900">0</span> appointments scheduled for today
                </div>
                <div class="flex space-x-2">
                    <button type="button" onclick="printSchedule()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Schedule
                    </button>
                    <button type="button" onclick="exportSchedule()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Export
                    </button>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                 </tr>
                        </thead>
                        <tbody id="todayAppointmentsList" class="bg-white divide-y divide-gray-200">
                            <!-- Today's appointments will be loaded here dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Empty state for no appointments -->
                <div id="noAppointmentsToday" class="hidden text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Appointments Today</h3>
                    <p class="text-gray-500 max-w-sm mx-auto mb-4">There are no appointments scheduled for today.</p>
                    <button onclick="openNewAppointmentModal(); closeTodayScheduleModal();" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Schedule New Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
