<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $timestamps = false;

    protected static function newFactory()
    {
        // return \Modules\Discount\Database\factories\DiscountFactory::new();
    }
}
