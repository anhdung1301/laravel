<?php

namespace App\Providers;

use App\Cart;
use Illuminate\Support\ServiceProvider;
use App\ProductType;
use Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('header',function($view)
        {
            $loai_sp = ProductType::all();
            $view->with('loai_sp',$loai_sp);
//            $view->with(['loai_sp',$loai_sp, 'cart'=> Session::get('cart'),'product_cart'=>$cart->item,'totalPrice'=>$cart->totalPrice,'totalQty' =>$cart->totalPrice]);
        });

        view()->composer('header',function($view)
        {
            if(Session('cart')) {
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $view->with(['cart' => Session::get('cart'), 'product_cart' => $cart->items, 'totalPrice' => $cart->totalPrice, 'totalQty' => $cart->totalPrice]);
            }
        });

    }
}
