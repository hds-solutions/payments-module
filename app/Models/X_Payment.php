<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Payment extends Base\Model {
    use BelongsToCompany;

    const PAYMENT_TYPE_Cash         = 'CA';
    const PAYMENT_TYPE_Card         = 'CD';
    const PAYMENT_TYPE_Credit       = 'CR';
    const PAYMENT_TYPE_Check        = 'CH';
    const PAYMENT_TYPE_CreditNote   = 'CN';
    const PAYMENT_TYPE_Promissory   = 'PP';
    const PAYMENT_TYPES = [
        self::PAYMENT_TYPE_Cash         => 'payments::payment.payment_type.cash',
        self::PAYMENT_TYPE_Card         => 'payments::payment.payment_type.card',
        self::PAYMENT_TYPE_Credit       => 'payments::payment.payment_type.credit',
        self::PAYMENT_TYPE_Check        => 'payments::payment.payment_type.check',
        self::PAYMENT_TYPE_CreditNote   => 'payments::payment.payment_type.credit_note',
        self::PAYMENT_TYPE_Promissory   => 'payments::payment.payment_type.promissory',
    ];

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
