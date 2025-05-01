@extends('user.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-file-invoice-dollar"></i> My Invoices
        </h2>
    </div>
    <div class="card-body">
        @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                <td>${{ number_format($invoice->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No invoices found.</p>
        @endif
    </div>
</div>
@endsection
