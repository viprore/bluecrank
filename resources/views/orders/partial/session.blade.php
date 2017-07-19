<div class="panel panel-default">
    <div class="panel-heading">
        <a class="panel-title" data-toggle="collapse" data-parent="#panel-container"
           href="#panel-element-session">비로그인 상태입니다</a>
    </div>
    <div id="panel-element-session" class="panel-collapse collapse in">
        <div class="panel-body text-center">
            <a class="btn btn-primary" href="{{ route('sessions.create') }}">로그인</a> :
            <button type="button" class="btn btn-default" data-toggle="collapse"
                    data-parent="#panel-container" data-target="#panel-element-shipinfo">비회원으로 계속
            </button>

        </div>
    </div>
</div>