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

    protected static array $rules = [
        'receipment_id'     => [ 'required' ],
        'invoice_id'        => [ 'required' ],
        'imputed_amount'    => [ 'required', 'numeric', 'min:0' ],
    ];

}
