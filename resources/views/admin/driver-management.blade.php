@extends('layouts.admin-layout')

@section('title', 'Driver Management')

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
            background: linear-gradient(45deg, #EA2F2F, #5E1313);
            border-radius: 0.6rem;
            z-index: -1;
            opacity: 0.5;
        }
        .hover-gradient:hover { background: linear-gradient(45deg, rgba(255, 8, 8, 0.15), rgba(52, 0, 0, 0.15)); }
        .search-input { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); transition: all 0.3s ease; border: none; }
        .search-input:focus { background: rgba(255, 255, 255, 0.1); box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1); }
        .action-button { transition: all 0.2s ease; }
        .action-button:hover { transform: translateY(-2px); }
        .upload-zone { transition: all 0.3s ease; }
        .upload-zone:hover { border-color: #EA2F2F; background: rgba(255, 0, 0, 0.1); box-shadow: 0 0 10px rgba(225, 120, 120, 0.3); }
        ::-webkit-scrollbar { width: 10px; background: #1a1a2e; }
        ::-webkit-scrollbar-thumb { background: #EA2F2F; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #7d1010; }
        .modal-content { max-height: 90vh; overflow-y: auto; }
        body.modal-open { overflow: hidden; }
        @media (min-width: 1024px) { .modal-content { max-height: none; overflow-y: visible; } }
        select { border: none; }
        .custom-input { height: 2rem; font-size: 0.875rem; }
        .image-container { position: relative; width: 100%; max-width: 200px; margin-bottom: 1rem; }
        .image-preview { width: 100%; height: 120px; object-fit: cover; border-radius: 0.5rem; }
        .upload-button { position: absolute; top: -2rem; left: 50%; transform: translateX(-50%); cursor: pointer; }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; }
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
                    <i class="fas fa-users-gear mr-3 text-[#EA2F2F]"></i>
                    Driver Management
                </h1>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    <div class="flex rounded-lg overflow-hidden gradient-border flex-1 sm:flex-none">
                        <select id="searchField" name="searchField" class="bg-gray-800 text-gray-300 px-4 py-2">
                            <option value="driver_id">Driver ID</option>
                            <option value="first_name">First Name</option>
                            <option value="email">Email</option>
                        </select>
                        <input type="text" id="searchQuery" name="searchQuery" placeholder="Search drivers..."
                            class="search-input text-gray-300 px-4 py-2 w-full sm:w-64 focus:outline-none">
                        <button onclick="searchDrivers()"
                            class="bg-gradient-to-r from-[#EA2F2F] to-[#5E1313] text-white px-6 py-2 hover:opacity-90 transition duration-150">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button onclick="openAddModal()"
                        class="bg-gradient-to-r from-[#EA2F2F] to-[#5E1313] text-white px-6 py-2 rounded-lg hover:opacity-90 transition duration-150 flex items-center justify-center w-full sm:w-auto">
                        <i class="fas fa-user-plus mr-2"></i> Add Driver
                    </button>
                </div>
            </div>
        </div>

        <!-- Drivers Table -->
        <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden gradient-border">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr class="bg-gray-900">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Driver ID</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Contact No</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700" id="driverTableBody">
                        @forelse ($drivers as $driver)
                            <tr class="hover-gradient transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $driver->driver_id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $driver->first_name }} {{ $driver->last_name }}</td>
                                <td class="px-6 py-4">
                                    <span class="status-badge {{ $driver->availability == 'Available' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20' }}">
                                        {{ $driver->availability }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $driver->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $driver->contact_number }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button onclick="openViewModal('{{ $driver->driver_id }}')"
                                            class="action-button text-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="openEditModal('{{ $driver->driver_id }}')"
                                            class="action-button text-green-400 hover:text-green-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteDriver('{{ $driver->driver_id }}')"
                                            class="action-button text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">No drivers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-700 px-6 py-4">
                <p class="text-gray-400 text-sm">Total Drivers: <span id="totalDrivers">{{ $drivers->count() }}</span></p>
            </div>
        </div>

        <!-- View Driver Modal -->
        <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-800 rounded-lg p-8 max-w-5xl w-full modal-transition modal-enter gradient-border modal-content mt-16">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-id-card mr-3 text-[#EA2F2F]"></i>
                        Driver Details
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

        <!-- Add/Edit Driver Modal -->
        <div id="driverModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-800 rounded-lg p-8 max-w-4xl w-full modal-transition modal-enter gradient-border modal-content mt-16">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-bold text-white flex items-center" id="modalTitle">
                        <i class="fas fa-user-plus mr-3 text-[#EA2F2F]"></i>
                        Add New Driver
                    </h2>
                    <button onclick="closeDriverModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="driverForm" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="driver_id" id="driverId">

                    <!-- Left Column -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Driver ID</label>
                            <input type="text" name="driver_id" id="driver_id_input"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('driver_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">First Name</label>
                            <input type="text" name="first_name"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Last Name</label>
                            <input type="text" name="last_name"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Contact Number</label>
                            <input type="tel" name="contact_number"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('contact_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Email</label>
                            <input type="email" name="email"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Middle Column -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400">NIC Number</label>
                            <input type="text" name="nic_number"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('nic_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">License Type</label>
                            <select name="license_type" class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                            @error('license_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">License ID</label>
                            <input type="text" name="license_id"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('license_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">License Expiry Date</label>
                            <input type="date" name="license_expiry_date"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('license_expiry_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Availability</label>
                            <select name="availability" class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                                <option value="Available">Available</option>
                                <option value="Not Available">Not Available</option>
                            </select>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Address</label>
                            <textarea name="address" rows="4"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20"></textarea>
                            @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-xs font-medium text-gray-400 mb-2">License Images</label>
                            <div class="flex flex-col space-y-6">
                                <div class="image-container">
                                    <label class="upload-button upload-zone rounded-full p-2 bg-gray-700 hover:bg-gray-600">
                                        <i class="fas fa-camera text-[#EA2F2F]"></i>
                                        <input type="file" name="license_front_image" class="hidden" accept="image/*" onchange="previewImage(event, 'front')">
                                    </label>
                                    <img id="license_front_preview" src="https://via.placeholder.com/200x120" class="image-preview" alt="License Front">
                                </div>
                                <div class="image-container">
                                    <label class="upload-button upload-zone rounded-full p-2 bg-gray-700 hover:bg-gray-600">
                                        <i class="fas fa-camera text-[#EA2F2F]"></i>
                                        <input type="file" name="license_back_image" class="hidden" accept="image/*" onchange="previewImage(event, 'back')">
                                    </label>
                                    <img id="license_back_preview" src="https://via.placeholder.com/200x120" class="image-preview" alt="License Back">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-full flex justify-end space-x-4">
                        <button type="button" onclick="closeDriverModal()"
                            class="px-6 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Close
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-[#EA2F2F] to-[#5E1313] text-white rounded-lg hover:opacity-90 transition-colors">
                            Save
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const darkSwal = Swal.mixin({
            background: '#1a1a2e',
            color: '#fff',
            confirmButtonColor: '#EA2F2F',
            cancelButtonColor: '#5E1313',
            customClass: {
                popup: 'gradient-border',
                title: 'text-white',
                content: 'text-gray-300',
                confirmButton: 'hover:opacity-90 transition duration-150',
                cancelButton: 'hover:opacity-90 transition duration-150'
            }
        });

        function updateDriverCount() {
            const totalDrivers = document.getElementById('driverTableBody').rows.length;
            document.getElementById('totalDrivers').textContent = totalDrivers;
        }

        function openAddModal() {
            const modal = document.getElementById('driverModal');
            document.body.classList.add('modal-open');
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-user-plus mr-3 text-[#EA2F2F]"></i>Add New Driver';
            document.getElementById('driverForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('driverForm').action = '{{ route('drivers.store') }}';
            document.getElementById('driver_id_input').readOnly = false;
            document.getElementById('driverId').value = '';
            document.getElementById('license_front_preview').src = 'https://via.placeholder.com/200x120';
            document.getElementById('license_back_preview').src = 'https://via.placeholder.com/200x120';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function openEditModal(driverId) {
            const modal = document.getElementById('driverModal');
            document.body.classList.add('modal-open');
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-user-edit mr-3 text-[#EA2F2F]"></i>Edit Driver';
            document.getElementById('formMethod').value = 'PATCH';
            document.getElementById('driverForm').action = `/admin/drivers/${driverId}`;
            document.getElementById('driver_id_input').readOnly = true;
            document.getElementById('driverId').value = driverId;

            fetch(`/admin/drivers/${driverId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(driver => {
                document.querySelector('input[name="driver_id"]').value = driver.driver_id;
                document.querySelector('input[name="first_name"]').value = driver.first_name;
                document.querySelector('input[name="last_name"]').value = driver.last_name;
                document.querySelector('input[name="email"]').value = driver.email;
                document.querySelector('input[name="contact_number"]').value = driver.contact_number;
                document.querySelector('input[name="nic_number"]').value = driver.nic_number;
                document.querySelector('select[name="license_type"]').value = driver.license_type;
                document.querySelector('input[name="license_id"]').value = driver.license_id;
                document.querySelector('input[name="license_expiry_date"]').value = driver.license_expiry_date;
                document.querySelector('select[name="availability"]').value = driver.availability;
                document.querySelector('textarea[name="address"]').value = driver.address;
                document.getElementById('license_front_preview').src = driver.license_front_image ? `/storage/${driver.license_front_image}` : 'https://via.placeholder.com/200x120';
                document.getElementById('license_back_preview').src = driver.license_back_image ? `/storage/${driver.license_back_image}` : 'https://via.placeholder.com/200x120';
            })
            .catch(error => {
                console.error('Error fetching driver:', error);
                darkSwal.fire('Error', 'Failed to load driver details', 'error');
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function openViewModal(driverId) {
            const modal = document.getElementById('viewModal');
            document.body.classList.add('modal-open');
            fetch(`/admin/drivers/${driverId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(driver => {
                const frontImage = driver.license_front_image ? `/storage/${driver.license_front_image}` : 'https://via.placeholder.com/500x300';
                const backImage = driver.license_back_image ? `/storage/${driver.license_back_image}` : 'https://via.placeholder.com/500x300';

                const safeDisplay = (value, defaultValue = 'Not provided') => value || defaultValue;

                document.getElementById('viewModalContent').innerHTML = `
                    <div class="grid grid-cols-3 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Driver ID</label>
                                <p class="text-white mt-1">${safeDisplay(driver.driver_id)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">First Name</label>
                                <p class="text-white mt-1">${safeDisplay(driver.first_name)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Last Name</label>
                                <p class="text-white mt-1">${safeDisplay(driver.last_name)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Email</label>
                                <p class="text-white mt-1">${safeDisplay(driver.email)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Contact Number</label>
                                <p class="text-white mt-1">${safeDisplay(driver.contact_number)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">NIC Number</label>
                                <p class="text-white mt-1">${safeDisplay(driver.nic_number)}</p>
                            </div>
                        </div>

                        <!-- Middle Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400">License ID</label>
                                <p class="text-white mt-1">${safeDisplay(driver.license_id)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">License Type</label>
                                <p class="text-white mt-1">${safeDisplay(driver.license_type)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">License Expiry Date</label>
                                <p class="text-white mt-1">${safeDisplay(driver.license_expiry_date)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Availability</label>
                                <p class="text-white mt-1">
                                    <span class="status-badge ${driver.availability === 'Available' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20'}">
                                        ${safeDisplay(driver.availability, 'Not Available')}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Address</label>
                                <p class="text-white mt-1">${safeDisplay(driver.address)}</p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">License Images</label>
                                <div class="space-y-4">
                                    <div class="relative">
                                        <img src="${frontImage}" alt="License Front" class="rounded-lg w-full h-48 object-cover">
                                        <span class="absolute top-0 left-0 bg-gray-800 text-white px-2 py-1 text-xs">Front</span>
                                    </div>
                                    <div class="relative mt-4">
                                        <img src="${backImage}" alt="License Back" class="rounded-lg w-full h-48 object-cover">
                                        <span class="absolute top-0 left-0 bg-gray-800 text-white px-2 py-1 text-xs">Back</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching driver details:', error);
                darkSwal.fire('Error', 'Failed to load driver details', 'error');
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

        function closeDriverModal() {
            const modal = document.getElementById('driverModal');
            document.body.classList.remove('modal-open');
            modal.querySelector('.modal-transition').classList.add('modal-enter');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function searchDrivers() {
            const field = document.getElementById('searchField').value;
            const query = document.getElementById('searchQuery').value;

            if (!query.trim()) {
                darkSwal.fire('Warning', 'Please enter a search term', 'warning');
                return;
            }

            fetch(`/admin/driver-management?searchField=${field}&searchQuery=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Failed to fetch drivers');
                }
                const tbody = document.getElementById('driverTableBody');
                tbody.innerHTML = '';
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-400">No drivers found.</td></tr>';
                } else {
                    data.data.forEach(driver => {
                        tbody.innerHTML += `
                            <tr class="hover-gradient transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-300">${driver.driver_id}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${driver.first_name} ${driver.last_name}</td>
                                <td class="px-6 py-4">
                                    <span class="status-badge ${driver.availability === 'Available' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20'}">
                                        ${driver.availability}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-300">${driver.email}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${driver.contact_number}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button onclick="openViewModal('${driver.driver_id}')" class="action-button text-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="openEditModal('${driver.driver_id}')" class="action-button text-green-400 hover:text-green-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteDriver('${driver.driver_id}')" class="action-button text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                updateDriverCount();
                darkSwal.fire('Search Complete', `Found ${data.data.length} driver(s).`, 'info');
            })
            .catch(error => {
                console.error('Search error:', error);
                darkSwal.fire('Error', 'Failed to search drivers: ' + error.message, 'error');
            });
        }

        function deleteDriver(driverId) {
            darkSwal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/drivers/${driverId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            darkSwal.fire('Deleted!', 'Driver has been deleted.', 'success').then(() => window.location.reload());
                        } else {
                            darkSwal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(() => darkSwal.fire('Error!', 'Failed to delete driver.', 'error'));
                }
            });
        }

        document.getElementById('driverForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const method = document.getElementById('formMethod').value;
            const formData = new FormData(form);

            formData.set('_method', method);

            const driverId = document.getElementById('driverId').value || document.querySelector('input[name="driver_id"]').value;
            formData.set('driver_id', driverId);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    darkSwal.fire('Success!', method === 'POST' ? 'Driver added successfully.' : 'Driver updated successfully.', 'success')
                        .then(() => window.location.reload());
                } else {
                    darkSwal.fire('Error!', data.message || 'An error occurred.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                darkSwal.fire('Error!', 'Something went wrong: ' + error.message, 'error');
            });
        });

        function previewImage(event, type) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(`license_${type}_preview`).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        updateDriverCount();
    </script>
@endsection
