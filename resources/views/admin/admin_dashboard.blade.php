@extends('admin.admin_logged.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600">Here's what's happening with your dental practice today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Patients -->
        <div class="stats-card bg-gradient-to-r from-blue-500 to-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Total Patients</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalPatients ?? 0) }}</h3>
                    <p class="text-blue-100 text-sm mt-2">
                        <span class="text-emerald-300">↑ 3.48%</span> vs last month
                    </p>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="stats-card bg-gradient-to-r from-violet-500 to-violet-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-violet-100 text-sm mb-1">Today's Appointments</p>
                    <h3 class="text-2xl font-bold">{{ $todayAppointments ?? 0 }}</h3>
                    <p class="text-violet-100 text-sm mt-2">
                        <span class="text-emerald-300">↑ 5.28%</span> vs last week
                    </p>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="stats-card bg-gradient-to-r from-emerald-500 to-emerald-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm mb-1">Monthly Revenue</p>
                    <h3 class="text-2xl font-bold">₹{{ number_format($monthlyRevenue ?? 0) }}</h3>
                    <p class="text-emerald-100 text-sm mt-2">
                        <span class="text-emerald-300">↑ 12.65%</span> vs last month
                    </p>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="stats-card bg-gradient-to-r from-amber-500 to-amber-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm mb-1">Pending Payments</p>
                    <h3 class="text-2xl font-bold">₹{{ number_format($pendingPayments ?? 0) }}</h3>
                    <p class="text-amber-100 text-sm mt-2">
                        <span class="text-red-300">↓ 2.35%</span> vs yesterday
                    </p>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-file-invoice text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Revenue Chart -->
        <div class="card lg:col-span-2">
            <div class="card-header flex items-center justify-between">
                <h5 class="card-title">Revenue Overview</h5>
                <div class="flex gap-2">
                    <button class="btn btn-sm btn-outline-primary active">Week</button>
                    <button class="btn btn-sm btn-outline-primary">Month</button>
                    <button class="btn btn-sm btn-outline-primary">Year</button>
                </div>
            </div>
            <div class="card-body p-4">
                <canvas id="revenueChart" height="300"></canvas>
            </div>
        </div>

        <!-- Top Treatments -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Top Treatments</h5>
            </div>
            <div class="card-body p-4">
                <canvas id="treatmentsChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Appointments -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h5 class="card-title">Recent Appointments</h5>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentAppointments) && count($recentAppointments))
                                    @foreach($recentAppointments as $appointment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm rounded-circle bg-gray-200 mr-3">
                                                    <span class="text-gray-700">{{ substr($appointment->patient->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $appointment->patient->name }}</h6>
                                                    <small class="text-muted">{{ $appointment->patient->mobileNumber }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $appointment->visitDate }}</td>
                                        <td>
                                            <span class="badge bg-success text-white">Confirmed</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center py-4">No recent appointments</td>
                                    </tr>
                                @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h5 class="card-title">Recent Invoices</h5>
                <a href="{{ route('admin.invoice.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Patient</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentInvoices) && count($recentInvoices))
                                    @foreach($recentInvoices as $invoice)
                                    <tr>
                                        <td>#{{ $invoice->id }}</td>
                                        <td>{{ $invoice->patient->name }}</td>
                                        <td>₹{{ number_format($invoice->totalAmount, 2) }}</td>
                                        <td>
                                            @if($invoice->totalAmount == $invoice->advanceAmount)
                                                <span class="badge bg-success text-white">Paid</span>
                                            @else
                                                <span class="badge bg-warning text-white">Partial</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No recent invoices</td>
                                    </tr>
                                @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        var revenueCtx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderColor: '#2563eb',
                    borderWidth: 2,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '₹' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Treatments Chart
        var treatmentsCtx = document.getElementById('treatmentsChart').getContext('2d');
        var treatmentsChart = new Chart(treatmentsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Root Canal', 'Cleaning', 'Extraction', 'Filling', 'Braces'],
                datasets: [{
                    data: [30, 25, 15, 20, 10],
                    backgroundColor: [
                        '#2563eb',
                        '#0ea5e9',
                        '#06b6d4',
                        '#10b981',
                        '#f59e0b'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });

        // Update chart configurations with modern styling
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 12
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 12
                        }
                    }
                }
            }
        };

        // Apply updated options to charts
        revenueChart.options = {...revenueChart.options, ...chartOptions};
        treatmentsChart.options = {...treatmentsChart.options, ...chartOptions};
    });
</script>
@endsection

