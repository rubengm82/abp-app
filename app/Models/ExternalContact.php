<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ExternalContact extends Model
{
    
    protected $table = 'external_contacts';
    
    protected $fillable = [
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

