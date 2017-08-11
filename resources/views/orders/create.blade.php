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
        $ship_method = old('shipmethod', $order->shipmethod);
        $itemIdList = implode(',', $items->pluck('id')->all());

        $total_amount= 0;
        foreach($items as $item){
            $total_amount += $item->option->product->price * $item->count;
        }
        if(str_contains(url()->previous(), 'secrets') && $currentUser->isStudent()){
            $total_amount = $total_amount * 0.9;
        }
    @endphp

    <div class="page-header">
        <h3>
            주문서 작성{{ (str_contains(url()->previous(), 'secrets') && $currentUser->isStudent()) ? '(교육생 전용)' : '' }}
        </h3>
    </div>

    <div class="container">
        <div class="row">
            <form id="ordrForm" action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="col-md-12">
                    <div class="panel-group" id="panel-container">
                        @if(!Auth::check())
                            @include('orders.partial.session')
                        @endif
                        @include('orders.partial.shipinfo', [$ship_method, $order])
                        @include('orders.partial.itemchk', $items)
                        @include('orders.partial.payment', [$total_amount, $order, $itemIdList])




                    </div>


                </div>
            </form>

            {{-- PG용 추가 데이터 --}}
            @if($items->count() == 1)
                <input type="hidden" id="good_name" value="{{ $items->first()-> option->product->ad_title }}"/>
            @else
                <input type="hidden" id="good_name"
                       value="{{ $items->first()-> option->product->ad_title . " 외 " . ($items->count()-1)  . '건'}}"/>
            @endif
            @if(Auth::check())
                <input type="hidden" id="buyer_email" value="{{ \Auth::user()->email }}"/>
            @endif

        </div>
    </div>


    <!-- 매장 모달 -->
    @include('orders.partial.shop', $shops)

@stop


{{--@section('script')
    <script>
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
    </script>
@endsection--}}
