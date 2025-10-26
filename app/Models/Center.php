<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Center extends Model
{
    protected $table = 'centers';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'status'
    ];

    /**
     * Relationship with professionals of the center
     */
    public function professionals()
    {
        return $this->hasMany(Professional::class);
    }

    /**
     * Relationship with notes of the center
     */
    public function notes()
    {
        return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc');
    }

    /**
     * Relationship with documents of the center
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc');
    }
}
