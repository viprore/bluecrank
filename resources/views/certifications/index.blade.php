@extends('layouts.app')

@section('content')
  @php $viewName = 'certifications.index'; @endphp

  <div class="page-header">
    <h4>
      <a href="{{ route('certifications.index') }}">
        인증/점검 예약
      </a>
      <small>
        / 예약 목록
      </small>
    </h4>
  </div>

  <div class="text-right action__article">
    <a href="{{ route('certifications.create') }}" class="btn btn-primary">
      <i class="fa fa-plus-circle"></i>
      예약하기
    </a>

    <!--정렬 UI-->
    {{--<div class="btn-group sort__article">
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
    </div>--}}
  </div>

  <div class="row container__article">
    {{--<div class="col-md-3 sidebar__article">
      <aside>
        @include('certifications.partial.search')

        @include('tags.partial.index')
      </aside>
    </div>--}}

    <div class="col-md-9 list__article">
      <article>
        @forelse($certifications as $certification)
          @include('certifications.partial.certification', compact('$certification'))
        @empty
          <p class="text-center text-danger">
            글이 없습니다.
          </p>
        @endforelse
      </article>

      @if($certifications->count())
        <div class="text-center paginator__article">
          {!! $certifications->appends(request()->except('page'))->render() !!}
        </div>
      @endif
    </div>
  </div>
@stop