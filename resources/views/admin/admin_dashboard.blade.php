@extends('admin.admin_logged.app')

@section('head')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('content')
<!-- Loading Overlay -->
<div id="loader" class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-80 backdrop-blur-sm transition-all duration-300 hidden">
    <div class="relative">
        <div class="w-24 h-24">
            <div class="absolute inset-0 border-4 border-indigo-100 rounded-full animate-pulse"></div>
            <div class="absolute inset-0 border-t-4 border-indigo-500 rounded-full animate-spin"></div>
        </div>
        <div class="mt-4 text-center text-indigo-600 font-medium">Loading...</div>
    </div>
</div>

<div class="container-fluid animate-fadeIn">
    <!-- Welcome Section with enhanced styling -->
    <div class="mb-8 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primary-100 to-primary-200 rounded-bl-full opacity-70"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center">
                <span class="bg-gradient-to-r from-indigo-500 to-blue-500 text-transparent bg-clip-text">
                    Welcome back, {{ Auth::user()->name }}!
                </span>
            </h1>
            <p class="text-gray-600 mt-2">Here's what's happening with your dental practice today.</p>

            <div class="mt-4 flex flex-wrap gap-4">
                <button class="btn btn-sm btn-primary" onclick="showLoader(); setTimeout(() => { hideLoader(); showAlert('Report Generated', 'Your daily report has been generated successfully!'); }, 1500);">
                    <i class="fas fa-file-alt"></i> Generate Report
                </button>
                <button class="btn btn-sm btn-outline-primary" onclick="showToast('Quick View', 'Showing today\'s appointments', 'info')">
                    <i class="fas fa-calendar-day"></i> Today's Schedule
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Patients -->
        <div class="stats-card bg-gradient-to-r from-blue-500 to-blue-600 animate-float" style="animation-delay: 0s;">
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
        <div class="stats-card bg-gradient-to-r from-violet-500 to-violet-600 animate-float" style="animation-delay: 0.2s;">
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
        <div class="stats-card bg-gradient-to-r from-emerald-500 to-emerald-600 animate-float" style="animation-delay: 0.4s;">
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
        <div class="stats-card bg-gradient-to-r from-amber-500 to-amber-600 animate-float" style="animation-delay: 0.6s;">
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
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Revenue Chart -->
        <div class="card animate-fadeIn" style="animation-delay: 0.3s;">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-chart-line text-primary mr-2"></i>
                    Revenue Overview
                </h5>
            </div>
            <div class="card-body p-4">
                <div id="revenueChart" style="height: 300px;"></div>
            </div>
        </div>

        <!-- Treatments Chart -->
        <div class="card animate-fadeIn" style="animation-delay: 0.5s;">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-tooth text-primary mr-2"></i>
                    Treatment Distribution
                </h5>
            </div>
            <div class="card-body p-4">
                <div id="treatmentsChart" style="height: 300px;"></div>
            </div>
        </div>

        <!-- Appointments Chart -->
        <div class="card animate-fadeIn" style="animation-delay: 0.7s;">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-calendar-check text-primary mr-2"></i>
                    Appointment Status
                </h5>
            </div>
            <div class="card-body p-4">
                <div id="appointmentsChart" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Appointments -->
        <div class="card animate-fadeIn" style="animation-delay: 0.7s;">
            <div class="card-header flex items-center justify-between">
                <h5 class="card-title">
                    <i class="fas fa-calendar-alt text-primary mr-2"></i>
                    Recent Appointments
                </h5>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-external-link-alt mr-1"></i>
                    View All
                </a>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentAppointments) && count($recentAppointments))
                                @foreach($recentAppointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm rounded-circle bg-primary-100 text-primary mr-3">
                                                <span>{{ substr($appointment->patient->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 font-medium">{{ $appointment->patient->name ?? 'Unknown' }}</h6>
                                                <small class="text-muted">{{ $appointment->patient->mobileNumber ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_date ?? now())->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_time ?? now())->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = 'bg-success';
                                            $status = 'Confirmed';

                                            if(isset($appointment->status)) {
                                                if($appointment->status == 'pending') {
                                                    $statusClass = 'bg-warning';
                                                    $status = 'Pending';
                                                } elseif($appointment->status == 'cancelled') {
                                                    $statusClass = 'bg-danger';
                                                    $status = 'Cancelled';
                                                }
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }} text-white">{{ $status }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="showToast('Appointment Details', 'Viewing details for {{ $appointment->patient->name ?? 'patient' }}', 'info')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="py-6">
                                            <i class="fas fa-calendar-times text-gray-400 text-4xl mb-3"></i>
                                            <p class="text-gray-500">No recent appointments</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="card animate-fadeIn" style="animation-delay: 0.9s;">
            <div class="card-header flex items-center justify-between">
                <h5 class="card-title">
                    <i class="fas fa-file-invoice-dollar text-primary mr-2"></i>
                    Recent Invoices
                </h5>
                <a href="{{ route('admin.invoice.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-external-link-alt mr-1"></i>
                    View All
                </a>
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
                                    <td>
                                        <div class="font-medium">#{{ $invoice->id }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($invoice->created_at ?? now())->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm rounded-circle bg-primary-100 text-primary mr-3">
                                                <span>{{ substr($invoice->patient->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <span>{{ $invoice->patient->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-medium">₹{{ number_format($invoice->totalAmount ?? 0, 2) }}</div>
                                        <small class="text-muted">Balance: ₹{{ number_format(($invoice->totalAmount ?? 0) - ($invoice->advanceAmount ?? 0), 2) }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $isPaid = isset($invoice->totalAmount) && isset($invoice->advanceAmount) && $invoice->totalAmount == $invoice->advanceAmount;
                                            $statusClass = $isPaid ? 'bg-success' : 'bg-warning';
                                            $status = $isPaid ? 'Paid' : 'Partial';
                                        @endphp
                                        <span class="badge {{ $statusClass }} text-white">{{ $status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="py-6">
                                            <i class="fas fa-file-invoice text-gray-400 text-4xl mb-3"></i>
                                            <p class="text-gray-500">No recent invoices</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="card mt-6 animate-fadeIn" style="animation-delay: 1.1s;">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-bolt text-primary mr-2"></i>
                Quick Actions
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-primary-50 rounded-xl border border-primary-100 hover:bg-primary-100 transition-all cursor-pointer" onclick="showLoader(); setTimeout(() => { hideLoader(); showAlert('New Patient', 'Patient registration form is ready!'); }, 800);">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center mr-4">
                            <i class="fas fa-user-plus text-xl"></i>
                        </div>
                        <div>
                            <h6 class="font-medium text-gray-800">New Patient</h6>
                            <p class="text-sm text-gray-600">Register a patient</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-secondary-50 rounded-xl border border-secondary-100 hover:bg-secondary-100 transition-all cursor-pointer" onclick="showLoader(); setTimeout(() => { hideLoader(); showAlert('New Appointment', 'Appointment booking form is ready!'); }, 800);">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-secondary-500 text-white flex items-center justify-center mr-4">
                            <i class="fas fa-calendar-plus text-xl"></i>
                        </div>
                        <div>
                            <h6 class="font-medium text-gray-800">New Appointment</h6>
                            <p class="text-sm text-gray-600">Schedule appointment</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-success-50 rounded-xl border border-success-100 hover:bg-success-100 transition-all cursor-pointer" onclick="showLoader(); setTimeout(() => { hideLoader(); showAlert('New Invoice', 'Invoice creation form is ready!'); }, 800);">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-success text-white flex items-center justify-center mr-4">
                            <i class="fas fa-file-invoice text-xl"></i>
                        </div>
                        <div>
                            <h6 class="font-medium text-gray-800">New Invoice</h6>
                            <p class="text-sm text-gray-600">Create invoice</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-warning-50 rounded-xl border border-warning-100 hover:bg-warning-100 transition-all cursor-pointer" onclick="showConfirm('Generate Report', 'Do you want to generate a monthly report?').then((result) => { if(result.isConfirmed) { showLoader(); setTimeout(() => { hideLoader(); showAlert('Report Generated', 'Your monthly report has been generated!'); }, 1500); } });">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-warning text-white flex items-center justify-center mr-4">
                            <i class="fas fa-chart-pie text-xl"></i>
                        </div>
                        <div>
                            <h6 class="font-medium text-gray-800">Reports</h6>
                            <p class="text-sm text-gray-600">Generate reports</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Modern Design System */
    :root {
        --primary: #0ea5e9;
        --primary-light: #38bdf8;
        --primary-dark: #0284c7;
        --primary-50: #f0f9ff;
        --primary-100: #e0f2fe;
        --secondary: #6366f1;
        --secondary-light: #818cf8;
        --secondary-dark: #4f46e5;
        --secondary-50: #eef2ff;
        --secondary-100: #e0e7ff;
        --success: #10b981;
        --success-light: #34d399;
        --success-50: #ecfdf5;
        --success-100: #d1fae5;
        --warning: #f59e0b;
        --warning-light: #fbbf24;
        --warning-50: #fffbeb;
        --warning-100: #fef3c7;
        --danger: #ef4444;
        --danger-light: #f87171;
        --danger-50: #fef2f2;
        --danger-100: #fee2e2;
    }

    /* Enhanced Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    /* Modern Card Styling */
    .stats-card {
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E") center center;
        opacity: 0.2;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                   0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
    }

    /* Enhanced Chart Cards */
    .chart-card {
        background-color: white;
        border-radius: 1rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .chart-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    /* Modern Table Design */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .modern-table td {
        padding: 1rem 1.5rem;
        color: #475569;
        border-bottom: 1px solid #f1f5f9;
    }

    .modern-table tr:hover td {
        background-color: #f8fafc;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }

    .status-badge.success {
        background-color: #d1fae5;
        color: #047857;
    }

    .status-badge.warning {
        background-color: #fef3c7;
        color: #b45309;
    }

    /* Progress Animation */
    @keyframes progress {
        0% { stroke-dasharray: 0 100; }
    }

    .progress-ring circle {
        animation: progress 1s ease-out forwards;
    }

    .card-body {
        position: relative;
        width: 100%;
    }

    #revenueChart, #treatmentsChart, #appointmentsChart {
        width: 100%;
        min-height: 300px;
    }
    </style>
</div>

@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show loader initially
        showLoader();

        // Hide loader after content is ready
        setTimeout(() => {
            hideLoader();
        }, 800);

        // Revenue Chart
        var revenueCtx = document.getElementById('revenueChart').getContext('2d');

        // Weekly data (default)
        const weeklyData = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Revenue',
                data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                borderColor: '#0ea5e9',
                borderWidth: 2,
                pointBackgroundColor: '#0ea5e9',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4
            }]
        };

        // Monthly data
        const monthlyData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue',
                data: [150000, 180000, 210000, 190000, 220000, 250000, 240000, 260000, 270000, 290000, 310000, 330000],
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderColor: '#6366f1',
                borderWidth: 2,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4
            }]
        };

        // Yearly data
        const yearlyData = {
            labels: ['2018', '2019', '2020', '2021', '2022', '2023'],
            datasets: [{
                label: 'Revenue',
                data: [1200000, 1500000, 1800000, 1600000, 2200000, 2800000],
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderColor: '#10b981',
                borderWidth: 2,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4
            }]
        };

        var revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: weeklyData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            },
                            font: {
                                family: "'Poppins', sans-serif",
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
                                family: "'Poppins', sans-serif",
                                size: 12
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1e293b',
                        bodyColor: '#475569',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return '₹' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
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
                        '#0ea5e9',
                        '#6366f1',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1e293b',
                        bodyColor: '#475569',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true
                    }
                },
                cutout: '70%',
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });

        // Chart period buttons
        document.getElementById('weekBtn').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('monthBtn').classList.remove('active');
            document.getElementById('yearBtn').classList.remove('active');

            revenueChart.data = weeklyData;
            revenueChart.update();
            showToast('Chart Updated', 'Showing weekly revenue data', 'info');
        });

        document.getElementById('monthBtn').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('weekBtn').classList.remove('active');
            document.getElementById('yearBtn').classList.remove('active');

            revenueChart.data = monthlyData;
            revenueChart.update();
            showToast('Chart Updated', 'Showing monthly revenue data', 'info');
        });

        document.getElementById('yearBtn').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('weekBtn').classList.remove('active');
            document.getElementById('monthBtn').classList.remove('active');

            revenueChart.data = yearlyData;
            revenueChart.update();
            showToast('Chart Updated', 'Showing yearly revenue data', 'info');
        });
    });
</script>

<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(initCharts);

    function initCharts() {
        fetchAndDrawRevenueChart();
        fetchAndDrawTreatmentsChart();
        fetchAndDrawAppointmentsChart();
    }

    function fetchAndDrawRevenueChart() {
        fetch('{{ route("admin.chart.revenue") }}')
            .then(response => response.json())
            .then(chartData => {
                const data = google.visualization.arrayToDataTable(chartData);
                const options = {
                    title: 'Revenue Trend',
                    curveType: 'function',
                    legend: { position: 'bottom' },
                    colors: ['#0ea5e9'],
                    backgroundColor: 'transparent',
                };
                const chart = new google.visualization.LineChart(document.getElementById('revenueChart'));
                chart.draw(data, options);
            });
    }

    function fetchAndDrawTreatmentsChart() {
        fetch('{{ route("admin.chart.treatments") }}')
            .then(response => response.json())
            .then(chartData => {
                const data = google.visualization.arrayToDataTable(chartData);
                const options = {
                    title: 'Treatment Distribution',
                    pieHole: 0.4,
                    colors: ['#0ea5e9', '#6366f1', '#10b981', '#f59e0b', '#ef4444'],
                    backgroundColor: 'transparent',
                };
                const chart = new google.visualization.PieChart(document.getElementById('treatmentsChart'));
                chart.draw(data, options);
            });
    }

    function fetchAndDrawAppointmentsChart() {
        fetch('{{ route("admin.chart.appointments") }}')
            .then(response => response.json())
            .then(chartData => {
                const data = google.visualization.arrayToDataTable(chartData);
                const options = {
                    title: 'Appointment Status Distribution',
                    pieHole: 0.4,
                    colors: ['#10b981', '#f59e0b', '#ef4444'],
                    backgroundColor: 'transparent',
                };
                const chart = new google.visualization.PieChart(document.getElementById('appointmentsChart'));
                chart.draw(data, options);
            });
    }

    // Redraw charts on window resize
    window.addEventListener('resize', function() {
        initCharts();
    });
</script>
@endsection
