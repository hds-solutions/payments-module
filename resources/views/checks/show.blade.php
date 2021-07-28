@extends('backend::layouts.master')

@section('page-name', __('payments::checks.title'))
@section('description', __('payments::checks.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-user-plus"></i>
                @lang('payments::checks.show')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.checks.create') }}"
                    class="btn btn-sm ml-2 btn-primary">@lang('payments::checks.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">

        @include('backend::components.errors')

        <div class="row">
            <div class="col">
                <h2>@lang('payments::check.details.0')</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::check.partnerable_id.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ $resource->partnerable->fullname }} <small class="font-weight-light">[{{ $resource->partnerable->ftid }}]</small></div>
                </div>

                <div class="row">
                    <div class="col-4">@lang('payments::check.transacted_at.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ pretty_date($resource->transacted_at, true) }}</div>
                </div>

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::check.bank_name.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ $resource->bank_name }}</div>
                </div>

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::check.bank_account.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ $resource->bank_account }}</div>
                </div>

                <div class="row">
                    <div class="col-4">@lang('payments::check.document_number.0'):</div>
                    <div class="col-8 col-lg-6 h4 font-weight-bold">{{ $resource->document_number }}</div>
                </div>

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::check.account_holder.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ $resource->account_holder }}</div>
                </div>

                {{-- <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::check.currency_id.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ currency($resource->currency_id)->name }}</div>
                </div> --}}

                <div class="row">
                    <div class="col-4">@lang('payments::check.payment_amount.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ currency($resource->currency_id)->code }} <b>{{ number($resource->payment_amount, currency($resource->currency_id)->decimals) }}</b></div>
                </div>

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::check.due_date.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ pretty_date($resource->due_date) }}</div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
