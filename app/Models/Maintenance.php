<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $table = 'maintenances';

    protected $fillable = [
        'name_maintenance', 
        'responsible_maintenance',
        'center_id',
        'description',
        'opening_date_maintenance',
        'ending_date_maintenance',
    ];
    
    public function center():BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function notes() { 
        return $this->morphMany(NotesComponent::class, 'noteable')->orderBy('created_at', 'desc'); 
    }

    public function documents() { 
        return $this->morphMany(DocumentComponent::class, 'documentable')->orderBy('created_at', 'desc'); 
    }

}