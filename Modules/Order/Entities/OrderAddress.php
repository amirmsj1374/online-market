<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'address',
        'city',
        'province',
        'zipcode',
        'phone',
        'email',
        'order_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderAddressFactory::new();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
