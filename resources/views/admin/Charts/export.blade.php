<!DOCTYPE html>
<html>
<head>
    <title>Analytics Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .summary-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .stat-item {
            padding: 10px;
            background: #f8f9fa;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #0066cc;
        }
        .chart-container {
            margin: 20px 0;
            page-break-inside: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Analytics Report</h1>
        <p>Generated on: {{ $exportDate }}</p>
    </div>

    <div class="summary-box">
        <h2>Summary Statistics</h2>
        <div class="summary-grid">
            <div class="stat-item">
                <div class="stat-value">{{ number_format($totalAppointments) }}</div>
                <div>Total Appointments</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ number_format($totalPatients) }}</div>
                <div>Total Patients</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">Rs.{{ number_format($totalAmount, 2) }}</div>
                <div>Total Revenue</div>
            </div>
        </div>
    </div>

    <div class="chart-container">
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
                @foreach($recentInvoices as $invoice)
                <tr>
                    <td>#{{ $invoice->id }}</td>
                    <td>{{ $invoice->patient->name }}</td>
                    <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                    <td>Rs.{{ number_format($invoice->totalAmount, 2) }}</td>
                    <td>{{ ucfirst($invoice->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>This report is system generated</p>
        <p>© {{ date('Y') }} Dental Management System</p>
    </div>
</body>
</html>
