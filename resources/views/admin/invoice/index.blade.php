@extends('admin.admin_logged.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h2 class="text-xl font-semibold flex items-center">
                    <i class="fas fa-file-invoice mr-2"></i> Invoice List
                </h2>
                <p class="text-sm text-blue-100">Manage and view all invoices</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="p-6">
            <div class="flex flex-col sm:flex-row items-stretch gap-3 mb-6">
                <input type="text" name="keyword" id="keyword" placeholder="Search by invoice number or patient name"
                       class="w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                <button type="button" onclick="search_invoice()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i> Search
                </button>
                <select id="filter" class="w-full sm:w-48 px-3 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    <option value="all">All Invoices</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

            <!-- Invoice Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 rounded-lg">
                        <tr>
                            <th class="px-4 py-2">Invoice #</th>
                            <th class="px-4 py-2">Patient</th>
                            <th class="px-4 py-2">Total Amount</th>
                            <th class="px-4 py-2">Balance</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $invoice)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">#{{ $invoice->id }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="font-semibold">{{ substr($invoice->patient->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $invoice->patient->name }}</div>
                                        <div class="text-gray-500 text-xs">ID: #{{ $invoice->patient->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">Rs {{ number_format($invoice->totalAmount, 2) }}</td>
                            <td class="px-4 py-3">Rs {{ number_format($invoice->totalAmount - $invoice->advanceAmount, 2) }}</td>
                            <td class="px-4 py-3">
                                @if($invoice->totalAmount == $invoice->advanceAmount)
                                    <span class="text-green-500 font-semibold">Paid</span>
                                @elseif($invoice->advanceAmount > 0)
                                    <span class="text-yellow-500 font-semibold">Partial</span>
                                @else
                                    <span class="text-red-500 font-semibold">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.invoice.view', $invoice->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow inline-flex items-center">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-file-invoice fa-3x text-gray-400 mb-2"></i>
                                    <h6 class="font-semibold">No Invoices Found</h6>
                                    <p class="text-sm">No invoices match your search criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(count($invoices))
            <!-- Pagination Info & Links -->
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 text-sm text-gray-600">
                <div class="mb-2 sm:mb-0">
                    Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} invoices
                </div>
                <div>
                    {{ $invoices->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@section('javascript')
<script type="text/javascript">
    var query = <?php echo json_encode((object)Request::only(['keyword', 'filter'])); ?>;

    function search_invoice() {
        Object.assign(query, {
            'keyword': document.getElementById('keyword').value,
            'filter': document.getElementById('filter').value
        });
        window.location.href = "{{route('admin.invoice.index')}}?" + new URLSearchParams(query).toString();
    }

    // Enable Enter key for search
    document.getElementById('keyword').addEventListener('keypress', function (e) {
        if (e.which === 13 || e.keyCode === 13) {
            search_invoice();
        }
    });
</script>
@endsection
@endsection
