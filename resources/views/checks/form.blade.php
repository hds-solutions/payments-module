@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="cash_book_id" required
    foreign="cash_books" :values="$cash_books" foreign-add-label="{{ __('payments::cash_books.add') }}"

    label="{{ __('payments::check.cash_book_id.0') }}"
    placeholder="{{ __('payments::check.cash_book_id._') }}"
    {{-- helper="{{ __('payments::check.cash_book_id.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="description" required
    default="{{ __('payments::check.nav').' @ '.now() }}"
    label="{{ __('payments::check.description.0') }}"
    placeholder="{{ __('payments::check.description._') }}"
    {{-- helper="{{ __('payments::check.description.?') }}" --}} />

{{-- <x-backend-form-amount :resource="$resource ?? null" name="start_balance"
    label="{{ __('payments::check.start_balance.0') }}"
    placeholder="{{ __('payments::check.start_balance._') }}"
    helper="{{ __('payments::check.start_balance.?') }}" /> --}}

<x-backend-form-controls
    submit="payments::checks.save"
    cancel="payments::checks.cancel" cancel-route="backend.checks" />
