<?php

namespace Modules\Product\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Product;
use Modules\Product\Repository\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function index()
    {
        return Product::all();
    }

    public function create($request)
    {
        $product = Product::create([
            'title'       => $request->title,
            'description' => $request->description,
            'body'        => $request->body,
        ]);

        // update tags
        $this->updateTags($request, $product);

        // update categories of product
        if (!is_null($request->categories)) {
            $this->updateCategory($request, $product);
        }

        return $product;
    }


    public function update($request, $product)
    {
        $product->update($request->all());

        // update tags
        $this->updateTags($request, $product);

        // update categories of product
        if (!is_null($request->categories)) {
            $this->updateCategory($request, $product);
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
}
