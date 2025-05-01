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
        $query = Appointment::with('user');

        // If requesting all statuses for chart
        if ($request->status === 'all' && $request->format === 'json') {
            $counts = [
                'confirmed' => Appointment::where('status', 'confirmed')->count(),
                'pending' => Appointment::where('status', 'pending')->count(),
                'cancelled' => Appointment::where('status', 'cancelled')->count()
            ];

            return response()->json($counts);
        }

        // Retrieve all appointments with related user data
        $query = Appointment::with('user') // Ensure 'user' relationship is loaded
            ->orderBy('appointment_date', 'desc'); // Order by appointment_date

        // Apply optional filters if provided
        if ($request->has('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Modified status filter to handle pending specifically
        if ($request->has('status')) {
            $query->where('status', $request->status);

            // If requesting pending count via AJAX
            if ($request->status === 'pending' && $request->has('count')) {
                return response()->json([
                    'count' => $query->count()
                ]);
            }

            // If requesting pending appointments for notification panel
            if ($request->status === 'pending' && $request->format === 'json') {
                $appointments = $query->get();
                return response()->json([
                    'success' => true,
                    'appointments' => $appointments
                ]);
            }
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

    public function getStats()
    {
        try {
            $stats = [
                'total' => Appointment::count(),
                'confirmed' => Appointment::where('status', 'confirmed')->count(),
                'pending' => Appointment::where('status', 'pending')->count(),
                'cancelled' => Appointment::where('status', 'cancelled')->count(),
                'today' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
                'thisWeek' => Appointment::whereBetween('appointment_date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'thisMonth' => Appointment::whereBetween('appointment_date', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->count()
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
