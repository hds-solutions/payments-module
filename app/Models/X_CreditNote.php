<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\ExtendsPayment;
use Illuminate\Database\Eloquent\Builder;

abstract class X_CreditNote extends Base\Model {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'used_amount',
        'is_paid',
    ];

    public function isPaid():bool {
        return $this->is_paid;
    }

    public function isUsed():bool {
        return $this->payment_amount == $this->used_amount;
    }

}
