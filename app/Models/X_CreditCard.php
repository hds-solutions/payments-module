<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\ExtendsPayment;
use Illuminate\Database\Eloquent\Builder;

abstract class X_CreditCard extends Base\Model {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'card_holder',
        'card_number',
    ];

    public function isPaid():bool {
        return $this->is_paid;
    }

}
