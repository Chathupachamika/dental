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
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    <p>
                        Showing
                        <span class="font-semibold">{{ $appointments->firstItem() }}</span>
                        to
                        <span class="font-semibold">{{ $appointments->lastItem() }}</span>
                        of
                        <span class="font-semibold">{{ $appointments->total() }}</span>
                        appointments
                    </p>
                </div>

                <div class="pagination-controls">
                    @if ($appointments->onFirstPage())
                        <span class="pagination-btn disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $appointments->previousPageUrl() }}" class="pagination-btn">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    @foreach ($appointments->onEachSide(1)->links()->elements[0] as $page => $url)
                        @if ($page == $appointments->currentPage())
                            <span class="pagination-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($appointments->hasMorePages())
                        <a href="{{ $appointments->nextPageUrl() }}" class="pagination-btn">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="pagination-btn disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
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

.pagination-wrapper {
    padding: 1.5rem;
    background: white;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pagination-info {
    color: #6b7280;
    font-size: 0.875rem;
}

.pagination-info span {
    color: #374151;
}

.pagination-controls {
    display: flex;
    gap: 0.25rem;
    align-items: center;
}

.pagination-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2rem;
    height: 2rem;
    padding: 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    background: white;
    color: #4b5563;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
}

.pagination-btn:hover {
    background: #f3f4f6;
    color: #2563eb;
    border-color: #93c5fd;
}

.pagination-btn.active {
    background: #93c5fd;
    color: #1e40af;
    border-color: #60a5fa;
    font-weight: 600;
}

.pagination-btn.disabled {
    background: #f3f4f6;
    color: #9ca3af;
    cursor: not-allowed;
    border-color: #e5e7eb;
}

.pagination-btn i {
    font-size: 0.75rem;
}
</style>

@endsection
