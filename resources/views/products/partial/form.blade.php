<div class="form-group {{ $errors->has('ad_title') ? 'has-error' : '' }}">
    <label for="ad_title">상품 제목</label>
    <input type="text" name="ad_title" id="ad_title" value="{{ old('ad_title', $product->ad_title) }}"
           class="form-control"/>
    {!! $errors->first('ad_title', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('ad_short_description') ? 'has-error' : '' }}">
    <label for="ad_short_description">간략 소개</label>
    <textarea name="ad_short_description" id="ad_short_description" rows="3"
              class="form-control">{{ old('ad_short_description', $product->ad_short_description) }}</textarea>
    {!! $errors->first('ad_short_description', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('ad_status') ? 'has-error' : '' }}">
    <label for="status">상태</label>
    <select name="ad_status" id="ad_status" class="form-control">
        <option value="준비중" {{ $product->ad_status==='준비중' ? 'selected="selected"' : '' }}>준비중</option>
        <option value="판매" {{ $product->ad_status==='판매' ? 'selected="selected"' : '' }}>판매</option>
        <option value="매진" {{ $product->ad_status==='매진' ? 'selected="selected"' : '' }}>매진</option>
    </select>
</div>

<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
    <label for="category">카테고리</label>
    <select name="category" id="category" class="form-control">
        @foreach($categories as $slug => $locale)
            <option value="{{ $slug }}" {{ $product->category===$slug ? 'selected="selected"' : '' }}>
                {{ $locale[$currentLocale] }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('category', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="price">가격</label>
    <input type="text" name="price" id="price" value="{{ old('price', $product->price) }}"
           onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;'
           class="form-control"/>
    {!! $errors->first('price', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
    <label for="tags">태그</label>
    <select name="tags[]" id="tags" multiple="multiple" class="form-control">

        @foreach($productTags as $tag)
            <option value="{{ $tag->id }}" {{ $product->tags->contains($tag->id) ? 'selected="selected"' : '' }}>
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('tags', '<span class="form-error">:message</span>') !!}
</div>

@if($viewName == 'products.edit')
    <div class="form-group">
        <label for="description">첨부된 이미지들</label>
        <table class="table text-center">
            <thead>
            <tr>
                <th class="text-center">파일명</th>
                <th class="text-center">대표</th>
                <th class="text-center">삭제</th>
            </tr>
            </thead>
            <tbody>
            @forelse($product->attachments as $attachment)
                <tr>
                    <td><a href="{{ $attachment->url }}">{{ $attachment->filename }}</a></td>
                    <td>
                        @if($product->attachments->first() == $attachment)
                            <button type="button" class="btn btn-success"><i class="fa fa-check"></i></button>
                        @else
                            <button type="button" class="btn btn-default" onclick="setMainImage({{ $attachment->id }})">
                                <i class="fa fa-check"></i></button>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn__del"
                                onclick="deleteAttachment({{ $attachment->id }})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
@endif


<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">본문</label>
    <textarea name="description" id="description" rows="10"
              class="form-control">{{ old('description', $product->description) }}</textarea>
    {!! $errors->first('description', '<span class="form-error">:message</span>') !!}

    {{--마크다운 컴파일 결과 미리보기--}}
    <div class="preview__content">
        {!! markdown(old('description', '미리보기')) !!}
    </div>
</div>

<div class="form-group">
    <label for="my-dropzone">파일
        <small class="text-muted">
            <i class="fa fa-chevron-down"></i>
            열기
        </small>
        <small class="text-muted" style="display: none;">
            <i class="fa fa-chevron-up"></i>
            닫기
        </small>
    </label>

    <div id="my-dropzone" class="dropzone"></div>
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

        var form = $('form').first(),
            dropzone = $('div.dropzone'),
            dzControl = $('label[for=my-dropzone]>small');

        /* Dropzone */
        Dropzone.autoDiscover = false;

        // 드롭존 인스턴스 생성.
        var myDropzone = new Dropzone('div#my-dropzone', {
            url: '/attachments',
            paramName: 'files',
            maxFilesize: 3,
            acceptedFiles: '.{{ implode(',.', config('project.mimes')) }}',
            uploadMultiple: true,
            params: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: '{{ $product->id }}'
            },
            dictDefaultMessage: '<div class="text-center text-muted">' +
            "<h2>첨부할 파일을 끌어다 놓으세요!</h2>" +
            "<p>(또는 클릭하셔도 됩니다.)</p></div>",
            dictFileTooBig: "파일당 최대 크기는 3MB입니다.",
            dictInvalidFileType: '{{ implode(',', config('project.mimes')) }} 파일만 가능합니다.',
            addRemoveLinks: true
        });

        // 파일 업로드 성공 이벤트 리스너.
        myDropzone.on('successmultiple', function (file, data) {
            for (var i = 0, len = data.length; i < len; i++) {
                // 책에 있는 'attachments[]' 숨은 필드 추가 로직을 별도 메서드로 추출했다.
                handleFormElement(data[i].id);

                // 책에 없는 내용
                // 성공한 파일 애트리뷰트를 파일 인스턴스에 추가
                file[i]._id = data[i].id;
                file[i]._name = data[i].filename;
                file[i]._url = data[i].url;

                // 책에 없는 내용
                // 이미 파일일 경우 handleContent() 호출.
                if (/^image/.test(data[i].mime)) {
                    handleContent('description', data[i].url);
                }
            }
        });

        // 파일 삭제 이벤트 리스너.
        myDropzone.on('removedfile', function (file) {
            // 사용자가 이미지를 삭제하면 UI의 DOM 레벨에서 사라진다.
            // 서버에서도 삭제해야 하므로 Ajax 요청한다.
            $.ajax({
                type: 'DELETE',
                url: '/attachments/' + file._id
            }).then(function (data) {
                handleFormElement(data.id, true);

                if (/^image/.test(data.mime)) {
                    handleContent('description', data.url, true);
                }
            })
        });

        // 'attachments[]' 숨은 필드를 만들거나 제거한다.
        var handleFormElement = function (id, remove) {
            if (remove) {
                $('input[name="attachments[]"][value="' + id + '"]').remove();

                return;
            }

            $('<input>', {
                type: 'hidden',
                name: 'attachments[]',
                value: id
            }).appendTo(form);
        };

        // 컨텐트 영역의 캐럿 위치에 이미지 마크다운을 삽입한다.
        var handleContent = function (objId, imgUrl, remove) {
            var caretPos = document.getElementById(objId).selectionStart;
            var content = $('#' + objId).val();
            var imgMarkdown = '![](' + imgUrl + ')';
            if (remove) {
                $('#' + objId).val(
                    content.replace(imgMarkdown, '')
                );
                simplemde.value($('#' + objId).val());
                return;
            }
            $('#' + objId).val(
                content.substring(0, caretPos) +
                imgMarkdown + '\n' +
                content.substring(caretPos)
            );
            simplemde.value($('#' + objId).val());
        };

        // 드롭존의 가시성을 토글한다.
        dzControl.on('click', function (e) {
            dropzone.fadeToggle(0);
            dzControl.fadeToggle(0);
        });


        $('#tags').select2({
            placeholder: '자전거 태그를 선택하세요(최대 3개)',
            maximumSelectionLength: 3
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

        // 상단 스크롤 헤더 숨기기
        simplemde.codemirror.on("focus", function () {
            if (simplemde.isFullscreenActive()) {
                $('.navbar').hide();
            } else {
                $('.navbar').show();
            }
        });

        function setMainImage(id) {
            $.ajax({
                type: 'PUT',
                url: '/attachments/' + id
            }).then(function (data) {

                location.reload();
            })
        }

        function deleteAttachment(id) {
            $.ajax({
                type: 'DELETE',
                url: '/attachments/' + id
            }).then(function (data) {
                location.reload();
            })
        }
    </script>
@stop
