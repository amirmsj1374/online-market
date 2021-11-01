<?php

namespace Modules\Order\Http\Responses;

use Illuminate\Http\Response;

class VueResponses
{

    public function index($order)
    {
        return response()->json([
            'items' => $order
        ], Response::HTTP_OK);
    }

    public function create()
    {
        return response()->json([
            'message' => 'سفارش با موفقیت در سیستم ثبت شد'
        ], Response::HTTP_OK);
    }
}
