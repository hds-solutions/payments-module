<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Contracts\PaymentContract;
use HDSSolutions\Finpar\Traits\ExtendsPayment;

abstract class X_Card extends Base\Model implements PaymentContract {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
        'card_holder',
        'card_number',
        'is_credit',
    ];

    protected $with = [ 'identity' ];

    public final function getCardNumberAttribute():string {
        return $this->identity->document_number;
    }

    public final function setCardNumberAttribute(string $card_number):void {
        $this->identity->document_number = $card_number;
    }

}
