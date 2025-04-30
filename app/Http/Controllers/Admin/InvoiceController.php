use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    // ...existing code...

    public function download($id)
    {
        $invoice = Invoice::with(['patient', 'invoiceTreatment.subCategoryOne', 'invoiceTreatment.subCategoryTwo'])->findOrFail($id);

        $pdf = PDF::loadView('admin.invoice.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->id . '.pdf');
    }

    // ...existing code...
}
