@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h4>
      <a href="{{ route('products.index') }}">
        BC몰
      </a>
      <small>
        / 옵션 수정
        / {{ $product->ad_short_title }}
      </small>
    </h4>
  </div>

  @include('products.partial.option')

@stop
