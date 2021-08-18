<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Builder;

class CreditNote extends X_CreditNote {

    public static function nextDocumentNumber():string {
        // return next document number
        return str_increment(self::withTrashed()->max('document_number') ?? null);
    }

    public function __construct(array|MaterialReturn $attributes = []) {
        // check if is instance of MaterialReturn
        if (($materialReturn = $attributes) instanceof MaterialReturn) $attributes = self::fromMaterialReturn($materialReturn);
        // redirect attributes to parent
        parent::__construct(is_array($attributes) ? $attributes : []);
    }

    private static function fromMaterialReturn(MaterialReturn $materialReturn):array {
        // copy invoice attributes
        $attributes = [
            'currency_id'       => $materialReturn->invoice->currency_id,
            'partnerable_type'  => $materialReturn->partnerable_type,
            'partnerable_id'    => $materialReturn->partnerable_id,
            'document_number'   => self::nextDocumentNumber(),
            'transacted_at'     => $materialReturn->transacted_at,
            'description'       => __('payments::credit_note.material-return', [
                'document_number'   => $materialReturn->invoice->document_number,
            ]),
        ];

        // calculate payment_amount from Invoice lines
        $attributes['payment_amount'] = 0;
        foreach ($materialReturn->lines as $line)
            // add amount of returned line multiplied by invoiced price
            $attributes['payment_amount'] += $line->invoiceLine->price_invoiced * $line->quantity_movement;

        // return creditNote attributes
        return $attributes;
    }

    public static function createFromMaterialReturn(int|MaterialReturn $materialReturn, array $attributes = []):CreditNote {
        // make creditNote
        $creditNote = self::makeFromMaterialReturn($materialReturn, $attributes);
        // save created creditNote
        $creditNote->save();
        // return created creditNote
        return $creditNote;
    }

    public static function makeFromMaterialReturn(int|MaterialReturn $materialReturn, array $attributes = []):CreditNote {
        // load materialReturn if isn't instance
        if (!$materialReturn instanceof MaterialReturn) $materialReturn = MaterialReturn::findOrFail($materialReturn);
        // create new CreditNote from materialReturn
        $creditNote = new self($materialReturn);
        // append extra attributes
        $creditNote->fill( $attributes );
        // link Invoice from which material is returned
        $creditNote->documentable()->associate( $materialReturn );
        // return CreditNote
        return $creditNote;
    }

    public function scopeAvailable(Builder $query) {
        return $this->scopeUsed($query, false);
    }

    public function scopeUsed(Builder $query, bool $used = true) {
        return $query->where('is_used', $used);
    }

    public function scopePaid(Builder $query, bool $paid = true) {
        return $query->where('is_paid', $paid);
    }

    public function documentable() {
        // return $this->morphTo(type: 'documentable_type', id: 'documentable_id');
        return $this->morphTo();
    }

}
