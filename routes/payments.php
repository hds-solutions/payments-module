<?php

use Illuminate\Support\Facades\Route;
use HDSSolutions\Laravel\Http\Controllers\{
    CheckController,
    CreditNoteController,
};

Route::group([
    'prefix'        => config('backend.prefix'),
    'middleware'    => [ 'web', 'auth:'.config('backend.guard') ],
], function() {
    // name prefix
    $name_prefix = [ 'as' => 'backend' ];

    Route::resource('checks',           CheckController::class,    $name_prefix)
        ->only([ 'index', 'show' ])
        ->parameters([ 'checks' => 'resource' ])
        ->name('index', 'backend.checks');

    Route::resource('credit_notes',     CreditNoteController::class,    $name_prefix)
        ->parameters([ 'credit_notes' => 'resource' ])
        ->name('index', 'backend.credit_notes');

    // Route::resource('payments',    PaymentsController::class,   $name_prefix)
    //     ->parameters([ 'payments' => 'resource' ])
    //     ->name('index', 'backend.payments');

});
