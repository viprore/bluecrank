<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Say hello to visitors.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index() {
        return redirect(route('products.index'));
    }

    /**
     * Say hello to visitors.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function shop() {
        $shops = Shop::all();
        return view('shop.index');
    }

    /**
     * Set locale.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
//    public function locale()
//    {
//        $cookie = cookie()->forever('locale__myapp', request('locale'));
//
//        cookie()->queue($cookie);
//
//        return ($return = request('return'))
//            ? redirect(urldecode($return))->withCookie($cookie)
//            : redirect('/')->withCookie($cookie);
//    }
}
