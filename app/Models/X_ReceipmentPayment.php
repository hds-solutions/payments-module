<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Builder;

abstract class X_ReceipmentPayment extends Base\Model {
    use BelongsToCompany;

    protected $fillable = [
        'receipment_id',
        'currency_id',
        'paymentable_type',
        'paymentable_id',
        'conversion_rate',
        'payment_amount',
        'used_amount',
    ];

}
