<?php

namespace App\Http\Controllers;

use App\Item;
use App\Option;
use App\ItemStack;
use App\Product;
use App\Src\SimpleXMLElementExtended;
use Illuminate\Http\Request;


class NPayController extends Controller
{
    /**
     * 네이버 페이용 주문 정보를 생성한다
     *
     * @param Request $request
     * @param $item_list
     * @param null $shipping_type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function makeOrder(Request $request, $item_list, $shipping_type = null)
    {
        $shopId = env('NAVER_SHOP_ID');
        $certiKey = env('NAVER_CERTI_KEY');

        $list = explode(',', $item_list);
        $items = Item::find($list);

        if (str_contains(url()->previous(), 'olds') || str_contains(url()->previous(), 'products')) {
            $item = $items->first();    // 이전 아이템
            $backUrl = url()->previous() . "?itemId=". $item->id;
        }else{
            $backUrl = route('carts.index');
        }

        $queryString = 'SHOP_ID=' . urlencode($shopId);
        $queryString .= '&CERTI_KEY=' . urlencode($certiKey);

        $queryString .= '&RESERVE1=&RESERVE2=&RESERVE3=&RESERVE4=&RESERVE5=';
        $queryString .= '&BACK_URL=' . $backUrl;
        $queryString .= '&SA_CLICK_ID=' . (isset($_COOKIE["NVADID"]) ? $_COOKIE["NVADID"] : ''); //CTS

        // CPA 스크립트 가이드 설치 업체는 해당 값 전달
        $queryString .= '&CPA_INFLOW_CODE=' . (isset($_COOKIE["CPAValidator"]) ? urlencode($_COOKIE["CPAValidator"]) : '');
        $queryString .= '&NAVER_INFLOW_CODE=' . (isset($_COOKIE["NA_CO"]) ? urlencode($_COOKIE["NA_CO"]) : '');

        $totalMoney = 0;

        foreach ($items as $item) {
            $product = $item->option->product;
            $opt = $item->option;

            $id = $product->id;
            $ec_mall_pid = $product->id;
            $name = $product->ad_title;
            $uprice = $product->price;
            $count = $item->count;
            $tprice = $uprice * $count;
            if ($opt->color == '`' || $opt->color == '-' || empty($opt->color)) {
                $option = "사이즈 : " . $opt->size;
            } else {
                $option = "색상 : " . $opt->color . " / 사이즈 : " . $opt->size;
            }

            $itemStack = new ItemStack($id, $ec_mall_pid, $uprice, $name, false, $tprice, $option, $count);
            $totalMoney += $tprice;
            $queryString .= '&' . $itemStack->makeQueryString();
        }

        $shippingType = !empty($shipping_type) ? $shipping_type : 'PAYED'; // 무료, 선불, 착불 : FREE, PAYED, ONDELIVERY

        if ($totalMoney >= 50000) {
            $shippingType = 'FREE';
            $shippingPrice = '0';
        } else {
            if ($shippingType == 'PAYED') {
                $shippingPrice = 2500;
            } else {
                $shippingPrice = 0;
            }
        }

        $queryString .= '&SHIPPING_TYPE=' . $shippingType;
        $queryString .= '&SHIPPING_PRICE=' . $shippingPrice;

        $totalPrice = (int)$totalMoney + (int)$shippingPrice;
        $queryString .= '&TOTAL_PRICE=' . $totalPrice;

        $logs = $queryString . "<br />\n";

        $req_addr = 'ssl://pay.naver.com';
        $req_url = 'POST /customer/api/order.nhn HTTP/1.1'; // utf-8
        // $req_url = 'POST /customer/api/CP949/order.nhn HTTP/1.1'; // euc-kr
        $req_host = 'pay.naver.com';
        $req_port = 443;
        $nc_sock = @fsockopen($req_addr, $req_port, $errno, $errstr);
        if ($nc_sock) {
            fwrite($nc_sock, $req_url . "\r\n");
            fwrite($nc_sock, "Host: " . $req_host . ":" . $req_port . "\r\n");
            fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=utf-8\r\n");
            //fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded;charset=CP949\r\n");
            fwrite($nc_sock, "Content-length: " . strlen($queryString) . "\r\n");
            fwrite($nc_sock, "Accept: */*\r\n");
            fwrite($nc_sock, "\r\n");
            fwrite($nc_sock, $queryString . "\r\n");
            fwrite($nc_sock, "\r\n");

            // get header
            $headers = "";
            $bodys = "";
            while (!feof($nc_sock)) {
                $header = fgets($nc_sock, 4096);
                if ($header == "\r\n") {
                    break;
                } else {
                    $headers .= $header;
                }
            }

            // get body
            while (!feof($nc_sock)) {
                $bodys .= fgets($nc_sock, 4096);
            }
            fclose($nc_sock);

            $resultCode = substr($headers, 9, 3);

            if ($resultCode == 200) {
                // success
                $orderId = $bodys;
            } else {
                // fail
                $logs .= $bodys;
            }
        } else {
            $logs .= "$errstr ($errno)<br />\n";
            exit(-1);
            //에러처리
        }


        //리턴받은 order_id로 주문서 page를 호출한다.
        if (isset($orderId)) {
            $logs .= ($orderId . "<br />\n");
        }
        $orderUrl = "https://" . (checkMobile() ? 'm.' : '') . "pay.naver.com/" . (checkMobile() ? 'mobile/' : '') . "customer/order.nhn";


        /*print_r(str_replace("&", "<br />", urldecode($queryString)));
        dd();*/

        return view('npay.order', compact('orderUrl', 'orderId', 'shopId', 'totalPrice', 'resultCode', 'logs'));
    }

    /**
     * 상품 정보 조회 요청(From NaverPay)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function itemInfo(Request $request)
    {
        $query = $request->getQueryString();
        $vars = array();
        foreach (explode('&', $query) as $pair) {
            list($key, $value) = explode('=', $pair);
            $key = urldecode($key);
            $value = urldecode($value);
            $vars[$key][] = $value;
        }

        $itemIds = $vars['ITEM_ID'];

        if (count($itemIds) < 1) {
            exit('ITEM_ID 는 필수입니다.');
        }

        $categories = config('project.categories');

        $xml_top = new SimpleXMLElementExtended('<response />');
        foreach ($itemIds as $itemId) {
            $product = Product::find($itemId);

            $xml = $xml_top->addChild('item');
            $xml->addAttribute('id', $itemId);
            $xml->addChildWithCDATA('name', $product->ad_title);
            $xml->addChild('url', route('products.show', $product->id));
            $xml->addChildWithCDATA('description', markdown($product->description));
            $xml->addChild('image', $product->attachments->first()->url);
            $xml->addChild('thumb', $product->attachments->first()->url);
            $xml->addChild('price', $product->price);

            $xml_option = $xml->addChild('options')->addChild('option');
            $xml_option->addAttribute('name', '색상/크기');
            $quantity = 0;
            foreach ($product->options as $option) {
                $quantity += $option->inventory;
                if ($option->color == '`' || $option->color == '-' || empty($option->color)) {
                    $xml_option->addChildWithCDATA('select', $option->size);
                } else {
                    $xml_option->addChildWithCDATA('select', $option->color . '/' . $option->size);
                }
            }
            $xml->addChild('quantity', $quantity);

            $xml_category = $xml->addChild('category');
            // 이거 한글로
            $xml_category->addChild('first', $categories[$product->category]['ko']);
        }

        // Print
        $dom = new \DOMDocument();
        $dom->loadXML($xml_top->asXML());
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->encoding = 'UTF-8';
        $formattedXML = $dom->saveXML();

        return \Response::make($formattedXML, '200')->header('Content-Type', 'application/xml');
    }

    /**
     * 네이버 페이용 찜하기 처리
     *
     * @param $item_list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function makeWish($item_list)
    {
        $shopId = env('NAVER_SHOP_ID');
        $certiKey = env('NAVER_CERTI_KEY');

        $queryString = 'SHOP_ID=' . urlencode($shopId);
        $queryString .= '&CERTI_KEY=' . urlencode($certiKey);
        $queryString .= '&RESERVE1=&RESERVE2=&RESERVE3=&RESERVE4=&RESERVE5=';

        $list = explode(',', $item_list);
        $items = Item::find($list);

        foreach ($items as $item) {
            $product = $item->option->product;
            $opt = $item->option;

            $uid = $product->id;
            $ec_mall_pid = $product->id;
            $name = $product->ad_title;
            $uprice = $product->price;
            $image = $product->attachments->first()->url;
            $thumb = $product->attachments->first()->url;
            $url = route('products.show', $product->id);
            $item_ws = new ItemStack($uid, $ec_mall_pid, $name, $uprice, true, $image, $thumb, $url);
            $queryString .= '&' . $item_ws->makeQueryString();
        }

        $logs = 'query : ' . $queryString . "<br>\n";


        $req_addr = 'ssl://pay.naver.com';
        $req_url = 'POST /customer/api/wishlist.nhn HTTP/1.1'; // utf-8
        // $req_url = 'POST /customer/api/CP949/wishlist.nhn HTTP/1.1'; // euc-kr

        $req_host = 'pay.naver.com';
        $req_port = 443;
        $nc_sock = @fsockopen($req_addr, $req_port, $errno, $errstr);

        if ($nc_sock) {
            fwrite($nc_sock, $req_url . "\r\n");
            fwrite($nc_sock, "Host: " . $req_host . ":" . $req_port . "\r\n");
            fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=utf-8\r\n");
            fwrite($nc_sock, "Content-length: " . strlen($queryString) . "\r\n");
            fwrite($nc_sock, "Accept: */*\r\n");
            fwrite($nc_sock, "\r\n");
            fwrite($nc_sock, $queryString . "\r\n");
            fwrite($nc_sock, "\r\n");

            $headers = "";
            $bodys = "";

            // get header
            while (!feof($nc_sock)) {
                $header = fgets($nc_sock, 4096);
                if ($header == "\r\n") {
                    break;
                } else {
                    $headers .= $header;
                }
            }
            // get body
            while (!feof($nc_sock)) {
                $bodys .= fgets($nc_sock, 4096);
            }
            fclose($nc_sock);

            $resultCode = substr($headers, 9, 3);

            if ($resultCode == 200) {
                // success
                // 한개일경우
                if ($items->count() > 1) {
                    $itemIds = trim($bodys);
                    $itemIdList = explode(",", $itemIds);
                } else {
                    $itemId = $bodys;
                }
            } else {
                // fail
                $logs .= $bodys;
            }
        } else {
            $logs .= "$errstr ($errno)<br>\n";
            log($logs);
            exit(-1);
            //에러처리
        }
        if (checkMobile()) {
            $wishlistPopupUrl = "https://m.pay.naver.com/mobile/customer/wishList.nhn";
        }else{
            $wishlistPopupUrl = "https://pay.naver.com/customer/wishlistPopup.nhn";
        }

        return view('npay.wish', compact('logs', 'itemId', 'itemIdList', 'shopId', 'wishlistPopupUrl', 'resultCode'));
    }
}
