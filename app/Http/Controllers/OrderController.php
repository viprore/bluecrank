<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Item;
use App\Order;
use App\Payment;
use App\Ship;
use App\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

//require_once('../../src/iamport.php');

class OrderController extends Controller
{
    /**
     * 주문 내역 or 취소 내역 리스트
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function index(Request $request)
    {

        if (\Auth::check()) {
            $user = \Auth::user();
        }else{
            // TODO : 비회원일 경우 처리
           return route('sessions.create');
        }

        // 걸러내기
        // 1. 작성중인 주문서 중 Item이 연결되지 않은 주문서
        // 2. 작성중인 주문서 중 생성 후 1일이 경과한 주문서
        // TODO : 신용카드인데 입금전인 주문서 주기적으로 입금취소 처리
        $orders = $user->orders()->where('status', '작성중');
        foreach ($orders as $order) {
            if ($order->items->count() == 0 || ($order->created_at->addDays('+1') < Carbon::now())) {
                $order->delete();
            }
        }

        // 시작일, 종료일 쿼리 세팅
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

        // 주문내역 / 취소내역을 url로 구분
        if (str_contains($request->url(), 'cancel')) {
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
            flash('선택된 상품이 존재하지 않습니다.');
            return redirect()->back();
        } else {
            $items = Item::whereIn(
                'id',
                $request->input('items', [])
            )->get();
        }

        $items_price = 0;

        foreach ($items as $item) {
            $price = $item->option->product->price;

            $count = $item->count;
            $items_price += $price * $count;
        }



        $order = new Order;

        if($items_price >= 50000) $order->ship_fee = '무료';
        else                      $order->ship_fee = '포함';

        $order->shipmethod = 'toshop';

        $order->paymethod = '신용카드';

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
        /*dd($request->input());
        $user = \Auth::user();*/

        // 배송방법에 따른 유효성검사, 입력값 삽입
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
        } else {
            $this->validate($request, [
                'name2' => ['required'],
                'contact2' => ['required'],
                'item_id_list' => ['required'],
                'paymethod' => ['required'],
                'amount' => ['required'],
                'shop_id' => ['required']
            ]);

            $shop = Shop::find($request->input('shop_id'));

            $postcode = $shop->postcode;
            $find_address = $shop->address;
            $input_address = $shop->name;
            $shop_id = $shop->id;
            $name = $request->input('name2');
            $contact = $request->input('contact2');
            $please = $request->input('please2');
            $banker = $request->input('banker');
        }
        $paymethod = $request->input('paymethod');
        $amount = $request->input('amount');
        $ship_fee = $request->input('ship_fee');

        $payload = [
            "name" => $name,
            "postcode" => $postcode,
            "find_address" => $find_address,
            "input_address" => $input_address,
            "contact" => $contact,
            "please" => $please,
            "paymethod" => $paymethod,
            "amount" => $amount,
            "shipmethod" => $shipmethod,
            "ship_fee" => $ship_fee,
            "banker" => $banker,
            "status" => '입금전'
        ];

        // PG사 이용시 생성되는 상점 id 추가
        if (strpos($paymethod, '무통장') === false) {
            $payload = array_merge($payload, [
                "merchant_uid" => $request->input('merchant_uid')
            ]);
        }
        // 매장 배송일 경우 매장 id 추가
        if (!empty($shop_id)) {
            $payload = array_merge($payload, [
                "shop_id" => $shop_id
            ]);
        }

        $order = Order::create($payload);

        // 회원일 경우 계정에 주문서 귀속
        if (\Auth::check()) {
            $user = \Auth::user();
            $order->user_id = $user->id;
            $order->save();

            // 주문서 저장시 처리
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
        }


        $list = explode(',', $request->input('item_id_list'));
        $items = Item::find($list);
        foreach ($items as $item) {
            $item->order_id = $order->id;
            $item->save();
        }

        event(new \App\Events\OrderEvent($order));

        if (str_contains($paymethod, '무통장')) {


            flash()->success(
                '주문이 완료되었습니다.'
            );

            return redirect(route('orders.show', $order->id));
        } else {
            /*return redirect(route('orders.show', $order->id));*/
            // 아약스 요청으로 인해 응답에 order 오브젝트를 Json 반환
            return response()->json($order, 200, [], JSON_PRETTY_PRINT);
        }

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
     * TODO : Update the specified resource in storage.
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
     * TODO : Remove the specified resource from storage.
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
            case 'failed':
                $order->status = '작성중';
                $order->save();
                break;
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

    public function checkPayment(Request $request)
    {
        $iamport = new \Iamport(ENV('IMP_REST_API_KEY'), ENV('IMP_REST_API_SECRET'));
        $merchant_uid = $request->get('merchant_uid');

        $order = Order::where('merchant_uid', $merchant_uid)->first();

        if (empty($order)) {
            return response()->json("가맹점 내 해당 결제 정보가 없습니다.", 400, [], JSON_PRETTY_PRINT);
        } else {
            $result = $iamport->findByMerchantUID($merchant_uid);

            if ($result->success) {
                $payment_data = $result->data;

                if ($payment_data->status === "paid" && $payment_data->amount === $order->amount) {
                    $payload = [
                        'amount' => $payment_data->amount,
                        'apply_num' => $payment_data->apply_num,
                        'buyer_addr' => $payment_data->buyer_addr,
                        'buyer_email' => $payment_data->buyer_email,
                        'buyer_name' => $payment_data->buyer_name,
                        'buyer_tel' => $payment_data->buyer_tel,
                        'imp_uid' => $payment_data->imp_uid,
                        'merchant_uid' => $payment_data->merchant_uid,
                        'name' => $payment_data->name,
                        'paid_at' => date('Y-m-d H:i:s',$payment_data->paid_at),
                        'pay_method' => $payment_data->pay_method,
                        'receipt_url' => $payment_data->receipt_url,
                        'status' => $payment_data->status,
                    ];

                    $payment = Payment::create($payload);

                    $order = $payment->getOrder();

                    $order->status = "입금완료";
                    $order->save();

                    event(new \App\Events\OrderEvent($order));

                    return redirect(route('orders.show', $payment->getOrder()->id));
                } else {
                    foreach ($order->items as $item) {
                        $item->order_id = null;
                        $item->save();
                    }
                    $order->delete();

                    return response()->json("결제실패 또는 결제 금액 불일치 입니다.", 400, [], JSON_PRETTY_PRINT);
                }
            } else {
                return response()->json("아임포트 조회중 오류 발생", 400, [], JSON_PRETTY_PRINT);
            }
        }

    }

}
