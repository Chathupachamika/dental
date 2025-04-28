@extends('admin.admin_logged.app')

@section('content')
<div class="appointments-container">
    <div class="appointments-header">
        <div class="header-content">
            <h1 class="page-title">Edit Appointment</h1>
            <p class="page-subtitle">Update appointment details for {{ $appointment->user->name ?? 'Unknown' }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.appointments.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="appointments-card">
        <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="appointment_date">Appointment Date</label>
                    <input type="date" id="appointment_date" name="appointment_date"
                    value="{{ old('appointment_date', optional($appointment)->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : now()->format('Y-m-d')) }}"

                           class="form-control @error('appointment_date') is-invalid @enderror" required>
                    @error('appointment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="appointment_time">Appointment Time</label>
                    <input type="time" id="appointment_time" name="appointment_time"
                           value="{{ old('appointment_time', $appointment->appointment_time) }}"
                           class="form-control @error('appointment_time') is-invalid @enderror" required>
                    @error('appointment_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="pending" {{ old('status', $appointment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ old('status', $appointment->status) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ old('status', $appointment->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="4"
                          class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $appointment->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="history.back()">Cancel</button>
                <button type="submit" class="btn-primary">Update Appointment</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Simplified styles for the edit appointment page */
.appointments-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.appointments-header {
    margin-bottom: 2rem;
    text-align: center;
}

.page-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #718096;
}

.appointments-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    padding: 2rem;
    margin-bottom: 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #2d3748;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49,130,206,0.1);
    outline: none;
}

.is-invalid {
    border-color: #e53e3e;
}

.invalid-feedback {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-primary {
    background: #3182ce;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-secondary {
    background: #e2e8f0;
    color: #4a5568;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
</style>

@endsection
