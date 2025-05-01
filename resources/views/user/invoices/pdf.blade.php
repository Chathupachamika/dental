<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        @page {
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica', Arial, sans-serif;
        }

        body {
            color: #333;
            line-height: 1.6;
            font-size: 14px;
            background-color: #f9fafc;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .invoice-header {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .invoice-subtitle {
            font-size: 16px;
            opacity: 0.8;
            margin-top: 5px;
        }

        .invoice-id {
            font-size: 18px;
            font-weight: 600;
            margin-top: 15px;
            display: inline-block;
            padding: 8px 20px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 30px;
        }

        .invoice-body {
            padding: 40px;
        }

        .invoice-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 18px;
            color: #0ea5e9;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
        }

        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: 600;
            color: #6b7280;
            padding: 10px 0;
            width: 40%;
        }

        .info-value {
            display: table-cell;
            color: #111827;
            padding: 10px 0;
        }

        .amount-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .amount-table th {
            background-color: #f3f4f6;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .amount-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .amount-table tr:last-child td {
            border-bottom: none;
        }

        .amount-label {
            color: #6b7280;
        }

        .amount-value {
            text-align: right;
            font-weight: 600;
            color: #111827;
        }

        .total-row td {
            padding-top: 20px;
            border-top: 2px solid #0ea5e9;
            border-bottom: none;
        }

        .total-label {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .total-value {
            font-size: 16px;
            font-weight: 700;
            color: #0ea5e9;
        }

        .status-section {
            margin-top: 40px;
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-paid {
            background-color: #dcfce7;
            color: #166534;
            border: 2px solid #86efac;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
            border: 2px solid #fcd34d;
        }

        .invoice-footer {
            background-color: #f3f4f6;
            padding: 30px 40px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            border-top: 1px solid #e5e7eb;
        }

        .footer-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .payment-methods {
            margin-top: 15px;
        }

        .payment-method {
            display: inline-block;
            margin: 0 10px;
            font-weight: 600;
            color: #0ea5e9;
        }

        .thank-you {
            margin-top: 30px;
            font-size: 16px;
            color: #0ea5e9;
            font-weight: 600;
        }

        .clinic-info {
            margin-top: 20px;
            font-style: italic;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(14, 165, 233, 0.05);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 10px;
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Watermark for paid invoices -->
        @if($invoice->totalAmount <= $invoice->advanceAmount)
            <div class="watermark">PAID</div>
        @endif

        <div class="invoice-header">
            <h1 class="invoice-title">Invoice</h1>
            <div class="invoice-subtitle">Dental Management System</div>
            <div class="invoice-id">INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>

        <div class="invoice-body">
            <div class="invoice-section">
                <h2 class="section-title">Invoice Details</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Invoice Number:</div>
                        <div class="info-value">INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Invoice Date:</div>
                        <div class="info-value">{{ $invoice->created_at->format('F d, Y') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Due Date:</div>
                        <div class="info-value">{{ $invoice->created_at->addDays(30)->format('F d, Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="invoice-section">
                <h2 class="section-title">Patient Information</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Patient Name:</div>
                        <div class="info-value">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Patient ID:</div>
                        <div class="info-value">PT-{{ str_pad(auth()->id(), 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="invoice-section">
                <h2 class="section-title">Payment Summary</h2>
                <table class="amount-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="amount-label">Total Treatment Cost</td>
                            <td class="amount-value">${{ number_format($invoice->totalAmount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="amount-label">Amount Paid</td>
                            <td class="amount-value">${{ number_format($invoice->advanceAmount, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td class="total-label">Balance Due</td>
                            <td class="total-value">${{ number_format($invoice->totalAmount - $invoice->advanceAmount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="status-section">
                    <div class="status-badge {{ $invoice->totalAmount <= $invoice->advanceAmount ? 'status-paid' : 'status-pending' }}">
                        {{ $invoice->totalAmount <= $invoice->advanceAmount ? 'PAID IN FULL' : 'PAYMENT PENDING' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="invoice-footer">
            <div class="footer-title">Payment Information</div>
            <p>Please make payment within 30 days of invoice date.</p>

            <div class="payment-methods">
                <span class="payment-method">Credit Card</span> |
                <span class="payment-method">Bank Transfer</span> |
                <span class="payment-method">Cash</span>
            </div>

            <div class="thank-you">Thank you for choosing our dental services!</div>

            <div class="clinic-info">
                Dental Management Clinic<br>
                123 Dental Street, Suite 100<br>
                Dental City, DC 12345<br>
                Phone: (123) 456-7890<br>
                Email: info@dentalmanagement.com
            </div>
        </div>
    </div>
</body>
</html>
