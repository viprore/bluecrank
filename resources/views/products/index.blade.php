@extends('layouts.app')

@section('style')
    <style>
        .caption h4 {
            /*display: block;*/
            /*width: 200px; */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 16px;
            font-weight: bold;
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

        #search_m {
            display: none;
        }

        .padding-8 {
            padding: 8px;
        }

        .padding-12 {
            padding-top: 8px;
            padding-left: 12px;
            padding-right: 12px;
        }

        .category-active {
            background: #eee;
        }

        .lead {
            margin-bottom: 10px;
        }

        .no-margin {
            margin: 0;
        }

        #sidebar {
            padding-top: 1em;
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
            border-top: 1px solid lightgray;
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
            height: auto;
            overflow: hidden;
        }

        .caption>h4 {
            margin: 0;
            margin-top: 6px;
            margin-bottom: 1em;
        }

        .caption>h4 > a {
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
    </style>
@endsection

@section('content')
    @php
        if(str_contains(request()->url(), 'product')){
            $viewName = 'products.show';
            $prefix = 'products.';
        }elseif(str_contains(request()->url(), 'olds')){
            $viewName = 'olds.show';
            $prefix = 'olds.';
        }else{
            $viewName = 'secrets.show';
            $prefix = 'secrets.';
        }
    @endphp

    @include('products.partial.banner')

    {{-- 태블릿 디바이스부터 카테고리를 숨기고 버튼으로 토글 --}}
    <div class="row visible-xs visible-sm">
        <div class="col-xs-12">
            <form method="get" action="{{ route($prefix.'index') }}" role="search" class="form-inline">
                <div class="form-group no-margin">
                    <button class="btn btn-default" type="button" id="toggle-category"
                            title="카테고리 여/닫">
                        <i class="fa fa-list"></i>
                    </button>
                    <button class="btn btn-default" type="button" id="toggle-search" title="검색창 여닫">
                        <i class="fa fa-search"></i>
                    </button>
                    <label class="sr-only" for="search_m">검색</label>
                    <input id="search_m" type="text" name="q" class="form-control" style="width:auto"
                           placeholder="BC몰 검색"/>
                </div>
            </form>
        </div>

    </div>

    <div class="row">
        {{-- 좌측 검색(데스크탑), 카테고리, 배너 --}}
        <div class="col-md-3 sidebar__article visible-xs">
            {{-- 검색바(데스크탑) --}}
            <div class="visible-md visible-lg">
                @include('products.partial.search', [$prefix])
            </div>

            {{-- 카테고리 --}}
            <aside id="sidebar">
                <p class="lead">
                    <i class="fa fa-list"></i>
                    카테고리
                </p>

                <div class="list-group">
                    @foreach($categories as $slug => $locale)
                        <a href="{{ route('categories.'.$prefix.'index', $slug) }}"
                           class="list-group-item {{ str_contains(request()->path(), $slug) ? 'category-active' : '' }}">{{ $locale['ko'] }}</a>
                    @endforeach
                </div>
            </aside>

            {{-- 사이드 배너 --}}
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

        {{-- 우측 아이템 리스트, 인기 태그, 등록/정렬 --}}
        <div class="col-md-12 list__article">
            <!-- 태그 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>인기태그</b>
                            <small>(최대 3개 선택 가능)</small>
                        </div>
                        <div class="panel-body padding-8">
                            @foreach((str_contains($prefix, 'olds') ? $oldTags : $productTags) as $tag)
                                <button type="button" id="{{ $tag->slug }}"
                                        class="button__slug btn btn-sm {{ str_contains(request()->input('slug'), $tag->slug) ? 'btn-info' : 'btn-default' }}">
                                    # {{ $tag->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- 글 등록, 정렬 -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="text-right">
                        @if(($currentUser ? ($currentUser->isAdmin() ? true : false ) : false))
                            <a href="{{ str_contains($prefix, 'olds') ? route('olds.create'): route('products.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus-circle"></i>
                                등록
                            </a>
                    @endif

                    <!--정렬 UI-->
                        <div class="btn-group sort__article">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-sort"></i>
                                정렬
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

            <!-- 아이템 리스트 -->
            <div class="row padding-12">
                @forelse($products as $product)
                    @include('products.partial.item', [$product, $prefix])
                @empty
                    <p class="text-center">해당 물품이 없습니다.</p>
                @endforelse
            </div>

            <!-- 페이지네이션 -->
            @if($products->count())
                <div class="text-center">
                    {!! $products->appends(request()->except('page'))->render() !!}
                </div>
            @endif
        </div>


    </div>

@stop

@section('script')
    <script>
        /* 인기태그 클릭시 이벤트 */
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

        /* url에서 해당 key 삭제 함수 */
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

        /* param 교체 함수 */
        function replaceUrlParam(url, paramName, paramValue) {
            if (paramValue == null)
                paramValue = '';
            var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)')
            if (url.search(pattern) >= 0) {
                return url.replace(pattern, '$1' + paramValue + '$2');
            }
            return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
        }

        /* name에 해당하는 param값 리턴 from url */
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        /* 카테고리 버튼 클릭시 펼침 */
        $('#toggle-category').on('click', function () {
            $('#sidebar').slideToggle('fast');
            $('body,html').animate({scrollTop: 0}, 'fast');
        });

        /* 검색버튼 누르면 검색 폼 토글(태블릿 이하 디바이스) */
        $('#toggle-search').on('click', function () {
            $('#search_m').toggle('slide');
        });
    </script>
@endsection