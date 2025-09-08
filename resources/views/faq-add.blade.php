@extends('layouts.master')

@section('title')
    Add Faq
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
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
        {{-- Add Faq's Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Add a new Faq <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                     <p class="text-muted">Faq List / Add Faq</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/faq-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Faq information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('faq-save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Question<span style="color: red;">*</span></label>
                                <textarea name="title" class="form-control" id="title" placeholder="Enter Question" cols="30" rows="5" style="background-color: #edeff166;">{{ old('title') }}</textarea>
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Answer <span
                                        style="color: red;">*</span></label>
                                <textarea name="description" class="form-control" id="description" placeholder="Enter Answer" cols="30" 
                                    rows="5" style="background-color: #edeff166;">{{ old('description') }}</textarea>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="servce_id" class="form-label">Select Service <span
                                        style="color: red;">*</span></label>
                                <select class="form-control" data-trigger id="servce_id" name="servce_id">
                                    <option value="">Select Service</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('servce_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('servce_id') }}</span>
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
