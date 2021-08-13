<?php

namespace Modules\Product\Entities;

use AliBayat\LaravelCategorizable\Categorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\factories\ProductFactory;
use Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTags, Categorizable, InteractsWithMedia, Sluggable;

    protected $fillable = [
        'title',
        'description',
        'body',
        'quantity',
        'price',
        'final_price',
        'sku',
        'related_products',
        'tax_status',
        'publish',
        'min_quantity',
        'downloadable',
        'virtual',
        'slug',
        'length',
        'width',
        'height',
        'weight',
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
        // ->width(200)
        // ->height(250);

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
