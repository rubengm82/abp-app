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
     * Relationship with the project/commission
     */
    public function projectCommission()
    {
        return $this->belongsTo(ProjectCommission::class, 'project_commission_id');
    }

    /**
     * Relationship with the professional that created the note
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}
