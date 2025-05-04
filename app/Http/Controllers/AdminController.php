<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Check if user is admin
        if (!$user->isAdmin()) {
            \Log::info('Non-admin attempted to access admin dashboard', ['email' => $user->email]);
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized access.');
        }

        // Fetch recent activities (if table exists)
        $recentActivities = collect();
        try {
            $recentActivities = DB::table('activity_logs')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            \Log::warning('Failed to fetch activity logs: ' . $e->getMessage());
        }

        return view('admin.admin_dashboard', compact('recentActivities'));
    }

    public function generateDailyReport(Request $request)
    {
        try {
            $date = $request->input('date', now()->toDateString());

            // Get appointments with patient and treatment details
            $appointments = Appointment::with(['patient', 'invoiceTreatment.treatment'])
                ->whereDate('appointment_date', $date)
                ->get()
                ->map(function($appointment) {
                    return [
                        'time' => $appointment->appointment_time,
                        'patient' => $appointment->patient,
                        'treatment' => $appointment->invoiceTreatment ?
                            $appointment->invoiceTreatment->treatment->name : 'No treatment assigned',
                        'status' => $appointment->status
                    ];
                });

            // Get invoices with patient and treatment details
            $invoices = Invoice::with(['patient', 'invoiceTreatment.treatment'])
                ->whereDate('created_at', $date)
                ->get();

            $data = [
                'date' => Carbon::parse($date)->format('F d, Y'),
                'appointments' => $appointments,
                'patients' => Patient::whereDate('created_at', $date)->get(),
                'invoices' => $invoices,
                'total_revenue' => $invoices->sum('totalAmount'),
                'pending_payments' => $invoices->where('totalAmount', '>', 'advanceAmount')->sum('totalAmount'),
            ];

            $pdf = PDF::loadView('admin.reports.daily_report', $data);
            return $pdf->download('daily-report-' . $date . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }
}


