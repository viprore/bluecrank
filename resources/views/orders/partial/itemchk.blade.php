<div class="panel panel-default">
    <div class="panel-heading">
        <a id="temp" class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-container"
           href="#panel-element-itemchk">구매상품 확인</a>
    </div>
    <div id="panel-element-itemchk" class="panel-collapse collapse">
        <div class="panel-body">
            @forelse($items as $item)
                <div class="row">
                    <div class="col-xs-3">
                        <img src="{{ $item->option->product->attachments->count() > 0 ? $item->option->product->attachments->first()->url : 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQlzvW0rg_vTZkwz20Ot15G_zcKgx2L5DTtgUNPOrArVnPjpRoJiK8hJZc' }}"
                             class="img-thumbnail w-100">
                    </div>
                    <div class="col-xs-9">
                        <dl>
                            <dt>{{ $item->option->product->ad_title }}</dt>
                            <dd>색상 : {{ $item->option->color }} // 사이즈
                                : {{ $item->option->size }}</dd>
                            <dt>가격(수량 {{ $item->count }}개)</dt>
                            <dd>{{ $item->option->product->price * ($currentUser->isStudent() ? 0.9 : 1) * $item->count }}원</dd>
                        </dl>
                    </div>
                </div>
            @empty
            @endforelse
            <div class="padding-side text-right">
                <div><p class="text-danger" id="validation-error"></p></div>
                <button type="button" class="btn btn-primary" data-toggle="collapse"
                        data-parent="#panel-container" data-target="#panel-element-final">다음
                </button>
            </div>
        </div>
    </div>
</div>