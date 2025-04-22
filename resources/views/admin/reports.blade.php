@extends('layouts.admin-layout')

@section('title', 'Reports')

@section('styles')
    <style>
        .gradient-border { position: relative; border-radius: 0.75rem; }
        .gradient-border::before {
            content: ''; position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px;
            border-radius: 0.85rem; z-index: -1; opacity: 0.7; background: linear-gradient(135deg, #EA2F2F, #5E1313, #FF6B6B);
            transition: opacity 0.3s ease;
        }
        .gradient-border:hover::before { opacity: 1; }
        .hover-gradient:hover { background: linear-gradient(45deg, rgba(234, 47, 47, 0.2), rgba(94, 19, 19, 0.2)); }
        .stat-card { transition: transform 0.3s ease, box-shadow 0.3s ease; background: #1f2937; }
        .stat-card:hover { transform: translateY(-6px); box-shadow: 0 8px 20px rgba(234, 47, 47, 0.3); }
        .search-input { background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease; }
        .search-input:focus { background: rgba(255, 255, 255, 0.15); border-color: #EA2F2F; box-shadow: 0 0 0 3px rgba(234, 47, 47, 0.2); }
        .chart-container { max-width: 600px; margin: 0 auto; padding: 1rem; }
        .table-container { overflow-x: auto; scrollbar-width: thin; scrollbar-color: #EA2F2F #1a1a2e; }
        ::-webkit-scrollbar { width: 12px; background: #1a1a2e; }
        ::-webkit-scrollbar-thumb { background: #EA2F2F; border-radius: 6px; }
        ::-webkit-scrollbar-thumb:hover { background: #FF6B6B; }
        select { background: #1f2937; border: 1px solid rgba(255, 255, 255, 0.1); transition: border-color 0.3s ease; }
        select:focus { border-color: #EA2F2F; }
        .custom-input { height: 2.5rem; font-size: 0.9rem; }
        .btn-gradient { background: linear-gradient(90deg, #EA2F2F, #5E1313); transition: all 0.3s ease; }
        .btn-gradient:hover { background: linear-gradient(90deg, #FF6B6B, #EA2F2F); transform: scale(1.05); }
        .shadow-glow { box-shadow: 0 4px 15px rgba(234, 47, 47, 0.2); }
    </style>
@endsection

@section('content')
    <div class="min-h-screen py-8 px-6 sm:px-8 lg:px-12 bg-gray-900">
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-600 text-white rounded-lg shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-10 mt-16">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-6 lg:space-y-0">
                <h1 class="text-4xl font-extrabold text-white flex items-center">
                    <i class="fas fa-chart-line mr-4 text-[#EA2F2F] text-3xl"></i>
                    Reports Dashboard
                </h1>
                <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-6 w-full lg:w-auto">
                    <div class="flex rounded-lg overflow-hidden gradient-border shadow-glow">
                        <input type="date" id="startDate" name="startDate" class="search-input text-gray-200 px-4 py-2 focus:outline-none custom-input">
                        <input type="date" id="endDate" name="endDate" class="search-input text-gray-200 px-4 py-2 focus:outline-none custom-input">
                        <select id="reportType" class="search-input text-gray-200 px-4 py-2 focus:outline-none custom-input">
                            <option value="all">All Reports</option>
                            <option value="bookings">Bookings Only</option>
                            <option value="vehicles">Vehicles Only</option>
                            <option value="revenue">Revenue Only</option>
                        </select>
                        <button onclick="filterReports()" class="btn-gradient text-white px-6 py-2 flex items-center">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                    </div>
                    <div class="flex space-x-4">
                        <button onclick="exportToPdf()" class="btn-gradient text-white px-6 py-2 rounded-lg flex items-center justify-center w-full lg:w-auto shadow-glow">
                            <i class="fas fa-file-pdf mr-2"></i> Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-gray-800 p-6 rounded-lg gradient-border stat-card shadow-glow">
                <h3 class="text-lg font-semibold text-gray-300 flex items-center"><i class="fas fa-book mr-2 text-[#EA2F2F]"></i> Total Bookings</h3>
                <p class="text-3xl font-bold text-white mt-3">{{ $data['total_bookings'] }}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg gradient-border stat-card shadow-glow">
                <h3 class="text-lg font-semibold text-gray-300 flex items-center"><i class="fas fa-car mr-2 text-[#EA2F2F]"></i> Total Vehicles</h3>
                <p class="text-3xl font-bold text-white mt-3">{{ $data['total_vehicles'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Available: {{ $data['available_vehicles'] }}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg gradient-border stat-card shadow-glow">
                <h3 class="text-lg font-semibold text-gray-300 flex items-center"><i class="fas fa-user-tie mr-2 text-[#EA2F2F]"></i> Total Drivers</h3>
                <p class="text-3xl font-bold text-white mt-3">{{ $data['total_drivers'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Available: {{ $data['available_drivers'] }}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg gradient-border stat-card shadow-glow">
                <h3 class="text-lg font-semibold text-gray-300 flex items-center"><i class="fas fa-users mr-2 text-[#EA2F2F]"></i> Total Customers</h3>
                <p class="text-3xl font-bold text-white mt-3">{{ $data['total_customers'] }}</p>
            </div>
        </div>

        <!-- Charts and Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Booking Statuses -->
            <div class="bg-gray-800 p-6 rounded-lg gradient-border shadow-glow">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center"><i class="fas fa-chart-bar mr-3 text-[#EA2F2F]"></i> Booking Statuses</h2>
                <div class="table-container mb-6">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Count</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($data['booking_statuses'] as $status => $count)
                                <tr class="hover-gradient transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-200">{{ $status }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-200">{{ $count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="chart-container">
                    <canvas id="bookingStatusChart"></canvas>
                </div>
            </div>

            <!-- Vehicle Categories -->
            <div class="bg-gray-800 p-6 rounded-lg gradient-border shadow-glow">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center"><i class="fas fa-car-side mr-3 text-[#EA2F2F]"></i> Vehicle Categories</h2>
                <div class="table-container mb-6">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Count</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($data['vehicle_categories'] as $category => $count)
                                <tr class="hover-gradient transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-200">{{ $category }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-200">{{ $count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="chart-container">
                    <canvas id="vehicleCategoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Insights -->
        <div class="bg-gray-800 p-6 rounded-lg gradient-border shadow-glow">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center"><i class="fas fa-lightbulb mr-3 text-[#EA2F2F]"></i> Additional Insights</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-semibold text-gray-200 mb-4 flex items-center"><i class="fas fa-star mr-2 text-[#EA2F2F]"></i> Top Vehicles by Bookings</h3>
                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Vehicle Model</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Bookings</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($data['top_vehicles'] as $model => $count)
                                    <tr class="hover-gradient transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm text-gray-200">{{ $model }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-200">{{ $count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-200 mb-4 flex items-center"><i class="fas fa-dollar-sign mr-2 text-[#EA2F2F]"></i> Revenue Overview</h3>
                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Revenue (LKR)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($data['revenue_by_category'] as $category => $revenue)
                                    <tr class="hover-gradient transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm text-gray-200">{{ $category }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-200">{{ number_format($revenue, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const darkSwal = Swal.mixin({
            background: '#1f2937',
            color: '#fff',
            confirmButtonColor: '#EA2F2F',
            cancelButtonColor: '#5E1313',
            customClass: {
                popup: 'gradient-border shadow-glow',
                title: 'text-white font-bold',
                content: 'text-gray-200',
                confirmButton: 'btn-gradient text-white px-4 py-2 rounded-lg',
                cancelButton: 'btn-gradient text-white px-4 py-2 rounded-lg'
            }
        });

        $(document).ready(function () {
            const bookingStatuses = @json($data['booking_statuses']);
            const vehicleCategories = @json($data['vehicle_categories']);

            // Booking Status Bar Chart
            const bookingStatusCtx = document.getElementById('bookingStatusChart').getContext('2d');
            new Chart(bookingStatusCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(bookingStatuses),
                    datasets: [{
                        label: 'Bookings',
                        data: Object.values(bookingStatuses),
                        backgroundColor: ['#EA2F2F', '#FF6B6B', '#5E1313', '#A52A2A'],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.1)' } },
                        x: { grid: { display: false } }
                    },
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Booking Distribution', color: '#fff', font: { size: 16 } }
                    }
                }
            });

            // Vehicle Category Pie Chart
            const vehicleCategoryCtx = document.getElementById('vehicleCategoryChart').getContext('2d');
            new Chart(vehicleCategoryCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(vehicleCategories),
                    datasets: [{
                        data: Object.values(vehicleCategories),
                        backgroundColor: ['#EA2F2F', '#5E1313', '#FF6B6B', '#A52A2A', '#FFD700', '#4CAF50'],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top', labels: { color: '#fff', font: { size: 14 } } },
                        title: { display: true, text: 'Vehicle Categories', color: '#fff', font: { size: 16 } }
                    }
                }
            });
        });

        function filterReports() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const reportType = document.getElementById('reportType').value;

            if (!startDate || !endDate) {
                darkSwal.fire({
                    title: 'Warning',
                    text: 'Please select both start and end dates.',
                    icon: 'warning'
                });
                return;
            }

            fetch(`/admin/reports?start_date=${startDate}&end_date=${endDate}&report_type=${reportType}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Failed to fetch filtered reports');
                }
                darkSwal.fire({
                    title: 'Filter Applied',
                    text: 'Reports updated successfully.',
                    icon: 'success'
                }).then(() => window.location.reload());
            })
            .catch(error => {
                console.error('Filter error:', error);
                darkSwal.fire({
                    title: 'Error',
                    text: 'Failed to filter reports: ' + error.message,
                    icon: 'error'
                });
            });
        }

        function exportToPdf() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const reportType = document.getElementById('reportType').value;

            darkSwal.fire({
                title: 'Exporting PDF...',
                text: 'Please wait while your report is being generated.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/reports/export-pdf?start_date=${startDate}&end_date=${endDate}&report_type=${reportType}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to generate PDF');
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `report_${reportType}_${new Date().toISOString().slice(0,10)}.pdf`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                darkSwal.fire({
                    title: 'Success',
                    text: 'PDF report downloaded successfully!',
                    icon: 'success'
                });
            })
            .catch(error => {
                console.error('PDF export error:', error);
                darkSwal.fire({
                    title: 'Error',
                    text: 'Failed to export PDF: ' + error.message,
                    icon: 'error'
                });
            });
        }

        function exportToExcel() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const reportType = document.getElementById('reportType').value;

            darkSwal.fire({
                title: 'Exporting Excel...',
                text: 'Please wait while your report is being generated.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/reports/export-excel?start_date=${startDate}&end_date=${endDate}&report_type=${reportType}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to generate Excel');
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `report_${reportType}_${new Date().toISOString().slice(0,10)}.xlsx`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                darkSwal.fire({
                    title: 'Success',
                    text: 'Excel report downloaded successfully!',
                    icon: 'success'
                });
            })
            .catch(error => {
                console.error('Excel export error:', error);
                darkSwal.fire({
                    title: 'Error',
                    text: 'Failed to export Excel: ' + error.message,
                    icon: 'error'
                });
            });
        }
    </script>
@endsection
