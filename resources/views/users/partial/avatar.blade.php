@php
  $size = isset($size) ? $size : 48;
@endphp

<style>
  .img-thumbnail {
    padding: 2px;
  }
</style>

@if (isset($user) and $user)
  <a class="pull-left" href="{{ gravatar_profile_url($user->email) }}">
    <img class="media-object img-thumbnail img-circle" src="{{ gravatar_url($user->email, $size) }}" alt="{{ $user->name }}">
  </a>
@else
  <a class="pull-left" href="{{ gravatar_profile_url('unknown@example.com') }}">
    <img class="media-object img-thumbnail img-circle" src="{{ gravatar_url('unknown@example.com', $size) }}" alt="Unknown User">
  </a>
@endif
