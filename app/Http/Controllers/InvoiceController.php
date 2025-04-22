<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\Invoice;
use App\Models\InvoiceTreatment;
use App\Models\Treatment;
use App\Models\TreatmentSubCategoriesOne;
use App\Models\TreatmentSubCategoriesTwo;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $place_query = Invoice::whereNotNull('patient_id')->with('patient');

        if ($request->keyword) {
            $place_query->where('id', $request->keyword);
        }
        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);

        return view('invoice.index', $data);
    }
    public function create($id)
    {
        $data['id'] = $id;
        return view('invoice.create', $data);
    }
    public function view($id)
    {
        $invoice = invoice::with('patient')->with('invoiceTreatment')->find($id);

        $data['invoice'] = $invoice;
        return view('invoice.show', $data);
    }
}
