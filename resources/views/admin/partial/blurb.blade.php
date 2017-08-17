<div class="row">
    <div class="col-sm-6">
        @if($blurb->attachments()->first())
            <img style="width: 100%" src="{{ $blurb->attachments()->first()->url }}" />
        @else
            이미지가 등록되지 않았습니다.
        @endif
    </div>
    <div class="col-sm-6">
        <form class="form-inline" method="post" action="{{ route('blurb.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $blurb->id }}"/>
            <div class="form-inline">
                <div class="form-group">
                    <label for="target">광고 위치</label>
                    <select class="form-control" name="target">
                        <option {{ isset($blurb) ? '' : 'selected' }}>---- 선택하세요 ----</option>
                        <option value="1" {{ isset($blurb) && $blurb->target == 1 ? 'selected' : '' }}>상단 빅 이미지</option>
                        <option value="2" {{ isset($blurb) && $blurb->target == 2 ? 'selected' : '' }}>그 아래 3개짜리</option>
                        <option value="3" {{ isset($blurb) && $blurb->target == 3 ? 'selected' : '' }}>하태하태(빅)</option>
                        <option value="4" {{ isset($blurb) && $blurb->target == 4 ? 'selected' : '' }}>하태하태(스몰)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="order">순서</label>
                    <input type="number" class="form-control" id="order" placeholder="비어있으면 만든 순서(숫자만)" name="order"
                           value="{{ $blurb->order }}">
                </div>
            </div>

            <div class="form-inline">
                <div class="form-group">
                    <label for="link">링크</label>
                    <input type="text" class="form-control" id="link" placeholder="http://naver.com" name="link"
                           value="{{ $blurb->link }}">
                </div>

                <div class="checkbox">
                    <label>
                        <input name="is_blank" type="checkbox" {{ $blurb->is_blank ? 'checked' : '' }}>
                        새창
                    </label>
                </div>
            </div>

            <div class="form-inline">
                <div class="form-group">
                    <label for="title">제목</label>
                    <input type="text" class="form-control" id="title" placeholder="하태하태 - 큰 글씨" name="title"
                           value="{{ $blurb->title }}">
                </div>

                <div class="form-group">
                    <label for="text1">텍스트1</label>
                    <input type="text" class="form-control" id="text1" placeholder="하태하태 - 작은 글씨" name="text1"
                           value="{{ $blurb->text1 }}">
                </div>

                <div class="form-group">
                    <label for="text2">텍스트2</label>
                    <input type="text" class="form-control" id="text2" placeholder="하태하태 - 노란 글씨" name="text2"
                           value="{{ $blurb->text2 }}">
                </div>
            </div>

            <div class="form-inline">
                <div class="form-group">
                    <label for="files">이미지 추가 및 수정</label>
                    <input type="file" id="files" name="files">
                    <p class="help-block">3MB로 제한</p>
                </div>
            </div>
            <button type="submit" class="btn btn-default">{{ $blurb->id ? '변경' : '작성' }}</button>

        </form>
    </div>
</div>
<hr />
