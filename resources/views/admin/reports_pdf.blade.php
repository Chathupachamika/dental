<!DOCTYPE html>
<html>
<head>
    <title>Reports - {{ $reportType }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
        h1 { color: #EA2F2F; text-align: center; }
        h2 { color: #5E1313; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #EA2F2F; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .date-range { text-align: center; font-style: italic; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>{{ $reportType === 'all' ? 'Full Report' : ucfirst($reportType) . ' Report' }}</h1>
    @if($startDate && $endDate)
        <p class="date-range">Date Range: {{ $startDate }} to {{ $endDate }}</p>
    @endif

    @if(isset($data['total_bookings']))
        <h2>Booking Summary</h2>
        <p>Total Bookings: {{ $data['total_bookings'] }}</p>
        <table>
            <tr><th>Status</th><th>Count</th></tr>
            @foreach($data['booking_statuses'] as $status => $count)
                <tr><td>{{ $status }}</td><td>{{ $count }}</td></tr>
            @endforeach
        </table>
    @endif

    @if(isset($data['total_vehicles']))
        <h2>Vehicle Summary</h2>
        <p>Total Vehicles: {{ $data['total_vehicles'] }} (Available: {{ $data['available_vehicles'] }})</p>
        <table>
            <tr><th>Category</th><th>Count</th></tr>
            @foreach($data['vehicle_categories'] as $category => $count)
                <tr><td>{{ $category }}</td><td>{{ $count }}</td></tr>
            @endforeach
        </table>
    @endif

    @if(isset($data['total_drivers']))
        <h2>Driver Summary</h2>
        <p>Total Drivers: {{ $data['total_drivers'] }} (Available: {{ $data['available_drivers'] }})</p>
    @endif

    @if(isset($data['total_customers']))
        <h2>Customer Summary</h2>
        <p>Total Customers: {{ $data['total_customers'] }}</p>
    @endif

    @if(isset($data['top_vehicles']))
        <h2>Top Vehicles by Bookings</h2>
        <table>
            <tr><th>Vehicle Model</th><th>Bookings</th></tr>
            @foreach($data['top_vehicles'] as $model => $count)
                <tr><td>{{ $model }}</td><td>{{ $count }}</td></tr>
            @endforeach
        </table>
    @endif

    @if(isset($data['revenue_by_category']))
        <h2>Revenue Overview</h2>
        <table>
            <tr><th>Category</th><th>Revenue (LKR)</th></tr>
            @foreach($data['revenue_by_category'] as $category => $revenue)
                <tr><td>{{ $category }}</td><td>{{ number_format($revenue, 2) }}</td></tr>
            @endforeach
        </table>
    @endif
</body>
</html>
