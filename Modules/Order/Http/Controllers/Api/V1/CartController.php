<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Cart\Cart;
use Modules\Product\Entities\Inventory;
use Modules\Product\Entities\Product;

class CartController extends Controller
{


    public function addToCart(Request $request)
    {


        $inventories = $request->inventories;

        foreach ($inventories as $item) {
            $inventory = Inventory::find($item['id']);
            $product = Product::find($item['product_id']);



            if (Cart::has($inventory)) {
                Cart::add(
                    [
                        'name' => $product->title,
                        'quantity' => 1,
                    ],
                    $inventory,
                );
            }
        }

        return response()->json([
            'data' => Cart::all()
        ]);
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
        if (!Cart::has($inventory, $request->userCartKey)) {
            Cart::update(
                $request->rowId,
                [
                    'quantity' =>  $request->orderQty,
                ],
                $request->inventoryId,
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

        if (!Cart::has($inventory, $request->userCartKey)) {
            Cart::delete($request->rowId, $request->itemId);
        }


        return response()->json([
            'data' => Cart::all()
        ], 200);
    }

    public function flush()
    {
        Cart::flush();

        return response()->json([
            'data' => Cart::all()
        ], 200);
    }
}
