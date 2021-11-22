<?php

namespace HDSSolutions\Laravel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class PaymentsMenu extends Base\Menu {

    public function handle($request, Closure $next) {
        // create a submenu
        $sub = backend()->menu()
            ->add(__('payments::payments.nav'), [
                'icon'  => 'hand-holding-usd',
            ])->data('priority', 700);

        $this
            // append items to submenu
            ->checks($sub)
            ->wallet_checks($sub)
            ->credit_notes($sub)
            ;

        // continue witn next middleware
        return $next($request);
    }

    private function checks(&$menu) {
        if (Route::has('backend.checks') && $this->can('checks.crud.index'))
            $menu->add(__('payments::checks.nav'), [
                'route'     => 'backend.checks',
                'icon'      => 'signature'
            ]);

        return $this;
    }

    private function wallet_checks(&$menu) {
        if (Route::has('backend.checks.wallet') && $this->can('checks.crud.index'))
            $menu->add(__('payments::checks.wallet'), [
                'route'     => 'backend.checks.wallet',
                'icon'      => 'signature'
            ]);

        return $this;
    }

    private function credit_notes(&$menu) {
        if (Route::has('backend.credit_notes') && $this->can('credit_notes.crud.index'))
            $menu->add(__('payments::credit_notes.nav'), [
                'route'     => 'backend.credit_notes',
                'icon'      => 'money-check-alt'
            ]);

        return $this;
    }

}
