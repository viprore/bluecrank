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
                    @if(!empty($order->ship_code))
                        <thead>
                        <tr>
                            <th style="width:25%">운송장번호</th>
                            <th>{{ $order->ship_code }}</th>
                        </tr>
                        </thead>
                    @endif

                    <tbody>
                    <tr>
                        <td style="width:25%">받으시는분</td>
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
                                <dd>{{ number_format($item->option->product->price * $item->count) }}원</dd>
                            </dl>
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr>
                    @endif

                @empty
                @endforelse
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
                        <td style="width:25%">결제방법</td>
                        <td>{{ $order->paymethod }}</td>
                    </tr>
                    @if(str_contains($order->paymethod, '무통장'))
                        <tr>
                            <td>입금은행</td>
                            <td>바이크아카데미학원(이상훈) 110-274-824505 (신한)</td>
                        </tr>

                        <tr>
                            <td>입금자명</td>
                            <td>{{ $order->banker }}</td>
                        </tr>
                    @endif

                    <tr style="margin-top:10px;">
                        <td>상품금액</td>
                        <td>{{ number_format($order->ship_fee=='포함' ? $order->amount - 2500 : $order->amount) }} 원</td>
                    </tr>
                    <tr>
                        <td>배송비</td>
                        <td>{{ $order->ship_fee=='포함' ? '2,500 원' : '0 원' }}({{ $order->ship_fee }})</td>
                    </tr>
                    <tr>
                        <td>결제금액</td>
                        <td>{{ number_format($order->amount) }} 원</td>
                    </tr>
                    <tr>
                        <td>상태</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                    @if(!empty($order->message))
                        <tr>
                            <td>사유</td>
                            <td>{{ $order->message }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--{{ dd($order) }}--}}





@stop