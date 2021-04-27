<?php

namespace HDSSolutions\Finpar\Models;

class ReceipmentInvoice extends X_ReceipmentInvoice {

    public function receipment() {
        return $this->belongsTo(Receipment::class);
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

}
