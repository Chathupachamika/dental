@extends('user.layouts.app')

@section('content')
<!-- Add this at the beginning of content section -->
<script>
    window.onload = function() {
        // First check terms agreement status
        fetch('{{ route("user.api.terms.status") }}')
            .then(response => response.json())
            .then(data => {
                if (!data.terms_agreed) {
                    Swal.fire({
                        title: 'Incomplete Profile',
                        text: 'Please fill in all required data about you to proceed smoothly.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4361ee',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Go to Profile',
                        cancelButtonText: 'Later'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("user.profile") }}';
                        }
                    });
                } else {
                    // Only check profile completion if terms are agreed
                    fetch('{{ route("user.check.profile") }}')
                        .then(response => response.json())
                        .then(data => {
                            if (!data.isComplete) {
                                Swal.fire({
                                    title: 'Complete Your Profile',
                                    text: 'Please complete your profile details to better serve you.',
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonColor: '#4361ee',
                                    cancelButtonColor: '#6c757d',
                                    confirmButtonText: 'Go to Profile',
                                    cancelButtonText: 'Later'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '{{ route("user.profile") }}';
                                    }
                                });
                            }
                        });
                }
            });
    }
</script>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2 class="welcome-title">
                    <i class="fas fa-smile-beam welcome-icon"></i>
                    Welcome back, {{ Auth::user()->name }}
                </h2>
                <p class="welcome-description">Manage your dental appointments and health information all in one place.</p>
                <a href="{{ route('user.book.appointment') }}" class="btn-appointment">
                    <i class="fas fa-calendar-plus"></i> Schedule Appointment
                </a>
            </div>
            <div class="welcome-graphic">
                <i class="fas fa-teeth"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Upcoming Appointments -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 class="card-title">Upcoming Appointments</h3>
            </div>
            <div class="card-body">
                @if(!is_null($upcomingAppointments) && count($upcomingAppointments) > 0)
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Treatment</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingAppointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="appointment-date">
                                            <span class="date">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('M d, Y') }}</span>
                                            <span class="day">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('l') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if(count($appointment->invoiceTreatment) > 0)
                                            <span class="treatment-badge">{{ $appointment->invoiceTreatment[0]->treatMent }}</span>
                                        @else
                                            <span class="treatment-badge empty">Not specified</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('user.appointment.details', $appointment->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h4 class="empty-title">No Upcoming Appointments</h4>
                        <p class="empty-description">You don't have any scheduled appointments at the moment.</p>
                        <a href="{{ route('user.book.appointment') }}" class="btn-book">
                            <i class="fas fa-calendar-plus"></i> Book Now
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Dental Health Tips -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-tooth"></i>
                </div>
                <h3 class="card-title">Dental Health Tips</h3>
            </div>
            <div class="card-body">
                <ul class="health-tips">
                    <li class="tip-item">
                        <div class="tip-icon">
                            <i class="fas fa-brush"></i>
                        </div>
                        <div class="tip-content">
                            <h4 class="tip-title">Brush Twice Daily</h4>
                            <p class="tip-description">Brush your teeth for two minutes, twice a day with fluoride toothpaste.</p>
                        </div>
                    </li>
                    <li class="tip-item">
                        <div class="tip-icon">
                            <i class="fas fa-wind"></i>
                        </div>
                        <div class="tip-content">
                            <h4 class="tip-title">Floss Daily</h4>
                            <p class="tip-description">Clean between your teeth daily with floss or an interdental cleaner.</p>
                        </div>
                    </li>
                    <li class="tip-item">
                        <div class="tip-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="tip-content">
                            <h4 class="tip-title">Regular Dental Visits</h4>
                            <p class="tip-description">Visit your dentist regularly for prevention and treatment of oral disease.</p>
                        </div>
                    </li>
                    <li class="tip-item">
                        <div class="tip-icon">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <div class="tip-content">
                            <h4 class="tip-title">Healthy Diet</h4>
                            <p class="tip-description">Limit sugary snacks and drinks, and eat a balanced diet for good oral health.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

<style>
    /* Modern Dashboard Styles */
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
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        --shadow-hover: 0 10px 15px rgba(0, 0, 0, 0.1);
        --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        --gradient-accent: linear-gradient(135deg, var(--primary-light) 0%, var(--accent) 100%);
        --radius: 12px;
        --radius-sm: 8px;
        --transition: all 0.3s ease;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Welcome Card */
    .welcome-card {
        background: var(--gradient);
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        color: white;
    }

    .welcome-content {
        display: flex;
        align-items: center;
        padding: 2rem;
    }

    .welcome-text {
        flex: 1;
    }

    .welcome-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .welcome-icon {
        margin-right: 0.75rem;
        font-size: 1.5rem;
    }

    .welcome-description {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        opacity: 0.9;
        max-width: 80%;
    }

    .btn-appointment {
        display: inline-flex;
        align-items: center;
        background-color: white;
        color: var(--primary);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-appointment i {
        margin-right: 0.5rem;
    }

    .btn-appointment:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .welcome-graphic {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        opacity: 0.2;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
    }

    .dashboard-card:hover {
        box-shadow: var(--shadow-hover);
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .card-header {
        display: flex;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-light);
    }

    .header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--gradient-accent);
        color: white;
        margin-right: 1rem;
        font-size: 1.25rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        color: var(--dark);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Tables */
    .appointments-table, .history-table {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    thead {
        background-color: var(--gray-light);
    }

    th {
        padding: 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray);
        text-align: left;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-light);
        vertical-align: middle;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .appointment-date {
        display: flex;
        flex-direction: column;
    }

    .date {
        font-weight: 600;
        color: var(--dark);
    }

    .day {
        font-size: 0.85rem;
        color: var(--gray);
    }

    .treatment-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary);
    }

    .treatment-badge.empty {
        background-color: var(--gray-light);
        color: var(--gray);
    }

    .text-right {
        text-align: right;
    }

    .btn-view {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        color: var(--primary);
        border: 1px solid var(--primary);
        transition: var(--transition);
    }

    .btn-view i {
        margin-right: 0.4rem;
    }

    .btn-view:hover {
        background-color: var(--primary);
        color: white;
    }

    /* Empty States */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
    }

    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: var(--gray-light);
        color: var(--gray);
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .empty-description {
        color: var(--gray);
        margin-bottom: 1.5rem;
        max-width: 300px;
    }

    .btn-book {
        display: inline-flex;
        align-items: center;
        background: var(--gradient);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-book i {
        margin-right: 0.5rem;
    }

    .btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Health Tips */
    .health-tips {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tip-item {
        display: flex;
        align-items: flex-start;
        padding: 1rem 0;
        border-bottom: 1px solid var(--gray-light);
    }

    .tip-item:last-child {
        border-bottom: none;
    }

    .tip-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--gradient-accent);
        color: white;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .tip-content {
        flex: 1;
    }

    .tip-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        color: var(--dark);
    }

    .tip-description {
        font-size: 0.9rem;
        color: var(--gray);
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-content {
            flex-direction: column;
            text-align: center;
        }

        .welcome-description {
            max-width: 100%;
        }

        .welcome-graphic {
            display: none;
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .card-header {
            padding: 1rem;
        }

        .card-body {
            padding: 1rem;
        }
    }
</style>
@endsection
