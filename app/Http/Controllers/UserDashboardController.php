<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $upcomingAppointments = Invoice::where('patient_id', $user->id)
            ->where('visitDate', '>=', Carbon::today())
            ->orderBy('visitDate', 'asc')
            ->with('invoiceTreatment')
            ->get();

        $pastAppointments = Invoice::where('patient_id', $user->id)
            ->where('visitDate', '<', Carbon::today())
            ->orderBy('visitDate', 'desc')
            ->with('invoiceTreatment')
            ->get();

        return view('user.user_dashboard', compact('upcomingAppointments', 'pastAppointments'));
    }
}
