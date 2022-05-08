<?php

namespace Modules\Product\Repositories;

use AliBayat\LaravelCategorizable\Category;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\Product;
use Modules\Product\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Modules\Discount\Entities\Discount;
use Modules\Product\Entities\Inventory;
use Modules\Product\QueryFilter\Title;

class ProductRepository implements ProductRepositoryInterface
{
    public function index($request)
    {
        $per_page = $request->input('per_page')  ?? 5;
        $product = Product::with('categories', 'media', 'inventories')->orderBy('id', 'desc')->paginate($per_page);
        return $this->addExtraDataToProductCollection($product);
    }

    public function show(Product $product)
    {
        $product->load('downloads', 'inventories');
        return $this->addExtraDataToProductCollection($product, true);
    }

    public function create($request)
    {

        if (strpos($request->body, 'src') !== false) {

            preg_match_all('@src="([^"]+)"@', $request->body, $match);

            $request->request->add(['imagesUrl' =>  $match[1]]); //add request

        }

        $product = Product::create($request->all());

        // if the request has images
        if ($request->hasFile('images') && count($request->images) > 0) {
            foreach ($request->images as  $value) {
                $product->addMedia($value)->toMediaCollection('product-gallery');
            }
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

        $this->addInventoryForProduct($request->inventories, $product, $request->tax_status);

        return $product;
    }

    public function update($request, $product)
    {


        if ($product->imagesUrl == null) {

            if (strpos($request->body, 'src') !== false) {
                preg_match_all('@src="([^"]+)"@', $request->body, $match);

                $request->request->add(['imagesUrl' =>  $match[1]]); //add request
            }
        } else {
            //check if image on body was inserted
            if (strpos($request->body, 'img') !== false) {
                //fatch url from img
                preg_match_all('@src="([^"]+)"@', $request->body, $match);

                //check if fatch url and exist url get diffrent  and return link
                $result = array_diff($product->imagesUrl, $match[1]);
                // return (['result' => $result, '$match' => $match[1], 'imagesUrl' => $product->imagesUrl]);

                //get link from result and delete
                foreach ($result as $imgurl) {
                    $path = str_replace('"', '', $imgurl);
                    Storage::delete('/public' . $path);
                }
                //set agin img to imageUrl for ckeck
                $request->request->add(['imagesUrl' =>  $match[1]]); //add request
            }
        }


        $product->update($request->all());

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


        foreach ($request->inventories as $inventory) {
            $oldInventory = Inventory::find($inventory['id']);
            $result = changeFinalPrice($oldInventory, $inventory, $request->tax_status);
            $oldInventory->update([
                'color' => $inventory['color'],
                'size' => $inventory['size'],
                'final_price' => $result['final_price'],
                'discount' => $result['discount'],
                'min_quantity' => $inventory['min_quantity'],
                'price' => $inventory['price'],
                'quantity' => $inventory['quantity'],
            ]);
        }


        return $product;
    }



    public function syncTags($request, $product)
    {
        $product->syncTags($request->productTags);
    }

    public function syncCategories($request, $product)
    {

        $category = [];
        foreach ($request->categories as $key => $category_id) {
            $category[$key] = Category::findById($category_id);
        }

        $product->syncCategories($category);
    }

    public function syncDownloads($links, $product)
    {
        foreach ($product->downloads as $download) {
            $download->delete();
        }
        foreach (json_decode($links, true) as $link) {
            $product->downloads()->create($link);
        }
    }


    public function attachAttributesToProduct($attributes, $product)
    {

        $collection = collect($attributes);

        $collection->each(function ($item) use ($product) {

            if (is_null(json_decode($item, true)['key']) || is_null(json_decode($item, true)['value'])) return;

            $attr = Attribute::firstOrCreate(['key' => json_decode($item, true)['key']]);

            $attr_value = $attr->values()->firstOrCreate(['value' => json_decode($item, true)['value']]);


            $product->attributes()->detach($attr->id, ['value_id' => $attr_value->id]);
            $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
        });
    }

    public function addExtraDataToProductCollection($productData, $single = false)
    {

        if ($single) {

            $images = [];
            if ($productData->getFirstMedia('product-gallery')) {
                foreach ($productData->getMedia('product-gallery') as $key => $image) {
                    $images[$key] = $image->getFullUrl();
                }
            }
            $productData['images'] =  $images;
        } else {

            foreach ($productData as $product) {
                $images = [];
                if ($product->getFirstMedia('product-gallery')) {
                    foreach ($product->getMedia('product-gallery') as $key => $image) {
                        $images[$key] = $image->getFullUrl();
                    }
                }
                $product['images'] =  $images;
            }
        }
        if ($single) {
            $attributes = [];
            foreach ($productData->attributes as $key => $value) {

                $attributes[$key] = ['id' => $value->pivot->value->id, 'key' => $value->key, 'value' => $value->pivot->value->value];
            }

            $productData['attrs'] =  $attributes;
        }

        if ($single) {
            $productData['productTags'] = $productData->tags->pluck('name');

            $productData['category'] =  $productData->categories->pluck('id');
        }


        return $productData;
    }

    public function addInventoryForProduct($inventories, $product, $tax_status)
    {
        foreach ($inventories as $inventory) {
            if ($tax_status == 0) {
                $final_price = $inventory['price'];
            } else {
                $final_price = $inventory['price'] * 1.09;
            }
            $product->inventories()->create([
                'color' => $inventory['color'],
                'size' => $inventory['size'],
                'final_price' => $final_price,
                'min_quantity' => $inventory['min_quantity'],
                'price' => $inventory['price'],
                'quantity' => $inventory['quantity'],
            ]);
        }
    }

    public function updateInventoryForProduct($inventories, $product, $tax_status)
    {
    }

    public function filterProducts($per_page = 10)
    {

        $products = app(Pipeline::class)

            ->send(Product::query())

            ->through([
                Title::class,
            ])

            ->thenReturn()
            ->paginate($per_page);

        return $products;
    }
}
