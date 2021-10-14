<?php

namespace Modules\Order\Http\Responses;

use Illuminate\Http\Response;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;

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

        //    return response()->json([
        //                 'message' => 'پایان موجودی در انبار',
        //                 'type'    => 'warning',
        //             ]);
        // return response()->json([
        //     'cart' => \Cart::session(auth()->id())->getContent()->toArray()
        // ], Response::HTTP_OK);
        Log::info(['create' =>  Cart::content()]);
        return response()->json([
            'cart' => Cart::content()
        ], Response::HTTP_OK);
    }

    public function update()
    {
        // Log::info([
        //     'returnCartItems' => \Cart::session(auth()->id())->getContent()->toArray(),
        //     'update' => auth()->id(),
        //     'cart' => \Cart::getContent(),
        // ]);
        
        // return response()->json([
        //     'cart' => \Cart::session(auth()->id())->getContent()->toArray()
        // ], Response::HTTP_OK);
        Log::info(['update' =>  Cart::content()]);
        return response()->json([
            'cart' => Cart::content()
        ], Response::HTTP_OK);
    }
}
