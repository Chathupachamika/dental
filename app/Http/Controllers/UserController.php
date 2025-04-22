<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure only authenticated users can access
    }

    public function home()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            \Log::info('Redirecting admin from user dashboard', ['email' => $user->email]);
            return redirect()->route('admin.dashboard'); // Redirect admins away
        }
        return view('user.dashboard'); // Load user/dashboard.blade.php for non-admins
    }
}
