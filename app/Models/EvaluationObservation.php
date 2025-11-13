<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationObservation extends Model
{
    protected $table = 'evaluation_observations';
    
    protected $fillable = [
        'evaluation_uuid',
        'observation',
    ];

    /**
     * Relationship with evaluations by UUID
     * Note: This is a logical relationship, not a database FK
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluation_uuid', 'evaluation_uuid');
    }
}

