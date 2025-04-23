<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        \Log::info('Root route accessed', [
            'email' => $user->email,
            'role' => $user->role ?? 'none',
            'is_admin' => $user->isAdmin(),
        ]);
        return $user->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.home');
    }
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Redirect /dashboard based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return $user->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.home');
    })->name('dashboard');

    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->middleware('auth')
        ->name('admin.dashboard');

    // User dashboard
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])
        ->middleware('auth')
        ->name('user.user_dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient routes
    Route::get('/', [PatientController::class, 'index'])->name('admin.patient.index');
    Route::get('/patientList', [PatientController::class, 'list'])->name('admin.patient.list');
    Route::get('/createPatient', [PatientController::class, 'store'])->name('admin.patient.store');
    Route::post('/createPatient', [PatientController::class, 'createPatient'])->name('admin.patient.create');
    Route::get('/showPatient/{id}', [PatientController::class, 'show'])->name('admin.patient.show');
    Route::get('/editPatient/{id}', [PatientController::class, 'edit'])->name('admin.patient.edit');
    Route::post('/editPatient', [PatientController::class, 'update'])->name('admin.patient.update');
    Route::delete('/patient/{patient}', [PatientController::class, 'destroy'])->name('admin.patient.destroy');
    
    // API routes for patient
    Route::get('/patient/getTreatments', [PatientController::class, 'getTreatments']);
    Route::get('/patient/getTreatDataById/{id}', [PatientController::class, 'getTreatDataById']);
    Route::get('/patient/getSubTreatDataById/{id}', [PatientController::class, 'getSubTreatDataById']);
    Route::get('/patient/getSubCategory/{id}', [PatientController::class, 'getSubCategory']);
    Route::get('/patient/getPatientByID/{id}', [PatientController::class, 'getPatientByID']);
    Route::get('/patient/patientList', [PatientController::class, 'patientList']);
    
    // Invoice routes
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/createInvoice/{id}', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('/ViewInvoice/{id}', [InvoiceController::class, 'view'])->name('invoice.view');
    Route::post('/createInvoice', [PatientController::class, 'createInvoice'])->name('invoice.store');

    // Chart routes
    Route::get('/Chart', [ChartController::class, 'index'])->name('Chart.index');

    // Appointment routes
    Route::get('/Appointments', [AppointmentController::class, 'index'])->name('Appointments.index');
});

require __DIR__.'/auth.php';
