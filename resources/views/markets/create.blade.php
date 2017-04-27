@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h4>
      <a href="{{ route('markets.index') }}">
        중고 장터
      </a>
      <small>
        / 새 상품 등록
      </small>
    </h4>
  </div>

  <form action="{{ route('markets.store') }}" method="POST" enctype="multipart/form-data" class="form__article">
    {!! csrf_field() !!}

    @include('markets.partial.form')

    <div class="form-group text-center">
      <button type="submit" class="btn btn-primary">
        등록하기
      </button>
    </div>
  </form>
@stop