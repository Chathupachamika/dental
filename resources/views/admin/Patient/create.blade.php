@extends('layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create Patient</h4>
            <div class="">
                <form action="\createPatient" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name='name' id="name" value="{{old('name')}}" placeholder="Name">
                            @if($errors->any('name'))
                            <span class="text-danger"> {{$errors->first('name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="address" value="{{old('address')}}" name="address" placeholder="Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="age" class="col-sm-3 col-form-label">Age</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="age"value="{{old('age')}}" name="age" placeholder="Age">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="mobile" value="{{old('mobileNumber')}}" name="mobileNumber" placeholder="Mobile">
                            @if($errors->any('mobile'))
                            <span class="text-danger"> {{$errors->first('mobile')}}</span>
                            @endif
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="gender" name="gender">
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nic" class="col-sm-3 col-form-label">Nic</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{old('nic')}}" id="nic" name="nic" placeholder="Nic">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection