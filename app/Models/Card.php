<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Validation\Validator;

class Card extends X_Card {

    protected function beforeSave(Validator $validator) {
        // force card number to 4 chars
        $this->card_number = substr($this->card_number, 0, 4);
    }

}
