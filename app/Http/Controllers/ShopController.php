<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * 패밀리샵 리스트를 보여줌
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index(Request $request) {
        $states = \DB::table('shops')->distinct()->pluck('state');
        $select_state = $request->input('state');
        if (empty($select_state)) {
            $shops = Shop::all();
        } else {
            $shops = Shop::whereState($select_state)->get();
        }
        return view('shop.index', compact('shops', 'states'));
    }
}
