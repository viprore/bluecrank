@extends('layouts.app')

@section('content')
  @php $viewName = 'products.create'; @endphp

  <div class="page-header">
    <h4>
      <a href="{{ route('products.index') }}">
        BC몰
      </a>
      <small>
        / 상품등록
      </small>
    </h4>
  </div>

  <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="form__article">
    {!! csrf_field() !!}

    @include('products.partial.form')

    <div class="form-group text-center">
      <button type="submit" class="btn btn-primary">
        등록하기
      </button>
    </div>
  </form>
@stop