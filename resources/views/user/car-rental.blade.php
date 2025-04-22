@extends('layouts.user-layout')

@section('title', 'CASONS - Car Rental')

@section('styles')
<style>
    body {
        background-color: #1b253c;
        color: #ffffff;
        font-family: 'Inter', sans-serif;
    }

    .container {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .scroll-indicator {
        opacity: 1;
        transition: opacity 0.5s ease;
        z-index: 10;
        position: relative;
        width: 40px;
    }

    .scroll-indicator.hide {
        opacity: 0;
    }

    .arrow-1, .arrow-2, .arrow-3 {
        animation: fadeInOut 2s infinite;
        transform: translateX(0);
        position: absolute;
    }

    .arrow-1 { left: 0; }
    .arrow-2 { animation-delay: 0.2s; left: 15px; }
    .arrow-3 { animation-delay: 0.4s; left: 30px; }

    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateX(-15px); }
        50% { opacity: 1; transform: translateX(0); }
        100% { opacity: 0; transform: translateX(15px); }
    }

    .scroll-progress-33 .arrow-1,
    .scroll-progress-66 .arrow-2,
    .scroll-progress-100 .arrow-3 {
        opacity: 0;
        transform: translateX(15px);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Scrollbar Styles */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track { background: #1f2937; }
    ::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #6b7280; }

    /* Modal Styles */
    .modal-overlay {
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }

    .modal-content {
        background: linear-gradient(145deg, #1f2937, #111827);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-content.active {
        transform: scale(1);
        opacity: 1;
    }

    /* Form Elements */
    input[type="text"], input[type="date"], input[type="time"], select, textarea {
        background-color: rgba(55, 65, 81, 0.8);
        border: 1px solid rgba(75, 85, 99, 0.4);
        transition: all 0.3s ease;
        color: #ffffff;
    }

    input[type="text"]:focus, input[type="date"]:focus, input[type="time"]:focus, select:focus, textarea:focus {
        background-color: rgba(75, 85, 99, 0.9);
        border-color: #ef4444;
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
    }

    /* Select Styles */
    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23ffffff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 20px;
        padding: 10px 14px;
        border-radius: 6px;
    }

    /* Button Styles */
    .btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .btn::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: -100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn:hover::after { left: 100%; }

    button {
        background: linear-gradient(135deg, #EA2F2F, #5E1313);
        transition: all 0.3s ease;
    }

    button:hover { background: linear-gradient(135deg, #fc1010, #380606); }
    .btn-gray { background: linear-gradient(135deg, #888888, #4B4B4B); }
    .btn-gray:hover { background: linear-gradient(135deg, #686868, #333333); }

    /* Card Styles */
    .car-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .car-image {
        transition: all 0.5s ease;
    }

    .car-image:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }

    /* Theme Colors */
    .bg-gray-800 { background-color: #1f2937; }
    .bg-gray-700 { background-color: #374151; }
    .text-white { color: #ffffff; }
    .text-gray-400 { color: #9ca3af; }
    .text-gray-300 { color: #d1d5db; }

    /* Car Rental Section */
    #carRentalImage {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    #carRentalContent {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>
@endsection
@include('scroll-indicator.scroll-indicator')
@section('scripts')
    <script>
        // Fetch vehicles
        async function fetchVehicles(category = '', carType = '', color = '') {
            const loading = document.getElementById('loading');
            const error = document.getElementById('error');
            const vehicleList = document.getElementById('vehicle-list');

            try {
                error.classList.add('hidden');
                loading.classList.remove('hidden');
                vehicleList.innerHTML = '';

                let url = '/admin/vehicle-management';
                const params = new URLSearchParams();

                if (category) params.append('category', category);
                if (carType) params.append('car_type', carType);
                if (color) params.append('color', color);

                if (params.toString()) url += `?${params.toString()}`;

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const vehicles = await response.json();
                console.log(vehicles);
                loading.classList.add('hidden');

                if (vehicles.length === 0) {
                    vehicleList.innerHTML = '<p class="text-center col-span-full text-white">No vehicles available.</p>';
                    return;
                }

                vehicles.forEach(vehicle => {
                    const images = vehicle.image ? JSON.parse(vehicle.image) : [];
                    const imageUrl = images.length > 0 ? `/storage/${images[0]}` : 'https://via.placeholder.com/300x200';

                    const vehicleCard = `
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl car-card">
                        <img src="${imageUrl}" alt="${vehicle.model}" class="w-full h-48 object-cover car-image">
                        <div class="p-4">
                            <h3 class="text-xl font-bold mb-2">${vehicle.model}</h3>
                            <div class="space-y-2 text-gray-300">
                                <p><i class="fas fa-users mr-2"></i> Seats: ${vehicle.number_of_passenger}</p>
                                <p><i class="fas fa-door-closed mr-2"></i> ${vehicle.transmission_type}</p>
                                <p><i class="fas fa-gas-pump mr-2"></i> ${vehicle.fuel}</p>
                                <p><i class="fas fa-info-circle mr-2"></i> ${vehicle.status}</p>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <div class="text-red-500 font-bold">LKR ${vehicle.daily_rate}/day</div>
                                <button onclick="showCarDetails('${vehicle.car_id}')"
                                    class="btn text-white px-4 py-2 rounded">
                                    Get
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    vehicleList.insertAdjacentHTML('beforeend', vehicleCard);
                });
            } catch (err) {
                console.error('Error fetching vehicles:', err);
                loading.classList.add('hidden');
                error.classList.remove('hidden');
            }
        }
       let currentVehicleId = null;

        // Show car details
        async function showCarDetails(carId) {
            currentVehicleId = carId; // Store the vehicle ID globally
            const modal = document.getElementById('carDetailsModal');
            const title = document.getElementById('carDetailsTitle');
            const image = document.getElementById('carDetailsImage');
            const description = document.getElementById('carDescription');

            try {
                const response = await fetch(`/admin/vehicles/${carId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                if (!response.ok) throw new Error('Failed to fetch vehicle details');

                const vehicle = await response.json();

                title.textContent = `${vehicle.model} (${vehicle.year || 'N/A'})`;
                const images = vehicle.image ? (Array.isArray(vehicle.image) ? vehicle.image : JSON.parse(vehicle.image)) : [];
                image.src = images.length > 0 ? `/storage/${images[0]}` : 'https://via.placeholder.com/400x300';

                description.innerHTML = `
                <p class="mb-4">${vehicle.description || 'No description available.'}</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-semibold mb-2">Specifications</h4>
                        <ul class="space-y-2 text-gray-300">
                            <li><i class="fas fa-users mr-2"></i> ${vehicle.number_of_passenger} Seats</li>
                            <li><i class="fas fa-door-closed mr-2"></i> ${vehicle.transmission_type}</li>
                            <li><i class="fas fa-gas-pump mr-2"></i> ${vehicle.fuel}</li>
                            <li><i class="fas fa-palette mr-2"></i> ${vehicle.color}</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Rates & Details</h4>
                        <ul class="space-y-2 text-gray-300">
                            <li><i class="fas fa-tag mr-2"></i> LKR ${vehicle.daily_rate}/day</li>
                            <li><i class="fas fa-road mr-2"></i> ${vehicle.free_mileage}km free</li>
                            <li><i class="fas fa-car mr-2"></i> ${vehicle.car_type}</li>
                            <li><i class="fas fa-info-circle mr-2"></i> ${vehicle.status}</li>
                        </ul>
                    </div>
                </div>
            `;

                modal.style.display = 'flex';
                setTimeout(() => {
                    modal.querySelector('.modal-content').classList.add('active');
                }, 10);
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to load vehicle details.');
            }
        }

        // Close car details
        function closeCarDetails() {
            const modal = document.getElementById('carDetailsModal');
            modal.querySelector('.modal-content').classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Book car with form data submission
        // Function to book a car
            async function bookCar() {
                Swal.fire({
                    title: 'Confirm Booking',
                    text: 'Are you sure you want to book this car?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Book it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#4B5563'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // Collect form data
                        const formData = new FormData();
                        const driverOptionElement = document.querySelector('input[name="driver"]:checked');
                        const driverOption = driverOptionElement ? driverOptionElement.value : null;
                        const nicNumber = document.getElementById('nic_number').value;
                        const requestType = document.querySelector('select[name="request_type"]').value;
                        const location = document.getElementById('locationInput').value;
                        const pickDate = document.querySelector('input[name="pick_date"]').value;
                        const pickTime = document.querySelector('input[name="pick_time"]').value;
                        const returnDate = document.querySelector('input[name="return_date"]').value;
                        const returnTime = document.querySelector('input[name="return_time"]').value;

                        // Check if driver option is selected
                        if (!driverOption) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Please select a driver option.',
                                icon: 'error',
                                confirmButtonColor: '#EF4444'
                            });
                            return;
                        }

                        // Get authenticated user details
                        const user = @json(auth()->user());
                        formData.append('customer_full_name', user.name);
                        formData.append('email', user.email);
                        formData.append('contact_number', user.mobile_number || '0775456554');

                        formData.append('request_type', requestType);
                        formData.append('pick_date', pickDate);
                        formData.append('pick_time', pickTime);
                        formData.append('return_date', returnDate);
                        formData.append('return_time', returnTime);
                        formData.append('location', location);
                        formData.append('driver_option', driverOption === 'with_driver' ? 'With Driver' : 'Without Driver');
                        formData.append('vehicle_id', currentVehicleId);
                        formData.append('nic_number', nicNumber);
                        formData.append('driver_id', null);


                        try {
                            const response = await fetch('/bookings', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });

                            const result = await response.json();

                            if (response.ok && result.success) {
                                Swal.fire({
                                    title: 'Booking Successful!',
                                    text: 'Your car has been booked.',
                                    icon: 'success',
                                    confirmButtonColor: '#EF4444'
                                });
                                closeCarDetails();
                            } else {
                                throw new Error(result.message || 'Booking failed');
                            }
                        } catch (error) {
                            console.error('Error booking car:', error);
                            Swal.fire({
                                title: 'Booking Failed!',
                                text: error.message || 'An error occurred while booking the car.',
                                icon: 'error',
                                confirmButtonColor: '#EF4444'
                            });
                        }
                    }
                });
            }
        // Filter modal controls
        function showFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.querySelector('.modal-content').classList.add('active');
            }, 10);
        }

        function closeFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.querySelector('.modal-content').classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Apply filter
    function applyFilter() {
            // Select elements properly
            const carTypeElement = document.querySelector('select[name="car_type"]');
            const colorElement = document.querySelector('select[name="color"]');
            const categoryElement = document.querySelector('select[name="request_type"]'); // If exists

            // Check if elements exist before accessing `.value`
            if (!carTypeElement || !colorElement) {
                console.error("One or more select elements not found.");
                return; // Stop execution if elements are missing
            }

            // Get selected values
            const carType = carTypeElement.value;
            const color = colorElement.value;
            const category = categoryElement ? categoryElement.value : '';

            // Clear previous results before fetching new ones
            const vehicleList = document.getElementById('vehicle-list');
            vehicleList.innerHTML = '';

            // Fetch filtered vehicles (ONLY CALL ONCE)
            fetchVehicles(category, carType, color);

            // Close modal if function exists
            if (typeof closeFilterModal === "function") {
                closeFilterModal();
            }
        }


        // Show filter modal
        function showFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.querySelector('.modal-content').classList.add('active');
            }, 10);
        }

        // Close filter modal
        function closeFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.querySelector('.modal-content').classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Scroll indicator
        document.addEventListener('DOMContentLoaded', () => {
            fetchVehicles();

            const scrollIndicators = document.querySelectorAll('.scroll-indicator');
            const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

            window.addEventListener('scroll', () => {
                const scrollProgress = (window.scrollY / maxScroll) * 100;
                scrollIndicators.forEach(indicator => {
                    indicator.classList.toggle('scroll-progress-33', scrollProgress > 0);
                    indicator.classList.toggle('scroll-progress-66', scrollProgress > 33);
                    indicator.classList.toggle('scroll-progress-100', scrollProgress > 66);
                    indicator.classList.toggle('hide', scrollProgress > 90);
                    if (scrollProgress === 0) {
                        indicator.classList.remove('scroll-progress-33', 'scroll-progress-66', 'scroll-progress-100', 'hide');
                    }
                });
            });

            // Close modals on outside click
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeCarDetails();
                        closeFilterModal();
                    }
                });
            });

            // Category filter
            document.querySelector('select[name="request_type"]').addEventListener('change', (e) => {
                fetchVehicles(e.target.value);
            });
        });
    </script>
@endsection

@section('content')
                    <div class="container mx-auto px-8 mt-10 mb-20">
                        <!-- Rental Form -->
                        <div class="bg-gray-800 rounded-lg p-6 shadow-xl mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div id="carRentalImage" class="flex items-center justify-center p-4 border-4 border-gray-600 rounded-lg">
                                    <img src="/images/user/carrental.png" alt="Luxury Car" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div id="carRentalContent" class="flex flex-col space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-white mb-2">Driver Option</label>
                                        <div class="space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="driver" value="with_driver" class="form-radio text-red-500"
                                                    onchange="updateLocationField(this)" {{ session('booking.driver_option') === 'with' ? 'checked' : '' }}>
                                                <span class="ml-2 text-white">With Driver</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="driver" value="without_driver" class="form-radio text-red-500"
                                                    onchange="updateLocationField(this)" {{ session('booking.driver_option') === 'without' ? 'checked' : '' }}>
                                                <span class="ml-2 text-white">Without Driver</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-white mb-2">NIC Number</label>
                                        <input type="text" id="nic_number" name="nic_number"
                                            class="w-full bg-gray-700 text-white border border-gray-500 rounded-md p-2"
                                            placeholder="Enter NIC Number" value="{{ session('booking.nic_number') }}">
                                    </div>
                                    <div>
                                        <select name="request_type"
                                            class="w-full bg-gray-700 text-white border border-gray-700 rounded-md px-4 py-2">
                                            <option value="" disabled selected>Purpose</option>
                                            @php
$purposes = ['Wedding Car', 'Travel & Tourism', 'Business & Executive', 'Economy & Budget Rentals', 'Special Needs', 'Others'];
                                            @endphp
                                            @foreach($purposes as $purpose)
                                                <option value="{{ $purpose }}" {{ session('booking.request_type') === $purpose ? 'selected' : '' }}>{{ $purpose }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label id="locationLabel" class="block text-sm font-medium text-white mb-2">Location</label>
                                        <input type="text" id="locationInput" name="location"
                                            class="w-full bg-gray-700 text-white border border-gray-500 rounded-md p-2"
                                            placeholder="Enter location" value="{{ session('booking.location') }}">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-white mb-1">Pick-up date</label>
                                            <input type="date" name="pick_date"
                                                class="w-full bg-gray-700 border border-gray-500 rounded-md px-4 py-2"
                                                value="{{ session('booking.pick_date') }}">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-white mb-1">Time</label>
                                            <input type="time" name="pick_time"
                                                class="w-full bg-gray-700 border border-gray-500 rounded-md px-4 py-2"
                                                value="{{ session('booking.pick_time') }}">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-white mb-1">Drop-off date</label>
                                            <input type="date" name="return_date"
                                                class="w-full bg-gray-700 border border-gray-500 rounded-md px-4 py-2"
                                                value="{{ session('booking.return_date') }}">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-white mb-1">Time</label>
                                            <input type="time" name="return_time"
                                                class="w-full bg-gray-700 border border-gray-500 rounded-md px-4 py-2"
                                                value="{{ session('booking.return_time') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter and Search -->
                        <div class="flex justify-end mb-8">
                            <div class="w-full md:w-1/3 lg:w-1/4 flex items-center bg-gray-800 rounded-md overflow-hidden">
                                <div class="relative flex-grow">
                                    <input type="text" placeholder="Search cars..." class="w-full bg-gray-800 pl-10 pr-4 py-2 text-white">
                                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <button onclick="showFilterModal()" class="bg-gray-700 text-white px-4 py-2 flex items-center">
                                    <i class="fas fa-filter mr-2"></i> Filter
                                </button>
                            </div>
                        </div>

                        <!-- Car Cards -->
                        <div class="py-8">
                            <h1 class="text-3xl font-bold mb-6 text-center text-white">Available Vehicles</h1>
                            <div id="vehicle-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"></div>
                            <div id="loading" class="text-center text-white hidden">
                                <p>Loading vehicles...</p>
                            </div>
                            <div id="error" class="text-center text-red-500 hidden">
                                <p>Failed to load vehicles.</p>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-center mt-8">
                            <nav class="inline-flex rounded-md shadow">
                                <a href="#"
                                    class="px-4 py-2 border border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700">Previous</a>
                                <a href="#"
                                    class="px-4 py-2 border-t border-b border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700">1</a>
                                <a href="#"
                                    class="px-4 py-2 border-t border-b border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700">2</a>
                                <a href="#"
                                    class="px-4 py-2 border-t border-b border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700">3</a>
                                <a href="#" class="px-4 py-2 border border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700">Next</a>
                            </nav>
                        </div>

                        <!-- Filter Modal -->
                        <div id="filterModal"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 modal-overlay"
                            style="display: none;">
                            <div class="bg-gray-800 p-6 rounded-lg w-96 modal-content">
                                <h2 class="text-xl font-bold mb-4 text-white">Filter Cars</h2>
                                <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-white mb-2">Car Type</label>
                                    <select name="car_type" class="w-full bg-gray-700 rounded-md p-2 text-white">
                                        <option value="">All Types</option>
                                        @php
$car_types = ['SEDAN', 'COUPE', 'SPORTS CAR', 'STATION WAGON', 'HATCHBACK', 'CONVERTIBLE', 'SPORT-UTILITY VEHICLE', 'MINIVAN', 'VAN', 'PICKUP TRUCK', 'OTHER'];
                                        @endphp
                                        @foreach($car_types as $car_type)
                                            <option value="{{ $car_type }}" {{ session('booking.request_type') === $car_type ? 'selected' : '' }}>
                                                {{ $car_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-white mb-2">Color</label>
                                    <select name="color" class="w-full bg-gray-700 rounded-md p-2 text-white"> <!-- ✅ Added name="color" -->
                                        <option value="">Select a color</option>
                                        @foreach($colors as $color)
                                            <option value="{{ $color }}";">
                                                {{ ucfirst($color) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-4">
                                    <button onclick="closeFilterModal()" class="btn btn-gray text-white px-4 py-2 rounded">Cancel</button>
                                    <button onclick="applyFilter()" class="btn text-white px-4 py-2 rounded">Apply</button>
                                </div>

                                </div>
                            </div>
                        </div>

                        <!-- Car Details Modal -->
                        <div id="carDetailsModal"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 modal-overlay"
                            style="display: none;">
                            <div class="bg-gray-800 p-6 rounded-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto modal-content">
                                <h2 class="text-2xl font-bold mb-4 text-white" id="carDetailsTitle"></h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <img src="" id="carDetailsImage" class="w-full h-auto rounded-lg">
                                    </div>
                                    <div id="carDescription" class="text-gray-300 space-y-4"></div>
                                </div>
                                <div class="flex justify-between mt-6">
                                    <button onclick="closeCarDetails()" class="btn btn-gray text-white py-2 px-4 rounded">Close</button>
                                    <button onclick="bookCar()" class="btn text-white py-2 px-4 rounded">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
