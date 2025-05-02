<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Common dashboard route that redirects based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');

    // User routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        // Appointment booking
        Route::get('/book-appointment', [UserController::class, 'bookAppointment'])->name('book.appointment');
        Route::post('/book-appointment', [UserController::class, 'storeAppointment'])->name('store.appointment');

        // Appointment management
        Route::get('/appointments', [UserController::class, 'appointments'])->name('appointments');
        Route::get('/appointment/{id}', [UserController::class, 'appointmentDetails'])->name('appointment.details');
        Route::post('/appointment/{id}/cancel', [UserController::class, 'cancelAppointment'])->name('appointment.cancel');

        // Add this new route
        Route::get('/appointments/confirmed', [AppointmentController::class, 'getConfirmedAppointments'])->name('appointments.confirmed');

        // Appointment API routes
        Route::get('/api/appointments/all', [AppointmentController::class, 'getAllAppointments'])->name('api.appointments.all');
        Route::get('/api/appointments/upcoming', [AppointmentController::class, 'getUpcomingAppointments'])->name('api.appointments.upcoming');
        Route::get('/api/appointments/completed', [AppointmentController::class, 'getCompletedAppointments'])->name('api.appointments.completed');
        Route::get('/api/appointments/cancelled', [AppointmentController::class, 'getCancelledAppointments'])->name('api.appointments.cancelled');
        Route::get('/api/appointments/search', [AppointmentController::class, 'searchAppointments'])->name('api.appointments.search');

        // Add this new route
        Route::get('/api/terms-status', [UserController::class, 'getTermsStatus'])->name('api.terms.status');

        // User profile
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserController::class, 'updateProfile'])->name('update.profile');

        // Add these new routes
        Route::get('/check-profile', [UserController::class, 'checkProfileCompletion'])->name('check.profile');
        Route::get('/clear-login-session', [UserController::class, 'clearLoginSession'])->name('clear.login.session');

        // User invoices
        Route::get('/invoices', [App\Http\Controllers\User\InvoiceController::class, 'index'])->name('invoices');
        Route::get('/invoices/view/{id}', [App\Http\Controllers\User\InvoiceController::class, 'view'])->name('invoices.view');
        Route::get('/api/my-invoices', [App\Http\Controllers\User\InvoiceController::class, 'getMyInvoices'])->name('api.invoices');
        Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

        // Help & Support
        Route::get('/help', [App\Http\Controllers\User\HelpController::class, 'index'])->name('help');
     });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes - update the middleware definition
    Route::prefix('admin')->name('admin.')
        ->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
        ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Patient routes
        Route::prefix('patient')->name('patient.')->group(function () {
            Route::get('/', [PatientController::class, 'index'])->name('index');
            Route::get('/list', [PatientController::class, 'list'])->name('list');
            Route::get('/patientList', [PatientController::class, 'patientList'])->name('patientList');
            Route::get('/create', [PatientController::class, 'store'])->name('store');
            Route::post('/create', [PatientController::class, 'createPatient'])->name('create');
            Route::get('/show/{id}', [PatientController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('edit');
            Route::post('/edit', [PatientController::class, 'update'])->name('update');
            Route::delete('/{patient}', [PatientController::class, 'destroy'])->name('destroy');
            Route::get('/{patient}/download', [PatientController::class, 'downloadPDF'])->name('download'); // Add this line
        });

        // Invoice routes
        Route::prefix('invoice')->name('invoice.')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('index');
            Route::get('/create/{id?}', [InvoiceController::class, 'create'])->name('create');
            Route::get('/view/{id}', [InvoiceController::class, 'view'])->name('view');
            Route::post('/create', [InvoiceController::class, 'store'])->name('store');
            Route::get('/{invoice}/download', [InvoiceController::class, 'download'])->name('download');
            Route::put('/update/{id}', [InvoiceController::class, 'update'])->name('update');
        });

        // Chart routes - update to use single consistent route
        Route::prefix('chart')->name('chart.')->group(function () {
            Route::get('/', [ChartController::class, 'index'])->name('index');
            Route::get('/data', [ChartController::class, 'getData'])->name('data');
            Route::get('/revenue', [ChartController::class, 'revenue'])->name('revenue');
            Route::get('/treatments', [ChartController::class, 'treatments'])->name('treatments');
            Route::get('/appointments', [ChartController::class, 'appointments'])->name('appointments');
            Route::post('/export', [ChartController::class, 'export'])->name('export'); // Add this line
        });

        // Appointment routes
        Route::prefix('appointment')->name('appointments.')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('index');
            Route::get('/today-schedule', [AppointmentController::class, 'getTodaySchedule'])->name('today.schedule');
            Route::get('/today', [AppointmentController::class, 'getTodayAppointments'])->name('today');
            Route::post('/store', [AppointmentController::class, 'store'])->name('store');
            Route::post('/api/store', [AppointmentController::class, 'apiStore'])->name('api.store');

            // ID-specific routes should come last
            Route::post('/{id}/confirm', [AppointmentController::class, 'confirm'])->name('confirm');
            Route::get('/{id}/edit', [AppointmentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AppointmentController::class, 'update'])->name('update');
            Route::post('/{id}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
            Route::get('/{id}/notify', [AppointmentController::class, 'notify'])->name('notify');
            Route::get('/{id}', [AppointmentController::class, 'show'])->name('show');
        });

        Route::get('/patients/export', [PatientController::class, 'export'])->name('patient.export');

        // Add this new route
        Route::get('/chart/patient-ages', [PatientController::class, 'getPatientAges'])->name('chart.patient-ages');

        // Add these new API routes
        Route::get('/recent-invoices', [InvoiceController::class, 'getRecentInvoices'])->name('recent.invoices');
        Route::get('/treatment-stats', [PatientController::class, 'getTreatmentStats'])->name('treatment.stats');
        Route::get('/appointment-stats', [AppointmentController::class, 'getStats'])->name('appointment.stats');
        Route::get('/api/appointments/stats', [AppointmentController::class, 'getAppointmentStats'])->name('appointments.stats');

        // Add the export daily report route
        Route::post('/export/daily-report', [App\Http\Controllers\Admin\ReportController::class, 'exportDailyReport'])
            ->name('admin.export.daily.report');

        // API Routes for Dashboard Stats
        Route::get('/api/patients/total', [App\Http\Controllers\Admin\DashboardController::class, 'getTotalPatients']);
        Route::get('/api/appointments/today/count', [App\Http\Controllers\Admin\DashboardController::class, 'getTodayAppointments']);
        Route::get('/api/revenue/monthly', [App\Http\Controllers\Admin\DashboardController::class, 'getMonthlyRevenue']);
        Route::get('/api/payments/pending', [App\Http\Controllers\Admin\DashboardController::class, 'getPendingPayments']);

        // Dashboard Stats Routes
        Route::get('/revenue/monthly', [App\Http\Controllers\Admin\DashboardController::class, 'getMonthlyRevenue'])
            ->name('admin.revenue.monthly');
        Route::get('/payments/pending', [App\Http\Controllers\Admin\DashboardController::class, 'getPendingPayments'])
            ->name('admin.payments.pending');

        // Add the PDF export route
        Route::post('/admin/export/analytics-pdf', [App\Http\Controllers\Admin\AnalyticsController::class, 'exportPDF'])
            ->name('admin.export.analytics.pdf');

        // Add the patient PDF download route
        Route::get('/admin/patient/{patient}/download', [App\Http\Controllers\Admin\PatientController::class, 'downloadPDF'])->name('admin.patient.download');

        // Add the dashboard stats route
        Route::get('/dashboard-stats', [AppointmentController::class, 'getDashboardStats'])->name('dashboard.stats');

        // Add this new route
        Route::get('/appointments/counts', [AppointmentController::class, 'getDashboardCounts'])
            ->name('appointments.counts');

        // Add the charts export route
        Route::post('/admin/charts/export', [App\Http\Controllers\Admin\ChartController::class, 'export'])->name('admin.charts.export-pdf');

        // Add the new chart export route
        Route::post('/charts/export', [App\Http\Controllers\Admin\ChartController::class, 'exportPDF'])->name('admin.charts.export-pdf');

        // Add the new reports export route
        Route::post('/reports/export', [App\Http\Controllers\Admin\ChartController::class, 'exportPDF'])->name('admin.reports.export');
    });

    // API routes for patient - accessible to both admin and users
    Route::get('/patient/getTreatments', [PatientController::class, 'getTreatments']);
    Route::get('/patient/getTreatDataById/{id}', [PatientController::class, 'getTreatDataById']);
    Route::get('/patient/getSubTreatDataById/{id}', [PatientController::class, 'getSubTreatDataById']);
    Route::get('/patient/getSubCategory/{id}', [PatientController::class, 'getSubCategory']);
    Route::get('/patient/getPatientByID/{id}', [PatientController::class, 'getPatientByID']);
    Route::get('/patient/getContactInfo/{id}', [PatientController::class, 'getContactInfo']); // Add this new route

    // Add the PDF export route
    Route::post('/admin/analytics/export-pdf', [App\Http\Controllers\Admin\AnalyticsController::class, 'exportPdf'])->name('admin.export.analytics.pdf');
});

require __DIR__.'/auth.php';
