<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'instance',
        'content'
    ];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\CartFactory::new();
    }

    // public function setCartDataAttribute($value)
    // {
    //     $this->attributes['content'] = serialize($value);
    // }

    // public function getCartDataAttribute($value)
    // {
    //     return unserialize($value);
    // }
}
