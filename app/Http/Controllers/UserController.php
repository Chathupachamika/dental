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

        // Get patient record for this user
        $patient = Patient::where('mobileNumber', $user->mobile_number)->first();

        // Get upcoming appointments for this user
        $upcomingAppointments = Invoice::where('patient_id', $patient ? $patient->id : null)
            ->where('visitDate', '>=', Carbon::today())
            ->with(['patient', 'invoiceTreatment'])
            ->orderBy('visitDate', 'asc')
            ->get();

        // Get past appointments for this user
        $pastAppointments = Invoice::where('patient_id', $patient ? $patient->id : null)
            ->where('visitDate', '<', Carbon::today())
            ->with(['patient', 'invoiceTreatment'])
            ->orderBy('visitDate', 'desc')
            ->get();

        return view('user.user_dashboard', compact('user', 'upcomingAppointments', 'pastAppointments'));
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
            'appointment_date' => 'required|date|after_or_equal:today', // Validate the Preferred Date input
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

        // Save the appointment in the appointments table
        Appointment::create([
            'user_id' => $user->id,
            'appointment_date' => $request->appointment_date, // Set to Preferred Date input value
            'notes' => $request->notes,
            'status' => 'pending', // Default status
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

        // Get appointments for the logged-in user
        $appointments = Appointment::where('user_id', $user->id)
            ->with('patient') // Ensure the patient relationship is loaded
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

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

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'nic' => 'required|string|max:20',  // Add NIC validation
            'address' => 'nullable|string|max:255',
            'age' => 'nullable|numeric|min:1|max:120',
            'gender' => 'nullable|in:Male,Female,Other',
            'terms_agreed' => 'required|accepted',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->mobile_number = $request->mobile_number;
        $user->nic = $request->nic;  // Save NIC to user record
        $user->terms_agreed = true;
        $user->save();

        // Update or create patient record
        $patient = Patient::updateOrCreate(
            ['mobileNumber' => $user->mobile_number],
            [
                'name' => $request->name,
                'address' => $request->address,
                'age' => $request->age,
                'gender' => $request->gender,
                'user_id' => $user->id,
                'nic' => $request->nic  // Save NIC to patient record
            ]
        );

        return redirect()->route('user.profile')
            ->with('success', 'Profile updated successfully.');
    }

    public function checkProfileCompletion()
    {
        $user = Auth::user();
        $patient = $user->patient;

        // Check if all required fields are filled
        $isComplete = !empty($user->mobile_number) &&
                     !empty($patient->address) &&
                     !empty($patient->age) &&
                     !empty($patient->gender);

        return response()->json([
            'isComplete' => $isComplete
        ]);
    }

    public function clearLoginSession()
    {
        session()->forget('first_login');
        return response()->json(['status' => 'success']);
    }

    public function getTermsStatus()
    {
        $user = Auth::user();
        return response()->json([
            'terms_agreed' => $user->terms_agreed
        ]);
    }
}
