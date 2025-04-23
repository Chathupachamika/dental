@extends('layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Invoice</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="20%">Field Name</th>
                        <th width="80%"> Value</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Name:</td>
                        <td> {{ $invoice->patient->name }}</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td> {{ $invoice->patient->address }}</td>
                    </tr>
                    <tr>
                        <td>Age:</td>
                        <td> {{ $invoice->patient->age }}</td>
                    </tr>
                    <tr>
                        <td>Mobile Number:</td>
                        <td> {{ $invoice->patient->mobileNumber }}</td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td> {{ $invoice->patient->gender }}</td>
                    </tr>
                    <tr>
                        <td>NIC:</td>
                        <td> {{ $invoice->patient->nic }}</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;" class="table table-stripped ">
                <tr>
                    <td>Treatment</td>
                    <td>Other Notes</td>
                    <td>Created Date</td>
                    <td>Next Visit Date </td>
                    <td>Total Amount </td>
                    <td>Advance Amount </td>
                    <td>Balance</td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            @foreach ($invoice->invoiceTreatment as $treat)
                            <li>{{ $treat->treatMent }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $invoice->otherNote }}</td>
                    <td>{{$invoice->created_at->format("m/d/Y")}}
                    </td>
                    <td>{{ $invoice->visitDate }}</td>
                    <td>{{ $invoice->totalAmount }}</td>
                    <td>{{ $invoice->advanceAmount }}</td>
                    <td>{{ floatval($invoice->totalAmount) - floatval($invoice->advanceAmount) }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection