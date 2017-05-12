<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>블루크랭크</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .title a,
            .links > a {
                color: #636b6f;
                text-decoration: none;
            }

            .links > a {
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>

        <script>
            $(window).on('load', function() {
                $('.flexslider').flexslider({
                    animation: "slide"
                });


            });

        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">


            <div class="content">
                <div class="title m-b-md">
                    BlueCrank
                </div>
                @include('flash::message')

                <div class="links">
                    <a href="http://www.bluecrank.net">BC몰(Old)</a>
                    <a href="{{ route('products.index') }}">BC몰(New)</a>
                    {{--<a href="{{ route('markets.index') }}">중고장터</a>--}}
                    <a href="{{ route('articles.index') }}">커뮤니티</a>
                    <a href="#">인증/점검</a>
                    @if (auth()->guest())
                        <a href="{{ route('sessions.create') }}">로그인</a>
                        <a href="{{ route('users.create') }}">회원가입</a>
                    @else
                        <a href="{{ route('sessions.destroy') }}">
                            {{ auth()->user()->name }} • 로그아웃
                        </a>
                    @endif
                </div>



            </div>
        </div>
    </body>
</html>
