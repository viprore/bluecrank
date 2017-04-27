@php
    $productStatus = ['S', 'A', 'B', 'C', 'D'];
    $brands = config('project.brands');
    $sizes = config('project.sizes');
@endphp

<div class="form-group {{ $errors->has('ad_title') ? 'has-error' : '' }}">
    <label for="ad_title">제목</label>
    <input type="text" name="ad_title" id="ad_title" value="{{ old('ad_title', $market->ad_title) }}"
           class="form-control"/>
    {!! $errors->first('ad_title', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="price">가격</label>
    <input type="text" name="price" id="price" value="{{ old('price', $market->price) }}"
           onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;'
           class="form-control"/>
    {!! $errors->first('price', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('product_status') ? 'has-error' : '' }}">
    <label for="product_status">상품 상태</label>
    <select name="product_status[]" id="product_status" class="form-control">
        @foreach($productStatus as $status)
            <option value="{{ $status }}" {{ $market->product_status===$status ? 'selected="selected"' : '' }}>
                {{ $status }}
                @if($status === 'S') - 미개봉 / 새 상품
                @elseif($status === 'A') - 별로 사용도 안함
                @elseif($status === 'B') - 관리가 잘 된
                @elseif($status === 'C') - 쓸만한
                @else - 사용할 수 있는
                @endif
            </option>
        @endforeach
    </select>
    {!! $errors->first('product_status', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
    <label for="category">카테고리</label>
    <select name="category[]" id="category" class="form-control">
        @foreach($categories as $slug => $locale)
            <option value="{{ $slug }}" {{ $market->category===$slug ? 'selected="selected"' : '' }}>
                {{ $locale[$currentLocale] }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('category', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('brand') ? 'has-error' : '' }}">
    <label for="brands">브랜드</label>
    <select name="brands[]" id="brands" class="form-control">
        @foreach($brands as $brand)
            <option value="{{ $brand }}" {{ $market->brand===$brand ? 'selected="selected"' : '' }}>
                {{ $brand }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('brand', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('model') ? 'has-error' : '' }}">
    <label for="model">모델명</label>
    <input type="text" name="model" id="model" value="{{ old('model', $market->model) }}"
           class="form-control"/>
    {!! $errors->first('model', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('size') ? 'has-error' : '' }}">
    <label for="sizes">사이즈</label>
    <select name="sizes[]" id="sizes" class="form-control">
        @foreach($sizes as $size)
            <option value="{{ $size }}" {{ $market->size===$size ? 'selected="selected"' : '' }}>
                {{ $size }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('size', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
    <label for="tags">태그</label>
    <select name="tags[]" id="tags" multiple="multiple" class="form-control">
        @foreach($marketTags as $tag)
            <option value="{{ $tag->id }}" {{ $market->tags->contains($tag->id) ? 'selected="selected"' : '' }}>
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('tags', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <input type="checkbox" name="chk_direct" id="is_direct">
            <label for="is_direct">&nbsp;직거래</label>
            <input type="text" name="trading_place" id="trading_place" class="form-control"
                   placeholder="추가정보(ex : 지역, 지하철 역)">
        </div>
        <div class="col-md-4">
            <input type="checkbox" name="chk_ship" id="is_ship">
            <label for="is_ship">&nbsp;배송</label>
            <input type="text" name="ship_price" id="ship_price" class="form-control" placeholder="포함, 착불 등">
        </div>
        <div class="col-md-4">
            <input type="checkbox" name="chk_trade" id="is_trade">
            <label for="is_trade">&nbsp;대차</label>
            <input type="text" name="trading_what" id="trading_what" class="form-control" placeholder="LG G2 + 가격">
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">본문</label>
    <textarea name="description" id="description" rows="10"
              class="form-control">{{ old('content', $market->description) }}</textarea>
    {!! $errors->first('description', '<span class="form-error">:message</span>') !!}

    {{--마크다운 컴파일 결과 미리보기--}}
    <div class="preview__content">
        {!! markdown(old('description', '미리보기')) !!}
    </div>
</div>


@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@stop
@section('script')
    @parent
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        var simplemde = new SimpleMDE({
            element: document.getElementById("description"),
            forceSync: true,
            placeholder: "입력하세요",

            promptURLs: true,
            spellChecker: false,
        });

        $(document).ready(function () {
            if ($("input:checkbox[id='is_direct']").is(":checked")) {
                $('#trading_place').show();
            } else {
                $('#trading_place').hide();
            }
            if ($("input:checkbox[id='is_ship']").is(":checked")) {
                $('#ship_price').show();
            } else {
                $('#ship_price').hide();
            }
            if ($("input:checkbox[id='is_trade']").is(":checked")) {
                $('#trading_what').show();
            } else {
                $('#trading_what').hide();
            }
        });

        $('#categories').select2({
            placeholder: '카테고리를 선택하세요'
        });
        $('#brands').select2({
            placeholder: '브랜드를 선택하세요'
        });
        $('#sizes').select2({
            placeholder: '사이즈를 선택하세요'
        });
        $('#tags').select2({
            placeholder: '  자전거의 테마를 선택하세요(최대 3개)',
            maximumSelectionLength: 3
        });


        $("input:checkbox[id='is_direct']").click(function () {
            if ($("input:checkbox[id='is_direct']").is(":checked")) {
                $('#trading_place').show();
            } else {
                $('#trading_place').hide();
            }
        });

        $("input:checkbox[id='is_ship']").click(function () {
            if ($("input:checkbox[id='is_ship']").is(":checked")) {
                $('#ship_price').show();
            } else {
                $('#ship_price').hide();
            }
        });

        $("input:checkbox[id='is_trade']").click(function () {
            if ($("input:checkbox[id='is_trade']").is(":checked")) {
                $('#trading_what').show();
            } else {
                $('#trading_what').hide();
            }
        });

        function onlyNumber(event) {
            event = event || window.event;
            var keyID = (event.which) ? event.which : event.keyCode;
            if ((keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39)
                return;
            else
                return false;
        }
        function removeChar(event) {
            event = event || window.event;
            var keyID = (event.which) ? event.which : event.keyCode;
            if (keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39)
                return;
            else
                event.target.value = event.target.value.replace(/[^0-9]/g, "");
        }
    </script>
@stop
