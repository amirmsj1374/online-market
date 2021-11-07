<?php

namespace Modules\Order\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\Cart;


class CartDBService
{

    protected $cart;
    protected $userCartKey;
    protected $cartItems;

    public function __construct()
    {
        $this->cartItems = collect([]);
    }

    public function createUserCartKey($userCartKey)
    {
        if ($userCartKey || $this->userCartKey) {
            if ($userCartKey) {
                $this->userCartKey = $userCartKey;
            }
        } else {
            $this->userCartKey = auth()->id();
        }
    }

    public function identifyUser($userCartKey = null)
    {
        if (Cache::get('cart-' . $userCartKey)) {
            $this->switchCartMode();
        }

        return $this->cart = Cart::where('user_id', auth()->id())->get() ?? collect([]);
    }

    /**
     * @param array $value
     * @param null $obj
     * @return $this
     */
    public function add(array $value, $model = null)
    {


        if (!is_null($model) && $model instanceof Model) {

            $value = array_merge($value, [
                'subject_id' => $model->id,
                'subject_type' => get_class($model)
            ]);

            auth()->user()->carts()->firstOrCreate([
                'name' => $value['name'],
                'quantity' => $value['quantity'],
                'subject_id' =>  $value['subject_id'],
                'subject_type' => $value['subject_type']
            ]);
        } else {

            auth()->user()->carts()->firstOrCreate([
                'name' => $value['name'],
                'quantity' => $value['quantity'],
                'final_price' => $value['final_price'],
                'discount' => $value['discount'],
                'price' => $value['price'],
                'tax' => $value['tax'],
                'color' => $value['color'],
                'size' => $value['size'],
            ]);
        }
    }

    public function update($rowId, $options, $inventoryId = null)
    {

        $cart = auth()->user()->carts()->firstOrCreate();

        //chnage product quantity
        if (is_numeric($options)) {

            // $cart->cartItems()->where('inventory_id', $inventoryId)->update([
            //     'quantity' => $options
            // ]);

            $cart->where('subject_id', $inventoryId)->update([
                'quantity' => $options
            ]);
        }

        // can update color and size
        if (is_array($options)) {
            // $cart->cartItems()->where('inventory_id', $inventoryId)->update([
            //     'quantity' => $options['quantity']
            // ]);

            $cart->where('subject_id', $inventoryId)->update([

                'quantity' => $options['quantity']

            ]);
        }
    }

    /**
     * check if product exist on the cart
     *
     * @param  mixed $key
     * @return void
     */
    public function has($model, $userCartKey =  null)
    {
        $this->createUserCartKey($userCartKey);


        $this->identifyUser($this->userCartKey);

        if ($model instanceof Model) {

            if (auth()->user()->carts()->where('subject_id', $model->id)->count() > 0) {

                return false;
            }

            return true;
        }

        // else{
        //     if (auth()->user()->carts()->where('subject_id', $model->product_id)->count() > 0) {

        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
    }

    public function totalAmount($cart)
    {
        // Log::info(['cart' => $cart]);
        $sum = 0;
        $discount = 0;
        $payable = 0;
        foreach ($cart as $key => $item) {
            $sum += ($item->inventory->price * $item->quantity);
            $discount += ($item->inventory->discount * $item->quantity);
            $payable += ($item->inventory->final_price * $item->quantity);

        }

        return  [
            'sum' => $sum,
            'discount' => $discount,
            'payable' => $payable
        ];
    }

    public function all()
    {

        $cart = auth()->user()->carts()->get();

        $cart = $cart->map(function ($item) {

            return $this->withRelationshipIfExist($item);

        });


        $totalAmount = $this->totalAmount($cart);

        return [
            'cart' => $cart,
            'userCartKey' => auth()->user()->id,
            'sum' => $totalAmount['sum'],
            'discount' => $totalAmount['discount'],
            'payable' => $totalAmount['payable']
        ];
    }

    public function delete($rowId = null, $itemId)
    {
        auth()->user()->carts()->where('id', $itemId)->delete();

        return $this;
    }

    public function flushCashe()
    {

        unset($this->cart[$this->userCartKey]);

        Cache::forget($this->userCartKey);

        return $this;

    }


    public function flush()
    {
        Cart::where('user_id', auth()->id())->delete();

        return $this;
    }


    protected function withRelationshipIfExist($item)
    {
        if (isset($item['subject_id']) && isset($item['subject_type'])) {
            $class = $item['subject_type'];
            //    new inventory()->find(1)
            $subject = (new $class())->find($item['subject_id']);

            $item[strtolower(class_basename($class))] = $subject;

            unset($item['subject_id']);
            unset($item['subject_type']);

            return $item;
        }


        return $item;
    }

    public function switchCartMode()
    {
        $cart = Cache::get('cart-' . $this->userCartKey);
        foreach ($cart as $key => $item) {

            auth()->user()->carts()->create([
                'inventory_id' => $item->inventory_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'discount' => $item->discount,
                'price' => $item->price,
                'final_price' => $item->final_price,
                'color' => $item->color,
                'size' => $item->size,
            ]);
        }
        $this->flushCashe();
    }
}
