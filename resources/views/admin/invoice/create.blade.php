@extends('admin.admin_logged.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Enhanced Header with Steps -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Create New Invoice</h1>
                    <p class="text-gray-600 mt-2">Patient ID: <span class="font-semibold text-indigo-600">#{{ $patient->id }}</span></p>
                </div>
                <div class="flex items-center space-x-4 bg-white p-2 rounded-lg shadow-sm">
                    <span class="text-sm font-medium text-gray-600">Draft</span>
                    <div class="w-16 h-6 bg-indigo-100 rounded-full p-1 cursor-pointer transition-all duration-300 hover:bg-indigo-200">
                        <div class="w-4 h-4 bg-indigo-600 rounded-full shadow-md transform translate-x-0"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-600">Final</span>
                </div>
            </div>
        </div>

        <!-- Enhanced Main Content -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-8 relative overflow-hidden">
                <div class="absolute inset-0 bg-pattern opacity-10"></div>
                <h5 class="text-3xl font-bold text-white flex items-center relative z-10">
                    <i class="fas fa-file-invoice-dollar mr-4 text-white/80"></i>
                    New Invoice
                    <span class="ml-4 text-sm font-normal bg-white/20 px-4 py-1.5 rounded-full">
                        Patient #{{ $patient->id }}
                    </span>
                </h5>
            </div>

            <!-- Rest of the content -->
            <div class="p-8">
                <form action="{{ route('admin.invoice.store') }}" method="POST" id="invoiceForm">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                    <!-- Patient Details Card -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
                        <h6 class="text-lg font-semibold text-gray-700 mb-4">Patient Information</h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left column -->
                            <div class="space-y-6">
                                <div class="group transition-all duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <div class="relative">
                                        <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                                        <input type="text" class="pl-10 w-full rounded-lg border-gray-200 bg-white shadow-sm" value="{{ $patient->name }}" readonly>
                                    </div>
                                </div>
                                <div class="group transition-all duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                                    <div class="relative">
                                        <i class="fas fa-calendar-alt absolute left-3 top-3 text-gray-400"></i>
                                        <input type="text" class="pl-10 w-full rounded-lg border-gray-200 bg-white shadow-sm" value="{{ $patient->age }}" readonly>
                                    </div>
                                </div>
                                <div class="group transition-all duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <div class="relative">
                                        <i class="fas fa-venus-mars absolute left-3 top-3 text-gray-400"></i>
                                        <input type="text" class="pl-10 w-full rounded-lg border-gray-200 bg-white shadow-sm" value="{{ $patient->gender }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- Right column -->
                            <div class="space-y-6">
                                <div class="group transition-all duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <div class="relative">
                                        <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                                        <textarea class="pl-10 w-full rounded-lg border-gray-200 bg-white shadow-sm" readonly>{{ $patient->address }}</textarea>
                                    </div>
                                </div>
                                <div class="group transition-all duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mobile</label>
                                    <div class="relative">
                                        <i class="fas fa-phone absolute left-3 top-3 text-gray-400"></i>
                                        <input type="text" class="pl-10 w-full rounded-lg border-gray-200 bg-white shadow-sm" value="{{ $patient->mobileNumber }}" readonly>
                                    </div>
                                </div>
                                <div class="group transition-all duration-300">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">NIC</label>
                                    <div class="relative">
                                        <i class="fas fa-id-card absolute left-3 top-3 text-gray-400"></i>
                                        <input type="text" class="pl-10 w-full rounded-lg border-gray-200 bg-white shadow-sm" value="{{ $patient->nic }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Selection -->
                    <div class="bg-white rounded-xl p-6 mb-8 border border-gray-200 shadow-sm">
                        <h6 class="text-lg font-semibold text-gray-700 mb-4">Treatment Selection</h6>
                        <div class="flex items-end space-x-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <div class="flex-1 group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Treatment Type</label>
                                <select id="treatmentSelect" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                    <option value="">Select Treatment</option>
                                    @foreach(['Consultation', 'Extraction', 'Surgical removal', 'Restoration', 'Full mouth scaling', 'Denture', 'OtherDenticles', 'Crowns', 'Bridges', 'Implant'] as $treatment)
                                        <option value="{{ $treatment }}" class="py-2">{{ $treatment }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1 group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subtype</label>
                                <select id="subtypeSelect" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:ring-2 focus:ring-blue-500 transition-all hidden">
                                    <option value="">Select Subtype</option>
                                </select>
                            </div>
                            <div class="w-24 group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                                <select id="positionSelect" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:ring-2 focus:ring-blue-500 transition-all hidden">
                                    <option value="">Position</option>
                                </select>
                            </div>
                            <button type="button" id="addTreatmentBtn" class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                                <i class="fas fa-plus mr-2"></i>Add Treatment
                            </button>
                        </div>
                    </div>

                    <!-- Treatment Cards -->
                    <div id="treatmentCards" class="grid gap-4 mb-8"></div>

                    <!-- Invoice Details -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h6 class="text-lg font-semibold text-gray-700 mb-4">Invoice Details</h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group transition-all duration-300">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Other Note</label>
                                <textarea name="otherNote" class="pl-3 w-full rounded-lg border-gray-200 bg-white shadow-sm"></textarea>
                            </div>
                            <div class="group transition-all duration-300">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Next Visit Date</label>
                                <input type="date" name="visitDate" class="pl-3 w-full rounded-lg border-gray-200 bg-white shadow-sm">
                            </div>
                            <div class="group transition-all duration-300">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                                <input type="number" name="totalAmount" id="totalAmount" class="pl-3 w-full rounded-lg border-gray-200 bg-gray-100 shadow-sm" value="0.00" readonly>
                            </div>
                            <div class="group transition-all duration-300">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Advance</label>
                                <input type="number" name="advanceAmount" id="advanceAmount" class="pl-3 w-full rounded-lg border-gray-200 bg-white shadow-sm" value="0">
                            </div>
                            <div class="group transition-all duration-300">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Balance</label>
                                <input type="number" id="balanceAmount" class="pl-3 w-full rounded-lg border-gray-200 bg-gray-100 shadow-sm" value="0" readonly>
                            </div>
                            <div class="col-span-2">
                                <div class="flex justify-end space-x-4">
                                    <button type="button" class="px-6 py-3 rounded-lg border border-gray-300 hover:bg-gray-50 transition-all">
                                        <i class="fas fa-times mr-2"></i>Cancel
                                    </button>
                                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-all duration-300">
                                        <i class="fas fa-save mr-2"></i>Save Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Consultation Modal -->
<div id="viewModal" class="fixed inset-0 bg-gray-900/50 hidden z-50">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <span class="inline-block h-screen align-middle">&#8203;</span>
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Treatment Details</h3>
                <button id="closeViewModal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="viewModalContent" class="space-y-4">
                <!-- Content will be dynamically inserted here -->
            </div>
            <div class="mt-6">
                <button type="button" class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200" onclick="$('#viewModal').addClass('hidden')">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Consultation Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-900/50 hidden z-50">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <span class="inline-block h-screen align-middle">&#8203;</span>
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Treatment</h3>
                <button id="closeEditModal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Treatment Type</label>
                    <select id="editTreatmentSelect" class="w-full rounded-lg border-gray-200 bg-white shadow-sm">
                        @foreach(['Consultation', 'Extraction', 'Surgical removal', 'Restoration', 'Full mouth scaling', 'Denture', 'OtherDenticles', 'Crowns', 'Bridges', 'Implant'] as $treatment)
                            <option value="{{ $treatment }}">{{ $treatment }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtype</label>
                    <select id="editSubtypeSelect" class="w-full rounded-lg border-gray-200 bg-white shadow-sm">
                        <option value="">Select Subtype</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                    <select id="editPositionSelect" class="w-full rounded-lg border-gray-200 bg-white shadow-sm">
                        <option value="">Select Position</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex space-x-3">
                <button type="button" id="cancelEditBtn" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                    Cancel
                </button>
                <button type="button" id="saveEditBtn" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Consultation View Modal -->
<div id="consultationViewModal" class="fixed inset-0 bg-gray-900/50 hidden z-50">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <span class="inline-block h-screen align-middle">&#8203;</span>
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Consultation Details</h3>
                <button id="closeConsultationViewModal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="consultationViewContent" class="bg-gray-50 rounded-lg p-4 space-y-3">
                <!-- Content will be dynamically inserted here -->
            </div>
            <div class="mt-6">
                <button type="button" class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200" onclick="$('#consultationViewModal').addClass('hidden')">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Consultation Edit Modal -->
<div id="consultationEditModal" class="fixed inset-0 bg-gray-900/50 hidden z-50">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <span class="inline-block h-screen align-middle">&#8203;</span>
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Consultation</h3>
                <button id="closeConsultationEditModal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea id="consultationNotes" class="w-full rounded-lg border-gray-200 bg-white shadow-sm" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                    <input type="number" id="consultationPrice" class="w-full rounded-lg border-gray-200 bg-white shadow-sm" value="50">
                </div>
            </div>
            <div class="mt-6 flex space-x-3">
                <button type="button" id="cancelConsultationEditBtn" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                    Cancel
                </button>
                <button type="button" id="saveConsultationEditBtn" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<div id="loader" class="fixed inset-0 bg-white/80 z-50 flex items-center justify-center backdrop-blur-sm" style="display: none;">
    <div class="relative">
        <div class="h-24 w-24 rounded-full border-t-4 border-b-4 border-primary animate-spin"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-primary font-medium">Loading...</span>
        </div>
    </div>
</div>

<style>
/* Modern color scheme */
:root {
    --primary: #4f46e5;
    --primary-dark: #4338ca;
    --secondary: #3b82f6;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
}

/* Enhanced animations */
@keyframes fadeSlideIn {
    from {
        opacity: 0;
        transform: translateY(10px) scale(0.98);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes pulseGlow {
    0%, 100% { box-shadow: 0 0 0 rgba(79, 70, 229, 0); }
    50% { box-shadow: 0 0 20px rgba(79, 70, 229, 0.2); }
}

/* Card and container styles */
.container {
    animation: fadeSlideIn 0.6s ease-out;
}

.bg-pattern {
    background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.15) 2px, transparent 0);
    background-size: 24px 24px;
}

.group {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.group:hover {
    transform: translateY(-2px);
}

/* Form element enhancements */
input, select, textarea {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(209, 213, 219, 0.8);
}

input:focus, select:focus, textarea:focus {
    transform: scale(1.01);
    box-shadow213,219,0.8);
}

input:focus, select:focus, textarea:focus {
    transform: scale(1.01);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    border-color: var(--primary);
}

/* Button styles */
button {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

button:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 120%;
    height: 120%;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
    transform: translate(-50%, -50%) scale(0);
    opacity: 0;
    transition: 0.5s;
}

button:hover:after {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
}

/* Treatment card enhancements */
.treatment-card {
    animation: fadeSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: linear-gradient(to right bottom, #ffffff, #fafafa);
}

.treatment-card:hover {
    transform: translateY(-2px) scale(1.01);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    border-color: rgba(79, 70, 229, 0.3);
}

/* Progress steps animation */
.step-active {
    animation: pulseGlow 2s infinite;
}

/* Modern form layout */
.form-group {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-group label {
    position: absolute;
    top: -0.75rem;
    left: 0.75rem;
    padding: 0 0.5rem;
    background: white;
    font-size: 0.875rem;
    color: var(--primary);
    transition: all 0.2s;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c7d2fe;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #818cf8;
}

/* Loading state animations */
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

.loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite linear;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .grid {
        grid-template-columns: 1fr;
    }

    .treatment-card {
        margin-bottom: 1rem;
    }
}

/* Modern Design System */
:root {
    --primary: #4f46e5;
    --primary-light: #6366f1;
    --primary-dark: #4338ca;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --background: #f8fafc;
    --surface: #ffffff;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
}

/* Modern Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Enhanced Card Design */
.treatment-card {
    background: linear-gradient(145deg, var(--surface), #f8fafc);
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow:
        0 1px 3px rgba(0, 0, 0, 0.05),
        0 4px 6px rgba(79, 70, 229, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.treatment-card:hover {
    transform: translateY(-2px);
    box-shadow:
        0 4px 6px rgba(0, 0, 0, 0.05),
        0 10px 15px rgba(79, 70, 229, 0.1);
}

/* Modern Button Styles */
.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.2),
        transparent
    );
    transition: 0.5s;
}

.btn-primary:hover::before {
    left: 100%;
}

/* Modern Form Controls */
.form-control {
    transition: all 0.2s ease;
    border: 1px solid rgba(0, 0, 0, 0.08);
    background: linear-gradient(180deg, #ffffff, #fafafa);
}

.form-control:focus {
    transform: translateY(-1px);
    box-shadow:
        0 0 0 3px rgba(79, 70, 229, 0.1),
        0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Loader Animation */
@keyframes loader-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loader {
    animation: loader-spin 1s linear infinite;
}

/* Glass Morphism Effects */
.glass {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Modern Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(45deg, var(--primary-light), var(--primary));
    border-radius: 4px;
    border: 2px solid #f1f1f1;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--primary-dark);
}

/* Treatment Status Tags */
.status-tag {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

/* Modern Tooltips */
[data-tooltip] {
    position: relative;
}

[data-tooltip]:after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-2px);
    background: var(--text-primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s ease;
}

[data-tooltip]:hover:after {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(-8px);
}
</style>

@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        const treatmentData = {
            'Consultation': { subtypes: [], positions: [], price: 50 },
            'Extraction': { subtypes: ['UL', 'UR', 'LL', 'LR'], positions: ['1', '2', '3', '4', '5', '6', '7', '8'], price: 100 },
            'Surgical removal': { subtypes: ['UL', 'UR', 'LL', 'LR'], positions: ['1', '2', '3', '4', '5', '6', '7', '8'], price: 200 },
            'Restoration': { subtypes: ['LCC', 'GIC', 'TF', 'RCT'], positions: [], price: 150 },
            'Full mouth scaling': { subtypes: ['Normal', 'Polishing', 'Betel Stains', 'Chromogenic Stains'], positions: [], price: 80 },
            'Denture': { subtypes: ['Acrylic', 'Valplast', 'Metal'], positions: [], price: 300 },
            'OtherDenticles': { subtypes: ['URA', 'LRA', 'FA', 'Anderson Type FA', 'Twin Bloc'], positions: [], price: 250 },
            'Crowns': { subtypes: ['PFM', 'Metal', 'Cercornium'], positions: [], price: 400 },
            'Bridges': { subtypes: ['PFM', 'Cercornium'], positions: [], price: 500 },
            'Implant': { subtypes: ['UL', 'UR', 'LL', 'LR'], positions: ['1', '2', '3', '4', '5', '6', '7', '8'], price: 1000 }
        };

        let treatments = [];
        let editIndex = null;

        // Update dropdowns based on treatment selection
        $('#treatmentSelect').change(function () {
            const treatment = $(this).val();
            const $subtypeSelect = $('#subtypeSelect');
            const $positionSelect = $('#positionSelect');

            $subtypeSelect.empty().append('<option value="">Select Subtype</option>').addClass('hidden');
            $positionSelect.empty().append('<option value="">Position</option>').addClass('hidden');

            if (treatment && treatmentData[treatment].subtypes.length > 0) {
                $subtypeSelect.removeClass('hidden');
                treatmentData[treatment].subtypes.forEach(subtype => {
                    $subtypeSelect.append(`<option value="${subtype}">${subtype}</option>`);
                });
            }

            if (['Extraction', 'Surgical removal', 'Implant'].includes(treatment)) {
                $positionSelect.removeClass('hidden');
                treatmentData[treatment].positions.forEach(position => {
                    $positionSelect.append(`<option value="${position}">${position}</option>`);
                });
            }

            updateAddButton();
        });

        // Enable/disable Add button
        function updateAddButton() {
            const treatment = $('#treatmentSelect').val();
            const subtype = $('#subtypeSelect').val();
            const position = $('#positionSelect').val();
            const isValid = treatment && (!treatmentData[treatment].subtypes.length || subtype) && (!treatmentData[treatment].positions.length || position);
            $('#addTreatmentBtn').prop('disabled', !isValid);
        }

        $('#subtypeSelect, #positionSelect').change(updateAddButton);

        // Add treatment card
        $('#addTreatmentBtn').click(function () {
            const treatment = $('#treatmentSelect').val();
            const subtype = $('#subtypeSelect').val();
            const position = $('#positionSelect').val();
            treatments.push({
                treatment,
                subtype,
                position,
                price: treatmentData[treatment].price
            });
            renderTreatmentCards();
            resetForm();
            updateTotal();
        });

        // Render treatment cards
        function renderTreatmentCards() {
            $('#treatmentCards').empty();
            treatments.forEach((t, index) => {
                const card = `
                    <div class="treatment-card p-4 rounded-xl" data-index="${index}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h6 class="font-semibold text-gray-800 text-lg">${t.treatment}</h6>
                                    <span class="status-tag ${t.status === 'active' ? 'status-active' : 'status-pending'}">
                                        ${t.status || 'Pending'}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">
                                    ${t.subtype ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">${t.subtype}</span>` : ''}
                                    ${t.position ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">Position ${t.position}</span>` : ''}
                                </p>
                                <p class="text-lg font-medium text-primary mt-2">$${t.price.toFixed(2)}</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="btn-icon view-btn" data-tooltip="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon edit-btn" data-tooltip="Edit Treatment">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon delete-btn" data-tooltip="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>`;
                $('#treatmentCards').append(card);
            });
        }

        // View consultation details
        $(document).on('click', '.view-btn', function () {
            const index = $(this).closest('div[data-index]').data('index');
            const t = treatments[index];

            if (t.treatment === 'Consultation') {
                const content = `
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Treatment Type</span>
                        <span class="text-sm text-gray-900">Consultation</span>
                    </div>
                    <div class="flex items-center justify-between border-t pt-3">
                        <span class="text-sm font-medium text-gray-500">Price</span>
                        <span class="text-sm font-semibold text-indigo-600">$${t.price.toFixed(2)}</span>
                    </div>
                    ${t.notes ? `
                        <div class="border-t pt-3">
                            <span class="text-sm font-medium text-gray-500 block mb-1">Notes</span>
                            <p class="text-sm text-gray-900">${t.notes}</p>
                        </div>
                    ` : ''}`;

                $('#consultationViewContent').html(content);
                $('#consultationViewModal').removeClass('hidden');
            } else {
                // Handle other treatment types with existing modal
                $('#viewModalContent').html(`
                    <p><strong>Treatment:</strong> ${t.treatment}</p>
                    ${t.subtype ? `<p><strong>Subtype:</strong> ${t.subtype}</p>` : ''}
                    ${t.position ? `<p><strong>Position:</strong> ${t.position}</p>` : ''}
                    <p><strong>Price:</strong> $${t.price}</p>
                `);
                $('#viewModal').removeClass('hidden');
            }
        });

        $('#closeViewModal').click(() => $('#viewModal').addClass('hidden'));

        // Edit consultation
        $(document).on('click', '.edit-btn', function () {
            const index = $(this).closest('div[data-index]').data('index');
            const t = treatments[index];

            if (t.treatment === 'Consultation') {
                editIndex = index;
                $('#consultationNotes').val(t.notes || '');
                $('#consultationPrice').val(t.price);
                $('#consultationEditModal').removeClass('hidden');
            } else {
                // Handle other treatment types with existing edit modal
                editIndex = index;
                $('#editTreatmentSelect').val(t.treatment);
                populateEditDropdowns(t.treatment, t.subtype, t.position);
                $('#editModal').removeClass('hidden');
            }
        });

        function populateEditDropdowns(treatment, selectedSubtype, selectedPosition) {
            const $editSubtypeSelect = $('#editSubtypeSelect');
            const $editPositionSelect = $('#editPositionSelect');
            $editSubtypeSelect.empty().append('<option value="">Select Subtype</option>');
            $editPositionSelect.empty().append('<option value="">Position</option>');

            if (treatmentData[treatment].subtypes.length > 0) {
                treatmentData[treatment].subtypes.forEach(subtype => {
                    $editSubtypeSelect.append(`<option value="${subtype}" ${subtype === selectedSubtype ? 'selected' : ''}>${subtype}</option>`);
                });
            }

            if (['Extraction', 'Surgical removal', 'Implant'].includes(treatment)) {
                treatmentData[treatment].positions.forEach(position => {
                    $editPositionSelect.append(`<option value="${position}" ${position === selectedPosition ? 'selected' : ''}>${position}</option>`);
                });
            }
        }

        $('#editTreatmentSelect').change(function () {
            const treatment = $(this).val();
            populateEditDropdowns(treatment, '', '');
        });

        $('#saveEditBtn').click(function () {
            treatments[editIndex] = {
                treatment: $('#editTreatmentSelect').val(),
                subtype: $('#editSubtypeSelect').val(),
                position: $('#editPositionSelect').val(),
                price: treatmentData[$('#editTreatmentSelect').val()].price
            };
            renderTreatmentCards();
            $('#editModal').addClass('hidden');
            updateTotal();
        });

        $('#closeEditModal, #cancelEditBtn').click(() => $('#editModal').addClass('hidden'));

        // Save consultation changes
        $('#saveConsultationEditBtn').click(function () {
            treatments[editIndex] = {
                treatment: 'Consultation',
                notes: $('#consultationNotes').val(),
                price: parseFloat($('#consultationPrice').val()) || 50,
            };
            renderTreatmentCards();
            $('#consultationEditModal').addClass('hidden');
            updateTotal();
        });

        // Close consultation modals
        $('#closeConsultationViewModal, #closeConsultationEditModal, #cancelConsultationEditBtn').click(function() {
            $('#consultationViewModal, #consultationEditModal').addClass('hidden');
        });

        // Delete treatment
        $(document).on('click', '.delete-btn', function () {
            const index = $(this).closest('div[data-index]').data('index');
            treatments.splice(index, 1);
            renderTreatmentCards();
            updateTotal();
        });

        // Update total and balance
        function updateTotal() {
            const total = treatments.reduce((sum, t) => sum + t.price, 0);
            $('#totalAmount').val(total.toFixed(2));
            const advance = parseFloat($('#advanceAmount').val()) || 0;
            $('#balanceAmount').val((total - advance).toFixed(2));
        }

        $('#advanceAmount').on('input', updateTotal);

        // Reset form
        function resetForm() {
            $('#treatmentSelect').val('');
            $('#subtypeSelect').empty().append('<option value="">Select Subtype</option>').addClass('hidden');
            $('#positionSelect').empty().append('<option value="">Position</option>').addClass('hidden');
            $('#addTreatmentBtn').prop('disabled', true);
        }

        // Form submission
        $('#invoiceForm').submit(function (e) {
            e.preventDefault();
            showLoader();

            // Ensure we're sending the complete treatment data
            const formData = {
                patient_id: $('input[name="patient_id"]').val(),
                otherNote: $('textarea[name="otherNote"]').val(),
                visitDate: $('input[name="visitDate"]').val(),
                totalAmount: $('#totalAmount').val(),
                advanceAmount: $('#advanceAmount').val(),
                treatments: treatments.map(t => ({
                    treatment: t.treatment,
                    subtype: t.subtype || null,
                    position: t.position || null,
                    price: t.price
                }))
            };

            console.log('Submitting form data:', formData);

            $.ajax({
                url: "{{ route('admin.invoice.store') }}",
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    hideLoader();
                    showSuccess('Invoice created successfully!');
                    setTimeout(() => {
                        window.location.href = `/admin/invoice/view/${response.data.id}`;
                    }, 2000);
                },
                error: function(xhr) {
                    hideLoader();
                    console.error('Error response:', xhr);
                    showError('Error saving invoice. Please try again.');
                }
            });
        });
    });

    function showLoader() {
        $('#loader').removeClass('hidden');
    }

    function hideLoader() {
        $('#loader').addClass('hidden');
    }

    function showSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'animated fadeInDown faster'
            }
        });
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
            confirmButtonColor: 'var(--primary)',
            customClass: {
                popup: 'animated fadeInDown faster'
            }
        });
    }
    </script>

@endsection
