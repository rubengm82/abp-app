<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class HrIssue extends Model
{
    protected $table = 'hr_issues';
    
    /**
     * Fields that can be mass assigned
     */
    protected $fillable = [
        'opening_date',
        'closing_date',
        'affected_professional_id',
        'registering_professional_id',
        'referred_to_professional_id',
        'description',
        'status',
    ];

    /**
     * Cast attributes to native types
     */
    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
    ];

    /**
     * Relationship with the affected professional
     */
    public function affectedProfessional()
    {
        return $this->belongsTo(Professional::class, 'affected_professional_id');
    }

    /**
     * Relationship with the professional who registered the issue
     */
    public function registeringProfessional()
    {
        return $this->belongsTo(Professional::class, 'registering_professional_id');
    }

    /**
     * Relationship with the professional the issue is referred to
     */
    public function referredToProfessional()
    {
        return $this->belongsTo(Professional::class, 'referred_to_professional_id');
    }

    /**
     * Relationship with notes for the HR issue
     */
    public function notes()
    {
        return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc');
    }

    /**
     * Relationship with documents for the HR issue
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc');
    }
}

