<?php

namespace App\Http\Controllers;

use App\Item;
use App\Option;
use App\Order;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function want(\App\Product $product)
    {
        $user = \Auth::user();

        if ($user->wantProducts()->find($product->id)) {
            $user->wantProducts()->detach($product->id);
            flash('해제');
        } else {
            $user->wantProducts()->attach($product->id);
            flash('등록');
        }

        return response()->json([], 200, [], JSON_PRETTY_PRINT);
    }

    public function cart(Option $option, $count)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            if ($option->inventory < $count) {
                flash('재고량보다 많은 수를 요청하셨습니다');
            }else{
                $item = $user->carts->where('option_id', '=', $option->id);

                if ($item->first()) {
                    $item->first()->update([
                        'count' => $count,
                    ]);
                    flash('기존 상품의 수량이 변경되었습니다.');
                } else {
                    Item::create([
                        'user_id' => $user->id,
                        'option_id' => $option->id,
                        'count' => $count,
                    ]);
                    flash('카트에 상품이 담겼습니다.');
                }

            }
        }

        return response()->json([], 200, [], JSON_PRETTY_PRINT);
    }

    /*public function mycart()
    {
        $user = \Auth::user();
        $items = $user->carts;
        return view('carts.index', compact('items'));
    }*/

    public function order()
    {
        $items = Item::all();

        $order = new Order;

        return view('orders.index', compact('order', 'items'));
    }
}
