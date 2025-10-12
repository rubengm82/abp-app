<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterDocument extends Model
{
    protected $table = 'center_documents';
    
    protected $fillable = [
        'file_name',
        'original_name',
        'file_content',
        'file_size',
        'mime_type',
        'center_id',
        'uploaded_by_professional_id'
    ];

    /**
     * Relación con el centro
     */
    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    /**
     * Relación con el profesional que subió el documento
     */
    public function uploadedByProfessional()
    {
        return $this->belongsTo(Professional::class, 'uploaded_by_professional_id');
    }
}