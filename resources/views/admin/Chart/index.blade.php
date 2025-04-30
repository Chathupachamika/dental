@extends('admin.admin_logged.app')

@section('content')
<div class="animate-fadeIn">
    <!-- Page Header -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">
                    <i class="fas fa-chart-line text-primary mr-2"></i>
                    Financial Reports
                </h4>
                <p class="text-muted mb-0">Track your clinic's financial performance</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="input-group date-picker-group">
                    <input type="date" class="form-control" name="date" id="date" value="{{ request('date', date('Y-m-d')) }}">
                    <div class="input-group-append">
                        <button type="button" onclick="search_place()" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <!-- Total Appointments -->
        <div class="col-md-4">
            <div class="card stats-card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title text-white mb-0">Total Appointments</h5>
                            <p class="text-white-50 mb-0">For selected date</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                    <h2 class="mt-3 mb-0">{{ count($invoice) }}</h2>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{ min(count($invoice) * 5, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Amount -->
        <div class="col-md-4">
            <div class="card stats-card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title text-white mb-0">Total Revenue</h5>
                            <p class="text-white-50 mb-0">All transactions</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                    <h2 class="mt-3 mb-0">
                        <?php
                        $total = 0;
                        foreach($invoice as $bD) {
                            $total += ($bD['totalAmount']);
                        }
                        ?>
                        ${{ number_format($total, 2) }}
                    </h2>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{ min($total/100, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advance Amount -->
        <div class="col-md-4">
            <div class="card stats-card bg-accent text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title text-white mb-0">Advance Payments</h5>
                            <p class="text-white-50 mb-0">Pre-payments received</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-hand-holding-usd fa-2x"></i>
                        </div>
                    </div>
                    <h2 class="mt-3 mb-0">
                        <?php
                        $advanceTotal = 0;
                        foreach($invoice as $bD) {
                            $advanceTotal += ($bD['advanceAmount']);
                        }
                        ?>
                        ${{ number_format($advanceTotal, 2) }}
                    </h2>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{ min($advanceTotal/100, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Revenue Chart -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary mr-2"></i>
                        Revenue Overview
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary active" onclick="updateChartPeriod('daily')">Daily</button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="updateChartPeriod('weekly')">Weekly</button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="updateChartPeriod('monthly')">Monthly</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Payment Distribution -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-primary mr-2"></i>
                        Payment Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentDistributionChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list-alt text-primary mr-2"></i>
                Detailed Report for <span id="date-label" class="font-weight-bold">{{ request('date', date('Y-m-d')) }}</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Patient</th>
                            <th>Treatment</th>
                            <th>Total Amount</th>
                            <th>Advance</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($invoice) > 0)
                            @foreach($invoice as $index => $inv)
                                <tr>
                                    <td>INV-{{ str_pad($inv['id'], 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $inv['patient_name'] ?? 'N/A' }}</td>
                                    <td>{{ $inv['treatment_name'] ?? 'General' }}</td>
                                    <td>${{ number_format($inv['totalAmount'], 2) }}</td>
                                    <td>${{ number_format($inv['advanceAmount'], 2) }}</td>
                                    <td>${{ number_format($inv['totalAmount'] - $inv['advanceAmount'], 2) }}</td>
                                    <td>
                                        @if($inv['totalAmount'] == $inv['advanceAmount'])
                                            <span class="badge bg-success text-white">Paid</span>
                                        @elseif($inv['advanceAmount'] > 0)
                                            <span class="badge bg-warning text-white">Partial</span>
                                        @else
                                            <span class="badge bg-danger text-white">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.invoice.view', $inv['id']) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">No invoices found for this date</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-outline-primary" onclick="exportReport()">
                        <i class="fas fa-file-export mr-1"></i> Export Report
                    </button>
                </div>
                <div>
                    <button class="btn btn-outline-secondary" onclick="printReport()">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    // Initialize charts and data on page load
    window.onload = function() {
        // Set date label
        const urlParams = new URLSearchParams(window.location.search);
        const date = urlParams.get('date') || moment().format('YYYY-MM-DD');
        document.getElementById('date-label').innerHTML = date;

        // Initialize charts
        initializeCharts();

        // Show welcome message
        showToast('Report Loaded', 'Financial report data has been loaded successfully', 'success');
    };

    // Query parameters for search
    var query = <?php echo json_encode((object)Request::only(['date'])); ?>;

    // Search function
    function search_place() {
        showLoader('Loading report data...');
        Object.assign(query, {
            'date': $('#date').val()
        });
        window.location.href = "{{route('admin.chart.index')}}?" + $.param(query);
    }

    // Initialize all charts
    function initializeCharts() {
        // Sample data for charts - in a real app, this would come from the backend
        const revenueData = generateSampleRevenueData();
        const distributionData = {
            labels: ['Advance Payments', 'Balance Due'],
            datasets: [{
                data: [
                    <?php echo $advanceTotal ?? 0; ?>,
                    <?php echo ($total - $advanceTotal) ?? 0; ?>
                ],
                backgroundColor: ['#0ea5e9', '#f59e0b'],
                borderWidth: 0
            }]
        };

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        window.revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: revenueData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
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
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 5,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': $' + context.parsed.y;
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                elements: {
                    line: {
                        tension: 0.4
                    },
                    point: {
                        radius: 3,
                        hoverRadius: 5
                    }
                }
            }
        });

        // Payment Distribution Chart
        const distributionCtx = document.getElementById('paymentDistributionChart').getContext('2d');
        window.distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: distributionData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${context.label}: $${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Generate sample data for the revenue chart
    function generateSampleRevenueData() {
        // In a real app, this would come from the backend
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const totalRevenue = [4500, 5200, 4800, 5800, 6000, 3500, 4200];
        const advancePayments = [3000, 3500, 2800, 4000, 4200, 2000, 2500];

        return {
            labels: days,
            datasets: [
                {
                    label: 'Total Revenue',
                    data: totalRevenue,
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.1)',
                    fill: true
                },
                {
                    label: 'Advance Payments',
                    data: advancePayments,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true
                }
            ]
        };
    }

    // Update chart based on selected period
    function updateChartPeriod(period) {
        showLoader('Updating chart...');

        // Update active button
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');

        // In a real app, you would fetch new data from the server
        // For demo purposes, we'll just simulate a data change
        setTimeout(() => {
            let labels, totalRevenue, advancePayments;

            switch(period) {
                case 'weekly':
                    labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    totalRevenue = [18000, 22000, 19500, 24000];
                    advancePayments = [12000, 15000, 13000, 16000];
                    break;
                case 'monthly':
                    labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                    totalRevenue = [65000, 72000, 68000, 79000, 82000, 75000];
                    advancePayments = [45000, 48000, 42000, 52000, 56000, 50000];
                    break;
                default: // daily
                    labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    totalRevenue = [4500, 5200, 4800, 5800, 6000, 3500, 4200];
                    advancePayments = [3000, 3500, 2800, 4000, 4200, 2000, 2500];
            }

            window.revenueChart.data.labels = labels;
            window.revenueChart.data.datasets[0].data = totalRevenue;
            window.revenueChart.data.datasets[1].data = advancePayments;
            window.revenueChart.update();

            hideLoader();
            showToast('Chart Updated', `Showing ${period} revenue data`, 'success');
        }, 800);
    }

    // Export report function
    function exportReport() {
        showAlert('Export Report', 'Your report will be exported as Excel file.', 'info')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoader('Preparing export...');

                    // Simulate export process
                    setTimeout(() => {
                        hideLoader();
                        showToast('Export Complete', 'Your report has been exported successfully', 'success');
                    }, 1500);
                }
            });
    }

    // Print report function
    function printReport() {
        showLoader('Preparing print view...');

        // Simulate print preparation
        setTimeout(() => {
            hideLoader();
            window.print();
        }, 1000);
    }
</script>
@endsection
