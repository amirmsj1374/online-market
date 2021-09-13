<?php

namespace Modules\Product\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Product\Entities\Product;

/**
 * @method static \Illuminate\Http\JsonResponse all(string $filter, string $sort_name, string $sort_direction, integer $per_page)
 * @method static \Illuminate\Http\JsonResponse find(integer $product_id)
 * @method static \Illuminate\Http\JsonResponse create(array $attributes)
 * @method static \Illuminate\Http\JsonResponse update(Product $product, array $attributes)
 * @method static \Illuminate\Http\JsonResponse delete(Product $product)
 *
 * @see \Modules\Product\Repositories\ProductRepository
 */
class ProductRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return static::class;
    }

    public static function shouldProxyTo($class)
    {
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}
