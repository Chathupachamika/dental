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
        $query = Appointment::with(['patient', 'invoiceTreatment'])
            ->orderBy('visitDate', 'desc');

        // Filter by date
        if ($request->has('date')) {
            $query->whereDate('visitDate', $request->date);
        }

        // Filter by type (user-booked or admin-created)
        if ($request->has('type')) {
            if ($request->type === 'user') {
                $query->where('otherNote', 'like', '%Booked by user%');
            } elseif ($request->type === 'admin') {
                $query->where(function($q) {
                    $q->where('otherNote', 'not like', '%Booked by user%')
                      ->orWhereNull('otherNote');
                });
            }
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('otherNote', 'like', '%Booked by user%')
                      ->where('totalAmount', 0);
            } elseif ($request->status === 'confirmed') {
                $query->where(function($q) {
                    $q->where('otherNote', 'not like', '%Cancelled%')
                      ->where(function($sq) {
                          $sq->where('otherNote', 'not like', '%Booked by user%')
                             ->orWhere('totalAmount', '>', 0);
                      });
                });
            }
        }

        $patients = $query->paginate(10);
        return view('admin.Appointments.index', compact('patients'));
    }

    public function edit($id)
    {
        $appointment = Appointment::with(['patient', 'invoiceTreatment'])->findOrFail($id);
        return view('admin.Appointments.edit', compact('appointment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'visitDate' => 'required|date',
            'totalAmount' => 'required|numeric|min:0',
            'advanceAmount' => 'required|numeric|min:0|lte:totalAmount',
            'otherNote' => 'nullable|string'
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'visitDate' => $request->visitDate,
            'totalAmount' => $request->totalAmount,
            'advanceAmount' => $request->advanceAmount,
            'otherNote' => $request->otherNote
        ]);

        if ($appointment->isUserBooked()) {
            // Log the update for user-booked appointments
            Log::info('User-booked appointment updated', [
                'appointment_id' => $id,
                'admin_id' => Auth::id()
            ]);
        }

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully');
    }

    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (!$appointment->isPending()) {
            return redirect()->route('admin.appointments.index')
                ->with('error', 'This appointment is not pending confirmation');
        }

        $appointment->update([
            'status' => 'confirmed',
            'otherNote' => trim($appointment->otherNote . "\nConfirmed by admin on " . now())
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
