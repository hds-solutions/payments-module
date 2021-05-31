<?php

namespace HDSSolutions\Finpar\Seeders;

class PaymentsPermissionsSeeder extends Base\PermissionsSeeder {

    public function __construct() {
        parent::__construct('payments');
    }

    protected function permissions():array {
        return [
            $this->resource('checks'),
            $this->resource('credit_notes'),
        ];
    }

    protected function afterRun():void {
        // append permissions to Cashier role
        $this->role('Cashier', [
            'checks.*',
            'credit_notes.*',
        ]);
    }

}
