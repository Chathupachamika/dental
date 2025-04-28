<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all appointments with related user data
        $query = Appointment::with('user') // Ensure 'user' relationship is loaded
            ->orderBy('appointment_date', 'desc'); // Order by appointment_date

        // Apply optional filters if provided
        if ($request->has('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(10); // Paginate the results

        return view('admin.Appointments.index', compact('appointments'));
    }

    public function edit($id)
    {
        $appointment = Appointment::with('user')->findOrFail($id);
        return view('admin.Appointments.edit', compact('appointment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string'
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully');
    }

    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status !== 'pending') { // Ensure the status check is correct
            return redirect()->route('admin.appointments.index')
                ->with('error', 'This appointment is not pending confirmation');
        }

        $appointment->update([
            'status' => 'confirmed',
            'notes' => trim(($appointment->notes ?? '') . "\nConfirmed by admin on " . now()->toDateTimeString())
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment confirmed successfully');
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->isCancelled()) {
            return redirect()->route('admin.appointments.index')
                ->with('error', 'This appointment is already cancelled');
        }

        $appointment->update([
            'status' => 'cancelled',
            'otherNote' => trim($appointment->otherNote . "\nCancelled by admin on " . now())
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment cancelled successfully');
    }

    public function notify($id)
    {
        $appointment = Appointment::with('patient')->findOrFail($id);

        // Add notification logic here (e.g., email, SMS)
        Log::info('Notification sent for appointment', [
            'appointment_id' => $id,
            'patient_id' => $appointment->patient_id
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Notification sent successfully');
    }
}
