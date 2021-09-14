<?php

namespace Modules\Discount\Http\Responses;

use Illuminate\Http\Response;

class VueResponses
{
    public function index($discount)
    {
        return response()->json(
            [
                'discount' => $discount
            ],
            Response::HTTP_OK
        );
    }

    public function filterProduct($products)
    {
        return response()->json(
            [
                'data' => $products
            ],
            Response::HTTP_OK
        );
    }

    public function filtercategories($categories)
    {
        return response()->json(
            [
                'data' => $categories
            ],
            Response::HTTP_OK
        );
    }

    public function filterUser($users)
    {
        return response()->json(
            [
                'data' => $users
            ],
            Response::HTTP_OK
        );
    }

    public function discountSuccessCreate()
    {
        return response()->json([
            'message' => 'تخفیف با موفقیت ثبت شد '
        ], Response::HTTP_OK);
    }

    public function show($discount)
    {
        return response()->json([
            'discount' => $discount
        ], Response::HTTP_OK);
    }

    public function discountUpdateCondition()
    {
        return response()->json([
            'message' => 'ویرایش تخفیفات در حال اجرا میسر نمی باشد'
        ], Response::HTTP_OK);
    }

    public function updateSuccess()
    {
        return response()->json([
            'message' => 'تخفیف ویرایش شد '
        ], Response::HTTP_OK);
    }

    public function destroyDiscount()
    {
        return response()->json([
            'message' => 'اطلاعات تخفیف حذف شد'
        ], Response::HTTP_OK);
    }
}
