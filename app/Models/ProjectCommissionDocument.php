<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectCommissionDocument extends Model
{
    protected $table = 'project_commission_documents';

    protected $fillable = [
        'project_commission_id',
        'professional_id',
        'file_name',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
    ];
    
    // What is this? THis is a way to cast the data type of the columns, cast is a laravel function 
    // In this case, we are casting the file_size column to an integer
    // The created_at and updated_at columns are casted to datetime
    protected $casts = [
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the project commission that owns the document.
     */
    public function projectCommission(): BelongsTo
    {
        return $this->belongsTo(ProjectCommission::class);
    }

    /**
     * Get the professional that uploaded the document.
     */
    public function uploadedByProfessional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }
}
