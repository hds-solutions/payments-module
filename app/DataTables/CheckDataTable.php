<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Check as Resource;
use Yajra\DataTables\Html\Column;

class CheckDataTable extends Base\DataTable {

    protected array $with = [
        'partnerable',
        'currency',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.checks'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('payments::check.id.0') )
                ->hidden(),

            Column::computed('transacted_at')
                ->title( __('payments::check.transacted_at.0') )
                ->renderRaw('datetime:transacted_at;F j, Y H:i'),

            Column::make('partnerable.full_name')
                ->title( __('payments::check.partnerable_id.0') ),

            Column::make('bank_name')
                ->title( __('payments::check.bank_name.0') ),

            Column::make('bank_account')
                ->title( __('payments::check.bank_account.0') ),

            Column::make('account_holder')
                ->title( __('payments::check.account_holder.0') ),

            Column::computed('due_date')
                ->title( __('payments::check.due_date.0') )
                ->renderRaw('datetime:due_date;F j, Y H:i'),

            Column::make('payment_amount')
                ->title( __('payments::check.payment_amount.0') )
                ->renderRaw('view:check')
                ->data( view('payments::checks.datatable.payment_amount')->render() ),

            Column::make('actions'),
        ];
    }

}
