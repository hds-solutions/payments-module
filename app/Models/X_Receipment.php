<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

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

    public function getIsSaleAttribute():bool {
        return !$this->is_purchase;
    }

    public function getInvoicesAmountAttribute() {
        return $this->invoices->sum('receipmentInvoice.imputed_amount');
    }

    public function getPaymentsAmountAttribute() {
        return $this->payments->sum('receipmentPayment.used_amount');
    }

    public function getPaymentsNetAmountAttribute() {
        return $this->payments->sum('receipmentPayment.payment_amount');
    }

    public function getTransactedAtPrettyAttribute():string {
        return pretty_date($this->transacted_at, true);
    }

}
