<style>
    .ft-title {
        font-size: 14px;
        color: #333;
    }

    .ft-body {
        font-size: 12px;
        color: #888;
    }

    .ft-div {
        display: inline-block;
        vertical-align: top;
        float: none;
    }

    .btn-shop-info {
        background: #e6e6e6;
        color: #505050;
    }
</style>

<footer class="container footer__master">
    <ul class="list-inline pull-right">

    </ul>

    <div id="shop-info">
        <div class="row">
            <div class="col-sm-4 ft-div">
                <b class="ft-title">바이크아카데미학원</b>

                <p class="ft-body"><br/>(07212) 서울시 영등포구 선유로 258<br/>
                    대표 : 이상훈<br/>
                    사업자 등록번호 : 107-15-91150<br/>
                    통신판매업신고 : 2017-서울영등포-0671호<br/>
                    Tel : 02-2631-9910</p>
            </div>
            <div class="col-sm-4 ft-div">
                <b class="ft-title">고객센터</b>

                <p class="ft-body"><br/>상담 가능 시간 : 10:00~19:00 (토,일, 공휴일 휴무)<br/>
                    (01849) 서울 노원구 동일로 174길 27 305호<br/>
                    Tel : 0507-1453-7457<br/>
                    E-mail : bt.biketrade@gmail.com<br/>
                    KAKAO : <a href="http://pf.kakao.com/_DxnLmu">@블루크랭크</a></p>
            </div>
            <div class="col-sm-3 ft-div">
                <b class="ft-title">BANK INFO</b>

                <p class="ft-body"><br/>신한은행<br/>
                    110-274-824505<br/>
                    예금주 : 바이크아카데미학원(이상훈)</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <b><a href="{{ route('use.info') }}">이용약관</a>&nbsp;|&nbsp;
                <a href="{{ route('private.info') }}">개인정보 취급방침</a>&nbsp;|&nbsp;
                <a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp"
                      target="_blank">사업자 정보 확인</a></b>
            </div>
        </div>
    </div>



    <div class="row visible-xs-block visible-sm-block">
        <button type="button" id="toggle-shop-info" class="btn btn-block btn-shop-info">SHOP INFO ▼</button>
    </div>


</footer>

<div>
    <a type="button" id="back-to-top" href="#" class="btn btn-sm btn-primary back-to-top" title="Top">
        <i class="fa fa-chevron-up"></i>
    </a>
</div>

@section('script')
    @parent
    <script>
        $(window).on('load', function () {
            $('#toggle-shop-info').on('click', function () {
                $('#shop-info').slideToggle('fast');
                $('body,html').animate({scrollTop: $(document).height() }, 'fast');
            });
        });
    </script>
@endsection
