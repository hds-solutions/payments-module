<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\CreditNote as Resource;
use Yajra\DataTables\Html\Column;

class CreditNoteDataTable extends Base\DataTable {

    protected array $with = [
        'partnerable',
        'currency',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.credit_notes'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('payments::credit_note.id.0') )
                ->hidden(),

            Column::computed('transacted_at')
                ->title( __('payments::credit_note.transacted_at.0') )
                ->renderRaw('datetime:transacted_at;F j, Y H:i'),

            Column::make('description')
                ->title( __('payments::credit_note.description.0') ),

            Column::make('partnerable.full_name')
                ->title( __('payments::credit_note.partnerable_id.0') ),

            Column::make('payment_amount')
                ->title( __('payments::credit_note.payment_amount.0') )
                ->renderRaw('view:credit_note')
                ->data( view('payments::credit_notes.datatable.payment_amount')->render() ),

            Column::make('used_amount')
                ->title( __('payments::credit_note.used_amount.0') )
                ->renderRaw('view:credit_note')
                ->data( view('payments::credit_notes.datatable.used_amount')->render() ),

            Column::make('actions'),
        ];
    }

}
