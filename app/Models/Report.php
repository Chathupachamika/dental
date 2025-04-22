<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = null;

    public static function getReportData($startDate = null, $endDate = null, $reportType = 'all')
    {
        $bookingsQuery = Booking::query();
        $vehiclesQuery = Vehicle::query();

        if ($startDate && $endDate) {
            $bookingsQuery->whereBetween('pick_time_date', [$startDate, $endDate]);
        }

        $data = [];

        if ($reportType === 'all' || $reportType === 'bookings') {
            $data['total_bookings'] = $bookingsQuery->count();
            $data['booking_statuses'] = $bookingsQuery->selectRaw('test_filter_status, COUNT(*) as count')
                ->groupBy('test_filter_status')
                ->pluck('count', 'test_filter_status')
                ->toArray();
            $data['top_vehicles'] = $bookingsQuery->select('vehicle_id')
                ->selectRaw('COUNT(*) as booking_count')
                ->groupBy('vehicle_id')
                ->orderBy('booking_count', 'desc')
                ->limit(5)
                ->with('vehicle')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->vehicle->model ?? 'Unknown' => $item->booking_count];
                })->toArray();
        }

        if ($reportType === 'all' || $reportType === 'vehicles') {
            $data['total_vehicles'] = Vehicle::count();
            $data['available_vehicles'] = Vehicle::where('status', 'Available')->count();
            $data['vehicle_categories'] = Vehicle::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category')
                ->toArray();
        }

        if ($reportType === 'all') {
            $data['total_drivers'] = Driver::count();
            $data['available_drivers'] = Driver::where('availability', 'Available')->count();
            $data['total_customers'] = Customer::count();
        }

        if ($reportType === 'all' || $reportType === 'revenue') {
            $data['revenue_by_category'] = $bookingsQuery
                ->join('vehicles', 'booking.vehicle_id', '=', 'vehicles.car_id')
                ->selectRaw('vehicles.category, SUM(vehicles.daily_rate) as revenue')
                ->groupBy('vehicles.category')
                ->pluck('revenue', 'category')
                ->toArray();
        }

        return $data;
    }
}
