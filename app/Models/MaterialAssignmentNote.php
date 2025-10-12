<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialAssignmentNote extends Model
{
    protected $table = 'material_assignment_notes';
    
    protected $fillable = [
        'material_assignment_id',
        'notes',
        'created_by_professional_id'
    ];

    /**
     * Relación con la asignación de material
     */
    public function materialAssignment()
    {
        return $this->belongsTo(MaterialAssignment::class, 'material_assignment_id');
    }

    /**
     * Relación con el profesional que creó la nota
     */
    public function createdByProfessional()
    {
        return $this->belongsTo(Professional::class, 'created_by_professional_id');
    }
}