@extends('admin.admin_logged.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-t-xl flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h2 class="text-2xl font-semibold flex items-center">
                    <i class="fas fa-file-invoice mr-2"></i> Invoice Details
                </h2>
                <p class="text-sm text-blue-100">View detailed information about the invoice</p>
            </div>
            <div class="flex space-x-2 mt-4 sm:mt-0">
                <button onclick="window.print()" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg shadow flex items-center">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
                <a href="{{ route('admin.invoice.download', $invoice) }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg shadow flex items-center">
                    <i class="fas fa-download mr-2"></i> Download PDF
                </a>
                <a href="{{ route('admin.invoice.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg shadow flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <!-- Invoice Information -->
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Patient Details -->
                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-circle text-blue-500 mr-2"></i> Patient Information
                    </h3>
                    <div class="space-y-2">
                        <p><strong>Name:</strong> {{ $invoice->patient->name }}</p>
                        <p><strong>Age:</strong> {{ $invoice->patient->age }}</p>
                        <p><strong>Gender:</strong> {{ $invoice->patient->gender }}</p>
                        <p><strong>Address:</strong> {{ $invoice->patient->address }}</p>
                        <p><strong>Mobile:</strong> {{ $invoice->patient->mobileNumber }}</p>
                        <p><strong>NIC:</strong> {{ $invoice->patient->nic }}</p>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calculator text-blue-500 mr-2"></i> Financial Summary
                    </h3>
                    <div class="space-y-2">
                        <p><strong>Total Amount:</strong> <span class="text-green-600 font-semibold">Rs {{ number_format($invoice->totalAmount, 2) }}</span></p>
                        <p><strong>Advance Paid:</strong> <span class="text-yellow-600 font-semibold">Rs {{ number_format($invoice->advanceAmount, 2) }}</span></p>
                        <p><strong>Balance Due:</strong> <span class="text-red-600 font-semibold">Rs {{ number_format($invoice->totalAmount - $invoice->advanceAmount, 2) }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Treatment Details -->
        <div class="p-6 border-t">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clipboard-list text-blue-500 mr-2"></i> Treatment Details
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Treatment</th>
                            <th class="px-4 py-2">Subtype</th>
                            <th class="px-4 py-2">Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->invoiceTreatment as $treatment)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $treatment->treatMent }}</td>
                            <td class="px-4 py-3">{{ $treatment->subCategoryOne->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $treatment->subCategoryTwo->name ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="p-6 border-t flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <button onclick="window.print()" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-lg shadow flex items-center">
                <i class="fas fa-print mr-2"></i> Print Invoice
            </button>
            <a href="{{ route('admin.invoice.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg shadow flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Invoices
            </a>
        </div>
    </div>
</div>

<style>
/* Responsive Design */
@media (max-width: 640px) {
    .grid-cols-2 {
        grid-template-columns: 1fr !important;
    }
    .sm\:flex-row {
        flex-direction: column !important;
    }
    .sm\:space-y-0 {
        margin-bottom: 1rem !important;
    }
}

/* Enhanced Table Styling */
table {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 0.5rem;
    overflow: hidden;
}

thead th {
    background-color: #f9fafb;
    font-weight: 600;
    color: #374151;
}

tbody tr:hover {
    background-color: #f3f4f6;
}
</style>
@endsection
