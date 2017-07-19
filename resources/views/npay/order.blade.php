<!DOCTYPE html>
<html>
<body>
@if(isset($orderId))
    <form name="frm" method="get" action="{{ $orderUrl }}">
        <input type="hidden" name="ORDER_ID" value="{{ $orderId }}">
        <input type="hidden" name="SHOP_ID" value="{{ $shopId }}">
        <input type="hidden" name="TOTAL_PRICE" value="{{ $totalPrice }}">
    </form>
    @else
    <p>{{ $logs }}</p>
@endif
</body>
<script>
    @if($resultCode == 200)
        document.frm.target = "_top";
        document.frm.submit();
    @endif
</script>
</html>