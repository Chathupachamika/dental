@extends('admin.admin_logged.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h2 class="text-xl font-semibold flex items-center">
                    <i class="fas fa-user-plus mr-2"></i> Create Patient
                </h2>
                <p class="text-sm text-blue-100">Add a new patient to the system</p>
            </div>
        </div>

        <!-- Form -->
        <div class="p-6">
            <form action="{{ route('admin.patient.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-500"></i> Patient Name <span class="text-gray-400 text-xs ml-2">(e.g., John Doe)</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="mobileNumber" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-phone-alt mr-2 text-blue-500"></i> Mobile Number <span class="text-gray-400 text-xs ml-2">(e.g., 9876543210)</span>
                        </label>
                        <input type="text" name="mobileNumber" id="mobileNumber" required
                               class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    </div>

                    <!-- Address -->
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Address <span class="text-gray-400 text-xs ml-2">(e.g., 123 Main Street, City)</span>
                        </label>
                        <textarea name="address" id="address" rows="3" required
                                  class="mt-1 block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow flex items-center">
                        <i class="fas fa-save mr-2"></i> Save Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
