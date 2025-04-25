@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-invoice me-2"></i> Invoice #{{ $invoice->id }}
                </h5>
                <div>
                    <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                    <button onclick="window.print()" class="btn btn-sm btn-light ms-2">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-user-circle me-2 text-primary"></i> Patient Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Name</label>
                                    <p class="fw-medium">{{ $invoice->patient->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Age</label>
                                    <p class="fw-medium">{{ $invoice->patient->age }} years</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Gender</label>
                                    <p class="fw-medium">{{ $invoice->patient->gender }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Mobile Number</label>
                                    <p class="fw-medium">{{ $invoice->patient->mobileNumber }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">NIC</label>
                                    <p class="fw-medium">{{ $invoice->patient->nic }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Address</label>
                                    <p class="fw-medium">{{ $invoice->patient->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-clipboard-list me-2 text-primary"></i> Treatment Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Treatment</label>
                                <ul class="list-group">
                                    @foreach ($invoice->invoiceTreatment as $treat)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $treat->treatMent }}
                                            @if(isset($treat->amount))
                                                <span class="badge bg-primary rounded-pill">₹{{ number_format($treat->amount, 2) }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Created Date</label>
                                    <p class="fw-medium">{{$invoice->created_at->format("M d, Y")}}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Next Visit</label>
                                    <p class="fw-medium">{{ $invoice->visitDate }}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted">Other Notes</label>
                                    <p class="fw-medium">{{ $invoice->otherNote ?: 'No notes' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-money-bill-wave me-2 text-primary"></i> Payment Summary
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted mb-2">Total Amount</h6>
                                            <h3 class="mb-0">₹{{ number_format($invoice->totalAmount, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-success bg-opacity-10">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted mb-2">Advance Paid</h6>
                                            <h3 class="text-success mb-0">₹{{ number_format($invoice->advanceAmount, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning bg-opacity-10">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted mb-2">Balance</h6>
                                            <h3 class="text-warning mb-0">₹{{ number_format(floatval($invoice->totalAmount) - floatval($invoice->advanceAmount), 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-outline-primary me-2">
                                            <i class="fas fa-edit me-1"></i> Edit Invoice
                                        </button>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-money-bill-wave me-1"></i> Record Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
