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

        // User profile
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserController::class, 'updateProfile'])->name('update.profile');
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
            Route::get('/create', [PatientController::class, 'store'])->name('store');
            Route::post('/create', [PatientController::class, 'createPatient'])->name('create');
            Route::get('/show/{id}', [PatientController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('edit');
            Route::post('/edit', [PatientController::class, 'update'])->name('update');
            Route::delete('/{patient}', [PatientController::class, 'destroy'])->name('destroy');
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

        // Chart routes
        Route::prefix('chart')->name('chart.')->group(function () {
            Route::get('/', [ChartController::class, 'index'])->name('index');
        });

        // Appointment routes
        Route::prefix('appointment')->name('appointments.')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('index');
            Route::post('/{id}/confirm', [AppointmentController::class, 'confirm'])->name('confirm');
            Route::get('/{id}/edit', [AppointmentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AppointmentController::class, 'update'])->name('update');
            Route::post('/{id}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
            Route::get('/{id}/notify', [AppointmentController::class, 'notify'])->name('notify');
        });

        // Reports route
        Route::get('/reports', [ChartController::class, 'index'])->name('reports.index');

        Route::get('/patients/export', [PatientController::class, 'export'])->name('patient.export');

        Route::get('/chart/revenue', [App\Http\Controllers\Admin\ChartController::class, 'revenue'])->name('chart.revenue');

        Route::get('/chart/treatments', [App\Http\Controllers\Admin\ChartController::class, 'treatments'])->name('chart.treatments');
        Route::get('/chart/appointments', [App\Http\Controllers\Admin\ChartController::class, 'appointments'])->name('chart.appointments');

        // Add this new route
        Route::get('/chart/patient-ages', [PatientController::class, 'getPatientAges'])->name('chart.patient-ages');

        // Add these new API routes
        Route::get('/recent-invoices', [InvoiceController::class, 'getRecentInvoices'])->name('recent.invoices');
        Route::get('/treatment-stats', [PatientController::class, 'getTreatmentStats'])->name('treatment.stats');
        Route::get('/appointment-stats', [AppointmentController::class, 'getStats'])->name('appointment.stats');
    });

    // API routes for patient - accessible to both admin and users
    Route::get('/patient/getTreatments', [PatientController::class, 'getTreatments']);
    Route::get('/patient/getTreatDataById/{id}', [PatientController::class, 'getTreatDataById']);
    Route::get('/patient/getSubTreatDataById/{id}', [PatientController::class, 'getSubTreatDataById']);
    Route::get('/patient/getSubCategory/{id}', [PatientController::class, 'getSubCategory']);
    Route::get('/patient/getPatientByID/{id}', [PatientController::class, 'getPatientByID']);
    Route::get('/patient/patientList', [PatientController::class, 'patientList']);
});


require __DIR__.'/auth.php';
