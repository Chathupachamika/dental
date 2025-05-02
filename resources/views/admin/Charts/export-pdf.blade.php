<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Dental Analytics Report</title>
    <style>
        /* Reset and Base Styles */
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #1e293b;
            font-size: 12px;
            line-height: 1.5;
        }
        // ...existing code for CSS styles...
        .page-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1 class="report-title">Dental Analytics Report</h1>
            <p class="report-subtitle">Comprehensive overview of clinic performance</p>
            <p class="report-date">Generated on: {{ now()->format('F d, Y') }}</p>
        </div>

        <!-- Key Statistics -->
        <div class="stats-section">
            <h2 class="section-title">Key Statistics</h2>
            <div class="stats-grid">
                // ...existing code for stats grid...
            </div>
        </div>

        <!-- Appointment Statistics -->
        <div class="stats-section">
            <h2 class="section-title">Appointment Statistics</h2>
            <div class="stats-grid">
                @php
                    $totalAppointments = $appointments->sum('total');
                    $pendingCount = $appointments->where('status', 'pending')->first()->total ?? 0;
                    $confirmedCount = $appointments->where('status', 'confirmed')->first()->total ?? 0;
                    $cancelledCount = $appointments->where('status', 'cancelled')->first()->total ?? 0;
                @endphp
                // ...existing code for appointment stats...
            </div>
        </div>

        <!-- Appointment Distribution -->
        <div class="stats-section">
            <h2 class="section-title">Appointment Status Distribution</h2>
            <table>
                // ...existing code for appointment distribution table...
            </table>
        </div>

        <!-- Recent Invoices -->
        <div class="table-section">
            <h2 class="section-title">Recent Invoices</h2>
            <table>
                // ...existing code for recent invoices table...
            </table>
        </div>

        <!-- Financial Summary -->
        <div class="stats-section">
            <h2 class="section-title">Financial Summary</h2>
            <table>
                // ...existing code for financial summary table...
            </table>
        </div>

        <!-- Footer -->
        <div class="page-footer">
            <p class="mb-0">© {{ date('Y') }} Dental Management System. All rights reserved.</p>
            <p class="mb-0">This report is generated automatically and is confidential.</p>
        </div>
    </div>
</body>
</html>
