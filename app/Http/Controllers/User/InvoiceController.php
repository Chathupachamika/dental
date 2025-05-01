<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', auth()->id())
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('user.invoices.index', compact('invoices'));
    }
}
