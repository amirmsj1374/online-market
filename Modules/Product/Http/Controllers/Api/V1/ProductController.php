<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\ProductRequest;
use Modules\Product\Facades\ProductRepositoryFacade;
use Modules\Product\Facades\ResponderFacade;

class ProductController extends Controller
{
    public function index()
    {
        $products = ProductRepositoryFacade::index();
        return ResponderFacade::index($products);
    }

    public function show(Product $product)
    {
        $product = ProductRepositoryFacade::show($product);
        return ResponderFacade::show($product);
    }

    public function create(ProductRequest $request)
    {
        ProductRepositoryFacade::create($request);
        return ResponderFacade::createSuccess();
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product = ProductRepositoryFacade::update($request, $product);
        return ResponderFacade::updateSuccess($product);
    }

    public function changeStatus(Product $product)
    {
        $product->update([
            'publish' => $product->publish === 0 ? 1 : 0
        ]);

        return ResponderFacade::changeStatus();
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return ResponderFacade::destroyProduct();
    }

    /*
    * check image if belongs to product and remove it
    * @return  void
    */
    public function deleteMedia(Request $request, Product $product)
    {
        foreach ($product->getMedia('product-gallery') as  $image) {
            if (in_array($image->getFullUrl(), $request->images)) {
                $image->delete();
            }
        }
    }

    public function filterProducts(Request $request)
    {
        $products = ProductRepositoryFacade::filterProducts($request);
        return ResponderFacade::filterProducts($products);
    }
}
