@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"> Invoice List</h4>
            <div class='d-flex w-100 justify-content-end pb-3'>
                <div class="d-flex">
                    <input type="text" class="form-control" name="keyword" placeholder="Invoice number" id="keyword">
                    <button type="button" onclick="search_place()" class="btn btn-primary ml-2">Search</button>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Invoice Number</td>
                        <td>User name</td>
                        <td>Next Visit Date</td>
                        <td>otherNote</td>
                        <td>Total Amount</td>
                        <td>Advance Amount</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @if(count($patients))
                    @foreach ($patients as $place)
                    <tr>
                        <td>{{$place->id}}</td>

                        <td>{{$place->patient->name}}</td>
                        <td>{{ $place->visitDate }}</td>
                        <td>{{ $place->otherNote }}</td>
                        <td>{{ $place->totalAmount }}</td>
                        <td>{{ $place->advanceAmount }}</td>
                        <td> <a class="btn btn-gradient-success btn-fw" href="/ViewInvoice/{{$place->id}}">View</a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="7">No Invoice found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="pt-4">
                @if(count($patients))
                {!! $patients->links("pagination::bootstrap-4") !!}
                @endif
            </div>
        </div>
    </div>
</div>


@endsection

@section('javascript')
<script type="text/javascript">
    var query = <?php echo json_encode((object)Request::only(['keyword', 'sortByName'])); ?>;


    function search_place() {

        Object.assign(query, {
            'keyword': $('#keyword').val()
        });

        window.location.href = "{{route('invoice.index')}}?" + $.param(query);

    }

    function sortByName(value) {
        Object.assign(query, {
            'sortByName': value
        });

        window.location.href = "{{route('invoice.index')}}?" + $.param(query);
    }
</script>
@endsection