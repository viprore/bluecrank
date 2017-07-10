@extends('layouts.app')

@section('style')
    <style>
        @import url(http://fonts.googleapis.com/css?family=Roboto:400,300);
        @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css);

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
            font-family: 'Roboto', sans-serif;
            margin-top: 10px;
            position: relative;
            -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            box-shadow: 4 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        }

        .card .card-content {
            padding: 10px;
        }

        .card .card-content .card-title, .card-reveal .card-title {
            font-size: 20px;
            font-weight: 200;
        }

        .card .card-content .card-title {
            padding-right: 20px;
            display: inline-block;
            width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card .card-action {
            padding: 10px;
            border-top: 1px solid rgba(160, 160, 160, 0.2);
        }

        .card .card-action a {
            font-size: 15px;
            color: #EBEBEB;
            margin-right: 20px;
            -webkit-transition: color 0.3s ease;
            -moz-transition: color 0.3s ease;
            -o-transition: color 0.3s ease;
            -ms-transition: color 0.3s ease;
            transition: color 0.3s ease;
        }

        .card .card-action a:hover {
            color: #ffffff;
            text-decoration: none;
        }

        .card .card-reveal {
            padding: 20px;
            position: absolute;
            background-color: #FFF;
            width: 100%;
            overflow-y: auto;
            /*top: 0;*/
            left: 0;
            bottom: 0;
            height: 100%;
            z-index: 1;
            display: none;
        }

        .card .card-reveal p {
            color: rgba(0, 0, 0, 0.71);
            margin: 20px;
        }

        .btn-custom {
            background-color: transparent;
            font-size: 18px;
        }

        .padding-side {
            padding-right: 5px;
            padding-left: 5px;
        }

        .img-responsive {
            width: 100%;
        }

    </style>
@stop

@section('content')
    @php $viewName = 'wants.index'; @endphp

    {{--<div class="page-header">

    </div>--}}

    <ul class="nav nav-pills nav-justified">

        <li role="presentation" {!! empty(request()->input('tab')) ? 'class="active"': '' !!}>
            <a href="{{ route('wants.index') }}">전체</a></li>
        <li role="presentation" {!! request()->input('tab') == 'products' ? 'class="active"': '' !!}>
            <a href="/wants?tab=products">BC몰</a></li>
        <li role="presentation" {!! request()->input('tab') == 'olds' ? 'class="active"': '' !!}><a
                    href="/wants?tab=olds">중고</a></li>
        <li role="presentation" {!! request()->input('tab') == 'articles' ? 'class="active"': '' !!}><a
                    href="/wants?tab=articles">커뮤니티</a></li>
    </ul>

    <div class="row">
        @forelse($items as $item)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-image embed-responsive embed-responsive-4by3">
                        @if($item->attachments->count() > 0)
                            <img class="img-responsive" src="{{ $item->attachments->first()->url }}">
                        @else
                            <img class="img-responsive"
                                 src='https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQlzvW0rg_vTZkwz20Ot15G_zcKgx2L5DTtgUNPOrArVnPjpRoJiK8hJZc'>
                        @endif




                    </div><!-- card image -->

                    <div class="card-content">
                        <span class="card-title">{{ isset($item->ad_title) ? $item->ad_title : $item->title }}</span>
                        <button type="button" class="btn btn-custom pull-right summary-show" aria-label="Left Align">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                    </div><!-- card content -->

                    <div class="card-action">
                        <div class="row padding-side">

                            @if(get_class($item) == "App\Product")
                                <div class="col-xs-6 padding-side">
                                    <a class="btn btn-success btn-block"
                                       href="{{ $item->is_old ? route('olds.show', $item->id) : route('products.show', $item->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>

                                <div class="col-xs-6 padding-side">
                                    <button type="button" class="btn btn-danger btn-block btn__want__product"
                                            item-id="{{ $item->id }}">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @else
                                <div class="col-xs-6 padding-side">
                                    <a class="btn btn-success btn-block" href="{{ route('articles.show', $item->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>

                                <div class="col-xs-6 padding-side">
                                    <button type="button" class="btn btn-danger btn-block btn__want__article"
                                            item-id="{{ $item->id }}">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif


                        </div>
                    </div><!-- card actions -->

                    <div class="card-reveal">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <span class="card-title">{{ isset($item->ad_title) ? $item->ad_title : $item->title }}</span>
                        <p>
                            {{ isset($item->ad_short_description) ? $item->ad_short_description : substr(strip_tags($item->content), 0, 50) . "..." }}
                        </p>
                    </div><!-- card reveal -->
                </div>
            </div>
        @empty
            <p class="text-center">관심 목록이 없습니다.</p>
        @endforelse
    </div>


@stop

@section('script')
    @parent
    <script>
        $(function () {

            $('.summary-show').on('click', function () {
//                alert($(this).parent());
                $(this).closest('.card').children('.card-reveal').slideToggle('slow');
            });

            $('.card-reveal .close').on('click', function () {
                $(this).parent().slideToggle('slow');
            });

            $('.btn__want__product').on('click', function (e) {
                var productId = $(this).attr('item-id');

                $.ajax({
                    type: 'POST',
                    url: '/wants/' + productId
                }).then(function () {
                    location.reload();
                });

            });

            $('.btn__want__article').on('click', function (e) {
                var productId = $(this).attr('item-id');

                $.ajax({
                    type: 'POST',
                    url: '/article/wants/' + productId
                }).then(function () {
                    location.reload();
                });

            });
        });
    </script>
@endsection
