@extends('layouts.app')

@section('style')
    <style>
        .my-6 {
            margin-top: 0em;
            margin-bottom: 2em;
        }

        .ad_inform {
            padding: 10px;
        }

        .ad_inform p {
            color: #bec6d5;
            margin: 0;
        }

        .caption {
            height: 100px;
            overflow: hidden;
        }

        .caption h4 {
            display: block;
            /*width: 200px; */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 16px;
            font-weight: bold;
        }

        .img-product {
            object-fit: cover;
        }

        .ratings {
            padding-right: 10px;
            padding-left: 10px;
            color: #0E2231;
        }

        .ratings h5 {
            font-size: 16px;
            font-weight: bold;
        }

        .glyphicon-time {
            padding-right: 3px;
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

        .thumbnail {
            padding: 0
        }

        .padding-option {
            padding: 3px;
        }

        .thumbnail .caption-full {
            padding: 9px;
            color: #333;
        }

        .action__market {
            padding-bottom: 1em;
        }

        .img-thumbnail2 {
            padding: 1px;
            line-height: 1.6;
            background-color: #f5f8fa;
            border: 1px solid #ddd;
            border-radius: 12px;
        }

        .inner__padding {
            font-size: 16px;
            padding: 10px;
        }

        .button__slug {
            font-size: 12px;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .item__banner img {
            width: 100%;
        }

        .no-padding {
            padding: 1px;
        }

        .form-control-inline {
            width: auto;
            float: left;
            margin-right: 5px;
        }

        #search_m {
            display: none;

        }

        .img-w100 {
            width: 100%;
        }

        .img-w80 {
            width: 80%;
        }

        .padding-8 {
            padding: 8px;
        }

        .category-active {
            background: #eee;
        }


    </style>
    {{--<link rel="stylesheet" href="{{ mix('css/flexslider.css') }}">--}}
@stop

@section('content')
    @php $viewName = 'products.index'; @endphp

    {{--<div class="page-header">

    </div>--}}
    <div class="row my-6 visible-xs-block visible-sm-block">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
        {{--<ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol>--}}

        <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <a href="https://www.youtube.com/watch?v=vhba0ICbeHc" target="_blank">
                        <img class="img-w100" src="{{ url('icons/banner02.png') }}">
                    </a>
                </div>
                <div class="item">
                    <img class="img-w100" src="{{ url('icons/banner04.jpg') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="row my-6 visible-md-block visible-lg-block text-center">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
        {{--<ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol>--}}

        <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <a href="https://www.youtube.com/watch?v=vhba0ICbeHc" target="_blank">
                        <img class="img-w100" src="{{ url('icons/banner02-pc.png') }}">
                    </a>
                </div>
                <div class="item">
                    <img class="img-w100" src="{{ url('icons/banner04-pc.jpg') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 ">
            <div class="visible-xs-inline-block visible-sm-inline-block">
                <form method="get" action="{{ route('olds.index') }}" role="search" class="form-inline">
                    <button class="btn btn-default form-control-inline" type="button" id="toggle-category"
                            title="카테고리 여/닫">
                        <i class="fa fa-list"></i>
                    </button>
                    <button class="btn btn-default form-control-inline" type="button" id="toggle-search" title="검색창 여닫">
                        <i class="fa fa-search"></i>
                    </button>
                    <input id="search_m" type="text" name="q" class="form-control form-control-inline"
                           placeholder="마켓 검색"/>
                </form>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="text-right action__market">
                @if(($currentUser ? ($currentUser->isAdmin() ? true : false ) : false))
                    <a href="{{ route('olds.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i>
                        상품 등록
                    </a>
            @endif

            <!--정렬 UI-->
                <div class="btn-group sort__article">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-sort"></i>
                        목록 정렬
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu" role="menu">
                        @foreach(config('project.sorting') as $column => $text)
                            <li {!! request()->input('sort') == $column ? 'class="active"' : '' !!}>
                                {!! link_for_sort($column, $text) !!}
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-3 sidebar__article">
            <div class="visible-md-block visible-lg-block">
                @include('products.partial.search')
            </div>
            <aside id="sidebar">
                <p class="lead">
                    <i class="fa fa-list"></i>
                    카테고리
                </p>

                <div class="list-group">
                    @foreach($categories as $slug => $locale)
                        <a href="{{ route('categories.olds.index', $slug) }}"
                           class="list-group-item {{ str_contains(request()->path(), $slug) ? 'category-active' : '' }}">{{ $locale['ko'] }}</a>
                    @endforeach
                </div>
            </aside>

            <div class="media item__banner">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img class="media-object" src="{{ url('icons/banner03.gif') }}">
                        </div>
                        <div class="item">
                            <a href="http://www.bikeacademy.co.kr/">
                                <img class="media-object img-thumbnail" src="{{ url('icons/banner01.jpg') }}">
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-md-9 list__article">
            @if(!strpos(request()->fullUrl(), 'slug') and !strpos(request()->fullUrl(), 'page') and !strpos(request()->fullUrl(), 'category'))
                {{--<div class="row my-6">

                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                    --}}{{--<ol class="carousel-indicators">--}}{{--
                    --}}{{--<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>--}}{{--
                    --}}{{--<li data-target="#carousel-example-generic" data-slide-to="1"></li>--}}{{--
                    --}}{{--<li data-target="#carousel-example-generic" data-slide-to="2"></li>--}}{{--
                    --}}{{--</ol>--}}{{--

                    <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="http://bluecrank.net/web/upload/homi/main_img/main_img3.jpg"/>
                                <div class="carousel-caption">

                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        --}}{{--<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>--}}{{--
                    </div>

                </div>--}}
            @endif

            {{--<div class="thumbnail row my-6 inner__padding">--}}

            <div class="row">
                <div class="col-md-12 no-padding">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>인기태그</b> <small>(최대 3개 선택 가능)</small></div>
                        <div class="panel-body padding-8">
                            @foreach($oldTags as $tag)
                                <button type="button" id="{{ $tag->slug }}"
                                        class="button__slug btn btn-sm {{ str_contains(request()->input('slug'), $tag->slug) ? 'btn-info' : 'btn-default' }}">
                                    # {{ $tag->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                @forelse($products as $product)
                    <div class="col-sm-6 col-md-6 col-lg-4 padding-option">
                        <div class="thumbnail">
                            <div class="ad_inform">
                                <a class="pull-left" href="{{ gravatar_profile_url('info@bluecrank.net') }}">
                                    <img class="media-object img-thumbnail2"
                                         src="{{ gravatar_url('info@bluecrank.net', 18) }}" alt="블루크랭크">
                                </a>
                                &nbsp;블루크랭크
                                {{--<p class="pull-right">
                                    <span class="glyphicon glyphicon-time"></span>
                                    {{ $product->created_at->diffForHumans() }}
                                </p>--}}
                            </div>
                            <div class="embed-responsive embed-responsive-4by3">
                                <a href="{{ route('olds.show', $product->id) }}">
                                    <img class="img-product embed-responsive-item"
                                         src="{{ $product->attachments->count() > 0 ? $product->attachments->first()->url : 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQlzvW0rg_vTZkwz20Ot15G_zcKgx2L5DTtgUNPOrArVnPjpRoJiK8hJZc' }}"
                                         alt="">
                                </a>
                            </div>
                            <div class="caption">
                                <h4><a href="{{ route('olds.show', $product->id) }}">{{ $product->ad_title }}</a>
                                </h4>
                                <p>{!! $product->ad_short_description !!}</p>
                            </div>
                            <div class="ratings">
                                <h5 class="pull-right">&#8361;{{ number_format($product->price) }}</h5>
                                <p>
                                    <span class="glyphicon glyphicon-heart"></span>
                                    {{ $product->getWantsCountAttribute() }}
                                    {{--<span class="glyphicon glyphicon-star">11</span>--}}
                                    <span class="glyphicon glyphicon-comment"></span>
                                    {{ $product->getCommentsCountAttribute() }}
                                </p>

                            </div>
                        </div>
                    </div>
                @empty
                    <p>글이 없습니다.</p>
                @endforelse
            </div>

            @if($products->count())
                <div class="text-center">
                    {!! $products->appends([
                        'slug' => request()->input('slug'),
                        'sort' => request()->input('sort'),
                        'order' => request()->input('order'),
                    ])->links() !!}
                </div>
            @endif
        </div>


    </div>

@stop

@section('script')
    @parent
    {{--<script src="{{ mix('js/jquery.flexslider.js') }}"></script>--}}

    <script>
        $(window).on('load', function () {
//            $('.flexslider').flexslider({
//                animation: "slide"
//            });
            $('.button__slug').click(function () {
                var slug = $(this).attr('id');
                var slugs = getParameterByName('slug');

                if (slugs.length < 1) {
                    var slugsArr = new Array();
                    slugsArr.push(slug);
                } else {
                    var slugsArr = slugs.split(' ');
                    if ($.inArray(slug, slugsArr) != -1) {
                        slugsArr = jQuery.grep(slugsArr, function (value) {
                            return value != slug;
                        });
                    } else {
                        slugsArr.push(slug);
                    }
                }

                /* slug 후처리 완료, 컨트롤로러 쿼리 매핑해서 보내기 */
                if (slugsArr.length > 3) {
                    alert('3개 이상의 태그를 선택하실 수 없습니다.');
                } else {
                    slugParam = '';
                    slugsArr.forEach(function (slug) {
                        if (slugParam == '') {
                            slugParam += slug;
                        } else {
                            slugParam += '+' + slug;
                        }
                    });

                    if (slugParam.length < 1) {
                        location.href = removeParam('page', removeParam('slug', $(location).attr('href')));
                    } else {
                        location.href = removeParam('page', replaceUrlParam($(location).attr('href'), 'slug', slugParam));
                    }
                }


            })
        });
        function removeParam(key, sourceURL) {
            var rtn = sourceURL.split("?")[0],
                param,
                params_arr = [],
                queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
            if (queryString !== "") {
                params_arr = queryString.split("&");
                for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                    param = params_arr[i].split("=")[0];
                    if (param === key) {
                        params_arr.splice(i, 1);
                    }
                }
                rtn = rtn + "?" + params_arr.join("&");
            }
            return rtn;
        }
        function replaceUrlParam(url, paramName, paramValue) {
            if (paramValue == null)
                paramValue = '';
            var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)')
            if (url.search(pattern) >= 0) {
                return url.replace(pattern, '$1' + paramValue + '$2');
            }
            return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
        }
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        $('#toggle-category').on('click', function () {
            $('#sidebar').slideToggle('fast');
            $('body,html').animate({scrollTop: 0}, 'fast');
        });

        $('#toggle-search').on('click', function () {
//            $('#search_m').toggle("slide", {direction:"left"}, 1000);
            $('#search_m').toggle('slide');
//            $('body,html').animate({scrollTop: 0}, 'fast');
        });
    </script>
@endsection