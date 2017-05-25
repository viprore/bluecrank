@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h4>
      <a href="{{ route('products.show', $product->id) }}">
        {{ $product->ad_title }}
      </a>
      <small>
        / 리뷰 작성
      </small>
    </h4>
  </div>

  <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="form__article">
    {!! csrf_field() !!}

    <input type="hidden" name="product_id" value="{{ $product->id }}"/>

    @include('reviews.partial.form')

    <div class="form-group text-center">
      <button type="submit" class="btn btn-primary">
        저장하기
      </button>
    </div>
  </form>
@stop