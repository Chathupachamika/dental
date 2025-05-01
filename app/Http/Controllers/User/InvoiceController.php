<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['patient', 'invoiceTreatment'])
            ->whereHas('patient', function($query) {
                $query->where('name', auth()->user()->name);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.invoices.index', compact('invoices'));
    }

    public function getMyInvoices()
    {
        $invoices = Invoice::with(['patient', 'invoiceTreatment'])
            ->whereHas('patient', function($query) {
                $query->where('name', auth()->user()->name);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $invoices
        ]);
    }

    public function view($id)
    {
        $invoice = Invoice::with(['patient', 'invoiceTreatment'])
            ->whereHas('patient', function($query) {
                $query->where('name', auth()->user()->name);
            })
            ->findOrFail($id);

        return view('user.invoices.view', compact('invoice'));
    }
}
