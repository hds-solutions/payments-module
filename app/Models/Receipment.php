<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\HasDocumentActions;
use HDSSolutions\Finpar\Traits\HasPartnerable;

class Receipment extends X_Receipment {
    use HasDocumentActions,
        HasPartnerable;

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function invoices() {
        return $this->hasMany(ReceipmentInvoice::class);
    }

    public function payments() {
        return $this->hasMany(ReceipmentPayment::class);
    }

    public function prepareIt():?string {
        // TODO: check that there are invoices to pay
        // TODO: check that there are payments to apply
        // TODO: check if there is an invoices already paid
        // TODO: check sum(payments.payment_amount) == sum(invoices.imputed_amount)
        // TODO: check if there is invoices.is_credit=false and there is credit payments, if so reject
        // TODO: check if there are credit payments
            // TODO: check if partner doesn't have credit enabled
            // TODO: check if partner doesn't have enought credit available
        return null;
    }

    public function completeIt():?string {
        // TODO: for each ReceipmentInvoice
            // TODO: set ReceipmentInvoice.invoice.paid_amount = ReceipmentInvoice.inputed_amount
            // TODO: set Invoice.is_paid=true if paid_amount == imputed_amount
        // TODO: for each ReceipmentPayment
            // TODO: if ReceipmentPayment type=creditNote
                // TODO: substract creditNote.used_amount
            // TODO: if ReceipmentPayment type=check
                // TODO: if Check.payment_amount > pendingReceipmentAmount
                    // TODO: generate CreditNote for remaining check amount
            // TODO: set ReceipmentPayment.used_amount
        return null;
    }

}
