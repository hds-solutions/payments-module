<?php

namespace HDSSolutions\Finpar\Models;

abstract class X_ReceipmentPayment extends Base\Pivot {

    protected $fillable = [
        'receipment_id',
        'currency_id',
        'paymentable_type',
        'paymentable_id',
        'conversion_rate',
        'payment_amount',
        'used_amount',
    ];

    protected static array $rules = [
        'receipment_id'     => [ 'required' ],
        'currency_id'       => [ 'required' ],
        'paymentable_type'  => [ 'required' ],
        'paymentable_id'    => [ 'required' ],
        'conversion_rate'   => [ 'sometimes', 'nullable', 'min:0' ],
        'payment_amount'    => [ 'required', 'numeric', 'min:0' ],
        'used_amount'       => [ 'sometimes', 'numeric', 'min:0' ],
    ];

    protected $attributes = [
        'used_amount'       => 0,
    ];

}
