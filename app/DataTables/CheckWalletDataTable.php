<?php

namespace HDSSolutions\Laravel\DataTables;

use Illuminate\Database\Eloquent\Builder;

class CheckWalletDataTable extends CheckDataTable {

    public function __construct() {
        // override datatable ajax route
        parent::__construct( route('backend.checks.wallet') );
    }

    public function filters(Builder $query) {
        // filter checks that aren't deposited
        return $query->where('is_deposited', false);
    }

}
