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
                    <div class="col-xs-4 align-self-center"><label><input id="{{ $item->id }}" type="checkbox"
                                                                          value="on" class="item__checkbox">
                            상품선택</label></div>
                    <div class="col-xs-8 text-right">
                        <button type="button" class="btn btn-danger btn-sm">삭제</button>
                        <button type="button" class="btn btn-warning btn-sm">관심상품</button>
                        <button type="button" class="btn btn-info btn-info2 btn-sm">주문하기</button>
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
                            <dd>{{ $item->option->product->price }}원</dd>
                        </dl>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-md-5 text-center">
                        <div class="btn-group" role="group" aria-label="수량">
                            <button type="button" class="btn btn-counter">-</button>
                            <button type="button" class="btn btn-secondary">{{ $item->count }}</button>
                            <button type="button" class="btn btn-counter">+</button>
                        </div>
                    </div>
                    <div class="col-md-7 text-right"> 합계 : <b>{{ ($item->option->product->price * $item->count) }}</b> 원
                    </div>
                </div>
            </div>
            <hr />
        @empty
            <p class="text-center text-danger">
                카트에 담긴 상품이 존재하지 않습니다
            </p>
        @endforelse
        <div class="row my-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-warning btn__select__all">전체선택</button>
                <button type="button" class="btn btn-info btn-info2 btn__delete">선택삭제</button>
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
            <div class="col-md-9 text-right"><b>{{ $result }}</b>원</div>
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
        $(document).ready(function(){
            $(".item__checkbox").change(function(){
                var item_id = this.getAttribute("id");
                var form = $('form').first();
                if($(".item__checkbox").is(":checked")){
                    $('<input>', {
                        type: 'hidden',
                        name: 'items[]',
                        value: item_id
                    }).appendTo(form);
                }else{
                    $('input[name="items[]"][value="' + item_id + '"]').remove();
                }
            });
            $(".btn__select__all").click(function (){
                $(".item__checkbox").attr('checked', true);
            });

            $(".btn__delete__all").click(function (){
                // TODO :: 아약스 카트 삭제 이벤트
            });
        });
    </script>
@stop