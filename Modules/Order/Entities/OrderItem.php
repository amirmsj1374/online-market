<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'order_id',
        'price',
        'discount',
        'final_price',
        'quantity',
        'color',
        'size',
    ];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderItemFactory::new();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
