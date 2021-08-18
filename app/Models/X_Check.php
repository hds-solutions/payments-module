<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Contracts\PaymentContract;
use HDSSolutions\Laravel\Traits\ExtendsPayment;

abstract class X_Check extends Base\Model implements PaymentContract {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'bank_id',
        'account_holder',
        'due_date',
        'is_deposited',
        'bank_account_id',
        'is_cashed',
        'cash_id',
        'is_paid',
    ];

    protected $with = [ 'identity' ];

    protected $attributes = [
        'is_deposited'  => false,
        'is_cashed'     => false,
        'is_paid'       => false,
    ];

    protected $casts = [
        'due_date'      => 'datetime',
        'is_deposited'  => 'boolean',
        'is_cashed'     => 'boolean',
        'is_paid'       => 'boolean',
    ];

    protected static array $rules = [
        'bank_id'           => [ 'required' ],
        'account_holder'    => [ 'required' ],
        'due_date'          => [ 'required', 'date', 'after:today' ],
        'is_deposited'      => [ 'sometimes', 'boolean' ],
        'bank_account_id'   => [ 'sometimes', 'nullable' ],
        'is_cashed'         => [ 'sometimes', 'boolean' ],
        'cash_id'           => [ 'sometimes', 'nullable' ],
        'is_paid'           => [ 'sometimes', 'boolean' ],
    ];

    public function getIsExpiredAttribute():bool {
        return $this->due_date < now();
    }

}
