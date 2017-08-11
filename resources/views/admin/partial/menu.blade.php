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
            ({{ $status_cnt && $status_cnt->where('status', $status)->first() ? $status_cnt->where('status', $status)->first()->status_count : '0'}})
            {{--{{ $status .' ('. $status_cnt->where('status', $status)->first()->status_count.')' }}--}}
        </a>
    @endforeach
    <a href="{{ route('admin.orders.status', 'qna') }}" class="list-group-item">상품문의</a>
</div>
<aside>
    <p class="lead">
        <i class="fa fa-pencil"></i>
        웹 수정
    </p>
</aside>
<div class="list-group">
    <a href="{{ route('admin.edit.main') }}" class="list-group-item">메인페이지</a>
</div>