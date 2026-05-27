<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    // Allow these meeting fields to be mass-assigned safely
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

    /**
     * Relationship back to the User/Board Member who logged it.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}