<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Inventory;
use Modules\User\Entities\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_count',
        'is_pay',
        'status',
        'final_price',
        'payment_method',
        'payment_id',
        'post_type',
        'post_pay',
        'tracking_serial',
        'note',
    ];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }
    public function items()
    {
        return $this->belongsToMany(Inventory::class, 'order_items', 'order_id', 'inventory_id')->withPivot('quantity', 'price', 'final_price', 'discount', 'color', 'size');
    }

}
