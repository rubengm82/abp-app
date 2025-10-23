<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCommissionAssignment extends Model
{
    protected $table = 'project_commission_assignments';
    
    protected $fillable = [
        'project_commission_id',
        'professional_id',
    ];

    /**
     * Relationship with the project/commission
     */
    public function projectCommission()
    {
        return $this->belongsTo(ProjectCommission::class);
    }

    /**
     * Relationship with the professional assigned
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
