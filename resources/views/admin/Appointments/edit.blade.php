@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i> Edit Appointment
                </h5>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left me-1"></i> Back to Appointments
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="patient_name" class="form-label">Patient Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="patient_name" value="{{ $appointment->patient->name }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="visitDate" class="form-label">Appointment Date <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control @error('visitDate') is-invalid @enderror"
                                       id="visitDate" name="visitDate"
                                       value="{{ old('visitDate', $appointment->visitDate) }}" required>
                            </div>
                            @error('visitDate')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="totalAmount" class="form-label">Total Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                <input type="number" class="form-control @error('totalAmount') is-invalid @enderror"
                                       id="totalAmount" name="totalAmount"
                                       value="{{ old('totalAmount', $appointment->totalAmount) }}" required>
                            </div>
                            @error('totalAmount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="advanceAmount" class="form-label">Advance Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                <input type="number" class="form-control @error('advanceAmount') is-invalid @enderror"
                                       id="advanceAmount" name="advanceAmount"
                                       value="{{ old('advanceAmount', $appointment->advanceAmount) }}" required>
                            </div>
                            @error('advanceAmount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="otherNote" class="form-label">Notes</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                <textarea class="form-control @error('otherNote') is-invalid @enderror"
                                          id="otherNote" name="otherNote" rows="4">{{ old('otherNote', $appointment->otherNote) }}</textarea>
                            </div>
                            @error('otherNote')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Treatment Information</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($appointment->invoiceTreatment as $treatment)
                                        <li class="list-group-item">
                                            <i class="fas fa-tooth text-primary me-2"></i> {{ $treatment->treatMent }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @if(strpos(strtolower($appointment->otherNote ?? ''), 'booked by user') !== false)
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Note:</strong> This appointment was booked by the patient through the user portal. Any changes will be visible to the patient.
                </div>
                @endif

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    // Ensure advance amount doesn't exceed total amount
    document.getElementById('advanceAmount').addEventListener('input', function() {
        const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
        const advanceAmount = parseFloat(this.value) || 0;

        if (advanceAmount > totalAmount) {
            this.value = totalAmount;
        }
    });

    document.getElementById('totalAmount').addEventListener('input', function() {
        const totalAmount = parseFloat(this.value) || 0;
        const advanceAmount = parseFloat(document.getElementById('advanceAmount').value) || 0;

        if (advanceAmount > totalAmount) {
            document.getElementById('advanceAmount').value = totalAmount;
        }
    });
</script>
@endsection
