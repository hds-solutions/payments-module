<?php

namespace HDSSolutions\Laravel\Traits;

use Illuminate\Database\Eloquent\Builder;

trait DatatableExtendsFromPayment {

    protected function searchTransactedAt(Builder $query, string $value):Builder {
        // return custom search for Payment.transacted_at
        return $query->where('payments.transacted_at', 'like', "%$value%");
    }

    protected function searchPaymentAmount(Builder $query, string $value):Builder {
        // return custom search for Payment.payment_amount
        return $query->where('payments.payment_amount', 'like', "%$value%");
    }

    protected function searchDocumentNumber(Builder $query, string $value):Builder {
        return $query->where('payments.document_number', 'like', "%$value%");
    }

    protected abstract function joins(Builder $query):Builder;

}
