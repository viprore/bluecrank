@if($status == '입금전')
    <form method="POST" action="{{ route('admin.orders.update', ['order' => $target, 'slug' => 'deposit']) }}"
          class="form-horizontal">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-xs btn-primary">입금완료</button>
    </form>
@endif

@if($status == '입금완료')
    <form method="POST" action="{{ route('admin.orders.update', ['order' => $target, 'slug' => 'checked']) }}"
          class="form-horizontal">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-xs btn-primary">배송준비</button>
    </form>
@endif

@if($status == '배송준비')
    <button type="button" class="btn btn-xs btn-success btn__shipcode" value="{{ $target }}">배송중</button>

    {{--<form method="POST" action="{{ route('admin.orders.update', ['order' => $target, 'slug' => 'prepare']) }}"
          class="form-inline">
        {{ csrf_field() }}
        <input type="text" id="shipcode" name="shipcode" placeholder="운송장번호" class="form-control"/>
        <button type="submit" class="btn btn-xs btn-primary btn__shipcode">배송중</button>
        {!! $errors->first('shipcode', '<span class="form-error">:message</span>') !!}
    </form>--}}
@endif

@if($status == '배송중')
    <form method="POST" action="{{ route('admin.orders.update', ['order' => $target, 'slug' => 'shipping']) }}"
          class="form-horizontal">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-xs btn-primary">배송완료</button>
    </form>
@endif

@section('style')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css">
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>
    <script>
        $(".btn__shipcode").click(function () {
            var target = $(this).val();
            BootstrapDialog.show({
                title: '운송장 번호를 입력하세요',
                message: '<label>운송장 번호<input type="text" id="shipcode" name="shipcode" placeholder="운송장번호" class="form-control"/></label>',
                size: BootstrapDialog.SIZE_SMALL,
                buttons: [{
                    label: '배송중',
                    cssClass: 'btn-primary',
                    action: function (dialog) {
                        var url = '/admin/orders/' + target + '/status/prepare';
                        var shipcode = $("#shipcode").val();

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                shipcode: shipcode
                            },
                            success: function() {
                                location.href = '/admin/status/shipping';
                            }
                        });

                        dialog.close();
                    }
                }, {
                    label: '닫기',
                    action: function (dialog) {
                        dialog.close()
                    }
                }]
            });
        })
        $(".btn__cancel").click(function () {
            var id = $(this).val();
            BootstrapDialog.show({
                title: '주문을 취소합니다',
                message: '<label>이유가 뭡니까<textarea class="form-control" rows="3" id="message"></textarea></label>',
                buttons: [{
                    label: '취소',
                    cssClass: 'btn-primary',
                    action: function (dialog) {

                        var url = '/status/cancel/orders/' + id;
                        var message = $("#message").val();

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                message: message
                            },
                            success: function () {
                                location.reload();
                            }
                        });

                        dialog.close();
                    }
                }, {
                    label: '닫기',
                    action: function (dialog) {
                        dialog.close()
                    }
                }]
            });
        });
    </script>


@endsection