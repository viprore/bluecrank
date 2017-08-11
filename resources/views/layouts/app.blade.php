<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msapplication-tap-highlight" content="no">

    <!-- SEO -->
    <meta name="description" content="{{ config('project.description') }}">

    <!-- Facebook Meta -->
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:image" content="">
    <meta property="og:type" content="Website">
    <meta property="og:author" content="">

    <!-- Google Meta -->
    <meta name="google-site-verification" content="JCCALmOzY_6xdmWrBKTNOd1JCqPYn1m50cH1hv1llHQ"/>
    <meta itemprop="name" content="블루크랭크">
    <meta itemprop="description" content="{{ config('project.description') }}">
    <meta itemprop="image" content="">
    <meta itemprop="author" content="BlueCrank"/>

    <!-- Twitter Meta-->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="{{ config('app.name') }}">
    <meta name="twitter:description" content="{{ config('project.description') }}">
    <meta name="twitter:image" content="">
    <meta name="twitter:domain" content="{{ config('project.url') }}">

    <!-- Naver Meta-->
    <meta name="naver-site-verification" content="cae6940f319e1dccf8b9a2161ed27eeb4ef340cd"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="블루크랭크">
    <meta property="og:description" content="온라인으로 구매하고 집 근처 패밀리 매장에서 받자">
    <meta property="og:image"
          content="https://ko.gravatar.com/userimage/120319295/945d5d59dd434917810352ecfe7a4312.jpg">
    <meta property="og:url" content="http://www.bluecrank.com">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>

    <!-- Favorite Icon -->
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
    <link rel="icon" href="favicon.png" type="image/x-icon" />

@yield('style')

<!-- Scripts -->

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-102257819-1', 'auto');
        ga('send', 'pageview');

        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'currentUser' => $currentUser,
            'currentRouteName' => $currentRouteName,
            'currentLocale' => $currentLocale,
            'currentUrl' => $currentUrl,
        ]) !!};
    </script>

    <script type="text/javascript" src="http://wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript">
        if (!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "s_15f6d8ad558b";

        wcs.inflow("bluecrank.kr");
    </script>

</head>

<body id="app-layout">
@include('layouts.partial.new-navigation')

<div class="container">
    @include('flash::message')

    @yield('content')
</div>

@include('layouts.partial.footer')

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

@yield('script')
<script>
    wcs_do();
</script>
</body>
</html>
