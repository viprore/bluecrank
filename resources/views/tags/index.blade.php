@extends('layouts.app')

@section('style')
    <style>
        .card-container {
            padding: 0;
        }

        .card-view {
            position: relative;
            width: 100%;
        }

        .card-view-img {
            display: block;
            width: 100%;
            height: auto;
        }




        .card-view-text {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            opacity: 0.5;

            height: 100%;
            width: 100%;

            transition: .5s ease;
            background-color: #000000;
        }

        .card-view:hover > .card-view-img {
            -webkit-filter: blur(4px);
            filter: blur(4px);
        }

        .card-view:hover > .card-view-text {
            opacity: 0.7;
        }

        .text {
            color: white;
            font-size: 2em;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        @media (min-width: 0px) {
            .card-view-img {
                padding-bottom: 50%;
            }
            .embed-responsive .embed-responsive-item {
                height: 150%;
            }
        }
        @media (min-width: 768px) {
            .card-view-img {
                padding-bottom: 75%;
            }
            .embed-responsive .embed-responsive-item {
                height: 100%;
            }
        }

        .page-header > h4 > a {
            color: #000;
            font-weight: bold;

        }
    </style>
@endsection

@section('content')
    @php $viewName = 'tags.index'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('products.index') }}" title="BC몰로 Go">
                BC몰
            </a>
        </h4>
    </div>

    {{-- 태블릿 디바이스부터 카테고리를 숨기고 버튼으로 토글 --}}
    <div class="row">
        @foreach($productTags as $tag)
            <div class="card-container col-sm-6 col-md-4">
                <a href="{{ route('products.index') . '?slug=' . $tag->slug }}">
                    <div class="card-view">
                        <div class="card-view-img embed-responsive embed-responsive-4by3">
                            <img class="embed-responsive-item"
                                 src="{{ url('icons/bc/', $tag->slug . '.jpg') }}">
                        </div>
                        <div class="card-view-text">
                            <div class="text">#{{ $tag->name }}</div>
                        </div>

                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="page-header">
        <h4>
            <a href="{{ route('olds.index') }}" title="중고장터로 Go">
                중고장터
            </a>
        </h4>
    </div>

    {{-- 태블릿 디바이스부터 카테고리를 숨기고 버튼으로 토글 --}}
    <div class="row">
        @foreach($oldTags as $tag)
            <div class="card-container col-sm-6 col-md-4">
                <a href="{{ route('olds.index') . '?slug=' . $tag->slug }}">
                    <div class="card-view">
                        <div class="card-view-img embed-responsive embed-responsive-4by3">
                            <img class="embed-responsive-item"
                                 src="{{ url('icons/old/', $tag->slug . '.jpg') }}">
                        </div>
                        <div class="card-view-text">
                            <div class="text">#{{ $tag->name }}</div>
                        </div>

                    </div>
                </a>
            </div>
        @endforeach
    </div>



@stop

@section('script')
    {{--<script>
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
    </script>--}}
@endsection