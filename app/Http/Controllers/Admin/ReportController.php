<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function exportDailyReport()
    {
        // Get today's data
        $data = [
            'date' => now()->format('Y-m-d'),
            // Add other data you want to include in the report
        ];

        // Generate PDF
        $pdf = PDF::loadView('admin.reports.daily_report', $data);

        // Return the PDF for download
        return $pdf->download('daily-report-' . now()->format('Y-m-d') . '.pdf');
    }
}
