<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\ProductRequest;
use Modules\Product\Facades\ProductRepositoryFacade;

class ProductController extends Controller
{
    public function index()
    {
        $products = ProductRepositoryFacade::index();

        return response()->json([
            'products' => $products,
        ], Response::HTTP_OK);
    }

    public function show(Product $product)
    {
        $product = ProductRepositoryFacade::show($product);

        return response()->json([
            'product' => $product,
        ], Response::HTTP_OK);
    }

    public function create(ProductRequest $request)
    {
        ProductRepositoryFacade::create($request);

        return response()->json([
            'message' => 'محصول با موفقیت ایجاد شد'
        ], Response::HTTP_CREATED);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product = ProductRepositoryFacade::update($request, $product);

        return response()->json([
            'product' => $product,
            'message' => 'محصول با موفقیت ویرایش شد'
        ], Response::HTTP_OK);
    }

    public function changeStatus(Product $product)
    {
        $product->update([
            'publish' => $product->publish === 0 ? 1 : 0
        ]);

        return response()->json([
            'product' => Product::all(),
            'message' => 'وضعیت محصول تغییر کرد'
        ], Response::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'محصول با موفقیت حذف شد'
        ], Response::HTTP_OK);
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
}
