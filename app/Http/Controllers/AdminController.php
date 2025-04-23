<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Check if user is admin
        if (!$user->isAdmin()) {
            \Log::info('Non-admin attempted to access admin dashboard', ['email' => $user->email]);
            return redirect()->route('user.home')->with('error', 'Unauthorized access.');
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
}


