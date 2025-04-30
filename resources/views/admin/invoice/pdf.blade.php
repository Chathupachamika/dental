<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .patient-info, .financial-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice #{{ $invoice->id }}</h1>
    </div>

    <div class="patient-info">
        <h3>Patient Information</h3>
        <p>Name: {{ $invoice->patient->name }}</p>
        <p>Age: {{ $invoice->patient->age }}</p>
        <p>Gender: {{ $invoice->patient->gender }}</p>
        <p>Address: {{ $invoice->patient->address }}</p>
        <p>Mobile: {{ $invoice->patient->mobileNumber }}</p>
        <p>NIC: {{ $invoice->patient->nic }}</p>
    </div>

    <div class="financial-info">
        <h3>Financial Summary</h3>
        <p>Total Amount: Rs {{ number_format($invoice->totalAmount, 2) }}</p>
        <p>Advance Paid: Rs {{ number_format($invoice->advanceAmount, 2) }}</p>
        <p>Balance Due: Rs {{ number_format($invoice->totalAmount - $invoice->advanceAmount, 2) }}</p>
    </div>

    <h3>Treatment Details</h3>
    <table>
        <thead>
            <tr>
                <th>Treatment</th>
                <th>Subtype</th>
                <th>Position</th>
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
</body>
</html>
