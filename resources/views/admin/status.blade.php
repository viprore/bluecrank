@extends('layouts.app')



@section('content')
    @php $viewName = 'admin.index'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('markets.index') }}">
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
                       class="list-group-item {!! str_contains(request()->path(), $slug) ? 'active' : '' !!}">{{ $status .' ('. $orders->where('status', $status)->count().')' }}</a>
                @endforeach
                <a href="{{ route('admin.orders.status', 'qna') }}" class="list-group-item">상품문의</a>
            </div>
        </div>

        <div class="col-md-9 list__article">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">날짜</th>
                        <th class="text-center">주문명</th>
                        <th class="text-center">상태</th>
                        @if(str_contains(request()->path(), 'shipping'))
                            <th class="text-center">운송장번호</th>
                        @endif
                        <th class="text-center">조작</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($datas as $data)

                        <tr>
                            <td class="text-center">{{ $data->id }}</td>
                            <td class="text-center">{{ $data->created_at }}</td>
                            <td>{{ $data->items->first()->option->product->ad_title . "외 " . $data->items->count() . "건" }}</td>
                            <td class="text-center">{{ $data->status }}</td>
                            @if(str_contains(request()->path(), 'shipping'))
                                <th class="text-center">{{ $data->ship_code }}</th>
                            @endif
                            <td class="text-center">
                                @include('admin.partial.manager', ['status' => $data->status, 'target' => $data->id])
                            </td>
                        </tr>

                    @empty
                        <tr>
                            @if(str_contains(request()->path(), 'shipping'))
                                <td class="text-center text-danger" colspan="6">노오오오력하세요요</td>
                            @else
                                <td class="text-center text-danger" colspan="5">노오오오력하세요요</td>
                            @endif

                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
