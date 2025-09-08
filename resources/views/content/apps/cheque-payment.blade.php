@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Payment')

@section('page-script')
    <script src="{{ asset('assets/js/payments.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Settings /</span> Payment
    </h4>
    <div class="row g-4 mb-4">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
    </div>
    <style>
        .dynamicdot {
            content: "";
            height: 15px;
            width: 15px;
            border-radius: 10rem;
            background-color: #1bb37d;
            display: inline-block;
            margin-left: auto;
            margin-right: 0%;
        }
    </style>
    <div class="row g-4">

        <!-- Navigation -->
        <div class="col-12 col-lg-4">
            <div class="d-flex justify-content-between flex-column mb-3 mb-md-0">
                <ul class="nav nav-align-left nav-pills flex-column">
                    <li class="nav-item mb-1">
                        <a class="nav-link" href="{{ url('/payments') }}">
                            <i class="fab fa-stripe-s me-2"></i>
                            <span class="align-middle">Stripe Payment</span>
                            <span class="dynamicdot"
                                style="background-color: {{ optional($payments->firstWhere('payment_mode', 'stripe'))->status ? '#1bb37d' : '#FF4233' }}"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a class="nav-link" href="{{ url('/razor-payment') }}">
                            <i class="bx bx-credit-card me-2"></i>
                            <span class="align-middle">Razor Payment</span>
                            <span class="dynamicdot"
                                style="background-color: {{ optional($payments->firstWhere('payment_mode', 'razor'))->status ? '#1bb37d' : '#FF4233' }}"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a class="nav-link" href="{{ url('/flutterwave-payment') }}">
                            <i class="fas fa-wind me-2"></i>
                            <span class="align-middle">Flutterwave Payment</span>
                            <span class="dynamicdot"
                                style="background-color: {{ optional($payments->firstWhere('payment_mode', 'flutterwave'))->status ? '#1bb37d' : '#FF4233' }}"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a class="nav-link" href="{{ url('/paypal') }}">
                            <i class="fab fa-paypal me-2"></i>
                            <span class="align-middle">PayPal</span>
                            <span class="dynamicdot"
                                style="background-color: {{ optional($payments->firstWhere('payment_mode', 'paypal'))->status ? '#1bb37d' : '#FF4233' }}"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a class="nav-link active" href="javascript:void(0);">
                            <i class="fas fa-money-check-alt me-2"></i>
                            <span class="align-middle">Cheque Payment</span>
                            <span class="dynamicdot"
                                style="background-color: {{ optional($payments->firstWhere('payment_mode', 'cheque'))->status ? '#1bb37d' : '#FF4233' }}"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cod-payment') }}">
                            <i class="fas fa-dollar-sign me-2"></i>
                            <span class="align-middle">COD</span>
                            <span class="dynamicdot"
                                style="background-color: {{ optional($payments->firstWhere('payment_mode', 'cod'))->status ? '#1bb37d' : '#FF4233' }}"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <!-- Options -->
        <div class="col-12 col-lg-8 pt-4 pt-lg-0">
            <div class="tab-content p-0">
                <!-- Payment Mode -->
                <div class="tab-pane fade show active" id="store_details" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">Cheque Payment</h5>
                        </div>
                        <div class="card-body">
                            <form id="addPayment" method="post" action="{{ route('cheque-payment-save') }}">
                                @csrf
                                <div class="row mb-3 g-3">
                                    {{-- Payment Mode --}}
                                    <input type="hidden" class="form-control" id="payment_mode" name="payment_mode"
                                        value="cheque">

                                    <!-- Status Switch -->
                                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                        <span class="h6">Status</span>
                                        <div class="w-25 d-flex justify-content-end">
                                            <label class="switch switch-primary switch-sm me-4 pe-2">
                                                <input type="checkbox" name="status" class="switch-input"
                                                    {{ optional($payments->firstWhere('payment_mode', 'cheque'))->status ? 'checked' : '' }}>
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <span class="switch-off"></span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <input type="submit" class="btn btn-primary me-sm-3 me-1 data-submit" value="Submit"
                                    onclick="submitForm(event)">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('_partials/_modals/modal-select-payment-providers')
    @include('_partials/_modals/modal-select-payment-methods')

@endsection
