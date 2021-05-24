<?php

namespace HDSSolutions\Finpar\Contracts;

interface PaymentContract {

    public function company();

    public function currency();

    public function partnerable();

}
