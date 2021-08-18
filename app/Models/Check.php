<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Validator;

class Check extends X_Check {

    public function bank() {
        return $this->belongsTo(Bank::class);
    }

    public function bankAccount() {
        return $this->belongsTo(BankAccount::class);
    }

    public function cash() {
        return $this->belongsTo(Cash::class);
    }

    public function movement() {
        return $this->morphOne(BankAccountMovement::class, 'referable');
    }

    public function scopeDeposited(Builder $query, bool $deposited = true) {
        // return checks that are deposited
        return $query->where('is_deposited', $deposited);
    }

    public function scopePaid(Builder $query, bool $paid = true) {
        // return checks that are paid
        return $query->where('is_paid', $paid);
    }

    protected function beforeSave(Validator $validator) {
        // a check only can be cashed or deposited, not both
        if ($this->is_deposited && $this->is_cashed)
            // reject with error
            return $validator->errors()->add('is_deposited', __('payment::check.cashed-or-deposited-only'));

        // check if it's being deposited, BankAccount must be set
        if ($this->is_deposited && $this->bankAccount === null)
            // reject with error
            return $validator->errors()->add('bank_account_id', __('payment::check.depositing-without-bank_account'));

        // check if it's being cashed, Cash must be set
        if ($this->is_cashed && $this->cash === null)
            // reject with error
            return $validator->errors()->add('cash_id', __('payment::check.cashing-without-cash'));
    }

}
