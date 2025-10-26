<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotesComponent extends Model
{
    protected $table = 'notes_component';

    protected $fillable = [
        'notes',
        'created_by_professional_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Polymorphic relation to any model (Center, ProjectCommission, MaterialAssignment, Professional, etc.)
     */
    public function noteable()
    {
        return $this->morphTo();
    }

    /**
     * Relationship with the professional that created the note
     */
    public function createdByProfessional()
    {
        return $this->belongsTo(Professional::class, 'created_by_professional_id');
    }
}
