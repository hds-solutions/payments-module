@extends('backend::layouts.master')

@section('page-name', __('payments::credit_notes.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-company-plus"></i>
                @lang('payments::credit_notes.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.credit_notes.create') }}"
                    class="btn btn-sm btn-primary">@lang('payments::credit_notes.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.credit_notes.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('payments::credit_notes.form')
        </form>
    </div>
</div>

@endsection
