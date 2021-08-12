<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['value'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Product\Database\factories\AttributeValueFactory::new();
    // }
}
