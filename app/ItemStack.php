<?php
namespace App;

class ItemStack
{
    var $id;
    var $ec_mall_pid;
    var $name;
    var $uprice;

    var $isWish;

    // for Buy
    var $tprice;
    var $option;
    var $count;
    // for Wish
    var $image;
    var $thumb;
    var $url;

    /**
     * ItemStack constructor.
     * 타입 구분 후 데이터 생성
     */
    function __construct($_id, $_ec_mall_pid, $_name, $_uprice, $_type, $_var1, $_var2, $_var3)
    {
        $this->id = $_id;
        $this->ec_mall_pid = $_ec_mall_pid;
        $this->name = $_name;
        $this->uprice = $_uprice;

        $this->isWish = $_type;

        if ($this->isWish) {
            $this->image = $_var1;
            $this->thumb = $_var2;
            $this->url = $_var3;
        } else{
            $this->tprice = $_var1;
            $this->option = $_var2;
            $this->count = $_var3;
        }
    }

    function makeQueryString()
    {
        $ret = "";
        $ret .= 'ITEM_ID=' . urlencode($this->id);
        $ret .= '&EC_MALL_PID=' . urlencode($this->ec_mall_pid);
        $ret .= '&ITEM_NAME=' . urlencode($this->name);
        $ret .= '&ITEM_UPRICE=' . $this->uprice;
        if ($this->isWish) {
            $ret .= '&ITEM_IMAGE=' . urlencode($this->image);
            $ret .= '&ITEM_THUMB=' . urlencode($this->thumb);
            $ret .= '&ITEM_URL=' . urlencode($this->url);
        }else{
            $ret .= '&ITEM_TPRICE=' . $this->tprice;
            $ret .= '&ITEM_COUNT=' . $this->count;
            $ret .= '&ITEM_OPTION=' . urlencode($this->option);
        }
        return $ret;
    }
}

