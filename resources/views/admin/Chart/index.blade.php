@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daily Chart </h4>

            <h5 id='date-label' class="card-title"> </h5>
            <div class='d-flex w-100 justify-content-end pb-3'>
                <div class="d-flex">
                    <input type="Date" class="form-control" name="date" id="date">
                    <button type="button" onclick="search_place()" class="btn btn-primary ml-2">Search</button>
                </div>
            </div>
            <div>
                <label for=""></label>Total Appointment :<label> {{count($invoice)}}</label>
            </div>
            <div>
                <label for="">Total Amount</label>
                <label for="">
                    <?php
                    $total = 0;
                    ?>
                    @foreach($invoice as $k => $bD)
                    <?php
                    $total += ($bD['totalAmount']);
                    ?>
                    @endforeach
                    {{$total}}
                </label>
            </div>
            <div>
                <label for="">Advance Amount</label>
                <label for="">
                    <?php
                    $total = 0;
                    ?>
                    @foreach($invoice as $k => $bD)
                    <?php
                    $total += ($bD['advanceAmount']);
                    ?>
                    @endforeach
                    {{$total}}
                </label>
            </div>
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
        window.location.href = "{{route('Chart.index')}}?" + $.param(query);
    }
</script>
@endsection