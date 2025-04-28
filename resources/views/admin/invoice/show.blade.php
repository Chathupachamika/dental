@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-file-invoice-dollar text-primary me-2"></i> Invoice #{{ $invoice->id }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control" value="{{ $invoice->patient->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Age:</label>
                        <input type="text" class="form-control" value="{{ $invoice->patient->age }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender:</label>
                        <input type="text" class="form-control" value="{{ $invoice->patient->gender }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Address:</label>
                        <textarea class="form-control" readonly>{{ $invoice->patient->address }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mobile:</label>
                        <input type="text" class="form-control" value="{{ $invoice->patient->mobileNumber }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIC:</label>
                        <input type="text" class="form-control" value="{{ $invoice->patient->nic }}" readonly>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Treatments:</label>
                <ul>
                    @foreach($invoice->invoiceTreatment as $treatment)
                        <li>
                            {{ $treatment->treatMent }}
                            @if($treatment->subType)
                                - {{ $treatment->subType }}
                            @endif
                            @if($treatment->position)
                                - {{ $treatment->position }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-3">
                <label class="form-label">Other Note:</label>
                <textarea class="form-control" readonly>{{ $invoice->otherNote }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Next Visit Date:</label>
                <input type="text" class="form-control" value="{{ $invoice->visitDate }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Total:</label>
                <input type="text" class="form-control" value="{{ $invoice->totalAmount }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Advance:</label>
                <input type="text" class="form-control" value="{{ $invoice->advanceAmount }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Balance:</label>
                <input type="text" class="form-control" value="{{ $invoice->totalAmount - $invoice->advanceAmount }}" readonly>
            </div>

            <div class="text-end">
                <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
