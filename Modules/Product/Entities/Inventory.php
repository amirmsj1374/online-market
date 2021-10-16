<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'discount',
        'final_price',
        'min_quantity',
        'price',
        'product_id',
        'quantity',
        'size',
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\InventoryFactory::new();
    }

    // Relationships
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
