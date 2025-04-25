@extends('user.layouts.app')

@section('content')
<div class="appointments-container">
    <div class="appointments-header">
        <div class="header-content">
            <h1 class="page-title">My Appointments</h1>
            <p class="page-subtitle">View and manage all your dental appointments</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('user.book.appointment') }}" class="btn-primary">
                <i class="fas fa-calendar-plus"></i> Schedule Appointment
            </a>
        </div>
    </div>

    <div class="appointments-card">
        <div class="appointments-filters">
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">
                    All Appointments
                </button>
                <button class="filter-tab" data-filter="upcoming">
                    Upcoming
                </button>
                <button class="filter-tab" data-filter="completed">
                    Completed
                </button>
                <button class="filter-tab" data-filter="cancelled">
                    Cancelled
                </button>
            </div>
            <div class="filter-search">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Search appointments..." class="search-input">
                </div>
            </div>
        </div>

        @if(count($appointments) > 0)
            <div class="appointments-table-wrapper">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Treatment</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        @php
                            $today = \Carbon\Carbon::today();
                            $appointmentDate = \Carbon\Carbon::parse($appointment->visitDate);
                            $isPast = $appointmentDate->lt($today);
                            $isCancelled = strpos($appointment->otherNote ?? '', 'Cancelled') !== false;
                            
                            if($isCancelled) {
                                $statusClass = 'cancelled';
                                $statusText = 'Cancelled';
                            } elseif($isPast) {
                                $statusClass = 'completed';
                                $statusText = 'Completed';
                            } else {
                                $statusClass = 'upcoming';
                                $statusText = 'Upcoming';
                            }
                        @endphp
                        <tr data-status="{{ $statusClass }}">
                            <td>
                                <div class="appointment-date">
                                    <div class="date-calendar">
                                        <span class="date-month">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('M') }}</span>
                                        <span class="date-day">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('d') }}</span>
                                    </div>
                                    <div class="date-details">
                                        <span class="date-year">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('Y') }}</span>
                                        <span class="date-weekday">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('l') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(count($appointment->invoiceTreatment) > 0)
                                    <span class="treatment-badge">{{ $appointment->invoiceTreatment[0]->treatMent }}</span>
                                @else
                                    <span class="treatment-badge empty">Not specified</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                @if($appointment->otherNote)
                                    <div class="note-content" title="{{ $appointment->otherNote }}">
                                        {{ \Illuminate\Support\Str::limit($appointment->otherNote, 50) }}
                                    </div>
                                @else
                                    <span class="no-content">No notes</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="action-buttons">
                                    <a href="{{ route('user.appointment.details', $appointment->id) }}" class="btn-action view">
                                        <i class="fas fa-eye"></i>
                                        <span class="action-text">View</span>
                                    </a>

                                    @php
                                        $canCancel = !$isPast && !$isCancelled;
                                    @endphp

                                    @if($canCancel)
                                        <form method="POST" action="{{ route('user.appointment.cancel', $appointment->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-action cancel" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                <i class="fas fa-times-circle"></i>
                                                <span class="action-text">Cancel</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h2 class="empty-title">No Appointments Found</h2>
                <p class="empty-description">You don't have any appointments scheduled at the moment.</p>
                <a href="{{ route('user.book.appointment') }}" class="btn-primary">
                    <i class="fas fa-calendar-plus"></i> Book Your First Appointment
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    /* Professional Appointments Page Styles */
    :root {
        --primary: #2c6ecb;
        --primary-light: #4a89dc;
        --primary-dark: #1a56b0;
        --secondary: #5d7aed;
        --accent: #00b8d9;
        --success: #36b37e;
        --warning: #ffab00;
        --danger: #ff5630;
        --light: #f8f9fa;
        --dark: #172b4d;
        --gray: #6b778c;
        --gray-light: #dfe1e6;
        --gray-lighter: #f4f5f7;
        --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.12);
        --radius: 8px;
        --radius-sm: 4px;
        --radius-lg: 12px;
        --transition: all 0.25s ease;
        --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    /* Container */
    .appointments-container {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 1.5rem;
        font-family: var(--font-sans);
    }

    /* Header */
    .appointments-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
    }

    .header-content {
        max-width: 600px;
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .page-subtitle {
        font-size: 1.125rem;
        color: var(--gray);
        margin: 0;
        line-height: 1.5;
    }

    .header-actions {
        display: flex;
        align-items: center;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.875rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(44, 110, 203, 0.2);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(44, 110, 203, 0.25);
    }

    /* Card */
    .appointments-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-light);
    }

    .appointments-card:hover {
        box-shadow: var(--shadow-hover);
    }

    /* Filters */
    .appointments-filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: var(--gray-lighter);
        border-bottom: 1px solid var(--gray-light);
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
    }

    .filter-tab {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-tab:hover {
        background: rgba(107, 119, 140, 0.08);
        color: var(--dark);
    }

    .filter-tab.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .filter-search {
        flex-shrink: 0;
    }

    .search-wrapper {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
    }

    .search-input {
        padding: 0.5rem 1rem 0.5rem 2.25rem;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        width: 240px;
        transition: var(--transition);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(44, 110, 203, 0.15);
    }

    /* Table */
    .appointments-table-wrapper {
        overflow-x: auto;
    }

    .appointments-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .appointments-table thead {
        background-color: var(--gray-lighter);
    }

    .appointments-table th {
        padding: 1rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray);
        text-align: left;
        border-bottom: 1px solid var(--gray-light);
    }

    .appointments-table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-light);
    }

    .appointments-table tr:last-child td {
        border-bottom: none;
    }

    .appointments-table tr:hover {
        background-color: rgba(244, 245, 247, 0.5);
    }

    .text-right {
        text-align: right;
    }

    /* Appointment Date */
    .appointment-date {
        display: flex;
        align-items: center;
    }

    .date-calendar {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        background: var(--primary-light);
        color: white;
        border-radius: var(--radius-sm);
        margin-right: 1rem;
    }

    .date-month {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .date-day {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .date-details {
        display: flex;
        flex-direction: column;
    }

    .date-year {
        font-weight: 600;
        color: var(--dark);
    }

    .date-weekday {
        font-size: 0.875rem;
        color: var(--gray);
    }

    /* Treatment Badge */
    .treatment-badge {
        display: inline-block;
        padding: 0.4rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        background-color: rgba(44, 110, 203, 0.1);
        color: var(--primary);
    }

    .treatment-badge.empty {
        background-color: var(--gray-lighter);
        color: var(--gray);
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-badge.upcoming {
        background-color: rgba(0, 184, 217, 0.1);
        color: var(--accent);
    }

    .status-badge.completed {
        background-color: rgba(54, 179, 126, 0.1);
        color: var(--success);
    }

    .status-badge.cancelled {
        background-color: rgba(255, 86, 48, 0.1);
        color: var(--danger);
    }

    /* Notes */
    .note-content {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.875rem;
        color: var(--dark);
    }

    .no-content {
        font-size: 0.875rem;
        color: var(--gray);
        font-style: italic;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        border: none;
        background: transparent;
    }

    .btn-action.view {
        color: var(--primary);
        background-color: rgba(44, 110, 203, 0.08);
    }

    .btn-action.view:hover {
        background-color: rgba(44, 110, 203, 0.16);
    }

    .btn-action.cancel {
        color: var(--danger);
        background-color: rgba(255, 86, 48, 0.08);
    }

    .btn-action.cancel:hover {
        background-color: rgba(255, 86, 48, 0.16);
    }

    /* Pagination */
    .pagination-container {
        padding: 1.5rem;
        border-top: 1px solid var(--gray-light);
        display: flex;
        justify-content: center;
    }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--gray-lighter);
        color: var(--gray);
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.75rem;
    }

    .empty-description {
        font-size: 1rem;
        color: var(--gray);
        margin-bottom: 2rem;
        max-width: 400px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .appointments-header {
            flex-direction: column;
            gap: 1.5rem;
        }

        .header-actions {
            width: 100%;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }

        .appointments-filters {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .filter-tabs {
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }

        .filter-search {
            width: 100%;
        }

        .search-input {
            width: 100%;
        }

        .action-text {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .appointments-container {
            margin: 2rem auto;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .appointments-table th:nth-child(4),
        .appointments-table td:nth-child(4) {
            display: none;
        }

        .date-calendar {
            width: 40px;
            height: 40px;
        }

        .date-day {
            font-size: 1rem;
        }

        .date-month {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .appointments-table th:nth-child(3),
        .appointments-table td:nth-child(3) {
            display: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterTabs = document.querySelectorAll('.filter-tab');
        const appointmentRows = document.querySelectorAll('.appointments-table tbody tr');
        
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Update active tab
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                // Filter table rows
                appointmentRows.forEach(row => {
                    if (filter === 'all' || row.getAttribute('data-status') === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
        
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                appointmentRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection