<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Contracts\PaymentContract;
use HDSSolutions\Finpar\Traits\ExtendsPayment;

abstract class X_PromissoryNote extends Base\Model implements PaymentContract {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'due_date',
        'is_paid',
    ];

    protected $with = [ 'identity' ];

}
