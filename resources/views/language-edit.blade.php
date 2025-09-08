@extends('layouts.master')
@section('title')
    Edit Language
@endsection
@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->first_name }} {{ $userwelcomedata->last_name }}
@endsection
@section('css')
    <!-- choices css -->
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- color picker css -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" /> <!-- 'nano' theme -->

    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">


    <link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

    <style>
        input.form-control {
            background-color: #edeff166;
            border: 1px solid #edeff1;
            border-radius: calc(6px + .0025*(100vw - 320px));
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 400;
            color: #00162e;
        }

        .form-control {
            background-color: #edeff166;
            border: 1px solid #edeff1;
            border-radius: calc(6px + .0025*(100vw - 320px));
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 400;
            color: #00162e;
        }

        .choices__list--dropdown .choices__item {
            color: #000 !important;
        }


        .choices__inner {
            background-color: #edeff166 !important;
        }
    </style>
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Add Language Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Edit Language <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">
                        <a href="/language-list" class="text-muted">Language</a> / Edit Language
                    </p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/language-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Language information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('language-update', ['status_id' => $language->status_id]) }}" method="POST">

                            @csrf
                            <div class="mb-3">
                                <label for="language" class="form-label">Language Name <span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="language" placeholder="Enter Language Name"
                                    name="language" value="{{ old('language', $language->language) }}">
                                <span id="language_error" class="error text-danger">{{ $errors->first('language') }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="language_alignment" class="form-label">Text Direction <span
                                        style="color: red;">*</span></label>
                                <select class="form-control" id="language_alignment" data-trigger name="language_alignment">
                                    <option value="ltr" {{ $language->language_alignment == 'ltr' ? 'selected' : '' }}>
                                        Left to Right (LTR)</option>
                                    <option value="rtl" {{ $language->language_alignment == 'rtl' ? 'selected' : '' }}>
                                        Right to Left (RTL)</option>
                                </select>
                                <span id="language_alignment_error" class="error text-danger">
                                    {{ $errors->first('language_alignment') }}
                                </span>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <!-- choices js -->
        <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

        <!-- color picker js -->
        <script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

        <!-- datepicker js -->
        <script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
