@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"> Appointments</h4>
            <h5 id='date-label' class="card-title"> </h5>

            <div class='d-flex w-100 justify-content-end pb-3'>
                <div class="d-flex">
                    <input type="Date" class="form-control" name="date" id="date">
                    <button type="button" onclick="search_place()" class="btn btn-primary ml-2">Search</button>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>User name</td>
                        <td>Next Visit Date</td>
                        <td>otherNote</td>
                        <td>Total Amount</td>
                        <td>Advance Amount</td>
                    </tr>
                </thead>
                <tbody>
                    @if(count($patients))
                    @foreach ($patients as $place)
                    <tr>
                        <td>{{$place->patient->name}}</td>
                        <td>{{ $place->visitDate }}</td>
                        <td>{{ $place->otherNote }}</td>
                        <td>{{ $place->totalAmount }}</td>
                        <td>{{ $place->advanceAmount }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="7">No Invoice found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection

@section('javascript')
<script type="text/javascript">
    window.onload = function() {

        const urlParams = new URLSearchParams(window.location.search);
        const date = urlParams.get('date');
        if (date) {
            document.getElementById('date-label').innerHTML = date;
        } else {
            document.getElementById('date-label').innerHTML = moment().format('YYYY-MM-DD');
        }
    };

    var query = <?php echo json_encode((object)Request::only(['date',])); ?>;

    function search_place() {
        Object.assign(query, {
            'date': $('#date').val()
        });
        window.location.href = "{{route('Appointments.index')}}?" + $.param(query);
    }
</script>
@endsection