<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Order\Cart\Cart;
use Modules\Product\Entities\Inventory;
// use Modules\Order\Cart\Cart;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{

    public function index()
    {
        # code...
    }

    public function addToCart(Request $request)
    {
        // Cache::flush();

        $inventories = $request->inventories;

        // if (!empty($request->inventories)) {
        foreach ($inventories as $item) {

            $inventory = Inventory::find($item['id']);
            $product = Product::find($item['product_id']);

            if (!Cart::has($inventory)) {
                Cart::add(
                    [
                        'name' => $product->title,
                        'price' => $inventory->price,
                        'final_price' => $inventory->final_price,
                        'discount' =>  $inventory->discount,
                        'tax' => $product->tax_status ? 0.09 : 0,
                        'quantity' => 1,
                        'max' => $inventory->quantity,
                        'color' =>  $inventory->color,
                        'size' =>  $inventory->size,
                    ],
                    $inventory,
                );
            }
        }

        return response()->json([
            'data' => Cart::all()
        ]);
        
        // }

        //delete all cart data

        // return response()->json([
        //     'cart' => Cart::all()
        // ]);
    }

    public function updateCart(Request $request)
    {

        Log::info(['is_null' => Cart::identifyUser($request->userCartKey)]);
        Log::info(['isEmpty' => Cart::identifyUser($request->userCartKey)]);
        if (is_null(Cart::identifyUser($request->userCartKey)) || Cart::identifyUser($request->userCartKey)->isEmpty()) {
            return response()->json([
                'message' => 'اطلاعات سبد خرید شما نامعتبر است سبد خرید جدید ایجاد کنید'
            ],400);
        }

      
        // check qty  equal  or less then product qty

        // Cart::count()
        //userCartKey
        // qty not equal with zero

        $inventory = Inventory::find($request->rowId);
     
       

        if (Cart::has($inventory,$request->userCartKey)) {
            // Cart::update(
            //     $inventory,
            //     [
            //         'quantity' =>  $request->orderQty,
            //     ]
            // );
        }


        return response()->json([
            'data' => Cart::all()
        ],200);
    }
}
