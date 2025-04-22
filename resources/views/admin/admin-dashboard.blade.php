@extends('layouts.admin-layout')

@section('title', 'Admin Dashboard')

@section('styles')
    <style>
        :root {
            --primary-color: #6366F1; /* Indigo */
            --secondary-color: #DC2626; /* Darker Red */
            --accent-color: #030712; /* Nearly Black */
            --background-color: #111827; /* Dark Blue-Gray */
            --card-background: #1F2937; /* Darker Blue-Gray */
            --text-primary: #F9FAFB; /* Very Light Gray */
            --text-secondary: #9CA3AF; /* Medium Gray */
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
        }

        .profile-popup {
            position: fixed;
            top: 20%;
            right: 10%;
            width: 600px;
            background: linear-gradient(to bottom, #1F2937, #111827);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            z-index: 50;
        }

        .profile-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.4);
            border-radius: 0.5rem;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .profile-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(31, 41, 55, 0.9);
        }

        .profile-input::placeholder {
            color: var(--text-secondary);
        }

        .update-button {
            background: var(--primary-color);
            color: var(--text-primary);
            padding: 0.75rem 2.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .update-button:hover {
            background: #4F46E5;
            transform: translateY(-1px);
        }

        header {
            backdrop-filter: blur(10px);
            background: rgba(17, 24, 39, 0.95);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .stats-card {
            background: linear-gradient(135deg, #2D3748 0%, #1F2937 100%);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(75, 85, 99, 0.2);
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        th {
            background: #374151;
            font-weight: 600;
            color: var(--text-primary);
        }

        tr:hover:not(thead tr) {
            background-color: #2D3748;
        }

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

        .chart-container {
            background-color: var(--card-background);
            border-radius: 0.75rem;
            box-shadow: var(--card-shadow);
            padding: 1rem;
        }

        .chart-select {
            background-color: var(--card-background);
            border: 1px solid #4B5563;
            color: var(--text-primary);
            border-radius: 0.375rem;
            padding: 0.5rem;
        }

        .chart-select:hover {
            border-color: var(--primary-color);
        }

        .chart-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .progress-bar {
            background: #374151;
            border-radius: 9999px;
            height: 0.5rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.3s ease;
        }

        @media (max-width: 640px) {
            .profile-popup {
                width: calc(100vw - 2rem);
                left: 1rem;
                right: 1rem;
            }
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1024px) {
            .grid-cols-12 {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }
        }
    </style>
@endsection

@section('content')
        {{-- <div class="bg-gray-900 p-4 flex flex-col md:flex-row justify-between items-center shadow-sm mt-0">
            <div class="flex items-center gap-4 flex-1">
                <h1 class="text-xl font-bold text-white">DASHBOARD</h1>
                <div class="relative max-w-md flex-1">
                    <input type="text" id="searchQuery" placeholder="Type in to Search"
                        class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-700 text-gray-300 border-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fas fa-search absolute left-4 top-3 text-gray-400"></i>
                </div>
            </div>

            <div class="flex items-center gap-6 mt-4 md:mt-0">
                @include('admin.admin-notification')
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-4">
                        <img src="{{ asset('images/administrator.png') }}" alt="Administrator" class="w-10 h-10 rounded-full">
                        <span class="font-medium text-white">{{ Auth::user()->name }}</span>
                    </button>
                    <div x-show="open" @click.away="open = false" id="profilePopup" class="profile-popup">
                        <div class="flex items-center gap-4 mb-6">
                            <h2 class="text-xl font-bold text-white">MANAGE YOUR PROFILE</h2>
                            <img src="{{ asset('images/administrator.png') }}" alt="Profile" class="w-12 h-12 rounded-full ml-auto">
                        </div>
                        <form id="profileForm" method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-2 gap-4">
                            @csrf
                            @method('PATCH')
                            <div class="relative">
                                <label class="text-sm text-gray-400">Name</label>
                                <div class="relative mt-1">
                                    <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="profile-input">
                                </div>
                            </div>
                            <div class="relative">
                                <label class="text-sm text-gray-400">Email</label>
                                <div class="relative mt-1">
                                    <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="profile-input">
                                </div>
                            </div>
                            <div class="col-span-2 text-center mt-4">
                                <button type="submit" class="update-button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="relative">
                        <i class="fas fa-sign-out-alt text-2xl text-white"></i>
                    </button>
                </form>
            </div>
        </div> --}}

        <main class="p-6 mt-20">
            <!-- Enhanced Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="stats-card p-4 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $stats['total_vehicles'] }}</h3>
                            <p class="text-gray-400">Total Vehicles</p>
                        </div>
                        <div class="p-3 bg-indigo-500/10 rounded-full">
                            <i class="fas fa-car text-indigo-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-400 flex justify-between">
                        <span>Today: {{ $stats['vehicles_today'] }}</span>
                        <span>Month: {{ $stats['vehicles_month'] }}</span>
                    </div>
                </div>
                <div class="stats-card p-4 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $stats['total_customers'] }}</h3>
                            <p class="text-gray-400">Total Customers</p>
                        </div>
                        <div class="p-3 bg-blue-500/10 rounded-full">
                            <i class="fas fa-users text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-400 flex justify-between">
                        <span>Today: {{ $stats['customers_today'] }}</span>
                        <span>Month: {{ $stats['customers_month'] }}</span>
                    </div>
                </div>
                <div class="stats-card p-4 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $stats['total_drivers'] }}</h3>
                            <p class="text-gray-400">Total Drivers</p>
                        </div>
                        <div class="p-3 bg-yellow-500/10 rounded-full">
                            <i class="fas fa-user-tie text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-400 flex justify-between">
                        <span>Today: {{ $stats['drivers_today'] ?? 0 }}</span>
                        <span>Month: {{ $stats['drivers_month'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="stats-card p-4 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-green-400">{{ $stats['total_bookings'] }}</h3>
                            <p class="text-gray-400">Total Bookings</p>
                        </div>
                        <div class="p-3 bg-green-500/10 rounded-full">
                            <i class="fas fa-calendar-check text-green-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-400 flex justify-between">
                        <span>Today: {{ $stats['bookings_today'] }}</span>
                        <span>Month: {{ $stats['bookings_month'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Charts and Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                <!-- Booking Status Pie Chart -->
                <div class="stats-card p-4 rounded-lg col-span-3">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-white">Booking Status</h3>
                            <p class="text-xl font-bold text-red-400">{{ array_sum($stats['booking_statuses']) }}</p>
                        </div>
                        <select id="rentPeriod" class="chart-select">
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="rentChart"></canvas>
                    </div>
                </div>

                <!-- Booking Trends Bar Chart -->
                <div class="stats-card p-4 rounded-lg col-span-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-white">Booking Trends</h3>
                        <select id="comboChartPeriod" class="chart-select">
                            <option value="6">Last 6 Months</option>
                            <option value="12">Last 12 Months</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="comboChart"></canvas>
                    </div>
                </div>

     <!-- Check Availability -->
    <!-- Check Availability -->
    <div class="stats-card p-6 rounded-lg col-span-4">
        <h3 class="text-lg font-semibold mb-6 text-white">Check Availability</h3>
        <form method="GET" id="availabilityForm" action="{{ route('admin.check-availability') }}" class="space-y-6">
            @csrf

            <div class="relative">
                <select name="model" id="carModelSelect"
                    class="w-full bg-gray-700 text-white border-gray-600 rounded-md p-2">
                    <option value="">Select Car Model</option>
                    @foreach ($carModels as $model)
                        <option value="{{ $model }}">{{ $model }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <input type="date" name="date" class="bg-gray-700 text-white rounded-md p-2 border border-gray-600"
                    value="{{ now()->format('Y-m-d') }}">
                <select name="time" class="bg-gray-700 text-white border-gray-600 rounded-md p-2">
                    <option value="10:00">10 AM</option>
                    <option value="14:00">2 PM</option>
                    <option value="18:00">6 PM</option>
                </select>
            </div>
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2.5 rounded-md hover:bg-indigo-700 transition-colors font-medium">
                Check
            </button>
        </form>

        <!-- Display Available Vehicles -->
        <div id="availabilityResult" class="mt-4 hidden bg-gray-800 text-white p-4 rounded-md"></div>
    </div>

    <script>
        // Handle form submission to check availability
        document.getElementById('availabilityForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form data
            const model = document.getElementById('carModelSelect').value;
            const date = document.querySelector('input[name="date"]').value;
            const time = document.querySelector('select[name="time"]').value;

            // Display a loading message while waiting for response
            const resultDiv = document.getElementById('availabilityResult');

            resultDiv.classList.remove('hidden');

            // Send a GET request to the server to check availability
            fetch('{{ route('admin.check-availability') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    model: model,
                    date: date,
                    time: time
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        resultDiv.innerHTML = data.error;
                    } else if (data.available) {
                        // Show available vehicle IDs
                        let vehicleList = '<ul>';
                        data.vehicles.forEach(vehicle => {
                            vehicleList +=`<li>Vehicle ID: ${vehicle.car_id}</li>`;
                        });
                        vehicleList += '</ul>';

                        resultDiv.innerHTML = `Available Vehicles: <br> ${vehicleList}`;
                    } else {
                        resultDiv.innerHTML = 'No available vehicles for this selection.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                });
        });
    </script>




                <!-- Vehicle Categories -->
                <div class="stats-card p-4 rounded-lg col-span-4">
                    <h3 class="text-lg font-semibold text-white mb-4">Vehicle Categories</h3>
                    <div class="space-y-4">
                        @foreach ($stats['vehicle_categories'] as $category)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-400">{{ $category->category }}</span>
                                    <span class="text-white">{{ $category->count }}</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill bg-indigo-500" style="width: {{ ($category->count / $stats['total_vehicles']) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Popular Vehicles -->
                <div class="stats-card p-4 rounded-lg col-span-4">
                    <h3 class="text-lg font-semibold text-white mb-4">Top Vehicles</h3>
                    <div class="space-y-4">
                        @foreach ($stats['popular_vehicles'] as $vehicle)
                            <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-indigo-500/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-car text-indigo-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-medium">{{ $vehicle->model }}</h4>
                                        <p class="text-gray-400 text-sm">{{ $vehicle->category }}</p>
                                    </div>
                                </div>
                                <span class="text-white font-medium">{{ $vehicle->bookings_count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="stats-card p-4 rounded-lg col-span-4">
                    <h3 class="text-lg font-semibold text-white mb-4">Recent Activities</h3>
                    <div class="space-y-4">
                        @foreach ($stats['recent_activities'] as $activity)
                            <div class="flex items-center space-x-4 p-3 bg-gray-800 rounded-lg">
                                <div class="w-8 h-8 rounded-full bg-indigo-500/10 flex items-center justify-center">
                                    <i class="fas {{ $activity->icon ?? 'fa-info-circle' }} text-indigo-400"></i>
                                </div>
                                <div>
                                    <p class="text-white text-sm">{{ $activity->description }}</p>
                                    <p class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="stats-card rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-4">Recent Bookings</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm border-b border-gray-700">
                                <th class="pb-3 text-gray-400">Booking ID</th>
                                <th class="pb-3 text-gray-400">Booking Date</th>
                                <th class="pb-3 text-gray-400">Client Name</th>
                                <th class="pb-3 text-gray-400">Car Model</th>
                                <th class="pb-3 text-gray-400">Date</th>
                                <th class="pb-3 text-gray-400">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($recentBookings as $booking)
                                <tr class="border-b border-gray-700">
                                    <td class="py-3 text-gray-300">{{ $booking->booking_id }}</td>
                                    <td class="py-3 text-gray-300">{{ $booking->created_at->format('Y.m.d') }}</td>
                                    <td class="py-3 text-gray-300">{{ $booking->customer?->customer_full_name ?? 'N/A' }}</td>
                                    <td class="py-3 text-gray-300">{{ $booking->vehicle?->model ?? 'N/A' }}</td>
                                    <td class="py-3 text-gray-300">{{ $booking->pick_time_date?->format('Y.m.d') ?? 'N/A' }}</td>
                                    <td>
                                        <span class="px-2 py-1 rounded {{ $booking->test_filter_status == 'Active' ? 'bg-green-900 text-green-300' : ($booking->test_filter_status == 'Pending' ? 'bg-yellow-900 text-yellow-300' : 'bg-red-900 text-red-300') }}">
                                            {{ $booking->test_filter_status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 text-gray-400 text-center">No recent bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
@endsection

@section('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Booking Status Pie Chart
            const rentChartCtx = document.getElementById('rentChart').getContext('2d');
            const rentChart = new Chart(rentChartCtx, {
                type: 'pie',
                data: {
                    labels: ['Active', 'Completed', 'Booked'],
                    datasets: [{
                        data: [
                            {{ $stats['booking_statuses']['Active'] ?? 0 }},
                            {{ $stats['booking_statuses']['Completed'] ?? 0 }},
                            {{ $stats['booking_statuses']['Booked'] ?? 0 }}
                        ],
                        backgroundColor: ['#EF4444', '#1E3A8A', '#4B5563'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: '#F9FAFB' } }
                    }
                }
            });

            // Booking Trends Bar Chart
            const comboChartCtx = document.getElementById('comboChart').getContext('2d');
            const bookingTrends = @json($stats['booking_trends']);
            const comboChart = new Chart(comboChartCtx, {
                type: 'bar',
                data: {
                    labels: bookingTrends.slice(1).map(row => row[0]),
                    datasets: [
                        {
                            label: 'Active',
                            data: bookingTrends.slice(1).map(row => row[1]),
                            backgroundColor: '#1E3A8A'
                        },
                        {
                            label: 'Completed',
                            data: bookingTrends.slice(1).map(row => row[2]),
                            backgroundColor: '#EF4444'
                        },
                        {
                            label: 'Cancelled',
                            data: bookingTrends.slice(1).map(row => row[3]),
                            backgroundColor: '#4B5563'
                        },
                        {
                            label: 'Total',
                            type: 'line',
                            data: bookingTrends.slice(1).map(row => row[4]),
                            borderColor: '#FFA500',
                            borderWidth: 2,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#374151' }, ticks: { color: '#F9FAFB' } },
                        x: { grid: { display: false }, ticks: { color: '#F9FAFB' } }
                    },
                    plugins: {
                        legend: { labels: { color: '#F9FAFB' } }
                    }
                }
            });

            // Period Selectors
            $('#comboChartPeriod, #rentPeriod').on('change', function() {
                // Add logic to refresh charts with new data if needed
            });

            // Availability Form
            $('#availabilityForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('admin.check-availability') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Availability',
                            text: response.available ? 'Vehicle is available!' : 'Vehicle is not available.',
                            icon: response.available ? 'success' : 'warning',
                            background: '#1F2937',
                            color: '#F9FAFB',
                            confirmButtonColor: '#6366F1'
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to check availability.', 'error');
                    }
                });
            });

            // Profile Form
            $('#profileForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('profile.update') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Success', 'Profile updated successfully!', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON.message || 'Failed to update profile.', 'error');
                    }
                });
            });
        });
    </script>
@endsection
