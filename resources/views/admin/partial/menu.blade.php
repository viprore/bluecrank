<aside>
    <p class="lead">
        <i class="fa fa-list"></i>
        배송
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
        관리
    </p>
</aside>
<div class="list-group">
    <a href="{{ route('admin.edit.main') }}" class="list-group-item">메인페이지 수정</a>
    <a href="{{ route('admin.manage.users') }}" class="list-group-item">회원관리</a>
    <a href="{{ route('admin.manage.products') }}" class="list-group-item">상품관리</a>
    <a href="{{ route('admin.manage.comments') }}" class="list-group-item">최근문의</a>
</div>