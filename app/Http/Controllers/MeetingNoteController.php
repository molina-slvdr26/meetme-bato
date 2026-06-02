<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class MeetingNoteController extends Controller
{
    
    public function index()
    {
        
        $meetingNotes = DB::table('notes')->latest()->get(); 

        return view('meeting_notes.index', compact('meetingNotes'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'          => 'required|string|max:255',
            'place'            => 'nullable|string|max:255',
            'meeting_date'     => 'required|date',
            'meeting_time'     => 'required',
            'agenda'           => 'nullable|string',
            'minutes_taken_by' => 'nullable|string|max:255',
            'attendees'        => 'nullable|string',
            'meeting_notes'    => 'required|string',
        ]);

        
        $validated['user_id'] = Auth::id();

       
        $validated['action_items'] = json_encode([]);
        
        
        $validated['created_at'] = now();
        $validated['updated_at'] = now();

       
        DB::table('notes')->insert($validated);

        return redirect()->route('notes.index')
            ->with('toast_success', 'Meeting document archived successfully!');
    }

    
    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'subject'          => 'required|string|max:255',
            'place'            => 'nullable|string|max:255',
            'meeting_date'     => 'required|date',
            'meeting_time'     => 'required',
            'agenda'           => 'nullable|string',
            'minutes_taken_by' => 'nullable|string|max:255',
            'attendees'        => 'nullable|string',
            'meeting_notes'    => 'required|string',
        ]);

        $validated['updated_at'] = now();

        
        DB::table('notes')->where('id', $id)->update($validated);

        return redirect()->route('notes.index')
            ->with('toast_success', 'Meeting record updated securely.');
    }

   
    public function destroy($id) // Changed from model type-hinting to ID
    {
        
        DB::table('notes')->where('id', $id)->delete();

        return redirect()->route('notes.index')
            ->with('toast_success', 'Meeting record purged from archives.');
    }
}