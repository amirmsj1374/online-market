<?php

namespace Modules\Order\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\Cart;

use function PHPSTORM_META\map;

class CartService
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
            $this->userCartKey = 'cart-' . Str::random(10);
        }
    }

    public function identifyUser($userCartKey = null)
    {
        return $this->cart = Cache::get('cart-' . $userCartKey) ?? collect([]);
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


        // collection

        $this->cartItems->put($value['id'], $value);
        $this->cart->put($this->userCartKey, $this->cartItems);


        Cache::put('cart-' . $this->userCartKey, $this->cart, now()->addMinutes(60));

        return $this;
    }

    public function update($rowId, $options)
    {

        
        $cartItems = $this->cart[$this->userCartKey]->map(function ($cartItems) use ($rowId, $options) {

            if ($cartItems['id'] == $rowId) {

                //chnage product quantity
                if (is_numeric($options)) {
                    $cartItems['quantity'] = $options;
                }
                
                // can update color and size
                if (is_array($options)) {
                    $cartItems['quantity'] = $options['quantity'];
                }
            }

            return $cartItems;
        });

      

        unset($this->cart[$this->userCartKey]);
        Cache::forget($this->userCartKey);

         $this->cart->put($this->userCartKey, $cartItems);
        Cache::put('cart-' . $this->userCartKey, $this->cart, now()->addMinutes(60));


        return $this;
    }

    /**
     * check if product exist on the cart
     *
     * @param  mixed $key
     * @return void
     */
    public function has($key, $userCartKey =  null)
    {

        $this->createUserCartKey($userCartKey);
        $this->identifyUser($this->userCartKey);



        if ($key instanceof Model) {
            if ($this->cart->has($this->userCartKey)) {
                return !is_null(
                    $this->cart[$this->userCartKey]->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
                );
            } else {
                return !is_null(
                    $this->cart->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
                );
            }
        }

        // return !is_null(
        //     $this->cart[$this->userCartKey]->firstWhere('id', $key)
        // );
    }

    public function count($key)
    {
        if (!$this->has($key)) return 0;

        return $this->get($key)['quantity'];
    }

    public function get($key, $withRelationship = true)
    {

        $item = $key instanceof Model
            ? $this->cart[$this->userCartKey]->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            : $this->cart[$this->userCartKey]->firstWhere('id', $key);

        return $withRelationship ? $this->withRelationshipIfExist($item) : $item;
    }

    public function all()
    {

        $cart = $this->cart[$this->userCartKey]->map(function ($item) {

            return $this->withRelationshipIfExist($item);
        });

        return [
            'cart' => $cart,
            'userCartKey' => $this->userCartKey
        ];
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
