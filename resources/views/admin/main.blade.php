@extends('layouts.app')


@section('content')
    @php $viewName = 'admin.edit.main'; @endphp


    <div class="page-header">
        <h4>
            <a href="{{ route('admin.index') }}">
                관리자
            </a>
            <small>
                메인 페이지 수정
            </small>
        </h4>
    </div>

    <div class="row">
        <div class="col-md-3 sidebar__article">
            @include('admin.partial.menu', $statusList)
        </div>

        <div class="col-md-9 list__article">

            @foreach($blurbs as $blurb)
                <div class="row">
                    @include('admin.partial.blurb', $blurb)
                </div>
            @endforeach

            <div class="row">
                <h3>새로만들기</h3>
                @include('admin.partial.blurb', [$blurb = new App\Blurb])
            </div>
        </div>
    </div>

@stop
