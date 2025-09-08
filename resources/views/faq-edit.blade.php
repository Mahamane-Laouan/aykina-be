@extends('layouts.master')

@section('title')
    Edit Faq
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection


<style>
    .select2-container--default .select2-selection--multiple {
        min-height: 39px !important;
        border-radius: 9px !important;
        border: 1px solid #edeff166 !important;
    }

    .choices__inner {
        display: inline-block !important;
        vertical-align: top !important;
        width: 100% !important;
        border: 1px solid #edeff166 !important;
        background-color: #edeff166 !important;
        border-radius: 9.5px !important;
        font-size: 14px !important;
        min-height: 44px !important;
        overflow: hidden !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #246FC1 !important;
        color: #fff !important;
    }


    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff !important;
    }

    .dropzone {
        border: dotted !important;
        border-color: lightgrey !important;
    }
</style>


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
@endsection

<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Add Faq's Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Edit Faq <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                   <p class="text-muted">Faq List / Edit Faq</p>
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
                        <h4 class="card-title mb-0">Faq Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('faq-update', ['id' => $faq->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Question <span style="color: red;">*</span></label>
                                <textarea name="title" class="form-control" id="title" placeholder="Enter Question" cols="30" rows="5" style="background-color: #edeff166;">{{ old('title', $faq->title) }}</textarea>
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Answer <span
                                        style="color: red;">*</span></label>
                                <textarea name="description" class="form-control" id="description" placeholder="Enter Answer" cols="30"
                                    rows="5" style="background-color: #edeff166;">{{ old('description', $faq->description) }}</textarea>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="service_id" class="form-label">Select Service <span
                                        style="color: red;">*</span></label>
                                <select class="form-control" data-trigger id="service_id" name="service_id">
                                    <option value="">Select Service</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ $faq->service_id == $service->id ? 'selected' : '' }}>
                                            {{ $service->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('service_id') }}</span>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
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
