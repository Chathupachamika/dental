<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        /* Modern Professional Styles */
        body {
            font-family: 'Inter', 'Helvetica Neue', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #334155;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            min-height: 1123px; /* A4 height */
            position: relative;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Modern Attractive Header */
        .header {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            padding: 30px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
            transform: translate(30%, -30%);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .clinic-logo {
            font-size: 28px;
            font-weight: 900;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .clinic-tagline {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .clinic-details {
            font-size: 12px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: 800;
            text-align: right;
            letter-spacing: 1px;
        }

        .invoice-id {
            font-size: 16px;
            text-align: right;
            margin-top: 5px;
            font-weight: 600;
        }

        .invoice-date {
            font-size: 14px;
            text-align: right;
            margin-top: 5px;
            opacity: 0.9;
        }

        /* Information Sections */
        .info-section {
            padding: 30px;
        }

        .info-grid {
            display: flex;
            gap: 30px;
        }

        .info-box {
            flex: 1;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: #0369a1;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #0ea5e9;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title svg {
            width: 18px;
            height: 18px;
        }

        .info-item {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            width: 100px;
            color: #475569;
        }

        .info-value {
            flex: 1;
        }

        /* Payment Summary */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px 0;
        }

        .summary-table .label {
            font-weight: 600;
            color: #475569;
        }

        .summary-table .value {
            text-align: right;
            font-weight: 500;
        }

        .summary-table .total-row {
            font-weight: 700;
            font-size: 14px;
            color: #0369a1;
            border-top: 1px solid #e5e7eb;
        }

        .summary-table .total-row td {
            padding-top: 12px;
        }

        .payment-status {
            display: flex;
            align-items: center;
            margin-top: 15px;
            justify-content: flex-end;
            gap: 10px;
        }

        .status-label {
            font-weight: 600;
            color: #475569;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-paid {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .badge-partial {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .badge-unpaid {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Treatment Table */
        .treatment-section {
            padding: 0 30px 30px 30px;
        }

        .treatment-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .treatment-table th {
            background: #f1f5f9;
            color: #0369a1;
            font-weight: 600;
            text-transform: uppercase;
            padding: 12px 15px;
            font-size: 12px;
            letter-spacing: 0.5px;
            text-align: left;
            border-bottom: 2px solid #0ea5e9;
        }

        .treatment-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
            color: #475569;
        }

        .treatment-table tr:last-child td {
            border-bottom: none;
        }

        /* Notes Section */
        .notes-section {
            padding: 0 30px 30px 30px;
        }

        .notes-content {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            color: #475569;
            font-style: italic;
        }

        /* Next Appointment */
        .next-appointment {
            margin-top: 20px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 15px;
            color: #0369a1;
        }

        .next-appointment-title {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 14px;
        }

        /* Footer */
        .footer {
            margin-top: auto;
            padding: 20px 30px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
            text-align: center;
        }

        .payment-info {
            margin-bottom: 15px;
        }

        .payment-title {
            font-weight: 700;
            margin-bottom: 5px;
            color: #0369a1;
        }

        .thank-you {
            font-size: 18px;
            color: #0369a1;
            font-weight: 700;
            margin: 15px 0;
            letter-spacing: 1px;
        }

        /* Watermark for paid invoices */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(3, 105, 161, 0.07);
            font-weight: 900;
            pointer-events: none;
            z-index: 1;
        }

        /* Print Optimizations */
        @media print {
            body {
                background: #ffffff;
            }

            .invoice-container {
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Watermark for paid invoices -->
        @if($invoice->totalAmount == $invoice->advanceAmount)
        <div class="watermark">PAID</div>
        @endif

        <!-- Modern Header -->
        <div class="header">
            <div class="header-content">
                <div>
                    <div class="clinic-logo">DENTAL CLINIC</div>
                    <div class="clinic-tagline">Excellence in Dental Care</div>
                    <div class="clinic-details">
                        123 Dental Avenue, Medical District<br>
                        City, State, ZIP 12345<br>
                        Phone: (123) 456-7890<br>
                        Email: care@dentalclinic.com
                    </div>
                </div>
                <div>
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-id">#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="invoice-date">{{ date('F d, Y', strtotime($invoice->created_at)) }}</div>
                </div>
            </div>
        </div>

        <!-- Patient and Payment Information Side by Side -->
        <div class="info-section">
            <div class="info-grid">
                <!-- Patient Information (Left Side) -->
                <div class="info-box">
                    <div class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Patient Information
                    </div>
                    <div class="info-item">
                        <div class="info-label">Name:</div>
                        <div class="info-value">{{ $invoice->patient->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Age:</div>
                        <div class="info-value">{{ $invoice->patient->age }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Gender:</div>
                        <div class="info-value">{{ $invoice->patient->gender }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Address:</div>
                        <div class="info-value">{{ $invoice->patient->address }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Mobile:</div>
                        <div class="info-value">{{ $invoice->patient->mobileNumber }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">NIC:</div>
                        <div class="info-value">{{ $invoice->patient->nic }}</div>
                    </div>
                </div>

                <!-- Payment Summary (Right Side) -->
                <div class="info-box">
                    <div class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        Financial Summary
                    </div>
                    <table class="summary-table">
                        <tr>
                            <td class="label">Total Amount:</td>
                            <td class="value">Rs {{ number_format($invoice->totalAmount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="label">Advance Paid:</td>
                            <td class="value">Rs {{ number_format($invoice->advanceAmount, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td class="label">Balance Due:</td>
                            <td class="value">Rs {{ number_format($invoice->totalAmount - $invoice->advanceAmount, 2) }}</td>
                        </tr>
                    </table>
                    <div class="payment-status">
                        <div class="status-label">Status:</div>
                        @if($invoice->totalAmount == $invoice->advanceAmount)
                            <span class="badge badge-paid">PAID</span>
                        @elseif($invoice->advanceAmount > 0)
                            <span class="badge badge-partial">PARTIAL</span>
                        @else
                            <span class="badge badge-unpaid">UNPAID</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Treatment Details -->
        <div class="treatment-section">
            <div class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                </svg>
                Treatment Details
            </div>
            <table class="treatment-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Treatment</th>
                        <th style="width: 30%;">Subtype</th>
                        <th style="width: 30%;">Position</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoiceTreatment as $treatment)
                    <tr>
                        <td>{{ $treatment->treatMent }}</td>
                        <td>{{ $treatment->subCategoryOne->name ?? '—' }}</td>
                        <td>{{ $treatment->subCategoryTwo->name ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Notes Section (if available) -->
        @if($invoice->otherNote)
        <div class="notes-section">
            <div class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                Notes
            </div>
            <div class="notes-content">
                {{ $invoice->otherNote }}
            </div>
        </div>
        @endif

        <!-- Next Appointment (if available) -->
        @if($invoice->visitDate)
        <div class="notes-section">
            <div class="next-appointment">
                <div class="next-appointment-title">Next Appointment</div>
                <div>{{ date('l, F d, Y', strtotime($invoice->visitDate)) }}</div>
                <div style="font-size: 11px; margin-top: 6px; opacity: 0.8;">
                    Please arrive 10 minutes early for your appointment.
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div class="payment-info">
                <div class="payment-title">Payment Instructions</div>
                <div>Bank: National Bank | Account: Dental Clinic</div>
                <div>Account Number: 1234-5678-9012-3456</div>
            </div>
            <div class="thank-you">Thank You for Choosing Us!</div>
            <div>
                Payments are due within 30 days. Please include invoice number with payment.<br>
                © {{ date('Y') }} Dental Clinic. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
