<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplementaryService extends Model
{
    protected $table = 'complementary_services';
    
    protected $fillable = [
        'complementary_services',
        'center_id',
        'service_type',
        'service_responsible',
        'start_date',
        'end_date',
    ];

    public function center()
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
