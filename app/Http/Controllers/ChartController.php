<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.chart.index');
    }

    public function getData(Request $request)
    {
        $range = $request->input('range', 'month');
        $startDate = null;
        $endDate = null;

        // Determine date range based on filter
        switch ($range) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                $previousStartDate = Carbon::yesterday();
                $previousEndDate = Carbon::yesterday()->endOfDay();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                $previousStartDate = Carbon::now()->subWeek()->startOfWeek();
                $previousEndDate = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $previousStartDate = Carbon::now()->subMonth()->startOfMonth();
                $previousEndDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                $previousStartDate = Carbon::now()->subYear()->startOfYear();
                $previousEndDate = Carbon::now()->subYear()->endOfYear();
                break;
            case 'custom':
                $startDate = Carbon::parse($request->input('start_date'));
                $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

                // Calculate previous period with same duration
                $daysDiff = $startDate->diffInDays($endDate);
                $previousStartDate = (clone $startDate)->subDays($daysDiff + 1);
                $previousEndDate = (clone $startDate)->subDay()->endOfDay();
                break;
        }

        // Get current period appointments
        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])->get();

        // Get previous period appointments for comparison
        $previousAppointments = Appointment::whereBetween('appointment_date', [$previousStartDate, $previousEndDate])->get();

        // Get invoices for the period
        $invoices = Invoice::whereBetween('created_at', [$startDate, $endDate])->get();
        $previousInvoices = Invoice::whereBetween('created_at', [$previousStartDate, $previousEndDate])->get();

        // Calculate stats
        $totalAppointments = $appointments->count();
        $previousTotalAppointments = $previousAppointments->count();

        $totalAmount = $invoices->sum('totalAmount');
        $previousTotalAmount = $previousInvoices->sum('totalAmount');

        $advanceAmount = $invoices->sum('advanceAmount');
        $previousAdvanceAmount = $previousInvoices->sum('advanceAmount');

        // Calculate conversion rate (confirmed appointments / total appointments)
        $confirmedAppointments = $appointments->where('status', 'confirmed')->count();
        $conversionRate = $totalAppointments > 0 ? round(($confirmedAppointments / $totalAppointments) * 100, 1) : 0;

        $previousConfirmedAppointments = $previousAppointments->where('status', 'confirmed')->count();
        $previousConversionRate = $previousTotalAppointments > 0 ? round(($previousConfirmedAppointments / $previousTotalAppointments) * 100, 1) : 0;

        // Calculate trends (percentage change)
        $appointmentTrendPercentage = $previousTotalAppointments > 0
            ? round((($totalAppointments - $previousTotalAppointments) / $previousTotalAppointments) * 100, 1)
            : 0;

        $amountTrendPercentage = $previousTotalAmount > 0
            ? round((($totalAmount - $previousTotalAmount) / $previousTotalAmount) * 100, 1)
            : 0;

        $advanceTrendPercentage = $previousAdvanceAmount > 0
            ? round((($advanceAmount - $previousAdvanceAmount) / $previousAdvanceAmount) * 100, 1)
            : 0;

        $conversionTrendPercentage = $previousConversionRate > 0
            ? round((($conversionRate - $previousConversionRate) / $previousConversionRate) * 100, 1)
            : 0;

        // Prepare stats data
        $stats = [
            'totalAppointments' => $totalAppointments,
            'appointmentTrendPercentage' => abs($appointmentTrendPercentage),
            'appointmentTrendUp' => $appointmentTrendPercentage >= 0,

            'totalAmount' => $totalAmount,
            'amountTrendPercentage' => abs($amountTrendPercentage),
            'amountTrendUp' => $amountTrendPercentage >= 0,

            'advanceAmount' => $advanceAmount,
            'advanceTrendPercentage' => abs($advanceTrendPercentage),
            'advanceTrendUp' => $advanceTrendPercentage >= 0,

            'conversionRate' => $conversionRate,
            'conversionTrendPercentage' => abs($conversionTrendPercentage),
            'conversionTrendUp' => $conversionTrendPercentage >= 0,
        ];

        // Prepare appointment trends chart data
        $appointmentTrends = $this->getAppointmentTrendsData($range, $startDate, $endDate);

        // Prepare status distribution chart data
        $statusDistribution = $this->getStatusDistributionData($startDate, $endDate);

        // Prepare calendar chart data
        $calendarData = $this->getCalendarData($startDate, $endDate);

        // Prepare revenue by service chart data
        $revenueByService = $this->getRevenueByServiceData($startDate, $endDate);

        // Get recent appointments
        $recentAppointments = $this->getRecentAppointments();

        return response()->json([
            'stats' => $stats,
            'appointmentTrends' => $appointmentTrends,
            'statusDistribution' => $statusDistribution,
            'calendarData' => $calendarData,
            'revenueByService' => $revenueByService,
            'recentAppointments' => $recentAppointments
        ]);
    }

    private function getAppointmentTrendsData($range, $startDate, $endDate)
    {
        $data = [['Period', 'Appointments', 'Revenue']];

        switch ($range) {
            case 'today':
                // Hourly breakdown for today
                for ($hour = 0; $hour < 24; $hour++) {
                    $hourStart = Carbon::today()->addHours($hour);
                    $hourEnd = Carbon::today()->addHours($hour + 1);

                    $appointments = Appointment::whereBetween('appointment_date', [$hourStart, $hourEnd])->count();
                    $revenue = Invoice::whereBetween('created_at', [$hourStart, $hourEnd])->sum('total_amount');

                    $data[] = [$hour . ':00', $appointments, $revenue];
                }
                break;

            case 'week':
                // Daily breakdown for week
                for ($day = 0; $day < 7; $day++) {
                    $dayDate = Carbon::now()->startOfWeek()->addDays($day);

                    $appointments = Appointment::whereDate('appointment_date', $dayDate)->count();
                    $revenue = Invoice::whereDate('created_at', $dayDate)->sum('total_amount');

                    $data[] = [$dayDate->format('D'), $appointments, $revenue];
                }
                break;

            case 'month':
                // Weekly breakdown for month
                $currentDate = Carbon::now()->startOfMonth();
                $weekNumber = 1;

                while ($currentDate->month === Carbon::now()->month) {
                    $weekStart = clone $currentDate;
                    $weekEnd = (clone $currentDate)->addDays(6);

                    if ($weekEnd->month !== $currentDate->month) {
                        $weekEnd = (clone $currentDate)->endOfMonth();
                    }

                    $appointments = Appointment::whereBetween('appointment_date', [$weekStart, $weekEnd])->count();
                    $revenue = Invoice::whereBetween('created_at', [$weekStart, $weekEnd])->sum('total_amount');

                    $data[] = ['Week ' . $weekNumber, $appointments, $revenue];

                    $currentDate->addDays(7);
                    $weekNumber++;
                }
                break;

            case 'year':
                // Monthly breakdown for year
                for ($month = 0; $month < 12; $month++) {
                    $monthDate = Carbon::now()->startOfYear()->addMonths($month);

                    $appointments = Appointment::whereYear('appointment_date', $monthDate->year)
                        ->whereMonth('appointment_date', $monthDate->month)
                        ->count();

                    $revenue = Invoice::whereYear('created_at', $monthDate->year)
                        ->whereMonth('created_at', $monthDate->month)
                        ->sum('total_amount');

                    $data[] = [$monthDate->format('M'), $appointments, $revenue];
                }
                break;

            case 'custom':
                // Determine appropriate interval based on date range
                $daysDiff = $startDate->diffInDays($endDate);

                if ($daysDiff <= 7) {
                    // Daily breakdown
                    for ($day = 0; $day <= $daysDiff; $day++) {
                        $dayDate = (clone $startDate)->addDays($day);

                        $appointments = Appointment::whereDate('appointment_date', $dayDate)->count();
                        $revenue = Invoice::whereDate('created_at', $dayDate)->sum('total_amount');

                        $data[] = [$dayDate->format('M d'), $appointments, $revenue];
                    }
                } else if ($daysDiff <= 31) {
                    // Weekly breakdown
                    $currentDate = clone $startDate;
                    $weekNumber = 1;

                    while ($currentDate <= $endDate) {
                        $weekStart = clone $currentDate;
                        $weekEnd = (clone $currentDate)->addDays(6);

                        if ($weekEnd > $endDate) {
                            $weekEnd = clone $endDate;
                        }

                        $appointments = Appointment::whereBetween('appointment_date', [$weekStart, $weekEnd])->count();
                        $revenue = Invoice::whereBetween('created_at', [$weekStart, $weekEnd])->sum('total_amount');

                        $data[] = ['Week ' . $weekNumber, $appointments, $revenue];

                        $currentDate->addDays(7);
                        $weekNumber++;
                    }
                } else {
                    // Monthly breakdown
                    $currentDate = clone $startDate;

                    while ($currentDate <= $endDate) {
                        $monthStart = (clone $currentDate)->startOfMonth();
                        $monthEnd = (clone $currentDate)->endOfMonth();

                        if ($monthEnd > $endDate) {
                            $monthEnd = clone $endDate;
                        }

                        $appointments = Appointment::whereBetween('appointment_date', [$monthStart, $monthEnd])->count();
                        $revenue = Invoice::whereBetween('created_at', [$monthStart, $monthEnd])->sum('total_amount');

                        $data[] = [$currentDate->format('M Y'), $appointments, $revenue];

                        $currentDate->addMonth();
                    }
                }
                break;
        }

        return $data;
    }

    private function getStatusDistributionData($startDate, $endDate)
    {
        $data = [['Status', 'Count']];

        $confirmed = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'confirmed')
            ->count();

        $pending = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'pending')
            ->count();

        $cancelled = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'cancelled')
            ->count();

        $completed = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->count();

        $data[] = ['Confirmed', $confirmed];
        $data[] = ['Pending', $pending];
        $data[] = ['Cancelled', $cancelled];
        $data[] = ['Completed', $completed];

        return $data;
    }

    private function getCalendarData($startDate, $endDate)
    {
        // For calendar chart, we need data for the entire year
        $yearStart = Carbon::now()->startOfYear();
        $yearEnd = Carbon::now()->endOfYear();

        $appointments = Appointment::select(
                DB::raw('DATE(appointment_date) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('appointment_date', [$yearStart, $yearEnd])
            ->groupBy(DB::raw('DATE(appointment_date)'))
            ->get();

        $data = [];

        foreach ($appointments as $appointment) {
            $data[] = [Carbon::parse($appointment->date)->format('Y-m-d'), $appointment->count];
        }

        return $data;
    }

    private function getRevenueByServiceData($startDate, $endDate)
    {
        $data = [['Service', 'Revenue']];

        // Get revenue from invoice_treatments table grouped by treatment
        $services = DB::table('invoice_treatments')
            ->join('invoices', 'invoice_treatments.invoice_id', '=', 'invoices.id')
            ->select(
                'invoice_treatments.treatMent as service_type',
                DB::raw('SUM(invoices.totalAmount) as revenue')
            )
            ->whereBetween('invoices.created_at', [$startDate, $endDate])
            ->groupBy('invoice_treatments.treatMent')
            ->get();

        if ($services->isEmpty()) {
            // Use actual treatment categories from your database
            $defaultServices = DB::table('treatments')
                ->select('name')
                ->limit(5)
                ->get();

            foreach ($defaultServices as $service) {
                $data[] = [$service->name, 0];
            }
        } else {
            foreach ($services as $service) {
                $data[] = [$service->service_type ?: 'Other', floatval($service->revenue)];
            }
        }

        return $data;
    }

    private function getRecentAppointments()
    {
        $appointments = Appointment::with('patient')
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        $formattedAppointments = [];

        foreach ($appointments as $appointment) {
            $formattedAppointments[] = [
                'id' => $appointment->id,
                'patient_name' => $appointment->patient->name ?? 'Unknown',
                'patient_email' => $appointment->patient->email ?? '',
                'appointment_date' => Carbon::parse($appointment->appointment_date)->format('M d, Y'),
                'appointment_time' => $appointment->appointment_time,
                'status' => ucfirst($appointment->status),
                'amount' => $appointment->totalAmount ?? 0,
                'view_url' => route('admin.appointments.edit', $appointment->id),
                'confirm_url' => route('admin.appointments.confirm', $appointment->id),
                'cancel_url' => route('admin.appointments.cancel', $appointment->id)
            ];
        }

        return $formattedAppointments;
    }
}
