@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">
                        <i class="fas fa-users text-primary me-2"></i> Patient List
                    </h5>
                    <p class="text-muted mb-0">Manage and view all patient records</p>
                </div>
                <a href="{{ route('admin.patient.store') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Add Patient
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <div class="d-flex">
                    <div class="input-group me-2" style="width: 300px;">
                        <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search by name or mobile">
                        <button type="button" onclick="search_place()" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                    </div>
                    <select class="form-select" id="filter" style="width: 150px;">
                        <option value="all">All Patients</option>
                        <option value="recent">Recent Patients</option>
                        <option value="pending">Pending Balance</option>
                    </select>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-secondary" onclick="exportPatients()">
                        <i class="fas fa-file-export me-1"></i> Export
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
                            <th>Last Visit</th>
                            <th>Balance</th>
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
                                <td>
                                    @if(isset($place->lastVisit))
                                        {{ \Carbon\Carbon::parse($place->lastVisit)->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">No visits</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($place->balance) && $place->balance > 0)
                                        <span class="text-danger">₹{{ number_format($place->balance, 2) }}</span>
                                    @else
                                        <span class="text-success">₹0.00</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.patient.show', $place->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                    <a href="{{ route('admin.patient.edit', $place->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <a href="javascript:delete_place('{{route('admin.patient.destroy',$place->id)}}')" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4">
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

<form id="place_delete_form" method="post" action="" class="d-none">
    @csrf
    @method('DELETE')
</form>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this patient? This action cannot be undone and will delete all associated invoices and records.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Patient</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var query = <?php echo json_encode((object)Request::only(['keyword', 'sortByName', 'filter'])); ?>;
    var deleteUrl = '';

    function search_place() {
        Object.assign(query, {
            'keyword': $('#keyword').val(),
            'filter': $('#filter').val()
        });
        window.location.href = "{{route('admin.patient.list')}}?" + $.param(query);
    }

    function sortByName(value) {
        Object.assign(query, {
            'sortByName': value
        });
        window.location.href = "{{route('admin.patient.list')}}?" + $.param(query);
    }

    function delete_place(url) {
        deleteUrl = url;
        $('#deleteConfirmModal').modal('show');
    }

    $('#confirmDeleteBtn').click(function() {
        $('#place_delete_form').attr('action', deleteUrl);
        $('#place_delete_form').submit();
        $('#deleteConfirmModal').modal('hide');
    });

    $('#filter').on('change', function() {
        search_place();
    });

    // Enable pressing Enter to search
    $('#keyword').keypress(function(e) {
        if(e.which == 13) {
            search_place();
        }
    });

    function exportPatients() {
        window.location.href = "{{route('admin.patient.export')}}?" + $.param(query);
    }

    // Set filter from URL if present
    $(document).ready(function() {
        if (query.filter) {
            $('#filter').val(query.filter);
        }
    });
</script>
@endsection
