@extends('layouts.master')

@section('title')
    Add Coupon
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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

        .flatpickr-input[readonly],
        .input[readonly] {
            background-color: #edeff166 !important;
        }
    </style>
@endsection


@section('body')

    <body>
    @endsection

    @section('content')
        {{-- Add Coupon Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Add a new Coupon <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Coupon List / Add Coupon</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/coupon-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Coupon Information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('coupon-save') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Coupon Code <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="code"
                                            placeholder="Enter Coupon Code" name="code" value="{{ old('code') }}"
                                            aria-label="Coupon Code">
                                        <span id="code_error" class="error text-danger">{{ $errors->first('code') }}</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="discount" class="form-label">Coupon Discount <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="discount"
                                            placeholder="Enter Coupon Discount" name="discount"
                                            value="{{ old('discount') }}" aria-label="Coupon Discount">
                                        <span id="discount_error"
                                            class="error text-danger">{{ $errors->first('discount') }}</span>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Discount Type <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-trigger id="type" name="type">
                                            <option value="">Select an option</option>
                                            <option value="Percentage" {{ old('type') == 'Percentage' ? 'selected' : '' }}>
                                                Percentage</option>
                                            <option value="Fixed" {{ old('type') == 'Fixed' ? 'selected' : '' }}>Fixed
                                            </option>
                                        </select>
                                        <span id="type_error" class="error text-danger">{{ $errors->first('type') }}</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="coupon_for" class="form-label">Coupon For <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-trigger id="coupon_for" name="coupon_for">
                                            <option value="">Select an option</option>
                                            <option value="Service" {{ old('coupon_for') == 'Service' ? 'selected' : '' }}>
                                                Service</option>
                                            <option value="Product" {{ old('coupon_for') == 'Product' ? 'selected' : '' }}>
                                                Product</option>
                                        </select>
                                        <span id="coupon_for_error"
                                            class="error text-danger">{{ $errors->first('coupon_for') }}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-trigger id="status" name="status">
                                            <option value="">Select an option</option>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                        <span id="status_error"
                                            class="error text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Expire Date <span style="color: red;">*</span></label>
                                        <input type="text" id="datetimepicker" class="form-control"
                                            placeholder="Select Date & Time" name="expire_date">
                                        <span id="expire_date_error"
                                            class="error text-danger">{{ $errors->first('expire_date_error') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Coupon Description <span
                                                style="color: red;">*</span></label>
                                        <textarea name="description" class="form-control" id="description" placeholder="Enter Coupon Description"
                                            cols="30" rows="5" style="background-color: #edeff166;">{{ old('description') }}</textarea>
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    </div>
                                </div>
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
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                flatpickr("#datetimepicker", {
                    enableTime: true, // Enable time picker
                    dateFormat: "Y-m-d H:i:S", // Set format to include date and time
                    time_24hr: true, // Use 24-hour format
                });
            });
        </script>
    @endsection
