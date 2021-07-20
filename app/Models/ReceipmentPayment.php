<?php

namespace HDSSolutions\Laravel\Models;

class ReceipmentPayment extends X_ReceipmentPayment {

    public function receipment() {
        return $this->belongsTo(Receipment::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function paymentable() {
        return $this->morphTo();
    }

}
