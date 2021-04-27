<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class PaymentsMenu {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // create a submenu
        $sub = backend()->menu()
            ->add(__('payments::payments.nav'), [
                'icon'  => 'cogs',
            ])->data('priority', 700);

        $this
            // append items to submenu
            ->payments($sub);

        // continue witn next middleware
        return $next($request);
    }

    private function payments(&$menu) {
        if (Route::has('backend.payments'))
            $menu->add(__('payments::payments.nav'), [
                'route'     => 'backend.payments',
                'icon'      => 'payments'
            ]);

        return $this;
    }

}
