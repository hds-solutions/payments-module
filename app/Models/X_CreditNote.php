<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Contracts\PaymentContract;
use HDSSolutions\Laravel\Traits\ExtendsPayment;

abstract class X_CreditNote extends Base\Model implements PaymentContract {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'document_number',
        'documentable_type',
        'documentable_id',
        'description',
        'used_amount',
        'is_used',
        'is_paid',
    ];

    protected $with = [ 'identity' ];

    public function getIsUsedAttribute():bool {
        return $this->attributes['is_used'] || $this->payment_amount == $this->used_amount;
    }

}
