<?php

namespace HDSSolutions\Laravel\Traits;

use HDSSolutions\Laravel\Models\Payment;
use HDSSolutions\Laravel\Traits\HasPartnerable;

trait ExtendsPayment {
    use HasIdentity,
        HasPartnerable;

    protected static $identityClass = Payment::class;

    public static function bootExtendsPayment() {
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

    public function setTransactedAtAttribute($value) {
        $this->identity->transacted_at = $value;
    }

    public function getPaymentAmountAttribute() {
        return $this->identity->payment_amount;
    }

    public function setPaymentAmountAttribute($value) {
        $this->identity->payment_amount = $value;
    }

}
