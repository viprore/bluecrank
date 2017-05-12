@extends('layouts.app')

@section('content')
  @php $viewName = 'orders.index'; @endphp

  <div class="page-header">
    <h4>
      주문내역
    </h4>
  </div>

  {{ dd($order) }}





@stop