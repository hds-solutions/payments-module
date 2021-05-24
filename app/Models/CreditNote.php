<?php

namespace HDSSolutions\Finpar\Models;

use Illuminate\Database\Eloquent\Builder;

class CreditNote extends X_CreditNote {

    public function scopeAvailable(Builder $query) {
        return $this->scopeUsed($query, false);
    }

    public function scopeUsed(Builder $query, bool $used = true) {
        return $query->where('is_used', $used);
    }

    public function scopePaid(Builder $query, bool $paid = true) {
        return $query->where('is_paid', $paid);
    }

    public function documentable() {
        // return $this->morphTo(type: 'documentable_type', id: 'documentable_id');
        return $this->morphTo();
    }

}
