@extends('admin.admin_logged.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h2 class="text-xl font-semibold flex items-center">
                    <i class="fas fa-user-circle mr-2"></i> Patient Details
                </h2>
                <p class="text-sm text-blue-100">View detailed information about the patient</p>
            </div>
            <div class="flex space-x-2 mt-4 sm:mt-0">
                <button onclick="window.print()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow flex items-center">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
                <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="mt-1 text-gray-800">{{ $patient->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <p class="mt-1 text-gray-800">{{ $patient->address }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Age</label>
                    <p class="mt-1 text-gray-800">{{ $patient->age }} years</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
                    <p class="mt-1 text-gray-800">{{ $patient->mobileNumber }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <p class="mt-1 text-gray-800">{{ $patient->gender }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIC</label>
                    <p class="mt-1 text-gray-800">{{ $patient->nic }}</p>
                </div>
                @if(isset($patient->medicalHistory) && $patient->medicalHistory)
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Medical History</label>
                    <p class="mt-1 text-gray-800">{{ $patient->medicalHistory }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Treatment & Invoice History -->
        <div class="p-6 border-t">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-file-invoice text-blue-500 mr-2"></i> Treatment & Invoice History
                </h3>
                <a href="{{ route('admin.invoice.create', $patient->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center">
                    <i class="fas fa-plus mr-2"></i> New Invoice
                </a>
            </div>

            @if(count($patient->invoice))
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Invoice #</th>
                            <th class="px-4 py-2">Treatment</th>
                            <th class="px-4 py-2">Other Notes</th>
                            <th class="px-4 py-2">Created Date</th>
                            <th class="px-4 py-2">Next Visit</th>
                            <th class="px-4 py-2">Total Amount</th>
                            <th class="px-4 py-2">Advance</th>
                            <th class="px-4 py-2">Balance</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patient->invoice as $place)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">#{{ $place->id }}</td>
                            <td class="px-4 py-3">
                                <ul class="list-disc pl-5">
                                    @foreach($place->invoiceTreatment as $treat)
                                    <li>{{ $treat->treatMent }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-3">{{ $place->otherNote }}</td>
                            <td class="px-4 py-3">{{ $place->created_at->format("m/d/Y") }}</td>
                            <td class="px-4 py-3">{{ $place->visitDate }}</td>
                            <td class="px-4 py-3">Rs {{ number_format($place->totalAmount, 2) }}</td>
                            <td class="px-4 py-3">Rs {{ number_format($place->advanceAmount, 2) }}</td>
                            <td class="px-4 py-3">Rs {{ number_format($place->totalAmount - $place->advanceAmount, 2) }}</td>
                            <td class="px-4 py-3">
                                @if($place->totalAmount == $place->advanceAmount)
                                    <span class="text-green-600 font-semibold">Paid</span>
                                @elseif($place->advanceAmount > 0)
                                    <span class="text-yellow-600 font-semibold">Partial</span>
                                @else
                                    <span class="text-red-600 font-semibold">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.invoice.view', $place->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow inline-flex items-center">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 bg-gray-100 p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <h4 class="text-gray-800 font-semibold">Total Outstanding Balance</h4>
                    @php
                        $totalDue = 0;
                        foreach($patient->invoice as $invoice) {
                            $totalDue += ($invoice->totalAmount - $invoice->advanceAmount);
                        }
                    @endphp
                    <h4 class="text-red-600 font-semibold">Rs {{ number_format($totalDue, 2) }}</h4>
                </div>
            </div>
            @else
            <div class="text-center py-6">
                <i class="fas fa-file-invoice fa-4x text-gray-400 mb-3"></i>
                <h5 class="text-gray-800 font-semibold">No Invoice Records</h5>
                <p class="text-gray-600">This patient doesn't have any invoice records yet.</p>
                <a href="{{ route('admin.invoice.create', $patient->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow mt-4 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Create First Invoice
                </a>
            </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="p-6 border-t flex justify-end space-x-2">
            <a href="{{ route('admin.patient.edit', $patient->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit Patient
            </a>
            <button onclick="delete_patient('{{ route('admin.patient.destroy', $patient->id) }}')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow flex items-center">
                <i class="fas fa-trash-alt mr-2"></i> Delete Patient
            </button>
        </div>
    </div>
</div>

<form id="patient_delete_form" method="post" action="" class="hidden">
    @csrf
    @method('DELETE')
</form>

<!-- Delete Confirmation Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="deleteConfirmModal">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="px-6 py-4 border-b">
            <h5 class="text-lg font-semibold text-gray-800">Confirm Delete</h5>
        </div>
        <div class="px-6 py-4">
            <p class="text-gray-600">Are you sure you want to delete this patient? This action cannot be undone and will delete all associated invoices and records.</p>
        </div>
        <div class="px-6 py-4 border-t flex justify-end space-x-2">
            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg" onclick="document.getElementById('deleteConfirmModal').classList.add('hidden')">Cancel</button>
            <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg" id="confirmDeleteBtn">Delete Patient</button>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var deleteUrl = '';

    function delete_patient(url) {
        deleteUrl = url;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        document.getElementById('patient_delete_form').setAttribute('action', deleteUrl);
        document.getElementById('patient_delete_form').submit();
        document.getElementById('deleteConfirmModal').classList.add('hidden');
    });
</script>
@endsection
