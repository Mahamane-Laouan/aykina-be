@extends('layouts.master')

@section('title')
    Edit Tax
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

@section('css')
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">

    <style>
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
    </style>
@endsection

@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Edit Tax Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Edit Tax <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Tax List / Edit Tax</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/tax-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Tax information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('tax-update', ['id' => $category->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Tax Name <span
                                        style="color: red;">*</span></label>
                                <input type="text" id="name" value="{{ $category->name }}"
                                    placeholder="Enter Tax Name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" />
                                @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tax_rate" class="form-label">Tax Rate <span
                                        style="color: red;">*</span></label>
                                <input type="text" id="tax_rate" value="{{ $category->tax_rate }}"
                                    placeholder="Enter Tax Rate" name="tax_rate"
                                    class="form-control @error('tax_rate') is-invalid @enderror" />
                                @error('tax_rate')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="type" class="form-label">Type <span style="color: red;">*</span></label>
                                <select class="form-control" data-trigger id="type" name="type">
                                    <option value="">Select Type</option>
                                    <option value="1" {{ old('type', $category->type) == '1' ? 'selected' : '' }}>
                                        Fixed
                                    </option>
                                    <option value="0" {{ old('type', $category->type) == '0' ? 'selected' : '' }}>
                                        Percentage
                                    </option>
                                </select>
                                <span id="type_error" class="error text-danger">{{ $errors->first('type') }}</span>
                            </div>


                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span style="color: red;">*</span></label>
                                <select class="form-control" data-trigger id="status" name="status">
                                    <option value="">Select Option</option>
                                    <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                <span id="status_error" class="error text-danger">{{ $errors->first('status') }}</span>
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
        <script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
