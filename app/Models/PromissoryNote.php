<?php

namespace HDSSolutions\Finpar\Models;

use Illuminate\Database\Eloquent\Builder;

class PromissoryNote extends X_PromissoryNote {

    public function scopePaid(Builder $query, bool $paid = true) {
        // return invoices that are paid
        return $query->where('is_paid', $paid);
    }

}
