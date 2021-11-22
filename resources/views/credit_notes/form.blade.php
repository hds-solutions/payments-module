@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="cash_book_id" required
    foreign="cash_books" :values="$cash_books" foreign-add-label="{{ __('payments::cash_books.add') }}"

    label="{{ __('payments::credit_note.cash_book_id.0') }}"
    placeholder="{{ __('payments::credit_note.cash_book_id._') }}"
    {{-- helper="{{ __('payments::credit_note.cash_book_id.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="description" required
    default="{{ __('payments::credit_note.nav').' @ '.now() }}"
    label="{{ __('payments::credit_note.description.0') }}"
    placeholder="{{ __('payments::credit_note.description._') }}"
    {{-- helper="{{ __('payments::credit_note.description.?') }}" --}} />

{{-- <x-backend-form-amount :resource="$resource ?? null" name="start_balance"
    label="{{ __('payments::credit_note.start_balance.0') }}"
    placeholder="{{ __('payments::credit_note.start_balance._') }}"
    helper="{{ __('payments::credit_note.start_balance.?') }}" /> --}}

<x-backend-form-controls
    submit="payments::cashes.save"
    cancel="payments::cashes.cancel" cancel-route="backend.cashes" />
