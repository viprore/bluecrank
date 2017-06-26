@extends('layouts.app')

@section('style')
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
                            <button type="button" class="btn btn-counter value-minus1">-</button>
                            <button type="button" class="btn btn-secondary value1"
                                    id="item_{{ $item->id }}_count">{{ $item->count }}</button>
                            <button type="button" class="btn btn-counter value-plus1">+</button>
                        </div>
                    </div>
                    <div class="col-md-7 text-right"> 합계 :
                        <b>{{ number_format($item->option->product->price * $item->count) }}</b> 원
                    </div>
                </div>
            </div>
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
            <div class="col-md-9 text-right"><b>{{ number_format($result) }}</b>원</div>
        </div>
        <div class="row my-3 text-center">
            <div class="col-md-12">
                <form action="{{ route('orders.create') }}" method="GET" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-secondary select__submit">선택상품주문</button>
                </form>
                <form action="{{ route('orders.create') }}" method="GET" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-primary">전체상품주문</button>
                </form>

            </div>
        </div>
    </div>

@stop
@section('script')
    <script>
        $(document).ready(function () {
            var checked_all = false;
            $(".item__checkbox").change(function () {
                var item_id = this.getAttribute("item_id");
                var form = $('form').first();
                if ($(this).is(":checked")) {
                    $('<input>', {
                        type: 'hidden',
                        name: 'items[]',
                        value: item_id
                    }).appendTo(form);
                } else {
                    $('input[name="items[]"][value="' + item_id + '"]').remove();
                }
            });
            $(".btn__select__all").click(function () {
                var form = $('form').first();
                checked_all = !checked_all;
                $('.item__checkbox').each(function (i, e) {
                    var item_id = e.getAttribute("item_id");
                    if (checked_all) {
                        $('<input>', {
                            type: 'hidden',
                            name: 'items[]',
                            value: item_id
                        }).appendTo(form);
                    } else {
                        $('input[name="items[]"][value="' + item_id + '"]').remove();
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
                    post_to_url('/items/destroy/list', {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'items': items
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
            var count = $('#item_' + id + '_count').text();

            post_to_url('/direct/item', {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'item_id': id,
                'count': count
            });
        }

        $('.value-plus1').on('click', function () {
            var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10) + 1;
            divUpd.text(newVal);
        });

        $('.value-minus1').on('click', function () {
            var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10) - 1;
            if (newVal >= 1) divUpd.text(newVal);
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
    </script>
@stop