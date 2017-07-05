@if ($tags->count())
    <ul class="tags__article">
        <li><i class="fa fa-tags"></i></li>
        @foreach ($tags as $tag)
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
@endif