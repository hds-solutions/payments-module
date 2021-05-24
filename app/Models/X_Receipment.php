<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

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

    protected $appends = [
        'invoices_amount',
        'payments_amount',
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

    public function getInvoicesAmountAttribute() {
        return $this->invoices->sum('pivot.imputed_amount');
    }

    public function getPaymentsAmountAttribute() {
        return $this->payments->sum('pivot.payment_amount');
    }

}
