<style>
    /* Common */
    .navbar-default {
        border-color: transparent;
    }

    .li-divider {
        float: left;
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .navbar-default .navbar-nav > li > a {
        font-size: 1.1em;
    }

    .navbar-default .navbar-nav > .active > a,
    .navbar-default .navbar-nav > .active > a:hover,
    .navbar-default .navbar-nav > .active > a:focus {
        font-size: 1.1em;
        color: #4253da;
        background-color: #ffffff;
        font-weight: bold;
    }

    /* 상단 네비게이션 */
    .nav-top > .navbar-collapse {
        padding-left: 0;
        padding-right: 0;
    }

    .navbar-default .nav-top .navbar-left > li > a {
        font-size: 0.8em;
    }

    .nav-top .nav-left > li > a {
        padding-left: 0;
        padding-right: 14px;
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .nav-top .fa-star {
        font-size: 1.3em;
        padding-right: 4px;
        color: #ffd511;
    }

    .nav-top .fa-youtube {
        font-size: 1.3em;
        padding-right: 4px;
        color: #e62117;
    }

    .nav-top .fa-facebook-square {
        font-size: 1.3em;
        padding-right: 4px;
        color: #3b5998;
    }

    /* 중단 네비게이션 */
    @media (min-width: 768px) {
        .navbar-form-alt > .form-group > .input-group {
            padding-right: 20%;
            padding-left: 20%;
            padding-top: 12px;
        }

        .navbar-default .nav-product > li > a {
            padding-left: 0.6em;
            padding-right: 0.6em;
        }


    }

    @media (min-width: 992px) {
        .navbar-form-alt > .form-group > .input-group {
            padding-right: 7%;
            padding-left: 7%;
            padding-top: 0;
        }

        .navbar-default .nav-product > li > a {
            padding-left: 1em;
            padding-right: 1em;
        }
    }

    @media (min-width: 1200px) {
        .navbar-form-alt > .form-group > .input-group {
            padding-right: 12%;
            padding-left: 12%;
            padding-top: 0;
        }

        .navbar-default .nav-product > li > a {
            padding-left: 2em;
            padding-right: 2em;
        }
    }

    .navbar-brand {
        margin-left: 0;
        padding: 0;
    }

    .navbar-brand > img {
        height: 60px;
        padding: 12px;
    }

    .form-search, .btn-nav-search {
        border: transparent;
    }

    .form-search, .form-search:focus {
        height: 34px;
        box-shadow: none;
        border-radius: 0;
        border-top: 2px solid #374dda;
        border-left: 2px solid #374dda;
        border-bottom: 2px solid #374dda;
    }

    .btn-nav-search {
        padding: 0;
        height: 34px;
        width: 34px;
        color: #374dda;
        border-radius: 0;
        border-top: 2px solid #374dda;
        border-right: 2px solid #374dda;
        border-bottom: 2px solid #374dda;
    }

    .btn-nav-search:hover {
        color: #5f73da;
        background-color: transparent;
        border-color: #374dda;
    }

    .navbar-form-alt {
        margin: 8px 0;
    }

    .search-tag {
        padding-top: 0;
    }

    .search-tag > a {

        font-size: 0.8em;
        color: #777;
        text-decoration: none;
    }

    .search-tag > a:hover {
        color: #777;
        text-decoration: none;
    }

    .a-divider {
        text-decoration: none;
    }

    .navbar-default .navbar-nav > .active > a,
    .navbar-default .navbar-nav > .active > a:hover,
    .navbar-default .navbar-nav > .active > a:focus {
        color: #4253da;
        background-color: #ffffff;
        font-weight: bold;
    }

    .nav-middle {
        border-bottom: #475cdd solid 2px;
    }

    /* 하단 네비게이션 */
    .nav-product {
        float: none;
        margin: 0 auto;
        display: block;
        text-align: center;
    }

    .nav-product > li {
        display: inline-block;
        float: none;
    }

    .navbar-default .nav-product > li > a,
    .navbar-default .nav-product > li > a:hover,
    .navbar-default .nav-product > li > a:focus {
        font-size: 1em;
        color: #333333;
        background-color: #ffffff;
        font-weight: bold;
    }

    .navbar-default .nav-product > .active > a,
    .navbar-default .nav-product > .active > a:hover,
    .navbar-default .nav-product > .active > a:focus {
        font-size: 1em;
        color: #4253da;
        background-color: #ffffff;
        font-weight: bold;
    }

    .nav-bottom {
        border-bottom: #dddddd solid 1px;
    }

    @media (max-width: 768px) {
        .navbar-brand > img {
            height: 58px;
            padding: 14px;
        }

        .navbar-toggle {
            margin-right: 4px;
        }
    }
</style>

<nav id="header" class="navbar navbar-default navbar-static-top-top">
    <div class="container nav-top">
        <div class="collapse navbar-collapse hidden-xs">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="javascript:bookmarksite('블루크랭크 - 온라인으로 구매하고 집 근처 패밀리 매장에서 받자', 'http://bluecrank.kr');"
                       title="블루크랭크를 즐겨찾기에 추가합니다">
                        <i class="fa fa-star" aria-hidden="true"></i>즐겨찾기
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/channel/UCBdW7aGayrA37xHzenn9__w" target="_blank" title="블루크랭크 유튜브">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e5/YouTube_arrow_flat.png" style="height: 1.5em; width: 1.5em; padding-bottom: 3px;"/>
                        {{--<i class="fa fa-youtube" aria-hidden="true"></i>--}}유튜브
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/bIuecrank/" target="_blank" title="블루크랭크 페이스북">
                        <i class="fa fa-facebook-square" aria-hidden="true"></i>페이스북
                    </a>
                </li>


            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check() && Auth::user()->isAdmin())
                    <li {!! str_contains(request()->path(), 'admin') ? 'class="active"' : '' !!}>
                        <a href="{{ route('admin.index') }}" title="관리자 페이지">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </a>
                    </li>
                @endif
                <li {!! str_contains(request()->path(), 'carts') ? 'class="active"' : '' !!}>
                    <a href="{{ route('carts.index') }}" title="카트">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </a>
                </li>
                <li {!! str_contains(request()->path(), 'wants') ? 'class="active"' : '' !!}>
                    <a href="{{ route('wants.index') }}" title="관심목록">
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                    </a>
                </li>

                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li {!! str_contains(request()->path(), 'auth/login') ? 'class="active"' : '' !!}>
                        <a href="{{ route('sessions.create', ['return' => urlencode($currentUrl)]) }}">
                            <i class="fa fa-power-off" aria-hidden="true"></i>
                        </a>
                    </li>
                @else

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if(Auth::user()->isAdmin())

                            @endif

                            <li>
                                <a href="{{ route('orders.index') }}">
                                    주문내역
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    작성글 관리
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('sessions.destroy') }}">
                                    로그아웃
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="container-fluid nav-middle">
        <div class="container">
            <!-- 브랜드 이미지 및 모바일시 접는 메뉴 -->
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button data-target="#user-menu" type="button" class="navbar-toggle collapsed" data-toggle="collapse">
                    &nbsp;<i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                </button>
                <button data-target="#site-menu" type="button" class="navbar-toggle collapsed" data-toggle="collapse">
                    &nbsp;<i class="fa fa-sitemap" aria-hidden="true"></i>&nbsp;
                </button>
                <button data-target="#product-menu" type="button" class="navbar-toggle collapsed"
                        data-toggle="collapse">
                    &nbsp;<i class="fa fa-list" aria-hidden="true"></i>&nbsp;

                </button>


                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ auth()->check() ? route('root') : route('root') }}">
                    {{--<b>B L U E C R A N K</b>--}}
                    <img src="{{ url('icons/' .  'brand.png') }}"/>
                    {{--{{ config('project.name', 'Laravel') }}--}}
                </a>
            </div>

            <div class="collapse navbar-collapse hidden-xs">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check() && Auth::user()->isStudent())
                        <li {!! str_contains(request()->path(), 'secrets') ? 'class="active"' : '' !!}>
                            <a href="{{ route('secrets.index') }}">
                                교육생몰
                            </a>
                        </li>
                        <div class="li-divider hidden-xs">|</div>
                    @endif
                    <li {!! str_contains(request()->path(), 'shops') ? 'class="active"' : '' !!}>
                        <a href="{{ route('shops.index') }}">
                            패밀리샵
                        </a>
                    </li>
                    <div class="li-divider hidden-xs">|</div>
                    <li>
                        <a href="#">
                            이벤트
                        </a>
                    </li>
                    <div class="li-divider hidden-xs">|</div>
                    <li {!! str_contains(request()->path(), ['tags', 'articles']) ? 'class="active"' : '' !!}>
                        <a href="{{ route('articles.index') }}">
                            커뮤니티
                        </a>
                    </li>
                </ul>

                <form method="get" action="{{ route('products.search') }}" role="search" class="navbar-form-alt hidden-xs">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control form-search" placeholder="SCR2 Plus">
                            <span class="input-group-btn">
                                    <button class="btn btn-default btn-nav-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>

                        <div class="row search-tag text-center">
                            <a href="{{ route('products.index') }}?slug=giant">자이언트</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('products.index') }}?slug=canon">캐논데일</a><u
                                    class="a-divider hidden-md">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</u>
                            <a class="hidden-md" href="#">SCR2</a><u class="a-divider hidden-md">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</u>
                            <a class="hidden-md" href="{{ route('products.index') }}?slug=fuji">후지</a>
                        </div>


                    </div>
                </form>


            </div>
            <div class="visible-xs hidden-xs">
                <div class="collapse navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li {!! str_contains(request()->path(), 'auth/login') ? 'class="active"' : '' !!}>
                                <a href="{{ route('sessions.create', ['return' => urlencode($currentUrl)]) }}">
                                    로그인
                                </a>
                            </li>
                        @else

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if(Auth::user()->isAdmin())

                                    @endif

                                    <li>
                                        <a href="{{ route('orders.index') }}">
                                            주문내역
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            작성글 관리
                                        </a>
                                    </li>


                                    <li>
                                        <a href="{{ route('sessions.destroy') }}">
                                            로그아웃
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <li {!! str_contains(request()->path(), 'admin') ? 'class="active"' : '' !!}>
                                <a href="{{ route('admin.index') }}" title="관리자 페이지">
                                    관리자
                                </a>
                            </li>
                        @endif
                        <li {!! str_contains(request()->path(), 'carts') ? 'class="active"' : '' !!}>
                            <a href="{{ route('carts.index') }}" title="카트">
                                카트
                            </a>
                        </li>
                        <li {!! str_contains(request()->path(), 'wants') ? 'class="active"' : '' !!}>
                            <a href="{{ route('wants.index') }}" title="관심목록">
                                관심목록
                            </a>
                        </li>


                    </ul>
                </div>
            </div>


        </div>
    </div>
    <div class="container-fluid nav-bottom">
        <div class="container">
            <div class="collapse navbar-collapse" id="product-menu">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav nav-product">

                    <li {!! request()->path() == 'tags' ? 'class="active"' : '' !!}>
                        <a href="{{ route('tags.index') }}">
                            #인기태그
                        </a>
                    </li>
                    <li {!! str_contains(request()->path(), 'road/products') ? 'class="active"' : '' !!}>
                        <a href="{{ route('categories.products.index', 'road') }}">
                            로드
                        </a>
                    </li>
                    <li {!! str_contains(request()->path(), 'mtb/products') ? 'class="active"' : '' !!}>
                        <a href="{{ route('categories.products.index', 'mtb') }}">
                            MTB
                        </a>
                    </li>
                    <li {!! str_contains(request()->path(), 'hybrid/products') ? 'class="active"' : '' !!}>
                        <a href="{{ route('categories.products.index', 'hybrid') }}">
                            하이브리드
                        </a>
                    </li>
                    <li {!! str_contains(request()->path(), 'bacc/products') ? 'class="active"' : '' !!}>
                        <a href="{{ route('categories.products.index', 'bacc') }}">
                            자전거 용품
                        </a>
                    </li>
                    <li {!! str_contains(request()->path(), 'racc/products') ? 'class="active"' : '' !!}>
                        <a href="{{ route('categories.products.index', 'racc') }}">
                            라이더 용품
                        </a>
                    </li>
                    <li {!! str_contains(request()->path(), 'part/products') ? 'class="active"' : '' !!}>
                        <a href="{{ route('categories.products.index', 'part') }}">
                            미니벨로/기타
                        </a>
                    </li>
                    <li {!! str_contains(request()->path(), 'olds') ? 'class="active"' : '' !!}>
                        <a href="{{ route('olds.index') }}">
                            중고장터
                        </a>
                    </li>
                </ul>

                <hr class="visible-xs" />
                <form method="get" action="{{ route('products.search') }}" role="search" class="navbar-form-alt visible-xs">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control form-search" placeholder="SCR2 Plus">
                            <span class="input-group-btn">
                                    <button class="btn btn-default btn-nav-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>

                        <div class="row search-tag text-center">
                            <a href="{{ route('products.index') }}?slug=giant">자이언트</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('products.index') }}?slug=canon">캐논데일</a><u
                                    class="a-divider hidden-md">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</u>
                            <a class="hidden-md" href="#">SCR2</a><u class="a-divider hidden-md">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</u>
                            <a class="hidden-md" href="{{ route('products.index') }}?slug=fuji">후지</a>
                        </div>


                    </div>
                </form>
            </div>

            <div class="visible-xs">
                <div class="collapse navbar-collapse" id="site-menu">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @if(Auth::check() && Auth::user()->isStudent())
                            <li {!! str_contains(request()->path(), 'secrets') ? 'class="active"' : '' !!}>
                                <a href="{{ route('secrets.index') }}">
                                    교육생몰
                                </a>
                            </li>
                            <div class="li-divider hidden-xs">|</div>
                        @endif
                        <li {!! str_contains(request()->path(), 'shops') ? 'class="active"' : '' !!}>
                            <a href="{{ route('shops.index') }}">
                                패밀리샵
                            </a>
                        </li>
                        <div class="li-divider hidden-xs">|</div>
                        <li>
                            <a href="#">
                                이벤트
                            </a>
                        </li>
                        <div class="li-divider hidden-xs">|</div>
                        <li {!! str_contains(request()->path(), ['tags', 'articles']) ? 'class="active"' : '' !!}>
                            <a href="{{ route('articles.index') }}">
                                커뮤니티
                            </a>
                        </li>
                    </ul>

                    <form method="get" action="{{ route('products.search') }}" role="search" class="navbar-form-alt hidden-xs">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control form-search" placeholder="SCR2 Plus">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-nav-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>

                            <div class="row search-tag text-center">
                                <a href="{{ route('products.index') }}?slug=giant">자이언트</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                <a href="{{ route('products.index') }}?slug=canon">캐논데일</a><u
                                        class="a-divider hidden-md">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</u>
                                <a class="hidden-md" href="#">SCR2</a><u class="a-divider hidden-md">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</u>
                                <a class="hidden-md" href="{{ route('products.index') }}?slug=fuji">후지</a>
                            </div>


                        </div>
                    </form>


                </div>
                <div class="collapse navbar-collapse" id="user-menu">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li {!! str_contains(request()->path(), 'auth/login') ? 'class="active"' : '' !!}>
                                <a href="{{ route('sessions.create', ['return' => urlencode($currentUrl)]) }}">
                                    로그인
                                </a>
                            </li>
                        @else

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if(Auth::user()->isAdmin())

                                    @endif

                                    <li>
                                        <a href="{{ route('orders.index') }}">
                                            주문내역
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            작성글 관리
                                        </a>
                                    </li>


                                    <li>
                                        <a href="{{ route('sessions.destroy') }}">
                                            로그아웃
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <li {!! str_contains(request()->path(), 'admin') ? 'class="active"' : '' !!}>
                                <a href="{{ route('admin.index') }}" title="관리자 페이지">
                                    관리자
                                </a>
                            </li>
                        @endif
                        <li {!! str_contains(request()->path(), 'carts') ? 'class="active"' : '' !!}>
                            <a href="{{ route('carts.index') }}" title="카트">
                                카트
                            </a>
                        </li>
                        <li {!! str_contains(request()->path(), 'wants') ? 'class="active"' : '' !!}>
                            <a href="{{ route('wants.index') }}" title="관심목록">
                                관심목록
                            </a>
                        </li>


                    </ul>
                </div>
            </div>

            {{--<div class="collapse navbar-collapse visible-xs" id="site-menu">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check() && Auth::user()->isStudent())
                        <li {!! str_contains(request()->path(), 'secrets') ? 'class="active"' : '' !!}>
                            <a href="{{ route('secrets.index') }}">
                                교육생몰
                            </a>
                        </li>
                        <div class="li-divider hidden-xs">|</div>
                    @endif
                    <li {!! str_contains(request()->path(), 'shops') ? 'class="active"' : '' !!}>
                        <a href="{{ route('shops.index') }}">
                            패밀리샵
                        </a>
                    </li>
                    <div class="li-divider hidden-xs">|</div>
                    <li>
                        <a href="#">
                            이벤트
                        </a>
                    </li>
                    <div class="li-divider hidden-xs">|</div>
                    <li {!! str_contains(request()->path(), ['tags', 'articles']) ? 'class="active"' : '' !!}>
                        <a href="{{ route('articles.index') }}">
                            커뮤니티
                        </a>
                    </li>
                </ul>

                <form method="get" action="{{ route('products.search') }}" role="search" class="navbar-form-alt hidden-xs">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control form-search" placeholder="SCR2 Plus">
                            <span class="input-group-btn">
                                    <button class="btn btn-default btn-nav-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>

                        <div class="row search-tag text-center">
                            <a href="{{ route('products.index') }}?slug=giant">자이언트</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('products.index') }}?slug=canon">캐논데일</a><u
                                    class="a-divider hidden-md">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</u>
                            <a class="hidden-md" href="#">SCR2</a><u class="a-divider hidden-md">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</u>
                            <a class="hidden-md" href="{{ route('products.index') }}?slug=fuji">후지</a>
                        </div>


                    </div>
                </form>


            </div>--}}
        </div>
    </div>


</nav>

<script type="text/javascript">

    function bookmarksite(title, url) {
        // Internet Explorer
        if (document.all) {
            window.external.AddFavorite(url, title);
        }
        // Google Chrome
        else if (window.chrome) {
            alert("크롬 브라우저의 경우 해당 기능을 지원하지 않습니다." +
                "\n대신 Ctrl+D키를 누르신 후 직접 북마크를 추가하실 수 있습니다.");
        }
        // Firefox
        else if (window.sidebar) // firefox
        {
            window.sidebar.addPanel(title, url, "");
        }
        // Opera
        else if (window.opera && window.print) { // opera
            var elem = document.createElement('a');
            elem.setAttribute('href', url);
            elem.setAttribute('title', title);
            elem.setAttribute('rel', 'sidebar');
            elem.click();
        }
    }
</script>
