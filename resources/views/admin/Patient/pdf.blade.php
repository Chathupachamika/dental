<!DOCTYPE html>
<html>
<head>
    <title>Patient Details</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .patient-info { margin-bottom: 20px; }
        .patient-info div { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Patient Details</h1>
    </div>

    <div class="patient-info">
        <div><strong>Name:</strong> {{ $patient->name }}</div>
        <div><strong>Address:</strong> {{ $patient->address }}</div>
        <div><strong>Age:</strong> {{ $patient->age }} years</div>
        <div><strong>Mobile:</strong> {{ $patient->mobileNumber }}</div>
        <div><strong>Gender:</strong> {{ $patient->gender }}</div>
        <div><strong>NIC:</strong> {{ $patient->nic }}</div>
        @if(isset($patient->medicalHistory) && $patient->medicalHistory)
        <div><strong>Medical History:</strong> {{ $patient->medicalHistory }}</div>
        @endif
    </div>

    @if(count($patient->invoice))
    <h2>Treatment & Invoice History</h2>
    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Treatment</th>
                <th>Created Date</th>
                <th>Total Amount</th>
                <th>Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patient->invoice as $invoice)
            <tr>
                <td>#{{ $invoice->id }}</td>
                <td>
                    <ul>
                        @foreach($invoice->invoiceTreatment as $treat)
                        <li>{{ $treat->treatMent }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $invoice->created_at->format("m/d/Y") }}</td>
                <td>Rs {{ number_format($invoice->totalAmount, 2) }}</td>
                <td>Rs {{ number_format($invoice->totalAmount - $invoice->advanceAmount, 2) }}</td>
                <td>
                    @if($invoice->totalAmount == $invoice->advanceAmount)
                        Paid
                    @elseif($invoice->advanceAmount > 0)
                        Partial
                    @else
                        Unpaid
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>
</html>
