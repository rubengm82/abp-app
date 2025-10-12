<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * No utilizar ya que se necesita especificar el item
     */
    public static function getLatestForProfessional($professionalId)
    {
        return self::where('professional_id', $professionalId)
            ->orderBy('assignment_date', 'desc')
            ->first();
    }

    /**
     * Get the latest shirt size for a professional.
     */
    public static function getLatestShirtSize($professionalId)
    {
        $assignment = self::where('professional_id', $professionalId)
            ->whereNotNull('shirt_size')
            ->orderBy('assignment_date', 'desc')
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
            ->orderBy('assignment_date', 'desc')
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
            ->orderBy('assignment_date', 'desc')
            ->first();
        
        return $assignment ? $assignment->shoe_size : null;
    }

    /**
     * Relación con las notas de la asignación de material
     */
    public function notes()
    {
        return $this->hasMany(MaterialAssignmentNote::class);
    }

    /**
     * Relación con los documentos de la asignación de material
     */
    public function documents()
    {
        return $this->hasMany(MaterialAssignmentDocument::class);
    }
}