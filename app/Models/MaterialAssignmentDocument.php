<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialAssignmentDocument extends Model
{
    protected $table = 'material_assignment_documents';
    
    protected $fillable = [
        'file_name',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'material_assignment_id',
        'uploaded_by_professional_id'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con la asignación de material
     */
    public function materialAssignment()
    {
        return $this->belongsTo(MaterialAssignment::class, 'material_assignment_id');
    }

    /**
     * Relación con el profesional que subió el documento
     */
    public function uploadedByProfessional()
    {
        return $this->belongsTo(Professional::class, 'uploaded_by_professional_id');
    }
}