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
            'cart' => \Cart::session(auth()->id())->getContent()
        ], Response::HTTP_OK);
    }
}
