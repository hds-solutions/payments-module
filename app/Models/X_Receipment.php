<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;
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

    public function isPurchase():bool {
        return $this->is_purchase;
    }

}
