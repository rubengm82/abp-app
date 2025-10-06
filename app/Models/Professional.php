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
        'phone',
        'email',
        'address',
        'employment_status',
        'cvitae',
        'login',
        'password',
        'key_code',
        'shirt_size',
        'pants_size',
        'shoe_size',
    ];

    // /**
    //  * Relación con el centro
    //  */
    // public function center()
    // {
    //     return $this->belongsTo(Center::class);
    // }
}
