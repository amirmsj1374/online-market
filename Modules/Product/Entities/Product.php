<?php

namespace Modules\Product\Entities;

use AliBayat\LaravelCategorizable\Categorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\factories\ProductFactory;
use Spatie\Tags\HasTags;

class Product extends Model
{
    use HasFactory, HasTags, Categorizable;

    protected $fillable = [
        'title', 'slug', 'sku', 'description', 'body', 'related_products',
        'tax_status', 'virtual', 'downloadable', 'publish', 'quantity',
        'min_quantity', 'price', 'final_price',
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->using(ProductAttributeValues::class)
            ->withPivot(['value_id']);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }
}
