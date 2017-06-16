@extends('layouts.app')

@section('style')
    <style>
        #search_m {
            display: none;
        }

        .mb-6 {
            margin-top: 0em;
            margin-bottom: 2em;
        }

        .mb-split {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }

        .vcenter {
            display: inline-block;
            vertical-align: middle;
            float: none;
        }

        .side-padding {
            padding-right: 30px;
            padding-left: 30px;
        }

        .hr-title {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 1em;
            margin-left: auto;
            margin-right: auto;
            border-style: solid;
            border-width: 3px;
            border-color: #3097d0;
            color:#FFFFFF;
        }

        .text-article-title {
            color: #333333;
        }
    </style>
@endsection

@section('content')
    @php $viewName = 'articles.index'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('articles.index') }}">
                커뮤니티
            </a>
            <small>
                / 글 목록
            </small>
        </h4>
    </div>

    <div class="row">
        <div class="col-xs-8">
            <div class="visible-xs-inline-block visible-sm-inline-block">
                <form method="get" action="{{ route('articles.index') }}" role="search" class="form-inline">
                    <button class="btn btn-default form-control-inline" type="button" id="toggle-category"
                            title="태그 여/닫">
                        <i class="fa fa-tags"></i>
                    </button>
                    <button class="btn btn-default form-control-inline" type="button" id="toggle-search" title="검색창 여닫">
                        <i class="fa fa-search"></i>
                    </button>
                    <input id="search_m" type="text" name="q" class="form-control form-control-inline"
                           placeholder="커뮤니티 검색"/>
                </form>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="text-right">
                <a href="{{ route('articles.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i>
                    글 쓰기
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
        </div>
    </div>





    <div class="row container__article">
        <div class="col-md-3 sidebar__article mb-6">
            <div class="visible-md-block visible-lg-block">
                @include('articles.partial.search')
            </div>
            <aside id="sidebar">
                @include('tags.partial.index')
            </aside>
        </div>

        <div class="col-md-9">

            <h3><p class="text-primary">
                <i class="fa fa-tags text-muted"></i>
                @foreach($articleTags as $tag)
                    @if(str_contains(request()->path(), $tag->slug))
                        {{ $tag->name }}
                    @endif
                @endforeach
                 게시판
            </p></h3>

            <hr class="hr-title" />


            @forelse($articles as $article)
                <div class="row side-padding">
                    <h5 class="mb-split"><a class="text-article-title" href="{{ route('articles.show', $article->id) }}">
                                {{ $article->title }}
                            </a></h5>
                </div>
                <div class="row side-padding">
                    <div class="vcenter">
                        @if (isset($article->user) and $article->user)
                            <a class="pull-left" href="{{ gravatar_profile_url($article->user->email) }}">
                                <img class="media-object img-circle vcenter"
                                     src="{{ gravatar_url($article->user->email, 16) }}"
                                     alt="{{ $article->user->name }}">
                            </a>
                        @else
                            <a class="pull-left" href="{{ gravatar_profile_url('unknown@example.com') }}">
                                <img class="media-object img-circle vcenter"
                                     src="{{ gravatar_url('unknown@example.com', 16) }}" alt="Unknown User">
                            </a>
                        @endif
                    </div>&nbsp;
                    <div class="vcenter">
                        <a class="pull-left" href="{{ gravatar_profile_url($article->user->email) }}">
                            <small>{{ $article->user->name }}</small>
                        </a>
                    </div>
                    <div class="vcenter">
                        <small>
                            • {{ $article->created_at->diffForHumans() }}
                            • 조회수 {{ $article->view_count }}

                            @if ($article->comment_count > 0)
                                • 댓글 {{ $article->comment_count }}
                            @endif
                        </small>
                    </div>
                    <div class="vcenter"></div>

                    &nbsp;
                    &nbsp;

                </div>
                <hr class="mb-split"/>
                {{--@include('articles.partial.article', compact('article'))--}}
            @empty
                <p class="text-center text-danger">
                    글이 없습니다.
                </p>
            @endforelse

            @if($articles->count())
                <div class="text-center paginator__article">
                    {!! $articles->appends(request()->except('page'))->render() !!}
                </div>
            @endif
        </div>
    </div>
@stop

@section('script')
    @parent
    <script>
        $(window).on('load', function () {
            $('#toggle-category').on('click', function () {
                $('#sidebar').slideToggle('fast');
                $('body,html').animate({scrollTop: 0}, 'fast');
            });

            $('#toggle-search').on('click', function () {
//            $('#search_m').toggle("slide", {direction:"left"}, 1000);
                $('#search_m').toggle('slide');
//            $('body,html').animate({scrollTop: 0}, 'fast');
            });
        })
    </script>
@endsection
