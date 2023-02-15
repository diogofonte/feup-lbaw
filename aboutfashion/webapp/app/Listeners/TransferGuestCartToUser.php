<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferGuestCartToUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        if(Auth::guard('admin')){
            return;
        }

        $guestCart = Session::get('cart');
        if (is_null($guestCart)) {
            return;
        }

        $controller = new \App\Http\Controllers\ShoppingCartController;

        foreach ($guestCart as $product) {
            $controller->addProductAuth($product['id_product'], $product['id_color'], $product['id_size'], 1);
        }

        Session::forget('cart');
    }
}