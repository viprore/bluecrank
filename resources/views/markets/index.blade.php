@extends('layouts.app')

@section('style')
<style>
    .ad_inform {
        padding : 10px;
    }

    .ad_inform p {
        color : #bec6d5;
        margin: 0;
    }

    .caption {
        height: 150px;
        overflow: hidden;
    }

    .caption h4 {
        white-space: nowrap;
    }

    .thumbnail img {
        width: 100%;
    }

    .ratings {
        padding-right: 10px;
        padding-left: 10px;
        color : #0E2231;
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
        padding: 0;
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
@stop

@section('content')
    @php $viewName = 'markets.index'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('markets.index') }}">
                마켓
            </a>
            <small>
                글 목록
            </small>
        </h4>
    </div>

    <div class="text-right action__market">
        <a href="{{ route('markets.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i>
            상품 등록
        </a>

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
                @include('markets.partial.search')

                <p class="lead">
                    <i class="fa fa-list"></i>
                    카테고리
                </p>
            </aside>
            <div class="list-group">
                @foreach($categories as $slug => $locale)
                    <a href="{{ route('categories.markets.index', $slug) }}" class="list-group-item">{{ $locale['ko'] }}</a>
                @endforeach
            </div>
        </div>

        <div class="col-md-9 list__article">
            <div class="row">
                @forelse($markets as $market)
                <div class="col-sm-6 col-lg-4 col-md-6">
                    <div class="thumbnail">
                        <div class="ad_inform" >
                            <a class="pull-left" href="{{ gravatar_profile_url($market->user->email) }}">
                                <img class="media-object img-thumbnail2" src="{{ gravatar_url($market->user->email, 18) }}" alt="{{ $market->user->name }}">
                            </a>
                            &nbsp;{{ $market->user->name }}
                            <p class="pull-right">
                                <span class="glyphicon glyphicon-time"></span>
                                {{ $market->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <img class="img-product" src="{{ $market->attachments->first()->url }}" alt="">
                        <div class="caption">
                            <h4><a href="#">{{ $market->ad_title }}</a></h4>
                        </div>
                        <div class="ratings">
                            <h5 class="pull-right">&#8361;{{ $market->price }}</h5>
                            <p>
                                <span class="glyphicon glyphicon-heart"></span>
                                {{ $market->getWantsCountAttribute() }}
                                {{--<span class="glyphicon glyphicon-star">11</span>--}}
                                <span class="glyphicon glyphicon-comment"></span>
                                {{ $market->getCommentsCountAttribute() }}
                            </p>

                        </div>
                    </div>
                </div>
                @empty
                    <p>글이 없습니다.</p>
                @endforelse
            </div>

            @if($markets->count())
                <div class="text-center">
                    {!! $markets->render() !!}
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