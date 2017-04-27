@extends('layouts.app')

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

        <div class="col-md-9 list__article">
            <article data-id="{{ $product->id }}" id="item__article">
                @include('products.partial.article', compact('product'))

                <div class="content__article">
                    {!! markdown($product->description) !!}
                </div>

                {{--@include('tags.partial.list', ['tags' => $product->tags])--}}
            </article>

            <div class="form-group">
                @if($product->options->count() == 0)
                    해당 옵션이 존재하지 않습니다.
                    옵션을 등록하시고 판매하세요!
                @else
                    <div class="row">
                        <div class="col-md-6">
                            {{--<div class="thumbnail">--}}
                                {{--<img src="{{ $product->attachments->first()->url }}" alt="">--}}
                            {{--</div>--}}

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select_option">옵션 선택</label>
                                <select name="select_option[]" id="select_option" class="form-control">
                                    @foreach($product->options as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->color . " - (" . $option->size .") // 남은수량 (" . $option->inventory . ")" }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group-align-right">
                                <label for="count">수량</label>
                                <input type="number" name="count" id="count" value="{{ old('count') }}"
                                       onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)'
                                       style='ime-mode:disabled;'/>
                            </div>
                            <div class="form-group text-center">
                                @if(Auth::check())
                                    <button type="button" class="btn btn-danger btn__want">찜하기</button>
                                    <button type="button" class="btn btn-success  btn__cart">카트</button>
                                    <button type="button" class="btn btn-primary  btn__buy">구매</button>
                                @else
                                    <a href="{{ route('sessions.create') }}">로그인</a>후 구매 가능합니다.
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

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
                <a href="{{ route('products.index') }}" class="btn btn-default">
                    <i class="fa fa-list"></i>
                    목록
                </a>
            </div>

            <div class="container__comment">
                @include('comments.index')
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
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

            if (confirm('찜하기')) {
                $.ajax({
                    type: 'POST',
                    url: '/wants/' + productId
                }).then(function () {
                    window.location.href = '/products/' + productId;
                });
            }
        });
    </script>
@stop
