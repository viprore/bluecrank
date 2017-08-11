<?php

namespace App\Http\Controllers;

use App\Blurb;
use App\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orders = Order::all();
        $dates = \DB::table('orders')
            ->select(\DB::raw('DATE(created_at) as created_date'))
            ->orderBy('created_date', 'desc')
            ->distinct()
            ->take(6)
            ->get();

        $summary = \DB::table('orders')
            ->select(\DB::raw('DATE(created_at) as created_date'),
                \DB::raw('COUNT(*) as order_count'),
                'status', \DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', $dates->last()->created_date)
            ->groupBy('created_date', 'status')
            ->get();

        $status_cnt = \DB::table('orders')
            ->select(\DB::raw('status, count(*) as status_count'))
            ->groupBy('status')
            ->get();

        return view('admin.index', compact('orders', 'dates', 'summary' , 'status_cnt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function status($slug)
    {
        $status = null;
        switch ($slug) {
            case 'deposit':
                $status = '입금전';
                break;
            case 'checked':
                $status = '입금완료';
                break;
            case 'prepare':
                $status = '배송준비';
                break;
            case 'shipping':
                $status = '배송중';
                break;
            case 'arrive':
                $status = '배송완료';
                break;
            case 'confirm':
                $status = '구매결정';
                break;
            case 'cancel':
                $status = '취소';
                break;
            case 'exchange':
                $status = '교환';
                break;
            case 'return':
                $status = '반품';
                break;
            case 'qna':
                return response("제작중");
                break;

        }


        $datas = Order::where('status', $status)
            ->orderBy('created_at', 'desc')->get();

//        $datas = Order::all();


        $status_cnt = \DB::table('orders')
            ->select(\DB::raw('status, count(*) as status_count'))
            ->groupBy('status')
            ->get();

//        dd($orders);


        return view('admin.status', compact('status_cnt', 'datas'));
    }

    public function statusPost(Request $request, Order $order, $slug)
    {
        switch ($slug) {
            case 'deposit':
                $next = '입금완료';
                break;
            case 'checked':
                $next = '배송준비';
                break;
            case 'prepare':
                $shipcode = $request->input('shipcode');
                if (empty($shipcode)) {
                    flash('운송장 번호가 없습니다');
                    return redirect(route('admin.orders.status', $slug));
                }
                $next = '배송중';
                break;
            case 'shipping':
                $next = '배송완료';
                break;
            case 'cancel':
                break;
            case 'exchange':
                break;
            case 'return':
                break;
        }
        if (!empty($next)) {
            $order->status = $next;
            flash('게시글 번호 ' . $order->id . '의 주문 상태가 ' . $next . '로 변경되었습니다');
        }

        if (!empty($shipcode)) {
            $order->ship_code = $shipcode;
        }
        $order->save();


        return redirect(route('admin.orders.status', $slug));
    }

    public function editMain()
    {
        $blurbs = Blurb::all();
        $status_cnt = \DB::table('orders')
            ->select(\DB::raw('status, count(*) as status_count'))
            ->groupBy('status')
            ->get();
        return view('admin.main', compact('blurbs', 'status_cnt'));
    }

    public function storeBlurb(Request $request)
    {
        $id = $request->input('id');

        $payload = [
            'type' => $request->input('type'),
            'order' => $request->input('order'),
            'link' => $request->input('link'),
            'title' => $request->input('title'),
            'text1' => $request->input('text1'),
            'text2' => $request->input('text2')
        ];

        $result_msg = '';
        if ($id) {
            $blurb = Blurb::find($id);
            $blurb->update($payload);
            $blurb->save();
            $result_msg .= '광고 수정';
        }else{
            $blurb = Blurb::create($payload);
            $result_msg .= '광고 생성';
        }

        if ($request->hasFile('files')) {
            $this->uploadFileWithBlurb($request, $blurb);
            $result_msg .= ' 및 파일 업로드';
        }

        $result_msg .= '을(를) 완료했습니다.';

        flash()->success($result_msg);

        return redirect()->back();
    }

    private function uploadFileWithBlurb(Request $request, $blurb)
    {
        $file = $request->file('files');
        $filename = str_random() . filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);

        $payload = [
            'filename' => $filename,
            'bytes' => $file->getClientSize(),
            'mime' => $file->getClientMimeType()
        ];

        $file->move(attachments_path(), $filename);

        if ($blurb->attachments()->first()) {
            $blurb->attachments()->first()->delete();
        }

        $blurb->attachments()->create($payload);

    }
}
