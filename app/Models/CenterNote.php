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
     * Relationship with the center
     */
    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    /**
     * Relationship with the professional that created the note
     */
    public function createdByProfessional()
    {
        return $this->belongsTo(Professional::class, 'created_by_professional_id');
    }
}