@extends('admin.admin_logged.app')

@section('head')
    <!-- Material Design Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- ApexCharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])
@endsection

@section('content')
<div class="animate-fadeIn">
    <!-- Welcome Section -->
    <div class="relative mb-8 overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-xl">
        <div class="absolute top-0 right-0 hidden w-96 h-96 opacity-20 lg:block">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#FFFFFF" d="M42.8,-65.2C54.9,-56.7,63.6,-43.2,69.1,-28.8C74.6,-14.4,76.9,0.9,73.3,15.1C69.7,29.3,60.2,42.3,48.3,52.2C36.5,62.1,22.4,68.9,6.2,72.5C-10,76.1,-28.3,76.5,-41.2,68.5C-54.1,60.5,-61.6,44.1,-68.2,27.6C-74.8,11.1,-80.5,-5.7,-77.3,-20.8C-74.1,-35.9,-62,-49.4,-47.9,-57.4C-33.8,-65.4,-17.7,-68,-1.6,-65.7C14.6,-63.4,30.7,-73.7,42.8,-65.2Z" transform="translate(100 100)" />
            </svg>
        </div>
        <div class="relative p-8 z-10">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl font-bold text-white">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="mt-2 text-blue-100">Here's what's happening with your dental practice today.</p>
                </div>
                <div class="flex space-x-3">
                    <button class="px-4 py-2 text-sm font-medium text-white bg-white/20 rounded-lg hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all flex items-center">
                        <i class="fas fa-calendar-day mr-2"></i>
                        Today: {{ now()->format('d M, Y') }}
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-indigo-700 bg-white rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all flex items-center" onclick="generateDailyReport()">
                        <i class="fas fa-file-alt mr-2"></i>
                        Generate Report
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                <div class="p-4 bg-white/10 backdrop-blur-sm rounded-xl">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white/20 mr-4">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-blue-100">Total Patients</p>
                            <h3 class="text-2xl font-bold text-white" id="totalPatientsCount">...</h3>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-blue-100" id="patientsChange">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Loading...
                    </div>
                </div>

                <div class="p-4 bg-white/10 backdrop-blur-sm rounded-xl">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white/20 mr-4">
                            <i class="fas fa-calendar-check text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-blue-100">Today's Appointments</p>
                            <h3 class="text-2xl font-bold text-white" id="appointmentsCount">...</h3>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-blue-100" id="appointmentsChange">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Loading...
                    </div>
                </div>

                <div class="p-4 bg-white/10 backdrop-blur-sm rounded-xl">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white/20 mr-4">
                            <i class="fas fa-rupee-sign text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-blue-100">Monthly Revenue</p>
                            <h3 class="text-2xl font-bold text-white" id="monthlyRevenue">...</h3>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-blue-100" id="revenueChange">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Loading...
                    </div>
                </div>

                <div class="p-4 bg-white/10 backdrop-blur-sm rounded-xl">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white/20 mr-4">
                            <i class="fas fa-file-invoice text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-blue-100">Pending Payments</p>
                            <h3 class="text-2xl font-bold text-white" id="pendingPayments">...</h3>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-blue-100" id="paymentsChange">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Loading...
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Helper function for error handling
                    function handleFetchError(elementId, error) {
                        console.error(`Error fetching data for ${elementId}:`, error);
                        document.getElementById(elementId).textContent = 'Error';
                        document.getElementById(elementId + 'Change').innerHTML = `
                            <span class="text-red-300">
                                <i class="fas fa-exclamation-circle mr-1"></i>Failed to load
                            </span>
                            <button onclick="location.reload()" class="ml-2 text-blue-300 hover:text-blue-200">
                                <i class="fas fa-redo-alt"></i>
                            </button>
                        `;
                    }

                    // Fetch total patients with error handling
                    fetch('/admin/api/patients/total')
                        .then(res => {
                            if (!res.ok) throw new Error('Network response was not ok');
                            return res.json();
                        })
                        .then(data => {
                            document.getElementById('totalPatientsCount').textContent = data.total.toLocaleString();
                            const changeEl = document.getElementById('patientsChange');
                            const isPositive = data.percentageChange >= 0;
                            changeEl.innerHTML = `
                                <span class="${isPositive ? 'text-green-300' : 'text-red-300'}">
                                    <i class="fas fa-arrow-${isPositive ? 'up' : 'down'} mr-1"></i>${Math.abs(data.percentageChange)}%
                                </span> vs last month
                            `;
                        })
                        .catch(error => handleFetchError('totalPatientsCount', error));

                    // Fetch appointments count with error handling
                    fetch('/admin/api/appointments/today/count')
                        .then(res => {
                            if (!res.ok) throw new Error('Network response was not ok');
                            return res.json();
                        })
                        .then(data => {
                            document.getElementById('appointmentsCount').textContent = data.count;
                            const changeEl = document.getElementById('appointmentsChange');
                            const isPositive = data.percentageChange >= 0;
                            changeEl.innerHTML = `
                                <span class="${isPositive ? 'text-green-300' : 'text-red-300'}">
                                    <i class="fas fa-arrow-${isPositive ? 'up' : 'down'} mr-1"></i>${Math.abs(data.percentageChange)}%
                                </span> vs yesterday
                            `;
                        })
                        .catch(error => handleFetchError('appointmentsCount', error));

                    // Fetch monthly revenue with error handling
                    fetch('/admin/revenue/monthly')
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('monthlyRevenue').textContent = 'Rs.' + data.amount.toLocaleString();
                            const revenueChangeEl = document.getElementById('revenueChange');
                            const isPositive = data.percentageChange >= 0;
                            revenueChangeEl.innerHTML = `
                                <span class="${isPositive ? 'text-green-300' : 'text-red-300'}">
                                    <i class="fas fa-arrow-${isPositive ? 'up' : 'down'} mr-1"></i>${Math.abs(data.percentageChange)}%
                                </span> vs last month
                            `;
                        })
                        .catch(error => {
                            document.getElementById('monthlyRevenue').textContent = 'Error';
                            document.getElementById('revenueChange').innerHTML = `
                                <span class="text-red-300">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Failed to load
                                </span>
                            `;
                        });

                    // Fetch pending payments with error handling
                    fetch('/admin/payments/pending')
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('pendingPayments').textContent = 'Rs.' + data.amount.toLocaleString();
                            const paymentsChangeEl = document.getElementById('paymentsChange');
                            const isPositive = data.percentageChange >= 0;
                            paymentsChangeEl.innerHTML = `
                                <span class="${isPositive ? 'text-green-300' : 'text-red-300'}">
                                    <i class="fas fa-arrow-${isPositive ? 'up' : 'down'} mr-1"></i>${Math.abs(data.percentageChange)}%
                                </span> vs yesterday
                            `;
                        })
                        .catch(error => {
                            document.getElementById('pendingPayments').textContent = 'Error';
                            document.getElementById('paymentsChange').innerHTML = `
                                <span class="text-red-300">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Failed to load
                                </span>
                            `;
                        });
                });
            </script>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Patient Age Distribution Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">
                        <i class="fas fa-user-friends text-blue-500 mr-2"></i>
                        Patient Age Distribution
                    </h3>
                </div>
                <div class="p-5">
                    <div id="dashboard_div">
                        <div id="filter_div" class="mb-4"></div>
                        <div id="chart_div" style="min-height: 400px;"></div>
                    </div>
                </div>
            </div>

            <!-- Appointment & Treatment Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Appointment Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-800">
                            <i class="fas fa-calendar-check text-blue-500 mr-2"></i>
                            Appointment Status
                        </h3>
                    </div>
                    <div class="p-5">
                        <div id="appointmentsPieChart" style="width: 100%; height: 250px;"></div>
                    </div>
                </div>

                <!-- Treatment Distribution -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-800">
                            <i class="fas fa-tooth text-blue-500 mr-2"></i>
                            Treatment Distribution
                        </h3>
                    </div>
                    <div class="p-5">
                        <div id="treatmentChart" style="height: 250px;"></div>
                    </div>
                </div>

                <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawTreatmentChart);

                    function drawTreatmentChart() {
                        fetch('/admin/treatment-stats')
                            .then(response => response.json())
                            .then(treatmentData => {
                                var data = new google.visualization.DataTable();
                                data.addColumn('string', 'Treatment');
                                data.addColumn('number', 'Count');

                                treatmentData.forEach(item => {
                                    data.addRow([item.treatment, item.count]);
                                });

                                var options = {
                                    titleTextStyle: {
                                        color: '#1e293b',
                                        fontSize: 16,
                                        fontName: 'Poppins'
                                    },
                                    pieHole: 0.4,
                                    sliceVisibilityThreshold: 0.05,
                                    colors: ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#6366f1'],
                                    chartArea: {
                                        width: '100%',
                                        height: '80%'
                                    },
                                    legend: {
                                        position: 'bottom',
                                        alignment: 'center',
                                        textStyle: {
                                            color: '#475569',
                                            fontName: 'Poppins',
                                            fontSize: 12
                                        }
                                    },
                                    pieSliceText: 'percentage',
                                    pieSliceTextStyle: {
                                        color: 'white',
                                        fontName: 'Poppins'
                                    },
                                    tooltip: {
                                        showColorCode: true,
                                        text: 'percentage'
                                    }
                                };

                                var chart = new google.visualization.PieChart(document.getElementById('treatmentChart'));
                                chart.draw(data, options);

                                // Redraw chart on window resize
                                window.addEventListener('resize', function() {
                                    chart.draw(data, options);
                                });
                            })
                            .catch(error => {
                                console.error('Error loading treatment data:', error);
                                document.getElementById('treatmentChart').innerHTML = `
                                    <div class="text-center text-gray-500 py-4">
                                        <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                                        <p>Failed to load treatment data</p>
                                        <button onclick="drawTreatmentChart()" class="mt-2 text-sm text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-redo mr-1"></i> Try again
                                        </button>
                                    </div>
                                `;
                            });
                    }
                </script>
            </div>

            <!-- Recent Invoices -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">
                        <i class="fas fa-file-invoice-dollar text-blue-500 mr-2"></i>
                        Recent Invoices
                    </h3>
                    <a href="{{ route('admin.invoice.index') }}" class="text-sm text-blue-500 hover:text-blue-700 flex items-center">
                        View All
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                <div class="overflow-x-auto" id="recentInvoicesTable">
                    <div class="p-4 text-center text-gray-500">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Loading invoices...
                    </div>
                </div>
            </div>

            <script>
            function loadRecentInvoices() {
                fetch('/admin/recent-invoices')
                    .then(response => response.json())
                    .then(invoices => {
                        const tableContent = `
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase text-left">Invoice #</th>
                                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase text-left">Patient</th>
                                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase text-left">Date</th>
                                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase text-left">Amount</th>
                                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    ${invoices.length > 0 ? invoices.map(invoice => `
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-5 py-4 text-sm text-gray-900">
                                                <a href="/admin/invoice/view/${invoice.id}" class="font-medium text-blue-600 hover:text-blue-800">#${invoice.id}</a>
                                            </td>
                                            <td class="px-5 py-4 text-sm">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                                                        <span class="font-medium">${invoice.patient ? invoice.patient.name.charAt(0) : 'U'}</span>
                                                    </div>
                                                    <span class="text-gray-700">${invoice.patient ? invoice.patient.name : 'Unknown'}</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 text-sm text-gray-500">
                                                ${moment(invoice.created_at).format('D MMM, YYYY')}
                                            </td>
                                            <td class="px-5 py-4 text-sm">
                                                <span class="font-medium text-gray-900">Rs.${invoice.totalAmount ? invoice.totalAmount.toLocaleString() : '0'}</span>
                                            </td>
                                            <td class="px-5 py-4 text-sm">
                                                ${invoice.totalAmount <= invoice.advanceAmount ?
                                                    `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <i class="fas fa-check-circle mr-1"></i> Paid
                                                    </span>` :
                                                    `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-clock mr-1"></i> Pending
                                                    </span>`
                                                }
                                            </td>
                                        </tr>
                                    `).join('') : `
                                        <tr>
                                            <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                                                <i class="fas fa-file-invoice text-gray-300 text-4xl mb-3 block"></i>
                                                <p>No recent invoices found</p>
                                            </td>
                                        </tr>
                                    `}
                                </tbody>
                            </table>
                        `;
                        document.getElementById('recentInvoicesTable').innerHTML = tableContent;
                    })
                    .catch(error => {
                        console.error('Error loading recent invoices:', error);
                        document.getElementById('recentInvoicesTable').innerHTML = `
                            <div class="p-4 text-center text-gray-500">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl mb-2 block"></i>
                                <p>Failed to load recent invoices</p>
                                <button onclick="loadRecentInvoices()" class="mt-2 text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-redo mr-1"></i> Try again
                                </button>
                            </div>
                        `;
                    });
            }

            // Load invoices when the document is ready
            document.addEventListener('DOMContentLoaded', loadRecentInvoices);
            </script>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Today's Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">
                        <i class="fas fa-calendar-day text-blue-500 mr-2"></i>
                        Today's Appointments
                    </h3>
                    <a href="{{ route('admin.appointments.index') }}" class="text-sm text-blue-500 hover:text-blue-700 flex items-center">
                        View All
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                <div class="p-5">
                    @if(isset($todayAppointmentsList) && count($todayAppointmentsList) > 0)
                        <div class="space-y-4">
                            @foreach($todayAppointmentsList as $appointment)
                                <div class="p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                                                <span class="font-medium">{{ substr($appointment->patient->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $appointment->patient->name ?? 'Unknown Patient' }}</h4>
                                                <p class="text-xs text-gray-500">{{ $appointment->patient->mobileNumber ?? 'No contact' }}</p>
                                            </div>
                                        </div>
                                        @php
                                            $statusClass = 'bg-green-100 text-green-800';
                                            $statusIcon = 'fa-check-circle';
                                            $status = 'Confirmed';

                                            if(isset($appointment->status)) {
                                                if($appointment->status == 'pending') {
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    $statusIcon = 'fa-clock';
                                                    $status = 'Pending';
                                                } elseif($appointment->status == 'cancelled') {
                                                    $statusClass = 'bg-red-100 text-red-800';
                                                    $statusIcon = 'fa-times-circle';
                                                    $status = 'Cancelled';
                                                }
                                            }
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                            <i class="fas {{ $statusIcon }} mr-1"></i> {{ $status }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time ?? now())->format('h:i A') }}
                                        </div>
                                        <div class="flex space-x-2">
                                            @if(isset($appointment->status) && $appointment->status == 'pending')
                                                <form action="{{ route('admin.appointments.confirm', $appointment->id ?? 1) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-1 text-xs font-medium text-green-600 hover:text-green-800 focus:outline-none">
                                                        <i class="fas fa-check"></i> Confirm
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.appointments.edit', $appointment->id ?? 1) }}" class="p-1 text-xs font-medium text-blue-600 hover:text-blue-800 focus:outline-none">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center">
                            <i class="far fa-calendar-check text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">No appointments scheduled for today</p>
                            <a href="{{ route('admin.appointments.index') }}" class="mt-3 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Schedule Appointment
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">
                        <i class="fas fa-bolt text-blue-500 mr-2"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-5 grid grid-cols-1 gap-4">
                    <a href="{{ route('admin.patient.store') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-4 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 group-hover:text-blue-700">Add New Patient</h4>
                            <p class="text-xs text-gray-500">Register a new patient record</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.appointments.index') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-indigo-50 hover:border-indigo-200 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-500 flex items-center justify-center mr-4 group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 group-hover:text-indigo-700">Schedule Appointment</h4>
                            <p class="text-xs text-gray-500">Book a new appointment</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.patient.list') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-green-50 hover:border-green-200 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-500 flex items-center justify-center mr-4 group-hover:bg-green-500 group-hover:text-white transition-colors">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 group-hover:text-green-700">Create Invoice</h4>
                            <p class="text-xs text-gray-500">Generate a new invoice</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.chart.index') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-purple-50 hover:border-purple-200 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-500 flex items-center justify-center mr-4 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 group-hover:text-purple-700">View Reports</h4>
                            <p class="text-xs text-gray-500">Access detailed analytics</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">
                        <i class="fas fa-history text-blue-500 mr-2"></i>
                        Recent Activity
                    </h3>
                </div>
                <div class="p-5">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                        <div class="relative">
                            <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200"></div>
                            <div class="space-y-6">
                                @foreach($recentActivities as $activity)
                                    <div class="relative pl-8">
                                        <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center z-10">
                                            <i class="fas fa-{{ $activity->icon ?? 'check' }}"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $activity->description ?? 'Activity logged' }}</h4>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity->created_at ?? now())->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="py-8 text-center">
                            <i class="fas fa-history text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">No recent activities</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
function generateDailyReport() {
    showLoader();

    fetch('/admin/export/daily-report', {  // Changed from route() helper to direct path
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `daily-report-${new Date().toISOString().split('T')[0]}.pdf`;
        link.click();
        window.URL.revokeObjectURL(url);
        hideLoader();
        showAlert('Success', 'Report downloaded successfully!', 'success');
    })
    .catch(error => {
        console.error('Export failed:', error);
        hideLoader();
        showAlert('Error', 'Failed to generate report. Please try again.', 'error');
    });
}

    // Make sure Google Charts is loaded before using it
    if (typeof google !== 'undefined') {
        google.charts.load('current', {'packages':['corechart', 'controls']});
        google.charts.setOnLoadCallback(drawDashboard);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Google Charts
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(initCharts);

        // Show loader initially
        if (typeof showLoader === 'function') {
            showLoader();
        }

        // Hide loader after content is ready
        setTimeout(() => {
            if (typeof hideLoader === 'function') {
                hideLoader();
            }
        }, 800);

        function initCharts() {
            drawRevenueChart();
            drawTreatmentsChart();
            drawAppointmentsChart();
        }

        function drawRevenueChart() {
            // Revenue Chart with ApexCharts
            const revenueOptions = {
                series: [{
                    name: 'Revenue',
                    data: [30000, 40000, 35000, 50000, 49000, 60000, 70000]
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                colors: ['#3b82f6'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontFamily: 'Poppins, sans-serif'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return '₹' + val.toLocaleString();
                        },
                        style: {
                            colors: '#64748b',
                            fontFamily: 'Poppins, sans-serif'
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return '₹' + val.toLocaleString();
                        }
                    }
                },
                grid: {
                    borderColor: '#e2e8f0',
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };

            const revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
            revenueChart.render();

            // Chart period buttons
            document.getElementById('weekBtn').addEventListener('click', function() {
                this.classList.add('bg-blue-500', 'text-white');
                this.classList.remove('bg-gray-100', 'text-gray-600');
                document.getElementById('monthBtn').classList.remove('bg-blue-500', 'text-white');
                document.getElementById('monthBtn').classList.add('bg-gray-100', 'text-gray-600');
                document.getElementById('yearBtn').classList.remove('bg-blue-500', 'text-white');
                document.getElementById('yearBtn').classList.add('bg-gray-100', 'text-gray-600');

                revenueChart.updateOptions({
                    series: [{
                        data: [30000, 40000, 35000, 50000, 49000, 60000, 70000]
                    }],
                    xaxis: {
                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    }
                });

                if (typeof showToast === 'function') {
                    showToast('Chart Updated', 'Showing weekly revenue data', 'info');
                }
            });

            document.getElementById('monthBtn').addEventListener('click', function() {
                this.classList.add('bg-blue-500', 'text-white');
                this.classList.remove('bg-gray-100', 'text-gray-600');
                document.getElementById('weekBtn').classList.remove('bg-blue-500', 'text-white');
                document.getElementById('weekBtn').classList.add('bg-gray-100', 'text-gray-600');
                document.getElementById('yearBtn').classList.remove('bg-blue-500', 'text-white');
                document.getElementById('yearBtn').classList.add('bg-gray-100', 'text-gray-600');

                revenueChart.updateOptions({
                    series: [{
                        data: [150000, 180000, 210000, 190000, 220000, 250000, 240000, 260000, 270000, 290000, 310000, 330000]
                    }],
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    }
                });

                if (typeof showToast === 'function') {
                    showToast('Chart Updated', 'Showing monthly revenue data', 'info');
                }
            });

            document.getElementById('yearBtn').addEventListener('click', function() {
                this.classList.add('bg-blue-500', 'text-white');
                this.classList.remove('bg-gray-100', 'text-gray-600');
                document.getElementById('weekBtn').classList.remove('bg-blue-500', 'text-white');
                document.getElementById('weekBtn').classList.add('bg-gray-100', 'text-gray-600');
                document.getElementById('monthBtn').classList.remove('bg-blue-500', 'text-white');
                document.getElementById('monthBtn').classList.add('bg-gray-100', 'text-gray-600');

                revenueChart.updateOptions({
                    series: [{
                        data: [1200000, 1500000, 1800000, 1600000, 2200000, 2800000]
                    }],
                    xaxis: {
                        categories: ['2018', '2019', '2020', '2021', '2022', '2023']
                    }
                });

                if (typeof showToast === 'function') {
                    showToast('Chart Updated', 'Showing yearly revenue data', 'info');
                }
            });
        }

        function drawTreatmentsChart() {
            // Treatment Distribution Chart
            const treatmentsOptions = {
                series: [30, 25, 15, 20, 10],
                chart: {
                    type: 'donut',
                    height: 250
                },
                labels: ['Root Canal', 'Cleaning', 'Extraction', 'Filling', 'Braces'],
                colors: ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444'],
                legend: {
                    position: 'bottom',
                    fontFamily: 'Poppins, sans-serif'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '60%'
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            const treatmentsChart = new ApexCharts(document.querySelector("#treatmentsChart"), treatmentsOptions);
            treatmentsChart.render();
        }

        function drawAppointmentsChart() {
            // Appointment Status Chart
            const appointmentsOptions = {
                series: [65, 25, 10],
                chart: {
                    type: 'donut',
                    height: 250
                },
                labels: ['Confirmed', 'Pending', 'Cancelled'],
                colors: ['#10b981', '#f59e0b', '#ef4444'],
                legend: {
                    position: 'bottom',
                    fontFamily: 'Poppins, sans-serif'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '60%'
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            const appointmentsChart = new ApexCharts(document.querySelector("#appointmentsChart"), appointmentsOptions);
            appointmentsChart.render();
        }

        // Fetch data from API endpoints if available
        function fetchChartData() {
            // Revenue Chart Data
            fetch('{{ route("admin.chart.revenue") }}')
                .then(response => response.json())
                .then(data => {
                    // Update revenue chart with real data
                    console.log('Revenue data loaded');
                })
                .catch(error => {
                    console.error('Error loading revenue data:', error);
                });

            // Treatments Chart Data
            fetch('{{ route("admin.chart.treatments") }}')
                .then(response => response.json())
                .then(data => {
                    // Update treatments chart with real data
                    console.log('Treatments data loaded');
                })
                .catch(error => {
                    console.error('Error loading treatments data:', error);
                });

            // Appointments Chart Data
            fetch('{{ route("admin.chart.appointments") }}')
                .then(response => response.json())
                .then(data => {
                    // Update appointments chart with real data
                    console.log('Appointments data loaded');
                })
                .catch(error => {
                    console.error('Error loading appointments data:', error);
                });
        }

        // Try to fetch real data if available
        try {
            fetchChartData();
        } catch (e) {
            console.log('Using demo data for charts');
        }

        // Redraw charts on window resize
        window.addEventListener('resize', function() {
            initCharts();
        });
    });
</script>
@endsection
