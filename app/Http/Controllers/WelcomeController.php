<?php

namespace App\Http\Controllers;

use App\Blurb;
use App\Product;
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
//        return redirect(route('products.index'));
        $big_ads = Blurb::whereTarget(1)->orderBy('order', 'asc')->get();
        $sm_ads = Blurb::whereTarget(2)->orderBy('order', 'asc')->get();
        $big_hots = Blurb::whereTarget(3)->orderBy('order', 'asc')->get();
        $sm_hots = Blurb::whereTarget(4)->orderBy('order', 'asc')->get();

        $products = Product::where('ad_status','판매')
            ->where('is_old', false)
            ->orderBy('created_at', 'desc')
            ->forPage(1, 21)
            ->get();

        return view('home', compact('big_ads', 'sm_ads', 'big_hots', 'sm_hots', 'products'));
    }

    public function phpinfo() {
        return view('info');
    }

    public function useinfo() {
        return view('layouts.use');
    }

    public function privateinfo() {
        return view('layouts.private');
    }

}
