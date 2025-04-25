@extends('user.layouts.app')

@section('content')
<div class="booking-container">
    <div class="booking-header">
        <h1 class="booking-title">
            <i class="fas fa-calendar-plus"></i>
            Book Your Appointment
        </h1>
        <p class="booking-subtitle">Schedule your next dental visit with our easy booking system</p>
    </div>

    <div class="booking-card">
        <form method="POST" action="{{ route('user.store.appointment') }}" class="booking-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="appointment_date" class="form-label">
                        Preferred Date <span class="required-mark">*</span>
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <input 
                            type="date" 
                            class="form-input @error('appointment_date') input-error @enderror" 
                            id="appointment_date" 
                            name="appointment_date" 
                            value="{{ old('appointment_date') }}" 
                            min="{{ date('Y-m-d') }}" 
                            required
                        >
                    </div>
                    @error('appointment_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Please select your preferred appointment date</div>
                </div>

                <div class="form-group">
                    <label for="treatment" class="form-label">
                        Treatment Type <span class="required-mark">*</span>
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <i class="fas fa-tooth"></i>
                        </div>
                        <select 
                            class="form-input @error('treatment') input-error @enderror" 
                            id="treatment" 
                            name="treatment" 
                            required
                        >
                            <option value="">Select Treatment</option>
                            @foreach($treatments as $treatment)
                                <option value="{{ $treatment->name }}" {{ old('treatment') == $treatment->name ? 'selected' : '' }}>
                                    {{ $treatment->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('treatment')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Additional Notes</label>
                <textarea 
                    class="form-input form-textarea @error('notes') input-error @enderror" 
                    id="notes" 
                    name="notes" 
                    rows="4" 
                    placeholder="Please describe your dental issue or any specific concerns"
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="info-alert">
                <div class="alert-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="alert-content">
                    <strong>Important:</strong> This is a request for an appointment. Our staff will contact you to confirm the exact date and time based on availability.
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('user.user_dashboard') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-calendar-check"></i> Request Appointment
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Modern Appointment Booking Styles */
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

    /* Container */
    .booking-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    /* Header */
    .booking-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .booking-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .booking-title i {
        color: var(--primary);
    }

    .booking-subtitle {
        font-size: 1.1rem;
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Card */
    .booking-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: var(--transition);
    }

    .booking-card:hover {
        box-shadow: var(--shadow-hover);
    }

    /* Form */
    .booking-form {
        padding: 2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .required-mark {
        color: var(--danger);
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        color: var(--gray);
        z-index: 1;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        font-size: 1rem;
        transition: var(--transition);
        background-color: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }

    .form-textarea {
        padding: 0.75rem 1rem;
        min-height: 120px;
        resize: vertical;
    }

    .input-error {
        border-color: var(--danger);
    }

    .error-message {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .form-hint {
        color: var(--gray);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    /* Alert */
    .info-alert {
        display: flex;
        align-items: flex-start;
        padding: 1.25rem;
        background-color: rgba(76, 201, 240, 0.1);
        border-radius: var(--radius-sm);
        margin: 1.5rem 0;
    }

    .alert-icon {
        color: var(--accent);
        font-size: 1.25rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .alert-content {
        color: var(--dark);
        font-size: 0.95rem;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--gradient);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        color: var(--dark);
        border: 1px solid var(--gray-light);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-secondary:hover {
        background-color: var(--gray-lighter);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .booking-form {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Set minimum date to today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('appointment_date').setAttribute('min', today);
    });
</script>
@endsection