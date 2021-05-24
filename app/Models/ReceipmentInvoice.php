<?php

namespace HDSSolutions\Finpar\Models;

use Illuminate\Validation\Validator;

class ReceipmentInvoice extends X_ReceipmentInvoice {

    public function receipment() {
        return $this->belongsTo(Receipment::class);
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    protected function beforeSave(Validator $validator) {
        // check if invoice is completed
        if (!$this->invoice->isCompleted)
            // reject line with error
            return $validator->errors()->add('invoice_id', __('sales::invoice.lines.invoice-not-completed', [
                'invoice'   => $this->invoice->document_number,
            ]));
    }

}
