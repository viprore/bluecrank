@extends('layouts.app')

@section('style')
    <style>
        .caption h4 {
            display: block;
            /*width: 200px; */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 16px;
            font-weight: bold;
        }

        .list__article > h3 {
            font-size: 16px;
            font-weight: bold;
            color: #374dda;

            padding-bottom: 0.5em;
            border-bottom: 2px solid lightgray;
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

        @media (max-width: 768px) {
            .padding-option {
                padding: 0;
            }

        }


    </style>
@endsection

@section('content')
    @php $viewName = 'products.search'; @endphp

    @include('products.partial.banner')

    <div class="row">
        {{-- 우측 아이템 리스트, 인기 태그, 등록/정렬 --}}
        <div class="col-md-12 list__article">
            <h3>BC몰</h3>
            <!-- 아이템 리스트 -->
            <div class="row padding-12">
                @forelse($bc_items as $product)
                    @if(!$loop->last)
                        @include('products.partial.item', [$product, $prefix = 'products.'])
                    @endif
                @empty
                    <p class="text-center">해당 물품이 없습니다.</p>
                @endforelse
                @if($bc_items->count() > 3)
                    <p class="text-right">
                        <a href="{{ route('products.index') }}?q={{ request()->input('q') }}">
                            BC몰 더 보기
                        </a>
                    </p>
                @endif
            </div>
            <h3>중고</h3>
            <!-- 아이템 리스트 -->
            <div class="row padding-12">
                @forelse($old_items as $product)
                    @if(!$loop->last)
                        @include('products.partial.item', [$product, $prefix = 'olds.'])
                    @endif
                @empty
                    <p class="text-center">해당 물품이 없습니다.</p>
                @endforelse
                @if($old_items->count() > 3)
                    <p class="text-right">
                        <a href="{{ route('olds.index') }}?q={{ request()->input('q') }}">
                            중고장터 더 보기
                        </a>
                    </p>
                @endif
            </div>

        </div>


    </div>

@stop

{{--
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
@endsection--}}
