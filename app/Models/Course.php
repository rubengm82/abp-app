<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    /**
     * Relationship with notes of the center
     */
    public function notes()
    {
        return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc');
    }

    /**
     * Relationship with documents of the center
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc');
    }

    /**
     * Relationship with the assignments of professionals to the course
     */
    public function assignments()
    {
        return $this->hasMany(CourseAssignment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relationship many-to-many with professionals through the assignments
     */
    public function assignedProfessionals()
    {
        return $this->belongsToMany(Professional::class, 'course_assignments')
                    ->withTimestamps();
    }
}
