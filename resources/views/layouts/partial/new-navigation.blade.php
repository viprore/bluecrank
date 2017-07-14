<style>

    .navbar-default {
        border-color: transparent;
    }
    .nav-top {
        border-bottom: 1px solid black;
    }
    .li-divider {
        float: left;
        padding-top: 14px;
        padding-bottom: 14px;
    }
    .navbar-default .navbar-nav > .active > a,
    .navbar-default .navbar-nav > .active > a:hover,
    .navbar-default .navbar-nav > .active > a:focus {
        color: #555;
        background-color: #ffffff;
        font-weight: bold;
    }



    .navbar-form-alt {margin:8px 0;}


    @media (min-width: 768px) {
        .navbar-form-alt > .form-group > .input-group {
            padding-right: 10%;
            padding-left: 10%;
        }
    }

    @media (min-width: 1200px) {
        .navbar-form-alt > .form-group > .input-group {
            padding-right: 20%;
            padding-left: 20%;
        }
    }
    .navbar-brand > b {
        color: #374dda;
    }

    .form-search,.btn-nav-search {
        border: transparent;
    }
    .form-search {
        border-bottom: 2px solid #374dda;

    }
    .btn-nav-search {
        color: #374dda;
        border-bottom: 2px solid #374dda;
    }

</style>

<nav id="header" class="navbar navbar-default navbar-static-top-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button data-target="#user-menu" type="button" class="navbar-toggle collapsed" data-toggle="collapse">
                &nbsp;<i class="fa fa-user" aria-hidden="true"></i>&nbsp;

                {{--<span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>--}}
            </button>
            <button data-target="#site-menu" type="button" class="navbar-toggle collapsed" data-toggle="collapse">
                &nbsp;<i class="fa fa-list" aria-hidden="true"></i>&nbsp;

            </button>


            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ auth()->check() ? route('products.index') : route('root') }}">
                <b>B L U E C R A N K</b>
                {{--<img src="icons/brand.png"/>--}}
                {{--{{ config('project.name', 'Laravel') }}--}}
            </a>
        </div>

        <div class="collapse navbar-collapse nav-top" id="user-menu">
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li {!! str_contains(request()->path(), 'auth/login') ? 'class="active"' : '' !!}>
                        <a href="{{ route('sessions.create', ['return' => urlencode($currentUrl)]) }}">
                            로그인
                        </a>
                    </li>
                    <div class="li-divider hidden-xs hidden-sm">|</div>
                    <li {!! str_contains(request()->path(), 'auth/register') ? 'class="active"' : '' !!}>
                        <a href="{{ route('users.create', ['return' => urlencode($currentUrl)]) }}">
                            회원가입
                        </a>
                    </li>
                @else

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if(Auth::user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin.index') }}">
                                        관리자 페이지
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('carts.index') }}">
                                    카트
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('orders.index') }}">
                                    주문내역
                                </a>
                            </li>
                            {{--<li>
                                <a href="#">
                                    프로필
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    작성글 관리
                                </a>
                            </li>--}}
                            <li>
                                <a href="{{ route('wants.index') }}">
                                    관심목록
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

            <form class="navbar-form-alt">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control form-search" placeholder="Search">
                        <span class="input-group-btn">
                           <button class="btn btn-default btn-nav-search"><i class="fa fa-search"></i></button>
                           </span>
                    </div>
                </div>
            </form>


        </div>

        <div class="collapse navbar-collapse nav-bottom" id="site-menu">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">

                <li {!! str_contains(request()->path(), 'products') ? 'class="active"' : '' !!}>
                    <a href="{{ route('products.index') }}">
                        BC몰
                    </a>
                </li>
                <div class="li-divider hidden-xs hidden-sm">|</div>
                <li {!! str_contains(request()->path(), 'olds') ? 'class="active"' : '' !!}>
                    <a href="{{ route('olds.index') }}">
                        중고
                    </a>
                </li>
                <div class="li-divider hidden-xs hidden-sm">|</div>
                <li {!! str_contains(request()->path(), ['tags', 'articles']) ? 'class="active"' : '' !!}>
                    <a href="{{ route('articles.index') }}">
                        커뮤니티
                    </a>
                </li>
                <div class="li-divider hidden-xs hidden-sm">|</div>
                <li {!! str_contains(request()->path(), 'shops') ? 'class="active"' : '' !!}>
                    <a href="{{ route('shops.index') }}">
                        오프라인매장
                    </a>
                </li>
                {{--<li {!! str_contains(request()->path(), 'certifications') ? 'class="active"' : '' !!}>
                    <a href="{{ route('certifications.index') }}">
                        점검/인증예약
                    </a>
                </li>--}}
            </ul>
        </div>

    </div>
</nav>

{{--<nav class="navbar navbar-default" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapsible">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Some Brand</a>
        </div>

        <div class="navbar-collapse collapse" id="navbar-collapsible">

            --}}{{--<ul class="nav navbar-nav navbar-left">
                <li><a href="#">Link 1</a></li>
                <li><a href="#">Link 2</a></li>
            </ul>--}}{{--

            <div class="navbar-form navbar-right btn-group">
                <button type="button" class="btn btn-default">Button 1</button>
                <button type="button" class="btn btn-default">Button 2</button>
                <button type="button" class="btn btn-default">Button 3</button>
            </div>

            <form class="navbar-form-alt">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control inputAB" id="addBook" placeholder="Search">
                        <span class="input-group-btn">
                           <button class="btn btn-default" id="addBookButton">Search</button>
                           </span>
                    </div>
                </div>
            </form>

        </div>

    </div>
</nav>--}}

<script>
    $('.nav-bottom').affix({
       offset: {top: 50}
    });
</script>

