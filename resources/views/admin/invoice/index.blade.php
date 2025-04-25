@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-file-invoice text-primary me-2"></i> Invoice Management
            </h5>
            <p class="text-muted mb-0">View and manage patient invoices and payments</p>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-4">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search by invoice number">
                    <button type="button" onclick="search_place()" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Patient Name</th>
                            <th>Next Visit</th>
                            <th>Notes</th>
                            <th>Total</th>
                            <th>Advance</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($patients))
                            @foreach ($patients as $place)
                            <tr>
                                <td>
                                    <span class="fw-medium text-primary">#{{$place->id}}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle bg-primary-soft me-3">
                                            <span>{{ substr($place->patient->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{$place->patient->name}}</h6>
                                            <small class="text-muted">ID: #{{ $place->patient->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $place->visitDate }}</td>
                                <td>
                                    @if($place->otherNote)
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $place->otherNote }}">
                                            {{ $place->otherNote }}
                                        </span>
                                    @else
                                        <span class="text-muted">No notes</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-medium">₹{{ number_format($place->totalAmount, 2) }}</span>
                                </td>
                                <td>
                                    <span class="fw-medium text-success">₹{{ number_format($place->advanceAmount, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="/ViewInvoice/{{$place->id}}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i> Print</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                                        <h6>No Invoices Found</h6>
                                        <p class="text-muted">No invoices match your search criteria.</p>
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
                        <p class="text-muted mb-0">Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} invoices</p>
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
        window.location.href = "{{route('admin.invoice.index')}}?" + $.param(query);
    }

    function sortByName(value) {
        Object.assign(query, {
            'sortByName': value
        });
        window.location.href = "{{route('admin.invoice.index')}}?" + $.param(query);
    }
</script>
@endsection
