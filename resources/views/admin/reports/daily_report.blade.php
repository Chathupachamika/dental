<!DOCTYPE html>
<html>
<head>
    <title>Daily Report - {{ $date }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2563eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8fafc;
        }
        .summary-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .total {
            font-weight: bold;
            color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Daily Report</h2>
        <p>Date: {{ $date }}</p>
    </div>

    <div class="summary-box">
        <div class="section-title">Summary</div>
        <p>Total Appointments: {{ $appointments->count() }}</p>
        <p>New Patients: {{ $patients->count() }}</p>
        <p>Total Revenue: Rs.{{ number_format($total_revenue, 2) }}</p>
        <p>Pending Payments: Rs.{{ number_format($pending_payments, 2) }}</p>
    </div>

    @if($appointments->count() > 0)
    <div class="section">
        <div class="section-title">Today's Appointments</div>
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Treatment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ Carbon\Carbon::parse($appointment['time'])->format('h:i A') }}</td>
                    <td>{{ $appointment['patient']->name ?? 'N/A' }}</td>
                    <td>{{ $appointment['treatment'] ?? 'N/A' }}</td>
                    <td>{{ ucfirst($appointment['status']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($invoices->count() > 0)
    <div class="section">
        <div class="section-title">Today's Invoices</div>
        <table>
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Patient</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>#{{ $invoice->id }}</td>
                    <td>{{ $invoice->patient->name ?? 'N/A' }}</td>
                    <td>Rs.{{ number_format($invoice->totalAmount, 2) }}</td>
                    <td>{{ $invoice->totalAmount <= $invoice->advanceAmount ? 'Paid' : 'Pending' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>
</html>
