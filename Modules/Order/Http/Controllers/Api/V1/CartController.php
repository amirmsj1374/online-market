<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Order\Cart\Cart;
use Modules\Product\Entities\Inventory;
use Modules\Product\Entities\Product;

class CartController extends Controller
{


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
                        'inventory_id'   => $inventory->id,
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

        if (is_null(Cart::identifyUser($request->userCartKey)) || Cart::identifyUser($request->userCartKey)->isEmpty()) {
            return response()->json([
                'message' => 'اطلاعات سبد خرید شما نامعتبر است سبد خرید جدید ایجاد کنید'
            ], 400);
        }


        // check qty  equal  or less then product qty

        // Cart::count()
        // qty not equal with zero

        $inventory = Inventory::find($request->inventoryId);

        if (Cart::has($inventory, $request->userCartKey)) {
            Cart::update(
                $request->rowId,
                [
                    'quantity' =>  $request->orderQty,
                ]
            );
        }


        return response()->json([
            'data' => Cart::all()
        ], 200);
    }

    public function delete(Request $request)
    {
        if (is_null(Cart::identifyUser($request->userCartKey)) || Cart::identifyUser($request->userCartKey)->isEmpty()) {
            return response()->json([
                'message' => 'اطلاعات سبد خرید شما نامعتبر است سبد خرید جدید ایجاد کنید'
            ], 400);
        }

        $inventory = Inventory::find($request->inventoryId);

        if (Cart::has($inventory, $request->userCartKey)) {
            $result = Cart::delete($request->rowId);
        }


        return response()->json([
            'data' => Cart::all()
        ], 200);
    }

    public function flush()
    {
        $result = Cart::flush();

        return response()->json([
            'data' => Cart::all()
        ], 200);
    }
}
