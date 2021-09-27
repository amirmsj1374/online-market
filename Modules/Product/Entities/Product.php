<?php

namespace Modules\Product\Entities;

use AliBayat\LaravelCategorizable\Categorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Product\Database\factories\ProductFactory;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTags, Categorizable, InteractsWithMedia, Sluggable;

    protected $fillable = [
        'body',
        'description',
        'downloadable',
        'final_price',
        'height',
        'imagesUrl',
        'length',
        'min_quantity',
        'price',
        'publish',
        'quantity',
        'related_products',
        'slug',
        'sku',
        'tax_status',
        'title',
        'virtual',
        'weight',
        'width',
    ];

    protected $casts = [
        'imagesUrl' => 'array',
    ];

    /**
     * newFactory
     *
     * @return void
     */
    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    /**
     * registerMediaCollections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-gallery');
    }



    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * attributes
     *
     * @return void
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->using(ProductAttributeValues::class)
            ->withPivot(['value_id']);
    }

    /**
     * downloads
     *
     * @return void
     */
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }
}
