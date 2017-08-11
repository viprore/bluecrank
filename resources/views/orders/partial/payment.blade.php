<div class="panel panel-default">
    <div class="panel-heading">
        <a class="panel-title" data-toggle="collapse" data-parent="#panel-container"
           href="#panel-element-final">결제수단/최종 확인</a>
    </div>
    <div id="panel-element-final" class="panel-collapse collapse">
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
                        @if($order->ship_fee == "무료" || old('ship_fee') == "무료")
                            0 원(무료)
                            <input type="hidden" name="ship_fee" value="무료">
                        @else
                            <p id="ship_fee">{{ old('ship_fee', $order->ship_fee) == "포함" ? number_format(2500) . '원(선결제)' : '0원' }} </p>
                            <label class="radio-inline">
                                <input type="radio" name="ship_fee" id="shipFeeRadio1"
                                       value="포함" {{ old('ship_fee', $order->ship_fee) == "포함" ? 'checked' : '' }}>선결제
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="ship_fee" id="shipFeeRadio2"
                                       value="착불" {{ old('ship_fee', $order->ship_fee) == "착불" ? 'checked' : '' }}> 착불
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
                                   value="신용카드" {{ old('paymethod', $order->paymethod) == '신용카드' ? 'checked' : '' }}>
                            신용카드
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="paymethod" id="inlineRadio2"
                                   value="계좌이체" {{ old('paymethod') == '계좌이체' ? 'checked' : '' }}> 계좌이체(에스크로)
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="paymethod" id="inlineRadio1"
                                   value="무통장입금" {{ old('paymethod') == '무통장입금' ? 'checked' : '' }}> 무통장입금
                        </label>
                    </td>
                </tr>
                <tr class="account_form" {!! old('paymethod') == '무통장입금'? '' : 'style="display:none;"' !!}>
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
                                   value="{{ old('banker') }}"
                                   aria-describedby="basic-addon1"/>

                        </div>
                        <span class="form-error">받는 분과 동일하신 경우 체크</span>
                    </td>
                </tr>
                <tr class="account_form" {!! old('paymethod') == '무통장입금'? '' : 'style="display:none;"' !!}>
                    <td style="width:25%;padding-left:2em;">
                        입금은행
                    </td>
                    <td>
                        <p>바이크아카데미학원(이상훈) 110-274-824505 (신한)</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="button" class="btn btn-block btn-primary" id="btn_pg"
                                {!! old('paymethod') == '무통장입금' ? 'style="display:none;"' : '' !!}>
                            결제하기
                        </button>
                        <button type="submit" class="btn btn-block btn-primary" id="btn_acc"
                                {!! old('paymethod') == '무통장입금'? '' : 'style="display:none;"' !!}>
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

@section('script')
    @parent
    <script src="https://service.iamport.kr/js/iamport.payment-1.1.5.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var IMP = window.IMP;
            IMP.init('imp26813303');
            $('#btn_pg').click(function () {
                // 기타 정보
                var error = formCheck();
                if(error=='') {
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
                }else {
                    alert(error + "란을 확인해주세요.");
                }
            });

            $('input[type=radio][name=paymethod]').change(function () {
                if (this.value == '무통장입금') {
                    $('.account_form').toggle('slow');
                    $('#btn_acc').show();
                    $('#btn_pg').hide();
                } else if (this.value == '계좌이체') {
                    if (!$('.account_form').is(":hidden")) {
                        $('.account_form').toggle('slow');
                    }
                    $('#btn_acc').hide();
                    $('#btn_pg').show();
                } else if (this.value == '신용카드') {
                    if (!$('.account_form').is(":hidden")) {
                        $('.account_form').toggle('slow');
                    }
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
        });
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
                    $.ajax({
                        type: "POST",
                        url: "/status/failed/orders/" + order.id,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function() {
                            alert(rsp.error_msg);
//                            location.reload();
                            var str = "";
                            for (key in rsp) {
                                str += key + "=" + rsp[key] + "\n";
                            }

                            console.log(str);
                        }
                    });



                }
            });
        }
        function onError(data) {
            showObj(data);
            alert("서버 내부 에러입니다. 다시 시도해주세요.");
        }
        /* 주문번호 생성 */
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

        function showObj(obj) {
            var str = "";
            for (key in obj) {
                str += key + "=" + obj[key] + "\n";
            }

            alert(str);
            return;
        }

        function formCheck() {
            if ($('#shipmethod').val() == 'direct') {
                var name = $('#name').val();
                var postcode = $('#postcode').val();
                var find_address = $('#find_address').val();
                var input_address = $('#input_address').val();
                var contact = $('#contact').val();
            } else {
                var name = $('#name2').val();
                var shop_id = $('#shop_id').val();
                var contact = $('#contact2').val();
            }
            var errors = '';

            if (shop_id == '') {
                if (errors == '') errors += '매장정보';
                else                errors += ', 매장정보';
            }
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

            return errors;
        }
    </script>
@endsection