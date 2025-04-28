<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\Invoice;
use App\Models\InvoiceTreatment;
use App\Models\Treatment;
use App\Models\TreatmentSubCategoriesOne;
use App\Models\TreatmentSubCategoriesTwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::whereNotNull('patient_id')
            ->with('patient')
            ->with('invoiceTreatment');

        if ($request->keyword) {
            $invoices->where('id', $request->keyword);
        }

        $invoices = $invoices->orderBy('id', 'DESC')->paginate(5);

        return view('admin.invoice.index', compact('invoices'));
    }
    public function create($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            return view('admin.invoice.create', [
                'patient' => $patient,
                'id' => $id  // Explicitly pass the ID
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.invoice.index')
                ->with('error', 'Patient not found.');
        }
    }
    public function view(int $id)
    {
        try {
            $invoice = Invoice::with('patient')
                            ->with('invoiceTreatment')
                            ->findOrFail($id);

            return view('admin.invoice.show', ['invoice' => $invoice]);
        } catch (\Exception $e) {
            return redirect()->route('admin.invoice.index')
                ->with('error', 'Invoice not found.');
        }
    }

    public function store(Request $request)
    {
        try {
            // Start transaction
            \DB::beginTransaction();

            // Create invoice
            $invoice = new Invoice();
            $invoice->patient_id = $request->patient_id;
            $invoice->totalAmount = $request->totalAmount;
            $invoice->advanceAmount = $request->advanceAmount;
            $invoice->visitDate = $request->visitDate;
            $invoice->otherNote = $request->otherNote;
            $invoice->save();

            // Create invoice treatments
            if ($request->treatments) {
                foreach ($request->treatments as $key => $treatment) {
                    if ($treatment) {
                        $invoiceTreatment = new InvoiceTreatment();
                        $invoiceTreatment->invoice_id = $invoice->id;
                        $invoiceTreatment->treatMent = $treatment;
                        $invoiceTreatment->subType = $request->sub_types[$key] ?? null;
                        $invoiceTreatment->position = $request->positions[$key] ?? null;
                        $invoiceTreatment->save();
                    }
                }
            }

            \DB::commit();

            return redirect()->route('admin.invoice.view', $invoice->id)
                ->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }
}
