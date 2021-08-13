<?php

namespace Modules\Product\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\Product;
use Modules\Product\Repository\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function index()
    {
        return Product::orderBy('id','desc')->paginate(10);
    }

    public function create($request)
    {
        $product = Product::create($request->all());

        // update tags
        $this->updateTags($request, $product);

        // update categories of product
        // if (!is_null($request->categories)) {
        //     $this->updateCategory($request, $product);
        // }

        // update downladable links of product
        if (!is_null($request->links)) {
            $this->updateDownloads($request->links, $product);
        }

        // update attributes of product
        if (!is_null($request->input('attributes'))) {
            $this->attachAttributesToProduct($request->input('attributes'), $product);
        }
        return $product;
    }


    public function update($request, $product)
    {
        $product->update($request->all());

        // update tags
        $this->updateTags($request, $product);

        // update categories of product
        // if (!is_null($request->categories)) {
        //     $this->updateCategory($request, $product);
        // }

        // update downladable links of product
        if (!is_null($request->links)) {
            $this->updateDownloads($request, $product);
        }

        return $product;
    }
    public function updateTags($request, $product)
    {
        $product->syncTags($request->tags);
    }
    public function updateImages()
    {
    }
    public function updateCategory($request, $product)
    {
        $product->syncCategories($request->categories);
    }
    public function updateDownloads($links, $product)
    {
        foreach ($product->downloads as $download) {
            $download->delete();
        }
        foreach ($links as $link) {
            $product->downloads()->create(json_decode($link, true));
        }
    }

    public function attachAttributesToProduct($attributes, $product): void
    {

        $collection = collect($attributes);
        $collection->each(function ($item) use ($product) {
            Log::info([
                'attrs' => $item
            ]);
            if (is_null(json_decode($item, true)['key']) || is_null(json_decode($item, true)['value'])) return;
            $attr = Attribute::firstOrCreate(['key' => json_decode($item, true)['key']]);
            $attr_value = $attr->values()->firstOrCreate(['value' => json_decode($item, true)['value']]);
            Log::info([
                'relation' => $product->attributes
            ]);
            $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
        });
    }
}
