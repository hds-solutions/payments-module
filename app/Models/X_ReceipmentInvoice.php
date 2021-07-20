<?php

namespace HDSSolutions\Laravel\Models;

abstract class X_ReceipmentInvoice extends Base\Pivot {

    protected $table = 'receipment_invoice';

    protected $fillable = [
        'receipment_id',
        'invoice_id',
        'imputed_amount',
    ];

    protected static array $rules = [
        'receipment_id'     => [ 'required' ],
        'invoice_id'        => [ 'required' ],
        'imputed_amount'    => [ 'required', 'numeric', 'min:0' ],
    ];

}
