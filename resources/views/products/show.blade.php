@extends('layouts.app')

@section('style')
    @parent
    <style>
        .item_info h3 {
            font-size: 1.5em;
            color: #0E2231;
            margin-bottom: 1em;
        }

        .item_info h5 {
            color: #3c43a4;
            font-size: 1em;
            line-height: 1.1;
        }

        .short_description {
            margin: 2em 0;
        }

        .short_description p {
            color: #999;
            line-height: 1.8em;
            margin: 1em 0 0;
        }

        .price p {
            font-size: 1.2em;
            color: #212121;
            margin: 0.5em 0 1em;
            font-weight: 600;
        }

        .option-quantity-left {
            float: left;
        }

        .option-quantity-left h5, .option-quantity-right h5, .occasional h5 {
            text-transform: uppercase;
            font-size: 1em;
            color: #3c43a4;
            margin: 0 0 1em;
        }

        .option-quantity-right {
            float: left;
            margin-left: 8em;
        }

        /*-- quantity-starts --*/
        .value-minus,
        .value-plus, .value-minus1,
        .value-plus1 {
            height: 40px;
            line-height: 24px;
            width: 40px;
            margin-right: 3px;
            display: inline-block;
            cursor: pointer;
            position: relative;
            font-size: 18px;
            color: #fff;
            text-align: center;
            -webkit-user-select: none;
            -moz-user-select: none;
            border: 1px solid #b2b2b2;
            vertical-align: bottom;
        }

        .quantity-select .entry.value-minus:before,
        .quantity-select .entry.value-plus:before, .quantity-select .entry.value-minus1:before,
        .quantity-select .entry.value-plus1:before {
            content: "";
            width: 13px;
            height: 2px;
            background: #000;
            left: 50%;
            margin-left: -7px;
            top: 50%;
            margin-top: -0.5px;
            position: absolute;
        }

        .quantity-select .entry.value-plus:after, .quantity-select .entry.value-plus1:after {
            content: "";
            height: 13px;
            width: 2px;
            background: #000;
            left: 50%;
            margin-left: -1.4px;
            top: 50%;
            margin-top: -6.2px;
            position: absolute;
        }

        .value, .value1 {
            cursor: default;
            width: 40px;
            height: 40px;
            padding: 8px 0px;
            color: #A9A9A9;
            line-height: 24px;
            border: 1px solid #E5E5E5;
            background-color: #E5E5E5;
            text-align: center;
            display: inline-block;
            margin-right: 3px;
        }

        .quantity-select .entry.value-minus:hover,
        .quantity-select .entry.value-plus:hover, .quantity-select .entry.value-minus1:hover,
        .quantity-select .entry.value-plus1:hover {
            background: #E5E5E5;
        }

        .quantity-select .entry.value-minus, .quantity-select .entry.value-minus1 {
            margin-left: 0;
        }

        /*-- quantity-end --*/
    </style>
    <link rel="stylesheet" href="{{ mix('css/flexslider.css') }}">
@stop
@section('content')
    @php $viewName = 'products.show'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('products.index') }}">
                상품
            </a>
            <small>
                / {{ $product->ad_title }}
            </small>
        </h4>
    </div>

    <div class="row container__article">
        {{--<div class="col-md-3 sidebar__article">
            <aside>
                @include('articles.partial.search')

                @include('tags.partial.index')
            </aside>
        </div>--}}

        <div class="col-md-12 list__article">
            <div class="form-group">
                @if($product->options->count() == 0)
                    해당 옵션이 존재하지 않습니다.
                    옵션을 등록하시고 판매하세요!
                @else
                    <div class="row">
                        <div class="col-md-4">
                            <div class="flexslider">
                                <ul class="slides">
                                    @forelse($product->attachments as $attachment)
                                        <li data-thumb="{{ $attachment->url }}">
                                            <img src="{{ $attachment->url }}"/>
                                        </li>
                                    @empty
                                        <li>
                                            no image
                                        </li>
                                    @endforelse

                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8 item_info">
                            <h3>{{ $product->ad_title }}</h3>
                            <div class="short_description">
                                <h5><i>간략 설명</i></h5>
                                <p>{{ $product->ad_short_description }}</p>
                            </div>
                            <div class="price">
                                <h5>가격</h5>
                                <p>{{ $product->price }}&nbsp;<i class="fa fa-krw"></i></p>
                            </div>

                            <div class="option-quantity">
                                <div class="option-quantity-left">
                                    <h5>옵션 선택 : </h5>
                                    <select name="select_option[]" id="select_option" class="form-control">
                                        @foreach($product->options as $option)
                                            <option value="{{ $option->id }}">
                                                {{ strpos($option->color, '-') ? ($option->color . " - (" . $option->size .")") : $option->size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="option-quantity-right">
                                    <h5>Quantity :</h5>
                                    <div class="quantity">
                                        <div class="quantity-select">
                                            <div class="entry value-minus1">&nbsp;</div>
                                            <div class="entry value1"><span>1</span></div>
                                            <div class="entry value-plus1 active">&nbsp;</div>
                                        </div>
                                    </div>
                                    <!--quantity-->

                                    <!--quantity-->

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="form-group text-center">
                        @if(Auth::check())
                            <button type="button" class="btn btn-danger btn__want">
                                @if(empty(Auth::user()->wantProducts->where('id', '=', $product->id)->first()))
                                    찜하기
                                @else
                                    찜하기 해제
                                @endif
                            </button>
                            <button type="button" class="btn btn-success  btn__cart">카트</button>
                            <button type="button" class="btn btn-primary  btn__buy">구매</button>
                        @else
                            <a href="{{ route('sessions.create') }}">로그인</a>후 구매 가능합니다.
                        @endif
                    </div>
                @endif
            </div>

            <article data-id="{{ $product->id }}" id="item__article">
                @include('products.partial.article', compact('product'))

                <div class="content__article">
                    {!! markdown($product->description) !!}
                </div>

                {{--@include('tags.partial.list', ['tags' => $product->tags])--}}
            </article>

            <div class="text-center action__article">
                @can('update', $product)
                    <a href="{{ route('products.edit.option', $product->id) }}" class="btn btn-info">
                        <i class="fa fa-plus"></i>
                        옵션
                    </a>
                @endcan
                @can('update', $product)
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info">
                        <i class="fa fa-pencil"></i>
                        수정
                    </a>
                @endcan
                @can('delete', $product)
                    <button class="btn btn-danger button__delete">
                        <i class="fa fa-trash-o"></i>
                        삭제
                    </button>
                @endcan
                <a href="{{ route('reviews.create', $product->id) }}" class="btn btn-success">
                    <i class="fa fa-pencil-square-o"></i>
                    리뷰 작성
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-default">
                    <i class="fa fa-list"></i>
                    목록
                </a>
            </div>

            <div class="container__reviews">
                <div class="page-header">
                    <h4>
                        리뷰({{ $product->reviews->count() }})
                    </h4>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>글쓴이</th>
                        <th>날짜</th>
                        <th>제목</th>
                        <th>평점</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($product->reviews as $review)

                        <tr>
                            <td>{{ $review->user->name }}</td>
                            <td>{{ $review->created_at }}</td>
                            <td><a href="{{ route('reviews.show', $review->id) }}">{{ $review->title }}</a></td>
                            <td>
                                @for($i=0; $i<5; $i++)
                                    @if($i < $review->rating)
                                        <span class="glyphicon glyphicon-star text-danger"></span>
                                    @else
                                        <span class="glyphicon glyphicon-star-empty text-danger"></span>
                                    @endif

                                @endfor
                                    {{ '('.$review->rating.')' }}
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="4">No data</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="container__comment">
                @include('comments.index')
            </div>
        </div>
    </div>
@stop

@section('script')
    @parent
    <script src="{{ mix('js/jquery.flexslider.js') }}"></script>
    <script>
        $(window).on('load', function () {
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });
        });

        $('.value-plus1').on('click', function () {
            var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10) + 1;
            divUpd.text(newVal);
        });

        $('.value-minus1').on('click', function () {
            var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10) - 1;
            if (newVal >= 1) divUpd.text(newVal);
        });
        $('.button__delete').on('click', function (e) {
            var productId = $('article').data('id');

            if (confirm('상품을 삭제합니다.')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/products/' + productId
                }).then(function () {
                    window.location.href = '/products';
                });
            }
        });

        $('.btn__want').on('click', function (e) {
            var productId = $('article').data('id');


            $.ajax({
                type: 'POST',
                url: '/wants/' + productId
            }).then(function () {
                window.location.href = '/products/' + productId;
            });

        });

        $('.btn__cart').on('click', function (e) {
            var productId = $('article').data('id');
            var optionId = $('#select_option option:selected').val();
            var optionTxt = $('#select_option option:selected').text();
            var count = parseInt($('.value1').text(), 10);

            if (confirm(optionTxt + " " + count + "개를 장바구니에 추가합니다.")) {
                $.ajax({
//                    type: 'POST',
//                    url: '/carts/' + optionId + '/count/' + count
                    type: 'POST',
                    url: '/carts',
                    data: {
                        option_id: optionId,
                        count: count
                    }
                }).then(function () {
                    window.location.href = '/products/' + productId;
                });
            }
        });

        $('.btn__buy').on('click', function (e) {
            var optionId = $('#select_option option:selected').val();
            var optionTxt = $('#select_option option:selected').text();
            var count = parseInt($('.value1').text(), 10);

            if (confirm(optionTxt + " " + count + "개를 바로 구매합니다.")) {
                post_to_url('/buyone', {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'option_id': optionId,
                    'count': count
                });
            }
        });

        function post_to_url(path, params, method) {
            method = method || "post"; // 전송 방식 기본값을 POST로


            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            //히든으로 값을 주입시킨다.
            for (var key in params) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@stop
