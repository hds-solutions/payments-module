<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Contracts\PaymentContract;
use HDSSolutions\Laravel\Traits\ExtendsPayment;

abstract class X_Credit extends Base\Model implements PaymentContract {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'interest',
        'dues',
    ];

    protected $with = [ 'identity' ];

    protected $attributes = [
        'interest'  => 0,
        'dues'      => 1,
    ];

}
