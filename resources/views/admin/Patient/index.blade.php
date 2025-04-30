@extends('admin.admin_logged.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Add Patient Button -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.patient.store') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow flex items-center">
            <i class="fas fa-user-plus mr-2"></i> Add New Patient
        </a>
    </div>

    <!-- Card Wrapper -->
    <div class="bg-white shadow rounded-xl">

        <!-- Card Header -->
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h5 class="text-lg font-semibold"><i class="fas fa-search mr-2"></i> Patient Search</h5>
                <p class="text-sm text-blue-100">Search and create invoices for patients</p>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-6">
            <!-- Search Input + Button -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row items-stretch gap-3">
                    <input type="text" name="keyword" id="keyword" placeholder="Search by name or mobile"
                           class="w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring focus:border-blue-400">
                    <button type="button" onclick="search_place()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                </div>
            </div>

            <!-- Patient Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 rounded-lg">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Address</th>
                            <th class="px-4 py-2">Contact No</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($patients))
                            @foreach ($patients as $place)
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
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.invoice.create', $place->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow inline-flex items-center">
                                        <i class="fas fa-file-invoice-dollar mr-1"></i> Create Invoice
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-user-slash fa-3x text-gray-400 mb-2"></i>
                                        <h6 class="font-semibold">No Patients Found</h6>
                                        <p class="text-sm">No patients match your search criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if(count($patients))
            <!-- Pagination Info & Links -->
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 text-sm text-gray-600">
                <div class="mb-2 sm:mb-0">
                    Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} patients
                </div>
                <div>
                    {{ $patients->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var query = <?php echo json_encode((object)Request::only(['keyword', 'sortByName'])); ?>;

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
</script>
@endsection
