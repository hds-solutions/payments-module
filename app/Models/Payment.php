<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\HasPartnerable;

class Payment extends X_Payment {
    use HasPartnerable;

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

}
