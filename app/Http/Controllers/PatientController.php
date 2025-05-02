<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\TreatmentSubCategoriesTwo;
use App\Models\Treatment;
use App\Models\TreatmentSubCategoriesOne;
use App\Models\InvoiceTreatment;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientController extends Controller
{
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

        if ($request->has('sortByName')) {
            $query->orderBy('name', $request->sortByName);
        }

        $patients = $query->paginate(5);

        return view('admin.patient.index', compact('patients'));
    }

    public function list(Request $request)
    {
        $place_query = Patient::whereNotNull('name');

        if ($request->keyword) {
            $place_query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->keyword . '%')
                  ->orWhere('mobileNumber', 'LIKE', '%' . $request->keyword . '%');
            });
        }

        if ($request->filter) {
            switch ($request->filter) {
                case 'recent':
                    $place_query->orderBy('created_at', 'desc');
                    break;
                case 'pending':
                    $place_query->where('balance', '>', 0);
                    break;
            }
        }

        if ($request->sortByName && in_array($request->sortByName, ['asc', 'desc'])) {
            $place_query->orderBy('name', $request->sortByName);
        }

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.Patient.list', $data);
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the subcategory code for a treatment based on its properties.
     *
     * This function retrieves a Treatment model by its ID and evaluates its
     * properties to determine the appropriate subcategory code. The function
     * returns a string code based on the following conditions:
     * - Returns "10001" if the treatment is marked as an end treatment and does not have a dropdown.
     * - Returns "10002" if the treatment is marked as an end treatment and has a dropdown.
     * - Returns "10003" if the treatment is not marked as an end treatment and does not have a dropdown.
     *
     * @param int $id The ID of the treatment to evaluate.
     * @return string|bool The subcategory code or false if the treatment is not found.
     */

/*******  8ba95894-e6b1-453d-b94d-2e961583ffa0  *******/
    public function getSubCategory($id)
    {
        $treat = Treatment::find($id);
        if ($treat) {
            if ($treat->isEnd && !$treat->hasDrop) {
                return "10001";
            } else if ($treat->isEnd && $treat->hasDrop) {
                return "10002";
            } else if (!$treat->isEnd && !$treat->hasDrop) {
                return "10003";
            }
        } else {
            return false;
        }
    }
    public function getTreatmentSubCategoriesTwo()
    {
        return TreatmentSubCategoriesTwo::get();
    }
    public function getTreatments()
    {
        $data = Treatment::select('name', 'id')->get()->toArray();
        return response()->json([
            'data' => $data,
            'code' => 200,
        ]);
    }
    public function getTreatDataById($id)
    {
        $treat = Treatment::find($id);

        if ($treat) {
            if ($treat->showDropDown) {
                return response()->json([
                    'status' => true,
                    'data' => null,
                    'code' => 200,
                ]);
            } else {
                $data = TreatmentSubCategoriesOne::where("treatment_id", $id)->select('name', 'id')->get()->toArray();
                if ($data) {
                    return response()->json([
                        'status' => true,
                        'data' => $data,
                        'code' => 200,
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'data' => null,
                        'code' => 200,
                    ]);
                }
            }
        }
    }
    public function getSubTreatDataById($id)
    {
        $treat = TreatmentSubCategoriesOne::find($id);

        if ($treat) {
            if ($treat->showDropDown) {
                return response()->json([
                    'status' => true,
                    'data' => null,
                    'code' => 200,
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'data' => null,
                'code' => 200,
            ]);
        }
    }
    public function getPatientByID($id)
    {
        $data = Patient::find($id);
        return response()->json([
            'data' => $data,
            'code' => 200,
        ]);
    }
    public function patientList()
    {
        $data = Patient::select('name', 'id')->get()->toArray();
        return response()->json([
            'data' => $data,
            'code' => 200,
        ]);
    }
    public function createInvoice(Request $request)
    {
        // dd($request->nextDate);
        $invoice = Invoice::create([
            'patient_id' => $request->patient_id,
            'otherNote' => $request->otherNote,
            'visitDate' => $request->nextDate,
            'totalAmount' => $request->total,
            'advanceAmount' => $request->advance,
        ]);
        $data = [];

        foreach ($request->treatments as $treat) {
            $invoiceTreat = new InvoiceTreatment();
            $invoiceTreat->treatMent = $treat;
            array_push($data, $invoiceTreat);
        }

        $invoice->invoiceTreatment()->saveMany($data);

        $savedInvoice = Invoice::with('patient')->with("invoiceTreatment")->find($invoice->id);
        return response()->json([
            'data' => $savedInvoice,
            'code' => 200,
        ]);
    }
    public function show($id)
    {
        $place = Patient::with('invoice')
            ->with('invoice.invoiceTreatment')
            ->find($id);
        $data['patient'] = $place;
        return view('admin.patient.show', $data);
    }

    public function store()
    {
        return view('admin.patient.create');
    }
    public function createPatient(Request $request)
    {
        $request->validate(
            [
                'name'     => 'required',
                'mobileNumber'  => 'required',
            ]
        );
        $createdPatient = Patient::create([
            'name' => $request->name,
            'mobileNumber' => $request->mobileNumber,
            'address'  => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'nic' => $request->nic
        ]);

        $place_query = Patient::whereNotNull('name');

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.patient.list', $data);
    }
    public function destroy(Patient $patient)
    {
        Invoice::where('patient_id', $patient->id)->delete();
        $patient->delete();

        $place_query = Patient::whereNotNull('name');

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.patient.list', $data);
    }
    public function edit($id)
    {
        $patient = Patient::find($id);
        $data['patient'] = $patient;
        return view('admin.patient.edit', $data);
    }
    public function update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'mobileNumber'  => 'required',
            ]
        );
        $patient = Patient::find($request->id);

        $patient->update([
            'name' => $request->name,
            'mobileNumber' => $request->mobileNumber,
            'address'  => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'nic' => $request->nic
        ]);

        $place_query = Patient::whereNotNull('name');

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.patient.list', $data);
    }

    public function export()
    {
        $patients = Patient::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="patients.csv"',
        ];

        $callback = function() use ($patients) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['ID', 'Name', 'Mobile Number', 'Address', 'Age', 'Gender', 'NIC']);

            // Add patient data
            foreach ($patients as $patient) {
                fputcsv($file, [
                    $patient->id,
                    $patient->name,
                    $patient->mobileNumber,
                    $patient->address,
                    $patient->age,
                    $patient->gender,
                    $patient->nic
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function getPatientAges()
    {
        $patients = Patient::whereNotNull('age')->get(['name', 'age']);
        $data = $patients->map(function($patient) {
            return [$patient->name, (int)$patient->age];
        });

        return response()->json($data);
    }

    public function getTreatmentStats()
    {
        try {
            $treatments = InvoiceTreatment::select('treatMent')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('treatMent')
                ->get()
                ->map(function($item) {
                    return [
                        'treatment' => $item->treatMent,
                        'count' => $item->count
                    ];
                });

            return response()->json($treatments);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTotalPatients()
    {
        $count = Patient::count();
        $lastMonth = Patient::whereMonth('created_at', '=', now()->subMonth()->month)->count();
        $thisMonth = Patient::whereMonth('created_at', '=', now()->month)->count();
        $percentageChange = $lastMonth > 0 ? (($thisMonth - $lastMonth) / $lastMonth) * 100 : 0;

        return response()->json([
            'total' => $count,
            'percentageChange' => round($percentageChange, 1)
        ]);
    }

    public function downloadPDF(Patient $patient)
    {
        $patient->load(['invoice.invoiceTreatment']);
        $pdf = PDF::loadView('admin.Patient.pdf', ['patient' => $patient]);
        return $pdf->download('patient-'.$patient->id.'.pdf');
    }

    /**
     * Get patient contact information
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactInfo($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json([
                'status' => false,
                'message' => 'Patient not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'name' => $patient->name,
                'mobileNumber' => $patient->mobileNumber,
                'id' => $patient->id
            ]
        ]);
    }
}
