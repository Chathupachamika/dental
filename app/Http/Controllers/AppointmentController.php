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

        $appointments = $query->paginate(5); // Paginate the results
        $patients = Patient::select('id', 'name', 'mobileNumber')->orderBy('name')->get();

        return view('admin.Appointments.index', compact('appointments', 'patients'));
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

    /**
     * Get today's appointments
     */
    public function getTodayAppointments()
    {
        $appointments = Appointment::with('patient')
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->get();

        return response()->json([
            'success' => true,
            'appointments' => $appointments
        ]);
    }

    public function getTodayAppointmentsCount()
    {
        $today = Appointment::whereDate('appointment_date', today())->count();
        $yesterday = Appointment::whereDate('appointment_date', yesterday())->count();
        $percentageChange = $yesterday > 0 ? (($today - $yesterday) / $yesterday) * 50 : 0;

        return response()->json([
            'count' => $today,
            'percentageChange' => round($percentageChange, 1)
        ]);
    }

    public function getConfirmedAppointments(Request $request)
    {
        $user = Auth::user();

        $appointments = Appointment::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->with('user')
            ->get();

        return response()->json([
            'success' => true,
            'appointments' => $appointments
        ]);
    }

    /**
     * Store a new appointment
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string'
        ]);

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'notes' => $request->notes,
            'user_id' => Auth::id()
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully',
                'appointment' => $appointment->load('patient')
            ]);
        }

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully');
    }

    /**
     * Store a new appointment via API
     */
    public function apiStore(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required',
                'notes' => 'nullable|string'
            ]);

            $appointment = Appointment::create([
                'patient_id' => $request->patient_id,
                'user_id' => Auth::id(), // Add user_id
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => 'pending',
                'notes' => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully',
                'appointment' => $appointment->load('patient', 'user')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating appointment',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get appointment details
     */
    public function show($id)
    {
        $appointment = Appointment::with('patient')->findOrFail($id);
        return response()->json([
            'success' => true,
            'appointment' => $appointment
        ]);
    }

    public function getAllAppointments(Request $request)
    {
        $user = Auth::user();
        return Appointment::where('user_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->paginate(5);
    }

    public function getUpcomingAppointments(Request $request)
    {
        $user = Auth::user();
        return Appointment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->paginate(5);
    }

    public function getCompletedAppointments(Request $request)
    {
        $user = Auth::user();
        return Appointment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->paginate(5);
    }

    public function getCancelledAppointments(Request $request)
    {
        $user = Auth::user();
        return Appointment::where('user_id', $user->id)
            ->where('status', 'cancelled')
            ->orderBy('appointment_date', 'desc')
            ->paginate(5);
    }

    public function searchAppointments(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('query');
        return Appointment::where('user_id', $user->id)
            ->where(function($query) use ($search) {
                $query->where('notes', 'like', "%{$search}%")
                      ->orWhere('appointment_date', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
            })
            ->orderBy('appointment_date', 'desc')
            ->paginate(5);
    }

    public function getAppointmentStats()
    {
        $stats = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'today' => Appointment::whereDate('appointment_date', Carbon::today())->count()
        ];
        return response()->json($stats);
    }

    public function getDashboardStats()
    {
        try {
            $today = Carbon::today();
            $stats = [
                'pending' => Appointment::where('status', 'pending')->count(),
                'confirmed' => Appointment::where('status', 'confirmed')->count(),
                'cancelled' => Appointment::where('status', 'cancelled')->count(),
                'today' => Appointment::whereDate('appointment_date', $today)->count()
            ];
            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDashboardCounts()
    {
        $today = Carbon::today();
        $counts = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'today' => Appointment::whereDate('appointment_date', $today)->count()
        ];
        return response()->json($counts);
    }

    public function getTodaySchedule()
    {
        try {
            $appointments = Appointment::with(['patient', 'user'])
                ->whereDate('appointment_date', Carbon::today())
                ->orderBy('appointment_time', 'asc')
                ->get()
                ->map(function ($appointment) {
                    $statusClass = match($appointment->status) {
                        'pending' => 'bg-amber-100 text-amber-800',
                        'confirmed' => 'bg-emerald-100 text-emerald-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800'
                    };

                    $patientName = $appointment->patient?->name ?? $appointment->user?->name ?? 'N/A';
                    $formattedTime = $appointment->appointment_time
                        ? Carbon::parse($appointment->appointment_time)->format('h:i A')
                        : 'N/A';

                    return [
                        'id' => $appointment->id,
                        'time' => $formattedTime,
                        'patient_name' => $patientName,
                        'status' => ucfirst($appointment->status),
                        'notes' => $appointment->notes ?? 'No notes',
                        'status_class' => $statusClass,
                        'contact' => $appointment->patient?->mobileNumber ?? $appointment->user?->mobile_number ?? 'N/A'
                    ];
                });

            return response()->json([
                'success' => true,
                'count' => $appointments->count(),
                'appointments' => $appointments,
                'date' => Carbon::today()->format('F d, Y')
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getTodaySchedule: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch appointments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getStatusClass($status)
    {
        switch ($status) {
            case 'pending':
                return 'bg-amber-100 text-amber-800';
            case 'confirmed':
                return 'bg-emerald-100 text-emerald-800';
            case 'cancelled':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }
}
