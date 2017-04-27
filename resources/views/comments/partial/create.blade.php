<div class="media media__create__comment {{ isset($parentId) ? 'sub' : 'top' }}">

    @include('users.partial.avatar', ['user' => $currentUser, 'size' => 32])

    <div class="media-body">
        @if(isset($article))
            <form method="POST" action="{{ route('articles.comments.store', $article->id) }}" class="form-horizontal">
        @elseif(isset($product))
            <form method="POST" action="{{ route('products.comments.store', $product->id) }}" class="form-horizontal">
        @else
            <form method="POST" action="{{ route('markets.comments.store', $market->id) }}" class="form-horizontal">
        @endif
                {!! csrf_field() !!}
                @if(isset($parentId))
                    <input type="hidden" name="parent_id" value="{{ $parentId }}">
                @endif
                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                    <textarea name="content" class="form-control">{{ old('content') }}</textarea>
                    {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
                    <div class="preview__content">
                        {!! markdown(old('content', '...')) !!}
                    </div>
                </div>

                <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-sm">
                                전송하기
                            </button>
                </div>
           </form>
    </div>
</div>