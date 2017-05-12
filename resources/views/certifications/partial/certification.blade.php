<div class="media">
  @include('users.partial.avatar', ['user' => $certification->user])

  <div class="media-body">
    <h4 class="media-heading">
      <a href="{{ route('certifications.show', $certification->id) }}">
        {{ $certification->item_info }}
      </a>
    </h4>

    {{ $certification->reserved_date }}
  </div>
</div>
