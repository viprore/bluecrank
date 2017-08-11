@extends('layouts.app')


@section('content')
    @php $viewName = 'admin.index'; @endphp


    <div class="page-header">
        <h4>
            <a href="{{ route('admin.index') }}">
                관리자
            </a>
            <small>
                Total Page
            </small>
        </h4>
    </div>

    <div class="row">
        <div class="col-md-3 sidebar__article">
            @include('admin.partial.menu', $statusList)
        </div>

        <div class="col-md-9 list__article">
            <div class="row">
                @include('admin.partial.list', [$datas])
            </div>
        </div>
    </div>

@stop
