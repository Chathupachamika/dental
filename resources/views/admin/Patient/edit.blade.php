@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i> Edit Patient
                </h5>
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.patient.update') }}" method="POST">
                @csrf
                <input type="hidden" name='id' value="{{$patient->id}}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Patient Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control @if($errors->any('name')) is-invalid @endif" id="name" name="name" value="{{$patient->name}}" placeholder="Enter patient name" required>
                            </div>
                            @if($errors->any('name'))
                                <div class="invalid-feedback d-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" class="form-control" id="address" name="address" value="{{$patient->address}}" placeholder="Enter address">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="age" class="form-label">Age</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                <input type="number" class="form-control" id="age" name="age" value="{{$patient->age}}" placeholder="Enter age">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                <input type="text" class="form-control @if($errors->any('mobile')) is-invalid @endif" id="mobile" name="mobileNumber" value="{{$patient->mobileNumber}}" placeholder="Enter mobile number" required>
                            </div>
                            @if($errors->any('mobile'))
                                <div class="invalid-feedback d-block">{{$errors->first('mobile')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $patient->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nic" class="form-label">NIC</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" class="form-control" id="nic" name="nic" value="{{$patient->nic}}" placeholder="Enter NIC number">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" onclick="history.back()" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
