<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>블루크랭크</title>

        <!-- Styles -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <style>
            h1 {
                font-size: 20px;
            }
            div {
                width: 100%;

            }
            img[usemap] {
                border: none;
                height: auto;
                max-width: 100%;
                width: auto;
            }


        </style>
    </head>
    <body>
        <div class="container-fluid">
            <img src="{{ url('icons/renew.png') }}" width="1920" height="1280" usemap="#old-new" alt="" />
            <map name="old-new">
                <area shape="rect" alt="온고지신" title="old-bluecrank" coords="0,0,960,1280" href="http://bluecrank.net" />
                <area shape="rect" alt="환골탈태" title="new-bluecrank" coords="960,0,1920,1280" href="{{ route('products.index') }}" />
            </map>
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="js/jquery.rwdImageMaps.min.js"></script>
        <script>
            $(document).ready(function(e) {
                $('img[usemap]').rwdImageMaps();
            });
        </script>
    </body>
</html>
