<!DOCTYPE html>
<html>
<body>
@if(isset($itemId) or isset($itemIdList))
    <form name="frm" method="get" action="{{ $wishlistPopupUrl }}">
        <input type="hidden" name="SHOP_ID" value="{{ $shopId }}">

        <!-- 한 개일 경우 -->
        @if(isset($itemId))
            <input type="hidden" name="ITEM_ID" value="{{ $itemId }}">
        @else
            @foreach($itemIdList as $itemId)
                <input type="hidden" name="ITEM_ID" value="{{ $itemId }}?>">
            @endforeach
        @endif
    </form>
@endif
</body>
<script>
    @if($resultCode == 200)
        document.frm.target = "_top";
    document.frm.submit();
    @endif
</script>
</html>