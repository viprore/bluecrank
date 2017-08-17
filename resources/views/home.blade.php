@extends('layouts.app')

@section('style')
    <style>
        .carousel-indicators {
            left: 5%;
        }

        .carousel-indicators .active {
            /*margin: 0;
            width: 12px;
            height: 12px;
            background-color: #fff;*/
            background-color: #135fcd;
        }

        .carousel-indicators li {
            /*display: inline-block;
            width: 10px;
            height: 10px;
            margin: 1px;
            text-indent: -999px;
            border: 1px solid #fff;
            border-radius: 10px;
            cursor: pointer;
            background-color: #000\9;
            background-color: transparent;*/
            border: 1px solid transparent;
            background-color: gray;
        }

        /*.carousel-control {
            display: none;
        }*/

        .top-carousel{
            margin-bottom: 4em;
        }

        .top-static {
            margin-bottom: 8em;
        }



        .page-header {
            margin-bottom: 1em;
        }

        .page-header > h4 {
            font-stretch: ultra-condensed;
            font-weight: bold;
            font-size: 1.5em;
        }

        .page-header > h4 > b {
            font-size: 1.3em;
            color: #4055dc;
        }

        .hot-2by2 > div {
            padding-left: 0.5em;
            padding-right: 0.5em;
            padding-bottom: 1em;
        }

        .hot-sm > div {
            padding-left: 0.5em;
            padding-right: 0.5em;
            padding-bottom: 1em;
        }

        /*아이템*/
        .card .card-image {
            overflow: hidden;
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            -o-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .card .card-image img {
            -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            -ms-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        .card .card-image:hover img {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -ms-transform: scale(1.1);
            -o-transform: scale(1.1);
            transform: scale(1.1);
        }

        .card {
            /*-webkit-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.16), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
            -moz-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.16), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
            box-shadow: 2 1px 2px 0 rgba(0, 0, 0, 0.16), 0 1px 5px 0 rgba(0, 0, 0, 0.12);*/
            border: transparent;
        }

        .padding-option {
            padding: 24px;
        }

        .thumbnail {
            padding: 0
        }

        .glyphicon-heart {
            padding-right: 3px;
            color: #ff514d;
        }

        .glyphicon-comment {
            padding-left: 10px;
            padding-right: 3px;
            color: #6f80bd;
        }

        .img-product {
            object-fit: contain;
            border-radius: 5px 5px 0 0;
        }

        .ratings {
            margin-top: 0;
            border-top: 1px solid transparent;
            padding-top: 10px;
            padding-right: 10px;
            padding-left: 10px;
            color: #0E2231;
        }

        .ratings > p {
            padding-top: 2px;
            border-top: 1px solid lightgray;
        }

        .ratings > div > h5, .ratings > div > h6 {
            margin: 0;
        }

        .ratings > div > h5 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .caption {
            height: 127px;
            overflow: hidden;
        }

        .caption>h4 {
            margin: 0;
            margin-top: 6px;
            margin-bottom: 1.5em;
        }

        .caption>h4 > a {
            font-weight: bold;
            text-decoration: none;
            color: black;
        }

        .caption>p {
            margin: 0;
            color: darkgray;
            white-space: nowrap;
            overflow: hidden;
        }

        .price {
            display: inline-block;
            float: right;
            vertical-align: middle;
            color: #475cdd;
        }

        .caption>h6 {
            padding-right: 0.5em;
            padding-top: 2px;
            display: inline-block;
            float: right;
            vertical-align: middle;
            margin: 0;
            margin-top: 6px;
        }

        .tags__product {
            list-style: none;
            margin: 0;
            padding: 0;
            font-weight: 100;
            font-size: 0.8em;
        }

        .tags__product li {
            display: inline-block;
            padding: 2px 8px;
            margin-right: 0.6em;
            background-color: #8fa9d5;
            border-radius: 0;
        }

        .tags__product a {
            background-color : transparent;
            color: white;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .top-carousel{
                margin-bottom: 1em;
            }

            .top-carousel > div {
                padding: 0;
            }

            .top-static {
                margin-bottom: 2em;
            }

            .container {
                padding-left: 4px;
                padding-right: 4px;
            }

            .top-static > div {
                padding-left: 4px;
                padding-right: 4px;
            }

            .page-header > h4 {
                font-size: 1em;
            }

            .caption > p {
                font-size: 12px;
            }

            .caption > h4 > a {
                font-size: 16px;
            }

            .caption > .price {
                font-size: 16px;
                font-weight: bold;
            }

            .padding-option {
                padding: 4px;
            }

            .ratings {
                padding-top: 0px;
            }

            .thumbnail .caption {
                padding: 12px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        {{-- 최상단 캐러셀 --}}
        <div class="row top-carousel">
            <div class="col-md-12">
                <div id="carousel-top" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @for($i = 0; $i < $big_ads->count(); $i++)
                            <li data-target="#carousel-top"
                                data-slide-to="{{ $i }}" {!! $i == 0 ? 'class="active"' : '' !!}></li>
                        @endfor
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($big_ads as $item)
                            <div class="item {{ $loop->first ? 'active' : '' }}">
                                <a href="{{ $item->link }}">
                                    <img src="{{ $item->attachments->first()->url }}" alt="{{ $item->title }}">
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-top" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-top" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        {{-- 바로 아래 3개짜리 --}}
        <div class="row top-static">
            @foreach($sm_ads as $item)
                <div class="col-xs-4">
                    <a href="{{ $item->link }}" {!! $item->is_blank ? 'target="_blank"' : '' !!}>
                        <img src="{{ $item->attachments->first()->url }}" style="width: 100%">
                    </a>
                </div>
            @endforeach
        </div>
        {{-- 하태하태 2*2개 --}}
        <div class="page-header">
            <h4>
                <b>H</b>OT HAE HOT HAE
                <small>
                    프로가 여러분에게 직접 추천합니다.
                </small>
            </h4>
        </div>
        <div class="row hot-2by2">
            @foreach($big_hots as $item)
                <div class="col-xs-6">
                    <a href="{{ $item->link }}">
                        <img src="{{ $item->attachments->first()->url }}" style="width: 100%">
                    </a>
                </div>
            @endforeach
        </div>
        {{-- 하태하태 3개 --}}
        <div class="row hot-sm">
            @foreach($sm_hots as $item)
                <div class="col-xs-4">
                    <a href="{{ $item->link }}">
                        <img src="{{ $item->attachments->first()->url }}" style="width: 100%">
                    </a>
                </div>
            @endforeach
        </div>

        <div class="page-header">
            <h4>
                <b style="color: orange">N</b>EW ITEM
                <small>
                    따끈따끈한 신상
                </small>
            </h4>
        </div>

        <div class="row">
            @forelse($products as $product)
                @include('products.partial.item', [$product, 'prefix' => 'products.', 'viewName'=>'root'])
            @empty
                <p class="text-center">해당 물품이 없습니다.</p>
            @endforelse
        </div>
    </div>
@endsection
