@extends('layouts.master')
@section('title')
    Add Handyman
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Add Handyman Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Add a new Handyman <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Handyman List / Add Handyman</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/handyman-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Handyman information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('handyman-save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3" style="row-gap: 1rem;">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">First Name <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="firstname" placeholder="Enter First Name"
                                        name="firstname" value="{{ old('firstname') }}" aria-label="First Name">
                                    <span id="firstname_error"
                                        class="error text-danger">{{ $errors->first('firstname') }}</span>
                                </div>

                                <div class="col-md-6">
                                    <label for="lastname" class="form-label">Last Name <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name"
                                        name="lastname" value="{{ old('lastname') }}" aria-label="Last Name">
                                    <span id="lastname_error"
                                        class="error text-danger">{{ $errors->first('lastname') }}</span>
                                </div>
                            </div>


                            <div class="row mb-3" style="row-gap: 1rem;">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="email" placeholder="Enter Email"
                                        name="email" value="{{ old('email') }}" aria-label="Email">
                                    <span id="email_error" class="error text-danger">{{ $errors->first('email') }}</span>
                                </div>


                                <div class="col-md-6 d-flex" style="flex-direction: column;">
                                    <label for="mobile" class="form-label">Contact Number<span class="text-muted"> (Should
                                            contain 10 digits numbers)</span> <span style="color: red;">*</span></label>
                                    <input type="tel" class="form-control" id="mobile" name="mobile"
                                        placeholder="Enter Contact Number" value="{{ old('mobile') }}"
                                        aria-label="Contact Number">
                                    <span id="mobile_error" class="error text-danger">{{ $errors->first('mobile') }}</span>
                                </div>

                                <input type="hidden" id="country_code" name="country_code">
                            </div>


                            <div class="row mb-3" style="row-gap: 1rem;">
                                <div class="col-md-6 position-relative">
                                    <label for="password" class="form-label">Password<span class="text-muted"> (Should
                                            contain alphabets, numbers & special characters)</span> <span
                                            style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Enter Password" name="password" value="{{ old('password') }}"
                                            aria-label="Password">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                            onclick="togglePassword('password', this)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                    <span id="password_error"
                                        class="error text-danger">{{ $errors->first('password') }}</span>
                                </div>

                                <div class="col-md-6 position-relative">
                                    <label for="confirm_password" class="form-label">Confirm Password<span
                                            class="text-muted"> (Must match the password)</span> <span
                                            style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password"
                                            placeholder="Enter Confirmation Password" name="password_confirmation"
                                            value="{{ old('password_confirmation') }}"
                                            aria-label="Confirmation Password">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                            onclick="togglePassword('confirm_password', this)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                    <span id="password_confirmation_error"
                                        class="error text-danger">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-6 position-relative">
                                    <label for="choices-single-groups" class="form-label">Select Provider <span
                                            style="color: red;">*</span></label>
                                    <select class="form-control" data-trigger id="provider_id" name="provider_id">
                                        <option value="">Select Provider</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->firstname }}
                                                {{ $provider->lastname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="provider_id_error"
                                        class="error text-danger">{{ $errors->first('provider_id') }}</span>
                                </div>

                                <div class="col-md-6 position-relative">
                                    <label for="is_blocked" class="form-label">Status <span
                                            style="color: red;">*</span></label>
                                    <select class="form-control" data-trigger id="is_blocked" name="is_blocked">
                                        <option value="">Select an option</option>
                                        <option value="1" {{ old('is_blocked', '1') == '1' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0" {{ old('is_blocked') == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    <span id="is_blocked_error"
                                        class="error text-danger">{{ $errors->first('is_blocked') }}</span>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="profile_pic" class="form-label">Profile Image <span
                                        style="color: red;">*</span></label>
                                <input class="form-control" type="file" id="profile_pic" name="profile_pic"
                                    onchange="previewImage(event)">
                                <span id="image_error"
                                    class="error text-danger">{{ $errors->first('profile_pic') }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="image_preview" class="form-label"></label>
                                <img id="image_preview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 150px; max-height: 150px;" />
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
        <script>
            function previewImage(event) {
                const imageInput = event.target;
                const preview = document.getElementById('image_preview');

                if (imageInput.files && imageInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(imageInput.files[0]);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            }

            function togglePassword(fieldId, button) {
                let field = document.getElementById(fieldId);
                let icon = button.querySelector("i");

                if (field.type === "password") {
                    field.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    field.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.querySelector("#mobile");
                const countryCodeInput = document.querySelector("#country_code"); // Hidden country code input
                const iti = window.intlTelInput(input, {
                    initialCountry: "auto",
                    geoIpLookup: function(callback) {
                        fetch('https://ipinfo.io/json?token=YOUR_API_TOKEN')
                            .then(response => response.json())
                            .then(data => callback(data.country))
                            .catch(() => callback('us'));
                    },
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js", // for formatting/validation
                });

                // Set the country code when the input is initialized or changed
                input.addEventListener('input', function() {
                    countryCodeInput.value = iti.getSelectedCountryData().dialCode; // Set the country code
                });

                // Example: Getting the full number on form submit
                document.querySelector("form").addEventListener("submit", function() {
                    input.value = iti.getNumber(); // Sets the full international number
                });
            });
        </script>
    @endsection
