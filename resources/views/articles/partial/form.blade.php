<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title">제목</label>
    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="form-control"/>
    {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
    <label for="tags">태그</label>
    <select name="tags[]" id="tags" multiple="multiple" class="form-control">
        @foreach($articleTags as $tag)
            <option value="{{ $tag->id }}" {{ $article->tags->contains($tag->id) ? 'selected="selected"' : '' }}>
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('tags', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
    <label for="content">본문</label>

    <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $article->content) }}</textarea>
    {!! $errors->first('content', '<span class="form-error">:message</span>') !!}

    {{--마크다운 컴파일 결과 미리보기--}}
    <div class="preview__content">
        {!! markdown(old('content', '...')) !!}
    </div>
</div>




<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="notification" value="{{ old('notification', $article->notification) }}">
            댓글이 작성되면 이메일 알림 받기
        </label>
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
            element: document.getElementById("content"),
//            autofocus: false,
//            autosave: {
//                enabled: true,
//                uniqueId: "content_as",
//                delay: 1000,
//            },
            forceSync: true,
//            hideIcons: ["guide", "heading"],
//            initialValue: "Hello world!",
//            insertTexts: {
//                horizontalRule: ["", "\n\n-----\n\n"],
//                image: ["![](http://", ")"],
//                link: ["[", "](http://)"],
//                table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
//            },
//            lineWrapping: false,
//            parsingConfig: {
//                allowAtxHeaderWithoutSpace: true,
//                strikethrough: false,
//                underscoresBreakWords: true,
//            },
            placeholder: "입력하세요",
//            previewRender: function(plainText) {
//                return customMarkdownParser(plainText); // Returns HTML from a custom parser
//            },
            previewRender: function(plainText, preview) { // Async method
                setTimeout(function(){
                    preview.innerHTML = customMarkdownParser(plainText);
                }, 250);

                return "Loading...";
            },
            promptURLs: true,
//            renderingConfig: {
//                singleLineBreaks: false,
//                codeSyntaxHighlighting: true,
//            },
//            shortcuts: {
//                drawTable: "Alt-T"
//            },
//            showIcons: ["code", "table"],
            spellChecker: false,
//            status: true,
//            status: ["autosave", "lines", "words", "cursor"], // Optional usage
//            status: ["autosave", "lines", "words", "cursor", {
//                className: "keystrokes",
//                defaultValue: function(el) {
//                    this.keystrokes = 0;
//                    el.innerHTML = "0 Keystrokes";
//                },
//                onUpdate: function(el) {
//                    el.innerHTML = ++this.keystrokes + " Keystrokes";
//                }
//            }], // Another optional usage, with a custom status bar item that counts keystrokes
//            styleSelectedText: true,
//            tabSize: 4,
//            toolbar: true,
//            toolbarTips: true,
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
                article_id: '{{ $article->id }}'
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
                    handleContent('content', data[i].url);
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
                    handleContent('content', data.url, true);
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
        }

//        var simplemde = new SimpleMDE({
//            element: document.getElementById("content")
//        });

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

        /* select2 */
        $('#tags').select2({
            placeholder: '태그를 선택하세요',
            maximumSelectionLength: 1
        });

        /* 이메일 알림 체크박스 조작 */
        var notifyElem = $('input[name="notification"]');

        notifyElem.on('click', function (e) {
            var self = $(this),
                turnOn = self.val() ? false : true;

            if (turnOn) {
                self.val(1);
                self.attr('checked', 'checked');
            } else {
                self.removeAttr('value');
                self.removeAttr('checked');
            }
        });

        if (Laravel.currentRouteName == 'articles.create') {
            notifyElem.val(1);
        }

        if (notifyElem.val()) {
            notifyElem.attr('checked', 'checked');
        }



    </script>
@stop
