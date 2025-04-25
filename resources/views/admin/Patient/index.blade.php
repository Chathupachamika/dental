@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-search text-primary me-2"></i> Patient Search
            </h5>
            <p class="text-muted mb-0">Search and create invoices for patients</p>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-4">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search by name or mobile">
                    <button type="button" onclick="search_place()" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                Name
                                @if(Request::query('sortByName') && Request::query('sortByName')=='asc')
                                <a href="javascript:sortByName('desc')" class="text-muted"><i class="fas fa-sort-down ms-1"></i></a>
                                @elseif(Request::query('sortByName') && Request::query('sortByName')=='desc')
                                <a href="javascript:sortByName('asc')" class="text-muted"><i class="fas fa-sort-up ms-1"></i></a>
                                @else
                                <a href="javascript:sortByName('asc')" class="text-muted"><i class="fas fa-sort ms-1"></i></a>
                                @endif
                            </th>
                            <th>Address</th>
                            <th>Contact No</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($patients))
                            @foreach ($patients as $place)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle bg-primary-soft me-3">
                                            <span>{{ substr($place->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $place->name }}</h6>
                                            <small class="text-muted">ID: #{{ $place->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $place->address }}</td>
                                <td>{{ $place->mobileNumber }}</td>
                                <td class="text-end">
                                    <a href="/createInvoice/{{$place->id}}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-file-invoice-dollar me-1"></i> Create Invoice
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                        <h6>No Patients Found</h6>
                                        <p class="text-muted">No patients match your search criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if(count($patients))
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0">Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} patients</p>
                    </div>
                    <div>
                        {{ $patients->links() }}
                    </div>
                </div>
            @endif
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
        window.location.href = "{{route('admin.patient.index')}}?" + $.param(query);
    }

    function sortByName(value) {
        Object.assign(query, {
            'sortByName': value
        });
        window.location.href = "{{route('admin.patient.index')}}?" + $.param(query);
    }
</script>
@endsection
