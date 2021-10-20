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
            'cart' => Cart::all()
        ]);
        // }

        //delete all cart data

        // return response()->json([
        //     'cart' => Cart::all()
        // ]);
    }

    public function updateCart(Request $request)
    {

        Log::info(['$re' =>  $request->all()]);
        // check qty  equal  or less then product qty
        // Cart::count()
        // qty not equal with zero

        $inventory = Inventory::find($request->rowId);
        Log::info(['$inventory' =>  $inventory]);
        Log::info(['$has' =>  Cart::has($inventory)]);


        if (Cart::has($inventory)) {
            Cart::update(
                $inventory,
                [
                    'quantity' =>  $request->orderQty,
                ]
            );
        }


        return response()->json([
            'cart' => Cart::all()
        ]);
    }
}
