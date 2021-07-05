<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Interfaces\Document;
use HDSSolutions\Finpar\Traits\HasDocumentActions;
use HDSSolutions\Finpar\Traits\HasPartnerable;

class Receipment extends X_Receipment implements Document {
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
            ->withPivot([ 'imputed_amount' ])
            ->as('receipmentInvoice');
    }

    public function cashLines() {
        return $this->morphedByMany(CashLine::class, 'paymentable', 'receipment_payment')
            ->using(ReceipmentPayment::class)
            ->withTimestamps()
            ->withPivot([ 'currency_id', 'payment_type', 'payment_amount', 'used_amount' ])
            ->as('receipmentPayment');
    }

    public function credits() {
        return $this->morphedByMany(Credit::class, 'paymentable', 'receipment_payment')
            ->using(ReceipmentPayment::class)
            ->withTimestamps()
            ->withPivot([ 'currency_id', 'payment_type', 'payment_amount', 'used_amount' ])
            ->as('receipmentPayment');
    }

    public function checks() {
        return $this->morphedByMany(Check::class, 'paymentable', 'receipment_payment')
            ->using(ReceipmentPayment::class)
            ->withTimestamps()
            ->withPivot([ 'currency_id', 'payment_type', 'payment_amount', 'used_amount', 'credit_note_id' ])
            ->as('receipmentPayment');
    }

    public function creditNotes() {
        return $this->morphedByMany(CreditNote::class, 'paymentable', 'receipment_payment')
            ->using(ReceipmentPayment::class)
            ->withTimestamps()
            ->withPivot([ 'currency_id', 'payment_type', 'payment_amount', 'used_amount' ])
            ->as('receipmentPayment');
    }

    public function promissoryNotes() {
        return $this->morphedByMany(PromissoryNote::class, 'paymentable', 'receipment_payment')
            ->using(ReceipmentPayment::class)
            ->withTimestamps()
            ->withPivot([ 'currency_id', 'payment_type', 'payment_amount', 'used_amount' ])
            ->as('receipmentPayment');
    }

    public function cards() {
        return $this->morphedByMany(Card::class, 'paymentable', 'receipment_payment')
            ->using(ReceipmentPayment::class)
            ->withTimestamps()
            ->withPivot([ 'currency_id', 'payment_type', 'payment_amount', 'used_amount' ])
            ->as('receipmentPayment');
    }

    public function payments() {
        return $this->payments;
    }

    public function getPaymentsAttribute() {
        //
        return $this->cashLines
            ->merge($this->cards)
            ->merge($this->credits)
            ->merge($this->creditNotes)
            // we append Checks after other payments
            // to process last and create CreditNote for remaining amount
            ->merge($this->checks)
            ->merge($this->promissoryNotes);
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
            // check that invoice is completed
            if (!$invoice->isCompleted)
                // reject document with error
                return $this->documentError('payments::receipments.invoice-not-completed', [
                    'invoice'   => $invoice->document_number,
                ]);
            // check if invoice is already paid
            if ($invoice->is_paid)
                // reject document with error
                return $this->documentError('payments::receipments.invoice-already-paid', [
                    'invoice'   => $invoice->document_number,
                ]);
        }

        // get invoices inputed amount
        $imputedAmount = $this->invoices->sum('receipmentInvoice.imputed_amount');
        // get payments amount
        $paymentsAmount = $this->payments->sum('receipmentPayment.payment_amount');
        // TODO: check sum(payments.payment_amount) == sum(invoices.imputed_amount)
        if ($imputedAmount > $paymentsAmount)
            // reject document with error
            return $this->documentError('payments::receipments.imputed-gt-payments', [
                'imputed_amount'    => $imputedAmount,
                'payments_amount'   => $paymentsAmount,
            ]);

        // TODO: check if there is invoices.is_credit=false and there is credit payments, if so reject
        $has_cash_invoices = false;
        $this->invoices->each(fn($invoice) => $has_cash_invoices = $invoice->is_cash || $has_cash_invoices);
        if ($this->credits->count() > 0 && $has_cash_invoices)
            // reject document with error
            return $this->documentError('payments::receipments.credit-with-cash-invoices');

        // TODO: check if there are credit payments
        if ($this->credits->count()) {
            // TODO: check if partner doesn't have credit enabled
            if (!$this->partnerable->has_credit_enabled)
                // reject document with error
                return $this->documentError('payments::receipments.partnerable-no-credit-enabled');
            // TODO: check if partner doesn't have enought credit available
            if ($this->partnerable->credit_available === 0)
                // reject document with error
                return $this->documentError('payments::receipments.partnerable-no-credit-available');
        }

        // return status InProgress
        return Document::STATUS_InProgress;
    }

    public function completeIt():?string {
        // get total invoices imputed amount
        $pendingAmount = $this->invoices->sum('receipmentInvoice.imputed_amount');
        // TODO: for each ReceipmentPayment
        foreach ($this->payments as $payment) {
            switch (true) {
                // TODO: if ReceipmentPayment type=creditNote
                case $payment instanceof CreditNote:
                    // TODO: substract creditNote.used_amount
                    $payment->used_amount += $payment->receipmentPayment->payment_amount;
                    break;

                // TODO: if ReceipmentPayment type=check
                case $payment instanceof Check:
                    // TODO: if Check.payment_amount > pendingReceipmentAmount
                    if ($payment->payment_amount > $pendingAmount) {
                        // TODO: generate CreditNote for remaining check amount
                        $creditNote = CreditNote::make([
                            'document_number'   => 1234, // TODO: get next credit note number
                            'payment_amount'    => $amount = ($payment->payment_amount - $pendingAmount),
                            'description'       => __('payments::credit_note.check-diff', [
                                'document_number'   => $payment->document_number,
                                'amount'            => $amount,
                            ]),
                        ]);
                        $creditNote->currency()->associate( $payment->currency );
                        $creditNote->partnerable()->associate( $payment->partnerable );
                        $creditNote->documentable()->associate( $payment );
                        // save CreditNote
                        if (!$creditNote->save())
                            // redirect error
                            return $this->documentError( $creditNote->errors()->first() ?? 'payments::receipments.check-diff-credit-note-creation-failed' );

                        // set pending amount to 0 (zero)
                        $pendingAmount = 0;
                    }
                    break;
            }
            // save payment changes
            if (!$payment->save())
                // redirect error
                return $this->documentError( $payment->errors()->first() ?? 'payments::receipments.payment-update-failed' );

            //
            $relation = match(get_class($payment)) {
                CashLine::class         => 'cashLines',
                Credit::class           => 'credits',
                Check::class            => 'checks',
                CreditNote::class       => 'creditNotes',
                PromissoryNote::class   => 'promissoryNotes',
                Card::class             => 'cards',
            };

            // TODO: set ReceipmentPayment.used_amount
            if (!$this->$relation()->updateExistingPivot($payment->id, [ 'used_amount' => $payment->receipmentPayment->payment_amount ]))
                // reject document with error
                return $this->documentError('payments::receipments.payment-update-failed');

            // substract payment amount from pending payments amount
            $pendingAmount -= $payment->receipmentPayment->payment_amount;
        }

        // TODO: for each ReceipmentInvoice
        foreach ($this->invoices as $invoice) {
            // TODO: set ReceipmentInvoice.invoice.paid_amount = ReceipmentInvoice.inputed_amount
            $invoice->paid_amount += $invoice->receipmentInvoice->imputed_amount;
            // TODO: set Invoice.is_paid=true if paid_amount == imputed_amount
            $invoice->is_paid = $invoice->paid_amount == $invoice->total;
            // save invoice changes
            if (!$invoice->save())
                // redirect error
                return $this->documentError( $invoice->errors()->first() ?? 'payments::receipments.invoice-update-failed' );
        };

        // update partnerable credit
        if (!$this->partnerable->updateCreditUsed())
            // redirect error
            return $this->documentError( $this->partnerable->errors()->first() ?? 'payments::receipments.partnerable-update-credit-used-failed' );

        // return completed status
        return Document::STATUS_Completed;
    }

}
