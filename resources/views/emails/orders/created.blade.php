<h1>
  {{ $order->user->name }}님으로부터 주문이 접수되었습니다.
</h1>

<hr/>

<p>
  상세 정보는 아래 링크에서 확인하세요.
  <a href="{{ route('orders.show', $order->id) }}">주문서 보기</a>
  <small>
    {{ $order->created_at->timezone('Asia/Seoul') }}
  </small>
  <br/>
  <br/>
</p>

<hr/>

<footer>
  이 메일은 {{ config('app.url') }}에서 보냈습니다.
</footer>