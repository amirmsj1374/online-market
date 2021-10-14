<?php

namespace Modules\Order\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Modules\Order\Entities\Cart;

class CartService
{

    protected $cart;
    protected $cartType;

    // protected $name = 'default';

    public function __construct()
    {
        $this->cart = Cache::get('cart') ?? collect([]);
    }

    //shoud return type of database or cashe to 
    public function cartStoreRecognizer()
    { 
        auth()->check()  ? $this->cartType ='database' : 'cache';
        
        // check if user auth store cart to data base or store to cashe 
        if ($this->cartType==='database') {
            $this->cart = Cart::where('identifier',auth()->id())->get() ?? collect([]);
        } else {
            $this->cart = Cache::get('cart') ?? collect([]);
        }
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
                'id' => Str::random(10)
            ]);
        }



        //cart is collection 
        $this->cart->put($value['id'], $value);
        
        Cache::put('cart', $this->cart, now()->addMinutes(60));
        return $this;
    }

    public function update($key, $options)
    {
        Log::info(['get' => $this->get($key, false)]);
        $item = collect($this->get($key, false));

        if (is_numeric($options)) {
            $item = $item->merge([
                'quantity' => $item['quantity'] + $options
            ]);
        }

        // add color and size
        if (is_array($options)) {
            $item = $item->merge([
                'quantity' => $options['quantity']
            ]);
        }

        $this->add($item->toArray());

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
        $item = $key instanceof Model
            ? $this->cart->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            : $this->cart->firstWhere('id', $key);
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

            //            session()->put($this->name , $this->cart);
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
