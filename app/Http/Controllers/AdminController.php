<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            \Log::info('Redirecting non-admin from admin dashboard', ['email' => $user ? $user->email : 'none']);
            return redirect()->route('user.home');
        }

        try {
            $recentActivities = DB::table('activity_logs')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            $recentActivities = collect(); // Empty collection if table doesn't exist
        }

        $stats = [
            'total_vehicles' => Vehicle::count(),
            'vehicles_today' => Vehicle::whereDate('created_at', today())->count(),
            'vehicles_month' => Vehicle::whereMonth('created_at', now()->month)->count(),
            'total_customers' => Customer::count(),
            'customers_today' => Customer::whereDate('created_at', today())->count(),
            'customers_month' => Customer::whereMonth('created_at', now()->month)->count(),
            'total_drivers' => Driver::count(),
            'drivers_today' => Driver::whereDate('created_at', today())->count(),
            'drivers_month' => Driver::whereMonth('created_at', now()->month)->count(),
            'total_bookings' => Booking::count(),
            'bookings_today' => Booking::whereDate('created_at', today())->count(),
            'bookings_month' => Booking::whereMonth('created_at', now()->month)->count(),
            'booking_statuses' => Booking::selectRaw('test_filter_status, COUNT(*) as count')
                ->groupBy('test_filter_status')
                ->pluck('count', 'test_filter_status')
                ->toArray(),
            'booking_trends' => $this->getBookingTrends(),
            'popular_vehicles' => Vehicle::withCount('bookings')
                ->orderBy('bookings_count', 'desc')
                ->take(5)
                ->get(),
            'recent_activities' => $recentActivities,
            'vehicle_categories' => Vehicle::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->get()
        ];

        $vehicles = Vehicle::all();
        $recentBookings = Booking::with(['customer', 'vehicle'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get all unique car models from the 'vehicles' table
        $carModels = Vehicle::distinct()->pluck('model');

        return view('admin.admin-dashboard', compact('stats', 'vehicles', 'recentBookings', 'carModels'));
    }

    private function getBookingTrends()
    {
        $data = [['Month', 'Active', 'Pending', 'Cancelled', 'Total']];
        $months = Booking::selectRaw('MONTH(pick_time_date) as month, YEAR(pick_time_date) as year')
            ->groupBy('month', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get()
            ->reverse();

        foreach ($months as $month) {
            $counts = Booking::whereMonth('pick_time_date', $month->month)
                ->whereYear('pick_time_date', $month->year)
                ->selectRaw('test_filter_status, COUNT(*) as count')
                ->groupBy('test_filter_status')
                ->pluck('count', 'test_filter_status')
                ->toArray();

            $data[] = [
                \DateTime::createFromFormat('!m', $month->month)->format('M') . ' ' . $month->year,
                $counts['Active'] ?? 0,
                $counts['Pending'] ?? 0,
                $counts['Cancelled'] ?? 0,
                array_sum($counts)
            ];
        }

        return $data;
    }

    public function checkAvailability(Request $request)
    {
        try {
            $request->validate([
                'model' => 'required|exists:vehicles,model', // Ensure model exists
                'date' => 'required|date',
                'time' => 'required'
            ]);

            $dateTime = \Carbon\Carbon::parse("{$request->date} {$request->time}");

            // Get all vehicles of the selected model
            $vehicles = Vehicle::where('model', $request->model)->get();

            // Get booked vehicle IDs for the selected date and time range
            $bookedVehicles = Booking::whereIn('vehicle_id', $vehicles->pluck('car_id'))
                ->where('pick_time_date', '<=', $dateTime)
                ->where('return_time_date', '>=', $dateTime)
                ->pluck('vehicle_id');

            // Get available vehicles
            $availableVehicles = $vehicles->filter(function ($vehicle) use ($bookedVehicles) {
                return !$bookedVehicles->contains($vehicle->car_id);
            });

            return response()->json([
                'available' => $availableVehicles->isNotEmpty(),
                'vehicles' => $availableVehicles
            ]);
        } catch (\Exception $e) {
            \Log::error('Error checking vehicle availability: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred. Please try again later.'
            ], 500);
        }
    }
}