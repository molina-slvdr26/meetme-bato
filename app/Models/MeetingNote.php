<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingNote extends Model 
{
    use HasFactory;

    
    protected $table = 'notes';

    
    protected $fillable = [
        'user_id',
        'subject',
        'place',
        'meeting_date',
        'meeting_time',
        'agenda',
        'minutes_taken_by',
        'attendees',
        'meeting_notes',
        'action_items'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}