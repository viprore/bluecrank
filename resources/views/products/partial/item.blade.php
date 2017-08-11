<style>


</style>

<div class="col-sm-6 col-md-6 col-lg-4 padding-option">
    <div class="thumbnail card">
        <div class="card-image embed-responsive embed-responsive-4by3">
            <a href="{{ route($prefix. 'show', $product->id) }}">
                <img class="img-product embed-responsive-item"
                     src="{{ $product->attachments->count() > 0 ? $product->attachments->first()->url : 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQlzvW0rg_vTZkwz20Ot15G_zcKgx2L5DTtgUNPOrArVnPjpRoJiK8hJZc' }}"
                     alt="">
            </a>
        </div>
        <div class="caption padding-option">
            <p>{!! explode('<br />',$product->ad_short_description)[0] !!}</p>
            <h4><a href="{{ route($prefix. 'show', $product->id) }}">{{ $product->ad_title }}</a>
            </h4>
            @if(str_contains($prefix, 'secrets') && Auth::check() && Auth::user()->isStudent())
                <h4 class="price">{{ number_format(round($product->price * 0.9, 3)) }} 원</h4>
                <h6 class="text-right" style="margin-bottom: 0"><s>{{ number_format($product->price) }} 원</s></h6>
            @else
                <h4 class="price text-right" style="margin-bottom: 0">{{ number_format($product->price) }} 원</h4>
            @endif
        </div>
        <div class="ratings">
            <ul class="tags__product">
                @foreach ($product->tags as $tag)
                    <li>
                        @if(str_contains($viewName, 'products'))
                            <a href="{{ route('products.index', ['slug'=>$tag->slug]) }}">{{ $tag->name }}</a>
                        @elseif(str_contains($viewName, 'olds'))
                            <a href="{{ route('olds.index', ['slug'=>$tag->slug]) }}">{{ $tag->name }}</a>
                        @else
                            <a href="{{ route('tags.articles.index', $tag->slug) }}">{{ $tag->name }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>