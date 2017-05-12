@extends('layouts.app')

@section('content')
  @php $viewName = 'orders.index'; @endphp

  <div class="page-header">
    <h4>
      주문서 작성
    </h4>
  </div>

  @forelse($items as $item)
    <div class="container">
      <div class="row item-info">
        <div class="col-md-3">
          <img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQlzvW0rg_vTZkwz20Ot15G_zcKgx2L5DTtgUNPOrArVnPjpRoJiK8hJZc" />
        </div>
        <div class="col-md-9">
          <p>{{ $item->option->product->ad_title }}</p>
          <p>{{ "[옵션: " . $item->option->color . "(" . $item->option->size . ")"  }}</p>
          <p>{{ $item->option->product->price }}</p>
          <p>{{ $item->count }}</p>
        </div>
      </div>
      <div class="row summary">
        <div class="text-right">
          <p>{{ "합계 : " . ($item->option->product->price * $item->count) }}</p>
        </div>
      </div>
    </div>
  @empty
    <p class="text-center text-danger">
      없다
    </p>
  @endforelse

  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">이름</label>
    <input type="text" name="name" id="name" value="{{ old('name', $order->name) }}"
           class="form-control"/>
    {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
  </div>

  <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
    <label for="location">주소</label>
    <input type="text" location="location" id="location" value="{{ old('location', $order->location) }}"
           class="form-control"/>
    {!! $errors->first('location', '<span class="form-error">:message</span>') !!}
  </div>

  <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone">휴대폰 번호</label>
    <input type="text" phone="phone" id="phone" value="{{ old('phone', $order->phone) }}"
           class="form-control"/>
    {!! $errors->first('phone', '<span class="form-error">:message</span>') !!}
  </div>

  <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
    <label for="contact">비상 연락처</label>
    <input type="text" contact="contact" id="contact" value="{{ old('contact', $order->contact) }}"
           class="form-control"/>
    {!! $errors->first('contact', '<span class="form-error">:message</span>') !!}
  </div>

  <div class="form-group {{ $errors->has('request') ? 'has-error' : '' }}">
    <label for="request">요청사항</label>
    <input type="text" request="request" id="request" value="{{ old('request', $order->request) }}"
           class="form-control"/>
    {!! $errors->first('request', '<span class="form-error">:message</span>') !!}
  </div>

  <!-- 주문상품 확인 -->

  <!-- 배송지 입력 -->
  <div class="form-group">
    <label class="col-md-4 control-label">First Name</label>
    <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input  name="first_name" placeholder="First Name" class="form-control"  type="text">
      </div>
    </div>
  </div>
  <!-- 결제방법 -->




@stop