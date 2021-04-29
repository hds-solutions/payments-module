<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Builder;

abstract class X_Payment extends Base\Model
{
    use BelongsToCompany;

    const PAYMENT_TYPE_Cash = 'C';
    const PAYMENT_TYPE_Credit = 'CR';
    const PAYMENT_TYPE_Check = 'CH';
    const PAYMENT_TYPE_CreditNote = 'CRD';
    const PAYMENT_TYPE_FastPay = 'FP';
    const PAYMENT_TYPE_Card = 'CAR';
    const PAYMENT_TYPES = [
        self::PAYMENT_TYPE_Cash => 'payment::payment.payment_type.cash',
        self::PAYMENT_TYPE_Credit => 'payment::payment.payment_type.credit',
        self::PAYMENT_TYPE_Check => 'payment::payment.payment_type.check',
        self::PAYMENT_TYPE_CreditNote => 'payment::payment.payment_type.credit_note',
        self::PAYMENT_TYPE_FastPay => 'payment::payment.payment_type.fast_pay',
        self::PAYMENT_TYPE_Card => 'payment::payment.payment_type.card',
    ];
    
    protected $fillable = [
        'currency_id',
        'partnerable_type',
        'partnerable_id',
        'document_no',
        'transacted_at',
        'amount',
    ];

}
