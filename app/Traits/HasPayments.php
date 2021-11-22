<?php

namespace HDSSolutions\Laravel\Traits;

use HDSSolutions\Laravel\Contracts\PaymentContract;

trait HasPayments {

    public function hasManyPayments(string $paymentModel) {
        // get payment model instance
        $instance = $this->newRelatedInstance( $paymentModel );
        // validate that belongs to PaymentContract
        if (!($instance instanceof PaymentContract)) return null;
        // return custom hasMany
        return $this->newHasMany( $instance->newQuery(), $this, 'payments.partnerable_id', 'id' )
            // force partnerable_type
            ->where('payments.partnerable_type', self::class);
    }

}
