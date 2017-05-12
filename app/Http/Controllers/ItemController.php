<?php

namespace App\Http\Controllers;

use App\Item;
use App\Option;
use App\User;
use Illuminate\Http\Request;

class ItemController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $items = $user->carts->where('order_id', '=', null);
        return view('carts.index', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option_id = $request->input('option_id');
        $count = $request->input('count');

        $option = Option::find($option_id);

        if ($this->checkInventory($option, $count)) {
            return response()->json([], 200, [], JSON_PRETTY_PRINT);
        } else {
            return response()->json([], 204, [], JSON_PRETTY_PRINT);
        }


    }



    /**
     * Update the specified resource in storage.
     *
     * @param  Item  $item
     * @param  int  $count
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {

        $this->authorize('update', $item);
        $item->update($request->all());

        return response()->json([], 204, [], JSON_PRETTY_PRINT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  @param  Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        flash('해당 상품이 삭제되었습니다');

        return response()->json([], 205, [], JSON_PRETTY_PRINT);
    }

    public function checkInventory(Option $option, int $count)
    {
        if ($option->inventory < $count) {
            flash('죄송합니다. 재고량이 부족합니다.', 'warning');
            return false;
        }

        $user = \Auth::user();
        $item = $user->carts
            ->where('order_id', '=', null)
            ->where('option_id', '=', $option->id);

        if ($item->first()) {
            flash('장바구니에 상품의 수량을 ' . $count . '개로 변경합니다.', 'info');
            $item->first()->update([
                'count' => $count,
            ]);
            return true;
        } else {
            Item::create([
                'user_id' => $user->id,
                'option_id' => $option->id,
                'count' => $count,
            ]);
            flash('카트에 상품이 담겼습니다.');
            return true;
        }
    }
}
