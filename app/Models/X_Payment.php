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
        'document_number',
        'transacted_at',
        'payment_amount',
    ];

    protected static array $rules = [
        'currency_id'       => [ 'required' ],
        'partnerable_type'  => [ 'required' ],
        'partnerable_id'    => [ 'required' ],
        'document_number'   => [ 'required' ],
        'transacted_at'     => [ 'sometimes' ],
        'payment_amount'    => [ 'required', 'min:0' ],
    ];

}
