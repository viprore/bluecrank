<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'apply_num',
        'buyer_addr',
        'buyer_email',
        'buyer_name',
        'buyer_tel',
        'imp_uid',
        'merchant_uid',
        'name',
        'paid_at',
        'pay_method',
        'receipt_url',
        'status',
    ];

    public function getOrder()
    {
        return Order::where('merchant_uid', $this->merchant_uid)->first();
    }
}
