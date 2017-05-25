<div class="media">
  @include('users.partial.avatar', ['user' => $review->user])

  <div class="media-body">
    <h4 class="media-heading">
      <a href="{{ route('reviews.show', $review->id) }}">
        {{ $review->title }}
      </a>
    </h4>

    <p class="text-muted meta__article">
      <a href="{{ gravatar_profile_url($review->user->email) }}">
        {{ $review->user->name }}
      </a>

      <small>
        • {{ $review->created_at->diffForHumans() }}


      </small>
    </p>

  </div>
</div>
