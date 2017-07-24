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
            <aside>
                <p class="lead">
                    <i class="fa fa-list"></i>
                    Status
                </p>
            </aside>
            <div class="list-group">
                @foreach($statusList as $slug => $status)
                    <a href="{{ route('admin.orders.status', $slug) }}"
                       class="list-group-item {!! str_contains(request()->path(), $slug) ? 'active' : '' !!}">
                        {{ $status }}
                        ({{ $status_cnt->where('status', $status)->first() ? $status_cnt->where('status', $status)->first()->status_count : '0'}})
                        {{--{{ $status .' ('. $status_cnt->where('status', $status)->first()->status_count.')' }}--}}
                    </a>
                @endforeach

                <a href="{{ route('admin.orders.status', 'qna') }}" class="list-group-item">상품문의</a>
            </div>
        </div>

        <div class="col-md-9 list__article">
            <div class="row">
                @include('admin.partial.list', [$datas])
            </div>
        </div>
    </div>

@stop
