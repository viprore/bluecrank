<?php
namespace App;

class ItemStack
{
    var $id;
    var $ec_mall_pid;
    var $name;
    var $tprice;
    var $uprice;
    var $option;
    var $count;

//option이 여러 종류라면, 선택된 옵션을 슬래시(/)로 구분해서 표시하는 것을 권장한다.
    function __construct($_id, $_ec_mall_pid, $_name, $_tprice, $_uprice, $_option, $_count)
    {
        $this->id = $_id;
        $this->ec_mall_pid = $_ec_mall_pid;
        $this->name = $_name;
        $this->tprice = $_tprice;
        $this->uprice = $_uprice;
        $this->option = $_option;
        $this->count = $_count;
    }

    function makeQueryString()
    {
        $ret = "";
        $ret .= 'ITEM_ID=' . urlencode($this->id);
        $ret .= '&EC_MALL_PID=' . urlencode($this->ec_mall_pid);
        $ret .= '&ITEM_NAME=' . urlencode($this->name);
        $ret .= '&ITEM_COUNT=' . $this->count;
        $ret .= '&ITEM_OPTION=' . urlencode($this->option);
        $ret .= '&ITEM_TPRICE=' . $this->tprice;
        $ret .= '&ITEM_UPRICE=' . $this->uprice;
        return $ret;
    }
}

;