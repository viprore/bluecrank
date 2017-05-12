<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Item;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if (empty($request->input('items', []))) {
            $user = \Auth::user();
            $items = $user->carts->where('order_id', '=', null);
        }else{
            $items = Item::whereIn(
                'id',
                $request->input('items', [])
            )->get();
        }

        $order = new Order;

        return view('orders.create', compact('order', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {

        $list = explode(',',  $request->input('item_id_list'));
        $items = Item::find($list);

        $user = \Auth::user();

        $payload = [
            "user_id" => $user->id,
            "name" => $request->input('name'),
            "postcode" => $request->input('postcode'),
            "find_address" => $request->input('find_address'),
            "input_address" => $request->input('input_address'),
            "contact" => $request->input('contact'),
            "please" => $request->input('please'),
            "paymethod" => $request->input('paymethod'),
            "amount" => $request->input('amount')
        ];

        $order = Order::create($payload);

        foreach ($items as $item) {
            $item->order_id = $order->id;
            $item->save();
        }

        return redirect(route('orders.show', $order->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
