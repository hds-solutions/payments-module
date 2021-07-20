<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\ExtendsPayment;
use Illuminate\Database\Eloquent\Builder;

abstract class X_PromissoryNote extends Base\Model {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'due_date',
        'is_paid',
    ];

    public function isPaid():bool {
        return $this->is_paid;
    }

}
