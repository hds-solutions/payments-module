<?php

namespace HDSSolutions\Laravel\Models;

class Credit extends X_Credit {

    public static function nextDocumentNumber():string {
        // return next document number
        return str_increment(self::join('payments', 'payments.id', 'credits.id')->max('document_number') ?? null);
    }

}
