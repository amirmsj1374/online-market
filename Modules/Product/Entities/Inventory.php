<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Entities\CartItem;

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
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
