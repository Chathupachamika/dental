@extends('admin.admin_logged.app')

<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<div class="analytics-dashboard">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="dashboard-title">Analytics Report</h1>
            <p class="dashboard-subtitle">Dental Management System Overview</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-outline-primary" id="exportBtn">
                <i class="fas fa-file-export"></i> Export Data
            </button>
            <button class="btn btn-primary" id="refreshBtn">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards-container">
        <div class="stats-card primary">
            <div class="stats-card-content">
                <div class="stats-card-value" id="total-appointments">0</div>
                <div class="stats-card-label">Total Appointments</div>
                <div class="stats-card-trend">
                    <i class="fas fa-arrow-up"></i> 12.5%
                    <span class="trend-period">vs last month</span>
                </div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>

        <div class="stats-card success">
            <div class="stats-card-content">
                <div class="stats-card-value" id="total-amount">Rs.0.00</div>
                <div class="stats-card-label">Total Amount</div>
                <div class="stats-card-trend">
                    <i class="fas fa-arrow-up"></i> 8.3%
                    <span class="trend-period">vs last month</span>
                </div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>

        <div class="stats-card info">
            <div class="stats-card-content">
                <div class="stats-card-value" id="advance-amount">Rs.0.00</div>
                <div class="stats-card-label">Advance Amount</div>
                <div class="stats-card-trend">
                    <i class="fas fa-arrow-up"></i> 5.7%
                    <span class="trend-period">vs last month</span>
                </div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
        </div>

        <div class="stats-card warning">
            <div class="stats-card-content">
                <div class="stats-card-value" id="total-patients">0</div>
                <div class="stats-card-label">Total Patients</div>
                <div class="stats-card-trend">
                    <i class="fas fa-arrow-up"></i> 3.2%
                    <span class="trend-period">vs last month</span>
                </div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Main Charts Row -->
    <div class="charts-row">
        <div class="chart-container large">
            <div class="chart-header">
                <h2 class="chart-title">Revenue & Appointments Overview</h2>
                <div class="chart-actions">
                    <div class="period-selector">
                        <button class="period-btn" data-period="daily">Daily</button>
                        <button class="period-btn active" data-period="monthly">Monthly</button>
                        <button class="period-btn" data-period="annually">Annually</button>
                    </div>
                </div>
            </div>
            <div id="main_chart_div" class="chart-body"></div>
        </div>

        <div class="chart-container medium">
            <div class="chart-header">
                <h2 class="chart-title">Treatment Distribution</h2>
            </div>
            <div id="treatment_chart_div" class="chart-body"></div>
        </div>
    </div>

    <!-- Secondary Charts Row -->
    <div class="charts-row">
        <div class="chart-container medium">
            <div class="chart-header">
                <h2 class="chart-title">Appointment Status</h2>
            </div>
            <div id="appointment_status_chart" class="chart-body"></div>
        </div>

        <div class="chart-container medium">
            <div class="chart-header">
                <h2 class="chart-title">Monthly Revenue</h2>
            </div>
            <div id="revenue_chart_div" class="chart-body"></div>
        </div>
    </div>

    <!-- Recent Invoices -->
    <div class="data-table-container">
        <div class="data-table-header">
            <h2 class="data-table-title">Recent Invoices</h2>
            <div class="data-table-actions">
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> View All
                </button>
            </div>
        </div>
        <div class="data-table-body">
            <table class="data-table" id="recent-invoices-table">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Advance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Dashboard Styles */
    .analytics-dashboard {
        padding: 1.5rem;
        background-color: #f8fafc;
    }

    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .dashboard-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .dashboard-subtitle {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0.25rem 0 0 0;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    /* Stats Cards */
    .stats-cards-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .stats-card {
        background-color: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 100%);
        z-index: 1;
    }

    .stats-card-content {
        position: relative;
        z-index: 2;
    }

    .stats-card-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #1e293b;
    }

    .stats-card-label {
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 0.75rem;
    }

    .stats-card-trend {
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .trend-period {
        font-weight: 400;
        opacity: 0.7;
    }

    .stats-card-icon {
        font-size: 2.5rem;
        opacity: 0.15;
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-card-icon {
        opacity: 0.25;
        transform: translateY(-50%) scale(1.1);
    }

    /* Card Colors */
    .stats-card.primary {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    }

    .stats-card.primary .stats-card-value,
    .stats-card.primary .stats-card-label,
    .stats-card.primary .stats-card-trend,
    .stats-card.primary .stats-card-icon {
        color: #fff;
    }

    .stats-card.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stats-card.success .stats-card-value,
    .stats-card.success .stats-card-label,
    .stats-card.success .stats-card-trend,
    .stats-card.success .stats-card-icon {
        color: #fff;
    }

    .stats-card.info {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    }

    .stats-card.info .stats-card-value,
    .stats-card.info .stats-card-label,
    .stats-card.info .stats-card-trend,
    .stats-card.info .stats-card-icon {
        color: #fff;
    }

    .stats-card.warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stats-card.warning .stats-card-value,
    .stats-card.warning .stats-card-label,
    .stats-card.warning .stats-card-trend,
    .stats-card.warning .stats-card-icon {
        color: #fff;
    }

    /* Charts */
    .charts-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .chart-container {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .chart-container:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .chart-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chart-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .chart-body {
        padding: 1.25rem;
        height: 300px;
    }

    .period-selector {
        display: flex;
        gap: 0.5rem;
    }

    .period-btn {
        padding: 0.35rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        background-color: #f1f5f9;
        color: #64748b;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .period-btn:hover {
        background-color: #e2e8f0;
        color: #1e293b;
    }

    .period-btn.active {
        background-color: #0ea5e9;
        color: #fff;
    }

    /* Data Table */
    .data-table-container {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .data-table-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .data-table-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .data-table-body {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background-color: #f8fafc;
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        color: #64748b;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f1f5f9;
    }

    .data-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 0.95rem;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover td {
        background-color: #f8fafc;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-badge.paid {
        background-color: #dcfce7;
        color: #16a34a;
    }

    .status-badge.pending {
        background-color: #fef3c7;
        color: #d97706;
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .stats-cards-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .charts-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .stats-cards-container {
            grid-template-columns: 1fr;
        }

        .header-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Export button functionality
    document.getElementById('exportBtn').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';

        fetch('{{ route("admin.chart.export") }}', {
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
            link.download = `dental-analytics-${new Date().toISOString().split('T')[0]}.pdf`;
            link.click();
            window.URL.revokeObjectURL(url);

            this.disabled = false;
            this.innerHTML = '<i class="fas fa-file-export"></i> Export Data';

            // Success alert
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Report exported successfully',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            console.error('Export failed:', error);
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-file-export"></i> Export Data';

            // Error alert
            Swal.fire({
                icon: 'error',
                title: 'Export Failed',
                text: 'Unable to export the report. Please try again.',
                confirmButtonText: 'OK'
            });
        });
    });

    // Refresh button functionality
    document.getElementById('refreshBtn').addEventListener('click', async function() {
        try {
            // Show loading alert
            Swal.fire({
                title: 'Refreshing Dashboard',
                text: 'Please wait while we fetch the latest data...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';

            // Clear existing data
            document.getElementById('total-appointments').textContent = '...';
            document.getElementById('total-amount').textContent = '...';
            document.getElementById('advance-amount').textContent = '...';
            document.getElementById('total-patients').textContent = '...';

            // Fetch new data
            await Promise.all([
                fetchDashboardData(),
                initCharts()
            ]);

            // Success alert
            Swal.fire({
                icon: 'success',
                title: 'Dashboard Updated!',
                text: 'All data has been refreshed successfully',
                timer: 2000,
                showConfirmButton: false
            });

        } catch (error) {
            console.error('Refresh failed:', error);

            // Error alert
            Swal.fire({
                icon: 'error',
                title: 'Refresh Failed',
                text: 'Unable to refresh dashboard data. Please try again.',
                confirmButtonText: 'OK'
            });
        } finally {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-sync-alt"></i> Refresh';
        }
    });

    // Load Google Charts
    google.charts.load('current', {
        'packages': ['corechart', 'bar']
    });

    // Set callback when Google Charts is loaded
    google.charts.setOnLoadCallback(initCharts);

    // Fetch initial data
    fetchDashboardData();

    // Set up event listeners for period selector buttons
    document.querySelectorAll('.period-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.period-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');

            // Load chart with selected period
            loadMainChart(this.dataset.period);
        });
    });

    // Function to fetch dashboard data
    async function fetchDashboardData() {
        try {
            const [appointmentStats, invoices, patients] = await Promise.all([
                fetch('{{ route("admin.appointment.stats") }}').then(res => res.json()),
                fetch('{{ route("admin.recent.invoices") }}').then(res => res.json()),
                fetch('{{ route("admin.patient.patientList") }}').then(res => res.json())
            ]);

            // Update appointments
            document.getElementById('total-appointments').textContent = appointmentStats.total.toLocaleString();

            // Update invoices and amounts
            if (Array.isArray(invoices)) {
                renderRecentInvoices(invoices);
                const totalAmount = invoices.reduce((sum, inv) => sum + parseFloat(inv.totalAmount || 0), 0);
                const advanceAmount = invoices.reduce((sum, inv) => sum + parseFloat(inv.advanceAmount || 0), 0);

                document.getElementById('total-amount').textContent = 'Rs.' + totalAmount.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                document.getElementById('advance-amount').textContent = 'Rs.' + advanceAmount.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Update patients
            if (patients.code === 200) {
                document.getElementById('total-patients').textContent = patients.data.length.toLocaleString();
            }

        } catch (error) {
            console.error('Error fetching dashboard data:', error);
            throw error;
        }
    }

    // Function to render recent invoices
    function renderRecentInvoices(invoices) {
        const tableBody = document.querySelector('#recent-invoices-table tbody');
        tableBody.innerHTML = '';

        invoices.forEach(invoice => {
            const row = document.createElement('tr');

            // Format date
            const date = new Date(invoice.created_at);
            const formattedDate = date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            // Format status badge
            const statusBadge = invoice.status === 'paid'
                ? '<span class="status-badge paid">Paid</span>'
                : '<span class="status-badge pending">Pending</span>';

            row.innerHTML = `
                <td>#${invoice.id}</td>
                <td>${invoice.patient.name}</td>
                <td>${formattedDate}</td>
                <td>Rs.${parseFloat(invoice.totalAmount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}</td>
                <td>Rs.${parseFloat(invoice.advanceAmount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}</td>
                <td>${statusBadge}</td>
                <td>
                    <a href="{{ url('admin/invoice/view') }}/${invoice.id}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ url('admin/invoice') }}/${invoice.id}/download" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-download"></i>
                    </a>
                </td>
            `;

            tableBody.appendChild(row);
        });
    }

    // Initialize all charts
    function initCharts() {
        loadMainChart('monthly');
        loadTreatmentChart();
        loadAppointmentStatusChart();
        loadRevenueChart();
    }

    // Load the main overview chart
    function loadMainChart(period) {
        fetch(`{{ route('admin.chart.data') }}?period=${period}`)
            .then(response => response.json())
            .then(data => {
                const chartData = google.visualization.arrayToDataTable(data);

                const options = {
                    chartArea: {width: '85%', height: '75%'},
                    colors: ['#0ea5e9', '#10b981', '#f59e0b'],
                    fontName: 'Poppins',
                    legend: {position: 'bottom'},
                    seriesType: 'bars',
                    series: {
                        0: {color: '#0ea5e9'},
                        1: {color: '#10b981'},
                        2: {type: 'line', color: '#f59e0b', targetAxisIndex: 1}
                    },
                    vAxes: {
                        0: {title: 'Amount (Rs.)', format: 'currency', formatOptions: {prefix: 'Rs.', decimalSymbol: '.', groupingSymbol: ','}},
                        1: {title: 'Appointments', format: '#,##0', textStyle: {color: '#64748b'}}
                    },
                    hAxis: {
                        textStyle: {color: '#64748b'}
                    },
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    },
                    backgroundColor: 'transparent'
                };

                const chart = new google.visualization.ComboChart(document.getElementById('main_chart_div'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error loading chart data:', error));
    }

    // Load the treatment distribution chart
    function loadTreatmentChart() {
        fetch('{{ route("admin.chart.treatments") }}')
            .then(response => response.json())
            .then(data => {
                const chartData = google.visualization.arrayToDataTable(data);

                const options = {
                    pieHole: 0.4,
                    colors: ['#0ea5e9', '#10b981', '#6366f1', '#f59e0b', '#ef4444'],
                    chartArea: {width: '90%', height: '85%'},
                    legend: {position: 'right', alignment: 'center', textStyle: {color: '#64748b'}},
                    fontName: 'Poppins',
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    },
                    backgroundColor: 'transparent'
                };

                const chart = new google.visualization.PieChart(document.getElementById('treatment_chart_div'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error loading treatment chart data:', error));
    }

    // Load the appointment status chart
    function loadAppointmentStatusChart() {
        fetch('{{ route("admin.chart.appointments") }}')
            .then(response => response.json())
            .then(data => {
                const chartData = google.visualization.arrayToDataTable(data.statusData);

                const options = {
                    pieHole: 0.4,
                    colors: ['#10b981', '#f59e0b', '#ef4444'],
                    chartArea: {width: '90%', height: '85%'},
                    legend: {position: 'right', alignment: 'center', textStyle: {color: '#64748b'}},
                    fontName: 'Poppins',
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    },
                    backgroundColor: 'transparent'
                };

                const chart = new google.visualization.PieChart(document.getElementById('appointment_status_chart'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error loading appointment status chart data:', error));
    }

    // Load the revenue chart
    function loadRevenueChart() {
        fetch('{{ route("admin.chart.revenue") }}')
            .then(response => response.json())
            .then(data => {
                const chartData = google.visualization.arrayToDataTable(data);

                const options = {
                    colors: ['#0ea5e9', '#10b981'],
                    chartArea: {width: '80%', height: '75%'},
                    legend: {position: 'bottom', textStyle: {color: '#64748b'}},
                    fontName: 'Poppins',
                    hAxis: {textStyle: {color: '#64748b'}},
                    vAxis: {
                        format: 'currency',
                        formatOptions: {
                            prefix: 'Rs.',
                            decimalSymbol: '.',
                            groupingSymbol: ','
                        },
                        textStyle: {color: '#64748b'}
                    },
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    },
                    backgroundColor: 'transparent'
                };

                const chart = new google.visualization.ColumnChart(document.getElementById('revenue_chart_div'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error loading revenue chart data:', error));
    }

    // Handle window resize to make charts responsive
    window.addEventListener('resize', function() {
        if (this.resizeTimer) clearTimeout(this.resizeTimer);
        this.resizeTimer = setTimeout(function() {
            initCharts();
        }, 500);
    });
});
</script>
@endsection
