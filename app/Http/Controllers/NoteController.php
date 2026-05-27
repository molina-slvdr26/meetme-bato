<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the boardroom minutes records.
     */
    public function index()
    {
        // Fetch logs descending by meeting date for executive layout prioritization
        $notes = Note::with('user')->orderBy('meeting_date', 'desc')->get();
        
        return view('notes.index', compact('notes'));
    }

    /**
     * Store a newly created corporate minutes entry in storage.
     */
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

        // Securely bind the active log creation to the authenticated user account
        $validated['user_id'] = Auth::id();

        // Enforce structural empty JSON notation string for data mapping
        $validated['action_items'] = json_encode([]);

        Note::create($validated);

        return redirect()->route('notes.index')
            ->with('toast_success', 'Meeting document archived successfully!');
    }

    /**
     * Update the specified meeting minute vault entry securely.
     */
    public function update(Request $request, Note $note)
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

        // Retain security ownership integrity parameters during lifecycle mutation changes
        $note->update($validated);

        return redirect()->route('notes.index')
            ->with('toast_success', 'Meeting record updated securely.');
    }

    /**
     * Permanently purge a briefing log document from database records.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')
            ->with('toast_success', 'Meeting record purged from archives.');
    }
}