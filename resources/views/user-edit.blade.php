@extends('layouts.master')

@section('title')
    User List
@endsection

@section('page-title')
    User List
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">
@endsection

<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<style>
    .choices__inner {
        display: inline-block !important;
        vertical-align: top !important;
        width: 100% !important;
        border: 1px solid #eff0f2 !important;
        background-color: #ffff !important;
        border-radius: 9.5px !important;
        /* padding: 0px !important; */
        font-size: 14px !important;
        min-height: 44px !important;
        overflow: hidden !important;
    }
</style>

@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Edit User Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Edit User <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">User List / Edit User</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/user-list" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">User information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('user-update', ['id' => $user->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3" style="row-gap: 1rem;">

                                <div class="col-md-12 d-flex" style="flex-direction: column;">
                                    <label for="choices-single-groups" class="form-label">
                                        Status <span style="color: red;">*</span>
                                    </label>
                                    <select class="form-control" data-trigger id="confirmation" name="confirmation">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $user->confirmation == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $user->confirmation == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    <span id="confirmation_error" class="error text-danger">
                                        {{ $errors->first('confirmation') }}
                                    </span>
                                </div>
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
