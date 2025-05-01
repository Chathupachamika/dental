@extends('admin.admin_logged.app')

@section('title', 'Dashboard Analytics')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    .dashboard-card {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .chart-container {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background-color: white;
        padding: 20px;
        margin-bottom: 20px;
    }
    .filter-container {
        background-color: white;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .filter-btn {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .filter-btn.active {
        background-color: #4f46e5;
        color: white;
    }
    .filter-btn:hover:not(.active) {
        background-color: #e5e7eb;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
    }
    .stat-label {
        font-size: 14px;
        color: #6b7280;
    }
    .trend-up {
        color: #10b981;
    }
    .trend-down {
        color: #ef4444;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Appointment Analytics Dashboard</h1>

    <!-- Date Range Filter -->
    <div class="filter-container flex flex-wrap items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Filter by Date Range</h2>
            <div class="flex space-x-2">
                <button class="filter-btn active" data-range="today" id="todayBtn">Today</button>
                <button class="filter-btn" data-range="week" id="weekBtn">This Week</button>
                <button class="filter-btn" data-range="month" id="monthBtn">This Month</button>
                <button class="filter-btn" data-range="year" id="yearBtn">This Year</button>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="date" id="startDate" class="border rounded-lg px-3 py-2">
            </div>
            <span class="text-gray-500">to</span>
            <div class="relative">
                <input type="date" id="endDate" class="border rounded-lg px-3 py-2">
            </div>
            <button id="customRangeBtn" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Apply
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Appointments Card -->
        <div class="dashboard-card bg-white p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="stat-label">Total Appointments</p>
                    <p class="stat-value" id="totalAppointments">0</p>
                    <p class="text-sm flex items-center mt-2">
                        <span class="trend-up flex items-center" id="appointmentTrend">
                            <i class="fas fa-arrow-up mr-1"></i> 0%
                        </span>
                        <span class="text-gray-500 ml-1">vs previous period</span>
                    </p>
                </div>
                <div class="card-icon bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>

        <!-- Total Amount Card -->
        <div class="dashboard-card bg-white p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="stat-label">Total Amount</p>
                    <p class="stat-value" id="totalAmount">$0</p>
                    <p class="text-sm flex items-center mt-2">
                        <span class="trend-up flex items-center" id="amountTrend">
                            <i class="fas fa-arrow-up mr-1"></i> 0%
                        </span>
                        <span class="text-gray-500 ml-1">vs previous period</span>
                    </p>
                </div>
                <div class="card-icon bg-green-100 text-green-600">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <!-- Advance Amount Card -->
        <div class="dashboard-card bg-white p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="stat-label">Advance Amount</p>
                    <p class="stat-value" id="advanceAmount">$0</p>
                    <p class="text-sm flex items-center mt-2">
                        <span class="trend-up flex items-center" id="advanceTrend">
                            <i class="fas fa-arrow-up mr-1"></i> 0%
                        </span>
                        <span class="text-gray-500 ml-1">vs previous period</span>
                    </p>
                </div>
                <div class="card-icon bg-purple-100 text-purple-600">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <!-- Conversion Rate Card -->
        <div class="dashboard-card bg-white p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="stat-label">Conversion Rate</p>
                    <p class="stat-value" id="conversionRate">0%</p>
                    <p class="text-sm flex items-center mt-2">
                        <span class="trend-up flex items-center" id="conversionTrend">
                            <i class="fas fa-arrow-up mr-1"></i> 0%
                        </span>
                        <span class="text-gray-500 ml-1">vs previous period</span>
                    </p>
                </div>
                <div class="card-icon bg-yellow-100 text-yellow-600">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Area Chart -->
        <div class="chart-container">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Appointment Trends</h3>
            <div id="appointmentTrendsChart" style="width: 100%; height: 350px;"></div>
        </div>

        <!-- Pie Chart -->
        <div class="chart-container">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Appointment Status Distribution</h3>
            <div id="statusDistributionChart" style="width: 100%; height: 350px;"></div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Calendar Chart -->
        <div class="chart-container">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Appointment Calendar Heatmap</h3>
            <div id="calendar_basic" style="width: 100%; height: 350px;"></div>
        </div>

        <!-- Revenue by Service Type -->
        <div class="chart-container">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Revenue by Service Type</h3>
            <div id="revenueByServiceChart" style="width: 100%; height: 350px;"></div>
        </div>
    </div>

    <!-- Recent Appointments Table -->
    <div class="chart-container">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Recent Appointments</h3>
            <a href="{{ route('admin.appointments.index') }}" class="text-indigo-600 hover:text-indigo-800 transition">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="recentAppointmentsTable">
                    <!-- Data will be loaded via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Load Google Charts
    google.charts.load('current', {'packages':['corechart', 'calendar']});
    google.charts.setOnLoadCallback(initCharts);

    // Initialize date inputs with current date range
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const endDateInput = document.getElementById('endDate');
        const startDateInput = document.getElementById('startDate');

        endDateInput.valueAsDate = today;

        // Set start date to beginning of current month
        const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        startDateInput.valueAsDate = startOfMonth;

        // Set active filter button
        document.getElementById('monthBtn').click();

        // Fetch initial data
        fetchDashboardData('month');
    });

    // Filter buttons event listeners
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');

            // Fetch data based on selected range
            const range = this.getAttribute('data-range');
            fetchDashboardData(range);
        });
    });

    // Custom date range button
    document.getElementById('customRangeBtn').addEventListener('click', function() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (startDate && endDate) {
            // Remove active class from all buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            fetchDashboardData('custom', startDate, endDate);
        } else {
            alert('Please select both start and end dates');
        }
    });

    function fetchDashboardData(range, startDate = null, endDate = null) {
        // Prepare the URL with query parameters
        let url = '{{ route("admin.chart.data") }}?range=' + range;

        if (range === 'custom' && startDate && endDate) {
            url += '&start_date=' + startDate + '&end_date=' + endDate;
        }

        // Fetch data from the server
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Update stats cards
                updateStatsCards(data.stats);

                // Update charts
                updateAppointmentTrendsChart(data.appointmentTrends);
                updateStatusDistributionChart(data.statusDistribution);
                updateCalendarChart(data.calendarData);
                updateRevenueByServiceChart(data.revenueByService);

                // Update recent appointments table
                updateRecentAppointmentsTable(data.recentAppointments);
            })
            .catch(error => {
                console.error('Error fetching dashboard data:', error);
            });
    }

    function updateStatsCards(stats) {
        // Update total appointments
        document.getElementById('totalAppointments').textContent = stats.totalAppointments;

        // Update appointment trend
        const appointmentTrendEl = document.getElementById('appointmentTrend');
        appointmentTrendEl.innerHTML = `<i class="fas fa-arrow-${stats.appointmentTrendUp ? 'up' : 'down'} mr-1"></i> ${Math.abs(stats.appointmentTrendPercentage)}%`;
        appointmentTrendEl.className = stats.appointmentTrendUp ? 'trend-up flex items-center' : 'trend-down flex items-center';

        // Update total amount
        document.getElementById('totalAmount').textContent = '$' + stats.totalAmount.toLocaleString();

        // Update amount trend
        const amountTrendEl = document.getElementById('amountTrend');
        amountTrendEl.innerHTML = `<i class="fas fa-arrow-${stats.amountTrendUp ? 'up' : 'down'} mr-1"></i> ${Math.abs(stats.amountTrendPercentage)}%`;
        amountTrendEl.className = stats.amountTrendUp ? 'trend-up flex items-center' : 'trend-down flex items-center';

        // Update advance amount
        document.getElementById('advanceAmount').textContent = '$' + stats.advanceAmount.toLocaleString();

        // Update advance trend
        const advanceTrendEl = document.getElementById('advanceTrend');
        advanceTrendEl.innerHTML = `<i class="fas fa-arrow-${stats.advanceTrendUp ? 'up' : 'down'} mr-1"></i> ${Math.abs(stats.advanceTrendPercentage)}%`;
        advanceTrendEl.className = stats.advanceTrendUp ? 'trend-up flex items-center' : 'trend-down flex items-center';

        // Update conversion rate
        document.getElementById('conversionRate').textContent = stats.conversionRate + '%';

        // Update conversion trend
        const conversionTrendEl = document.getElementById('conversionTrend');
        conversionTrendEl.innerHTML = `<i class="fas fa-arrow-${stats.conversionTrendUp ? 'up' : 'down'} mr-1"></i> ${Math.abs(stats.conversionTrendPercentage)}%`;
        conversionTrendEl.className = stats.conversionTrendUp ? 'trend-up flex items-center' : 'trend-down flex items-center';
    }

    function initCharts() {
        // Initialize empty charts (they will be populated with data later)
        initAppointmentTrendsChart();
        initStatusDistributionChart();
        initCalendarChart();
        initRevenueByServiceChart();
    }

    function initAppointmentTrendsChart() {
        const data = google.visualization.arrayToDataTable([
            ['Period', 'Appointments', 'Revenue'],
            ['Initial', 0, 0]
        ]);

        const options = {
            title: '',
            hAxis: {title: 'Period', titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            chartArea: {width: '80%', height: '70%'},
            colors: ['#4f46e5', '#10b981'],
            legend: {position: 'top'},
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        const chart = new google.visualization.AreaChart(document.getElementById('appointmentTrendsChart'));
        chart.draw(data, options);

        // Store chart instance for later updates
        window.appointmentTrendsChart = chart;
        window.appointmentTrendsChartOptions = options;
    }

    function updateAppointmentTrendsChart(trendsData) {
        const data = google.visualization.arrayToDataTable(trendsData);
        window.appointmentTrendsChart.draw(data, window.appointmentTrendsChartOptions);
    }

    function initStatusDistributionChart() {
        const data = google.visualization.arrayToDataTable([
            ['Status', 'Count'],
            ['No Data', 1]
        ]);

        const options = {
            title: '',
            chartArea: {width: '90%', height: '80%'},
            colors: ['#4f46e5', '#10b981', '#ef4444', '#f59e0b'],
            legend: {position: 'right'},
            pieHole: 0.4,
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        const chart = new google.visualization.PieChart(document.getElementById('statusDistributionChart'));
        chart.draw(data, options);

        // Store chart instance for later updates
        window.statusDistributionChart = chart;
        window.statusDistributionChartOptions = options;
    }

    function updateStatusDistributionChart(distributionData) {
        const data = google.visualization.arrayToDataTable(distributionData);
        window.statusDistributionChart.draw(data, window.statusDistributionChartOptions);
    }

    function initCalendarChart() {
        const dataTable = new google.visualization.DataTable();
        dataTable.addColumn({ type: 'date', id: 'Date' });
        dataTable.addColumn({ type: 'number', id: 'Appointments' });
        dataTable.addRows([
            [new Date(), 0]
        ]);

        const options = {
            title: '',
            height: 350,
            calendar: {
                cellSize: 13,
                monthLabel: {
                    fontName: 'Arial',
                    fontSize: 12,
                    color: '#333',
                    bold: true
                },
                yearLabel: {
                    fontName: 'Arial',
                    fontSize: 14,
                    color: '#333',
                    bold: true
                }
            },
            colorAxis: {
                colors: ['#e5e7eb', '#4f46e5']
            }
        };

        const chart = new google.visualization.Calendar(document.getElementById('calendarChart'));
        chart.draw(dataTable, options);

        // Store chart instance for later updates
        window.calendarChart = chart;
        window.calendarChartOptions = options;
    }

    function updateCalendarChart(calendarData) {
        const dataTable = new google.visualization.DataTable();
        dataTable.addColumn({ type: 'date', id: 'Date' });
        dataTable.addColumn({ type: 'number', id: 'Appointments' });

        // Convert string dates to Date objects
        const rows = calendarData.map(item => {
            return [new Date(item[0]), item[1]];
        });

        dataTable.addRows(rows);
        window.calendarChart.draw(dataTable, window.calendarChartOptions);
    }

    function initRevenueByServiceChart() {
        const data = google.visualization.arrayToDataTable([
            ['Service', 'Revenue'],
            ['No Data', 1]
        ]);

        const options = {
            title: '',
            chartArea: {width: '80%', height: '70%'},
            legend: {position: 'right'},
            colors: ['#4f46e5', '#10b981', '#ef4444', '#f59e0b', '#8b5cf6', '#ec4899'],
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        const chart = new google.visualization.PieChart(document.getElementById('revenueByServiceChart'));
        chart.draw(data, options);

        // Store chart instance for later updates
        window.revenueByServiceChart = chart;
        window.revenueByServiceChartOptions = options;
    }

    function updateRevenueByServiceChart(revenueData) {
        const data = google.visualization.arrayToDataTable(revenueData);
        window.revenueByServiceChart.draw(data, window.revenueByServiceChartOptions);
    }

    function updateRecentAppointmentsTable(appointments) {
        const tableBody = document.getElementById('recentAppointmentsTable');
        tableBody.innerHTML = '';

        if (appointments.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td colspan="5" class="py-4 px-4 text-center text-gray-500">No recent appointments found</td>
            `;
            tableBody.appendChild(row);
            return;
        }

        appointments.forEach(appointment => {
            const row = document.createElement('tr');

            // Determine status badge color
            let statusBadgeClass = '';
            switch (appointment.status.toLowerCase()) {
                case 'confirmed':
                    statusBadgeClass = 'bg-green-100 text-green-800';
                    break;
                case 'pending':
                    statusBadgeClass = 'bg-yellow-100 text-yellow-800';
                    break;
                case 'cancelled':
                    statusBadgeClass = 'bg-red-100 text-red-800';
                    break;
                default:
                    statusBadgeClass = 'bg-gray-100 text-gray-800';
            }

            row.innerHTML = `
                <td class="py-3 px-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-gray-500 font-medium">${appointment.patient_name.charAt(0)}</span>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${appointment.patient_name}</div>
                            <div class="text-sm text-gray-500">${appointment.patient_email || 'No email'}</div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${appointment.appointment_date}</div>
                    <div class="text-sm text-gray-500">${appointment.appointment_time}</div>
                </td>
                <td class="py-3 px-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusBadgeClass}">
                        ${appointment.status}
                    </span>
                </td>
                <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-900">
                    $${appointment.amount ? appointment.amount.toLocaleString() : '0'}
                </td>
                <td class="py-3 px-4 whitespace-nowrap text-sm font-medium">
                    <a href="${appointment.view_url}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                    ${appointment.status.toLowerCase() === 'pending' ?
                        `<a href="${appointment.confirm_url}" class="text-green-600 hover:text-green-900 mr-3">Confirm</a>` : ''}
                    ${appointment.status.toLowerCase() !== 'cancelled' ?
                        `<a href="${appointment.cancel_url}" class="text-red-600 hover:text-red-900">Cancel</a>` : ''}
                </td>
            `;

            tableBody.appendChild(row);
        });
    }
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:["calendar"]});
  google.charts.setOnLoadCallback(drawChart);

function drawChart() {
   var dataTable = new google.visualization.DataTable();
   dataTable.addColumn({ type: 'date', id: 'Date' });
   dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
   dataTable.addRows([
      [ new Date(2012, 3, 13), 37032 ],
      [ new Date(2012, 3, 14), 38024 ],
      [ new Date(2012, 3, 15), 38024 ],
      [ new Date(2012, 3, 16), 38108 ],
      [ new Date(2012, 3, 17), 38229 ],
      // Many rows omitted for brevity.
      [ new Date(2013, 9, 4), 38177 ],
      [ new Date(2013, 9, 5), 38705 ],
      [ new Date(2013, 9, 12), 38210 ],
      [ new Date(2013, 9, 13), 38029 ],
      [ new Date(2013, 9, 19), 38823 ],
      [ new Date(2013, 9, 23), 38345 ],
      [ new Date(2013, 9, 24), 38436 ],
      [ new Date(2013, 9, 30), 38447 ]
    ]);

   var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

   var options = {
     title: "Red Sox Attendance",
     height: 350,
   };

   chart.draw(dataTable, options);
}
</script>
@endsection
