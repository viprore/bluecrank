@extends('layouts.app')

@section('style')
    <style>
        .img-w100 {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    @php $viewName = 'shop.index'; @endphp

    <div class="page-header">
        <h4>
            <img class="img-w100" src="{{ url('icons/shops/header.png') }}"/>
        </h4>
    </div>

    <div class="row container__article">
        <div class="col-md-12 list__article">
            <ul class="nav nav-pills">

                <li role="presentation" {!! !strpos(request()->fullUrl(), 'state') ? 'class="active"' : '' !!}><a href="{{ route('shops.index') }}">전국</a></li>
                @foreach($states as $state)
                    <li role="presentation" {!! strpos(request()->fullUrl(), 'state') !== false ? ($shops->first()->state == $state ? 'class="active"' : '') : "" !!}>
                        <a href="{{ route('shops.index', ['state' => $state]) }}">
                            {{ $state }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="row">
                @foreach($shops as $shop)
                    <img class="img-w100" src="{{ url('icons/shops/' . $shop->img_name) }}">
                @endforeach

            </div>
        </div>
    </div>
@stop


