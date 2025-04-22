<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ChartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $invoice = Invoice::whereNotNull('patient_id')->with('patient');

        if ($request->date) {
            $invoice = $invoice->whereDate('created_at', $request->date)->get();
        } else {
            $invoice = $invoice->whereDate('created_at', Carbon::today())->get();
        }

        $data['invoice'] = $invoice->all();
        return view('chart.index', $data);
    }
}
