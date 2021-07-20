<?php

namespace HDSSolutions\Laravel;

use HDSSolutions\Laravel\Modules\ModuleServiceProvider;
use HDSSolutions\Finpar\Models\Payment;

class PaymentsModuleServiceProvider extends ModuleServiceProvider {

    protected array $middlewares = [
        \HDSSolutions\Laravel\Http\Middleware\PaymentsMenu::class,
    ];

    private $commands = [
        // \HDSSolutions\Laravel\Commands\SomeCommand::class,
    ];

    public function bootEnv():void {
        // enable config override
        $this->publishes([
            module_path('config/payments.php') => config_path('payments.php'),
        ], 'payments.config');

        // load routes
        $this->loadRoutesFrom( module_path('routes/payments.php') );
        // load views
        $this->loadViewsFrom( module_path('resources/views'), 'payments' );
        // load translations
        $this->loadTranslationsFrom( module_path('resources/lang'), 'payments' );
        // load migrations
        $this->loadMigrationsFrom( module_path('database/migrations') );
        // load seeders
        $this->loadSeedersFrom( module_path('database/seeders') );
    }

    public function register() {
        // register helpers
        if (file_exists($helpers = realpath(__DIR__.'/helpers.php')))
            //
            require_once $helpers;
        // register singleton
        app()->singleton(Payments::class, fn() => new Payments);
        $this->alias('Payment', Payment::class);
        // register commands
        $this->commands( $this->commands );
        // merge configuration
        $this->mergeConfigFrom( module_path('config/payments.php'), 'payments' );
    }

}
