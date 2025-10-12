<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalDocument extends Model
{
    protected $table = 'professional_documents';
    
    protected $fillable = [
        'file_name',
        'original_name',
        'file_content',
        'file_size',
        'mime_type',
        'professional_id',
        'uploaded_by_professional_id'
    ];

    /**
     * Relación con el profesional
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    /**
     * Relación con el profesional que subió el documento
     */
    public function uploadedByProfessional()
    {
        return $this->belongsTo(Professional::class, 'uploaded_by_professional_id');
    }
}