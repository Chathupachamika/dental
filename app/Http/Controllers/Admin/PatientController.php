<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientController extends Controller
{
    // Other methods...

    public function downloadPDF(Patient $patient)
    {
        $pdf = PDF::loadView('admin.Patient.pdf', ['patient' => $patient]);
        return $pdf->download('patient-' . $patient->id . '.pdf');
    }
}
