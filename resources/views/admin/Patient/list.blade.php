@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Patient List</h4>

            <div class='d-flex w-100 justify-content-end pb-3'>
                <div class="d-flex">
                    <input type="text" class="form-control" name="keyword" placeholder="Name / Mobile" id="keyword">
                    <button type="button" onclick="search_place()" class="btn btn-primary ml-2">Search</button>
                    <a class="btn btn-gradient-info btn-fw ml-2" href="/createPatient">Create</a>

                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Name
                            @if(Request::query('sortByName') && Request::query('sortByName')=='asc')
                            <a href="javascript:sortByName('desc')"><i class="fas fa-sort-down"></i></a>
                            @elseif(Request::query('sortByName') && Request::query('sortByName')=='desc')
                            <a href="javascript:sortByName('asc')"><i class="fas fa-sort-up"></i></a>
                            @else
                            <a href="javascript:sortByName('asc')"><i class="fas fa-sort"></i></a>
                            @endif
                        </td>
                        <td>Address</td>
                        <td>Contact No</td>
                        <td></td>

                    </tr>
                </thead>
                <tbody>
                    @if(count($patients))
                    @foreach ($patients as $place)
                    <tr>
                        <td>{{ $place->name }}</td>
                        <td>{{ $place->address }}</td>
                        <td>{{ $place->mobileNumber }}</td>
                        <td>
                            <a class="btn btn-gradient-success btn-fw" href="/showPatient/{{$place->id}}">View</a>
                            <a class="btn btn-gradient-info btn-fw" href="/editPatient/{{$place->id}}">Edit</a>
                            <a href="javascript:delete_place('{{route('admin.patient.destroy',$place->id)}}')" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="7">No Patient found</td>
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
<form id="place_delete_form" method="post" action="">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('javascript')
<script type="text/javascript">
    var query = <?php echo json_encode((object)Request::only(['keyword', 'sortByName'])); ?>;


    function search_place() {
        Object.assign(query, {
            'keyword': $('#keyword').val()
        });
        window.location.href = "{{route('admin.patient.list')}}?" + $.param(query);
    }

    function delete_place(url) {
        swal({
                title: "Are you sure?",
                text: "You want to delete this patient",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#place_delete_form').attr('action', url);
                    $('#place_delete_form').submit();
                }
            });
    }
</script>
@endsection