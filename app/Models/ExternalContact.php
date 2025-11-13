<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ExternalContact extends Model
{
    
    protected $table = 'external_contacts';
    
    protected $fillable = [
        'center_id',
        'external_contact_type',
        'service_reason',
        'company',
        'department',
        'name',
        'surname',
        'link',
        'phone',
        'email',
        'observations'
    ];

    /**
     * Relationship with center
     */
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * Relationship with notes for the external contact
     */
    public function notes()
    {
        return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc');
    }

    /**
     * Relationship with documents for the external contact
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc');
    }
}

