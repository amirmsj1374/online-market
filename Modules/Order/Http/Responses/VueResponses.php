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
   
}
