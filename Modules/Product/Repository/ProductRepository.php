<?php

namespace Modules\Product\Repository;

use AliBayat\LaravelCategorizable\Category;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\Product;
use Modules\Product\Repository\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        return Product::orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Create
     *
     * @param  mixed $request
     * @return void
     */
    public function create($request)
    {


        $product = Product::create($request->all());

        foreach ($request->images as $key => $value) {
            $product->addMedia($value)->toMediaCollection('product-gallery');
        }

        // update tags
        $this->syncTags($request, $product);

        // update categories of product
        if (!is_null($request->categories)) {
            $this->syncCategories($request, $product);
        }

        // update downladable links of product
        if (!is_null($request->links)) {
            $this->syncDownloads($request->links, $product);
        }

        // update attributes of product
        if (!is_null($request->input('attributes'))) {
            $this->attachAttributesToProduct($request->input('attributes'), $product);
        }
        return $product;
    }

    /**
     * Update
     *
     * @param  mixed $request
     * @param  mixed $product
     * @return void
     */
    public function update($request, $product)
    {
        $product->update($request->all());

        // update tags
        $this->syncTags($request, $product);

        // update categories of product
        if (!is_null($request->categories)) {
            $this->syncCategories($request, $product);
        }

        // update downladable links of product
        if (!is_null($request->links)) {
            $this->syncDownloads($request, $product);
        }

        return $product;
    }

    /**
     * Sync Tags
     *
     * @param  mixed $request
     * @param  mixed $product
     * @return void
     */
    public function syncTags($request, $product)
    {
        $product->syncTags($request->tags);
    }

    /**
     * Sync Categories
     *
     * @param  mixed $request
     * @param  mixed $product
     * @return void
     */
    public function syncCategories($request, $product)
    {

        $categoryCollect = [];
        foreach ($request->categories as $category_id) {
            $categoryCollect = Category::findById($category_id);
        }

        $product->syncCategories($categoryCollect);
    }

    /**
     * Sync Downloads
     *
     * @param  mixed $links
     * @param  mixed $product
     * @return void
     */
    public function syncDownloads($links, $product)
    {
        foreach ($product->downloads as $download) {
            $download->delete();
        }
        foreach ($links as $link) {
            $product->downloads()->create(json_decode($link, true));
        }
    }

    /**
     * Attach Attributes To Product
     *
     * @param  mixed $attributes
     * @param  mixed $product
     * @return void
     */
    public function attachAttributesToProduct($attributes, $product): void
    {

        $collection = collect($attributes);

        $collection->each(function ($item) use ($product) {

            if (is_null(json_decode($item, true)['key']) || is_null(json_decode($item, true)['value'])) return;

            $attr = Attribute::firstOrCreate(['key' => json_decode($item, true)['key']]);

            $attr_value = $attr->values()->firstOrCreate(['value' => json_decode($item, true)['value']]);

            $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
        });
    }
}
