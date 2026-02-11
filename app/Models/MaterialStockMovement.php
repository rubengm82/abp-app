<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialStockMovement extends Model
{
    protected $table = 'material_stock_movements';

    protected $fillable = [
        'material_stock_item_id',
        'type',
        'quantity',
        'movement_date',
        'person',
        'professional_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'movement_date' => 'date',
    ];

    public function materialStockItem(): BelongsTo
    {
        return $this->belongsTo(MaterialStockItem::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }
}
