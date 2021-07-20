<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Builder;

abstract class X_Receipment extends Base\Model {
    use BelongsToCompany;

    protected $fillable = [
        'employee_id',
        'partnerable_type',
        'partnerable_id',
        'currency_id',
        'transacted_at',
        'document_number',
        'is_purchase',
    ];

    protected static array $rules = [
        'employee_id'       => [ 'required' ],
        'partnerable_type'  => [ 'required' ],
        'partnerable_id'    => [ 'required' ],
        'currency_id'       => [ 'required' ],
        'transacted_at'     => [ 'sometimes' ],
        'document_number'   => [ 'sometimes' ],
    ];

    public function isPurchase():bool {
        return $this->is_purchase;
    }

}
