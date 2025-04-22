@extends('layouts.admin-layout')

@section('title', 'Booking Management')

@section('styles')
    <style>
        .modal-transition { transition: all 0.3s ease-out; }
        .modal-enter { opacity: 0; transform: scale(0.95); }
        .modal-enter-active { opacity: 1; transform: scale(1); }
        .gradient-border { position: relative; border-radius: 0.5rem; }
        .gradient-border::before {
            content: ''; position: absolute; top: -1px; left: -1px; right: -1px; bottom: -1px;
            border-radius: 0.6rem; z-index: -1; opacity: 0.5; background: linear-gradient(45deg, #EA2F2F, #5E1313);
        }
        .hover-gradient:hover { background: linear-gradient(45deg, rgba(255, 8, 8, 0.15), rgba(52, 0, 0, 0.15)); }
        .search-input { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); transition: all 0.3s ease; border: none; }
        .search-input:focus { background: rgba(255, 255, 255, 0.1); box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1); }
        .action-button { transition: all 0.2s ease; }
        .action-button:hover { transform: translateY(-2px); }
        ::-webkit-scrollbar { width: 10px; background: #1a1a2e; }
        ::-webkit-scrollbar-thumb { background: #EA2F2F; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #7d1010; }
        .modal-content { max-height: 80vh; overflow-y: auto; }
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
                    <i class="fas fa-calendar-check mr-3 text-[#EA2F2F]"></i>
                    Booking Management
                </h1>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    <div class="flex rounded-lg overflow-hidden gradient-border flex-1 sm:flex-none">
                        <select id="searchField" class="bg-gray-800 text-gray-300 px-4 py-2">
                            <option value="booking_id">Request ID</option>
                            <option value="customer_full_name">Customer</option>
                            <option value="model">Model</option>
                            <option value="test_filter_status">Status</option>
                        </select>
                        <input type="text" id="searchQuery" placeholder="Search bookings..."
                            class="search-input text-gray-300 px-4 py-2 w-full sm:w-64 focus:outline-none">
                        <button onclick="searchBookings()"
                            class="bg-gradient-to-r from-[#EA2F2F] to-[#5E1313] text-white px-6 py-2 hover:opacity-90 transition duration-150">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button onclick="openAddModal()"
                        class="bg-gradient-to-r from-[#EA2F2F] to-[#5E1313] text-white px-6 py-2 rounded-lg hover:opacity-90 transition duration-150 flex items-center justify-center w-full sm:w-auto">
                        <i class="fas fa-plus mr-2"></i> Add Booking
                    </button>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden gradient-border">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr class="bg-gray-900">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Request ID</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Customer Name</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Model</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Email Address</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Contact No</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700" id="bookingTableBody">
                        @forelse ($bookings as $booking)
                            <tr class="hover-gradient transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $booking->booking_id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $booking->customer_full_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $booking->vehicle->model }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $booking->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $booking->contact_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $booking->test_filter_status }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button onclick="openViewModal('{{ $booking->booking_id }}')" class="action-button text-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="openEditModal('{{ $booking->booking_id }}')" class="action-button text-green-400 hover:text-green-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteBooking('{{ $booking->booking_id }}')" class="action-button text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-400">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-700 px-6 py-4">
                <p class="text-gray-400 text-sm">Total Bookings: <span id="totalBookings">{{ $bookings->count() }}</span></p>
            </div>
        </div>

        <!-- View Booking Modal -->
        <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-800 rounded-lg p-6 max-w-7xl w-full modal-transition modal-enter gradient-border modal-content mt-16">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-info-circle mr-3 text-[#EA2F2F]"></i>
                        Booking Details
                    </h2>
                    <button onclick="closeViewModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="viewModalContent" class="grid grid-cols-3 gap-6">
                    <!-- Content will be populated via JavaScript -->
                </div>
            </div>
        </div>

        <!-- Add/Edit Booking Modal -->
        <div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-gray-800 rounded-lg p-6 max-w-5xl w-full modal-transition modal-enter gradient-border modal-content mt-16">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-white flex items-center" id="modalTitle">
                        <i class="fas fa-plus-circle mr-3 text-[#EA2F2F]"></i>
                        Add New Booking
                    </h2>
                    <button onclick="closeBookingModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="bookingForm" enctype="multipart/form-data" class="grid grid-cols-3 gap-6">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="booking_id" id="bookingId">

                    <!-- Driver Options -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Driver Option</label>
                            <div class="mt-1 flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="driver_option" value="With Driver" class="mr-2 bg-gray-700 border-gray-600 text-[#EA2F2F] focus:ring-[#EA2F2F]" checked onchange="toggleDriverFields()">
                                    With Driver
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="driver_option" value="Without Driver" class="mr-2 bg-gray-700 border-gray-600 text-[#EA2F2F] focus:ring-[#EA2F2F]" onchange="toggleDriverFields()">
                                    Without Driver
                                </label>
                            </div>
                        </div>
                        <div id="driverField">
                            <label class="block text-sm font-medium text-gray-400">Driver ID</label>
                            <select name="driver_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                                <option value="">No Driver</option>
                                @foreach (\App\Models\Driver::where('availability', 'Available')->get() as $driver)
                                    <option value="{{ $driver->driver_id }}">{{ $driver->driver_id }} - {{ $driver->first_name }} {{ $driver->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Request Type</label>
                            <select name="request_type" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                                <option value="Wedding Car">Wedding Car</option>
                                <option value="Travel & Tourism">Travel & Tourism</option>
                                <option value="Business & Executive">Business & Executive</option>
                                <option value="Economy & Budget Rentals">Economy & Budget Rentals</option>
                                <option value="Special Needs">Special Needs</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Vehicle ID</label>
                            <select name="vehicle_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                                <option value="">Select Vehicle</option>
                                @foreach (\App\Models\Vehicle::where('status', 'Available')->get() as $vehicle)
                                    <option value="{{ $vehicle->car_id }}">{{ $vehicle->car_id }} - {{ $vehicle->model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Status</label>
                            <select name="test_filter_status" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                                <option value="Booked">Booked</option>
                                <option value="Active">Active</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div>
                            <label id="locationLabel" class="block text-sm font-medium text-gray-400">Location</label>
                            <input type="text" name="location" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Customer Full Name</label>
                            <input type="text" name="customer_full_name" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Email Address</label>
                            <input type="email" name="email" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Contact Number</label>
                            <input type="tel" name="contact_number" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">NIC Number</label>
                            <input type="text" name="nic_number" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                    </div>

                    <!-- Date and Time -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Pick Date</label>
                            <input type="date" name="pick_date" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Pick Time</label>
                            <input type="time" name="pick_time" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Return Date</label>
                            <input type="date" name="return_date" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Return Time</label>
                            <input type="time" name="return_time" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white text-sm py-2 focus:border-[#EA2F2F] focus:ring focus:ring-red-500/20">
                        </div>
                    </div>

                    <div class="col-span-full flex justify-end space-x-4">
                        <button type="button" onclick="closeBookingModal()"
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

        function updateBookingCount() {
            const totalBookings = document.getElementById('bookingTableBody').rows.length;
            document.getElementById('totalBookings').textContent = totalBookings;
        }

        function toggleDriverFields() {
            const driverOption = document.querySelector('input[name="driver_option"]:checked').value;
            const driverField = document.getElementById('driverField');
            const locationLabel = document.getElementById('locationLabel');

            if (driverOption === 'With Driver') {
                driverField.style.display = 'block';
                locationLabel.textContent = 'Location';
            } else {
                driverField.style.display = 'none';
                locationLabel.textContent = 'Address';
                document.querySelector('select[name="driver_id"]').value = '';
            }
        }

        function openAddModal() {
            const modal = document.getElementById('bookingModal');
            document.body.classList.add('modal-open');
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle mr-3 text-[#EA2F2F]"></i>Add New Booking';
            document.getElementById('bookingForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('bookingForm').action = '{{ route('bookings.store') }}';
            document.getElementById('bookingId').value = '';
            document.querySelector('input[name="driver_option"][value="With Driver"]').checked = true;
            document.querySelector('select[name="test_filter_status"]').value = 'Booked';
            toggleDriverFields();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function openEditModal(bookingId) {
            const modal = document.getElementById('bookingModal');
            document.body.classList.add('modal-open');
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit mr-3 text-[#EA2F2F]"></i>Edit Booking';
            document.getElementById('formMethod').value = 'PATCH';
            document.getElementById('bookingForm').action = `/admin/bookings/${bookingId}`;
            document.getElementById('bookingId').value = bookingId;

            fetch(`/admin/bookings/${bookingId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(booking => {
                document.querySelector('input[name="customer_full_name"]').value = booking.customer_full_name;
                document.querySelector('input[name="email"]').value = booking.email;
                document.querySelector('input[name="contact_number"]').value = booking.contact_number;
                document.querySelector('input[name="nic_number"]').value = booking.nic_number;
                document.querySelector('select[name="request_type"]').value = booking.request_type;
                document.querySelector('select[name="vehicle_id"]').value = booking.vehicle_id;
                document.querySelector('select[name="test_filter_status"]').value = booking.test_filter_status;
                document.querySelector('input[name="location"]').value = booking.location;
                document.querySelector('input[name="driver_option"][value="' + booking.driver_option + '"]').checked = true;
                document.querySelector('select[name="driver_id"]').value = booking.driver_id || '';
                document.querySelector('input[name="pick_date"]').value = booking.pick_date;
                document.querySelector('input[name="pick_time"]').value = booking.pick_time;
                document.querySelector('input[name="return_date"]').value = booking.return_date;
                document.querySelector('input[name="return_time"]').value = booking.return_time;
                toggleDriverFields();
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-transition').classList.remove('modal-enter');
            }, 10);
        }

        function openViewModal(bookingId) {
            const modal = document.getElementById('viewModal');
            document.body.classList.add('modal-open');
            fetch(`/admin/bookings/${bookingId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(booking => {
                const vehicleInfo = booking.vehicle ? `${booking.vehicle_id} - ${booking.vehicle.model}` : 'No Vehicle';
                const driverInfo = booking.driver ? `${booking.driver_id} - ${booking.driver.first_name} ${booking.driver.last_name}` : 'No Driver';

                document.getElementById('viewModalContent').innerHTML = `
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Customer Name</label>
                            <p class="text-white mt-1">${booking.customer_full_name}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Email</label>
                            <p class="text-white mt-1">${booking.email}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Contact Number</label>
                            <p class="text-white mt-1">${booking.contact_number}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">NIC Number</label>
                            <p class="text-white mt-1">${booking.nic_number}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Status</label>
                            <p class="text-white mt-1">${booking.test_filter_status}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Driver Option</label>
                            <p class="text-white mt-1">${booking.driver_option}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Driver</label>
                            <p class="text-white mt-1">${driverInfo}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Vehicle</label>
                            <p class="text-white mt-1">${vehicleInfo}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Request Type</label>
                            <p class="text-white mt-1">${booking.request_type}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">${booking.driver_option === 'With Driver' ? 'Location' : 'Address'}</label>
                            <p class="text-white mt-1">${booking.location}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Pick Date & Time</label>
                            <p class="text-white mt-1">${booking.pick_date} ${booking.pick_time}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400">Return Date & Time</label>
                            <p class="text-white mt-1">${booking.return_date} ${booking.return_time}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">NIC Front Image</label>
                            <img src="${booking.nic_front_image ? `/storage/${booking.nic_front_image}` : 'https://via.placeholder.com/400x250'}"
                                 alt="NIC Front"
                                 class="w-full h-48 object-cover rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">NIC Back Image</label>
                            <img src="${booking.nic_back_image ? `/storage/${booking.nic_back_image}` : 'https://via.placeholder.com/400x250'}"
                                 alt="NIC Back"
                                 class="w-full h-48 object-cover rounded-lg">
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

        function closeBookingModal() {
            const modal = document.getElementById('bookingModal');
            document.body.classList.remove('modal-open');
            modal.querySelector('.modal-transition').classList.add('modal-enter');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function searchBookings() {
            const field = document.getElementById('searchField').value;
            const query = document.getElementById('searchQuery').value;

            fetch(`/admin/bookings?${field}=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('bookingTableBody');
                tbody.innerHTML = '';
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-4 text-center text-gray-400">No bookings found.</td></tr>';
                } else {
                    data.forEach(booking => {
                        tbody.innerHTML += `
                            <tr class="hover-gradient transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-300">${booking.booking_id}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${booking.customer_full_name}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${booking.vehicle.model}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${booking.email}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${booking.contact_number}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">${booking.test_filter_status}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button onclick="openViewModal('${booking.booking_id}')" class="action-button text-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="openEditModal('${booking.booking_id}')" class="action-button text-green-400 hover:text-green-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteBooking('${booking.booking_id}')" class="action-button text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                updateBookingCount();
                darkSwal.fire({
                    title: 'Search Complete',
                    text: `Found ${data.length} booking(s).`,
                    icon: 'info'
                });
            })
            .catch(() => {
                darkSwal.fire({
                    title: 'Error',
                    text: 'Failed to search bookings.',
                    icon: 'error'
                });
            });
        }

        function deleteBooking(bookingId) {
            darkSwal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/bookings/${bookingId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            darkSwal.fire({
                                title: "Deleted!",
                                text: "Booking has been deleted.",
                                icon: "success"
                            }).then(() => window.location.reload());
                        } else {
                            darkSwal.fire("Error!", data.message, "error");
                        }
                    })
                    .catch(() => darkSwal.fire("Error!", "Failed to delete booking.", "error"));
                }
            });
        }

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const method = document.getElementById('formMethod').value;
            const formData = new FormData(form);
            formData.set('_method', method);

            const bookingId = document.getElementById('bookingId').value;
            formData.set('booking_id', bookingId);

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
                        text: method === 'POST' ? "Booking added successfully." : "Booking updated successfully.",
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

        updateBookingCount();
    </script>
@endsection
