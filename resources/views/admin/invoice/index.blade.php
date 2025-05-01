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
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
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
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Paid</span>
                                @elseif($invoice->advanceAmount > 0)
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Partial</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.invoice.view', $invoice->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow inline-flex items-center">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <button onclick="openEditModal({{ $invoice->id }})"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm shadow inline-flex items-center">
                                    <i class="fas fa-pencil-alt mr-1"></i> Edit
                                </button>
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

            <!-- Enhanced Pagination -->
            @if($invoices->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4 rounded-lg shadow">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($invoices->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Previous
                        </span>
                    @else
                        <a href="{{ $invoices->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @if($invoices->hasMorePages())
                        <a href="{{ $invoices->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Next
                        </a>
                    @else
                        <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Next
                        </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $invoices->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $invoices->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $invoices->total() }}</span>
                            invoices
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            {{-- Previous Page Link --}}
                            @if ($invoices->onFirstPage())
                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-default">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left w-5 h-5"></i>
                                </span>
                            @else
                                <a href="{{ $invoices->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left w-5 h-5"></i>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($invoices->onEachSide(1)->links()->elements[0] as $page => $url)
                                @if ($page == $invoices->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($invoices->hasMorePages())
                                <a href="{{ $invoices->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right w-5 h-5"></i>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-default">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right w-5 h-5"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Improved Edit Invoice Modal -->
<div id="editInvoiceModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300 ease-in-out">
    <div class="relative top-20 mx-auto p-0 max-w-2xl shadow-2xl rounded-lg bg-white transform transition-all duration-300 ease-in-out scale-95 opacity-0" id="modalContent">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-edit text-2xl mr-3"></i>
                <div>
                    <h3 class="text-xl font-bold">Edit Invoice</h3>
                    <p class="text-blue-100 text-sm">Update invoice details</p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="text-white hover:text-gray-200 focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form id="editInvoiceForm" class="space-y-5">
                @csrf
                <input type="hidden" id="editInvoiceId">

                <!-- Patient Info (Read-only) -->
                <div class="bg-gray-50 p-4 rounded-lg mb-5">
                    <div class="flex items-center mb-3">
                        <div id="patientAvatar" class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                            <span class="font-semibold text-lg" id="patientInitial"></span>
                        </div>
                        <div>
                            <h4 class="font-medium text-lg" id="patientName"></h4>
                            <p class="text-gray-500 text-sm" id="patientId"></p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">Rs</span>
                                </div>
                                <input type="number" id="editTotalAmount" name="totalAmount" step="0.01"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Advance Amount</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">Rs</span>
                                </div>
                                <input type="number" id="editAdvanceAmount" name="advanceAmount" step="0.01"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Next Visit Date</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-500"></i>
                                </div>
                                <input type="date" id="editVisitDate" name="visitDate"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Balance Due</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">Rs</span>
                                </div>
                                <input type="text" id="balanceDue" readonly
                                    class="pl-10 block w-full rounded-md bg-gray-50 border-gray-300 text-gray-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Treatment Section -->
                <div class="mt-6">
                    <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Treatment Details
                    </h4>
                    <div id="treatmentsList" class="space-y-3 mb-4">
                        <!-- Treatment items will be added here dynamically -->
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-sticky-note mr-2 text-blue-500"></i> Notes
                    </label>
                    <textarea id="editOtherNote" name="otherNote" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Add any additional notes here..."></textarea>
                </div>

                <!-- Status Indicator -->
                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-700 mr-2">Payment Status:</span>
                        <span id="paymentStatus" class="px-3 py-1 rounded-full text-xs font-semibold"></span>
                    </div>

                    <div class="flex space-x-3">
                        <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i> Update Invoice
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('javascript')
<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    // Calculate balance due when total or advance amount changes
    function calculateBalance() {
        const total = parseFloat(document.getElementById('editTotalAmount').value) || 0;
        const advance = parseFloat(document.getElementById('editAdvanceAmount').value) || 0;
        const balance = total - advance;

        document.getElementById('balanceDue').value = balance.toFixed(2);

        // Update payment status
        const statusElement = document.getElementById('paymentStatus');
        if (balance <= 0) {
            statusElement.textContent = 'PAID';
            statusElement.className = 'px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold';
        } else if (advance > 0) {
            statusElement.textContent = 'PARTIAL';
            statusElement.className = 'px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold';
        } else {
            statusElement.textContent = 'UNPAID';
            statusElement.className = 'px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold';
        }
    }

    function openEditModal(invoiceId) {
        // Show loading state with SweetAlert2
        Swal.fire({
            title: 'Loading...',
            text: 'Fetching invoice details',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Show modal
        const modal = document.getElementById('editInvoiceModal');
        const modalContent = document.getElementById('modalContent');
        modal.classList.remove('hidden');

        // Fetch invoice data
        fetch(`/admin/invoice/view/${invoiceId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            // Populate form fields
            document.getElementById('editInvoiceId').value = data.id;
            document.getElementById('editTotalAmount').value = data.totalAmount;
            document.getElementById('editAdvanceAmount').value = data.advanceAmount;
            document.getElementById('editVisitDate').value = data.visitDate;
            document.getElementById('editOtherNote').value = data.otherNote;

            // Set patient info
            document.getElementById('patientName').textContent = data.patient.name;
            document.getElementById('patientId').textContent = `ID: #${data.patient.id}`;
            document.getElementById('patientInitial').textContent = data.patient.name.charAt(0);

            // Calculate balance
            calculateBalance();

            // Populate treatments
            const treatmentsList = document.getElementById('treatmentsList');
            treatmentsList.innerHTML = '';

            if (data.invoiceTreatment && data.invoiceTreatment.length > 0) {
                data.invoiceTreatment.forEach((treatment, index) => {
                    const treatmentItem = document.createElement('div');
                    treatmentItem.className = 'p-3 bg-gray-50 rounded-lg';
                    treatmentItem.innerHTML = `
                        <input type="hidden" name="treatments[${index}][treatment]" value="${treatment.treatMent}">
                        <input type="hidden" name="treatments[${index}][subtype_id]" value="${treatment.subtype_id || ''}">
                        <input type="hidden" name="treatments[${index}][position_id]" value="${treatment.position_id || ''}">
                        <div class="flex justify-between">
                            <div class="font-medium">${treatment.treatMent}</div>
                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            ${treatment.subCategoryOne ? treatment.subCategoryOne.name : '—'} /
                            ${treatment.subCategoryTwo ? treatment.subCategoryTwo.name : '—'}
                        </div>
                    `;
                    treatmentsList.appendChild(treatmentItem);
                });
            } else {
                treatmentsList.innerHTML = '<p class="text-gray-500 italic">No treatments found</p>';
            }

            // Animate modal in
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        })
        .catch(error => {
            console.error('Error fetching invoice data:', error);
            closeEditModal();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load invoice data. Please try again.',
                confirmButtonColor: '#3085d6'
            });
        });
    }

    function closeEditModal() {
        const modal = document.getElementById('editInvoiceModal');
        const modalContent = document.getElementById('modalContent');

        // Animate modal out
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Add event listeners for amount calculations
    document.getElementById('editTotalAmount').addEventListener('input', calculateBalance);
    document.getElementById('editAdvanceAmount').addEventListener('input', calculateBalance);

    document.getElementById('editInvoiceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const invoiceId = document.getElementById('editInvoiceId').value;

        // Show confirmation dialog
        Swal.fire({
            title: 'Update Invoice',
            text: 'Are you sure you want to update this invoice?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
                submitBtn.disabled = true;

                // Send AJAX request
                fetch(`/admin/invoice/update/${invoiceId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Invoice updated successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            closeEditModal();
                            window.location.reload();
                        });
                    } else {
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating invoice: ' + data.message,
                            confirmButtonColor: '#3085d6'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the invoice. Please try again.',
                        confirmButtonColor: '#3085d6'
                    });
                });
            }
        });
    });

    // Close modal when clicking outside
    document.getElementById('editInvoiceModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('editInvoiceModal').classList.contains('hidden')) {
            closeEditModal();
        }
    });
</script>
@endsection
@endsection
