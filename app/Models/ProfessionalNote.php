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
     * Relationship with the professional
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    /**
     * Relationship with the professional that created the note
     */
    public function createdByProfessional()
    {
        return $this->belongsTo(Professional::class, 'created_by_professional_id');
    }
}