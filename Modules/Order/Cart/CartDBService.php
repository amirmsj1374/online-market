<?php

namespace Modules\Order\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
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
        return $this->cart = Cart::where('user_id', auth()->id())->with('cartItems')->get() ?? collect([]);
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
                'id' => Str::random(10),
                'subject_id' => $model->id,
                'subject_type' => get_class($model)
            ]);
        } elseif (!isset($value['id'])) {

            $value = array_merge($value, [
                'id' => Str::random(10),
            ]);
        }

        $cart = auth()->user()->cart()->firstOrCreate();
        $cart->cartItems()->firstOrCreate([
            'inventory_id' => $value['inventory_id'],
            'name' => $value['name'],
            'quantity' => $value['quantity'],
            'discount' => $value['discount'],
            'price' => $value['price'],
            'final_price' => $value['final_price'],
            'color' => $value['color'],
            'size' => $value['size'],
            'subject_id' => $model->id,
            'subject_type' => get_class($model)
        ]);
    }

    public function update($rowId, $options, $inventoryId = null)
    {

        $cart = auth()->user()->cart()->firstOrCreate();
        //chnage product quantity
        if (is_numeric($options)) {
            $cart->cartItems()->where('inventory_id', $inventoryId)->update([
                'quantity' => $options
            ]);
        }

        // can update color and size
        if (is_array($options)) {
            $cart->cartItems()->where('inventory_id', $inventoryId)->update([
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

        return true;
    }

    public function all()
    {
        $cart = auth()->user()->cart->cartItems()->get();

        // $cart = $cart->map(function ($item) {

        //     return $this->withRelationshipIfExist($item);
        // });

        Log::info([
            'cart ma' => $cart
        ]);

        return [
            'cart' => collect(),
            'userCartKey' => auth()->user()->cart
        ];
    }

    public function flush()
    {

        unset($this->cart[$this->userCartKey]);

        Cache::forget($this->userCartKey);

        return $this;
    }


    protected function withRelationshipIfExist($item)
    {
        if (isset($item['subject_id']) && isset($item['subject_type'])) {
            $class = $item['subject_type'];
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
            auth()->user()->cart()->cartItems()->create([
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
        $this->flush();
    }
}
