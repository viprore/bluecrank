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
    public function shop(Request $request) {
        $states = \DB::table('shops')->distinct()->pluck('state');
        $select_state = $request->input('state');
        if (empty($select_state)) {
            $shops = Shop::all();
        } else {
            $shops = Shop::whereState($select_state)->get();
        }
        return view('shop.index', compact('shops', 'states'));
    }

    public function phpinfo() {
        return view('info');
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
