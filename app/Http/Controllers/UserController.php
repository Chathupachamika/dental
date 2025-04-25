<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get upcoming appointments for this user
        $upcomingAppointments = Invoice::where('patient_id', function($query) use ($user) {
            $query->select('id')
                ->from('patients')
                ->where('mobileNumber', $user->mobile_number)
                ->first();
        })
        ->where('visitDate', '>=', Carbon::today())
        ->with(['patient', 'invoiceTreatment'])
        ->orderBy('visitDate', 'asc')
        ->take(5)
        ->get();

        // Get past appointments for this user
        $pastAppointments = Invoice::where('patient_id', function($query) use ($user) {
            $query->select('id')
                ->from('patients')
                ->where('mobileNumber', $user->mobile_number)
                ->first();
        })
        ->where('visitDate', '<', Carbon::today())
        ->with(['patient', 'invoiceTreatment'])
        ->orderBy('visitDate', 'desc')
        ->take(5)
        ->get();

        // Get available treatments for appointment booking
        $treatments = Treatment::all();

        return view('user.user_dashboard', compact('user', 'upcomingAppointments', 'pastAppointments', 'treatments'));
    }

    /**
     * Show the appointment booking form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bookAppointment()
    {
        $user = Auth::user();
        $treatments = Treatment::all();

        // Check if user already has a patient record
        $patient = Patient::where('mobileNumber', $user->mobile_number)->first();

        return view('user.book_appointment', compact('user', 'treatments', 'patient'));
    }

    /**
     * Store a new appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'treatment' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        // Check if user already has a patient record
        $patient = Patient::where('mobileNumber', $user->mobile_number)->first();

        // If not, create a new patient record
        if (!$patient) {
            $patient = Patient::create([
                'name' => $user->name,
                'mobileNumber' => $user->mobile_number,
                'email' => $user->email,
            ]);
        }

        // Create invoice (which serves as appointment)
        $invoice = Invoice::create([
            'patient_id' => $patient->id,
            'visitDate' => $request->appointment_date,
            'otherNote' => $request->notes,
            'totalAmount' => 0, // Will be set by admin later
            'advanceAmount' => 0, // Will be set by admin later
        ]);

        // Add treatment to invoice
        $invoice->invoiceTreatment()->create([
            'treatMent' => $request->treatment,
        ]);

        return redirect()->route('user.appointments')
            ->with('success', 'Appointment booked successfully! We will contact you to confirm the details.');
    }

    /**
     * Show user's appointments.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function appointments()
    {
        $user = Auth::user();

        // Get patient record for this user
        $patient = Patient::where('mobileNumber', $user->mobile_number)->first();

        if ($patient) {
            $appointments = Invoice::where('patient_id', $patient->id)
                ->with(['invoiceTreatment'])
                ->orderBy('visitDate', 'desc')
                ->paginate(10);
        } else {
            $appointments = collect();
        }

        return view('user.appointments', compact('user', 'appointments'));
    }

    /**
     * Show appointment details.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function appointmentDetails($id)
    {
        $user = Auth::user();

        // Get patient record for this user
        $patient = Patient::where('mobileNumber', $user->mobile_number)->first();

        if (!$patient) {
            return redirect()->route('user.appointments')
                ->with('error', 'Patient record not found.');
        }

        $appointment = Invoice::where('id', $id)
            ->where('patient_id', $patient->id)
            ->with(['invoiceTreatment', 'patient'])
            ->firstOrFail();

        return view('user.appointment_details', compact('user', 'appointment'));
    }

    /**
     * Cancel an appointment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelAppointment($id)
    {
        $user = Auth::user();

        // Get patient record for this user
        $patient = Patient::where('mobileNumber', $user->mobile_number)->first();

        if (!$patient) {
            return redirect()->route('user.appointments')
                ->with('error', 'Patient record not found.');
        }

        $appointment = Invoice::where('id', $id)
            ->where('patient_id', $patient->id)
            ->first();

        if (!$appointment) {
            return redirect()->route('user.appointments')
                ->with('error', 'Appointment not found.');
        }

        // Check if appointment is in the future
        if (Carbon::parse($appointment->visitDate)->isPast()) {
            return redirect()->route('user.appointments')
                ->with('error', 'Cannot cancel past appointments.');
        }

        // Add a note that this was cancelled by the user
        $appointment->otherNote = ($appointment->otherNote ? $appointment->otherNote . ' | ' : '') .
            'Cancelled by user on ' . Carbon::now()->format('Y-m-d H:i');
        $appointment->save();

        return redirect()->route('user.appointments')
            ->with('success', 'Appointment cancelled successfully.');
    }

    /**
     * Show user profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();

        // Get patient record for this user
        $patient = Patient::where('mobileNumber', $user->mobile_number)->first();

        return view('user.profile', compact('user', 'patient'));
    }

    /**
     * Update user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'age' => 'nullable|numeric|min:1|max:120',
            'gender' => 'nullable|in:Male,Female,Other',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->mobile_number = $request->mobile_number;
        $user->save();

        // Update or create patient record
        $patient = Patient::where('mobileNumber', $user->mobile_number)->first();

        if ($patient) {
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->age = $request->age;
            $patient->gender = $request->gender;
            $patient->save();
        } else {
            Patient::create([
                'name' => $request->name,
                'mobileNumber' => $request->mobile_number,
                'address' => $request->address,
                'age' => $request->age,
                'gender' => $request->gender,
            ]);
        }

        return redirect()->route('user.profile')
            ->with('success', 'Profile updated successfully.');
    }
}
