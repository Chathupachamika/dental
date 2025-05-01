<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .stats-grid { margin-bottom: 30px; }
        .stats-item { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dental Management Analytics Report</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stats-item">
            <h3>Appointments Summary</h3>
            <p>Total Appointments: {{ $appointments->sum('total') }}</p>
            @foreach($appointments as $stat)
                <p>{{ ucfirst($stat->status) }}: {{ $stat->total }}</p>
            @endforeach
        </div>

        <div class="stats-item">
            <h3>Financial Summary</h3>
            <p>Total Revenue: ${{ number_format($revenue->total, 2) }}</p>
            <p>Total Advance: ${{ number_format($revenue->advance, 2) }}</p>
        </div>

        <div class="stats-item">
            <h3>Patient Statistics</h3>
            <p>Total Patients: {{ number_format($patients) }}</p>
        </div>
    </div>

    <h3>Recent Invoices</h3>
    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>#{{ $invoice->id }}</td>
                <td>{{ $invoice->patient->name }}</td>
                <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                <td>${{ number_format($invoice->totalAmount, 2) }}</td>
                <td>{{ ucfirst($invoice->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
