@extends('user.layouts.app')

@section('styles')
<style>
    .invoice-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        border-radius: var(--radius-xl);
        overflow: hidden;
    }

    .invoice-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .invoice-header {
        background: linear-gradient(135deg, var(--primary-50) 0%, var(--primary-100) 100%);
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .invoice-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
        color: var(--gray-800);
    }

    .invoice-title i {
        color: var(--primary);
        font-size: 1.5rem;
    }

    .invoice-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background-color: white;
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .stat-card.total {
        border-left-color: var(--primary);
    }

    .stat-card.paid {
        border-left-color: var(--success);
    }

    .stat-card.pending {
        border-left-color: var(--warning);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: var(--gray-800);
    }

    .stat-label {
        color: var(--gray-600);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .invoice-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .invoice-table th {
        background-color: var(--gray-50);
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .invoice-table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-200);
        color: var(--gray-700);
        font-size: 0.95rem;
    }

    .invoice-table tr:last-child td {
        border-bottom: none;
    }

    .invoice-table tr {
        transition: all 0.2s;
    }

    .invoice-table tr:hover {
        background-color: var(--gray-50);
    }

    .invoice-id {
        font-weight: 600;
        color: var(--primary);
    }

    .invoice-date {
        color: var(--gray-600);
    }

    .invoice-amount {
        font-weight: 600;
        color: var(--gray-800);
    }

    .invoice-balance {
        font-weight: 600;
    }

    .balance-positive {
        color: var(--danger);
    }

    .balance-zero {
        color: var(--success);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        gap: 0.35rem;
    }

    .status-paid {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .status-pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-lg);
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-download {
        background-color: var(--primary-50);
        color: var(--primary);
        border: 1px solid var(--primary-100);
    }

    .btn-download:hover {
        background-color: var(--primary-100);
        transform: translateY(-2px);
    }

    .btn-pay {
        background-color: var(--success-light);
        color: white;
        border: none;
    }

    .btn-pay:hover {
        background-color: var(--success);
        transform: translateY(-2px);
    }

    .invoice-actions {
        display: flex;
        gap: 0.5rem;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
    }

    .empty-icon {
        font-size: 3rem;
        color: var(--gray-300);
        margin-bottom: 1rem;
    }

    .empty-text {
        color: var(--gray-500);
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .filter-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filter-select {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
        background-color: white;
        color: var(--gray-700);
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.2);
    }

    .search-input {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
        background-color: white;
        color: var(--gray-700);
        font-size: 0.875rem;
        width: 250px;
        transition: all 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.2);
    }

    @media (max-width: 768px) {
        .invoice-table {
            display: block;
            overflow-x: auto;
        }

        .filter-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-input {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="invoice-card">
    <div class="invoice-header">
        <h2 class="invoice-title">
            <i class="fas fa-file-invoice-dollar"></i> My Invoices
        </h2>
    </div>

    <div class="card-body">
        <!-- Invoice Statistics -->
        <div class="invoice-stats">
            <div class="stat-card total">
                <div class="stat-value">Rs.{{ number_format($invoices->sum('totalAmount'), 2) }}</div>
                <div class="stat-label">
                    <i class="fas fa-chart-line"></i> Total Billed
                </div>
            </div>

            <div class="stat-card paid">
                <div class="stat-value">Rs.{{ number_format($invoices->sum('advanceAmount'), 2) }}</div>
                <div class="stat-label">
                    <i class="fas fa-check-circle"></i> Total Paid
                </div>
            </div>

            <div class="stat-card pending">
                <div class="stat-value">Rs.{{ number_format($invoices->sum('totalAmount') - $invoices->sum('advanceAmount'), 2) }}</div>
                <div class="stat-label">
                    <i class="fas fa-clock"></i> Outstanding Balance
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-group">
                <select class="filter-select">
                    <option value="all">All Invoices</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                </select>

                <select class="filter-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="highest">Highest Amount</option>
                    <option value="lowest">Lowest Amount</option>
                </select>
            </div>

            <div class="filter-group">
                <input type="text" class="search-input" placeholder="Search invoices...">
            </div>
        </div>

        @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>
                                    <span class="invoice-id">INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <span class="invoice-date">{{ $invoice->created_at->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="invoice-amount">Rs.{{ number_format($invoice->totalAmount, 2) }}</span>
                                </td>
                                <td>
                                    <span class="invoice-amount">Rs.{{ number_format($invoice->advanceAmount, 2) }}</span>
                                </td>
                                <td>
                                    <span class="invoice-balance {{ ($invoice->totalAmount - $invoice->advanceAmount) > 0 ? 'balance-positive' : 'balance-zero' }}">
                                        Rs.{{ number_format($invoice->totalAmount - $invoice->advanceAmount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $invoice->totalAmount <= $invoice->advanceAmount ? 'status-paid' : 'status-pending' }}">
                                        <i class="fas {{ $invoice->totalAmount <= $invoice->advanceAmount ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                        {{ $invoice->totalAmount <= $invoice->advanceAmount ? 'Paid' : 'Pending' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="invoice-actions">
                                        <a href="{{ route('user.invoices.download', $invoice->id) }}" class="action-btn btn-download">
                                            <i class="fas fa-download"></i> Download
                                        </a>

                                        @if($invoice->totalAmount > $invoice->advanceAmount)
                                            <a href="{{ route('user.invoices.pay', $invoice->id) }}" class="action-btn btn-pay">
                                                <i class="fas fa-credit-card"></i> Pay
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{ $invoices->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="empty-text">No invoices found</div>
                <p class="text-gray-500">Your invoice history will appear here once you have received treatments.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterStatus = document.querySelector('.filter-select:nth-child(1)');
        const filterSort = document.querySelector('.filter-select:nth-child(2)');
        const searchInput = document.querySelector('.search-input');

        // Add event listeners for filters
        filterStatus.addEventListener('change', applyFilters);
        filterSort.addEventListener('change', applyFilters);
        searchInput.addEventListener('input', applyFilters);

        function applyFilters() {
            window.showLoader('Filtering invoices...');

            const rows = document.querySelectorAll('.invoice-table tbody tr');
            const status = filterStatus.value;
            const sortBy = filterSort.value;
            const search = searchInput.value.toLowerCase();

            let filteredRows = Array.from(rows);

            // Filter by status
            if (status !== 'all') {
                filteredRows = filteredRows.filter(row => {
                    const statusBadge = row.querySelector('.status-badge');
                    const isPaid = statusBadge.classList.contains('status-paid');
                    return (status === 'paid' && isPaid) || (status === 'pending' && !isPaid);
                });
            }

            // Filter by search
            if (search) {
                filteredRows = filteredRows.filter(row => {
                    const text = row.textContent.toLowerCase();
                    return text.includes(search);
                });
            }

            // Sort rows
            filteredRows.sort((a, b) => {
                switch (sortBy) {
                    case 'newest':
                        return new Date(b.querySelector('.invoice-date').textContent) -
                               new Date(a.querySelector('.invoice-date').textContent);
                    case 'oldest':
                        return new Date(a.querySelector('.invoice-date').textContent) -
                               new Date(b.querySelector('.invoice-date').textContent);
                    case 'highest':
                        return parseFloat(b.querySelector('.invoice-amount').textContent.replace(/[Rs.,]/g, '')) -
                               parseFloat(a.querySelector('.invoice-amount').textContent.replace(/[Rs.,]/g, ''));
                    case 'lowest':
                        return parseFloat(a.querySelector('.invoice-amount').textContent.replace(/[Rs.,]/g, '')) -
                               parseFloat(b.querySelector('.invoice-amount').textContent.replace(/[Rs.,]/g, ''));
                }
            });

            // Hide all rows
            rows.forEach(row => row.style.display = 'none');

            // Show filtered rows
            filteredRows.forEach(row => row.style.display = '');

            // Show empty state if no results
            const emptyState = document.querySelector('.empty-state');
            if (emptyState) {
                emptyState.style.display = filteredRows.length === 0 ? 'flex' : 'none';
            }

            window.hideLoader();
        }
    });
</script>
@endsection
