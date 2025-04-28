@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-file-invoice text-primary me-2"></i> Invoice List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Patient Name</th>
                            <th>Total Amount</th>
                            <th>Advance Amount</th>
                            <th>Balance</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>#{{ $invoice->id }}</td>
                                <td>{{ $invoice->patient->name }}</td>
                                <td>{{ $invoice->totalAmount }}</td>
                                <td>{{ $invoice->advanceAmount }}</td>
                                <td>{{ $invoice->totalAmount - $invoice->advanceAmount }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.invoice.view', $invoice->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                                        <h6>No Invoices Found</h6>
                                        <p class="text-muted">No invoices available.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <p class="text-muted mb-0">Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} invoices</p>
                </div>
                <div>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
