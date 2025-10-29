<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAssignment extends Model
{
    protected $table = 'course_assignments';
    
    protected $fillable = [
        'course_id',
        'professional_id',
        'certificate',
    ];

    /**
     * Relationship with the course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relationship with the professional assigned
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}

