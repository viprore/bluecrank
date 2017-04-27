<h1>
  {{ $market->ad_title }}
  <small>
    {{ $market->user->name }}
  </small>
</h1>

<hr/>

<p>
  {{ $market->description }}
  <small>
    {{ $market->created_at->timezone('Asia/Seoul') }}
  </small>
  <br/>
  <br/>
  @if (File::exists(storage_path('elephant.png')))
    <div style="text-align: center;">
      <img src="{{ $message->embed(storage_path('elephant.png')) }}" alt="">
    </div>
  @endif
</p>

<hr/>

<footer>
  이 메일은 {{ config('app.url') }}에서 보냈습니다.
</footer>