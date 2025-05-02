<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Other methods...

    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('mobileNumber', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'recent':
                    $query->whereNotNull('lastVisit')
                          ->orderBy('lastVisit', 'desc');
                    break;
                case 'pending':
                    $query->where('balance', '>', 0);
                    break;
            }
        }

        $patients = Patient::paginate(5);

        return view('admin.Patient.list', compact('patients'));
    }

    public function downloadPDF(Patient $patient)
    {
        $pdf = PDF::loadView('admin.Patient.pdf', ['patient' => $patient]);
        return $pdf->download('patient-' . $patient->id . '.pdf');
    }
}
