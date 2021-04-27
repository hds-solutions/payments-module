<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Builder;

abstract class X_Payment extends Base\Model {
    use BelongsToCompany;

    protected $fillable = [
        'currency_id',
        'partnerable_type',
        'partnerable_id',
        'document_no',
        'transacted_at',
        'amount',
    ];

}
