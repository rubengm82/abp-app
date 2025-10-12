<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterNote extends Model
{
    protected $table = 'center_notes';
    
    protected $fillable = [
        'center_id',
        'notes',
        'created_by_professional_id'
    ];

    /**
     * Relación con el centro
     */
    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    /**
     * Relación con el profesional que creó la nota
     */
    public function createdByProfessional()
    {
        return $this->belongsTo(Professional::class, 'created_by_professional_id');
    }
}