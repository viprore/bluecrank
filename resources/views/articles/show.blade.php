@extends('layouts.app')

@section('content')
    @php $viewName = 'articles.show'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('articles.index') }}">
                포럼
            </a>
            <small>
                / 포럼 검색
            </small>
        </h4>
    </div>

    <div class="row container__article">
        <div class="col-md-3 sidebar__article">
            <aside>
                @include('articles.partial.search')

                @include('tags.partial.index')
            </aside>
        </div>

        <div class="col-md-9 list__article">
            <article data-id="{{ $article->id }}" id="item__article">
                @include('articles.partial.article', compact('article'))

                <div class="content__article">
                    {!! markdown($article->content) !!}
                </div>

                @include('tags.partial.list', ['tags' => $article->tags])
            </article>

            <div class="text-center action__article">
                @if(Auth::check())
                    <button type="button" class="btn btn-danger btn__want">
                        @if(empty(Auth::user()->wantArticles->where('id', '=', $article->id)->first()))
                            <i class="fa fa-heart"></i>
                        @else
                            <i class="fa fa-heart-o"></i>
                        @endif
                    </button>
                @endif

                @can('update', $article)
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-info">
                        <i class="fa fa-pencil"></i>
                        글 수정
                    </a>
                @endcan
                @can('delete', $article)
                    <button class="btn btn-danger button__delete">
                        <i class="fa fa-trash-o"></i>
                        글 삭제
                    </button>
                @endcan
                <a href="{{ route('articles.index') }}" class="btn btn-default">
                    <i class="fa fa-list"></i>
                    글 목록
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
            var articleId = $('article').data('id');

            if (confirm('글을 삭제합니다.')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/articles/' + articleId
                }).then(function () {
                    window.location.href = '/articles';
                });
            }
        });

        $('.btn__want').on('click', function (e) {
            var articleId = $('article').data('id');


            $.ajax({
                type: 'POST',
                url: '/article/wants/' + articleId
            }).then(function () {
                location.reload();
            });

        });
    </script>
@stop