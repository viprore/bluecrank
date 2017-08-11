@extends('layouts.app')

@section('content')
  @php
    if(str_contains(request()->url(), 'olds')){
        $viewName = 'olds.create';
        $prefix = 'olds.';
        $isOld = true;
    }else{
        $viewName = 'products.create';
        $prefix = 'products.';
        $isOld = false;
    }
  @endphp

  <div class="page-header">
    <h4>

      <a href="{{ route($prefix . 'index') }}">
        {{ $isOld ? '중고' : 'BC몰' }}
      </a>
      <small>
        / 상품등록
      </small>
    </h4>
  </div>

  <form action="{{ route($prefix . 'store') }}" method="POST" enctype="multipart/form-data" class="form__article">
    {!! csrf_field() !!}

    @include('products.partial.form')

    <div class="form-group text-center">
      <button type="submit" class="btn btn-primary">
        등록하기
      </button>
    </div>
  </form>
@stop