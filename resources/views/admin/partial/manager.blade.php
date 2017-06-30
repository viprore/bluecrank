@if($status == '입금전')
    <form method="POST" action="{{ route('admin.orders.update', ['order' => $target, 'slug' => 'deposit']) }}"
          class="form-horizontal">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-xs btn-primary">입금완료</button>
    </form>
@endif

@if($status == '입금완료')
    <form method="POST" action="{{ route('admin.orders.update', ['order' => $target, 'slug' => 'checked']) }}"
          class="form-horizontal">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-xs btn-primary">배송준비</button>
    </form>
@endif

@if($status == '배송준비')
    <form method="POST" action="{{ route('admin.orders.update', ['order' => $target, 'slug' => 'prepare']) }}"
          class="form-inline">
        {{ csrf_field() }}
        <input type="text" id="shipcode" name="shipcode" placeholder="운송장번호" class="form-control"/>
        <button type="submit" class="btn btn-xs btn-primary btn__shipcode">배송중</button>
        {!! $errors->first('shipcode', '<span class="form-error">:message</span>') !!}
    </form>
@endif

@if($status == '배송중')
    <form method="POST" action="{{ route('admin.orders.update', ['order' => $target, 'slug' => 'shipping']) }}"
          class="form-horizontal">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-xs btn-primary">배송완료</button>
    </form>
@endif
