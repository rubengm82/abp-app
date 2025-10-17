<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $table = 'centers';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'status'
    ];

    /**
     * Relationship with professionals of the center
     */
    public function professionals()
    {
        return $this->hasMany(Professional::class);
    }

    /**
     * Relationship with notes of the center
     */
    public function notes()
    {
        return $this->hasMany(CenterNote::class);
    }

    /**
     * Relationship with documents of the center
     */
    public function documents()
    {
        return $this->hasMany(CenterDocument::class);
    }
}
