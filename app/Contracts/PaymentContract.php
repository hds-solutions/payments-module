<?php

namespace HDSSolutions\Laravel\Contracts;

interface PaymentContract {

    public function company();

    public function currency();

    public function partnerable();

}
