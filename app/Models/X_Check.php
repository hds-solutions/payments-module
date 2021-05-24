<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Contracts\PaymentContract;
use HDSSolutions\Finpar\Traits\ExtendsPayment;

abstract class X_Check extends Base\Model implements PaymentContract {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'bank_name',
        'bank_account',
        'account_holder',
        'due_date',
        'is_deposited',
    ];

    protected $with = [ 'identity' ];

    protected $attributes = [
        'is_deposited'  => false,
    ];

    protected static array $rules = [
        'bank_name'         => [ 'required' ],
        'bank_account'      => [ 'required' ],
        'account_holder'    => [ 'required' ],
        'due_date'          => [ 'required', 'date', 'after:today' ],
        'is_deposited'      => [ 'sometimes', 'boolean' ],
    ];

    public function isDeposited():bool {
        return $this->is_deposited;
    }

}
