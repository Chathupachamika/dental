<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

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
}
