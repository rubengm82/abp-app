<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalAccident extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'type',
        'date',
        'context',
        'description',
        'created_by_professional_id',
        'affected_professional_id',
        'duration',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'duration' => 'integer',
    ];

    /**
     * Get the professional who created this record
     */
    public function createdByProfessional()
    {
        return $this->belongsTo(Professional::class, 'created_by_professional_id');
    }

    /**
     * Get the affected professional
     */
    public function affectedProfessional()
    {
        return $this->belongsTo(Professional::class, 'affected_professional_id');
    }
}
