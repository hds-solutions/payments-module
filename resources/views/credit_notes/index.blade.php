@extends('backend::layouts.master')

@section('page-name', __('payments::credit_notes.title'))
@section('description', __('payments::credit_notes.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center cursor-pointer"
                data-toggle="collapse" data-target="#filters">
                <i class="fas fa-table mr-2"></i>
                @lang('payments::credit_notes.index')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.credit_notes.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('payments::credit_notes.create')</a> --}}
            </div>
        </div>
        <div class="row collapse @if (request()->has('filters')) show @endif" id="filters">
            <form action="{{ route('backend.checks') }}"
                class="col mt-2 pt-3 pb-2 border-top">

                <x-backend-form-foreign name="filters[partnerable]"
                    :values="$customers" show="full_name" default="{{ request('filters.partnerable') }}"

                    label="payments::check.partnerable_id.0"
                    placeholder="payments::check.partnerable_id._"
                    {{-- helper="payments::check.partnerable_id.?" --}} />

                <button type="submit"
                    class="btn btn-sm btn-outline-primary">Filtrar</button>

                <button type="reset"
                    class="btn btn-sm btn-outline-secondary btn-hover-danger">Limpiar filtros</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        @if ($count)
            <div class="table-responsive">
                {{ $dataTable->table() }}
                @include('backend::components.datatable-actions', [
                    'resource'  => 'credit_notes',
                    'actions'   => [ 'show', 'update', 'delete' ],
                    'label'     => '{resource.document_number}',
                ])
            </div>
        @else
            <div class="text-center m-t-30 m-b-30 p-b-10">
                <h2><i class="fas fa-table text-custom"></i></h2>
                <h3>@lang('backend.empty.title')</h3>
                {{-- <p class="text-muted">
                    @lang('backend.empty.description')
                    <a href="{{ route('backend.credit_notes.create') }}" class="text-custom">
                        <ins>@lang('payments::credit_notes.create')</ins>
                    </a>
                </p> --}}
            </div>
        @endif
    </div>
</div>

@endsection

@push('config-scripts')
{{ $dataTable->scripts() }}
@endpush
