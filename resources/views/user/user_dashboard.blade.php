@extends('user.layouts.app')

@section('content')
<!-- Profile Completion & Terms Agreement Check -->
<script>
    window.onload = function() {
        // First check terms agreement status
        fetch('{{ route("user.api.terms.status") }}')
            .then(response => response.json())
            .then(data => {
                if (!data.terms_agreed) {
                    Swal.fire({
                        title: 'Terms & Conditions',
                        text: 'Please review and accept our terms and conditions to continue.',
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

        // Load upcoming appointments
        loadUpcomingAppointments();
    }

    // Function to load upcoming appointments
    function loadUpcomingAppointments() {
        const appointmentsContainer = document.getElementById('upcoming-appointments-container');
        if (!appointmentsContainer) return;

        appointmentsContainer.innerHTML = '<div class="loading-spinner"><div class="spinner"></div><p>Loading your appointments...</p></div>';

        fetch('{{ route("user.api.appointments.upcoming") }}')
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    let html = '<div class="appointments-table"><table><thead><tr><th>Date & Time</th><th>Treatment</th><th class="text-right">Actions</th></tr></thead><tbody>';

                    data.forEach(appointment => {
                        const date = new Date(appointment.visitDate);
                        const formattedDate = date.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        });

                        const dayName = date.toLocaleDateString('en-US', {
                            weekday: 'long'
                        });

                        let treatmentName = 'Not specified';
                        if (appointment.invoiceTreatment && appointment.invoiceTreatment.length > 0) {
                            treatmentName = appointment.invoiceTreatment[0].treatMent;
                        }

                        html += `
                            <tr>
                                <td>
                                    <div class="appointment-date">
                                        <span class="date">${formattedDate}</span>
                                        <span class="day">${dayName}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="treatment-badge ${treatmentName === 'Not specified' ? 'empty' : ''}">${treatmentName}</span>
                                </td>
                                <td class="text-right">
                                    <a href="/user/appointment/${appointment.id}" class="btn-view">
                                        <i class="fas fa-eye"></i> Details
                                    </a>
                                </td>
                            </tr>
                        `;
                    });

                    html += '</tbody></table></div>';
                    appointmentsContainer.innerHTML = html;
                } else {
                    appointmentsContainer.innerHTML = `
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
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading appointments:', error);
                appointmentsContainer.innerHTML = `
                    <div class="error-state">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4 class="error-title">Couldn't Load Appointments</h4>
                        <p class="error-description">There was an error loading your appointments. Please try again later.</p>
                        <button onclick="loadUpcomingAppointments()" class="btn-retry">
                            <i class="fas fa-sync-alt"></i> Retry
                        </button>
                    </div>
                `;
            });
    }
</script>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-card">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h2 class="welcome-title">
                        <i class="fas fa-smile-beam welcome-icon"></i>
                        Welcome back, {{ Auth::user()->name }}
                    </h2>
                    <p class="welcome-description">Manage your dental appointments and health information all in one place.</p>
                    <div class="welcome-actions">
                        <a href="{{ route('user.book.appointment') }}" class="btn-primary">
                            <i class="fas fa-calendar-plus"></i> Schedule Appointment
                        </a>
                        <a href="{{ route('user.appointments') }}" class="btn-outline">
                            <i class="fas fa-calendar-alt"></i> View All Appointments
                        </a>
                    </div>
                </div>
                <div class="welcome-graphic">
                    <div class="welcome-illustration">
                        <i class="fas fa-tooth"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value" id="upcoming-count">-</h3>
                    <p class="stat-label">Upcoming Appointments</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value" id="completed-count">-</h3>
                    <p class="stat-label">Completed Visits</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value" id="invoice-count">-</h3>
                    <p class="stat-label">Total Invoices</p>
                </div>
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
                <div class="card-actions">
                    <a href="{{ route('user.book.appointment') }}" class="btn-sm">
                        <i class="fas fa-plus"></i> New
                    </a>
                </div>
            </div>
            <div class="card-body" id="upcoming-appointments-container">
                <!-- Appointments will be loaded here via JavaScript -->
                <div class="loading-spinner">
                    <div class="spinner"></div>
                    <p>Loading your appointments...</p>
                </div>
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

    <!-- Recent Invoices -->
    <div class="dashboard-card full-width">
        <div class="card-header">
            <div class="header-icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <h3 class="card-title">Recent Invoices</h3>
            <div class="card-actions">
                <a href="{{ route('user.invoices') }}" class="btn-link">
                    View All <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
        <div class="card-body" id="recent-invoices-container">
            <div class="loading-spinner">
                <div class="spinner"></div>
                <p>Loading your invoices...</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3 class="section-title">Quick Actions</h3>
        <div class="actions-grid">
            <a href="{{ route('user.book.appointment') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h4 class="action-title">Book Appointment</h4>
                <p class="action-description">Schedule your next dental visit</p>
            </a>

            <a href="{{ route('user.profile') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h4 class="action-title">Update Profile</h4>
                <p class="action-description">Keep your information up to date</p>
            </a>

            <a href="{{ route('user.invoices') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h4 class="action-title">View Invoices</h4>
                <p class="action-description">Check your payment history</p>
            </a>

            <a href="{{ route('user.help') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h4 class="action-title">Help & Support</h4>
                <p class="action-description">Get assistance when needed</p>
            </a>
        </div>
    </div>
</div>

<script>
    // Load stats when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Load appointment counts
        fetch('{{ route("user.api.appointments.upcoming") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('upcoming-count').textContent = data.length || 0;
            })
            .catch(error => {
                console.error('Error loading upcoming appointments count:', error);
                document.getElementById('upcoming-count').textContent = '0';
            });

        fetch('{{ route("user.api.appointments.completed") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('completed-count').textContent = data.length || 0;
            })
            .catch(error => {
                console.error('Error loading completed appointments count:', error);
                document.getElementById('completed-count').textContent = '0';
            });

        // Load invoices
        fetch('{{ route("user.api.invoices") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('invoice-count').textContent = data.length || 0;

                // Also populate recent invoices
                const invoicesContainer = document.getElementById('recent-invoices-container');
                if (data && data.length > 0) {
                    let html = '<div class="invoices-table"><table><thead><tr><th>Invoice #</th><th>Date</th><th>Amount</th><th>Status</th><th class="text-right">Actions</th></tr></thead><tbody>';

                    // Show only the 5 most recent invoices
                    const recentInvoices = data.slice(0, 5);

                    recentInvoices.forEach(invoice => {
                        const date = new Date(invoice.created_at);
                        const formattedDate = date.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        });

                        const isPaid = invoice.totalAmount <= invoice.advanceAmount;
                        const statusClass = isPaid ? 'status-paid' : 'status-pending';
                        const statusText = isPaid ? 'Paid' : 'Pending';
                        const statusIcon = isPaid ? 'fa-check-circle' : 'fa-clock';

                        html += `
                            <tr>
                                <td>
                                    <span class="invoice-number">#${invoice.id}</span>
                                </td>
                                <td>${formattedDate}</td>
                                <td>₹${invoice.totalAmount.toLocaleString()}</td>
                                <td>
                                    <span class="status-badge ${statusClass}">
                                        <i class="fas ${statusIcon}"></i> ${statusText}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('user.invoices.view', ':id') }}".replace(':id', invoice.id) class="btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('user.invoices.download', ':id') }}".replace(':id', invoice.id) class="btn-download">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                        `;
                    });

                    html += '</tbody></table></div>';
                    invoicesContainer.innerHTML = html;
                } else {
                    invoicesContainer.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <h4 class="empty-title">No Invoices Found</h4>
                            <p class="empty-description">You don't have any invoices at the moment.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading invoices:', error);
                document.getElementById('invoice-count').textContent = '0';

                const invoicesContainer = document.getElementById('recent-invoices-container');
                invoicesContainer.innerHTML = `
                    <div class="error-state">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4 class="error-title">Couldn't Load Invoices</h4>
                        <p class="error-description">There was an error loading your invoices. Please try again later.</p>
                    </div>
                `;
            });
    });
</script>

<style>
    /* Modern Dashboard Styles */
    :root {
        /* Primary Colors */
        --primary: #4361ee;
        --primary-light: #4895ef;
        --primary-dark: #3f37c9;
        --primary-50: rgba(67, 97, 238, 0.05);
        --primary-100: rgba(67, 97, 238, 0.1);
        --primary-200: rgba(67, 97, 238, 0.2);

        /* Secondary Colors */
        --secondary: #3f37c9;
        --accent: #4cc9f0;
        --accent-light: #72efdd;

        /* Semantic Colors */
        --success: #10b981;
        --success-light: rgba(16, 185, 129, 0.1);
        --warning: #f59e0b;
        --warning-light: rgba(245, 158, 11, 0.1);
        --danger: #ef4444;
        --danger-light: rgba(239, 68, 68, 0.1);
        --info: #3b82f6;
        --info-light: rgba(59, 130, 246, 0.1);

        /* Neutral Colors */
        --white: #ffffff;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;

        /* Shadows */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-inner: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
        --shadow-outline: 0 0 0 3px rgba(66, 153, 225, 0.5);

        /* Border Radius */
        --radius-sm: 0.125rem;
        --radius: 0.25rem;
        --radius-md: 0.375rem;
        --radius-lg: 0.5rem;
        --radius-xl: 0.75rem;
        --radius-2xl: 1rem;
        --radius-3xl: 1.5rem;
        --radius-full: 9999px;

        /* Transitions */
        --transition-fast: 0.15s ease;
        --transition: 0.3s ease;
        --transition-slow: 0.5s ease;

        /* Fonts */
        --font-sans: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    /* Base Styles */
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
        font-family: var(--font-sans);
        color: var(--gray-800);
    }

    /* Welcome Section */
    .welcome-section {
        margin-bottom: 2rem;
    }

    .welcome-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        color: white;
        position: relative;
        z-index: 1;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        z-index: -1;
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        z-index: -1;
    }

    .welcome-content {
        display: flex;
        align-items: center;
        padding: 2.5rem;
        position: relative;
        z-index: 2;
    }

    .welcome-text {
        flex: 1;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        line-height: 1.2;
    }

    .welcome-icon {
        margin-right: 0.75rem;
        font-size: 1.75rem;
    }

    .welcome-description {
        font-size: 1.1rem;
        margin-bottom: 1.75rem;
        opacity: 0.9;
        max-width: 80%;
        line-height: 1.6;
    }

    .welcome-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
        color: var(--gray-900);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-full);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: var(--shadow-md);
    }

    .btn-primary i {
        margin-right: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent) 100%);
    }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        background-color: transparent;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-full);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-outline i {
        margin-right: 0.5rem;
    }

    .btn-outline:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-3px);
    }

    .welcome-graphic {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .welcome-illustration {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        box-shadow: var(--shadow-md);
        position: relative;
        animation: float 6s ease-in-out infinite;
    }

    .welcome-illustration::before {
        content: '';
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.1);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.1); opacity: 0.1; }
    }

    /* Stats Container */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: -1.5rem;
        position: relative;
        z-index: 10;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        transition: var(--transition);
        border: 1px solid var(--gray-100);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-lg);
        background: var(--primary-100);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 0.25rem 0;
        color: var(--gray-900);
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--gray-500);
        margin: 0;
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
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
        border: 1px solid var(--gray-100);
    }

    .dashboard-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .card-header {
        display: flex;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        position: relative;
    }

    .header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: var(--radius-lg);
        background: var(--primary-100);
        color: var(--primary);
        margin-right: 1rem;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-800);
        flex: 1;
    }

    .card-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-sm {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        color: var(--primary);
        background-color: var(--primary-50);
        transition: var(--transition);
    }

    .btn-sm i {
        margin-right: 0.4rem;
    }

    .btn-sm:hover {
        background-color: var(--primary-100);
    }

    .btn-link {
        display: inline-flex;
        align-items: center;
        color: var(--primary);
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-link i {
        margin-left: 0.4rem;
        font-size: 0.75rem;
        transition: var(--transition);
    }

    .btn-link:hover {
        color: var(--primary-dark);
    }

    .btn-link:hover i {
        transform: translateX(3px);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Tables */
    .appointments-table, .invoices-table {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    thead {
        background-color: var(--gray-50);
    }

    th {
        padding: 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray-600);
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-100);
        vertical-align: middle;
        font-size: 0.95rem;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background-color: var(--gray-50);
    }

    .appointment-date {
        display: flex;
        flex-direction: column;
    }

    .date {
        font-weight: 600;
        color: var(--gray-800);
    }

    .day {
        font-size: 0.85rem;
        color: var(--gray-500);
    }

    .treatment-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 500;
        background-color: var(--primary-100);
        color: var(--primary);
    }

    .treatment-badge.empty {
        background-color: var(--gray-100);
        color: var(--gray-600);
    }

    .invoice-number {
        font-weight: 600;
        color: var(--primary);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-badge i {
        margin-right: 0.4rem;
        font-size: 0.8rem;
    }

    .status-paid {
        background-color: var(--success-light);
        color: var(--success);
    }

    .status-pending {
        background-color: var(--warning-light);
        color: var(--warning);
    }

    .text-right {
        text-align: right;
    }

    .btn-view, .btn-download {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
        margin-left: 0.5rem;
    }

    .btn-view {
        color: var(--primary);
        border: 1px solid var(--primary-100);
        background-color: var(--primary-50);
    }

    .btn-view i {
        margin-right: 0.4rem;
    }

    .btn-view:hover {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .btn-download {
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
        background-color: var(--gray-50);
    }

    .btn-download i {
        margin-right: 0.4rem;
    }

    .btn-download:hover {
        background-color: var(--gray-200);
        color: var(--gray-800);
    }

    /* Empty States */
    .empty-state, .error-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
    }

    .empty-icon, .error-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 1.5rem;
        font-size: 2rem;
    }

    .empty-icon {
        background-color: var(--gray-100);
        color: var(--gray-400);
    }

    .error-icon {
        background-color: var(--danger-light);
        color: var(--danger);
    }

    .empty-title, .error-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-title {
        color: var(--gray-700);
    }

    .error-title {
        color: var(--danger);
    }

    .empty-description, .error-description {
        margin-bottom: 1.5rem;
        max-width: 300px;
    }

    .empty-description {
        color: var(--gray-500);
    }

    .error-description {
        color: var(--gray-600);
    }

    .btn-book, .btn-retry {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-full);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-book {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .btn-retry {
        background-color: var(--gray-100);
        color: var(--gray-700);
        border: none;
        cursor: pointer;
    }

    .btn-book i, .btn-retry i {
        margin-right: 0.5rem;
    }

    .btn-book:hover, .btn-retry:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
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
        border-bottom: 1px solid var(--gray-100);
        transition: var(--transition);
    }

    .tip-item:last-child {
        border-bottom: none;
    }

    .tip-item:hover {
        transform: translateX(5px);
    }

    .tip-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: var(--radius-lg);
        background: var(--primary-100);
        color: var(--primary);
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
        color: var(--gray-800);
    }

    .tip-description {
        font-size: 0.9rem;
        color: var(--gray-600);
        margin: 0;
        line-height: 1.5;
    }

    /* Quick Actions */
    .quick-actions {
        margin-top: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--gray-800);
        position: relative;
        padding-left: 1rem;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.25rem;
        bottom: 0.25rem;
        width: 4px;
        background: linear-gradient(to bottom, var(--primary), var(--primary-light));
        border-radius: var(--radius-full);
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .action-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        text-decoration: none;
        border: 1px solid var(--gray-100);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-100);
    }

    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-lg);
        background: var(--primary-100);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .action-card:hover .action-icon {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
    }

    .action-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        color: var(--gray-800);
    }

    .action-description {
        font-size: 0.9rem;
        color: var(--gray-500);
        margin: 0;
    }

    /* Loading Spinner */
    .loading-spinner {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid var(--gray-200);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 1rem;
    }

    .loading-spinner p {
        color: var(--gray-500);
        font-size: 0.9rem;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
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

        .welcome-actions {
            justify-content: center;
        }

        .welcome-graphic {
            display: none;
        }

        .stats-container {
            grid-template-columns: 1fr;
            margin-top: 1rem;
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }

        .card-header {
            flex-wrap: wrap;
        }

        .card-actions {
            margin-top: 0.5rem;
            width: 100%;
            justify-content: flex-end;
        }

        .btn-view, .btn-download {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
    }
</style>
@endsection
