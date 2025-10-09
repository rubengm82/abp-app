<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCommissionNote extends Model
{
    protected $table = 'project_commission_notes';
    
    protected $fillable = [
        'project_commission_id',
        'notes',
        'professional_id'
    ];

    /**
     * Relación con el proyecto/comisión
     */
    public function projectCommission()
    {
        return $this->belongsTo(ProjectCommission::class, 'project_commission_id');
    }

    /**
     * Relación con el profesional que creó la nota
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}
