@extends('layouts.app')

@php
    $isMobile = checkMobile();
@endphp

@section('style')
    @parent
    <style>
        .py-3 {
            padding-top: 1em;
            padding-bottom: 1em;
        }

        .my-3 {
            margin-top: 1em;
            margin-bottom: 1em;
        }

        .w-100 {
            width: 100%;
        }

        .btn-secondary {
            background: #FFFFFF;
            border-color: #fff;
            line-height: 1.2;
        }

        .btn-danger {
            background: #c9333b;
            border-color: #c90919;
            line-height: 1.2;

        }

        .btn-warning {
            background: #049292;
            border-color: #047575;
            line-height: 1.2;
        }

        .btn-info2 {
            background: #f57336;
            border-color: #f56b24;
            line-height: 1.2;
        }

        .btn-counter {
            background: #ebebeb;
            border-color: #ebebeb;
            line-height: 1.2;
        }

    </style>
    <!-- 네이버 페이 스크립트 시작(헤더 파트) -->
    <script type="text/javascript"
            src="http://test-pay.naver.com/customer/js/{{ $isMobile ? 'mobile/' : '' }}naverPayButton.js"
            charset="UTF-8"></script>
    <script type="text/javascript">//<!CDATA[
        function buy_nc(url) {
            var formData = $("#selectOrdrForm").serialize();

            $.ajax({
                type: 'put',
                url: '/npay/carts',
                cache: false,
                data: formData,
                success: function (itemIds) {
                    if(itemIds) {
                        if(itemIds == "") {
                            alert('상품이 선택되지 않았습니다. \n다시 확인해주세요.');
                            location.reload();
                        }else {
                            location.href = '/npay/order/' + itemIds;
                        }
                    }else {
                        location.reload();
                    }
                },
                error: function () {
                    alert('Error');
                }
            });

            return false;
        }
        //]]></script>
    <!-- 네이버 페이 스크립트 끝(헤더 파트) -->
@stop

@section('content')
    @php $viewName = 'carts.index'; @endphp

    <div class="page-header">
        <h3>
            장바구니


        </h3>
    </div>

    <div class="container">
        @forelse($items as $item)
            <div class="item__group my-3">
                <div class="row my-3">
                    <div class="col-xs-4 align-self-center"><label><input item_id="{{ $item->id }}" type="checkbox"
                                                                          value="on" class="item__checkbox">
                            상품선택</label></div>
                    <div class="col-xs-8 text-right">
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteCart({{ $item->id }})">삭제
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="toggleWants({{ $item->id }})">
                            관심상품
                        </button>
                        <button type="button" class="btn btn-info btn-info2 btn-sm"
                                onclick="buyDirectly({{ $item->id }})">주문하기
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5"><img src="{{ $item->option->product->attachments->first()->url }}"
                                               class="w-100"></div>
                    <div class="col-xs-7">
                        <dl>
                            <dt>{{ $item->option->product->ad_title }}</dt>
                            <dd>색상 : {{ $item->option->color }} // 사이즈 : {{ $item->option->size }}</dd>
                            <dt>가격</dt>
                            <dd>{{ number_format($item->option->product->price) }}원</dd>
                        </dl>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-md-5 text-center">
                        <div class="btn-group" role="group" aria-label="수량">
                            <button type="button" class="btn btn-counter value-minus1" item-target="{{ $item->id }}">-
                            </button>
                            <button type="button" class="btn btn-secondary value1">{{ $item->count }}</button>
                            <button type="button" class="btn btn-counter value-plus1" item-target="{{ $item->id }}">+
                            </button>
                        </div>
                    </div>
                    <div class="col-md-7 text-right"> 합계 :
                        <b id="item_{{ $item->id }}_total">{{ number_format($item->option->product->price * $item->count) }}</b>
                        원
                    </div>
                </div>
            </div>
            <input type="hidden" class="prices" id="item_{{$item->id}}_price"
                   value="{{ $item->option->product->price }}"/>
            <input type="hidden" class="counts" id="item_{{$item->id}}_count" value="{{ $item->count }}"/>
            <hr/>
        @empty
            <p class="text-center text-danger">
                카트에 담긴 상품이 존재하지 않습니다
            </p>
        @endforelse
        <div class="row my-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-warning btn__select__all">전체선택</button>
                <button type="button" class="btn btn-info btn-info2 btn__delete__all">선택삭제</button>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-md-3">선택 상품 합계</div>
            @php
                $result = 0;
                foreach($items as $item){
                  $result += $item->option->product->price * $item->count;
                }

            @endphp
            <div class="col-md-9 text-right"><b id="total_price">{{ number_format($result) }}</b>원</div>
        </div>
        <div class="row my-3 text-center">
            <div class="col-md-12">
                <form id="selectOrdrForm" action="{{ route('carts.update') }}" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {!! method_field('PUT') !!}
                    <button type="submit" class="btn btn-secondary select__submit">선택상품주문</button>
                </form>
                <button type="button" class="btn btn-primary" onclick="buyAll()">전체상품주문</button>

            </div>
        </div>
        @if($currentUser ? $currentUser->isTester() : false)
            <div class="row">
                <div class="col-xs-12 text-center">
                    <script type="text/javascript">//<![CDATA[
                        naver.NaverPayButton.apply({
                            BUTTON_KEY: "C06715B6-5172-4A2C-8FC7-5C1F53CA9314",
                            TYPE: "{{ $isMobile ? 'MB' : 'A' }}", // 버튼 모음 종류 설정
                            COLOR: 1, // 버튼 모음의 색 설정
                            COUNT: 1, // 버튼 개수 설정. 구매하기 버튼만 있으면(장바구니 페이지) 1, 찜하기 버튼도 있으면(상품 상세 페이지) 2를 입력.
                            ENABLE: "{{ $items->count() > 0 ? 'Y' : 'N' }}", // 품절 등의 이유로 버튼 모음을 비활성화할 때에는 "N" 입력
                            BUY_BUTTON_HANDLER: buy_nc,
                            "": ""
                        });
                        //]]></script>
                </div>
            </div>
        @endif
    </div>

@stop
@section('script')
    <script>
        $(document).ready(function () {
            var checked_all = false;

            $('.item__checkbox').each(function (i, e) {
                e.checked = false;
            });

            $(".item__checkbox").change(function () {
                var item_id = this.getAttribute("item_id");
                var item_count = $('#item_' + item_id + '_count').val();
                var form = $('form').first();
                if ($(this).is(":checked")) {
                    $('<input>', {
                        type: 'hidden',
                        name: 'items[]',
                        value: item_id
                    }).appendTo(form);
                    $('<input>', {
                        type: 'hidden',
                        name: 'items_count[]',
                        itemId: item_id,
                        value: item_count
                    }).appendTo(form);
                } else {
                    $('input[name="items[]"][value="' + item_id + '"]').remove();
                    $('input[name="items_count[]"][itemId="' + item_id + '"]').remove();
                }
            });
            $(".btn__select__all").click(function () {
                var form = $('form').first();
                checked_all = !checked_all;
                $('.item__checkbox').each(function (i, e) {
                    var item_id = e.getAttribute("item_id");
                    var item_count = $('#item_' + item_id + '_count').val();
                    if (checked_all) {
                        $('<input>', {
                            type: 'hidden',
                            name: 'items[]',
                            value: item_id
                        }).appendTo(form);
                        $('<input>', {
                            type: 'hidden',
                            name: 'items_count[]',
                            itemId: item_id,
                            value: item_count
                        }).appendTo(form);
                    } else {
                        $('input[name="items[]"][value="' + item_id + '"]').remove();
                        $('input[name="items_count[]"][itemId="' + item_id + '"]').remove();
                    }

                    e.checked = checked_all;
                });

            });

            $(".btn__delete__all").click(function () {
                var items = '';
                $('input[name="items[]"]').each(function (i, e) {
                    if (items == '') {
                        items += e.getAttribute('value');
                    } else {
                        items += ',' + e.getAttribute('value');
                    }

                });

                if (items != '') {
                    $.ajax({
                        type: 'DELETE',
                        url: 'carts/' + items
                    }).then(function () {
                        location.reload();
                    });
                }
            });

        });

        function deleteCart(id) {
            var item_id = id;

            $.ajax({
                type: 'DELETE',
                url: 'carts/' + item_id
            }).then(function () {
                location.reload();
            })
        }

        function toggleWants(id) {
            $.ajax({
                _token: $('meta[name="csrf-token"]').attr('content'),
                type: 'POST',
                url: 'item/wants/' + id
            }).then(function () {
                location.reload();
            })
        }

        function buyDirectly(id) {
            var count = $('#item_' + id + '_count').val();

            $.ajax({
                _token: $('meta[name="csrf-token"]').attr('content'),
                type: 'PUT',
                url: 'carts',
                data: {
                    items: [id],
                    items_count: [count]
                }
            }).then(function (itemIds) {
                if (itemIds) {
                    location.href = '/orders/create?items[]=' + itemIds;
                } else {
                    location.reload();
                }
            });
        }

        $('.value-plus1').on('click', function () {
            var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10) + 1;
            divUpd.text(newVal);

            var itemId = $(this).attr('item-target');
            $("#item_" + itemId + "_count").val(newVal);

            var itemPrice = $("#item_" + itemId + "_price").val();
            var itemCount = $("#item_" + itemId + "_count").val();

            if($('input[name="items_count[]"][itemId="' + itemId + '"]')){
                $('input[name="items_count[]"][itemId="' + itemId + '"]').val(newVal)
            }

            $("#item_" + itemId + "_total").text(number_format(itemPrice * itemCount));

            calTotalPrice();
        });

        $('.value-minus1').on('click', function () {
            var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10) - 1;
            if (newVal >= 1) {
                divUpd.text(newVal);

                var itemId = $(this).attr('item-target');
                $("#item_" + itemId + "_count").val(newVal);

                var itemPrice = $("#item_" + itemId + "_price").val();
                var itemCount = $("#item_" + itemId + "_count").val();

                if($('input[name="items_count[]"][itemId="' + itemId + '"]')){
                    $('input[name="items_count[]"][itemId="' + itemId + '"]').val(newVal)
                }

                $("#item_" + itemId + "_total").text(number_format(itemPrice * itemCount));

                calTotalPrice();
            }
        });

        function post_to_url(path, params, method) {
            method = method || "post"; // 전송 방식 기본값을 POST로


            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            //히든으로 값을 주입시킨다.
            for (var key in params) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }

            document.body.appendChild(form);
            form.submit();
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

        function calTotalPrice() {
            var total_price = 0;
            $('.prices').each(function (i, e) {
                var item_price = e.getAttribute("value");
                var item_count = e.nextSibling.nextSibling.getAttribute("value");

                total_price += item_price * item_count;
            });
            $('#total_price').text(number_format(total_price));

        }
        function buyAll() {
            var form = $('form').first();
            $('.item__checkbox').each(function (i, e) {
                e.checked = false;
            });

            /*$('.item__checkbox').checked = false;*/
            $('input[name="items[]"]').remove();
            $('input[name="items_count[]"]').remove();

            $('.btn__select__all').click();
            $('.select__submit').click();
        }


    </script>
@stop