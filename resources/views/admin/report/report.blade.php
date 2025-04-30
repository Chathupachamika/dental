@extends('admin.admin_logged.app')

@section('content')
<div class="container-fluid p-6 animate-fadeIn">
    <!-- Loading Overlay -->
    <div id="loader" class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-80 backdrop-blur-sm transition-all duration-300 hidden">
        <div class="relative">
            <div class="h-24 w-24">
                <div class="absolute inset-0 rounded-full border-4 border-indigo-100 animate-pulse"></div>
                <div class="absolute inset-0 rounded-full border-t-4 border-sky-500 animate-spin"></div>
            </div>
            <div class="mt-4 text-center text-sky-600 font-medium">Loading...</div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-wrap items-center justify-between">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-900">Clinic Reports & Analytics</h1>
                <span class="ml-4 px-3 py-1 text-sm bg-sky-100 text-sky-800 rounded-full">
                    {{ now()->format('F Y') }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <select id="reportType" class="form-select pl-10 pr-10 py-2" onchange="loadReport(this.value)">
                        <option value="daily">Daily Report</option>
                        <option value="weekly">Weekly Report</option>
                        <option value="monthly">Monthly Report</option>
                        <option value="yearly">Yearly Report</option>
                    </select>
                    <i class="fas fa-file-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button onclick="exportReport()" class="btn btn-outline-primary">
                    <i class="fas fa-download mr-2"></i> Export
                </button>
                <button onclick="printReport()" class="btn btn-outline-secondary">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Patients -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex justify-between items-center mb-4">
                <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-sky-600 text-xl"></i>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-sm text-gray-600">Total Patients</p>
                    <h4 class="text-2xl font-bold">{{ number_format($totalPatients) }}</h4>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-green-500 text-sm">↑ 12.5%</span>
                    <span class="text-gray-500 text-sm">vs last month</span>
                </div>
                <button onclick="showDetails('patients')" class="text-sky-600 hover:text-sky-700">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Total Appointments -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex justify-between items-center mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-sm text-gray-600">Total Appointments</p>
                    <h4 class="text-2xl font-bold">{{ number_format($totalAppointments) }}</h4>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-green-500 text-sm">↑ 8.2%</span>
                    <span class="text-gray-500 text-sm">vs last month</span>
                </div>
                <button onclick="showDetails('appointments')" class="text-purple-600 hover:text-purple-700">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex justify-between items-center mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-emerald-600 text-xl"></i>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-sm text-gray-600">Total Revenue</p>
                    <h4 class="text-2xl font-bold">₹{{ number_format($totalRevenue) }}</h4>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-green-500 text-sm">↑ 15.3%</span>
                    <span class="text-gray-500 text-sm">vs last month</span>
                </div>
                <button onclick="showDetails('revenue')" class="text-emerald-600 hover:text-emerald-700">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Outstanding Amount -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex justify-between items-center mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-amber-600 text-xl"></i>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-sm text-gray-600">Outstanding Amount</p>
                    <h4 class="text-2xl font-bold">₹{{ number_format($outstandingAmount) }}</h4>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-red-500 text-sm">↓ 5.1%</span>
                    <span class="text-gray-500 text-sm">vs last month</span>
                </div>
                <button onclick="showDetails('outstanding')" class="text-amber-600 hover:text-amber-700">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">Revenue Analysis</h3>
                <div class="flex gap-2">
                    <button class="btn btn-xs btn-outline-primary active" onclick="updateRevenueChart('weekly')">Week</button>
                    <button class="btn btn-xs btn-outline-primary" onclick="updateRevenueChart('monthly')">Month</button>
                    <button class="btn btn-xs btn-outline-primary" onclick="updateRevenueChart('yearly')">Year</button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Treatment Distribution -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">Treatment Distribution</h3>
                <button class="text-sky-600 hover:text-sky-700 text-sm" onclick="refreshTreatmentData()">
                    <i class="fas fa-sync-alt mr-1"></i> Refresh
                </button>
            </div>
            <div class="h-80">
                <canvas id="treatmentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold">Recent Transactions</h3>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Search transactions..." class="form-input pl-10 pr-4 py-2">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button class="btn btn-primary" onclick="viewAllTransactions()">View All</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Invoice ID
                        </th>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Patient
                        </th>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Treatment
                        </th>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentTransactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">
                                #{{ $transaction->invoice_id }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-sky-100 flex items-center justify-center">
                                    <span class="text-sky-600 font-medium">
                                        {{ substr($transaction->patient_name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $transaction->patient_name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $transaction->patient_phone }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-900">
                                {{ $transaction->treatment_name }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">
                                ₹{{ number_format($transaction->amount, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($transaction->status === 'paid')
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                Paid
                            </span>
                            @elseif($transaction->status === 'pending')
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                Pending
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                Overdue
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-500">
                                {{ $transaction->date->format('M d, Y') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    showToast('Report Loaded', 'Report data has been loaded successfully', 'success');
});

function initializeCharts() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    window.revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenueData->labels),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueData->values),
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    });

    // Treatment Distribution Chart
    const treatmentCtx = document.getElementById('treatmentChart').getContext('2d');
    window.treatmentChart = new Chart(treatmentCtx, {
        type: 'doughnut',
        data: {
            labels: @json($treatmentData->labels),
            datasets: [{
                data: @json($treatmentData->values),
                backgroundColor: [
                    '#0ea5e9',
                    '#6366f1',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            },
            cutout: '60%'
        }
    });
}

// Export report function
function exportReport() {
    showLoader();
    // Simulate export process
    setTimeout(() => {
        hideLoader();
        showAlert('Success', 'Report has been exported successfully!', 'success');
    }, 1500);
}

// Print report function
function printReport() {
    showLoader();
    setTimeout(() => {
        hideLoader();
        window.print();
    }, 800);
}

// Show details function
function showDetails(type) {
    showLoader();
    // Simulate loading detailed data
    setTimeout(() => {
        hideLoader();
        showModal(`${type.charAt(0).toUpperCase() + type.slice(1)} Details`, 'Detailed information will be shown here.');
    }, 800);
}

// Update revenue chart based on period
function updateRevenueChart(period) {
    showLoader();
    // In a real app, you would fetch new data from the server here
    fetch(`/api/revenue-data?period=${period}`)
        .then(response => response.json())
        .then(data => {
            window.revenueChart.data = data;
            window.revenueChart.update();
            hideLoader();
            showToast('Chart Updated', `Showing ${period} revenue data`, 'success');
        })
        .catch(error => {
            hideLoader();
            showToast('Error', 'Failed to update chart', 'error');
        });
}

// Refresh treatment data
function refreshTreatmentData() {
    showLoader();
    // In a real app, you would fetch new data from the server here
    fetch('/api/treatment-data')
        .then(response => response.json())
        .then(data => {
            window.treatmentChart.data = data;
            window.treatmentChart.update();
            hideLoader();
            showToast('Data Refreshed', 'Treatment data has been updated', 'success');
        })
        .catch(error => {
            hideLoader();
            showToast('Error', 'Failed to refresh data', 'error');
        });
}

// View all transactions
function viewAllTransactions() {
    window.location.href = "{{ route('admin.transactions.index') }}";
}
</script>
@endsection
