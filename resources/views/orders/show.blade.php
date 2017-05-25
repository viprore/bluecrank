@extends('layouts.app')

@section('content')
    @php $viewName = 'orders.index'; @endphp

    <div class="page-header">
        <h4>
            주문내역
        </h4>
    </div>

    <div class="inform">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">상품 정보</h3>
            </div>
            <div class="panel-body">
                @forelse($order->items as $item)
                    <div class="row">
                        <div class="col-xs-3">
                            <img src="{{ $item->option->product->attachments->first()->url }}"
                                 class="img-thumbnail w-100">
                        </div>
                        <div class="col-xs-9">
                            <dl>
                                <dt>{{ $item->option->product->ad_title }}</dt>
                                <dd>색상 : {{ $item->option->color }} // 사이즈
                                    : {{ $item->option->size }}</dd>
                                <dt>가격(수량 {{ $item->count }}개)</dt>
                                <dd>{{ $item->option->product->price * $item->count }}원</dd>
                            </dl>
                        </div>
                    </div>

                @empty
                @endforelse
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">배송 정보
                    @if($order->shipmethod == 'direct')
                        (직접배송)
                    @else
                        (인근매장으로 배송)
                    @endif
                </h3>
            </div>
            <div class="panel-body">

                <table class="table">
                    <tbody>
                    <tr>
                        <td>받으시는분</td>
                        <td>{{ $order->name }}</td>
                    </tr>

                    <tr>
                        <td>주소</td>
                        <td>
                            {!! "(" . $order->postcode . ")" . $order->find_address . "<br />" .$order->input_address !!}
                        </td>
                    </tr>
                    <tr>
                        <td>연락처</td>
                        <td>
                            {{ $order->contact }}
                        </td>
                    </tr>
                    <tr>
                        <td>요청사항</td>
                        <td><textarea class="form-control" rows="3" id="please"
                                      name="please"
                                      readonly>{{ $order->please }}</textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">결제 정보</h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>결제방법</td>
                            <td>{{ $order->paymethod }}</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td>결제금액</td>
                            <td>{{ $order->amount }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>상태</td>
                            <td>{{ $order->status }}</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--{{ dd($order) }}--}}





@stop