<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LocalBookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RateController;
use App\Models\Rate;


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
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    return $user->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', function () {
    return view('user.aboutus');
})->name('user.aboutus');

Route::get('/contact', function () {
    return view('user.contactus',["rates"=>Rate::all()]);
})->name('user.contactus');

Route::get('/rental', function () {
    return view('user.car-rental');
})->name('user.car-rental');

Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

Route::post('/bookings/save', [LocalBookingController::class, 'store'])->name('bookings.save');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user/home', [UserController::class, 'home'])->name('user.home');

    // Add these new user booking routes
    Route::get('/user/bookings', [BookingController::class, 'userBookings'])->name('user.booking');

    //my booking
    Route::get('/user/bookings/booked', [BookingController::class, 'booked'])->name('user.booking.booked');
    Route::get('/user/bookings/active', [BookingController::class, 'active'])->name('user.booking.active');
    Route::get('/user/bookings/past', [BookingController::class, 'past'])->name('user.booking.past');
    Route::get('/user/bookings/cancelled', [BookingController::class, 'cancelled'])->name('user.booking.cancelled');
    Route::get('/user/bookings/search', [BookingController::class, 'search'])->name('user.booking.search');
    Route::delete('/user/bookings/{booking}', [BookingController::class, 'destroy'])->name('user.booking.destroy');


    Route::get('/user/bookings/create', [BookingController::class, 'create'])->name('user.booking.create');
    Route::get('/user/bookings/{booking}', [BookingController::class, 'userShow'])->name('user.booking.show');
    Route::get('/user/car-rental', [VehicleController::class, 'index'])->name('user.car-rental');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/check-availability', [AdminController::class, 'checkAvailability'])->name('admin.check-availability');

    // Vehicle management routes
    Route::get('/admin/vehicle-management', [VehicleController::class, 'index'])->name('admin.vehicle-management');
    Route::post('/admin/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/admin/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::patch('/admin/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/admin/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

    // Customer Management Routes
    Route::prefix('admin')->group(function () {
        Route::get('/customer-management', [CustomerController::class, 'index'])->name('admin.customer-management');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::patch('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    // Booking Management Routes
    Route::prefix('admin')->group(function () {
        Route::get('/bookings', [BookingController::class, 'index'])->name('admin.booking-management');
        Route::resource('bookings', BookingController::class)->except(['index']);
    });

    // Driver Management Routes
    Route::prefix('admin')->group(function () {
        Route::get('/driver-management', [DriverController::class, 'index'])->name('admin.driver-management');
        Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
        Route::get('/drivers/{driver_id}', [DriverController::class, 'show'])->name('drivers.show');
        Route::patch('/drivers/{driver_id}', [DriverController::class, 'update'])->name('drivers.update');
        Route::delete('/drivers/{driver_id}', [DriverController::class, 'destroy'])->name('drivers.destroy');
    });


        //rating
        Route::post('/rate', [RateController::class, 'store'])->name('rate.store');

    // Report Routes
    Route::prefix('admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
        Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.export.pdf');
        Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('admin.reports.export.excel');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/check-availability', [AdminController::class, 'checkAvailability'])->name('admin.check-availability');
});


require __DIR__.'/auth.php';
