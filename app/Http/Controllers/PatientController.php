<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\Invoice;
use App\Models\InvoiceTreatment;
use App\Models\Treatment;
use App\Models\TreatmentSubCategoriesOne;
use App\Models\TreatmentSubCategoriesTwo;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {

        $place_query = patient::whereNotNull('name');

        if ($request->keyword) {
            $place_query->where('name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('mobileNumber', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->sortByName && in_array($request->sortByName, ['asc', 'desc'])) {
            $place_query->orderBy('name', $request->sortByName);
        }

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.patient.index', $data);
    }
    public function list(Request $request)
    {

        $place_query = patient::whereNotNull('name');

        if ($request->keyword) {
            $place_query->where('name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('mobileNumber', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->sortByName && in_array($request->sortByName, ['asc', 'desc'])) {
            $place_query->orderBy('name', $request->sortByName);
        }

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.patient.list', $data);
    }

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
        $data = patient::find($id);
        return response()->json([
            'data' => $data,
            'code' => 200,
        ]);
    }
    public function patientList()
    {
        $data = patient::select('name', 'id')->get()->toArray();
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
        $place = patient::with('invoice')
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
        $createdPatient = patient::create([
            'name' => $request->name,
            'mobileNumber' => $request->mobileNumber,
            'address'  => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'nic' => $request->nic
        ]);

        $place_query = patient::whereNotNull('name');

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.patient.list', $data);
    }
    public function destroy(patient $patient)
    {
        Invoice::where('patient_id', $patient->id)->delete();
        $patient->delete();

        $place_query = patient::whereNotNull('name');

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.patient.list', $data);
    }
    public function edit($id)
    {
        $patient = patient::find($id);
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
        $patient = patient::find($request->id);

        $patient->update([
            'name' => $request->name,
            'mobileNumber' => $request->mobileNumber,
            'address'  => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'nic' => $request->nic
        ]);

        $place_query = patient::whereNotNull('name');

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.patient.list', $data);
    }
}
