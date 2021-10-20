<?php

namespace Modules\Order\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Modules\Order\Entities\Cart;

use function PHPUnit\Framework\isEmpty;

class CartService
{

    protected $cart;
    protected $cartType;
    protected $userKey;
    protected $cartItems;

    public function __construct()
    {        $this->cartItems = collect([]);

    // $this->cart = Cache::get('cart') ?? collect([]);
    }

    public function createUserKey()
    {
        $this->userKey = $this->userKey ?? 'cart-' . Str::random(10);
    }

    public function identifyUser($userKey = null)
    {
       
        $this->cart = Cache::get('cart-' . $userKey) ?? collect([]);
    }

    /**
     * @param array $value
     * @param null $obj
     * @return $this
     */
    public function add(array $value, $obj = null)
    {


        if (!is_null($obj) && $obj instanceof Model) {

            $value = array_merge($value, [
                'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj)
            ]);
        } elseif (!isset($value['id'])) {

            $value = array_merge($value, [
                'id' => Str::random(10),
            ]);
        }


        // //cartItem is collection 
        // $cartItem = collect([]);

        $this->cartItems->put($value['id'], $value);

        //cart is collection 
        $this->cart->put($this->userKey, $this->cartItems);



        Cache::put('cart-' . $this->userKey, $this->cart, now()->addMinutes(60));

        return $this;
    }

    public function update($key, $options)
    {

        $cartItem = collect($this->get($key, false));

        if (is_numeric($options)) {
            $cartItem = $cartItem->merge([
                'quantity' => $cartItem['quantity'] + $options
            ]);
        }

        // add color and size
        if (is_array($options)) {
            $cartItem = $cartItem->merge([
                'quantity' => $options['quantity']
            ]);
        }

        $this->add($cartItem->toArray());

        return $this;
    }

    /**
     * check if product exist on the cart   
     *
     * @param  mixed $key
     * @return void
     */
    public function has($key)
    {

        $this->createUserKey();
        $this->identifyUser($this->userKey);

        if ($key instanceof Model) {
            return !is_null(
                $this->cart->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            );
        }

        return !is_null(
            $this->cart->firstWhere('id', $key)
        );
    }

    public function count($key)
    {
        if (!$this->has($key)) return 0;

        return $this->get($key)['quantity'];
    }

    public function get($key, $withRelationship = true)
    {
        Log::info(['cart data' => $this->cart]);
        $item = $key instanceof Model
            ? $this->cart->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            : $this->cart->firstWhere('id', $key);
        Log::info(['get item' => $item]);
        return $withRelationship ? $this->withRelationshipIfExist($item) : $item;
    }

    public function all()
    {
        $cart = $this->cart;
        $cart = $cart->map(function ($item) {
            return $this->withRelationshipIfExist($item);
        });

        return $cart;
    }

    public function delete($key)
    {
        if ($this->has($key)) {
            $this->cart = $this->cart->filter(function ($item) use ($key) {
                if ($key instanceof Model) {
                    return ($item['subject_id'] != $key->id) && ($item['subject_type'] != get_class($key));
                }

                return $key != $item['id'];
            });

            // session()->put($this->name , $this->cart);
            // $this->storeCookie();

            return true;
        }

        return false;
    }

    public function flush()
    {
        $this->cart = collect([]);
        $this->storeCookie();

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

    public function instance(string $name)
    {
        $this->cart = collect(json_decode(request()->cookie($name), true)) ?? collect([]);
        $this->name = $name;
        return $this;
    }

    protected function storeCookie(): void
    {
        Cookie::queue($this->name, $this->cart->toJson(), 60 * 24 * 7);
    }
}
