@extends('layouts.master')

@section('title')
    Payment Method
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<style>
    .nav-link.active {
        background-color: #246FC1;
        color: white;
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

@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Privacy Policy Headline --}}
        <div class="row align-items-center">
            <div class="col-md-3" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Payment Method <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Settings Management / Payment Method</p>
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
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#razorpaysetup" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Razor Pay</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#flutterwavesetup" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Flutter Wave</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#stripesetup" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Stripe</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#paypalsetup" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">PayPal</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#googlepaysetup" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Google Pay</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#applepaysetup" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Apple Pay</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#walletsetup" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Wallet</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">

                            {{-- Razorpay --}}
                            <div class="tab-pane" id="razorpaysetup" role="tabpanel">
                                <div class="card shadow-sm border-0">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0" style="color: #ffff;">Razorpay</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('razorpay-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Razorpay Service Switch -->
                                            <div class="row mb-4 align-items-center border rounded p-3 bg-light">
                                                <div class="col-md-6">
                                                    <label for="razorpay_service" class="form-label fw-bold text-dark">
                                                        Enable Razorpay Payment
                                                    </label>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <div class="form-check form-switch"
                                                        style="margin-left: auto; margin-right: 0; width: fit-content;">
                                                        <input type="checkbox" class="form-check-input" id="razorpaySwitch"
                                                            name="razorpay_enabled" style="width: 2rem; height: 1.2rem;"
                                                            {{ $razorpay->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2" for="razorpaySwitch"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Razorpay Options -->
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold text-dark">RazorPay Mode</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="razorpay_mode"
                                                        id="razorpay_test" value="Test"
                                                        {{ $razorpay->mode == 'Test' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="razorpay_test">Test
                                                        Credential</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="razorpay_mode"
                                                        id="razorpay_live" value="Live"
                                                        {{ $razorpay->mode == 'Live' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="razorpay_live">Live
                                                        Credential</label>
                                                </div>
                                            </div>

                                            <!-- Razorpay Keys -->
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="razorpay_public_key"
                                                        class="form-label fw-bold text-dark">RazorPay Public Key</label>
                                                    <input type="text" class="form-control" id="razorpay_public_key"
                                                        name="razorpay_public_key" placeholder="Enter RazorPay Public Key"
                                                        value="*************">
                                                    <span id="razorpay_public_key_error"
                                                        class="text-danger small">{{ $errors->first('razorpay_public_key') }}</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="razorpay_secret_key"
                                                        class="form-label fw-bold text-dark">RazorPay Secret Key</label>
                                                    <input type="text" class="form-control" id="razorpay_secret_key"
                                                        name="razorpay_secret_key" placeholder="Enter RazorPay Secret Key"
                                                        value="*************">
                                                    <span id="razorpay_secret_key_error"
                                                        class="text-danger small">{{ $errors->first('razorpay_secret_key') }}</span>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>


                            {{-- Flutter Wave --}}
                            <div class="tab-pane" id="flutterwavesetup" role="tabpanel">
                                <div class="card shadow-sm border-0">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0" style="color: #ffff;">FlutterWave</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('flutterwave-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- FlutterWave Service Switch -->
                                            <div class="row mb-4 align-items-center border rounded p-3 bg-light">
                                                <div class="col-md-6">
                                                    <label for="flutterwave_service" class="form-label fw-bold text-dark">
                                                        Enable FlutterWave Payment
                                                    </label>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <div class="form-check form-switch"
                                                        style="margin-left: auto; margin-right: 0; width: fit-content;">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="flutterWaveSwitch" name="flutterwave_enabled"
                                                            style="width: 2rem; height: 1.2rem;"
                                                            {{ $flutterwave->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2"
                                                            for="flutterWaveSwitch"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Razorpay Options -->
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold text-dark">FlutterWave Mode</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="flutterwave_mode" id="flutterwave_test" value="Test"
                                                        {{ $flutterwave->mode == 'Test' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flutterwave_test">Test
                                                        Credential</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="flutterwave_mode" id="flutterwave_live" value="Live"
                                                        {{ $flutterwave->mode == 'Live' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flutterwave_live">Live
                                                        Credential</label>
                                                </div>
                                            </div>

                                            <!-- Razorpay Keys -->
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="flutterwave_public_key"
                                                        class="form-label fw-bold text-dark">FlutterWave Public Key</label>
                                                    <input type="text" class="form-control"
                                                        id="flutterwave_public_key" name="flutterwave_public_key"
                                                        placeholder="Enter FlutterWave Public Key"
                                                        value="*************">
                                                    <span id="flutterwave_public_key_error"
                                                        class="text-danger small">{{ $errors->first('flutterwave_public_key') }}</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="flutterwave_secret_key"
                                                        class="form-label fw-bold text-dark">FlutterWave Secret Key</label>
                                                    <input type="text" class="form-control"
                                                        id="flutterwave_secret_key" name="flutterwave_secret_key"
                                                        placeholder="Enter FlutterWave Secret Key"
                                                        value="*************">
                                                    <span id="flutterwave_secret_key_error"
                                                        class="text-danger small">{{ $errors->first('flutterwave_secret_key') }}</span>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>


                            {{-- Stripe --}}
                            <div class="tab-pane" id="stripesetup" role="tabpanel">
                                <div class="card shadow-sm border-0">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0" style="color: #ffff;">Stripe</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('stripe-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Stripe Service Switch -->
                                            <div class="row mb-4 align-items-center border rounded p-3 bg-light">
                                                <div class="col-md-6">
                                                    <label for="stripe" class="form-label fw-bold text-dark">
                                                        Enable Stripe Payment
                                                    </label>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <div class="form-check form-switch"
                                                        style="margin-left: auto; margin-right: 0; width: fit-content;">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="stripeWaveSwitch" name="stripe_enabled"
                                                            style="width: 2rem; height: 1.2rem;"
                                                            {{ $stripe->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2"
                                                            for="stripeWaveSwitch"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stripe Options -->
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold text-dark">Stripe Mode</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="stripe_mode"
                                                        id="stripe_test" value="Test"
                                                        {{ $stripe->mode == 'Test' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="stripe_test">Test
                                                        Credential</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="stripe_mode"
                                                        id="stripe_live" value="Live"
                                                        {{ $stripe->mode == 'Live' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="stripe_live">Live
                                                        Credential</label>
                                                </div>
                                            </div>

                                            <!-- Razorpay Keys -->
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="stripe_public_key"
                                                        class="form-label fw-bold text-dark">Stripe Public Key</label>
                                                    <input type="text" class="form-control" id="stripe_public_key"
                                                        name="stripe_public_key" placeholder="Enter Stripe Public Key"
                                                        value="*************">
                                                    <span id="stripe_public_key_error"
                                                        class="text-danger small">{{ $errors->first('stripe_public_key') }}</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="stripe_secret_key"
                                                        class="form-label fw-bold text-dark">Stripe Secret Key</label>
                                                    <input type="text" class="form-control" id="stripe_secret_key"
                                                        name="stripe_secret_key" placeholder="Enter Stripe Secret Key"
                                                        value="*************">
                                                    <span id="stripe_secret_key_error"
                                                        class="text-danger small">{{ $errors->first('stripe_secret_key') }}</span>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>


                            {{-- PayPal --}}
                            <div class="tab-pane" id="paypalsetup" role="tabpanel">
                                <div class="card shadow-sm border-0">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0" style="color: #ffff;">PayPal</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('paypal-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- PayPal Service Switch -->
                                            <div class="row mb-4 align-items-center border rounded p-3 bg-light">
                                                <div class="col-md-6">
                                                    <label for="paypal" class="form-label fw-bold text-dark">
                                                        Enable PayPal Payment
                                                    </label>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <div class="form-check form-switch"
                                                        style="margin-left: auto; margin-right: 0; width: fit-content;">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="paypalWaveSwitch" name="paypal_enabled"
                                                            style="width: 2rem; height: 1.2rem;"
                                                            {{ $paypal->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2"
                                                            for="paypalWaveSwitch"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- PayPal Options -->
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold text-dark">PayPal Mode</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="paypal_mode"
                                                        id="paypal_test" value="Test"
                                                        {{ $paypal->mode == 'Test' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="paypal_test">Test
                                                        Credential</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="paypal_mode"
                                                        id="paypal_live" value="Live"
                                                        {{ $paypal->mode == 'Live' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="paypal_live">Live
                                                        Credential</label>
                                                </div>
                                            </div>

                                            <!-- Razorpay Keys -->
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="paypal_public_key"
                                                        class="form-label fw-bold text-dark">PayPal Public Key</label>
                                                    <input type="text" class="form-control" id="paypal_public_key"
                                                        name="paypal_public_key" placeholder="Enter PayPal Public Key"
                                                        value="*************">
                                                    <span id="paypal_public_key_error"
                                                        class="text-danger small">{{ $errors->first('paypal_public_key') }}</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="paypal_secret_key"
                                                        class="form-label fw-bold text-dark">PayPal Secret Key</label>
                                                    <input type="text" class="form-control" id="paypal_secret_key"
                                                        name="paypal_secret_key" placeholder="Enter PayPal Secret Key"
                                                        value="*************">
                                                    <span id="paypal_secret_key_error"
                                                        class="text-danger small">{{ $errors->first('paypal_secret_key') }}</span>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>


                            {{-- Google Pay --}}
                            <div class="tab-pane" id="googlepaysetup" role="tabpanel">
                                <div class="card shadow-sm border-0">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0" style="color: #ffff;">Google Pay</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('googlepay-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Google Pay Service Switch -->
                                            <div class="row mb-4 align-items-center border rounded p-3 bg-light">
                                                <div class="col-md-6">
                                                    <label for="googlepay" class="form-label fw-bold text-dark">
                                                        Enable Google Pay Payment
                                                    </label>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <div class="form-check form-switch"
                                                        style="margin-left: auto; margin-right: 0; width: fit-content;">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="googlepayWaveSwitch" name="googlepay_enabled"
                                                            style="width: 2rem; height: 1.2rem;"
                                                            {{ $googlepay->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2"
                                                            for="googlepayWaveSwitch"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Google Pay Options -->
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold text-dark">Google Pay Mode</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="googlepay_mode"
                                                        id="googlepay_test" value="Test"
                                                        {{ $googlepay->mode == 'Test' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="googlepay_test">Test
                                                        Credential</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="googlepay_mode"
                                                        id="googlepay_live" value="Live"
                                                        {{ $googlepay->mode == 'Live' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="googlepay_live">Live
                                                        Credential</label>
                                                </div>
                                            </div>

                                            <!-- Razorpay Keys -->
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="googlepay_public_key"
                                                        class="form-label fw-bold text-dark">Google Pay Merchant Id</label>
                                                    <input type="text" class="form-control" id="googlepay_public_key"
                                                        name="googlepay_public_key" placeholder="Google Pay Merchant Id"
                                                        value="*************">
                                                    <span id="googlepay_public_key_error"
                                                        class="text-danger small">{{ $errors->first('googlepay_public_key') }}</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="googlepay_secret_key"
                                                        class="form-label fw-bold text-dark">Google Pay Merchant
                                                        Name</label>
                                                    <input type="text" class="form-control" id="googlepay_secret_key"
                                                        name="googlepay_secret_key"
                                                        placeholder="Enter Google Pay Merchant Name"
                                                        value="*************">
                                                    <span id="googlepay_secret_key_error"
                                                        class="text-danger small">{{ $errors->first('googlepay_secret_key') }}</span>
                                                </div>
                                            </div>


                                            <!-- Razorpay Keys -->
                                            <div class="row g-3" style="padding-top: 20px;">
                                                <div class="col-md-6">
                                                    <label for="country_code" class="form-label fw-bold text-dark">Google
                                                        Pay Country Code</label>
                                                    <input type="text" class="form-control" id="country_code"
                                                        name="country_code" placeholder="Google Pay Country Code"
                                                        value="{{ old('country_code', $googlepay->country_code ?? '') }}">
                                                    <span id="country_code_error"
                                                        class="text-danger small">{{ $errors->first('country_code') }}</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="currency_code" class="form-label fw-bold text-dark">Google
                                                        Pay Currency Code</label>
                                                    <input type="text" class="form-control" id="currency_code"
                                                        name="currency_code" placeholder="Enter Google Pay Currency Code"
                                                        value="{{ old('currency_code', $googlepay->currency_code ?? '') }}">
                                                    <span id="currency_code_error"
                                                        class="text-danger small">{{ $errors->first('currency_code') }}</span>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>


                            {{-- Apple Pay --}}
                            <div class="tab-pane" id="applepaysetup" role="tabpanel">
                                <div class="card shadow-sm border-0">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0" style="color: #ffff;">Apple Pay</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('applepay-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Apple Pay Service Switch -->
                                            <div class="row mb-4 align-items-center border rounded p-3 bg-light">
                                                <div class="col-md-6">
                                                    <label for="applepay" class="form-label fw-bold text-dark">
                                                        Enable Apple Pay Payment
                                                    </label>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <div class="form-check form-switch"
                                                        style="margin-left: auto; margin-right: 0; width: fit-content;">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="applepayWaveSwitch" name="applepay_enabled"
                                                            style="width: 2rem; height: 1.2rem;"
                                                            {{ $applepay->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2"
                                                            for="applepayWaveSwitch"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Apple Pay Options -->
                                            <div class="form-group mb-4">
                                                <label class="form-label fw-bold text-dark">Apple Pay Mode</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="applepay_mode"
                                                        id="applepay_test" value="Test"
                                                        {{ $applepay->mode == 'Test' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="applepay_test">Test
                                                        Credential</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="applepay_mode"
                                                        id="applepay_live" value="Live"
                                                        {{ $applepay->mode == 'Live' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="applepay_live">Live
                                                        Credential</label>
                                                </div>
                                            </div>

                                            <!-- Razorpay Keys -->
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="applepay_public_key"
                                                        class="form-label fw-bold text-dark">Apple Pay Merchant Id</label>
                                                    <input type="text" class="form-control" id="applepay_public_key"
                                                        name="applepay_public_key" placeholder="Apple Pay Merchant Id"
                                                        value="*************">
                                                    <span id="applepay_public_key_error"
                                                        class="text-danger small">{{ $errors->first('applepay_public_key') }}</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="applepay_secret_key"
                                                        class="form-label fw-bold text-dark">Apple Pay Merchant
                                                        Name</label>
                                                    <input type="text" class="form-control" id="applepay_secret_key"
                                                        name="applepay_secret_key"
                                                        placeholder="Enter Apple Pay Merchant Name"
                                                        value="*************">
                                                    <span id="applepay_secret_key_error"
                                                        class="text-danger small">{{ $errors->first('applepay_secret_key') }}</span>
                                                </div>
                                            </div>


                                            <!-- Razorpay Keys -->
                                            <div class="row g-3" style="padding-top: 20px;">
                                                <div class="col-md-6">
                                                    <label for="country_code" class="form-label fw-bold text-dark">Apple
                                                        Pay Country Code</label>
                                                    <input type="text" class="form-control" id="country_code"
                                                        name="country_code" placeholder="Apple Pay Country Code"
                                                        value="{{ old('country_code', $applepay->country_code ?? '') }}">
                                                    <span id="country_code_error"
                                                        class="text-danger small">{{ $errors->first('country_code') }}</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="currency_code" class="form-label fw-bold text-dark">Apple
                                                        Pay Currency Code</label>
                                                    <input type="text" class="form-control" id="currency_code"
                                                        name="currency_code" placeholder="Enter Apple Pay Currency Code"
                                                        value="{{ old('currency_code', $applepay->currency_code ?? '') }}">
                                                    <span id="currency_code_error"
                                                        class="text-danger small">{{ $errors->first('currency_code') }}</span>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>


                            {{-- Wallet --}}
                            <div class="tab-pane" id="walletsetup" role="tabpanel">
                                <div class="card shadow-sm border-0">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0" style="color: #ffff;">Wallet</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('wallet-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Wallet Service Switch -->
                                            <div class="row mb-4 align-items-center border rounded p-3 bg-light">
                                                <div class="col-md-6">
                                                    <label for="wallet" class="form-label fw-bold text-dark">
                                                        Enable Wallet Payment
                                                    </label>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <div class="form-check form-switch"
                                                        style="margin-left: auto; margin-right: 0; width: fit-content;">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="walletWaveSwitch" name="wallet_enabled"
                                                            style="width: 2rem; height: 1.2rem;"
                                                            {{ $wallet->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2"
                                                            for="walletWaveSwitch"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Wallet Options -->
                                            {{-- <div class="form-group mb-4">
                                                <label class="form-label fw-bold text-dark">Wallet Mode</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="wallet_mode"
                                                        id="wallet_test" value="Test"
                                                        {{ $wallet->mode == 'Test' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="wallet_test">Test
                                                        Credential</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="wallet_mode"
                                                        id="wallet_live" value="Live"
                                                        {{ $wallet->mode == 'Live' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="wallet_live">Live
                                                        Credential</label>
                                                </div>
                                            </div> --}}


                                            <!-- Submit Button -->
                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Retrieve the active tab from localStorage
                const activeTab = localStorage.getItem('activepaymentconfig');

                if (activeTab) {
                    // Activate the saved tab
                    const tabLink = document.querySelector(`a[href="${activeTab}"]`);
                    const tabPane = document.querySelector(activeTab);

                    if (tabLink && tabPane) {
                        tabLink.classList.add('active');
                        tabPane.classList.add('active', 'show');
                    }
                } else {
                    // Activate the default tab: #razorpaysetup
                    const defaultTabLink = document.querySelector('.nav-link[href="#razorpaysetup"]');
                    const defaultTabPane = document.querySelector('#razorpaysetup');

                    if (defaultTabLink && defaultTabPane) {
                        defaultTabLink.classList.add('active');
                        defaultTabPane.classList.add('active', 'show');
                    }
                }

                // Add click event to all tabs
                document.querySelectorAll('.nav-link').forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Save the clicked tab's ID to localStorage
                        localStorage.setItem('activepaymentconfig', this.getAttribute('href'));

                        // Update active classes for tabs and panes
                        document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove(
                            'active'));
                        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove(
                            'active', 'show'));

                        this.classList.add('active');
                        const targetPane = document.querySelector(this.getAttribute('href'));
                        if (targetPane) {
                            targetPane.classList.add('active', 'show');
                        }
                    });
                });
            });
        </script>
    @endsection
