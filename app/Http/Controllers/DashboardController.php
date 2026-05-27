<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\SupportStyle;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Fetch Core Dashboard Counters
        $totalUsers = User::count();
        $totalNotes = Note::count();
        
        // Count entries created specifically by the currently logged-in authenticated user
        // (Assumes a 'user_id' column exists on your notes table. If not, fallback safely to total)
        $myNotesCount = Note::where('user_id', Auth::id())->count() ?? Note::count();
        
        // Count records created within the current calendar month
        $thisMonthNotes = Note::whereMonth('meeting_date', Carbon::now()->month)
                              ->whereYear('meeting_date', Carbon::now()->year)
                              ->count();

        // 2. Compute Timeline Analytics For Chart.js (Last 6 Months Cadence)
        $labels = [];
        $counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            
            // Build chronological array labels (e.g., "Jan", "Feb", "Mar")
            $labels[] = $month->format('M');
            
            // Fetch total volume generated within this specific month sequence
            $counts[] = Note::whereMonth('meeting_date', $month->month)
                            ->whereYear('meeting_date', $month->year)
                            ->count();
        }

        // 3. Compact and send all 6 required parameters downstream to the view layer safely
        return view('dashboard', compact(
            'totalUsers', 
            'totalNotes', 
            'myNotesCount', 
            'thisMonthNotes', 
            'labels', 
            'counts'
        ));
    }
}