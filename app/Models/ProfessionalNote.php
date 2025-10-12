<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalNote extends Model
{
    protected $table = 'professional_notes';
    
    protected $fillable = [
        'professional_id',
        'notes',
        'created_by_professional_id'
    ];

    /**
     * Relación con el profesional
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    /**
     * Relación con el profesional que creó la nota
     */
    public function createdByProfessional()
    {
        return $this->belongsTo(Professional::class, 'created_by_professional_id');
    }
}