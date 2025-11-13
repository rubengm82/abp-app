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
    ];
}
