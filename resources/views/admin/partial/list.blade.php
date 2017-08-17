<table class="table table-bordered table-striped">
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
            <td><a href="{{ route('orders.show', $data->id) }}">
                    {{ $data->items->count() > 0 ? $data->items->first()->option->product->ad_title . "외 " . $data->items->count() . "건" : '주문서에 기록된 상품이 없습니다' }}
                </a></td>
            <td class="text-center">{{ $data->status }}</td>
            @if(str_contains(request()->path(), 'shipping'))
                <th class="text-center">{{ $data->ship_code }}</th>
            @endif
            <td class="text-center">
                @include('admin.partial.manager', ['status' => $data->status, 'target' => $data->id])

                @if($data->status == '입금전' || $data->status == '입금완료' || $data->status == '배송준비')
                    <button type="button" class="btn btn-danger btn-xs btn__cancel"
                            value="{{ $data->id }}">취소
                    </button>
                @endif
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