<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Check as Resource;
use HDSSolutions\Laravel\Models\Customer;
use HDSSolutions\Laravel\Traits\DatatableWithPartnerable;
use HDSSolutions\Laravel\Traits\DatatableExtendsFromPayment;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class CheckDataTable extends Base\DataTable {
    use DatatableWithPartnerable;
    use DatatableExtendsFromPayment;

    protected array $with = [
        'partnerable',
        'currency',
    ];

    protected array $orderBy = [
        'transacted_at'     => 'desc',
        'due_date'          => 'desc',
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

            Column::make('transacted_at')
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

            Column::make('document_number')
                ->title( __('payments::check.document_number.0') ),

            Column::make('due_date')
                ->title( __('payments::check.due_date.0') )
                ->renderRaw('datetime:due_date;F j, Y H:i'),

            Column::make('payment_amount')
                ->title( __('payments::check.payment_amount.0') )
                ->renderRaw('view:check')
                ->data( view('payments::checks.datatable.payment_amount')->render() ),

            Column::computed('actions'),
        ];
    }

    protected function joins(Builder $query):Builder {
        // add custom JOIN to customers + people for Partnerable
        return $query
            // join to Payment
            ->join('payments', fn($payments) => $payments
                ->on('payments.id', '=', 'checks.id')
                ->where('payments.company_id', '=', backend()->company()->id)
            )
                // join to partnerable
                ->leftJoin('customers', fn($customers) => $customers
                    ->on('payments.partnerable_id', '=', 'customers.id')
                    ->where('payments.partnerable_type', '=', Customer::class)
                )
                    // join to people
                    ->join('people', 'people.id', 'customers.id');
    }

}
