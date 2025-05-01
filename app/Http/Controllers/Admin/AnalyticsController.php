<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class AnalyticsController extends Controller
{
    public function exportPdf(Request $request)
    {
        // Get all the required data
        $stats = [
            'appointments' => $this->getAppointmentStats(),
            'invoices' => $this->getRecentInvoices(),
            'patients' => $this->getPatientStats(),
            'revenue' => $this->getRevenueStats()
        ];

        // Generate PDF
        $pdf = PDF::loadView('admin.charts.export-pdf', $stats);

        // Return the PDF for download
        return $pdf->download('dental-analytics-' . now()->format('Y-m-d') . '.pdf');
    }

    private function getAppointmentStats()
    {
        // Get appointment statistics from your existing logic
        return \App\Models\Appointment::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
    }

    private function getRecentInvoices()
    {
        // Get recent invoices from your existing logic
        return \App\Models\Invoice::with('patient')
            ->latest()
            ->take(10)
            ->get();
    }

    private function getPatientStats()
    {
        // Get patient statistics
        return \App\Models\Patient::count();
    }

    private function getRevenueStats()
    {
        // Get revenue statistics
        return \App\Models\Invoice::selectRaw('SUM(totalAmount) as total, SUM(advanceAmount) as advance')
            ->first();
    }
}
