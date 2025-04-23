
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
                                <td> {{ $patient->name }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td> {{ $patient->address }}</td>
                            </tr>
                            <tr>
                                <td>Age:</td>
                                <td> {{ $patient->age }}</td>
                            </tr>
                            <tr>
                                <td>mobileNumber:</td>
                                <td> {{ $patient->address }}</td>
                            </tr>
                            <tr>
                                <td>Gender:</td>
                                <td> {{ $patient->gender }}</td>
                            </tr>
                            <tr>
                                <td>NIC:</td>
                                <td> {{ $patient->nic }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;" class="table table-stripped ">
                        <tr>
                            <td>Name</td>
                            <td>Treatment</td>
                            <td>Other Notes</td>
                            <td>Created Date</td>
                            <td>Next Visit Date </td>
                            <td>Total Amount </td>
                            <td>Advance Amount </td>

                        </tr>
                        @if(count($patient->invoice))
                        @foreach ($patient->invoice as $place)
                        <tr>
                            <td>{{ $patient->name }}</td>
                            <td>
                                <ul id="list">
                                    @foreach($place->invoiceTreatment as $treat)
                                    <li class="list_item">
                                        {{$treat->treatMent}}
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $place->otherNote }}</td>
                            <td>{{$place->created_at->format("m/d/Y")}}
                            </td>
                            <td>{{ $place->visitDate }}</td>
                            <td>{{ $place->totalAmount }}</td>
                            <td>{{ $place->advanceAmount }}</td>

                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="text-center" colspan="7">No Invoice found</td>
                        </tr>
                        @endif
                    </table>
        </div>
    </div>
</div>
@endsection
