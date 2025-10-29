<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Professional extends Authenticatable
{
    protected $table = 'professionals';
    
    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'center_id',
        'role',
        'name',
        'surname1',
        'surname2',
        'dni',
        'phone',
        'email',
        'address',
        'employment_status',
        'cvitae',
        'user',       // username
        'password',   // hashed password
        'locker_num',
        'key_code',
        'status'
    ];

    /**
     * Mutator to automatically hash the password
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relationships
    public function center() { return $this->belongsTo(Center::class); }
    public function materialAssignments() { return $this->hasMany(MaterialAssignment::class); }
    public function notes() { return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc'); }
    public function documents() { return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc'); }
    
    /**
     * Relación con las asignaciones de proyectos/comisiones donde es responsable
     */
    public function responsibleProjects() { return $this->hasMany(ProjectCommission::class, 'responsible_professional_id'); }
    
    /**
     * Relación con las asignaciones de proyectos/comisiones donde participa
     */
    public function projectAssignments() { return $this->hasMany(ProjectCommissionAssignment::class); }
    
    /**
     * Relación many-to-many con proyectos/comisiones a través de las asignaciones
     */
    public function assignedProjects()
    {
        return $this->belongsToMany(ProjectCommission::class, 'project_commission_assignments')
                    ->withTimestamps();
    }

    /**
     * Relationship with course assignments where the professional participates
     */
    public function courseAssignments() { return $this->hasMany(CourseAssignment::class); }
    
    /**
     * Relationship many-to-many with courses through the assignments
     */
    public function assignedCourses()
    {
        return $this->belongsToMany(Course::class, 'course_assignments')
                    ->withTimestamps();
    }

    /**
     * Relationship with the user model
     */
    public function userAccount()
    {
        return $this->hasOne(User::class, 'professional_id');
    }

    /**
     * Boot method: automatically creates user when creating professional
     * and deletes user when deleting professional
     */
    protected static function booted()
    {
        static::created(function ($professional) {
            // Create a minimal user placeholder linked to this professional.
            // We intentionally do NOT copy name/email/password here to avoid
            // duplicating sensitive data or creating sync issues.
            $professional->userAccount()->create([]);
        });

        static::deleting(function ($professional) {
            if ($professional->userAccount) {
                $professional->userAccount->delete();
            }
        });
    }
}
