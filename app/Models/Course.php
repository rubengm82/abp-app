<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'training_center',
        'forcem_code',
        'total_hours',
        'type',
        'attendance_type',
        'training_name',
        'workshop',
        'conference_day',
        'congress',
        'attendee',
        'start_date',
        'end_date',
    ];
}
