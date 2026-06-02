<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
   
        $totalUsers = User::count();
        $totalNotes = DB::table('notes')->count();
        

        $myNotesCount = Auth::check() 
            ? DB::table('notes')->where('user_id', Auth::id())->count() 
            : $totalNotes;
        
       
        $thisMonthNotes = DB::table('notes')
            ->whereMonth('meeting_date', Carbon::now()->month)
            ->whereYear('meeting_date', Carbon::now()->year)
            ->count();

        
        $notesPerMonth = DB::table('notes')
            ->select(
                DB::raw('YEAR(meeting_date) as year'),
                DB::raw('MONTH(meeting_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('meeting_date', '>=', Carbon::now()->subMonths(4)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . sprintf('%02d', $item->month);
            });

        $labels = [];
        $counts = [];

        
        for ($i = 4; $i >= -1; $i--) {
            $monthDate = Carbon::now()->subMonths($i)->startOfMonth();
            
            $labels[] = $monthDate->format('M');
            $key = $monthDate->format('Y-m');
            
            $counts[] = isset($notesPerMonth[$key]) ? $notesPerMonth[$key]->count : 0;
        }

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