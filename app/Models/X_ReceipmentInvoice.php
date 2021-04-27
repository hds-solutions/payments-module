<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Builder;

abstract class X_ReceipmentInvoice extends Base\Model {
    use BelongsToCompany;

    protected $fillable = [
        'receipment_id',
        'invoice_id',
        'imputed_amount',
    ];

}
