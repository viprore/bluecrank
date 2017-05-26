@extends('layouts.app')

@section('style')
    <style>
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
            white-space: nowrap;
        }

        .thumbnail img {
            width: 100%;
        }

        .img-product {
            object-fit:cover;
        }

        .ratings {
            padding-right: 10px;
            padding-left: 10px;
            color: #0E2231;
        }

        .glyphicon-time {
            padding-right: 3px;
        }

        .glyphicon-heart {
            color: #d17581;
        }

        .glyphicon-comment {
            color: #2a88bd;
        }

        .thumbnail {
            padding: 0
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

    </style>
    {{--<link rel="stylesheet" href="{{ mix('css/flexslider.css') }}">--}}
@stop

@section('content')
    @php $viewName = 'products.index'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('products.index') }}">
                BC몰
            </a>
        </h4>

    </div>

    <div class="text-right action__market">
        @if($currentUser ? ($currentUser->isAdmin() ? true : false ) : false)
            <a href="{{ route('products.create') }}" class="btn btn-primary">
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

    <div class="row">
        <div class="col-md-3 sidebar__article">
            <aside>
                @include('products.partial.search')

                <p class="lead">
                    <i class="fa fa-list"></i>
                    카테고리
                </p>
            </aside>
            <div class="list-group">
                @foreach($categories as $slug => $locale)
                    <a href="{{ route('categories.products.index', $slug) }}"
                       class="list-group-item">{{ $locale['ko'] }}</a>
                @endforeach
            </div>
        </div>

        <div class="col-md-9 list__article">
            <div class="row">

                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    {{--<ol class="carousel-indicators">--}}
                        {{--<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>--}}
                        {{--<li data-target="#carousel-example-generic" data-slide-to="1"></li>--}}
                        {{--<li data-target="#carousel-example-generic" data-slide-to="2"></li>--}}
                    {{--</ol>--}}

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="http://bluecrank.net/web/upload/homi/main_img/main_img3.jpg" />
                            <div class="carousel-caption">

                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    {{--<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>--}}
                </div>
                {{--<div class="flexslider">
                    <ul class="slides">
                        <li>
                            <img src="http://bluecrank.net/web/upload/homi/main_img/main_img1.jpg" />
                        </li>
                        <li>
                            <img src="http://bluecrank.net/web/upload/homi/main_img/main_img2.jpg" />
                        </li>
                        <li>

                        </li>
                    </ul>
                </div>--}}
            </div>
            <div class="row">

                @forelse($products as $product)
                    <div class="col-sm-6 col-lg-4 col-md-6">
                        <div class="thumbnail">
                            <div class="ad_inform">
                                <a class="pull-left" href="{{ gravatar_profile_url('info@bluecrank.net') }}">
                                    <img class="media-object img-thumbnail2"
                                         src="{{ gravatar_url('info@bluecrank.net', 18) }}" alt="블루크랭크">
                                </a>
                                &nbsp;블루크랭크
                                <p class="pull-right">
                                    <span class="glyphicon glyphicon-time"></span>
                                    {{ $product->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="thumbnail-wrapper">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img class="img-product" src="{{ $product->attachments->count() > 0 ? $product->attachments->first()->url : 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQlzvW0rg_vTZkwz20Ot15G_zcKgx2L5DTtgUNPOrArVnPjpRoJiK8hJZc' }}" alt="">
                                </a>
                            </div>
                            <div class="caption">
                                <h4><a href="{{ route('products.show', $product->id) }}">{{ $product->ad_title }}</a>
                                </h4>
                                <p>{{ $product->ad_short_description }}</p>
                            </div>
                            <div class="ratings">
                                <h5 class="pull-right">&#8361;{{ $product->price }}</h5>
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
                    {!! $products->render() !!}
                </div>
            @endif
        </div>
    </div>


    {{--@php $viewName = 'articles.index'; @endphp

    <div class="page-header">
      <h4>
        <a href="{{ route('articles.index') }}">
          {{ trans('markets.title') }}
        </a>
        <small>
          / {{ trans('forum.articles.index') }}
        </small>
      </h4>
    </div>

    <div class="text-right action__article">
      <a href="{{ route('articles.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i>
        {{ trans('forum.articles.create') }}
      </a>

      <!--정렬 UI-->
      <div class="btn-group sort__article">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-sort"></i>
          {{ trans('forum.articles.sort') }}
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

    <div class="row container__article">
      <div class="col-md-3 sidebar__article">
        <aside>
          @include('articles.partial.search')

          @include('tags.partial.index')
        </aside>
      </div>

      <div class="col-md-9 list__article">
        <article>
          @forelse($articles as $article)
            @include('articles.partial.article', compact('article'))
          @empty
            <p class="text-center text-danger">
              {{ trans('forum.articles.empty') }}
            </p>
          @endforelse
        </article>

        @if($articles->count())
          <div class="text-center paginator__article">
            {!! $articles->appends(request()->except('page'))->render() !!}
          </div>
        @endif
      </div>
    </div>--}}
@stop

@section('script')
    @parent
    {{--<script src="{{ mix('js/jquery.flexslider.js') }}"></script>--}}
    <script>
        $(window).on('load', function() {
//            $('.flexslider').flexslider({
//                animation: "slide"
//            });
        });
    </script>
@endsection