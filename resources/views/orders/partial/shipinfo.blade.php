<div class="panel panel-default">
    <div class="panel-heading">
        <a class="panel-title" data-toggle="collapse" data-parent="#panel-container"
           href="#panel-element-shipinfo">배송정보 입력</a>
    </div>
    <div id="panel-element-shipinfo" class="panel-collapse collapse {{ Auth::check() ? 'in' : '' }}">
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
                        @if(Auth::check())
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
                                                                    <input type="checkbox" id="cb_save"
                                                                           name="ship_save">
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
                        @endif
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
                                          name="please">{{ old('please') }}</textarea>
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
                                <h4 id="shop_name">{{ empty(old('shop_id')) ? '매장정보 없음' : old('shop_info') }}</h4>
                                <p id="shop_address">{{ empty(old('shop_id')) ? '상단에 매장선택을 이용하세요!' : old('shop_loc')  }}</p>
                                {!! $errors->first('shop_id', '<span class="form-error">:message</span>') !!}

                                <input type="hidden" id="shop_id" name="shop_id"
                                       value="{{ old('shop_id') }}">
                                <input type="hidden" id="shop_info" name="shop_info"
                                       value="{{ old('shop_info') }}">
                                <input type="hidden" id="shop_loc" name="shop_loc"
                                       value="{{ old('shop_loc') }}">
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
                                          placeholder="완제품 조립 및 도착 후 피팅까지 부탁드립니다.">{{ old('please2', $order->please) }}</textarea>
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
                    <button id="btn_go_itemchk" type="button" class="btn btn-primary" data-toggle="collapse"
                            style="display: none"
                            data-parent="#panel-container" data-target="#panel-element-itemchk">다음
                    </button>
                </div>
            </div>


        </div>
    </div>
</div>

@section('script')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.postcodify/3.4.1/search.min.js"></script>--}}
    <script type="text/javascript">
        $(document).ready(function () {
            /** 주소록 리스트 내 아이템 클릭시
             * 아약스 이벤트로 배송정보를 가져온다. */
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

            /* 주소찾기 API 팝업 */
            $("#postcodify_search_button").postcodifyPopUp();
        });

        /** 배송방법 토글시 발생
         *  전송할 데이터 업데이트 */
        function editShipMethod(method) {
            $('#shipmethod').val(method);
        }

        /** 클라이언트 내 간략한 유효성 검사
         *  입력 여부만 확인한다. */
        function formValidation() {
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
            if (errors == '') {
                // 임시처리 : 주소검색 API가 jQuery 3.x를 미지원(X-CSRF-TOKEN 관련 에러)
                $('#btn_go_itemchk').click();
                $('#validation-error').text('');
            } else {
                $('#validation-error').text(errors + '란을 확인해주세요.');
            }


        }

        /** 해당 지역 상점 모달을 생성 */
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

        /** 상점 선택시 메인 폼에 데이터 업데이트 */
        function selectShop(btnClick) {
            var selected_tr = btnClick.parentNode.parentNode;
            var childs = selected_tr.childNodes;
            var id = null;
            var name = null;
            var address = null;
            var contact = null;

            var i = 0;
            while (contact == null) {
                if (childs[i].nodeName == 'TD') {
                    if (id == null) {
                        id = childs[i].textContent;
                    } else if (name == null) {
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
            $('#shop_id').val(id);
            $('#shop_info').val(name + "(매장 연락처: " + contact + ")");
            $('#shop_loc').val(address);

            $('#myModal .close').click();

        }
    </script>
@endsection