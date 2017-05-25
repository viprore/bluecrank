@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h4>
      <a href="{{ route('products.show', $review->product->id) }}">
        {{ $review->product->ad_title }}
      </a>
      <small>
        / 리뷰 수정
      </small>
    </h4>
  </div>

  <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data" class="form__article">
    {!! csrf_field() !!}
    {!! method_field('PUT') !!}

    <input type="hidden" name="product_id" value="{{ $review->product->id }}"/>

    @include('reviews.partial.form')

    <div class="form-group text-center">
      <button type="submit" class="btn btn-primary">
        수정
      </button>
    </div>
  </form>
@stop
