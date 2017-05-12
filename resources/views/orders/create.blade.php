@extends('layouts.app')

@section('content')
    @php
        $viewName = 'orders.index';
        $total_amount= 0;
        $itemIdList = '';
    @endphp

    <div class="page-header">
        <h3>
            주문서 작성
        </h3>
        <hr/>
    </div>

    <div class="container">
        <div class="row">
            <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>주소록</th>
                                            <th>
                                                <div class="form-inline">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            직접입력 <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">직접입력</a></li>
                                                            <li class="divider"></li>
                                                            @forelse(\Auth::user()->ships as $ship)
                                                                <li><a href="#">{{ $ship->alias }}</a></li>
                                                            @empty
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                    <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">
                                                <input type="checkbox">
                                            </span>
                                                        <input type="text" class="form-control" disabled
                                                               placeholder="주소록을 저장합니다"
                                                               aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>이름</td>
                                            <td>
                                                <input type="text" class="form-control" name="name" id="name"
                                                       value="{{ old('name', $order->name) }}">
                                                {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
                                            </td>

                                        </tr>

                                        <tr>
                                            <td rowspan="3">주소</td>
                                            <td>
                                                <div class="form-inline">
                                                    <a id="modal-261803" href="#modal-container-261803" role="button"
                                                       class="btn btn-default"
                                                       data-toggle="modal">주소찾기</a>
                                                    <input type="text" class="form-control disabled" name="postcode"
                                                           id="postcode"
                                                           value="{{ old('postcode', $order->postcode) }}">
                                                </div>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="form-control disabled" id="find_address"
                                                       name="find_address"
                                                       value="{{ old('find_address', $order->find_address) }}"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="form-control disabled" id="input_address"
                                                       name="input_address"
                                                       value="{{ old('input_address', $order->input_address) }}">
                                                {!! $errors->first('postcode', '<span class="form-error">:message</span>') !!}
                                                {!! $errors->first('find_address', '<span class="form-error">:message</span>') !!}
                                                {!! $errors->first('input_address', '<span class="form-error">:message</span>') !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>연락처</td>
                                            <td><input type="text" class="form-control" id="contact" name="contact"
                                                       value="{{ old('contact', $order->contact) }}">
                                                {!! $errors->first('contact', '<span class="form-error">:message</span>') !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>요청사항</td>
                                            <td><textarea class="form-control" rows="3" id="please" name="please"
                                                          value="{{ old('please', $order->please) }}"></textarea>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>


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
                                            <td>
                                                결제예정금액
                                            </td>
                                            <td>
                                                {{ $total_amount }} 원
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>결제수단</td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="paymethod" id="inlineRadio1"
                                                           value="무통장입금" checked> 무통장입금
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="paymethod" id="inlineRadio2"
                                                           value="계좌이체"> 계좌이체
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="paymethod" id="inlineRadio3"
                                                           value="신용카드" disabled> 신용카드
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <button type="submit" class="btn btn-block btn-primary">
                                                    결제하기
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="item_id_list" value="{{ $itemIdList }}">
                                    <input type="hidden" name="amount" value="{{ $total_amount }}">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="modal-container-261803" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        ×
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">
                                        주소찾기
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    네이버 API 이용
                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">
                                        Save changes
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
            </form>

        </div>
    </div>

@stop