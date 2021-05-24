@extends('backend::layouts.master')

@section('page-name', __('payments::checks.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-company-plus"></i>
                @lang('payments::checks.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.checks.create') }}"
                    class="btn btn-sm btn-primary">@lang('payments::checks.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.checks.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('payments::checks.form')
        </form>
    </div>
</div>

@endsection
