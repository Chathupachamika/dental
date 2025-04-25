@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-circle me-2"></i> Patient Details
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-sm btn-light me-2">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-user text-primary me-2"></i> Patient Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Name</label>
                                    <p class="fw-medium">{{ $patient->name }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Address</label>
                                    <p class="fw-medium">{{ $patient->address }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Age</label>
                                    <p class="fw-medium">{{ $patient->age }} years</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Mobile Number</label>
                                    <p class="fw-medium">{{ $patient->mobileNumber }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Gender</label>
                                    <p class="fw-medium">{{ $patient->gender }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">NIC</label>
                                    <p class="fw-medium">{{ $patient->nic }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-file-invoice text-primary me-2"></i> Treatment & Invoice History
                                </h6>
                                <a href="/createInvoice/{{$patient->id}}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus me-1"></i> New Invoice
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($patient->invoice))
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Treatment</th>
                                                <th>Other Notes</th>
                                                <th>Created Date</th>
                                                <th>Next Visit</th>
                                                <th>Total Amount</th>
                                                <th>Advance</th>
                                                <th>Balance</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($patient->invoice as $place)
                                            <tr>
                                                <td>
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($place->invoiceTreatment as $treat)
                                                        <li><i class="fas fa-tooth text-primary me-1"></i> {{$treat->treatMent}}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ $place->otherNote }}</td>
                                                <td>{{$place->created_at->format("m/d/Y")}}</td>
                                                <td>{{ $place->visitDate }}</td>
                                                <td>₹{{ number_format($place->totalAmount, 2) }}</td>
                                                <td>₹{{ number_format($place->advanceAmount, 2) }}</td>
                                                <td>₹{{ number_format($place->totalAmount - $place->advanceAmount, 2) }}</td>
                                                <td>
                                                    @if($place->totalAmount == $place->advanceAmount)
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($place->advanceAmount > 0)
                                                        <span class="badge bg-warning">Partial</span>
                                                    @else
                                                        <span class="badge bg-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            @php
                                                $totalDue = 0;
                                                foreach($patient->invoice as $invoice) {
                                                    $totalDue += ($invoice->totalAmount - $invoice->advanceAmount);
                                                }
                                            @endphp
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">Total Outstanding Balance</h6>
                                                <h4 class="text-danger mb-0">₹{{ number_format($totalDue, 2) }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
                                    <h5>No Invoice Records</h5>
                                    <p class="text-muted">This patient doesn't have any invoice records yet.</p>
                                    <a href="/createInvoice/{{$patient->id}}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Create First Invoice
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
