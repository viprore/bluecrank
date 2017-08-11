<div class="row product__id" data-id="{{ $product->id }}">
    <div class="col-md-4">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            @if($product->attachments->count() > 1)
                <ol class="carousel-indicators">
                    @foreach($product->attachments as $attachment)
                        <li data-target="#carousel-example-generic"
                            data-slide-to="{{ $loop->index }}"
                                {!! $loop->index == 0 ? 'class="active"' : '' !!}></li>
                    @endforeach
                </ol>
            @endif


        <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                @forelse($product->attachments as $attachment)
                    <div class="item {{ $loop->index == 0 ? 'active' : '' }}">
                        <img class="img-thumbnail" src="{{ $attachment->url }}" alt="">
                        <div class="carousel-caption"></div>
                    </div>
                @empty
                @endforelse

            </div>

            <!-- Controls -->
            {{--<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>--}}
        </div>
    </div>

    <div class="col-md-8 item_info">
        <h3>{{ '상품명 : ' . $product->ad_title }}</h3>
        <table class="table table-striped">
            <tr>
                <th>간략설명</th>
                <td>{!! $product->ad_short_description !!}</td>
            </tr>
            <tr>
                <th>카테고리</th>
                <td>{{ $product->category }}</td>
            </tr>
            <tr>
                <th>판매상태</th>
                <td>{{ $product->ad_status }}</td>
            </tr>
            <tr>
                <th>가격</th>
                <td>{{ number_format($product->price) }}&nbsp;원</td>
            </tr>
            <tr>
                <th>중고상품인가</th>
                <td>
                    @if($product->is_old)
                        그렇습네다
                    @else
                        아니라우
                    @endif
                </td>
            </tr>
        </table>

    </div>
</div>

<div class="form-group">
    <table class="table">
        <thead>
        <tr class="bg-success">
            <th class="text-center">#</th>
            <th class="text-center">색상</th>
            <th class="text-center">사이즈</th>
            <th class="text-center">수량</th>
            <th class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($product->options as $option)
            <tr class="item__option" name="options[{{ $loop->index }}]" data-id="{{ $option->id }}"
                id="option_{{ $option->id }}">
                <td name="id" class="text-center">{{ $option->id }}</td>
                <td class="text-center">{{ $option->color }}</td>
                <td class="text-center">{{ $option->size }}</td>
                <td class="text-center">{{ $option->inventory }}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-info button__option__edit" id="{{ $option->id }}">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger button__option__delete" id="{{ $option->id }}">
                        <i class="fa fa-minus-circle"></i>
                    </button>
                </td>
            </tr>

            <tr class="option__edit" hidden>
                <td class="text-center"><input type="hidden" name="id" id="id" class="form-control"
                                               value="{{ $option->id }}"/>{{ $option->id }}</td>
                <td>
                    <input type="text" name="color" id="color" class="form-control" placeholder="색상"
                           value="{{ $option->color }}"/>
                </td>
                <td>
                    <input type="text" name="size" id="size" class="form-control" placeholder="사이즈"
                           value="{{ $option->size }}"/>
                </td>
                <td>
                    <input type="number" name="inventory" id="inventory" class="form-control" placeholder="재고량"
                           value="{{ $option->inventory }}"/>
                </td>
                <td align="center">
                    <button type="button" class="btn btn-info button__option__update">
                        <i class="fa fa-check"></i>
                    </button>
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="5" class="text-center">
                    옵션이 존재하지 않습니다.
                </td>
            </tr>
        @endforelse
        <tr class="option__input" hidden>
            <td></td>
            <td>
                <input type="text" name="color" id="color" class="form-control" placeholder="색상"/>
            </td>
            <td>
                <input type="text" name="size" id="size" class="form-control" placeholder="사이즈"/>
            </td>
            <td>
                <input type="number" name="inventory" id="inventory" class="form-control" placeholder="재고량"/>
            </td>
            <td align="center">
                <button type="button" class="btn btn-info button__option__create">
                    <i class="fa fa-check"></i>
                </button>
            </td>
        </tr>

        <tr>
            <td colspan="5" class="text-center">
                <button type="button" class="btn btn-warning button__option__add">
                    <i class="fa fa-plus-circle"></i>
                    옵션 추가하기
                </button>

                <a href="{{ route($prefix.'show', $product->id) }}" class="btn btn-primary">
                    <i class="fa fa-eye"></i>
                    상품 보기
                </a>
            </td>
        </tr>

        </tbody>
    </table>
</div>
@section('script')
    @parent
    <script>
        $('.button__option__create').on('click', function (e) {
            var productId = $('.product__id').data('id');
            var color = $(this).parent('td').parent('tr').find('#color').val(),
                size = $(this).parent('td').parent('tr').find('#size').val(),
                inventory = $(this).parent('td').parent('tr').find('#inventory').val();

            var params = {
                color: color,
                size: size,
                inventory: inventory
            };

            if (confirm(productId + '옵션을 등록합니다\n' + color + ' - (' + size + ') // ' + inventory + '개')) {
                $.ajax({
                    type: 'POST',
                    url: "/{{ str_contains($prefix, 'olds') ? 'olds' : 'products' }}/" + productId + "/options",
                    data: params,
                    success: function () {
                        location.reload();
                    }

                }).then(function () {

                });
            }

        });

        $('.button__option__delete').on('click', function () {
            var optionId = $(this).closest('.item__option').data('id');
            alert(optionId);

            if (confirm('옵션을 삭제합니다.')) {
                $.ajax({
                    type: 'DELETE',
                    url: "/options/" + optionId
                }).then(function () {
                    $('#option_' + optionId).hide();
                });
            }
        });

        $('.button__option__update').on('click', function (e) {
            var optionId = $(this).parent('td').parent('tr').find('#id').val();
            var color = $(this).parent('td').parent('tr').find('#color').val(),
                size = $(this).parent('td').parent('tr').find('#size').val(),
                inventory = $(this).parent('td').parent('tr').find('#inventory').val();

            var params = {
                color: color,
                size: size,
                inventory: inventory
            };

            if (confirm(optionId + '옵션을 수정합니다\n' + color + ' - (' + size + ') // ' + inventory + '개')) {
                $.ajax({
                    type: 'PUT',
                    url: "/options/" + optionId,
                    data: params,
                    success: function () {
                        location.reload();
                    }

                }).then(function () {

                });
            }

        });

        $('.button__option__edit').on('click', function (e) {
            $(this).closest('.item__option').hide();
            $(this).closest('.item__option').next('.option__edit').show();

        });

        $('.button__option__add').on('click', function (e) {
            opt_form = $('.button__option__create');
            opt_form.parent('td').parent('tr').find('#color').val('');
            opt_form.parent('td').parent('tr').find('#size').val('');
            opt_form.parent('td').parent('tr').find('#inventory').val('');

            $('.option__input').show();
        });
    </script>
@stop
