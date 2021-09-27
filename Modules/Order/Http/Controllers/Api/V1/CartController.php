<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Order\Facades\ResponderFacade;
use Modules\Product\Entities\Product;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('order::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {

        \Cart::session(auth()->id())->clear();

        foreach ($request->products as $item) {

            $product = Product::find($item['id']);

          
            $rowId = '#' . str_pad($product->id, 8, "0", STR_PAD_LEFT) . uniqid(); // generate a unique() row ID
          


            $priceWithOutTax = $product->tax_status ? $product->final_price / 1.09 : $product->final_price;
            $discount = $product->price - $priceWithOutTax;

            // add the product to cart
            \Cart::session(auth()->id())->add(array(
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
        }

        return ResponderFacade::create();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('order::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('order::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    // public function updateCart(Type $var = null)
    // {
    //     # code...
    // }
}
