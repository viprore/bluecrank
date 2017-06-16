@extends('layouts.app')

@section('style')
    @parent
    <style>
        .py-3{
            padding-top: 1em;
            padding-bottom: 1em;
        }

        .w-100 {
            width: 100%;
        }

        .btn-secondary {
            background: #eeeeee;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css">

@stop

@section('content')
    @php $viewName = 'orders.index'; @endphp

    <div class="page-header">
        <h4>
            주문조회
        </h4>
    </div>


    <div class="container">
        <div class="row order__nav">
            <ul class="nav nav-tabs">
                <li role="presentation" {!! !str_contains(request()->path(), 'cancel') ? 'class="active"' : '' !!}><a
                            href="/orders">주문내역조회</a></li>
                <li role="presentation" {!! str_contains(request()->path(), 'cancel') ? 'class="active"' : '' !!}><a
                            href="/cancel/orders">취소/반품/교환 내역</a></li>
            </ul>
        </div>

        <form class="form-inline py-3 align-right" role="form" method="GET" action="{{ route('orders.index') }}">
            {{--<div class="row py-3">--}}
                <div class="form-group btn-group py-3" role="group" aria-label="term">
                    <button type="button" class="btn btn-sm {{ date("Y-m-d",strtotime ("+1 days", strtotime(request()->input('start_date')))) == date('Y-m-d') ? 'btn-default':'btn-secondary' }}" onclick="scopeTerm('-1')">오늘</button>
                    <button type="button" class="btn btn-sm {{ date("Y-m-d",strtotime ("+7 days", strtotime(request()->input('start_date')))) == date('Y-m-d') ? 'btn-default':'btn-secondary' }}" onclick="scopeTerm('-7')">1주일</button>
                    <button type="button" class="btn btn-sm {{ date("Y-m-d",strtotime ("+30 days", strtotime(request()->input('start_date')))) == date('Y-m-d') ? 'btn-default':'btn-secondary' }}" onclick="scopeTerm('-30')">1개월</button>
                    <button type="button" class="btn btn-sm {{ date("Y-m-d",strtotime ("+90 days", strtotime(request()->input('start_date')))) == date('Y-m-d') ? 'btn-default':'btn-secondary' }}" onclick="scopeTerm('-90')">3개월</button>
                    <button type="button" class="btn btn-sm {{ date("Y-m-d",strtotime ("+180 days", strtotime(request()->input('start_date')))) == date('Y-m-d') ? 'btn-default':'btn-secondary' }}" onclick="scopeTerm('-180')">6개월</button>
                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="form-group input-group date py-3" id="start_date">
                    <input type="text" class="form-control" name="start_date"/>
                    <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                </div>
                <div class="form-group visible-lg-inline visible-md-inline visible-sm-inline">~</div>
                <div class="form-group input-group date py-3" id="end_date">
                    <input type="text" class="form-control" name="end_date"/>
                    <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary">조회</button>
            {{--</div>--}}
        </form>


        @forelse($orders as $order)
            <div class="row item-info">
                <div class="col-xs-3">
                    <img class="w-100"
                         src="{{ $order->items->first()->option->product->attachments->first()->url }}"/>
                </div>
                <div class="col-xs-9">
                    <a href="/orders/{{ $order->id }}">
                        <h4>{{ $order->items->first()->option->product->ad_title . "외 " . $order->items->count() . "건" }}</h4>
                    </a>

                    <p><b>주문일자</b> : {{ $order->created_at->format('Y-m-d') }}&nbsp;&nbsp;<b>가격</b> : {{ number_format($order->amount) . "원"  }}</p>
                    <div class="btn-group" role="group" aria-label="status">
                        <button type="button" class="btn btn-link btn-sm">{{ $order->status }}</button>
                        {!! $order->status == '입금전' ? '<button type="button" class="btn btn-danger btn-sm btn__cancel" value="'. $order->id .'">취소</button>' : '' !!}
                        {!! $order->status == '배송중' ? '<button type="button" class="btn btn-warning btn-sm btn__where" value="'. $order->id .'">어딨냐내물건</button>' : '' !!}
                        {!! $order->status == '배송완료' ? '<button type="button" class="btn btn-success btn-sm btn__takit" value="'. $order->id .'">구매결정</button>
                                                            <button type="button" class="btn btn-danger btn-sm btn__return" value="'. $order->id .'">반품</button>' : '' !!}
                        {!! $order->status == '구매결정' ? '<button type="button" class="btn btn-primary btn-sm btn__review" value="'. $order->id .'">리뷰작성</button>' : '' !!}
                        {!! $order->status == '배송중' ? '<input type="hidden" class="order_'. $order->id.'" name="postcode2" value="'. $order->ship_code.'">':'' !!}
                    </div>
                </div>
            </div>
            <hr />

        @empty
            <p class="text-center text-danger">
                없다
            </p>
            <div class="row summary">
                <div class="text-right">

                </div>
            </div>
    </div>


    @endforelse
    @if($orders->count())
        <div class="text-center paginator__article">
            {!! $orders->appends(request()->except('page'))->render() !!}
        </div>
    @endif

@stop

@section('script')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>--}}
    <script type="text/javascript">


        $(function () {
            $('#start_date').datetimepicker({
                defaultDate: '{{ isset($_GET['start_date']) ? $_GET['start_date'] : \Carbon\Carbon::now()->addMonth(-1) }}',
                format: 'YYYY-MM-DD'
            });
            $('#end_date').datetimepicker({
                defaultDate: '{{ isset($_GET['end_date']) ? $_GET['end_date'] : \Carbon\Carbon::now() }}',
                format: 'YYYY-MM-DD',
                useCurrent: false //Important! See issue #1075
            });
            $("#start_date").on("dp.change", function (e) {
                $('#end_date').data("DateTimePicker").minDate(e.date);
            });
            $("#end_date").on("dp.change", function (e) {
                $('#start_date').data("DateTimePicker").maxDate(e.date);
            });
            $(".btn__cancel").click(function (){
                var id = $(this).val();
                BootstrapDialog.show({
                    title: '주문을 취소합니다',
                    message: '<labe>이유가 뭡니까<textarea class="form-control" rows="3" id="message"></textarea></label>',
                    buttons: [{
                        label: '취소',
                        cssClass: 'btn-primary',
                        action: function(dialog) {
                            // TODO : 취소 아약스 이벤트
                            var url = '/status/cancel/orders/'+id;
                            var message = $("#message").val();

                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    message: message
                                },
                                success: function (){
                                    location.href='/orders'
                                }
                            });

                            dialog.close();
                        }
                    }, {
                        label: '닫기',
                        action: function(dialog) {
                            dialog.close()
                        }
                    }]
                });
            });
            $(".btn__where").click(function (){
                var id = $(this).val();

                BootstrapDialog.show({
                    title: '운송장 번호를 알려드리죠',
                    message: $(".order_" + id).val(),
                    buttons: [{
                        label: '닫기',
                        action: function(dialog) {
                            dialog.close()
                        }
                    }]
                });
            });
            $(".btn__takit").click(function (){
                var url = '/status/confirm/orders/' + $(this).val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (){
                        location.href='/orders'
                    }
                });
            });
            $(".btn__return").click(function (){
                var id = $(this).val();
                BootstrapDialog.show({
                    title: '반품요청',
                    message: '<labe>이유가 뭡니까<textarea class="form-control" rows="3" id="message"></textarea></label>',
                    buttons: [{
                        label: '반품',
                        cssClass: 'btn-primary',
                        action: function(dialog) {
                            // TODO : 취소 아약스 이벤트
                            var url = '/status/return/orders/'+id;
                            var message = $("#message").val();

                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    message: message
                                },
                                success: function (){
                                    location.href='/orders'
                                }
                            });

                            dialog.close();
                        }
                    }, {
                        label: '닫기',
                        action: function(dialog) {
                            dialog.close()
                        }
                    }]
                });
            });
            $(".btn__exchange").click(function (){
                var id = $(this).val();
                BootstrapDialog.show({
                    title: '교환요청',
                    message: '<labe>이유가 뭡니까<textarea class="form-control" rows="3" id="message"></textarea></label>',
                    buttons: [{
                        label: '취소',
                        cssClass: 'btn-primary',
                        action: function(dialog) {
                            // TODO : 취소 아약스 이벤트
                            var url = '/status/exchange/orders/'+id;
                            var message = $("#message").val();

                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    message: message
                                },
                                success: function (){
                                    location.href='/orders'
                                }
                            });

                            dialog.close();
                        }
                    }, {
                        label: '닫기',
                        action: function(dialog) {
                            dialog.close()
                        }
                    }]
                });
            });
            $(".btn__review").click(function (){
                var id = $(this).val();
                alert("기능 : 리뷰\n" + "해당 주문 ID : " + id );

            });
        });

        function scopeTerm(days) {
            var start_date = new Date();
            start_date.setDate(start_date.getDate() + parseInt(days));

            if(location.href.indexOf('cancel') == -1) {
                var url = '/orders?start_date=' + dateToYYYYMMDD(start_date);
            }else{
                var url = '/cancel/orders?start_date=' + dateToYYYYMMDD(start_date);
            }


            $(location).attr('href',url);
        }

        function dateToYYYYMMDD(date)
        {
            function pad(num) {
                num = num + '';
                return num.length < 2 ? '0' + num : num;
            }
            return date.getFullYear() + '-' + pad(date.getMonth()+1) + '-' + pad(date.getDate());
        }


    </script>
@stop