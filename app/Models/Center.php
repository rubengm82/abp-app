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
     * Relación con los profesionales del centro
     */
    public function professionals()
    {
        return $this->hasMany(Professional::class);
    }

    /**
     * Relación con las notas del centro
     */
    public function notes()
    {
        return $this->hasMany(CenterNote::class);
    }

    /**
     * Relación con los documentos del centro
     */
    public function documents()
    {
        return $this->hasMany(CenterDocument::class);
    }
}
