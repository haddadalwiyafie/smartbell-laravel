<?php

namespace App\Http\Controllers;

use App\Models\BellPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $periods = BellPeriod::orderBy('sort_order')->get();
        $next    = $periods->firstWhere('status', 'Next');
        $total   = $periods->count();
        $remaining = $periods->whereIn('status', ['Next', 'Pending'])->count();

        return view('dashboard', compact('periods', 'next', 'total', 'remaining'));
    }
}
