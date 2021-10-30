<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\Order;
use Modules\Order\Facades\ResponderFacade;

class OrderController extends Controller
{

    public function index()
    {
        $order = Order::orderBy('id', 'desc')->paginate(5);
        return  ResponderFacade::index($order);
    }


    public function create(Request $request)
    {
        $order = auth()->user()->orders()->create([
            'item_count' => count($request->cart),
            'status' => 'received',
            'final_price' => $request->payable,
            'payment_method' => 'zarinpal',
        ]);

        foreach ($request->cart as $key => $item) {
            $order->items()->create([
                'inventory_id' => $item->inventory->id,
                'quantity' => $item->quantity,
                'final_price' => $item->final_price,
                'price' => $item->price,
                'dicsount' => $item->dicsount,
                'color' => $item->color,
                'size' => $item->size,
            ]);
        }

        // dosent have zipcode
        $order->address()->create([
            'fullname' => $request->form->name,
            'address' => $request->form->address,
            'city' => $request->form->city,
            'province' => $request->form->province,
            'phone' => $request->form->phone,
            'email' => $request->form->email,
        ]);

    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
