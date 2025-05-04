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
            $invoices->where(function($query) use ($request) {
                $query->where('id', $request->keyword)
                      ->orWhereHas('patient', function($q) use ($request) {
                          $q->where('name', 'like', '%' . $request->keyword . '%');
                      });
            });
        }

        if ($request->filter && $request->filter !== 'all') {
            if ($request->filter === 'paid') {
                $invoices->whereRaw('totalAmount = advanceAmount');
            } elseif ($request->filter === 'pending') {
                $invoices->whereRaw('totalAmount > advanceAmount');
            }
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
            $invoice = Invoice::with(['patient', 'invoiceTreatment.subCategoryOne', 'invoiceTreatment.subCategoryTwo'])
                            ->findOrFail($id);

            // Check if it's an AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json($invoice);
            }

            return view('admin.invoice.show', ['invoice' => $invoice]);
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Invoice not found'], 404);
            }

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

    public function update(Request $request, $id)
    {
        try {
            $invoice = Invoice::findOrFail($id);

            DB::beginTransaction();

            $invoice->update([
                'totalAmount' => $request->totalAmount,
                'advanceAmount' => $request->advanceAmount,
                'visitDate' => $request->visitDate,
                'otherNote' => $request->otherNote
            ]);

            if ($request->has('treatments')) {
                // Delete existing treatments
                $invoice->invoiceTreatment()->delete();

                // Create new treatments
                foreach ($request->treatments as $treatment) {
                    InvoiceTreatment::create([
                        'invoice_id' => $invoice->id,
                        'treatMent' => $treatment['treatment'],
                        'subtype_id' => $treatment['subtype_id'] ?? null,
                        'position_id' => $treatment['position_id'] ?? null
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Invoice updated successfully',
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

    public function downloadPDF($id)
    {
        try {
            $invoice = Invoice::with(['patient', 'invoiceTreatment.subCategoryOne', 'invoiceTreatment.subCategoryTwo'])
                ->findOrFail($id);

            $pdf = PDF::loadView('admin.invoice.pdf', compact('invoice'));
            return $pdf->download('invoice-' . $invoice->id . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Unable to download invoice: ' . $e->getMessage());
        }
    }

    public function getRecentInvoices()
    {
        try {
            $invoices = Invoice::with(['patient', 'invoiceTreatment'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function($invoice) {
                    return [
                        'id' => $invoice->id,
                        'patient' => $invoice->patient,
                        'totalAmount' => $invoice->totalAmount,
                        'advanceAmount' => $invoice->advanceAmount,
                        'created_at' => $invoice->created_at,
                        'status' => $invoice->totalAmount <= $invoice->advanceAmount ? 'paid' : 'pending'
                    ];
                });

            return response()->json($invoices);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMonthlyRevenue()
    {
        try {
            $currentMonth = Invoice::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('totalAmount');

            $lastMonth = Invoice::whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->sum('totalAmount');

            $percentageChange = $lastMonth > 0
                ? (($currentMonth - $lastMonth) / $lastMonth) * 100
                : ($currentMonth > 0 ? 100 : 0);

            return response()->json([
                'amount' => $currentMonth,
                'percentageChange' => round($percentageChange, 1)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPendingPayments()
    {
        try {
            $totalPending = Invoice::whereRaw('totalAmount > advanceAmount')
                ->sum(DB::raw('totalAmount - advanceAmount'));

            $todayPending = Invoice::whereRaw('totalAmount > advanceAmount')
                ->whereDate('created_at', today())
                ->sum(DB::raw('totalAmount - advanceAmount'));

            $yesterdayPending = Invoice::whereRaw('totalAmount > advanceAmount')
                ->whereDate('created_at', yesterday())
                ->sum(DB::raw('totalAmount - advanceAmount'));

            $percentageChange = $yesterdayPending > 0
                ? (($todayPending - $yesterdayPending) / $yesterdayPending) * 100
                : ($todayPending > 0 ? 100 : 0);

            return response()->json([
                'amount' => $totalPending,
                'today' => $todayPending,
                'percentageChange' => round($percentageChange, 1)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
