<style>
    .banner_top {
        padding: 1em 1em;
    }

    .img-w100 {
        width: 100%;
    }
</style>

{{-- 태블릿, 모바일폰 --}}
<div class="row my-6 visible-xs-block visible-sm-block banner_top">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        {{--<ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol>--}}

    <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <a href="https://www.youtube.com/watch?v=vhba0ICbeHc" target="_blank">
                    <img class="img-w100" src="{{ url('icons/banner02.png') }}">
                </a>
            </div>
            <div class="item">
                <img class="img-w100" src="{{ url('icons/banner04.jpg') }}">
            </div>
        </div>
    </div>
</div>

{{-- 데스크탑(992px 이상) --}}
<div class="row my-6 visible-md-block visible-lg-block text-center banner_top">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        {{--<ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol>--}}

    <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <a href="https://www.youtube.com/watch?v=vhba0ICbeHc" target="_blank">
                    <img class="img-w100" src="{{ url('icons/banner02-pc.png') }}">
                </a>
            </div>
            <div class="item">
                <img class="img-w100" src="{{ url('icons/banner04-pc.jpg') }}">
            </div>
        </div>
    </div>
</div>

