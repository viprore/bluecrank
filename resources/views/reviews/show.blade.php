@extends('layouts.app')

@section('content')
    @php $viewName = 'reviews.show'; @endphp

    <div class="page-header">
        <h4>
            <a href="#">
                리뷰
            </a>
            <small>
                / {{ $review->product->ad_title }}
            </small>
        </h4>
    </div>

    <div class="row container__article">


        <div class="col-md-9 list__article">
            <input type="hidden" id="product_id" name="product_id" value="{{ $review->product->id }}"/>
            <article data-id="{{ $review->id }}" id="item__article">
                @include('reviews.partial.article', compact('review'))

                <div class="content__article">
                    {!! markdown($review->content) !!}
                </div>

            </article>

            <div class="text-center action__article">
                @can('update', $review)
                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-info">
                        <i class="fa fa-pencil"></i>
                        글 수정
                    </a>
                @endcan
                @can('delete', $review)
                    <button class="btn btn-danger button__delete">
                        <i class="fa fa-trash-o"></i>
                        글 삭제
                    </button>
                @endcan
                <a href="{{ route('products.show', $review->product->id) }}" class="btn btn-default">
                    <i class="fa fa-list"></i>
                    상품으로
                </a>
            </div>

        </div>
    </div>
@stop

@section('script')
    <script>
        $('.button__delete').on('click', function (e) {
            var reviewId = $('article').data('id');
            var productId = $('#product_id').val();

            if (confirm('글을 삭제합니다.')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/reviews/' + reviewId
                }).then(function () {
                    window.location.href = '/products/' + productId;
                });
            }
        });
    </script>
@stop