<nav id="header" class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ auth()->check() ? route('home') : route('root') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                {{--<li {!! str_contains(request()->path(), 'docs') ? 'class="active"' : '' !!}>
                    <a href="{{ url('docs') }}">
                        {{ trans('docs.title') }}
                    </a>
                </li>--}}
                <li {!! str_contains(request()->path(), 'products') ? 'class="active"' : '' !!}>
                    <a href="{{ route('products.index') }}">
                        BC몰
                    </a>
                </li>
                {{--<li {!! str_contains(request()->path(), ['themes', 'categories', 'markets']) ? 'class="active"' : '' !!}>
                    <a href="{{ route('markets.index') }}">
                        중고장터
                    </a>
                </li>--}}
                <li {!! str_contains(request()->path(), ['tags', 'articles']) ? 'class="active"' : '' !!}>
                    <a href="{{ route('articles.index') }}">
                        커뮤니티
                    </a>
                </li>
                <li {!! str_contains(request()->path(), 'malls') ? 'class="active"' : '' !!}>
                    <a href="{{ route('shops.index') }}">
                        오프라인매장
                    </a>
                </li>
                <li {!! str_contains(request()->path(), 'malls') ? 'class="active"' : '' !!}>
                    <a href="#">
                        점검/인증예약
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li>
                        <a href="{{ route('sessions.create', ['return' => urlencode($currentUrl)]) }}">
                            로그인
                        </a>
                    </li>
                    <li>
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
                            <li>
                                <a href="#">
                                    프로필
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
</nav>