<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('patient');

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('id', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('patient', function($q) use ($keyword) {
                      $q->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        if ($request->has('filter')) {
            switch($request->filter) {
                case 'paid':
                    $query->whereRaw('totalAmount = advanceAmount');
                    break;
                case 'pending':
                    $query->whereRaw('totalAmount > advanceAmount');
                    break;
            }
        }

        $invoices = $query->latest()->paginate(5);
        return view('admin.invoice.index', compact('invoices'));
    }

    public function download($id)
    {
        $invoice = Invoice::with([
            'patient',
            'invoiceTreatment.subCategoryOne',
            'invoiceTreatment.subCategoryTwo'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.invoice.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->id . '.pdf');
    }
}
