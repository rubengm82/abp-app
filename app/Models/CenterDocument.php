<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterDocument extends Model
{
    protected $table = 'center_documents';
    
    protected $fillable = [
        'file_name',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'center_id',
        'uploaded_by_professional_id'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship with the center
     */
    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    /**
     * Relationship with the professional that uploaded the document
     */
    public function uploadedByProfessional()
    {
        return $this->belongsTo(Professional::class, 'uploaded_by_professional_id');
    }
}