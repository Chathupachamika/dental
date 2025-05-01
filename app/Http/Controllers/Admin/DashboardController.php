<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getTotalPatients()
    {
        $totalPatients = Patient::count();
        $lastMonthPatients = Patient::where('created_at', '<', Carbon::now()->startOfMonth())
            ->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->count();

        $currentMonthPatients = Patient::whereMonth('created_at', Carbon::now()->month)->count();
        $percentageChange = $lastMonthPatients > 0
            ? (($currentMonthPatients - $lastMonthPatients) / $lastMonthPatients) * 100
            : 100;

        return response()->json([
            'total' => $totalPatients,
            'percentageChange' => round($percentageChange, 1)
        ]);
    }

    public function getTodayAppointments()
    {
        $todayCount = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $yesterdayCount = Appointment::whereDate('appointment_date', Carbon::yesterday())->count();

        $percentageChange = $yesterdayCount > 0
            ? (($todayCount - $yesterdayCount) / $yesterdayCount) * 100
            : 100;

        return response()->json([
            'count' => $todayCount,
            'percentageChange' => round($percentageChange, 1)
        ]);
    }

    public function getMonthlyRevenue()
    {
        $currentMonthRevenue = Invoice::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('totalAmount');

        $lastMonthRevenue = Invoice::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('totalAmount');

        $percentageChange = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : ($currentMonthRevenue > 0 ? 100 : 0);

        return response()->json([
            'amount' => $currentMonthRevenue,
            'percentageChange' => round($percentageChange, 1)
        ]);
    }

    public function getPendingPayments()
    {
        $totalPending = Invoice::whereRaw('totalAmount > advanceAmount')
            ->sum(DB::raw('totalAmount - advanceAmount'));

        $todayPending = Invoice::whereRaw('totalAmount > advanceAmount')
            ->whereDate('created_at', Carbon::today())
            ->sum(DB::raw('totalAmount - advanceAmount'));

        $yesterdayPending = Invoice::whereRaw('totalAmount > advanceAmount')
            ->whereDate('created_at', Carbon::yesterday())
            ->sum(DB::raw('totalAmount - advanceAmount'));

        $percentageChange = $yesterdayPending > 0
            ? (($todayPending - $yesterdayPending) / $yesterdayPending) * 100
            : ($todayPending > 0 ? 100 : 0);

        return response()->json([
            'amount' => $totalPending,
            'percentageChange' => round($percentageChange, 1)
        ]);
    }
}
