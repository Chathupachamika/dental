@extends('admin.admin_logged.app')

@section('content')
<div class="appointments-container">
    <div class="appointments-header">
        <div class="header-content">
            <h1 class="page-title">Appointments Management</h1>
            <p class="page-subtitle">View and manage all dental appointments</p>
        </div>
    </div>

    <div class="appointments-card">
        <!-- Filters -->
        <div class="appointments-filters">
            <div class="filter-tabs">
                <a href="{{ route('admin.appointments.index') }}"
                   class="filter-tab {{ !request('status') ? 'active' : '' }}">
                    All
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}"
                   class="filter-tab {{ request('status') === 'pending' ? 'active' : '' }}">
                    Pending
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}"
                   class="filter-tab {{ request('status') === 'confirmed' ? 'active' : '' }}">
                    Confirmed
                </a>
                <a href="{{ route('admin.appointments.index', ['status' => 'cancelled']) }}"
                   class="filter-tab {{ request('status') === 'cancelled' ? 'active' : '' }}">
                    Cancelled
                </a>
            </div>

            <div class="filter-date">
                <form action="{{ route('admin.appointments.index') }}" method="GET">
                    <input type="date" name="date" value="{{ request('date') }}"
                           class="form-control" onchange="this.form.submit()">
                </form>
            </div>
        </div>

        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Contact</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>
                                    <div class="patient-info">
                                        <span class="patient-name">{{ $appointment->user->name ?? 'Unknown' }}</span>
                                        <span class="patient-id">#{{ $appointment->user->id ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="appointment-date">
                                        <span class="date">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                                        <span class="time">{{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ strtolower($appointment->status) }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        <span class="phone">{{ $appointment->user->mobileNumber ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="notes">
                                        {{ $appointment->notes ?? 'No notes available' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($appointment->status === 'pending')
                                            <form action="{{ route('admin.appointments.confirm', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-action confirm" onclick="return confirm('Confirm this appointment?')">
                                                    <i class="fas fa-check"></i>
                                                    <span>Confirm</span>
                                                </button>
                                            </form>
                                        @endif

                                        @if($appointment->status !== 'cancelled')
                                            <form action="{{ route('admin.appointments.cancel', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-action cancel" onclick="return confirm('Cancel this appointment?')">
                                                    <i class="fas fa-times"></i>
                                                    <span>Cancel</span>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn-action edit">
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($appointments->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($appointments->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Previous
                        </span>
                    @else
                        <a href="{{ $appointments->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @if($appointments->hasMorePages())
                        <a href="{{ $appointments->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
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
                            <span class="font-medium">{{ $appointments->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $appointments->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $appointments->total() }}</span>
                            appointments
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            {{-- Previous Page Link --}}
                            @if ($appointments->onFirstPage())
                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-400">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left w-5 h-5"></i>
                                </span>
                            @else
                                <a href="{{ $appointments->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left w-5 h-5"></i>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($appointments->onEachSide(1)->links()->elements[0] as $page => $url)
                                @if ($page == $appointments->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($appointments->hasMorePages())
                                <a href="{{ $appointments->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right w-5 h-5"></i>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-400">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right w-5 h-5"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h2>No Appointments Found</h2>
                <p>There are no appointments matching your current filters.</p>
            </div>
        @endif
    </div>
</div>

<style>
/* Updated styles to match book_appointment design */
:root {
    --primary: #4361ee;
    --primary-light: #4895ef;
    --secondary: #3f37c9;
    --accent: #4cc9f0;
    --success: #4CAF50;
    --warning: #ff9800;
    --danger: #f44336;
    --light: #f8f9fa;
    --dark: #212529;
    --gray: #6c757d;
    --gray-light: #e9ecef;
    --gray-lighter: #f5f5f5;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    --shadow-hover: 0 10px 15px rgba(0, 0, 0, 0.1);
    --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    --gradient-accent: linear-gradient(135deg, var(--primary-light) 0%, var(--accent) 100%);
    --radius: 12px;
    --radius-sm: 8px;
    --transition: all 0.3s ease;
}

.appointments-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    background: var(--gray-lighter);
    border-radius: var(--radius);
}

.appointments-header {
    margin-bottom: 2rem;
    text-align: center;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: var(--gray);
    font-size: 1rem;
}

.appointments-card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: var(--transition);
}

.appointments-card:hover {
    box-shadow: var(--shadow-hover);
}

.appointments-filters {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: var(--gray-light);
    border-bottom: 1px solid var(--gray);
}

.filter-tabs {
    display: flex;
    gap: 1rem;
}

.filter-tab {
    padding: 0.5rem 1rem;
    border-radius: var(--radius-sm);
    color: var(--gray);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.filter-tab:hover {
    background: var(--gray-lighter);
    color: var(--primary);
}

.filter-tab.active {
    background: var(--primary);
    color: white;
}

.filter-date input {
    padding: 0.5rem;
    border: 1px solid var(--gray-light);
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    transition: border-color 0.3s;
}

.filter-date input:focus {
    border-color: var(--primary);
    outline: none;
}

.appointments-table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}

.appointments-table th {
    padding: 1rem;
    text-align: left;
    background: var(--gray-light);
    font-weight: 600;
    color: var(--dark);
}

.appointments-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--gray-light);
    font-size: 0.875rem;
    color: var(--gray);
}

.appointments-table tr:hover {
    background: var(--gray-lighter);
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-badge.pending {
    background: rgba(255, 193, 7, 0.2);
    color: var(--warning);
}

.status-badge.confirmed {
    background: rgba(76, 175, 80, 0.2);
    color: var(--success);
}

.status-badge.cancelled {
    background: rgba(244, 67, 54, 0.2);
    color: var(--danger);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: var(--radius-sm);
    border: none;
    font-size: 0.875rem;
    cursor: pointer;
    transition: var(--transition);
}

.btn-action.confirm {
    background: rgba(76, 175, 80, 0.2);
    color: var(--success);
}

.btn-action.confirm:hover {
    background: rgba(76, 175, 80, 0.3);
}

.btn-action.cancel {
    background: rgba(244, 67, 54, 0.2);
    color: var(--danger);
}

.btn-action.cancel:hover {
    background: rgba(244, 67, 54, 0.3);
}

.btn-action.edit {
    background: var(--gray-light);
    color: var(--gray);
}

.btn-action.edit:hover {
    background: var(--gray-lighter);
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    background: var(--gray-lighter);
    border-radius: var(--radius);
}

.empty-icon {
    font-size: 3rem;
    color: var(--gray);
    margin-bottom: 1rem;
}

.pagination-container {
    padding: 1rem;
    border-top: 1px solid var(--gray-light);
    text-align: center;
}

.pagination-container .pagination {
    display: inline-flex;
    gap: 0.5rem;
}

.pagination-container .pagination a {
    padding: 0.5rem 0.75rem;
    border-radius: var(--radius-sm);
    background: var(--gray-light);
    color: var(--dark);
    text-decoration: none;
    transition: var(--transition);
}

.pagination-container .pagination a:hover {
    background: var(--gray-lighter);
    color: var(--primary);
}

.pagination-container .pagination .active {
    background: var(--primary);
    color: white;
}
</style>

@endsection
