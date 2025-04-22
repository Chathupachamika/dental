@extends('layouts.admin-layout')
@section('title', 'Vehicle Management')

@section('styles')
    <style>
        .modal-transition { transition: all 0.3s ease-out; }
        .modal-enter { opacity: 0; transform: scale(0.95); }
        .modal-enter-active { opacity: 1; transform: scale(1); }
        .gradient-border { position: relative; border-radius: 0.5rem; }
        .gradient-border::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(45deg, #EF4444, #000000);
            border-radius: 0.6rem;
            z-index: -1;
            opacity: 0.5;
        }
        .hover-gradient:hover { background: linear-gradient(45deg, rgba(239, 68, 68, 0.1), rgba(0, 0, 0, 0.1)); }
        .search-input { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); transition: all 0.3s ease; border: none; }
        .search-input:focus { background: rgba(255, 255, 255, 0.1); box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1); }
        .action-button { transition: all 0.2s ease; }
        .action-button:hover { transform: translateY(-2px); }
        .upload-zone { border: 2px dashed rgba(255, 255, 255, 0.2); background: rgba(42, 42, 62, 0.5); transition: all 0.3s ease; }
        .upload-zone:hover { border-color: #EF4444; background: rgba(239, 68, 68, 0.1); box-shadow: 0 0 20px rgba(220, 38, 38, 0.3); }
        ::-webkit-scrollbar { width: 10px; background: #1a1a2e; }
        ::-webkit-scrollbar-thumb { background: #EF4444; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #DC2626; }
        .modal-content { max-height: 90vh; overflow-y: auto; }
        body.modal-open { overflow: hidden; }
        @media (min-width: 1024px) { .modal-content { max-height: none; overflow-y: visible; } }
        select { border: none; }
    </style>
@endsection

@section('content')
    <div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-600 text-white rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-8 mt-20">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-car mr-3 text-red-500"></i>
                    Vehicle Management
                </h1>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    <!-- Search Bar -->
                    <div class="flex rounded-lg overflow-hidden gradient-border flex-1 sm:flex-none">
                        <select id="searchField" class="bg-gray-800 text-gray-300 px-4 py-2">
                            <option value="car_id">Car ID</option>
                            <option value="model">Model</option>
                            <option value="status">Status</option>
                        </select>
                        <input type="text" id="searchQuery" placeholder="Search vehicles..."
                            class="search-input text-gray-300 px-4 py-2 w-full sm:w-64 focus:outline-none">
                        <button onclick="searchVehicles()"
                            class="bg-gradient-to-r from-red-500 to-black text-white px-6 py-2 hover:opacity-90 transition duration-150">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <!-- Add Vehicle Button -->
                    <button onclick="openAddModal()"
                        class="bg-gradient-to-r from-red-500 to-black text-white px-6 py-2 rounded-lg hover:opacity-90 transition duration-150 flex items-center justify-center w-full sm:w-auto">
                        <i class="fas fa-car-plus mr-2"></i> Add Vehicle
                    </button>
                </div>
            </div>
        </div>

        <!-- Vehicles Table -->
        <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden gradient-border">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr class="bg-gray-900">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Car ID</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Model</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Owner Name</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Contact No</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700" id="vehicleTableBody">
                        @forelse ($vehicles as $vehicle)
                            <tr class="hover-gradient transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $vehicle->car_id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $vehicle->model }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $vehicle->owner_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $vehicle->owner_contact }}</td>
                                <td class="px-6 py-4">
                                    <span class="status-badge px-3 py-1 rounded-full text-xs font-medium {{ $vehicle->status === 'Available' ? 'bg-green-500/10 text-green-400 border-green-500/20' : ($vehicle->status === 'Booked' ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20') }}">
                                        {{ $vehicle->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button onclick="openViewModal('{{ $vehicle->car_id }}')" class="action-button text-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="openEditModal('{{ $vehicle->car_id }}')" class="action-button text-blue-400 hover:text-blue-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteVehicle('{{ $vehicle->car_id }}')" class="action-button text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">No vehicles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-700 px-6 py-4">
                <p class="text-gray-400 text-sm">Total Vehicles: <span id="totalVehicles">{{ $vehicles->count() }}</span></p>
            </div>
        </div>

        <!-- View Vehicle Modal -->
        <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-800 rounded-lg p-8 max-w-5xl w-full modal-transition modal-enter gradient-border modal-content mt-16">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-car mr-3 text-red-500"></i>
                        Vehicle & Owner Details
                    </h2>
                    <button onclick="closeViewModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="viewModalContent" class="space-y-4">
                    <!-- Populated via JavaScript -->
                </div>
            </div>
        </div>

        <!-- Add/Edit Vehicle Modal -->
        <div id="vehicleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-800 rounded-lg p-4 max-w-7xl w-full modal-transition modal-enter gradient-border modal-content mt-16">
                <div class="flex justify-between items-start mb-3">
                    <h2 class="text-lg font-bold text-white flex items-center" id="modalTitle">
                        <i class="fas fa-car-plus mr-2 text-red-500"></i>
                        Add New Vehicle
                    </h2>
                    <button onclick="closeVehicleModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="vehicleForm" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="car_id" id="carId">
                    <div class="flex flex-col lg:flex-row gap-2">
                        <div class="bg-gray-900 p-2 rounded-lg lg:w-2/3">
                            <h3 class="text-base font-semibold text-white mb-1">Vehicle Details</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-1.5">
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Car ID</label>
                                    <input type="text" name="car_id" id="car_id_input" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Car Type</label>
                                    <select name="car_type" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                        <option value="SEDAN">Sedan</option>
                                        <option value="COUPE">Coupe</option>
                                        <option value="SPORTS CAR">Sports Car</option>
                                        <option value="STATION WAGON">Station Wagon</option>
                                        <option value="HATCHBACK">Hatchback</option>
                                        <option value="CONVERTIBLE">Convertible</option>
                                        <option value="SPORT-UTILITY VEHICLE">Sport-Utility Vehicle</option>
                                        <option value="MINIVAN">Minivan</option>
                                        <option value="VAN">Van</option>
                                        <option value="PICKUP TRUCK">Pickup Truck</option>
                                        <option value="OTHER">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Model</label>
                                    <input type="text" name="model" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Type</label>
                                    <select name="type" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                        <option value="Car">Car</option>
                                        <option value="Van">Van</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Year</label>
                                    <input type="text" name="year" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">VIN</label>
                                    <input type="text" name="vin" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Passengers</label>
                                    <input type="number" name="number_of_passenger" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Engine Number</label>
                                    <input type="text" name="engine_number" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Transmission</label>
                                    <select name="transmission_type" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                        <option value="Manual">Manual</option>
                                        <option value="Automatic">Automatic</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Number Plate</label>
                                    <input type="text" name="number_plate" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Category</label>
                                    <select name="category" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                        <option value="Wedding Car">Wedding Car</option>
                                        <option value="Travel & Tourism">Travel & Tourism</option>
                                        <option value="Business & Executive">Business & Executive</option>
                                        <option value="Economy & Budget Rentals">Economy & Budget Rentals</option>
                                        <option value="Special Needs">Special Needs</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Fuel Type</label>
                                    <select name="fuel" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                        <option value="Petrol">Petrol</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Hybrid">Hybrid</option>
                                        <option value="Electric">Electric</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Daily Rate</label>
                                    <input type="number" name="daily_rate" step="0.01" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Monthly Rate</label>
                                    <input type="number" name="monthly_rate" step="0.01" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Free Mileage</label>
                                    <input type="number" name="free_mileage" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Color</label>
                                    <input type="text" name="color" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Weight Capacity</label>
                                    <input type="text" name="rated_weight_capacity" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400">Status</label>
                                    <select name="status" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                        <option value="Available">Available</option>
                                        <option value="Booked">Booked</option>
                                        <option value="Non-Available">Non-Available</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-1.5">
                                <label class="block text-xs font-medium text-gray-400">Description</label>
                                <textarea name="description" rows="1" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs focus:border-blue-500 focus:ring focus:ring-blue-500/20"></textarea>
                            </div>
                            <div class="mt-1.5">
                                <label class="block text-xs font-medium text-gray-400">Car Images</label>
                                <div class="mt-0.5">
                                    <label class="upload-zone flex flex-col items-center justify-center w-full h-16 rounded-lg cursor-pointer">
                                        <div class="flex flex-col items-center justify-center pt-1 pb-1">
                                            <i class="fas fa-upload mb-0.5 text-red-500"></i>
                                            <p class="text-xs text-gray-400">Upload Car Images</p>
                                        </div>
                                        <input type="file" name="image[]" class="hidden" accept="image/*" multiple>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-900 p-2 rounded-lg lg:w-1/3">
                            <h3 class="text-base font-semibold text-white mb-1">Owner Details</h3>
                            <div class="space-y-4 mt-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Name</label>
                                    <input type="text" name="owner_name" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Contact Number</label>
                                    <input type="tel" name="owner_contact" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Email</label>
                                    <input type="email" name="owner_email" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Address</label>
                                    <textarea name="owner_address" rows="1" class="mt-0.5 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-xs focus:border-blue-500 focus:ring focus:ring-blue-500/20"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-2">
                        <button type="button" onclick="closeVehicleModal()"
                            class="px-3 py-1 bg-gray-700 text-white text-xs rounded-lg hover:bg-gray-600 transition-colors">
                            <i class="fas fa-times mr-1"></i> Close
                        </button>
                        <button type="submit"
                            class="px-3 py-1 bg-gradient-to-r from-red-500 to-black text-white text-xs rounded-lg hover:opacity-90 transition-colors">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const darkSwal = Swal.mixin({
            background: '#1a1a2e',
            color: '#fff',
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#DC2626',
            customClass: {
                popup: 'gradient-border',
                title: 'text-white',
                content: 'text-gray-300',
                confirmButton: 'hover:opacity-90 transition duration-150',
                cancelButton: 'hover:opacity-90 transition duration-150'
            }
        });

        function updateVehicleCount() {
            const totalVehicles = document.getElementById('vehicleTableBody').rows.length;
            document.getElementById('totalVehicles').textContent = totalVehicles;
        }

        function openAddModal() {
            const modal = document.getElementById('vehicleModal');
            document.body.classList.add('modal-open');
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-car-plus mr-3 text-red-500"></i>Add New Vehicle';
            document.getElementById('vehicleForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('vehicleForm').action = '{{ route('vehicles.store') }}';
            document.getElementById('car_id_input').readOnly = false;
            document.getElementById('carId').value = '';
            document.querySelector('input[name="car_id"]').value = '';
            const existingPreview = document.getElementById('imagePreview');
            if (existingPreview) existingPreview.remove();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function openEditModal(vehicleId) {
            const modal = document.getElementById('vehicleModal');
            document.body.classList.add('modal-open');
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-car-alt mr-3 text-red-500"></i>Edit Vehicle';
            document.getElementById('formMethod').value = 'PATCH';
            document.getElementById('vehicleForm').action = `/admin/vehicles/${vehicleId}`;
            document.getElementById('car_id_input').readOnly = true;
            document.getElementById('carId').value = vehicleId;
            document.getElementById('vehicleForm').innerHTML += '<input type="hidden" name="_method" value="PATCH">';

            fetch(`/admin/vehicles/${vehicleId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(vehicle => {
                document.querySelector('input[name="car_id"]').value = vehicle.car_id;
                document.querySelector('select[name="car_type"]').value = vehicle.car_type;
                document.querySelector('input[name="model"]').value = vehicle.model;
                document.querySelector('select[name="type"]').value = vehicle.type;
                document.querySelector('input[name="engine_number"]').value = vehicle.engine_number;
                document.querySelector('input[name="year"]').value = vehicle.year;
                document.querySelector('input[name="vin"]').value = vehicle.vin;
                document.querySelector('input[name="number_of_passenger"]').value = vehicle.number_of_passenger;
                document.querySelector('select[name="transmission_type"]').value = vehicle.transmission_type;
                document.querySelector('select[name="fuel"]').value = vehicle.fuel;
                document.querySelector('input[name="daily_rate"]').value = vehicle.daily_rate;
                document.querySelector('input[name="monthly_rate"]').value = vehicle.monthly_rate;
                document.querySelector('input[name="rated_weight_capacity"]').value = vehicle.rated_weight_capacity;
                document.querySelector('input[name="number_plate"]').value = vehicle.number_plate;
                document.querySelector('input[name="free_mileage"]').value = vehicle.free_mileage;
                document.querySelector('input[name="color"]').value = vehicle.color;
                document.querySelector('select[name="category"]').value = vehicle.category;
                document.querySelector('textarea[name="description"]').value = vehicle.description || '';
                document.querySelector('select[name="status"]').value = vehicle.status;
                document.querySelector('input[name="owner_name"]').value = vehicle.owner_name;
                document.querySelector('input[name="owner_contact"]').value = vehicle.owner_contact;
                document.querySelector('input[name="owner_email"]').value = vehicle.owner_email;
                document.querySelector('textarea[name="owner_address"]').value = vehicle.owner_address;

                // Display existing images
                if (vehicle.image) {
                    const images = typeof vehicle.image === 'string' ? JSON.parse(vehicle.image) : vehicle.image;
                    const previewContainer = document.createElement('div');
                    previewContainer.id = 'imagePreview';
                    previewContainer.className = 'grid grid-cols-3 gap-2 mt-2';
                    images.forEach(img => {
                        previewContainer.innerHTML += `
                            <div class="relative">
                                <img src="/storage/${img}" class="w-full h-24 object-cover rounded">
                            </div>
                        `;
                    });
                    const uploadZone = document.querySelector('.upload-zone');
                    const existingPreview = document.getElementById('imagePreview');
                    if (existingPreview) existingPreview.remove();
                    uploadZone.parentNode.insertBefore(previewContainer, uploadZone.nextSibling);
                }
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function openViewModal(vehicleId) {
            const modal = document.getElementById('viewModal');
            document.body.classList.add('modal-open');
            fetch(`/admin/vehicles/${vehicleId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(vehicle => {
                const images = typeof vehicle.image === 'string' ? JSON.parse(vehicle.image) : vehicle.image;
                const imageSrc = images && images.length > 0 ? `/storage/${images[0]}` : 'https://via.placeholder.com/500x300';
                document.getElementById('viewModalContent').innerHTML = `
                    <div class="bg-gray-900 p-3 rounded-lg">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="md:w-1/2">
                                <img src="${imageSrc}" alt="Vehicle Image" class="w-full h-48 object-cover rounded-lg">
                                <p class="text-gray-400 text-xs mt-2">${vehicle.description || 'No description available.'}</p>
                            </div>
                            <div class="md:w-1/2">
                                <h3 class="text-lg font-semibold text-white mb-2">Vehicle Details</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <div><label class="block text-xs font-medium text-gray-400">Car Type - Model (Year)</label><p class="text-white text-sm">${vehicle.car_type} ${vehicle.model} (${vehicle.year})</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">VIN</label><p class="text-white text-sm">${vehicle.vin}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">No of Passengers</label><p class="text-white text-sm">${vehicle.number_of_passenger}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Engine Number</label><p class="text-white text-sm">${vehicle.engine_number}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Transmission Type</label><p class="text-white text-sm">${vehicle.transmission_type}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Daily Rate</label><p class="text-white text-sm">$${vehicle.daily_rate}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Category</label><p class="text-white text-sm">${vehicle.category}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Monthly Rate</label><p class="text-white text-sm">$${vehicle.monthly_rate}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Registration</label><p class="text-white text-sm">${vehicle.number_plate}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Free Mileage</label><p class="text-white text-sm">${vehicle.free_mileage} km/day</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Color</label><p class="text-white text-sm">${vehicle.color}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Weight Capacity</label><p class="text-white text-sm">${vehicle.rated_weight_capacity} kg</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Fuel Type</label><p class="text-white text-sm">${vehicle.fuel}</p></div>
                                    <div><label class="block text-xs font-medium text-gray-400">Status</label><p class="text-white text-sm">${vehicle.status}</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-900 p-3 rounded-lg">
                        <h3 class="text-lg font-semibold text-white mb-2">Owner Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <div><label class="block text-xs font-medium text-gray-400">Name</label><p class="text-white text-sm">${vehicle.owner_name}</p></div>
                            <div><label class="block text-xs font-medium text-gray-400">Contact Number</label><p class="text-white text-sm">${vehicle.owner_contact}</p></div>
                            <div><label class="block text-xs font-medium text-gray-400">Email</label><p class="text-white text-sm">${vehicle.owner_email}</p></div>
                            <div><label class="block text-xs font-medium text-gray-400">Address</label><p class="text-white text-sm">${vehicle.owner_address}</p></div>
                        </div>
                    </div>
                `;
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function closeViewModal() {
            const modal = document.getElementById('viewModal');
            document.body.classList.remove('modal-open');
            modal.querySelector('.modal-transition').classList.add('modal-enter');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function closeVehicleModal() {
            const modal = document.getElementById('vehicleModal');
            document.body.classList.remove('modal-open');
            modal.querySelector('.modal-transition').classList.add('modal-enter');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function searchVehicles() {
            const field = document.getElementById('searchField').value;
            const query = document.getElementById('searchQuery').value;

            fetch(`/admin/vehicle-management?${field}=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('vehicleTableBody');
                tbody.innerHTML = '';
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-400">No vehicles found.</td></tr>';
                } else {
                    data.forEach(vehicle => {
                        const statusClass = vehicle.status === 'Available' ? 'bg-green-500/10 text-green-400 border-green-500/20' :
                                          vehicle.status === 'Booked' ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' :
                                          'bg-red-500/10 text-red-400 border-red-500/20';
                        tbody.innerHTML += `
                            <tr class="hover-gradient transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-300">${vehicle.car_id}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${vehicle.model}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${vehicle.owner_name}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${vehicle.owner_contact}</td>
                                <td class="px-6 py-4">
                                    <span class="status-badge px-3 py-1 rounded-full text-xs font-medium ${statusClass}">
                                        ${vehicle.status}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button onclick="openViewModal('${vehicle.car_id}')" class="action-button text-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="openEditModal('${vehicle.car_id}')" class="action-button text-blue-400 hover:text-blue-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteVehicle('${vehicle.car_id}')" class="action-button text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                updateVehicleCount();
                darkSwal.fire({
                    title: 'Search Complete',
                    text: `Found ${data.length} vehicle(s).`,
                    icon: 'info'
                });
            })
            .catch(() => {
                darkSwal.fire({
                    title: 'Error',
                    text: 'Failed to search vehicles.',
                    icon: 'error'
                });
            });
        }

        function deleteVehicle(vehicleId) {
            darkSwal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/vehicles/${vehicleId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            darkSwal.fire({
                                title: "Deleted!",
                                text: "Vehicle has been deleted.",
                                icon: "success"
                            }).then(() => window.location.reload());
                        } else {
                            darkSwal.fire("Error!", data.message, "error");
                        }
                    })
                    .catch(() => darkSwal.fire("Error!", "Failed to delete vehicle.", "error"));
                }
            });
        }

        document.getElementById('vehicleForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const method = document.getElementById('formMethod').value;
            const formData = new FormData(form);

            // Always set _method for proper Laravel method spoofing
            formData.set('_method', method);

            // Handle image uploads
            const fileInput = form.querySelector('input[name="image[]"]');
            if (fileInput.files.length > 0) {
                for (let i = 0; i < fileInput.files.length; i++) {
                    formData.append('images[]', fileInput.files[i]); // Rename to 'images[]' to avoid confusion
                }
            } else if (method === 'PATCH') {
                formData.append('keep_existing_images', '1'); // Signal to keep existing images
            }

            // Ensure car_id is included
            const carId = document.getElementById('carId').value || document.querySelector('input[name="car_id"]').value;
            formData.set('car_id', carId);

            fetch(form.action, {
                method: 'POST', // Always use POST, let Laravel handle method spoofing
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    darkSwal.fire({
                        title: "Success!",
                        text: method === 'POST' ? "Vehicle added successfully." : "Vehicle updated successfully.",
                        icon: "success"
                    }).then(() => window.location.reload());
                } else {
                    darkSwal.fire("Error!", data.message || "An error occurred.", "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                darkSwal.fire("Error!", "Something went wrong.", "error");
            });
        });

        // Initial update of vehicle count
        updateVehicleCount();
    </script>
@endsection
