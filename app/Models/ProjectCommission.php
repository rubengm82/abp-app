<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCommission extends Model
{
    
    protected $table = 'project_commissions';
    
    protected $fillable = [
        'name',
        'start_date',
        'estimated_end_date',
        'responsible_professional_id',
        'description',
        'notes',
        'type',
        'status'
    ];

    /**
     * Relación con el profesional responsable para mostrar el nombre del profesional responsable
     */
    public function responsibleProfessional()
    {
        return $this->belongsTo(Professional::class, 'responsible_professional_id');
    }

    /**
     * Relación con las notas del proyecto/comisión
     */
    public function projectNotes()
    {
        return $this->hasMany(ProjectCommissionNote::class, 'project_commission_id')->orderBy('created_at', 'desc');
    }

    /**
     * Relación con los documentos del proyecto/comisión
     */
    public function projectCommissionDocuments()
    {
        return $this->hasMany(ProjectCommissionDocument::class, 'project_commission_id')->orderBy('created_at', 'desc');
    }
}
