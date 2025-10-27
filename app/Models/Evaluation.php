<?php

namespace App\Models;
use App\Models\Professional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    protected $table = 'evaluations';

    protected $fillable = [
        'evaluator_professional_id', 
        'evaluated_professional_id',
        'question_id',
    ];

}
