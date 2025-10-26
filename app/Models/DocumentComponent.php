<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentComponent extends Model
{
    protected $table = 'documents_component';

    protected $fillable = [
        'file_name',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_by_professional_id'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Polymorphic relation to any model (Center, ProjectCommission, etc.)
     */
    public function documentable()
    {
        return $this->morphTo();
    }

    /**
     * Professional that uploaded the document
     */
    public function uploadedByProfessional()
    {
        return $this->belongsTo(Professional::class, 'uploaded_by_professional_id');
    }
}
