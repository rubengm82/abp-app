<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class GeneralService extends Model
{
    protected $table = 'general_services';
    
    protected $fillable = [
        'center_id',
        'service_type',
        'responsible',
    ];

    /**
     * Relationship with notes of the general service
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc');
    }

    /**
     * Relationship with documents of the general service
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc');
    }

     /**
     * Relationship with center
     */
    public function centro()
    {
        return $this->belongsTo(Center::class);
    }

}

