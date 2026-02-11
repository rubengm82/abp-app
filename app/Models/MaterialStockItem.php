<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialStockItem extends Model
{
    protected $table = 'material_stock_items';

    protected $fillable = [
        'center_id',
        'name',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(MaterialStockMovement::class, 'material_stock_item_id')->orderBy('movement_date', 'desc')->orderBy('created_at', 'desc');
    }
}
