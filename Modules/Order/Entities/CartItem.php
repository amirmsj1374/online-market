<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\CartItemFactory::new();
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
