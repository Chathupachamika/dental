<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\Treatment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $place_query = patient::whereNotNull('name');

        $data['patients'] = $place_query->orderBy('id', 'DESC')->paginate(5);
        return view('patient.index', $data);
    }
}
