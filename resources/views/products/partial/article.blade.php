<div class="media">
  <a class="pull-left" href="{{ gravatar_profile_url('info@bluecrank.net') }}">
    <img class="media-object img-thumbnail" src="{{ gravatar_url('info@bluecrank.net', 48) }}" alt="블루크랭크">
  </a>

  <div class="media-body">
    <h4 class="media-heading">
      <a href="{{ route('products.show', $product->id) }}">
        {{ $product->ad_title }}
      </a>
    </h4>

    <p class="text-muted meta__article">
      <a href="{{ gravatar_profile_url('info@bluecrank.net') }}">
        블루크랭크
      </a>

      <small>
        • {{ $product->created_at->diffForHumans() }}
        • 조회수 {{ $product->view_count }}

        @if ($product->comment_count > 0)
          • 댓글 {{ $product->comment_count }}
        @endif
      </small>
    </p>

    {{--@if ($viewName === 'products.index')
      @include('tags.partial.list', ['tags' => $product->tags])
    @endif

    @if ($viewName === 'products.show')
      @include('attachments.partial.list', ['attachments' => $product->attachments])
    @endif--}}
  </div>
</div>
