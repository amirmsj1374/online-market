<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'maxDiscount',
        'minPrice',
        'measure',
        'description',
        'limit',
        'type',
        'selected',
        'select_all',
        'beginning',
        'expiration',
        'status'
    ];
    public $timestamps = false;

    protected $casts = [
        'selected' => 'array',
    ];
    protected static function newFactory()
    {
        // return \Modules\Discount\Database\factories\DiscountFactory::new();
    }
}
