<?php

namespace Modules\Order\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class VueResponses
{

    public function index($order)
    {
        return response()->json([
            'items' => $order
        ], Response::HTTP_OK);
    }

    public function returnCartItems()
    {
        Log::info([
            'id y ID' => auth()->id(),
        ]);
        return response()->json(['cart' => \Cart::session(auth()->id())->getContent()->toArray()
        ], Response::HTTP_OK);
    }
}
