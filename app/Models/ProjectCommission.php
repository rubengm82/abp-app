<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProjectCommission extends Model
{
    
    protected $table = 'project_commissions';
    
    protected $fillable = [
        'center_id',
        'name',
        'start_date',
        'estimated_end_date',
        'responsible_professional_id',
        'description',
        'type',
        'status'
    ];

    /**
     * Relationship with center
     */
    public function center()
    {
        return $this->belongsTo(Center::class);
    }

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
    public function notes()
    {
        return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc');
    }

    /**
     * Relación con los documentos del proyecto/comisión
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc');
    }

    /**
     * Relationship with the assignments of professionals to the project/commission
     */
    public function assignments()
    {
        return $this->hasMany(ProjectCommissionAssignment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relationship many-to-many with professionals through the assignments
     */
    public function assignedProfessionals()
    {
        return $this->belongsToMany(Professional::class, 'project_commission_assignments')
                    ->withTimestamps();
    }
}
