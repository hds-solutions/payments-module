<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\ExtendsPayment;
use Illuminate\Database\Eloquent\Builder;

abstract class X_Credit extends Base\Model {
    use ExtendsPayment;

    public $incrementing = false;

    protected $fillable = [
    ];


}
