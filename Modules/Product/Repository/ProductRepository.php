<?php

namespace Modules\Product\Repository;

use AliBayat\LaravelCategorizable\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\Product;
use Modules\Product\Repository\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        $product = Product::with('categories', 'media')->orderBy('id', 'desc')->paginate(5);
        return $this->AddExtraDataToProductCollection($product);
    }

    /**
     * Show
     *
     * @return void
     */
    public function show(Product $product)
    {
        $product->load('downloads');
        return $this->AddExtraDataToProductCollection($product, true);
    }



    /**
     * Create
     *
     * @param  mixed $request
     * @return void
     */
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
            $this->syncDownloads($request, $product);
        }

        // update attributes of product
        if (!is_null($request->input('attributes'))) {
            $this->attachAttributesToProduct($request->input('attributes'), $product);
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
        $product->syncTags($request->productTags);
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
       
        $category = [];
        foreach ($request->categories as $key => $category_id) {
            Log::info(['category' => $category_id]);
            $category[$key] = Category::findById($category_id);
        }

        $product->syncCategories($category);
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

    public function AddExtraDataToProductCollection($productData, $single = false)
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
}
