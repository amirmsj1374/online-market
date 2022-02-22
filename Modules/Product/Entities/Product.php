<?php

namespace Modules\Product\Entities;

use AliBayat\LaravelCategorizable\Categorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Log;
use Modules\Communication\Entities\Communication;
use Modules\Product\Database\factories\ProductFactory;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTags, Categorizable, InteractsWithMedia, Sluggable;

    protected $fillable = [
        'body',
        'description',
        'downloadable',
        'height',
        'imagesUrl',
        'length',
        'publish',
        'related_products',
        'slug',
        'sku',
        'tax_status',
        'title',
        'virtual',
        'weight',
        'width',
    ];

    public $appends = ['images', 'inventories', 'categories'];

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

    public function getImagesAttribute()
    {
        $images = array();

        if ($this->getFirstMedia('product-gallery')) {
            foreach ($this->getMedia('product-gallery') as $key => $image) {
                $images[$key] = $image->getFullUrl();
            }
        }
        return  $images;
    }
    public function getInventoriesAttribute()
    {
        return $this->inventories()->get() ?? [];
    }
    public function getCategoriesAttribute()
    {
        return $this->categories()->get() ?? [];
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->using(ProductAttributeValues::class)
            ->withPivot(['value_id']);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }
    public function communication()
    {
        return $this->morphMany(Communication::class, 'communicationable');
    }
}
