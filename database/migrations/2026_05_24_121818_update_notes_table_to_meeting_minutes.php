<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\SupportStyle;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            // Drop old simple structure safely if rewriting
            if (Schema::hasColumn('notes', 'title')) { $table->dropColumn('title'); }
            if (Schema::hasColumn('notes', 'content')) { $table->dropColumn('content'); }

            // Add comprehensive template fields
            $table->string('subject')->nullable();
            $table->string('place')->nullable();
            $table->date('meeting_date')->nullable();
            $table->time('meeting_time')->nullable();
            $table->text('agenda')->nullable();
            $table->text('minutes_taken_by')->nullable();
            $table->text('attendees')->nullable();
            $table->longText('meeting_notes')->nullable();
            
            // Action items (Stored cleanly as structured JSON parameters)
            $table->json('action_items')->nullable(); 
        });
    }

    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            
            $table->dropColumn(['subject', 'place', 'meeting_date', 'meeting_time', 'agenda', 'minutes_taken_by', 'attendees', 'meeting_notes', 'action_items']);
        });
    }
};