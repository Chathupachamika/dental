@extends('user.layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Profile Card -->
    <div class="dashboard-card full-width">
        <div class="card-header">
            <div class="header-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <h3 class="card-title">My Profile</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.update.profile') }}">
                @csrf

                <div class="profile-grid">
                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Full Name <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-input @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-input disabled"
                                   id="email" value="{{ $user->email }}" readonly disabled>
                        </div>
                        <div class="form-note">Email address cannot be changed</div>
                    </div>

                    <!-- Mobile Number -->
                    <div class="form-group">
                        <label for="mobile_number" class="form-label">
                            Mobile Number <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </span>
                            <input type="text" class="form-input @error('mobile_number') is-invalid @enderror"
                                   id="mobile_number" name="mobile_number"
                                   value="{{ old('mobile_number', $user->mobile_number) }}" required>
                        </div>
                        @error('mobile_number')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <input type="text" class="form-input @error('address') is-invalid @enderror"
                                   id="address" name="address"
                                   value="{{ old('address', $patient->address ?? '') }}">
                        </div>
                        @error('address')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Age -->
                    <div class="form-group">
                        <label for="age" class="form-label">Age</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fas fa-birthday-cake"></i>
                            </span>
                            <input type="number" class="form-input @error('age') is-invalid @enderror"
                                   id="age" name="age"
                                   value="{{ old('age', $patient->age ?? '') }}">
                        </div>
                        @error('age')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label for="gender" class="form-label">Gender</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fas fa-venus-mars"></i>
                            </span>
                            <select class="form-input @error('gender') is-invalid @enderror"
                                    id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ (old('gender', $patient->gender ?? '') == 'Male') ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ (old('gender', $patient->gender ?? '') == 'Female') ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ (old('gender', $patient->gender ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        @error('gender')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Information Alert -->
                <div class="info-alert">
                    <div class="alert-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="alert-content">
                        <h4 class="alert-title">Keep Your Information Updated</h4>
                        <p class="alert-description">
                            Keeping your profile information up-to-date helps us provide better dental care and ensures we can contact you when needed.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <a href="{{ route('user.dashboard') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Profile Page Styles - Matching Dashboard Theme */
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

    /* Dashboard Cards */
    .dashboard-card {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        margin-bottom: 2rem;
    }

    .dashboard-card:hover {
        box-shadow: var(--shadow-hover);
    }

    .full-width {
        width: 100%;
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

    /* Form Styles */
    .profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--dark);
    }

    .required {
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
        font-size: 1rem;
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
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .form-input.is-invalid {
        border-color: var(--danger);
    }

    .form-input.disabled {
        background-color: var(--gray-light);
        color: var(--gray);
        cursor: not-allowed;
    }

    .form-note {
        font-size: 0.85rem;
        color: var(--gray);
        margin-top: 0.5rem;
    }

    .error-message {
        color: var(--danger);
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    /* Alert Styles */
    .info-alert {
        display: flex;
        align-items: flex-start;
        padding: 1.5rem;
        background-color: rgba(76, 201, 240, 0.1);
        border-radius: var(--radius-sm);
        margin-bottom: 2rem;
    }

    .alert-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--accent);
        color: white;
        margin-right: 1rem;
        flex-shrink: 0;
        font-size: 1.25rem;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        color: var(--dark);
    }

    .alert-description {
        font-size: 0.95rem;
        color: var(--gray);
        margin: 0;
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-primary, .btn-secondary {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: var(--gradient);
        color: white;
    }

    .btn-secondary {
        background-color: white;
        color: var(--gray);
        border: 1px solid var(--gray-light);
    }

    .btn-primary:hover, .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary i, .btn-secondary i {
        margin-right: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
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
