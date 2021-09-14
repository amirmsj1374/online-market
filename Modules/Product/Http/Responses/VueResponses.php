<?php

namespace Modules\Product\Http\Responses;

use Illuminate\Http\Response;
use Modules\Product\Entities\Product;

class VueResponses
{

    public function index($products)
    {
        return response()->json([
            'products' => $products,
        ], Response::HTTP_OK);
    }

    public function show($product)
    {
        return response()->json([
            'product' => $product,
        ], Response::HTTP_OK);
    }

    public function createSuccess()
    {
        return response()->json([
            'message' => 'محصول با موفقیت ایجاد شد'
        ], Response::HTTP_CREATED);
    }

    public function updateSuccess($product)
    {
        return response()->json([
            'product' => $product,
            'message' => 'محصول با موفقیت ویرایش شد'
        ], Response::HTTP_OK);
    }

    public function changeStatus()
    {
        return response()->json([
            'product' => Product::all(),
            'message' => 'وضعیت محصول تغییر کرد'
        ], Response::HTTP_OK);
    }

    public function destroyProduct()
    {
        return response()->json([
            'message' => 'محصول با موفقیت حذف شد'
        ], Response::HTTP_OK);
    }
}
