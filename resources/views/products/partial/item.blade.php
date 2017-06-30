<style>
    .card .card-image {
        overflow: hidden;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -ms-transform-style: preserve-3d;
        -o-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }

    .card .card-image img {
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        -ms-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    .card .card-image:hover img {
        -webkit-transform: scale(1.1);
        -moz-transform: scale(1.1);
        -ms-transform: scale(1.1);
        -o-transform: scale(1.1);
        transform: scale(1.1);
    }

    .card {
        -webkit-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.16), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
        -moz-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.16), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
        box-shadow: 2 1px 2px 0 rgba(0, 0, 0, 0.16), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
    }

    .padding-option {
        padding: 3px;
    }

    .thumbnail {
        padding: 0
    }

    .glyphicon-heart {
        padding-right: 3px;
        color: #ff514d;
    }

    .glyphicon-comment {
        padding-left: 10px;
        padding-right: 3px;
        color: #6f80bd;
    }

    .img-product {
        object-fit: cover;
        border-radius: 5px 5px 0 0;
    }

    .ratings {
        padding-right: 10px;
        padding-left: 10px;
        color: #0E2231;
    }

    .ratings > h5 {
        font-size: 16px;
        font-weight: bold;
    }

    .caption {
        height: 100px;
        overflow: hidden;
    }

    /*
        .thumbnail .caption-full {
            padding: 9px;
            color: #333;
        }

        .img-thumbnail2 {
            padding: 1px;
            line-height: 1.6;
            background-color: #f5f8fa;
            border: 1px solid #ddd;
            border-radius: 12px;
        }

        .ad_inform {
            padding: 10px;
        }

        .ad_inform > p {
            color: #bec6d5;
            margin: 0;
        }

    */
</style>

<div class="col-sm-6 col-md-6 col-lg-4 padding-option">
    <div class="thumbnail card">
        {{--<div class="ad_inform">
            <a class="pull-left" href="{{ gravatar_profile_url('info@bluecrank.net') }}">
                <img class="media-object img-thumbnail2"
                     src="{{ gravatar_url('info@bluecrank.net', 18) }}" alt="블루크랭크">
            </a>
            &nbsp;블루크랭크
            --}}{{--<p class="pull-right">
                <span class="glyphicon glyphicon-time"></span>
                {{ $product->created_at->diffForHumans() }}
            </p>--}}{{--
        </div>--}}
        <div class="card-image embed-responsive embed-responsive-4by3">
            <a href="{{ route('products.show', $product->id) }}">
                <img class="img-product embed-responsive-item"
                     src="{{ $product->attachments->count() > 0 ? $product->attachments->first()->url : 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQlzvW0rg_vTZkwz20Ot15G_zcKgx2L5DTtgUNPOrArVnPjpRoJiK8hJZc' }}"
                     alt="">
            </a>
        </div>
        <div class="caption padding-option">
            <h4><a href="{{ route('products.show', $product->id) }}">{{ $product->ad_title }}</a>
            </h4>
            <p>{!! $product->ad_short_description !!}</p>
        </div>
        <div class="ratings">
            <h5 class="pull-right">&#8361;{{ number_format($product->price) }}</h5>
            <p>
                <span class="glyphicon glyphicon-heart"></span>
                {{ $product->getWantsCountAttribute() }}
                {{--<span class="glyphicon glyphicon-star">11</span>--}}
                <span class="glyphicon glyphicon-comment"></span>
                {{ $product->getCommentsCountAttribute() }}
            </p>

        </div>
    </div>
</div>