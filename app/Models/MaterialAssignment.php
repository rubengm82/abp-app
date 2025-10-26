<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MaterialAssignment extends Model
{
    protected $table = 'material_assignments';

    protected $fillable = [
        'professional_id',
        'shirt_size',
        'pants_size',
        'shoe_size',
        'assignment_date',
        'assigned_by_professional_id',
        'observations',
    ];

    protected $casts = [
        'assignment_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the professional that owns the material assignment.
     */
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    /**
     * Get the professional who assigned the materials.
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(Professional::class, 'assigned_by_professional_id');
    }

    /**
     * Get the latest material assignment for a professional. 
     */
    public static function getLatestForProfessional($professionalId)
    {
        return self::where('professional_id', $professionalId)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Get the latest shirt size for a professional.
     */
    public static function getLatestShirtSize($professionalId)
    {
        $assignment = self::where('professional_id', $professionalId)
            ->whereNotNull('shirt_size')
            ->orderBy('created_at', 'desc')
            ->first();
        
        return $assignment ? $assignment->shirt_size : null;
    }

    /**
     * Get the latest pants size for a professional.
     */
    public static function getLatestPantsSize($professionalId)
    {
        $assignment = self::where('professional_id', $professionalId)
            ->whereNotNull('pants_size')
            ->orderBy('created_at', 'desc')
            ->first();
        
        return $assignment ? $assignment->pants_size : null;
    }

    /**
     * Get the latest shoe size for a professional.
     */
    public static function getLatestShoeSize($professionalId)
    {
        $assignment = self::where('professional_id', $professionalId)
            ->whereNotNull('shoe_size')
            ->orderBy('created_at', 'desc')
            ->first();
        
        return $assignment ? $assignment->shoe_size : null;
    }

    /**
     * Relationship with notes of the material assignment
     */
    public function notes()
    {
        return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc');
    }

    /**
     * Relationship with documents of the material assignment
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc');
    }

}