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
        return $this->belongsToMany(Invoice::class, 'receipment_invoice')
            ->using(ReceipmentInvoice::class)
            ->withTimestamps()
            ->withPivot([ 'imputed_amount' ]);
    }

    public function cashLines() {
        return $this->morphedByMany(CashLine::class, 'paymentable', 'receipment_payment');
    }

    public function credits() {
        return $this->morphedByMany(Credit::class, 'paymentable', 'receipment_payment');
    }

    public function checks() {
        return $this->morphedByMany(Check::class, 'paymentable', 'receipment_payment');
    }

    public function creditNotes() {
        return $this->morphedByMany(CreditNote::class, 'paymentable', 'receipment_payment');
    }

    public function promissoryNotes() {
        return $this->morphedByMany(PromissoryNote::class, 'paymentable', 'receipment_payment');
    }

    public function creditCards() {
        return $this->morphedByMany(CreditCard::class, 'paymentable', 'receipment_payment');
    }

    public function getPaymentsAttribute() {
        //
        return $this->cashLines
            ->merge( $this->credits )
            ->merge( $this->checks )
            ->merge( $this->creditNotes )
            ->merge( $this->promissoryNotes )
            ->merge( $this->creditCards );
    }

    public function prepareIt():?string {
        // TODO: check that there are invoices to pay
        if ($this->invoices()->count() === 0)
            // reject document with error
            return $this->documentError('payments::receipments.no-invoices');

        // TODO: check that there are payments to apply
        if ($this->payments()->count() === 0)
            // reject document with error
            return $this->documentError('payments::receipments.no-payments');

        // TODO: check if there is an invoices already paid
        foreach ($this->invoices as $invoice) {
            // check if invoice is already paid
            if ($invoice->is_paid)
                // reject document with error
                return $this->documentError('payments::receipments.invoice-already-paid', [
                    'invoice'   => $invoice
                ]);
        }

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
