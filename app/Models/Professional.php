<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $table = 'professionals';
    
    /**
     * Los campos que pueden ser asignados
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
        'login',
        'password',
        'key_code',
        'status'
    ];

    /**
     * Relación con el centro
     */
    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * Relación con las asignaciones de material
     */
    public function materialAssignments()
    {
        return $this->hasMany(MaterialAssignment::class);
    }

    /**
     * Relación con las notas del profesional
     */
    public function notes()
    {
        return $this->hasMany(ProfessionalNote::class);
    }

    /**
     * Relación con los documentos del profesional
     */
    public function documents()
    {
        return $this->hasMany(ProfessionalDocument::class);
    }

    /**
     * Relación con las notas creadas por este profesional
     */
    public function createdNotes()
    {
        return $this->hasMany(ProfessionalNote::class, 'created_by_professional_id');
    }

    /**
     * Relación con los documentos subidos por este profesional
     */
    public function uploadedDocuments()
    {
        return $this->hasMany(ProfessionalDocument::class, 'uploaded_by_professional_id');
    }
}
