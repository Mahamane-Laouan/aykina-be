@extends('layouts.master')
@section('title')
    Handyman Commission
@endsection
@section('page-title')
    Handyman Commission
@endsection

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
@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Handyman Commission Headline --}}
        <div class="row align-items-center">
            <div class="col-md-3" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Handyman Commission <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Handyman / Handyman Commission</p>
                </div>
            </div>
        </div>

        <div class="row">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Handyman Commission Information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('handyman-commissionsave') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="value" class="form-label">Handyman Commission<span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Handyman Commission"
                                    id="value" name="value" value="{{ old('value', $data->value ?? '') }}">
                                <span class="error">{{ $errors->first('value') }}</span>
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
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
