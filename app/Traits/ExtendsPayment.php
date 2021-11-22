<?php

namespace HDSSolutions\Laravel\Traits;

use HDSSolutions\Laravel\Models\Payment;
use HDSSolutions\Laravel\Traits\HasPartnerable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

trait ExtendsPayment {
    use HasIdentity,
        HasPartnerable;

    protected static $identityClass = Payment::class;

    public function getRouteKeyName() {
        // return key name with table (JOIN makes ambiguous id fields)
        return $this->getTable().'.'.$this->getKeyName();
    }

    public function getRouteKey() {
        // return model key value
        return $this->getAttribute($this->getKeyName());
    }

    public function newModelQuery() {
        // get original modelQuery
        return parent::newModelQuery()
            // always JOIN to payments
            ->join('payments', 'payments.id', $this->getTable().'.'.$this->getKeyName());
    }

    public function scopeJoinedPayment(Builder $query) {
        return $query->join('payments', 'payments.id', $this->getTable().'.'.$this->getKeyName());
    }

    protected function setKeysForSaveQuery($query) {
        // add table name to column (JOIN makes mabiguois id fields)
        return $query->where($this->getTable().'.'.$this->getKeyName(), $this->getKeyForSaveQuery());
    }

    public static function bootExtendsPayment() {
        // add scope lo load payments from company only
        self::addGlobalScope(new class implements Scope {
            public function apply(Builder $query, Model $model) {
                // filter company ID on payments table
                return $query->where('payments.company_id', backend()->company()?->id);
            }
        });

        self::retrieved(function($model) {
            // append identity fields
            $model->appends += [
                'company_id',
                'currency_id',
                'partnerable_type',
                'partnerable_id',
                'document_number',
                'transacted_at',
                'payment_amount',
            ];
            // hide identity from JSON response
            $model->hidden += [
                'identity',
            ];
        });
    }

    public function getCompanyIdAttribute() {
        return $this->identity->company_id;
    }

    public function company() {
        return $this->identity->company();
    }

    public function getCurrencyIdAttribute() {
        return $this->identity->currency_id;
    }

    public function setCurrencyIdAttribute($value) {
        $this->identity->currency_id = $value;
    }

    public function currency() {
        return $this->identity->currency();
    }

    public function getPartnerableTypeAttribute() {
        return $this->identity->partnerable_type;
    }

    public function setPartnerableTypeAttribute($value) {
        $this->identity->partnerable_type = $value;
    }

    public function getPartnerableIdAttribute() {
        return $this->identity->partnerable_id;
    }

    public function setPartnerableIdAttribute($value) {
        $this->identity->partnerable_id = $value;
    }

    public function partnerable() {
        return $this->identity->partnerable();
    }

    public function getDocumentNumberAttribute() {
        return $this->identity->document_number;
    }

    public function setDocumentNumberAttribute($value) {
        $this->identity->document_number = $value;
    }

    public function getTransactedAtAttribute() {
        return $this->identity->transacted_at;
    }

    public function getTransactedAtPrettyAttribute():string {
        return pretty_date($this->identity->transacted_at, true);
    }

    public function setTransactedAtAttribute($value) {
        $this->identity->transacted_at = $value;
    }

    public function getPaymentAmountAttribute() {
        return $this->identity->payment_amount;
    }

    public function getPaymentAmountPrettyAttribute() {
        return $this->identity->payment_amount_pretty;
    }

    public function setPaymentAmountAttribute($value) {
        $this->identity->payment_amount = $value;
    }

}
