<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Order\Cart\Cart;
// use Modules\Order\Cart\Cart;
use Modules\Product\Entities\Product;


class CartController extends Controller
{

    /*

        public function create(Request $request)
        {

            $products = $request->products;

            foreach ($products as $item) {
                $item = json_decode($item, true);
                $product = Product::find($item['id']);

                $rowId = '#' . str_pad($product['id'], 8, "0", STR_PAD_LEFT) . uniqid(); // generate a unique() row ID

                $priceWithOutTax = $product['tax_status'] ? $product['final_price'] / 1.09 : $product['final_price'];
                $discount = $product['price'] - $priceWithOutTax;

                //check qty for product
                //check if product have price 

                // add the product to cart
                // $cart = \Cart::session(auth()->id())->add(array(
                //     'id' => $rowId,
                //     'name' => $product->title,
                //     'price' => $product->final_price,
                //     'quantity' => 1,
                //     'attributes' => array(
                //         // 'color'          => request('color'),
                //         // 'size'           => request('size'),
                //         // 'max'            => $product->inventories[$key]->qty,
                //         // 'min'            => $quantity,
                //         // 'image'          => $product->getFirstMedia('product-thumbs')->getFullUrl('xs'),
                //         'price' => $product->price,
                //         'tax' => $product->tax_status ?: 1.09,
                //         'discount' => $discount,
                //     ),
                //     'associatedModel' => $product
                // ));

                Cart::add([
                    'id' => $rowId,
                    'name' => $product['title'],
                    'qty' => 1,
                    'price' => $product['final_price'],
                    'weight' => 0,
                    'options' => [
                        // 'color'          => request('color'),
                        // 'size'           => request('size'),
                        // 'max'            => $product->inventories[$key]->qty,
                        // 'min'            => $quantity,
                        // 'image'          => $product->getFirstMedia('product-thumbs')->getFullUrl('xs'),
                        'price' => $product['price'],
                        'tax' => $product['tax_status'] ?: 1.09,
                        'discount' => $discount,
                        'associatedModel' => $product
                    ],
                ]);
            }

            return ResponderFacade::create();
        }

    */

    /*

        public function update(Request $request)
        {
            // \Cart::session(auth()->id())->update($request->rowId, [
            //     'quantity' => array(
            //         'relative' => false,
            //         'value' => $request->quantity,
            //     ),
            // ]);

            // return ResponderFacade::update();
        
            // Cart::setTax($rowId, 9);
            Cart::setGlobalTax(9);
            Cart::setGlobalDiscount(0);

            Cart::update($request->rowId, $request->quantity);
            return ResponderFacade::update();
        }

   */

    /*
     return response()->json([
            'cart' => Cart::content()
        ]);
    */

    /*

        public function updateCart(Request $request)
        {

            // return response()->json([
            //     'cart' => Cart::content()
            // ]);

        }
    
    */

    /*

        public function removeCart(Request $request)
        {

            Cart::remove($request->rowId);
            return response()->json([
                'cart' => Cart::content()
            ]);
            // \Cart::session(auth()->id())->remove($itemId);

            // return response()->json([
            //     'message' => 'محصول از سبد خرید حذف شد',
            //     'totalQuantity' => \Cart::session(auth()->id())->getTotalQuantity(),
            //     'cartItems'     => \Cart::session(auth()->id())->getContent()->toArray(),
            // ]);
        }

    */


    /*
            $rowId = '#' . str_pad($product['id'], 8, "0", STR_PAD_LEFT) . uniqid(); // generate a unique() row ID
            $cart = \Cart::session(auth()->id())->add(array(
                'id' => $rowId,
                'name' => $product->title,
                'price' => $product->final_price,
                'quantity' => 1,
                'attributes' => array(
                    'price' => $product->price,
                    'tax' => $product->tax_status ?: 1.09,
                    'discount' => $discount,
                ),
                'associatedModel' => $product
            ));

            return response()->json([
                'cart' => Cart::getContent()
            ]);
        */

    public function addToCart(Request $request)
    {

        $products = $request->products;

        foreach ($products as $item) {
            $product = Product::find($item['id']);
            $priceWithOutTax = $product['tax_status'] ? $product['final_price'] / 1.09 : $product['final_price'];
            $discount = $product['price'] - $priceWithOutTax;


            if (!Cart::has($product)) {
                Cart::add(
                    [
                        'name' => $product->title,
                        'price' => $product->price,
                        'quantity' => 1,
                        'inventory' => 5,
                        'discount' => $discount,
                        'tax' => $product['tax_status'] ?: 1.09,
                    ],
                    $product
                );
            }
        }

        return response()->json([
            'cart' => Cart::all()
        ]);
    }

    public function updateCart(Request $request)
    {


        // check qty  equal  or less then product qty
        //Cart::count()
        // qty not equal with zero

        $product = Product::find($request->id);
        Log::info(['Cart::has($product)' => Cart::has($product)]);
        if (Cart::has($product)) {
            Cart::update(
                $product,
                [
                    'quantity' =>  $request->orderQty,
                ]
            );
        }


        Log::info(['cart items' => Cart::all()]);
        return response()->json([
            'cart' => Cart::all()
        ]);
    }
}
