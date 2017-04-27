@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h4>
      <a href="{{ route('products.index') }}">
        BC몰
      </a>
      <small>
        / 상품 수정
        / {{ $product->ad_short_title }}
      </small>
    </h4>
  </div>

  <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="form__article">
    {!! csrf_field() !!}
    {!! method_field('PUT') !!}

    @include('products.partial.form')
{{--    @include('products.partial.option')--}}

    <div class="form-group text-center">
      <button type="submit" class="btn btn-primary">
        상품 수정하기
      </button>
    </div>
  </form>

@stop
