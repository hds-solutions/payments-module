<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'        => config('backend.prefix'),
    'middleware'    => [ 'web', 'auth:'.config('backend.guard') ],
], function() {
    // name prefix
    $name_prefix = [ 'as' => 'backend' ];

    // Route::resource('payments',    PaymentsController::class,   $name_prefix)
    //     ->parameters([ 'payments' => 'resource' ])
    //     ->name('index', 'backend.payments');

});
