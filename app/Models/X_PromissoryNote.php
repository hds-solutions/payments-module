<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Contracts\PaymentContract;
use HDSSolutions\Laravel\Traits\ExtendsPayment;

abstract class X_PromissoryNote extends Base\Model implements PaymentContract {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'due_date',
        'is_paid',
    ];

    protected $with = [ 'identity' ];

}
