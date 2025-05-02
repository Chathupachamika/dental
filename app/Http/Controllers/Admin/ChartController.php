<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use PDF;

class ChartController extends Controller
{
    public function revenue()
    {
        $revenue = Invoice::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(totalAmount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($revenue);
    }

    public function treatments()
    {
        $treatments = \App\Models\InvoiceTreatment::selectRaw('treatMent, COUNT(*) as count')
            ->groupBy('treatMent')
            ->get();

        $chartData = [['Treatment', 'Count']];
        foreach ($treatments as $treatment) {
            $chartData[] = [$treatment->treatMent, $treatment->count];
        }

        return response()->json($chartData);
    }

    public function appointments()
    {
        $appointments = \App\Models\Appointment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $chartData = [['Status', 'Count']];
        foreach ($appointments as $appointment) {
            $chartData[] = [ucfirst($appointment->status), $appointment->count];
        }

        return response()->json($chartData);
    }

    public function export()
    {
        $appointments = Appointment::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $revenue = (object)[
            'total' => Invoice::sum('totalAmount'),
            'advance' => Invoice::sum('advanceAmount')
        ];

        $patients = Patient::count();
        $invoices = Invoice::with('patient')
            ->latest()
            ->take(10)
            ->get();

        $pdf = PDF::loadView('admin.charts.export-pdf', compact(
            'appointments',
            'revenue',
            'patients',
            'invoices'
        ));

        // Configure PDF options
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans'
        ]);

        return $pdf->download('dental-analytics-'.now()->format('Y-m-d').'.pdf');
    }
}
