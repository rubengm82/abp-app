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
     * Relationship with the material assignment
     */
    public function materialAssignment()
    {
        return $this->belongsTo(MaterialAssignment::class, 'material_assignment_id');
    }

    /**
     * Relationship with the professional that created the note
     */
    public function createdByProfessional()
    {
        return $this->belongsTo(Professional::class, 'created_by_professional_id');
    }
}