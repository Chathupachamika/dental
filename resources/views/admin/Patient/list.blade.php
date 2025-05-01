@extends('admin.admin_logged.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h2 class="text-xl font-semibold flex items-center">
                    <i class="fas fa-users mr-2"></i> Patient List
                </h2>
                <p class="text-sm text-blue-100">Manage and view all patient records</p>
            </div>
            <a href="{{ route('admin.patient.store') }}" class="mt-4 sm:mt-0 bg-green-600 text-white px-5 py-2 rounded-lg shadow hover:bg-green-700 flex items-center">
                <i class="fas fa-user-plus mr-2"></i> Add Patient
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="p-6">
            <div class="flex flex-col sm:flex-row items-stretch gap-3 mb-6">
                <input type="text" name="keyword" id="keyword" placeholder="Search by name or mobile"
                       class="w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                <button type="button" onclick="search_place()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i> Search
                </button>
                <select id="filter" class="w-full sm:w-48 px-3 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    <option value="all">All Patients</option>
                    <option value="recent">Recent Patients</option>
                    <option value="pending">Pending Balance</option>
                </select>
            </div>

            <!-- Patient Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                            <th scope="col" class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Contact No</th>
                            <th scope="col" class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Last Visit</th>
                            <th scope="col" class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                            <th scope="col" class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($patients as $place)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-600 text-white flex items-center justify-center rounded-full mr-3">
                                        <span class="font-semibold">{{ substr($place->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $place->name }}</div>
                                        <div class="text-gray-500 text-xs">ID: #{{ $place->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $place->address }}</td>
                            <td class="px-4 py-3">{{ $place->mobileNumber }}</td>
                            <td class="px-4 py-3">
                                {{ $place->lastVisit ? \Carbon\Carbon::parse($place->lastVisit)->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($place->balance > 0)
                                    <span class="text-red-500 font-semibold">Rs {{ number_format($place->balance, 2) }}</span>
                                @else
                                    <span class="text-green-500 font-semibold">Rs 0.00</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.patient.show', $place->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow inline-flex items-center">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <a href="{{ route('admin.patient.edit', $place->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm shadow inline-flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <button onclick="delete_place('{{ route('admin.patient.destroy', $place->id) }}')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm shadow inline-flex items-center">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-user-slash fa-3x text-gray-400 mb-2"></i>
                                    <h6 class="font-semibold">No Patients Found</h6>
                                    <p class="text-sm">No patients match your search criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($patients->hasPages())
            <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($patients->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Previous
                        </span>
                    @else
                        <a href="{{ $patients->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @if($patients->hasMorePages())
                        <a href="{{ $patients->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Next
                        </a>
                    @else
                        <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Next
                        </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $patients->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $patients->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $patients->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        {{ $patients->onEachSide(2)->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var query = <?php echo json_encode((object)Request::only(['keyword', 'sortByName', 'filter'])); ?>;

    function search_place() {
        Object.assign(query, {
            'keyword': document.getElementById('keyword').value,
            'filter': document.getElementById('filter').value
        });
        window.location.href = "{{route('admin.patient.list')}}?" + new URLSearchParams(query).toString();
    }

    function delete_place(url) {
        deleteUrl = url;
        $('#deleteConfirmModal').removeClass('hidden');
    }

    $('#confirmDeleteBtn').click(function() {
        $('#place_delete_form').attr('action', deleteUrl);
        $('#place_delete_form').submit();
        $('#deleteConfirmModal').addClass('hidden');
    });

    // Enable Enter key for search
    document.getElementById('keyword').addEventListener('keypress', function (e) {
        if (e.which === 13 || e.keyCode === 13) {
            search_place();
        }
    });
</script>
@endsection
