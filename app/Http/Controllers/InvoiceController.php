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
use Barryvdh\DomPDF\Facade\Pdf;

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
            DB::beginTransaction();

            // Create invoice record
            $invoice = Invoice::create([
                'patient_id' => $request->patient_id,
                'totalAmount' => $request->totalAmount,
                'advanceAmount' => $request->advanceAmount,
                'visitDate' => $request->visitDate,
                'otherNote' => $request->otherNote
            ]);

            // Create invoice treatments
            foreach ($request->treatments as $treatment) {
                // Get or create the treatment record
                $treatmentModel = Treatment::firstOrCreate(
                    ['name' => $treatment['treatment']],
                    [
                        'description' => 'Added from invoice creation',
                        'showDropDown' => false
                    ]
                );

                // Handle subtype (save to treatment_sub_categories_ones)
                $subtype_id = null;
                if (!empty($treatment['subtype'])) {
                    $subtype = TreatmentSubCategoriesOne::firstOrCreate(
                        [
                            'name' => $treatment['subtype'],
                            'treatment_id' => $treatmentModel->id
                        ],
                        [
                            'description' => 'Added from invoice creation',
                            'showDropDown' => false
                        ]
                    );
                    $subtype_id = $subtype->id;
                }

                // Handle position (save to treatment_sub_categories_twos)
                $position_id = null;
                if (!empty($treatment['position'])) {
                    $position = TreatmentSubCategoriesTwo::firstOrCreate(
                        ['name' => $treatment['position']],
                        ['description' => 'Added from invoice creation']
                    );
                    $position_id = $position->id;
                }

                // Create the invoice treatment with the related IDs
                InvoiceTreatment::create([
                    'invoice_id' => $invoice->id,
                    'treatMent' => $treatment['treatment'],
                    'subtype_id' => $subtype_id,
                    'position_id' => $position_id
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $invoice->load('patient', 'invoiceTreatment')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function download($id)
    {
        $invoice = Invoice::with(['patient', 'invoiceTreatment.subCategoryOne', 'invoiceTreatment.subCategoryTwo'])
            ->findOrFail($id);

        $pdf = PDF::loadView('admin.invoice.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->id . '.pdf');
    }
}
