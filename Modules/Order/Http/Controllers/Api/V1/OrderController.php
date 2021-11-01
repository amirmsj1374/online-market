<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\Order;
use Modules\Order\Facades\ResponderFacade;
use Modules\Order\Http\Requests\OrderRequest;

class OrderController extends Controller
{

    public function index()
    {
        $order = Order::orderBy('id', 'desc')->paginate(5);
        // Log::info(['order' => $order]);
        return  ResponderFacade::index($order);
    }


    public function create(OrderRequest $request)
    {
        $order = auth()->user()->orders()->create([
            'item_count' => count($request->cart),
            'status' => 'preparation',
            'final_price' => $request->payable,
            'payment_method' => 'zarinpal',
        ]);

        foreach ($request->cart as $key => $item) {

            $order->orderItems()->create([
                'inventory_id' => $item['inventory']['id'],
                'quantity' => $item['quantity'],
                'final_price' => $item['inventory']['final_price'],
                'price' => $item['inventory']['price'],
                'discount' => $item['inventory']['discount'] ?? 0,
                'color' => $item['inventory']['color'],
                'size' => $item['inventory']['size'],
            ]);
        }

        // dosent have zipcode
        $order->address()->create([
            'fullname' => $request['form']['fullname'],
            'address' => $request['form']['address'],
            'zipcode' => $request['form']['zipcode'],
            'city' => $request['form']['city'],
            'province' => $request['form']['province'],
            'phone' => $request['form']['phone'],
            'email' => $request['form']['email'],
        ]);

        return  ResponderFacade::create();
    }
}
