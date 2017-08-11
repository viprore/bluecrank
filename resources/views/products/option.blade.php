@extends('layouts.app')

@section('content')
  @php
    if(str_contains(request()->url(), 'product')){
        $viewName = 'products.show';
        $prefix = 'products.';
    }elseif(str_contains(request()->url(), 'olds')){
        $viewName = 'olds.show';
        $prefix = 'olds.';
    }else{
        $viewName = 'secrets.show';
        $prefix = 'secrets.';
    }
  @endphp

  <div class="page-header">
    <h4>
      <a href="{{ route($prefix . 'index') }}">
        {{ str_contains($prefix, 'olds') ? '중고' : 'BC몰' }}
      </a>
      <small>
        / 옵션 수정
        / {{ $product->ad_title }}
      </small>
    </h4>
  </div>

  @include('products.partial.option', [$prefix])

@stop
