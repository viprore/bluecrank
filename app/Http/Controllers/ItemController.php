<?php

namespace App\Http\Controllers;

use App\Item;
use App\Option;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * 카트 내 아이템들을 보여준다
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $itemIds = explode(',', $this->setCart());
        $items = Item::whereIn('id', $itemIds)->get();

        return view('carts.index', compact('items'));
    }

    /**
     * 재고량 체크 후 Item 생성
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $option_id = $request->input('option_id');
        $count = $request->input('count');

        $option = Option::find($option_id);

        if ($option->stock >= $count) {
            // 카트에 해당 상품이 이미 존재하는지 확인
            $itemIds = explode(',', $this->setCart());
            $item = Item::whereIn('id', $itemIds)->where('option_id', $option_id)->first();

            if ($item) {
                $item->count = $count;
                $item->save();
                flash('장바구니 내 해당 상품의 수량을 변경');
            } else {
                $item = Item::create([
                    'option_id' => $option_id,
                    'count' => $count,
                    'expire_at' => Carbon::now()->addDays('+1'),
                ]);
                flash('장바구니에 상품을 담았습니다.');
            }

            $this->setExpireAndUserCart($item);

            if (isset($_COOKIE['carts'])) {
                $carts = $_COOKIE['carts'] . ',' . $item->id;
            } else {
                $carts = $item->id;
            }

            setcookie('carts', $carts);

            return response()->json($item, 200, [], JSON_PRETTY_PRINT);
        } else {
            flash('해당 상품의 재고가 부족합니다 <br />' .
                '재고량 : ' . $option->stock . '개');
            return response()->json([], 204, [], JSON_PRETTY_PRINT);
        }
    }

    /**
     * 해당하는 Item들을 제거
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($itemIds)
    {
        $items_temp = explode(',', $itemIds);

        $items = Item::whereIn('id', $items_temp)->get();

        $message = '';
        foreach ($items as $item) {
            $product = $item->option->product;
            $item->delete();
            $message .= '<a href="' . route('products.show', $product->id) . '">' . $product->ad_title . '</a><br />';
        }

        flash('아래 상품들이 장바구니에서 제거되었습니다.<br />' . $message);

        return response()->json([], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Item $item
     * @param  int $count
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $itemIds = $request->input('items', []);
        $items = Item::whereIn('id', $itemIds)->get();
        $counts = $request->input('items_count', []);

        $key = 0;
        $notEnoughMessage = '';
        foreach ($items as $item) {
            if ($item->option->stock >= $counts[$key]) {
                $item->count = $counts[$key];
                $item->save();
                $this->setExpireAndUserCart($item);
            } else {
                if ($notEnoughMessage == '') $notEnoughMessage = '해당 상품의 재고가 부족합니다 <br />';
                $notEnoughMessage .= '[' . $item->option->product->ad_title . '] 재고 : ' . $item->option->stock . '개 <br />';
            }
            $key++;
        }

        if (empty($notEnoughMessage)) {
            return response()->json($itemIds, 200, [], JSON_PRETTY_PRINT);
        } else {
            flash($notEnoughMessage, 'warning');
            if (str_contains($request->url(), 'npay')) {
                return response()->json([], 204, [], JSON_PRETTY_PRINT);
            }else{
                return redirect()->back();
            }
        }
    }


    /* 컨트롤러 헬퍼 */
    /**
     * 카트내 Item들의 유효성 검사 후 리턴
     *
     * @return string
     */
    public function setCart()
    {
        $carts = '';
        // 회원일 경우 계정에 귀속된 carts를 불러온다.
        if (\Auth::check()) {
            $user = \Auth::user();
            $carts = implode(',', $user->carts->pluck('id')->all());
        }

        // 쿠키에 쓰여진 carts를 불러온다.
        if (isset($_COOKIE['carts'])) {
            if ($carts == '') $carts = $_COOKIE['carts'];
            else                $carts .= ',' . $_COOKIE['carts'];
        }

        // carts의 배열화 > 중복 제거 > implode
        $itemIds = explode(',', $carts);
        sort($itemIds);
        $itemIds = array_unique($itemIds);


        // 카트 유효성 검사(만료일, 재고, 주문서 연결 여부)
        $newCart = '';
        $notEnoughMessage = '';
        foreach ($itemIds as $itemId) {
            // 아이템이 있는가?
            if ($item = Item::find($itemId)) {
                // 만료일 점검 및 수량 체크
                if ($item->expire_at > Carbon::now() && ($item->option->stock >= $item->count)) {
                    // 주문서에 등록된 아이템인가?
                    if ($item->order) {
                        // 완료된 주문서에 등록되지 않은 아이템인가?
                        if ($item->order->status == '작성중') {
                            $newCart == '' ? $newCart .= $item->id : $newCart .= ',' . $item->id;
                            // 만료일 재설정 및 계정 귀속
                            $this->setExpireAndUserCart($item);
                        } else {
                            // 주문서에 넘어간 품목이 카트에 있을 경우 계정 귀속을 풀어준다.
                            $item->user_id = null;
                            $item->save();
                        }
                    } else {
                        $newCart == '' ? $newCart .= $item->id : $newCart .= ',' . $item->id;
                        $this->setExpireAndUserCart($item);
                    }
                } else {
                    // 만료일이 지나거나 부족한 수량의 품목을 삭제한다.
                    if ($notEnoughMessage == '') {
                        $notEnoughMessage = '아래 상품들이 만료일, 재고부족으로 삭제되었습니다.<br />';
                    }
                    $notEnoughMessage .= '<a href="' . route('products.show', $item->option->product->id) . '">'
                        . $item->option->product->ad_title . '</a>';

                    $item->delete();
                }
            }
        }

        if (!empty($notEnoughMessage)) {
            flash($notEnoughMessage, 'warning');
        }

        // 리스트는 쿠키에 쓰고 관련 items를 리턴
        setcookie('carts', $newCart);
        return $newCart;
    }

    /**
     * 로그인 중일 경우 Item을 계정에 귀속 및 만료일을 증가시킨다
     *
     * @param Item $item
     */
    public function setExpireAndUserCart(Item $item)
    {
        if (\Auth::check()) {
            $item->user_id = \Auth::user()->id;
            $item->expire_at = Carbon::now()->addDays('+30');
            $item->save();
        } else {
            $item->expire_at = Carbon::now()->addDays('+1');
            $item->save();
        }
    }
}
