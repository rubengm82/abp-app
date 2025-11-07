<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenances';

    protected $fillable = [
        'name_maintenance', 
        'who_does_maintenance',
        'description',
        'center_id',
        'opening_date_maintenance',
    ];
}