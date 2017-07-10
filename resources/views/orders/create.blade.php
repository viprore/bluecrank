@extends('layouts.app')

{{--@section('style')
    @parent
    <style>
        .padding-side {
            padding-left: 1em;
            padding-right: 1em;
            padding-bottom: 2em;
        }
    </style>
@endsection--}}

@section('content')
    @php
        $viewName = 'orders.index';
        $total_amount= 0;
        $itemIdList = '';
        $ship_method = 'toshop';


    @endphp




    <div class="page-header">
        <h3>
            주문서 작성
        </h3>
        <hr/>
    </div>

    <div class="container">
        <div class="row">
            <form id="ordrForm" action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="col-md-12">
                    <div class="panel-group" id="panel-754737">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="panel-title" data-toggle="collapse" data-parent="#panel-754737"
                                   href="#panel-element-43672">배송정보 입력</a>
                            </div>
                            <div id="panel-element-43672" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" {!! $ship_method == 'direct' ? 'class="active"' : '' !!}>
                                            <a href="#direct" aria-controls="direct"
                                               role="tab" data-toggle="pill" onclick="editShipMethod('direct')">직접배송</a>
                                        </li>
                                        <li role="presentation" {!! $ship_method == 'toshop' ? 'class="active"' : '' !!}>
                                            <a href="#toshop" aria-controls="toshop" role="tab"
                                               data-toggle="pill" onclick="editShipMethod('toshop')">인근매장으로 배송</a></li>
                                        <input type="hidden" id="shipmethod" name="shipmethod"
                                               value="{{ $ship_method }}">
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel"
                                             class="tab-pane fade {!! $ship_method == 'direct' ? 'in active' : '' !!}"
                                             id="direct">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th style="width:25%;padding-left:2em;">주소록</th>
                                                    <th>
                                                            <div class="btn-group" style="display:inline">
                                                                <button type="button"
                                                                        class="btn btn-default dropdown-toggle"
                                                                        data-toggle="dropdown" aria-expanded="false">
                                                                    직접입력 <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a href="#">직접입력</a></li>
                                                                    <li class="divider"></li>
                                                                    @forelse(\Auth::user()->ships as $ship)
                                                                        <li><a href="#"
                                                                               ship-id="{{ $ship->id }}">{{ $ship->alias }}</a>
                                                                        </li>
                                                                    @empty
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                            <div class="input-group col-xs-6 col-md-4">
                                                                <span class="input-group-addon" id="basic-addon1">
                                                                    <input type="checkbox" id="cb_save" name="ship_save">
                                                                </span>
                                                                <input type="text" class="form-control" disabled
                                                                       id="alias"
                                                                       name="alias"
                                                                       placeholder="주소록을 저장합니다"
                                                                       aria-describedby="basic-addon1">
                                                            </div>
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td style="width:25%;padding-left:2em;">이름</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="name" id="name"
                                                               value="{{ old('name', $order->name) }}">
                                                        {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td rowspan="3" style="width:25%;padding-left:2em;">주소</td>
                                                    <td>
                                                        <div class="form-inline">
                                                            <button type="button" id="postcodify_search_button"
                                                                    class="btn btn-default" style="display:inline">주소찾기
                                                            </button>
                                                            {{--<a id="modal-261803" href="#modal-container-261803" role="button"
                                                               class="btn btn-default"
                                                               data-toggle="modal">주소찾기</a>--}}
                                                            <input type="text"
                                                                   class="form-control disabled postcodify_postcode5"
                                                                   name="postcode"
                                                                   id="postcode"
                                                                   value="{{ old('postcode', $order->postcode) }}">
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text"
                                                               class="form-control disabled postcodify_address"
                                                               id="find_address"
                                                               name="find_address"
                                                               value="{{ old('find_address', $order->find_address) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text"
                                                               class="form-control disabled postcodify_extra_info"
                                                               id="input_address"
                                                               name="input_address"
                                                               value="{{ old('input_address', $order->input_address) }}">
                                                        {!! $errors->first('postcode', '<span class="form-error">:message</span>') !!}
                                                        {!! $errors->first('find_address', '<span class="form-error">:message</span>') !!}
                                                        {!! $errors->first('input_address', '<span class="form-error">:message</span>') !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:25%;padding-left:2em;">연락처</td>
                                                    <td><input type="text" class="form-control" id="contact"
                                                               name="contact"
                                                               value="{{ old('contact', $order->contact) }}">
                                                        {!! $errors->first('contact', '<span class="form-error">:message</span>') !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:25%;padding-left:2em;">요청사항</td>
                                                    <td><textarea class="form-control" rows="3" id="please"
                                                                  name="please"
                                                                  value="{{ old('please', $order->please) }}"></textarea>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel"
                                             class="tab-pane fade {!! $ship_method == 'toshop' ? 'in active' : '' !!}"
                                             id="toshop">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td style="width:25%;padding-left:2em;">매장선택</td>
                                                    <td>
                                                        <div class="form-inline">
                                                            <select id="states" class="form-control form-inline"
                                                                    onchange="makeModal()">
                                                                @foreach($states as $state)
                                                                    <option value="{{ $state }}">{{ $state }}</option>
                                                                @endforeach
                                                            </select>
                                                            <button type="button"
                                                                    class="btn btn-primary btn-sm form-inline"
                                                                    data-toggle="modal" data-target="#myModal">
                                                                매장선택
                                                            </button>
                                                        </div>


                                                    {{--<a class="btn btn-primary" href="#">검색 </a></td>--}}

                                                </tr>
                                                <tr>
                                                    <td style="width:25%;padding-left:2em;">매장정보</td>
                                                    <td>
                                                        <h4 id="shop_name">{{ old('postcode2', $order->postcode) ? old('postcode2', $order->postcode) : '매장정보 없음'  }}</h4>
                                                        <p id="shop_address">{{ old('find_address2', $order->find_address) ? old('find_address2', $order->find_address) : '상단에 매장선택을 이용하세요!'  }}</p>
                                                        {!! $errors->first('postcode2', '<span class="form-error">:message</span>') !!}
                                                        <input type="hidden" id="postcode2" name="postcode2"
                                                               value="{{ old('postcode2', $order->postcode) }}">
                                                        <input type="hidden" id="find_address2" name="find_address2"
                                                               value="{{ old('find_address2', $order->find_address) }}">
                                                        <input type="hidden" id="input_address2" name="input_address2"
                                                               value="{{ old('input_address2', $order->input_address) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:25%;padding-left:2em;">이름</td>
                                                    <td>
                                                        <input type="text" id="name2" name="name2" class="form-control"
                                                               placeholder="홍길동"
                                                               value="{{ old('name2', $order->name) }}">
                                                        {!! $errors->first('name2', '<span class="form-error">:message</span>') !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:25%;padding-left:2em;">연락처</td>
                                                    <td>
                                                        <input type="text" id="contact2" name="contact2"
                                                               class="form-control"
                                                               placeholder="010-5882-7469"
                                                               value="{{ old('contact2', $order->contact) }}">
                                                        {!! $errors->first('contact2', '<span class="form-error">:message</span>') !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:25%;padding-left:2em;">요청사항</td>
                                                    <td><textarea name="please2" class="form-control" row="5"
                                                                  placeholder="완제품 조립 및 도착 후 피팅까지 부탁드립니다."
                                                                  value="{{ old('please2', $order->please) }}"></textarea>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="padding-side text-right">
                                            <div><p class="text-danger" id="validation-error"></p></div>
                                            <button type="button" class="btn btn-primary" onclick="formValidation()">
                                                다음
                                            </button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-754737"
                                   href="#panel-element-644507">구매상품 확인</a>
                            </div>
                            <div id="panel-element-644507" class="panel-collapse collapse">
                                <div class="panel-body">
                                    @forelse($items as $item)
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
                                        @php
                                            $total_amount += $item->option->product->price * $item->count;
                                            if($itemIdList == ''){
                                                $itemIdList .= $item->id;
                                            }else{
                                                $itemIdList .= ','.$item->id;
                                            }
                                        @endphp
                                    @empty
                                    @endforelse
                                    <div class="padding-side text-right">
                                        <div><p class="text-danger" id="validation-error"></p></div>
                                        <button type="button" class="btn btn-primary" data-toggle="collapse"
                                                data-parent="#panel-754737" data-target="#panel-element-15432">다음
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="panel-title" data-toggle="collapse" data-parent="#panel-754737"
                                   href="#panel-element-15432">결제수단/최종 확인</a>
                            </div>
                            <div id="panel-element-15432" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td style="width:25%;padding-left:2em;">
                                                상품금액
                                            </td>
                                            <td>
                                                {{ number_format($total_amount) }} 원
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:25%;padding-left:2em;">
                                                배송비
                                            </td>
                                            <td>
                                                @if($order->ship_fee == "무료")
                                                    0 원(무료)
                                                    <input type="hidden" name="ship_fee" value="무료">
                                                @else
                                                    <p id="ship_fee">{{ number_format(2500) }} 원(선결제)</p>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="ship_fee" id="shipFeeRadio1"
                                                               value="포함" checked>선결제
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="ship_fee" id="shipFeeRadio2"
                                                               value="착불"> 착불
                                                    </label>
                                                @endif
                                                <input type="hidden" id="products_price"
                                                       value="{{ $total_amount }}"/>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="width:25%;padding-left:2em;">
                                                결제예정금액
                                            </td>
                                            <td>
                                                <p id="total_amount">{{ number_format($order->ship_fee == "포함" ? $total_amount + 2500 : $total_amount) }}
                                                    원</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:25%;padding-left:2em;">결제수단</td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="paymethod" id="inlineRadio3"
                                                           value="신용카드" checked> 신용카드
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="paymethod" id="inlineRadio2"
                                                           value="계좌이체"> 계좌이체(에스크로)
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="paymethod" id="inlineRadio1"
                                                           value="무통장입금"> 무통장입금
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="account_form" style="display:none;">
                                            <td style="width:25%;padding-left:2em;">
                                                입금자명
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">
                                                        <input type="checkbox" id="cb_banker">
                                                    </span>
                                                    <input type="text" class="form-control"
                                                           id="banker"
                                                           name="banker"
                                                           placeholder="입금자명"
                                                           aria-describedby="basic-addon1"/>

                                                </div>
                                                <span class="form-error">받는 분과 동일하신 경우 체크</span>
                                            </td>
                                        </tr>
                                        <tr class="account_form" style="display:none;">
                                            <td style="width:25%;padding-left:2em;">
                                                입금은행
                                            </td>
                                            <td>
                                                <p>바이크아카데미학원(이상훈) 110-274-824505 (신한)</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <button type="submit" class="btn btn-block btn-primary" id="btn_acc"
                                                        style="display:none;">
                                                    결제하기
                                                </button>
                                                <button type="button" class="btn btn-block btn-primary" id="btn_pg">
                                                    결제하기
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="item_id_list" value="{{ $itemIdList }}">
                                    <input type="hidden" id="amount" name="amount"
                                           value="{{ $order->ship_fee == "포함" ? $total_amount + 2500 : $total_amount }}">
                                    <input type="hidden" id="merchant_uid" name="merchant_uid" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            {{-- PG용 --}}
            @if($items->count() == 1)
                <input type="hidden" id="good_name" value="{{ $items->first()-> option->product->ad_title }}"/>
            @else
                <input type="hidden" id="good_name"
                       value="{{ $items->first()-> option->product->ad_title . " 외 " . ($items->count()-1)  . '건'}}"/>
            @endif
            <input type="hidden" id="buyer_email" value="{{ \Auth::user()->email }}"/>


        </div>
    </div>


    <!-- 매장 모달 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">매장선택</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>매장명</th>
                            <th>매장주소</th>
                            <th>연락처</th>
                            <th>적용</th>
                        </tr>
                        </thead>
                        <tbody id="shoplist">
                        @foreach($shops as $shop)
                            <tr>
                                <td>{{ $shop->name }}</td>
                                <td>{{ $shop->address }}</td>
                                <td>{{ $shop->contact }}</td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="selectShop(this)">선택</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>
    <script src="https://service.iamport.kr/js/iamport.payment-1.1.5.js" type="text/javascript"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            var IMP = window.IMP;
            IMP.init('imp26813303');
            $('#btn_pg').click(function () {

                // 기타 정보
                $('#merchant_uid').val(init_orderid());
                var formData = $("#ordrForm").serialize();

                $.ajax({
                    type: "POST",
                    url: "/orders",
                    cache: false,
                    data: formData,
                    success: onSuccess,
                    error: onError
                });

            });

            $('input[type=radio][name=paymethod]').change(function () {
                if (this.value == '무통장입금') {
                    $('.account_form').show();
                    $('#btn_acc').show();
                    $('#btn_pg').hide();
                } else if (this.value == '계좌이체') {
                    $('.account_form').hide();
                    $('#btn_acc').hide();
                    $('#btn_pg').show();
                } else if (this.value == '신용카드') {
                    $('.account_form').hide();
                    $('#btn_acc').hide();
                    $('#btn_pg').show();
                }
            });

            $('input[type=radio][name=ship_fee]').change(function () {
                if (this.value == '포함') {
                    $total_amount = parseInt($('#products_price').val()) + 2500;
                    $('#ship_fee').text("2,500 원(선결제)");
                } else {
                    $total_amount = parseInt($('#products_price').val());
                    $('#ship_fee').text("0 원(착불)");
                }
                $('#total_amount').text(number_format($total_amount) + " 원");
                $('#amount').val($total_amount);
            });

            /*$("#states").select2({
             placeholder: "시/도"
             });*/

            $('#cb_save').change(function () {
                if ($('#cb_save').is(":checked")) {
                    $('#alias').prop('disabled', false)
                        .attr('placeholder', 'ex) 집, 회사');

                } else {
                    $('#alias').prop('disabled', true)
                        .attr('placeholder', '주소록을 저장합니다');

                }
            });

            $('#cb_banker').change(function () {
                if ($('#cb_banker').is(":checked")) {
                    var name = $('#name').val();
                    if (name.length < 1) {
                        name = $('#name2').val();
                    }
                    $('#banker').prop('disabled', false)
                        .val(name);

                } else {
                    $('#banker').val('');
                    $('#banker').prop('disabled', false)
                        .attr('placeholder', '입금하시는 분의 성함을 입력하세요');

                }
            });

            $('.dropdown-menu li a').click(function () {
                var shipId = $(this).attr('ship-id');

                $.ajax({
                    type: 'GET',
                    url: '/json/ships/' + shipId
                }).then(function (data) {
                    $('#name').val(data.name);
                    $('#postcode').val(data.postcode);
                    $('#find_address').val(data.find_address);
                    $('#input_address').val(data.input_address);
                    $('#contact').val(data.contact);
                });
            });


        });

        $(function () {
            $("#postcodify_search_button").postcodifyPopUp();
        });

        function makeModal() {
            var state = $('#states').val();
            $('#shoplist').empty();
            $.ajax({
                type: 'GET',
                url: '/shops/' + state
            }).then(function (data) {
                for (var i in data) {
                    $('#shoplist').append('<tr><td>' + data[i].name + '</td>' +
                        '<td>' + data[i].address + '</td>' +
                        '<td>' + data[i].contact + '</td>' +
                        '<td><button type="button" class="btn btn-success" onclick="selectShop(this)">선택</button></td></tr>')
                }
            });
        }

        function editShipMethod(method) {
            $('#shipmethod').val(method);
        }

        function selectShop(btnClick) {
            var selected_tr = btnClick.parentNode.parentNode;
            var childs = selected_tr.childNodes;
            var name = null;
            var address = null;
            var contact = null;

            var i = 0;
            while (contact == null) {
                if (childs[i].nodeName == 'TD') {
                    if (name == null) {
                        name = childs[i].textContent;
                    } else if (address == null) {
                        address = childs[i].textContent;
                    } else {
                        contact = childs[i].textContent;
                        break;
                    }
                }
                i++;
            }

            $('#shop_name').replaceWith("<h4 id='shop_name'>" + name + "(매장 연락처: " + contact + ")" + "</h4>");
            $('#shop_address').replaceWith("<p id='shop_address'>" + address + "</p>");
            $('#postcode2').val(name);
            $('#find_address2').val(address);
            $('#input_address2').val(contact);

            $('#myModal .close').click();

        }

        /* 주문번호 생성 예제 */
        function init_orderid() {
            var today = new Date();
            var year = today.getFullYear();
            var month = today.getMonth() + 1;
            var date = today.getDate();
            var time = today.getTime();

            if (parseInt(month) < 10) {
                month = "0" + month;
            }

            if (parseInt(date) < 10) {
                date = "0" + date;
            }

            var order_idxx = "BC" + year + "" + month + "" + date + "" + time;

            return order_idxx;
        }

        function onSuccess(order) {
            // 결제방식
            if (order.paymethod == '계좌이체') {
                var pay_method = 'trans';
            } else {
                var pay_method = 'card';
            }

//            alert(pay_method);

            IMP.request_pay({
                pg: 'html5_inicis',
                pay_method: pay_method,
                merchant_uid: order.merchant_uid,
                name: $('#good_name').val(),
                amount: order.amount,
                escrow: true,
                buyer_email: $('#buyer_email').val(),
                buyer_name: order.name,
                buyer_tel: order.contact,
                buyer_addr: order.find_address + ' ' + order.input_address,
                m_redirect_url: 'http://bluecrank.kr/payments/complete'
            }, function (rsp) {
                if (rsp.success) {
                    var url = 'http://bluecrank.kr/payments/complete?imp_uid=' + rsp.imp_uid + '&merchant_uid=' + rsp.merchant_uid;
                    $(location).attr('href', url);
                } else {
                    var str = "";
                    for (key in rsp) {
                        str += key + "=" + rsp[key] + "\n";
                    }

                    console.log(str);
                    alert('PG사 결제 에러');
                }
            });
        }

        function onError(data) {

            alert("서버 내부 에러입니다. 다시 시도해주세요.");
        }

        function formValidation() {
            if ($('#shipmethod').val() == 'direct') {
                var name = $('#name').val();
                var postcode = $('#postcode').val();
                var find_address = $('#find_address').val();
                var input_address = $('#input_address').val();
                var contact = $('#contact').val();
            } else {
                var name = $('#name2').val();
                var postcode = $('#postcode2').val();
                var find_address = $('#find_address2').val();
                var input_address = $('#input_address2').val();
                var contact = $('#contact2').val();
            }

            var errors = '';


            if (name == '') {
                if (errors == '') errors += '이름';
                else                errors += ', 이름';
            }
            if (postcode == '' || find_address == '' || input_address == '') {
                if (errors == '') errors += '주소정보';
                else                errors += ', 주소정보';
            }
            if (contact == '') {
                if (errors == '') errors += '연락처';
                else                errors += ', 연락처';
            }

            if (errors == '') {
                $('#panel-element-43672')
                    .collapse('hide');
                $('#panel-element-644507')
                    .collapse('show');

                $('#validation-error').text('');
            } else {
                $('#validation-error').text(errors + '란을 확인해주세요.');
            }


        }

        function logs(l) {
            if (typeof console == 'object') {
                var fctName = logs.caller && logs.caller.name || '전역';
                if (l instanceof Object) {
                    console.log('[' + fctName + ']');
                    console.log(l);
                } else {
                    console.log('[' + fctName + ']' + l);
                }
            }
        }

        function number_format(num, decimals, dec_point, thousands_sep) {
            num = parseFloat(num);
            if (isNaN(num)) return '0';

            if (typeof(decimals) == 'undefined') decimals = 0;
            if (typeof(dec_point) == 'undefined') dec_point = '.';
            if (typeof(thousands_sep) == 'undefined') thousands_sep = ',';
            decimals = Math.pow(10, decimals);

            num = num * decimals;
            num = Math.round(num);
            num = num / decimals;

            num = String(num);
            var reg = /(^[+-]?\d+)(\d{3})/;
            var tmp = num.split('.');
            var n = tmp[0];
            var d = tmp[1] ? dec_point + tmp[1] : '';

            while (reg.test(n)) n = n.replace(reg, "$1" + thousands_sep + "$2");

            return n + d;
        }


    </script>
@stop