<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {

        $invoice = Invoice::whereNotNull('patient_id')->with('patient');

        if ($request->date) {
            $invoice = $invoice->whereDate('visitDate', $request->date)->get();
        } else {
            $invoice = $invoice->whereDate('visitDate', Carbon::today())->get();
        }

        $data['patients'] = $invoice->all();
        return view('admin.Appointments.index', $data);
    }
}
