@extends('admin.admin_logged.app')

@section('styles')
<style>
    /* Custom styles for enhanced UI */
    .patient-avatar {
        transition: all 0.2s ease;
    }

    .patient-row:hover .patient-avatar {
        transform: scale(1.05);
    }

    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
    }

    .pagination-item {
        transition: all 0.2s ease;
    }

    .pagination-item:hover {
        transform: translateY(-1px);
    }

    .btn-create-invoice {
        transition: all 0.2s ease;
    }

    .btn-create-invoice:hover {
        transform: translateY(-1px);
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
    }

    .empty-state-icon {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 0.6; }
        50% { opacity: 1; }
        100% { opacity: 0.6; }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header with Stats -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
        <div class="mb-4 lg:mb-0">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Patient Management
            </h1>
            <p class="text-gray-600 mt-1">Manage patients and create invoices</p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.patient.store') }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Patient
            </a>

            <div class="relative">
                <button id="filterDropdown" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div id="filterMenu" class="hidden absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                    <div class="py-1" role="menu" aria-orientation="vertical">
                        <a href="{{ route('admin.patient.index', ['filter' => 'all']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600" role="menuitem">All Patients</a>
                        <a href="{{ route('admin.patient.index', ['filter' => 'recent']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600" role="menuitem">Recent Visits</a>
                        <a href="{{ route('admin.patient.index', ['filter' => 'pending']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600" role="menuitem">Pending Balance</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <!-- Card Header -->
        <div class="card-header-gradient text-white px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-800">Patient Search</h2>
                        <p class="text-blue-800 text-sm">Search and create invoices for patients</p>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 flex items-center">
                    <span class="bg-blue-900/20 rounded-full px-3 py-1 text-sm flex items-center text-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Total: {{ $patients->total() }} patients
                    </span>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="keyword" id="keyword" placeholder="Search by name or mobile number" value="{{ request('keyword') }}"
                           class="search-input block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm transition-all duration-200">
                </div>
                <button type="button" onclick="search_place()"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>
            </div>
        </div>

        <!-- Patient Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Name
                                <button onclick="sortByName('asc')" class="ml-1 text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                                <button onclick="sortByName('desc')" class="ml-1 text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact No
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(count($patients))
                        @foreach ($patients as $place)
                        <tr class="patient-row hover:bg-sky-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="patient-avatar h-10 w-10 bg-gradient-to-br from-sky-500 to-sky-600 text-white flex items-center justify-center rounded-full mr-3 shadow-sm">
                                        <span class="font-semibold">{{ substr($place->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $place->name }}</div>
                                        <div class="text-gray-500 text-xs">ID: #{{ str_pad($place->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $place->address ?: 'No address provided' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2-2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $place->mobileNumber ?: 'No contact provided' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.patient.show', $place->id) }}" class="text-sky-600 hover:text-sky-800 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.invoice.create', $place->id) }}" class="btn-create-invoice inline-flex items-center px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-medium rounded-md shadow-sm hover:shadow transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Create Invoice
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="empty-state-icon rounded-full bg-gray-100 p-4 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Patients Found</h3>
                                    <p class="text-gray-500 text-sm mb-4">No patients match your search criteria.</p>
                                    <a href="{{ route('admin.patient.index') }}" class="inline-flex items-center px-4 py-2 bg-sky-100 text-sky-700 hover:bg-sky-200 rounded-md text-sm font-medium transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Reset Search
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination -->
        @if(count($patients))
            <div class="px-6 py-4 bg-white border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500 mb-4 sm:mb-0">
                        Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} patients
                    </div>

                    <div class="pagination-container">
                        @if ($patients->hasPages())
                            <div class="flex items-center rounded-md shadow-sm">
                                <!-- Previous Page Link -->
                                @if ($patients->onFirstPage())
                                    <span class="pagination-item relative inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-300 border border-gray-200 cursor-not-allowed rounded-l-md">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $patients->previousPageUrl() }}" class="pagination-item relative inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-sky-50 hover:text-sky-600 border border-gray-200 rounded-l-md transition-colors duration-200">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endif

                                <!-- Pagination Elements -->
                                @foreach ($patients->getUrlRange(1, $patients->lastPage()) as $page => $url)
                                    @if ($page == $patients->currentPage())
                                        <span class="pagination-item relative inline-flex items-center px-4 py-2 bg-sky-50 text-sm font-medium text-sky-600 border border-sky-200">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="pagination-item relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-sky-50 hover:text-sky-600 border border-gray-200 transition-colors duration-200">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($patients->hasMorePages())
                                    <a href="{{ $patients->nextPageUrl() }}" class="pagination-item relative inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-sky-50 hover:text-sky-600 border border-gray-200 rounded-r-md transition-colors duration-200">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="pagination-item relative inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-300 border border-gray-200 cursor-not-allowed rounded-r-md">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var query = <?php echo json_encode((object)Request::only(['keyword', 'sortByName', 'filter'])); ?>;

    function search_place() {
        Object.assign(query, {
            'keyword': document.getElementById('keyword').value
        });
        window.location.href = "{{route('admin.patient.index')}}?" + new URLSearchParams(query).toString();
    }

    function sortByName(value) {
        Object.assign(query, {
            'sortByName': value
        });
        window.location.href = "{{route('admin.patient.index')}}?" + new URLSearchParams(query).toString();
    }

    // Enable Enter key for search
    document.getElementById('keyword').addEventListener('keypress', function (e) {
        if (e.which === 13 || e.keyCode === 13) {
            search_place();
        }
    });

    // Filter dropdown toggle
    document.getElementById('filterDropdown').addEventListener('click', function() {
        const menu = document.getElementById('filterMenu');
        menu.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('filterDropdown');
        const menu = document.getElementById('filterMenu');

        if (!dropdown.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    // Add hover effects to pagination items
    document.querySelectorAll('.pagination-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            if (!this.classList.contains('cursor-not-allowed')) {
                this.classList.add('shadow-sm');
            }
        });

        item.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-sm');
        });
    });
</script>
@endsection
