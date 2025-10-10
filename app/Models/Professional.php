<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $table = 'professionals';
    
    /**
     * Los campos que pueden ser asignados
     */
    protected $fillable = [
        'center_id',
        'role',
        'name',
        'surname1',
        'surname2',
        'dni',
        'phone',
        'email',
        'address',
        'employment_status',
        'cvitae',
        'login',
        'password',
        'key_code',
        'status'
    ];

    // /**
    //  * Relación con el centro
    //  */
    // public function center()
    // {
    //     return $this->belongsTo(Center::class);
    // }
}
