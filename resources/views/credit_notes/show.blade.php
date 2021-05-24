@extends('backend::layouts.master')

@section('page-name', __('payments::credit_notes.title'))
@section('description', __('payments::credit_notes.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-user-plus"></i>
                @lang('payments::credit_notes.show')
            </div>
            <div class="col-6 d-flex justify-content-end">
                @if ($resource->isOpen())
                <a href="{{ route('backend.credit_notes.edit', $resource) }}"
                    class="btn btn-sm ml-2 btn-info">@lang('payments::credit_notes.edit')</a>
                @endif
                <a href="{{ route('backend.credit_notes.create') }}"
                    class="btn btn-sm ml-2 btn-primary">@lang('payments::credit_notes.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">

        @include('backend::components.errors')

        <div class="row">
            <div class="col">
                <h2>@lang('payments::credit_note.details.0')</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::credit_note.cash_book_id.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ $resource->cashBook->name }}</div>
                </div>

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::credit_note.currency_id.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ $resource->cashBook->currency->name }}</div>
                </div>

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::credit_note.start_balance.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ amount($resource->start_balance, $resource->cashBook->currency) }}</div>
                </div>

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::credit_note.end_balance.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ amount($resource->end_balance, $resource->cashBook->currency) }}</div>
                </div>

                <div class="row">
                    <div class="col-4 col-lg-4">@lang('payments::credit_note.document_status.0'):</div>
                    <div class="col-8 col-lg-6 h4">{{ Document::__($resource->document_status) }}</div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col">
                <h2>@lang('payments::credit_note.lines.0')</h2>
            </div>
        </div>

        <div class="row">
            <div class="col">

                <div class="table-responsive">
                    <table class="table table-sm table-striped table-borderless table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>@lang('payments::credit_note.lines.created_at.0')</th>
                                <th>@lang('payments::credit_note.lines.cash_type.0')</th>
                                <th>@lang('payments::credit_note.lines.description.0')</th>
                                <th>@lang('payments::credit_note.lines.amount.0')</th>
                                <th>@lang('payments::credit_note.lines.new_amount.0')</th>
                                <th>@lang('payments::credit_note.end_balance.0')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $end_balance = $resource->start_balance; @endphp
                            @foreach ($resource->lines as $line)
                                <tr class="@if ($line->amount < 0) text-danger @endif">
                                    <td class="align-middle pl-3">{{ pretty_date($line->created_at, true) }}</td>
                                    <td class="align-middle pl-3">{{ $line->cash_type }}</td>
                                    <td class="align-middle pl-3">{{ $line->description }}</td>
                                    <td class="align-middle pl-3">{{ amount($line->amount, $line->currency) }}</td>
                                    <td class="align-middle pl-3">{{ amount($line->net_amount, $resource->cashBook->currency) }}</td>
                                    <td class="align-middle pl-3">{{ amount($end_balance += $line->net_amount, $resource->cashBook->currency) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        @include('backend::components.document-actions', [
            'route'     => 'backend.credit_notes.process',
            'resource'  => $resource,
        ])

    </div>
</div>

@endsection
