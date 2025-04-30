@extends('admin.admin_logged.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h2 class="text-xl font-semibold flex items-center">
                    <i class="fas fa-user-edit mr-2"></i> Edit Patient
                </h2>
                <p class="text-sm text-blue-100">Update patient details</p>
            </div>
        </div>

        <!-- Form -->
        <div class="p-6">
            <form action="{{ route('admin.patient.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="id" value="{{ $patient->id }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-500"></i> Patient Name <span class="text-gray-400 text-xs ml-2">(e.g., John Doe)</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ $patient->name }}" required
                               class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Address <span class="text-gray-400 text-xs ml-2">(e.g., 123 Main Street, City)</span>
                        </label>
                        <input type="text" name="address" id="address" value="{{ $patient->address }}"
                               class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-birthday-cake mr-2 text-blue-500"></i> Age <span class="text-gray-400 text-xs ml-2">(e.g., 30)</span>
                        </label>
                        <input type="number" name="age" id="age" value="{{ $patient->age }}"
                               class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="mobileNumber" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-phone-alt mr-2 text-blue-500"></i> Mobile Number <span class="text-gray-400 text-xs ml-2">(e.g., 9876543210)</span>
                        </label>
                        <input type="text" name="mobileNumber" id="mobileNumber" value="{{ $patient->mobileNumber }}" required
                               class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-venus-mars mr-2 text-blue-500"></i> Gender
                        </label>
                        <select name="gender" id="gender"
                                class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                            <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $patient->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- NIC -->
                    <div>
                        <label for="nic" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-id-card mr-2 text-blue-500"></i> NIC <span class="text-gray-400 text-xs ml-2">(e.g., 123456789V)</span>
                        </label>
                        <input type="text" name="nic" id="nic" value="{{ $patient->nic }}"
                               class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    </div>

                    <!-- Medical History -->
                    <div class="sm:col-span-2">
                        <label for="medicalHistory" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-notes-medical mr-2 text-blue-500"></i> Medical History
                        </label>
                        <textarea name="medicalHistory" id="medicalHistory" rows="3"
                                  class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">{{ $patient->medicalHistory }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow flex items-center">
                        <i class="fas fa-save mr-2"></i> Update Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
