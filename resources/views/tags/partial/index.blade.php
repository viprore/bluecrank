<p class="lead">
    <i class="fa fa-tags"></i>
    태그
</p>

<ul>
    <li {!! !str_contains(request()->path(), 'tags') ? 'class="active"' : '' !!}>
        <a href="{{ route('articles.index') }}">
            모아보기
            @if(App\Article::latest()->first()->created_at->between(\Carbon\Carbon::now(), \Carbon\Carbon::now()->addDays(-7)))
                <span class="badge badge-default" style="color:#ffffff; background-color:#fda203">
                    N
                </span>
            @endif
        </a>
    </li>

    @foreach($articleTags as $tag)
        <li {!! str_contains(request()->path(), $tag->slug) ? 'class="active"' : '' !!}>
            <a href="{{ route('tags.articles.index', $tag->slug) }}">
                {{ $tag->name }}
                @if ($tag->articles->max('created_at')->between(\Carbon\Carbon::now(), \Carbon\Carbon::now()->addDays(-7)))
                    <span class="badge badge-default" style="color:#ffffff; background-color:#fda203">
              N
          </span>
                @endif
            </a>
        </li>
    @endforeach
</ul>