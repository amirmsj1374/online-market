<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['key'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Product\Database\factories\AttributeFactory::new();
    // }
}
