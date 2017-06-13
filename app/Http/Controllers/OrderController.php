<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Item;
use App\Order;
use App\Ship;
use App\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

//require_once('../../src/iamport.php');

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth::user();

        // 종료일 설정
        if (!empty($request->get('end_date'))) {
            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('end_date'));
        } else {
            $end_date = Carbon::now();
        }

        if (!empty($request->get('start_date'))) {
            $start_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
        } else {
            $start_date = $end_date->copy()->addMonths(-1);
        }


        $orders = $user->orders()->whereBetween('created_at', [$start_date, $end_date]);

        if (strpos($request->url(), 'cancel')) {
            $orders = $orders->whereIn('status', ['반품', '취소']);
        } else {
            $orders = $orders->whereIn('status', [
                '입금전',
                '입금완료',
                '배송준비',
                '배송중',
                '배송완료',
                '구매결정',
            ]);
        }


        $orders = $orders->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('orders.index', compact('orders'));
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
        } else {
            $items = Item::whereIn(
                'id',
                $request->input('items', [])
            )->get();
        }

        $order = new Order;
        $order->shipmethod = 'direct';

        // TODO :: 캐시에 박기(변경 별로 없으니)
        $states = \DB::table('shops')->distinct()->pluck('state');

        $shops = Shop::whereState('서울')->get();

        return view('orders.create', compact('order', 'items', 'states', 'shops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();

        // request 데이터 유효성검사 및 페이로드 생성
        $shipmethod = $request->input('shipmethod');

        if ($shipmethod == 'direct') {
            $this->validate($request, [
                'name' => ['required'],
                'postcode' => ['required'],
                'find_address' => ['required'],
                'input_address' => ['required'],
                'contact' => ['required'],
                'item_id_list' => ['required'],
                'paymethod' => ['required'],
                'amount' => ['required']
            ]);
            $name = $request->input('name');
            $postcode = $request->input('postcode');
            $find_address = $request->input('find_address');
            $input_address = $request->input('input_address');
            $contact = $request->input('contact');
            $please = $request->input('please');
            $banker = $request->input('banker');

            if ($request->input('ship_save') == 'on') {
                Ship::create([
                    "user_id" => $user->id,
                    "alias" => $request->input('alias'),
                    "name" => $request->input('name'),
                    "postcode" => $request->input('postcode'),
                    "find_address" => $request->input('find_address'),
                    "input_address" => $request->input('input_address'),
                    "contact" => $request->input('contact'),
                ]);
            }
        } else {
            $this->validate($request, [
                'name2' => ['required'],
                'postcode2' => ['required'],
                'find_address2' => ['required'],
                'input_address2' => ['required'],
                'contact2' => ['required'],
                'item_id_list' => ['required'],
                'paymethod' => ['required'],
                'amount' => ['required']
            ]);

            $name = $request->input('name2');
            $postcode = $request->input('postcode2');
            $find_address = $request->input('find_address2');
            $input_address = $request->input('input_address2');
            $contact = $request->input('contact2');
            $please = $request->input('please2');
            $banker = $request->input('banker');
        }
        $paymethod = $request->input('paymethod');
        $amount = $request->input('amount');

        $list = explode(',', $request->input('item_id_list'));
        $items = Item::find($list);

        $payload = [
            "user_id" => $user->id,
            "name" => $name,
            "postcode" => $postcode,
            "find_address" => $find_address,
            "input_address" => $input_address,
            "contact" => $contact,
            "please" => $please,
            "paymethod" => $paymethod,
            "amount" => $amount,
            "shipmethod" => $shipmethod,
            "baker" => $banker
        ];

        if (strpos($paymethod, '무통장') === false) {
            $payload = array_merge($payload, [
                "status" => '입금완료',
                "merchant_uid" => $request->input('merchant_uid')
            ]);
        }

//        dd($payload);

        $order = Order::create($payload);

        foreach ($items as $item) {
            $item->order_id = $order->id;
            $item->save();
        }

        event(new \App\Events\OrderEvent($order));
        flash()->success(
            '주문이 완료되었습니다.'
        );

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

    public function getCity($state)
    {
        $shops = Shop::whereState($state)->get();

        return response()->json($shops, 200, [], JSON_PRETTY_PRINT);
    }

    public function updateStatus(Request $request, $status, Order $order)
    {
//        $this->authorize('update', $order);
//        dd($request->input('message'), $status, $order);
        switch ($status) {
            case 'cancel':
                $order->status = '취소';
                $order->message = $request->input('message');
                $order->save();
                break;
            case 'checked':
                $order->status = '입금완료';
                $order->save();
                break;
            case 'prepare':
                $order->status = '배송준비';
                $order->save();
                break;
            case 'shipping':
                $order->status = '배송중';
                $order->ship_code = $request->input('shipcode');
                $order->save();
                break;
            case 'arrive':
                $order->status = '배송완료';
                $order->save();
                break;
            case 'confirm':
                $order->status = '구매결정';
                $order->save();
                break;
            case 'exchange':
                $order->status = '교환';
                $order->message = $request->input('message');
                $order->save();
                break;
            case 'return':
                $order->status = '반품';
                $order->message = $request->input('message');
                $order->save();
                break;
        }

        return response()->json('', 200, [], JSON_PRETTY_PRINT);

    }



    public function getByMerchangUid($id)
    {
        $iamport = new \Iamport(ENV('IMP_REST_API_KEY'), ENV('YOUR_IMP_REST_API_SECRET'));

        $result = $iamport->findByMerchantUID($id);
    }

}
