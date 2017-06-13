@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h4>
      <a href="{{ route('olds.index') }}">
        BC몰
      </a>
      <small>
        / 옵션 수정
        / {{ $product->ad_title }}
      </small>
    </h4>
  </div>

  @include('olds.partial.option')

@stop
