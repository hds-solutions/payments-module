<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\HasPartnerable;

class Payment extends X_Payment {
    use HasPartnerable;

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

}
