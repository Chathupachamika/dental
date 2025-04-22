@extends('layouts.admin-layout')

@section('title', 'Customer Management')

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
                    Customer Management
                </h1>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    <div class="flex rounded-lg overflow-hidden gradient-border flex-1 sm:flex-none">
                        <select id="searchField" name="searchField" class="bg-gray-800 text-gray-300 px-4 py-2">
                            <option value="customer_id">Customer ID</option>
                            <option value="customer_full_name">Full Name</option>
                            <option value="email">Email</option>
                        </select>
                        <input type="text" id="searchQuery" name="searchQuery" placeholder="Search customers..."
                            class="search-input text-gray-300 px-4 py-2 w-full sm:w-64 focus:outline-none">
                        <button onclick="searchCustomers()"
                            class="bg-gradient-to-r from-[#EA2F2F] to-[#5E1313] text-white px-6 py-2 hover:opacity-90 transition duration-150">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button onclick="openAddModal()"
                        class="bg-gradient-to-r from-[#EA2F2F] to-[#5E1313] text-white px-6 py-2 rounded-lg hover:opacity-90 transition duration-150 flex items-center justify-center w-full sm:w-auto">
                        <i class="fas fa-user-plus mr-2"></i> Add Customer
                    </button>
                </div>
            </div>
        </div>

        <!-- Customers Table -->
        <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden gradient-border">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr class="bg-gray-900">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Customer ID</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Full Name</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Contact No</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700" id="customerTableBody">
                        @forelse ($customers as $customer)
                            <tr class="hover-gradient transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $customer->customer_id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $customer->customer_full_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $customer->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $customer->contact_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $customer->test_filter_status }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button onclick="openViewModal('{{ $customer->customer_id }}')"
                                            class="action-button text-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="openEditModal('{{ $customer->customer_id }}')"
                                            class="action-button text-green-400 hover:text-green-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteCustomer('{{ $customer->customer_id }}')"
                                            class="action-button text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-700 px-6 py-4">
                <p class="text-gray-400 text-sm">Total Customers: <span id="totalCustomers">{{ $customers->count() }}</span></p>
            </div>
        </div>

        <!-- View Customer Modal -->
        <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-800 rounded-lg p-8 max-w-4xl w-full modal-transition modal-enter gradient-border modal-content mt-16">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-user mr-3 text-[#EA2F2F]"></i>
                        Customer Details
                    </h2>
                    <button onclick="closeViewModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="viewModalContent" class="grid grid-cols-3 gap-6">
                    <!-- Populated via JavaScript -->
                </div>
            </div>
        </div>

        <!-- Add/Edit Customer Modal -->
        <div id="customerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-800 rounded-lg p-8 max-w-4xl w-full modal-transition modal-enter gradient-border modal-content mt-16">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-bold text-white flex items-center" id="modalTitle">
                        <i class="fas fa-user-plus mr-3 text-[#EA2F2F]"></i>
                        Add New Customer
                    </h2>
                    <button onclick="closeCustomerModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="customerForm" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="customer_id" id="customerId">

                    <!-- Left Column -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Customer ID</label>
                            <input type="text" name="customer_id" id="customer_id_input"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20" readonly>
                            @error('customer_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Full Name</label>
                            <input type="text" name="customer_full_name"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('customer_full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Email</label>
                            <input type="email" name="email"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Contact Number</label>
                            <input type="tel" name="contact_number"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('contact_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">NIC Number</label>
                            <input type="text" name="nic_number"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('nic_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Middle Column -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Request Type</label>
                            <select name="request_type" class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                                <option value="Wedding Car">Wedding Car</option>
                                <option value="Travel & Tourism">Travel & Tourism</option>
                                <option value="Business & Executive">Business & Executive</option>
                                <option value="Economy & Budget Rentals">Economy & Budget Rentals</option>
                                <option value="Special Needs">Special Needs</option>
                                <option value="Others">Others</option>
                            </select>
                            @error('request_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Vehicle Name</label>
                            <input type="text" name="vehicle_name"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('vehicle_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Vehicle ID</label>
                            <input type="text" name="vehicle_id"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('vehicle_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Driver First Name</label>
                            <input type="text" name="driver_first_name"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('driver_first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Driver ID</label>
                            <input type="text" name="driver_id"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('driver_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Test Filter Status</label>
                            <select name="test_filter_status" class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                                <option value="Booked">Booked</option>
                                <option value="Active">Active</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                            @error('test_filter_status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Pick Time/Date</label>
                            <input type="datetime-local" name="pick_time_date"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('pick_time_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400">Return Time/Date</label>
                            <input type="datetime-local" name="return_time_date"
                                class="custom-input mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                            @error('return_time_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-xs font-medium text-gray-400 mb-2">NIC Images</label>
                            <div class="flex flex-col space-y-6">
                                <div class="image-container">
                                    <label class="upload-button upload-zone rounded-full p-2 bg-gray-700 hover:bg-gray-600">
                                        <i class="fas fa-camera text-[#EA2F2F]"></i>
                                        <input type="file" name="nic_front_image" class="hidden" accept="image/*" onchange="previewImage(event, 'front')">
                                    </label>
                                    <img id="nic_front_preview" src="https://via.placeholder.com/200x120" class="image-preview" alt="NIC Front">
                                </div>
                                <div class="image-container">
                                    <label class="upload-button upload-zone rounded-full p-2 bg-gray-700 hover:bg-gray-600">
                                        <i class="fas fa-camera text-[#EA2F2F]"></i>
                                        <input type="file" name="nic_back_image" class="hidden" accept="image/*" onchange="previewImage(event, 'back')">
                                    </label>
                                    <img id="nic_back_preview" src="https://via.placeholder.com/200x120" class="image-preview" alt="NIC Back">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-full flex justify-end space-x-4">
                        <button type="button" onclick="closeCustomerModal()"
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

        function updateCustomerCount() {
            const totalCustomers = document.getElementById('customerTableBody').rows.length;
            document.getElementById('totalCustomers').textContent = totalCustomers;
        }

        function openAddModal() {
            const modal = document.getElementById('customerModal');
            document.body.classList.add('modal-open');
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-user-plus mr-3 text-[#EA2F2F]"></i>Add New Customer';
            document.getElementById('customerForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('customerForm').action = '{{ route('customers.store') }}';
            document.getElementById('customerId').value = '';
            document.getElementById('nic_front_preview').src = 'https://via.placeholder.com/200x120';
            document.getElementById('nic_back_preview').src = 'https://via.placeholder.com/200x120';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function openEditModal(customerId) {
            const modal = document.getElementById('customerModal');
            document.body.classList.add('modal-open');
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-user-edit mr-3 text-[#EA2F2F]"></i>Edit Customer';
            document.getElementById('formMethod').value = 'PATCH';
            document.getElementById('customerForm').action = `/admin/customers/${customerId}`;
            document.getElementById('customer_id_input').readOnly = true;
            document.getElementById('customerId').value = customerId;

            fetch(`/admin/customers/${customerId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(customer => {
                document.querySelector('input[name="customer_id"]').value = customer.customer_id;
                document.querySelector('input[name="customer_full_name"]').value = customer.customer_full_name;
                document.querySelector('input[name="email"]').value = customer.email;
                document.querySelector('input[name="contact_number"]').value = customer.contact_number;
                document.querySelector('input[name="nic_number"]').value = customer.nic_number;
                document.querySelector('select[name="request_type"]').value = customer.request_type;
                document.querySelector('input[name="vehicle_name"]').value = customer.vehicle_name || '';
                document.querySelector('input[name="vehicle_id"]').value = customer.vehicle_id || '';
                document.querySelector('input[name="driver_first_name"]').value = customer.driver_first_name || '';
                document.querySelector('input[name="driver_id"]').value = customer.driver_id || '';
                document.querySelector('input[name="pick_time_date"]').value = customer.pick_time_date ? new Date(customer.pick_time_date).toISOString().slice(0,16) : '';
                document.querySelector('input[name="return_time_date"]').value = customer.return_time_date ? new Date(customer.return_time_date).toISOString().slice(0,16) : '';
                document.querySelector('select[name="test_filter_status"]').value = customer.test_filter_status;
                document.getElementById('nic_front_preview').src = customer.nic_front_image ? `/storage/${customer.nic_front_image}` : 'https://via.placeholder.com/200x120';
                document.getElementById('nic_back_preview').src = customer.nic_back_image ? `/storage/${customer.nic_back_image}` : 'https://via.placeholder.com/200x120';
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function openViewModal(customerId) {
            const modal = document.getElementById('viewModal');
            document.body.classList.add('modal-open');
            fetch(`/admin/customers/${customerId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(customer => {
                const frontImage = customer.nic_front_image ? `/storage/${customer.nic_front_image}` : 'https://via.placeholder.com/500x300';
                const backImage = customer.nic_back_image ? `/storage/${customer.nic_back_image}` : 'https://via.placeholder.com/500x300';
                document.getElementById('viewModalContent').innerHTML = `
                    <div class="space-y-4">
                        <div><label class="block text-sm font-medium text-gray-400">Customer ID</label><p class="text-white mt-1">${customer.customer_id}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">Full Name</label><p class="text-white mt-1">${customer.customer_full_name}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">Email</label><p class="text-white mt-1">${customer.email}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">Contact Number</label><p class="text-white mt-1">${customer.contact_number}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">NIC Number</label><p class="text-white mt-1">${customer.nic_number}</p></div>
                    </div>
                    <div class="space-y-4">
                        <div><label class="block text-sm font-medium text-gray-400">Request Type</label><p class="text-white mt-1">${customer.request_type}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">Vehicle Name</label><p class="text-white mt-1">${customer.vehicle_name || 'N/A'}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">Vehicle ID</label><p class="text-white mt-1">${customer.vehicle_id || 'N/A'}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">Driver Name</label><p class="text-white mt-1">${customer.driver_first_name || 'N/A'}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">Driver ID</label><p class="text-white mt-1">${customer.driver_id || 'N/A'}</p></div>
                        <div><label class="block text-sm font-medium text-gray-400">Status</label><p class="text-white mt-1">${customer.test_filter_status}</p></div>
                    </div>
                    <div class="space-y-4">
                        <div><label class="block text-sm font-medium text-gray-400 mb-2">NIC Front</label>
                            <div class="relative w-full h-48 mb-4">
                                <img src="${frontImage}" alt="NIC Front" class="rounded-lg w-full h-full object-cover">
                            </div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-400 mb-2">NIC Back</label>
                            <div class="relative w-full h-48">
                                <img src="${backImage}" alt="NIC Back" class="rounded-lg w-full h-full object-cover">
                            </div>
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

        function closeCustomerModal() {
            const modal = document.getElementById('customerModal');
            document.body.classList.remove('modal-open');
            modal.querySelector('.modal-transition').classList.add('modal-enter');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function searchCustomers() {
            const field = document.getElementById('searchField').value;
            const query = document.getElementById('searchQuery').value;

            if (!query.trim()) {
                darkSwal.fire({
                    title: 'Warning',
                    text: 'Please enter a search term',
                    icon: 'warning'
                });
                return;
            }

            fetch(`/admin/customer-management?searchField=${field}&searchQuery=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Failed to fetch customers');
                }
                const tbody = document.getElementById('customerTableBody');
                tbody.innerHTML = '';
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-400">No customers found.</td></tr>';
                } else {
                    data.data.forEach(customer => {
                        tbody.innerHTML += `
                            <tr class="hover-gradient transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-300">${customer.customer_id}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${customer.customer_full_name}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${customer.email}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${customer.contact_number}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${customer.test_filter_status}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button onclick="openViewModal('${customer.customer_id}')" class="action-button text-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="openEditModal('${customer.customer_id}')" class="action-button text-green-400 hover:text-green-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteCustomer('${customer.customer_id}')" class="action-button text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                updateCustomerCount();
                darkSwal.fire({
                    title: 'Search Complete',
                    text: `Found ${data.data.length} customer(s).`,
                    icon: 'info'
                });
            })
            .catch(error => {
                console.error('Search error:', error);
                darkSwal.fire({
                    title: 'Error',
                    text: 'Failed to search customers: ' + error.message,
                    icon: 'error'
                });
            });
        }

        function deleteCustomer(customerId) {
            darkSwal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/customers/${customerId}`, {
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
                                text: "Customer has been deleted.",
                                icon: "success"
                            }).then(() => window.location.reload());
                        } else {
                            darkSwal.fire("Error!", data.message, "error");
                        }
                    })
                    .catch(() => darkSwal.fire("Error!", "Failed to delete customer.", "error"));
                }
            });
        }

        document.getElementById('customerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const method = document.getElementById('formMethod').value;
            const formData = new FormData(form);

            formData.set('_method', method);

            const customerId = document.getElementById('customerId').value || document.querySelector('input[name="customer_id"]').value;
            formData.set('customer_id', customerId);

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
                    darkSwal.fire({
                        title: "Success!",
                        text: method === 'POST' ? "Customer added successfully." : "Customer updated successfully.",
                        icon: "success"
                    }).then(() => window.location.reload());
                } else {
                    darkSwal.fire("Error!", data.message || "An error occurred.", "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                darkSwal.fire("Error!", "Something went wrong: " + error.message, "error");
            });
        });

        function previewImage(event, type) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(`nic_${type}_preview`).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        updateCustomerCount();
    </script>
@endsection
