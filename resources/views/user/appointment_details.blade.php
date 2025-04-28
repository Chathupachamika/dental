@extends('user.layouts.app')

@section('content')
<div class="details-container">
    <div class="details-header">
        <div class="header-content">
            <h1 class="page-title">Appointment Details</h1>
            <p class="page-subtitle">View complete information about your dental appointment</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('user.appointments') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Appointments
            </a>
        </div>
    </div>

    @php
        $today = \Carbon\Carbon::today();
        $appointmentDate = \Carbon\Carbon::parse($appointment->visitDate);
        $isPast = $appointmentDate->lt($today);
        $isCancelled = strpos($appointment->otherNote ?? '', 'Cancelled') !== false;
        
        if($isCancelled) {
            $statusClass = 'cancelled';
            $statusText = 'Cancelled';
            $statusIcon = 'times-circle';
        } elseif($isPast) {
            $statusClass = 'completed';
            $statusText = 'Completed';
            $statusIcon = 'check-circle';
        } else {
            $statusClass = 'upcoming';
            $statusText = 'Upcoming';
            $statusIcon = 'clock';
        }
    @endphp

    <div class="status-banner {{ $statusClass }}">
        <div class="status-icon">
            <i class="fas fa-{{ $statusIcon }}"></i>
        </div>
        <div class="status-content">
            <div class="status-label">Appointment Status</div>
            <div class="status-value">{{ $statusText }}</div>
        </div>
        <div class="status-date">
            <div class="date-label">Appointment Date</div>
            <div class="date-value">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('l, F j, Y') }}</div>
        </div>
    </div>

    <div class="details-grid">
        <!-- Appointment Information -->
        <div class="details-card">
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h2 class="card-title">Appointment Information</h2>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('M d, Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Day</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($appointment->visitDate)->format('l') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </div>
                    </div>
                    <div class="info-item full-width">
                        <div class="info-label">Treatment</div>
                        <div class="info-value">
                            @if(count($appointment->invoiceTreatment) > 0)
                                <div class="treatment-tags">
                                    @foreach($appointment->invoiceTreatment as $treatment)
                                        <span class="treatment-tag">{{ $treatment->treatMent }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="no-data">No treatments specified</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-item full-width">
                        <div class="info-label">Notes</div>
                        <div class="info-value">
                            @if($appointment->otherNote && !$isCancelled)
                                {{ $appointment->otherNote }}
                            @else
                                <span class="no-data">No notes available</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="details-card">
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="card-title">Patient Information</h2>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Name</div>
                        <div class="info-value">{{ $appointment->patient->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Mobile Number</div>
                        <div class="info-value">{{ $appointment->patient->mobileNumber }}</div>
                    </div>
                    @if($appointment->patient->address)
                    <div class="info-item full-width">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $appointment->patient->address }}</div>
                    </div>
                    @endif
                    @if($appointment->patient->age)
                    <div class="info-item">
                        <div class="info-label">Age</div>
                        <div class="info-value">{{ $appointment->patient->age }} years</div>
                    </div>
                    @endif
                    @if($appointment->patient->gender)
                    <div class="info-item">
                        <div class="info-label">Gender</div>
                        <div class="info-value">{{ $appointment->patient->gender }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Information -->
    <div class="details-card full-width">
        <div class="card-header">
            <div class="header-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <h2 class="card-title">Payment Information</h2>
        </div>
        <div class="card-body">
            <div class="payment-summary">
                <div class="payment-card">
                    <div class="payment-icon total">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="payment-details">
                        <div class="payment-label">Total Amount</div>
                        <div class="payment-value">₹{{ number_format($appointment->totalAmount, 2) }}</div>
                    </div>
                </div>
                
                <div class="payment-card">
                    <div class="payment-icon paid">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="payment-details">
                        <div class="payment-label">Paid Amount</div>
                        <div class="payment-value paid">₹{{ number_format($appointment->advanceAmount, 2) }}</div>
                    </div>
                </div>
                
                <div class="payment-card">
                    <div class="payment-icon balance">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <div class="payment-details">
                        <div class="payment-label">Balance</div>
                        <div class="payment-value balance">₹{{ number_format(floatval($appointment->totalAmount) - floatval($appointment->advanceAmount), 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$isCancelled && !$isPast)
    <div class="action-container">
        <div class="action-content">
            <div class="action-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="action-text">
                <h3>Need to cancel this appointment?</h3>
                <p>If you're unable to make it to this appointment, please cancel it as soon as possible so we can accommodate other patients.</p>
            </div>
        </div>
        <div class="action-buttons">
            <form method="POST" action="{{ route('user.appointment.cancel', $appointment->id) }}">
                @csrf
                <button type="submit" class="btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                    <i class="fas fa-times-circle"></i> Cancel Appointment
                </button>
            </form>
        </div>
    </div>
    @endif
</div>

<style>
    /* Professional Appointment Details Styles */
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
    .details-container {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 1.5rem;
        font-family: var(--font-sans);
    }

    /* Header */
    .details-header {
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

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        color: var(--dark);
        border: 1px solid var(--gray-light);
        padding: 0.875rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-secondary:hover {
        background-color: var(--gray-lighter);
        border-color: var(--gray);
    }

    /* Status Banner */
    .status-banner {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        border-radius: var(--radius);
        margin-bottom: 2rem;
        color: white;
    }

    .status-banner.upcoming {
        background: linear-gradient(135deg, var(--accent) 0%, #3EADCF 100%);
    }

    .status-banner.completed {
        background: linear-gradient(135deg, var(--success) 0%, #2DCE89 100%);
    }

    .status-banner.cancelled {
        background: linear-gradient(135deg, var(--danger) 0%, #F5365C 100%);
    }

    .status-icon {
        font-size: 2.5rem;
        margin-right: 1.5rem;
    }

    .status-content {
        flex: 1;
    }

    .status-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.25rem;
    }

    .status-value {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .status-date {
        text-align: right;
        padding-left: 1.5rem;
        border-left: 1px solid rgba(255, 255, 255, 0.3);
    }

    .date-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.25rem;
    }

    .date-value {
        font-size: 1.125rem;
        font-weight: 600;
    }

    /* Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Cards */
    .details-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-light);
    }

    .details-card:hover {
        box-shadow: var(--shadow-hover);
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .card-header {
        display: flex;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: var(--gray-lighter);
        border-bottom: 1px solid var(--gray-light);
    }

    .header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        background: var(--primary);
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

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .info-item.full-width {
        grid-column: 1 / -1;
    }

    .info-label {
        font-size: 0.875rem;
        color: var(--gray);
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 1rem;
        color: var(--dark);
        font-weight: 500;
    }

    .no-data {
        color: var(--gray);
        font-style: italic;
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

    /* Treatment Tags */
    .treatment-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .treatment-tag {
        display: inline-block;
        padding: 0.4rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        background-color: rgba(44, 110, 203, 0.1);
        color: var(--primary);
    }

    /* Payment Summary */
    .payment-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .payment-card {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        border-radius: var(--radius);
        background: var(--gray-lighter);
        transition: var(--transition);
    }

    .payment-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .payment-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 1rem;
        font-size: 1.5rem;
        color: white;
    }

    .payment-icon.total {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    }

    .payment-icon.paid {
        background: linear-gradient(135deg, var(--success) 0%, #2DCE89 100%);
    }

    .payment-icon.balance {
        background: linear-gradient(135deg, var(--warning) 0%, #FBB140 100%);
    }

    .payment-details {
        flex: 1;
    }

    .payment-label {
        font-size: 0.875rem;
        color: var(--gray);
        margin-bottom: 0.25rem;
    }

    .payment-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
    }

    .payment-value.paid {
        color: var(--success);
    }

    .payment-value.balance {
        color: var(--warning);
    }

    /* Action Container */
    .action-container {
        margin-top: 2rem;
        padding: 1.5rem;
        border-radius: var(--radius);
        background-color: rgba(255, 86, 48, 0.05);
        border: 1px solid rgba(255, 86, 48, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .action-content {
        display: flex;
        align-items: flex-start;
    }

    .action-icon {
        font-size: 1.5rem;
        color: var(--danger);
        margin-right: 1rem;
    }

    .action-text h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0 0 0.5rem 0;
    }

    .action-text p {
        font-size: 0.9375rem;
        color: var(--gray);
        margin: 0;
        max-width: 600px;
    }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--danger);
        color: white;
        border: none;
        padding: 0.875rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-danger:hover {
        background: #e03e1e;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(255, 86, 48, 0.25);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .details-header {
            flex-direction: column;
            gap: 1.5rem;
        }

        .header-actions {
            width: 100%;
        }

        .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .status-banner {
            flex-direction: column;
            text-align: center;
        }

        .status-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .status-date {
            text-align: center;
            padding-left: 0;
            border-left: none;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            padding-top: 1rem;
            margin-top: 1rem;
            width: 100%;
        }

        .action-container {
            flex-direction: column;
            gap: 1.5rem;
        }

        .action-content {
            flex-direction: column;
            text-align: center;
        }

        .action-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .action-buttons {
            width: 100%;
        }

        .btn-danger {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .details-container {
            margin: 2rem auto;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .payment-summary {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection