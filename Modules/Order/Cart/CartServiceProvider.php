<?php

namespace Modules\Order\Cart;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('cart', function () {
            if (Auth::check()) {

                return new CartDBService();
            } else {

                return new CartCacheService();
            }
        });
    }
}
