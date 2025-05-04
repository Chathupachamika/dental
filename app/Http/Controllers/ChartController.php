<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InvoiceTreatment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        // Get summary statistics
        $totalAppointments = Appointment::count();
        $totalPatients = Patient::count();
        $totalInvoices = Invoice::count();

        $totalAmount = Invoice::sum('totalAmount');
        $advanceAmount = Invoice::sum('advanceAmount');
        $pendingAmount = $totalAmount - $advanceAmount;

        // Get recent invoices for the dashboard
        $recentInvoices = Invoice::with('patient')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.Charts.index', compact(
            'totalAppointments',
            'totalPatients',
            'totalInvoices',
            'totalAmount',
            'advanceAmount',
            'pendingAmount',
            'recentInvoices'
        ));
    }

    public function getData(Request $request)
    {
        $period = $request->period ?? 'monthly';

        switch ($period) {
            case 'daily':
                return $this->getDailyData();
            case 'annually':
                return $this->getAnnualData();
            case 'monthly':
            default:
                return $this->getMonthlyData();
        }
    }

    private function getDailyData()
    {
        // Get data for the last 14 days
        $startDate = Carbon::now()->subDays(13)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $invoices = Invoice::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(totalAmount) as total, SUM(advanceAmount) as advance')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data for Google Charts
        $chartData = [];
        $chartData[] = ['Date', 'Total Amount', 'Advance Amount', 'Appointments'];

        for ($date = clone $startDate; $date <= $endDate; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');

            $invoice = $invoices->firstWhere('date', $dateStr);
            $appointment = $appointments->firstWhere('date', $dateStr);

            $chartData[] = [
                $date->format('M d'),
                $invoice ? (float)$invoice->total : 0,
                $invoice ? (float)$invoice->advance : 0,
                $appointment ? (int)$appointment->count : 0
            ];
        }

        return response()->json($chartData);
    }

    private function getMonthlyData()
    {
        // Get data for the last 12 months
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $invoices = Invoice::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(totalAmount) as total, SUM(advanceAmount) as advance')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->selectRaw('YEAR(appointment_date) as year, MONTH(appointment_date) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Format data for Google Charts
        $chartData = [];
        $chartData[] = ['Month', 'Total Amount', 'Advance Amount', 'Appointments'];

        for ($date = clone $startDate; $date <= $endDate; $date->addMonth()) {
            $year = $date->year;
            $month = $date->month;

            $invoice = $invoices->first(function ($item) use ($year, $month) {
                return $item->year == $year && $item->month == $month;
            });

            $appointment = $appointments->first(function ($item) use ($year, $month) {
                return $item->year == $year && $item->month == $month;
            });

            $chartData[] = [
                $date->format('M Y'),
                $invoice ? (float)$invoice->total : 0,
                $invoice ? (float)$invoice->advance : 0,
                $appointment ? (int)$appointment->count : 0
            ];
        }

        return response()->json($chartData);
    }

    private function getAnnualData()
    {
        // Get data for the last 5 years
        $startYear = Carbon::now()->subYears(4)->year;
        $endYear = Carbon::now()->year;

        $invoices = Invoice::whereYear('created_at', '>=', $startYear)
            ->whereYear('created_at', '<=', $endYear)
            ->selectRaw('YEAR(created_at) as year, SUM(totalAmount) as total, SUM(advanceAmount) as advance')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $appointments = Appointment::whereYear('appointment_date', '>=', $startYear)
            ->whereYear('appointment_date', '<=', $endYear)
            ->selectRaw('YEAR(appointment_date) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // Format data for Google Charts
        $chartData = [];
        $chartData[] = ['Year', 'Total Amount', 'Advance Amount', 'Appointments'];

        for ($year = $startYear; $year <= $endYear; $year++) {
            $invoice = $invoices->firstWhere('year', $year);
            $appointment = $appointments->firstWhere('year', $year);

            $chartData[] = [
                (string)$year,
                $invoice ? (float)$invoice->total : 0,
                $invoice ? (float)$invoice->advance : 0,
                $appointment ? (int)$appointment->count : 0
            ];
        }

        return response()->json($chartData);
    }

    public function revenue(Request $request)
    {
        // Get monthly revenue data for the current year
        $currentYear = Carbon::now()->year;

        $monthlyRevenue = Invoice::whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, SUM(totalAmount) as total, SUM(advanceAmount) as advance')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data for Google Charts
        $chartData = [];
        $chartData[] = ['Month', 'Total Revenue', 'Advance Payments'];

        for ($month = 1; $month <= 12; $month++) {
            $revenue = $monthlyRevenue->firstWhere('month', $month);
            $monthName = Carbon::create($currentYear, $month, 1)->format('M');

            $chartData[] = [
                $monthName,
                $revenue ? (float)$revenue->total : 0,
                $revenue ? (float)$revenue->advance : 0
            ];
        }

        return response()->json($chartData);
    }

    public function treatments(Request $request)
    {
        // Get treatment distribution
        $treatments = InvoiceTreatment::select('treatMent')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('treatMent')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        // Format data for Google Charts
        $chartData = [];
        $chartData[] = ['Treatment', 'Count'];

        foreach ($treatments as $treatment) {
            $chartData[] = [$treatment->treatMent, (int)$treatment->count];
        }

        return response()->json($chartData);
    }

    public function appointments(Request $request)
    {
        // Get appointment status distribution
        $statuses = Appointment::select('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Get appointment data by date for calendar
        $startDate = Carbon::now()->subMonths(3)->startOfDay();
        $endDate = Carbon::now()->addMonths(3)->endOfDay();

        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        // Format status data for Google Charts
        $statusData = [];
        $statusData[] = ['Status', 'Count'];

        foreach ($statuses as $status) {
            $statusData[] = [ucfirst($status->status), (int)$status->count];
        }

        // Format calendar data for Google Charts
        $calendarData = [];
        $calendarData[] = ['Date', 'Appointments'];

        foreach ($appointments as $appointment) {
            // Convert the date string to a JavaScript Date object format
            $jsDate = Carbon::parse($appointment->date)->format('Y, n-1, j');
            // Add data using JavaScript array format that Google Charts expects
            $calendarData[] = ["new Date($jsDate)", (int)$appointment->count];
        }

        return response()->json([
            'statusData' => $statusData,
            'calendarData' => $calendarData
        ]);
    }

    public function calendar()
    {
        return view('admin.calendar.index');
    }

    public function export(Request $request)
    {
        // Get all necessary data for the PDF
        $period = $request->period ?? 'monthly';
        $mainChartData = $this->getData($request)->getData();
        $treatmentData = $this->treatments($request)->getData();
        $appointmentData = $this->appointments($request)->getData();
        $revenueData = $this->revenue($request)->getData();

        // Get summary data
        $totalAppointments = Appointment::count();
        $totalPatients = Patient::count();
        $totalInvoices = Invoice::count();
        $totalAmount = Invoice::sum('totalAmount');
        $advanceAmount = Invoice::sum('advanceAmount');
        $pendingAmount = $totalAmount - $advanceAmount;

        // Get recent invoices
        $recentInvoices = Invoice::with('patient')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $data = [
            'mainChartData' => $mainChartData,
            'treatmentData' => $treatmentData,
            'appointmentData' => $appointmentData,
            'revenueData' => $revenueData,
            'totalAppointments' => $totalAppointments,
            'totalPatients' => $totalPatients,
            'totalInvoices' => $totalInvoices,
            'totalAmount' => $totalAmount,
            'advanceAmount' => $advanceAmount,
            'pendingAmount' => $pendingAmount,
            'recentInvoices' => $recentInvoices,
            'period' => $period,
            'exportDate' => now()->format('Y-m-d H:i:s')
        ];

        $pdf = PDF::loadView('admin.Charts.export', $data);
        return $pdf->download('analytics-report-' . now()->format('Y-m-d') . '.pdf');
    }
}
