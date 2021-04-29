<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\ExtendsPayment;
use Illuminate\Database\Eloquent\Builder;

abstract class X_Check extends Base\Model {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'bank_name',
        'bank_account',
        'account_holder',
        'due_date',
        'is_deposited',
    ];

    public function isDeposited():bool {
        return $this->is_deposited;
    }

}
