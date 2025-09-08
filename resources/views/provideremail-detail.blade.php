@extends('layouts.master')

@section('title')
    Provider Email
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<style>
    .nav-link.active {
        background-color: #007bff;
        color: white;
    }
</style>

@section('body')

    <body>
    @endsection
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="{{ asset('build/js/provideremail-detail.js') }}"></script>
    <script src="{{ asset('build/js/provideremail-statuschange.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @section('content')
        {{-- Email Headline --}}
        <div class="row align-items-center">
            <div class="col-md-3" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Provider Email <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Email / Provider Email</p>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="row">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist" id="tabList">
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerotpverify" role="tab">
                                    <span class="d-none d-sm-block">Otp Verify</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerforgotpassword" role="tab">
                                    <span class="d-none d-sm-block">Forgot Password</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerordereceived" role="tab">
                                    <span class="d-none d-sm-block">Order Received</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerbookingaccepted" role="tab">
                                    <span class="d-none d-sm-block">Booking Accepted</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerbookingrejected" role="tab">
                                    <span class="d-none d-sm-block">Booking Rejected</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerassignhandyman" role="tab">
                                    <span class="d-none d-sm-block">Order Cancelled</span>
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerrejecthandyman" role="tab">
                                    <span class="d-none d-sm-block">Reject Handyman</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerorderinprogress" role="tab">
                                    <span class="d-none d-sm-block">Order in Progress</span>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerorderdelivered" role="tab">
                                    <span class="d-none d-sm-block">Order Delivered</span>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerbookinghold" role="tab">
                                    <span class="d-none d-sm-block">Booking Hold</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerbookingcompleted" role="tab">
                                    <span class="d-none d-sm-block">Booking Completed</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerpaymentreceived" role="tab">
                                    <span class="d-none d-sm-block">Payment Request Received</span>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerpaymentsent" role="tab">
                                    <span class="d-none d-sm-block">Payment Request Sent</span>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerreviewreceived" role="tab">
                                    <span class="d-none d-sm-block">Review Received</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">

                            {{-- Otp Verify --}}
                            <div class="tab-pane" id="providerotpverify" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerotpverify') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        provider otp verify?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-otpverify-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderotpverify->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderOtpVerify({{ $emailproviderotpverify->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-otpverify-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerotpverify-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerotpverify-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerotpverify-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h5 id="providerotpverify-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h5>
                                                                    <h3
                                                                        style="text-align: center; margin-bottom: 20px; font-size: 28px;">
                                                                        523621</h3>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerotpverify-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerotpverify-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerotpverify-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerotpverify-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerotpverify-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerotpverify-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerotpverify-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerotpverify-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="providerotpverify-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3" id="providerotpverify-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerotpverify') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderotpverify) && $emailproviderotpverify->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderotpverify->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderotpverify->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderotpverify->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderotpverify->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderotpverify) && $emailproviderotpverify->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderotpverify) && $emailproviderotpverify->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderotpverify->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Forgot Password --}}
                            <div class="tab-pane" id="providerforgotpassword" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerforgotpassword') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        provider forgot password?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-forgotpassword-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderforgotpassword->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderForgotPassword({{ $emailproviderforgotpassword->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-forgotpassword-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerforgotpassword-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerforgotpassword-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerforgotpassword-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h5 id="providerforgotpassword-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h5>
                                                                    <h3
                                                                        style="text-align: center; margin-bottom: 20px; font-size: 28px;">
                                                                        523621</h3>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerforgotpassword-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerforgotpassword-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerforgotpassword-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerforgotpassword-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerforgotpassword-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerforgotpassword-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerforgotpassword-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerforgotpassword-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerforgotpassword-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerforgotpassword-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerforgotpassword') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderforgotpassword) && $emailproviderforgotpassword->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderforgotpassword->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderforgotpassword->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderforgotpassword->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderforgotpassword->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderforgotpassword) && $emailproviderforgotpassword->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderforgotpassword) && $emailproviderforgotpassword->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderforgotpassword->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Order Received --}}
                            <div class="tab-pane" id="providerordereceived" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerordereceived') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider order received?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-orderplaced-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderorderreceived->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderOrderReceived({{ $emailproviderorderreceived->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-orderplaced-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerordereceived-title" class="mb-4"
                                                        style="font-size: 1.2rem;"></h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                        <p id="providerordereceived-body"></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerordereceived-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;">Order Info</h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 800px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: start; gap: 20px; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h5 style="margin-bottom: 15px; color: #333;">Order
                                                                        Summary</h5>
                                                                    <div style="color: #555; margin-bottom: 8px;">
                                                                        <strong>Order #:</strong> 432121
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h5 style="margin-bottom: 15px; color: #333;">Delivery
                                                                        Address</h5>
                                                                    <div style="color: #555; margin-bottom: 8px;">Munam
                                                                        Shahariar</div>
                                                                    <div style="color: #555;">4517 Washington Ave.
                                                                        Manchester, Kentucky 39495</div>
                                                                </div>
                                                            </div>

                                                            <table
                                                                style="width: 100%; border-collapse: collapse; margin-bottom: 20px; background-color: #ffffff; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                <thead style="background-color: #4C7FDB; color: #fff;">
                                                                    <tr>
                                                                        <th
                                                                            style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">
                                                                            Service</th>
                                                                        <th
                                                                            style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">
                                                                            Quantity</th>
                                                                        <th
                                                                            style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">
                                                                            Price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            style="padding: 10px; border-bottom: 1px solid #ddd; display: flex; align-items: center; gap: 10px;">
                                                                            <img src="images/socialmedialogo/service_image.jpg"
                                                                                alt="Home Paint Service"
                                                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                                            Home Paint Service
                                                                        </td>
                                                                        <td
                                                                            style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">
                                                                            2
                                                                        </td>
                                                                        <td
                                                                            style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">
                                                                            $500.00
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <table
                                                                style="width: 100%; border-collapse: collapse; margin-bottom: 20px; background-color: #ffffff; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                <thead style="background-color: #4C7FDB; color: #fff;">
                                                                    <tr>
                                                                        <th
                                                                            style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">
                                                                            Product</th>
                                                                        <th
                                                                            style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">
                                                                            Quantity</th>
                                                                        <th
                                                                            style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">
                                                                            Price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            style="padding: 10px; border-bottom: 1px solid #ddd; display: flex; align-items: center; gap: 10px;">
                                                                            <img src="images/socialmedialogo/product_image.jpg"
                                                                                alt="Home Paint Service"
                                                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                                            Cleaty Paint Box
                                                                        </td>
                                                                        <td
                                                                            style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">
                                                                            1
                                                                        </td>
                                                                        <td
                                                                            style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">
                                                                            $500.00
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <div
                                                                style="padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); max-width: 400px; margin-left: auto;">
                                                                <dl style="margin: 0;">
                                                                    <div
                                                                        style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                                        <dt>Item Price:</dt>
                                                                        <dd style="margin: 0;">$500.00</dd>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                                        <dt>Coupon Discount:</dt>
                                                                        <dd style="margin: 0;">- $50.00</dd>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                                        <dt>Sub Total:</dt>
                                                                        <dd style="margin: 0;">$450.00</dd>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                                        <dt>VAT/Tax:</dt>
                                                                        <dd style="margin: 0;">$25.00</dd>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                                        <dt>Delivery Fee:</dt>
                                                                        <dd style="margin: 0;">$0.00</dd>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex; justify-content: space-between; font-weight: bold; color: #28a745;">
                                                                        <dt>Total:</dt>
                                                                        <dd style="margin: 0;">$475.00</dd>
                                                                    </div>
                                                                </dl>
                                                            </div>

                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerordereceived-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerordereceived-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerordereceived-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerordereceived-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerordereceived-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerordereceived-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerordereceived-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerordereceived-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="providerordereceived-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerordereceived-copyrightcontent"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerordereceived') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderorderreceived) && $emailproviderorderreceived->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderorderreceived->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif

                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderorderreceived->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderorderreceived->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderorderreceived->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderorderreceived) && $emailproviderorderreceived->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderorderreceived) && $emailproviderorderreceived->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderorderreceived->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Booking Accepted --}}
                            <div class="tab-pane" id="providerbookingaccepted" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerbookingaccepted') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider booking accepted?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-bookingaccepted-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderbookingaccepted->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderBookingAccepted({{ $emailproviderbookingaccepted->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-bookingaccepted-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerbookingaccepted-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerbookingaccepted-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerbookingaccepted-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerbookingaccepted-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Handyman Name:</strong>
                                                                        Clay Joey
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerbookingaccepted-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingaccepted-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingaccepted-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingaccepted-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingaccepted-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerbookingaccepted-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerbookingaccepted-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerbookingaccepted-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerbookingaccepted-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerbookingaccepted-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerbookingaccepted') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderbookingaccepted) && $emailproviderbookingaccepted->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderbookingaccepted->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderbookingaccepted->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderbookingaccepted->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderbookingaccepted->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderbookingaccepted) && $emailproviderbookingaccepted->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderbookingaccepted) && $emailproviderbookingaccepted->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderbookingaccepted->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{-- Booking Rejected --}}
                            <div class="tab-pane" id="providerbookingrejected" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerbookingrejected') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider booking rejected?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-bookingrejected-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderbookingrejected->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderBookingRejected({{ $emailproviderbookingrejected->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-bookingrejected-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerbookingrejected-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerbookingrejected-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerbookingrejected-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerbookingrejected-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Handyman Name:</strong>
                                                                        Clay Joey
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerbookingrejected-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingrejected-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingrejected-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingrejected-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingrejected-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerbookingrejected-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerbookingrejected-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerbookingrejected-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerbookingrejected-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerbookingrejected-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerbookingrejected') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderbookingrejected) && $emailproviderbookingrejected->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderbookingrejected->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderbookingrejected->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderbookingrejected->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderbookingrejected->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}" data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderbookingrejected) && $emailproviderbookingrejected->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderbookingrejected) && $emailproviderbookingrejected->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderbookingrejected->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{-- Assign Handyman --}}
                            <div class="tab-pane" id="providerassignhandyman" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerassignhandyman') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider order cancelled?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-assignhandyman-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderassignhandyman->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderAssignHandyman({{ $emailproviderassignhandyman->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-assignhandyman-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerassignhandyman-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerassignhandyman-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerassignhandyman-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerassignhandyman-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Handyman Name:</strong>
                                                                        Clay Joey
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerassignhandyman-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerassignhandyman-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerassignhandyman-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerassignhandyman-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerassignhandyman-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerassignhandyman-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerassignhandyman-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerassignhandyman-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerassignhandyman-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerassignhandyman-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerassignhandyman') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderassignhandyman) && $emailproviderassignhandyman->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderassignhandyman->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderassignhandyman->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderassignhandyman->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderassignhandyman->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}" data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderassignhandyman) && $emailproviderassignhandyman->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderassignhandyman) && $emailproviderassignhandyman->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderassignhandyman->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{-- Reject Handyman --}}
                            <div class="tab-pane" id="providerrejecthandyman" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerrejecthandyman') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider reject handyman?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-rejecthandyman-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderrejecthandyman->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderRejectHandyman({{ $emailproviderrejecthandyman->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-rejecthandyman-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerrejecthandyman-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerrejecthandyman-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerrejecthandyman-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerrejecthandyman-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Handyman Name:</strong>
                                                                        Clay Joey
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerrejecthandyman-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerrejecthandyman-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerrejecthandyman-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerrejecthandyman-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerrejecthandyman-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerrejecthandyman-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerrejecthandyman-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerrejecthandyman-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerrejecthandyman-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerrejecthandyman-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerrejecthandyman') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderrejecthandyman) && $emailproviderrejecthandyman->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderrejecthandyman->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderrejecthandyman->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderrejecthandyman->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderrejecthandyman->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}" data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderrejecthandyman) && $emailproviderrejecthandyman->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderrejecthandyman) && $emailproviderrejecthandyman->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderrejecthandyman->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{-- Order In Progress --}}
                            <div class="tab-pane" id="providerorderinprogress" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerorderinprogress') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider order in progress?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-orderinprogress-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderorderinprogress->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderOrderInProgress({{ $emailproviderorderinprogress->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-orderinprogress-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerorderinprogress-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerorderinprogress-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerorderinprogress-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerorderinprogress-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerorderinprogress-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerorderinprogress-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerorderinprogress-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerorderinprogress-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerorderinprogress-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerorderinprogress-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerorderinprogress-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerorderinprogress-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerorderinprogress-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerorderinprogress-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerorderinprogress') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderorderinprogress) && $emailproviderorderinprogress->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderorderinprogress->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderorderinprogress->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderorderinprogress->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderorderinprogress->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderorderinprogress) && $emailproviderorderinprogress->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderorderinprogress) && $emailproviderorderinprogress->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderorderinprogress->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{-- Order Delivered --}}
                            <div class="tab-pane" id="providerorderdelivered" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerorderdelivered') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider order delivered?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-orderdelivered-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderorderdelivered->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderOrderDelivered({{ $emailproviderorderdelivered->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-orderdelivered-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerorderdelivered-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerorderdelivered-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerorderdelivered-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerorderdelivered-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerorderdelivered-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerorderdelivered-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerorderdelivered-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerorderdelivered-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerorderdelivered-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerorderdelivered-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerorderdelivered-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerorderdelivered-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerorderdelivered-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerorderdelivered-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerorderdelivered') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderorderdelivered) && $emailproviderorderdelivered->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderorderdelivered->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderorderdelivered->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderorderdelivered->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderorderdelivered->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderorderdelivered) && $emailproviderorderdelivered->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderorderdelivered) && $emailproviderorderdelivered->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderorderdelivered->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{--Booking Hold --}}
                            <div class="tab-pane" id="providerbookinghold" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerbookinghold') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider booking hold?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-bookinghold-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderbookinghold->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderBookingHold({{ $emailproviderbookinghold->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-bookinghold-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerbookinghold-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerbookinghold-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerbookinghold-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerbookinghold-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerbookinghold-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookinghold-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookinghold-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookinghold-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookinghold-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerbookinghold-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerbookinghold-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerbookinghold-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerbookinghold-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerbookinghold-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerbookinghold') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderbookinghold) && $emailproviderbookinghold->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderbookinghold->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderbookinghold->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderbookinghold->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderbookinghold->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderbookinghold) && $emailproviderbookinghold->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderbookinghold) && $emailproviderbookinghold->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderbookinghold->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{--Booking Completed --}}
                            <div class="tab-pane" id="providerbookingcompleted" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerbookingcompleted') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider booking completed?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-bookingcompleted-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderbookingcompleted->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderBookingCompleted({{ $emailproviderbookingcompleted->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-bookingcompleted-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerbookingcompleted-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerbookingcompleted-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerbookingcompleted-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerbookingcompleted-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerbookingcompleted-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingcompleted-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingcompleted-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingcompleted-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerbookingcompleted-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerbookingcompleted-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerbookingcompleted-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerbookingcompleted-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerbookingcompleted-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerbookingcompleted-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerbookingcompleted') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderbookingcompleted) && $emailproviderbookingcompleted->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderbookingcompleted->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderbookingcompleted->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderbookingcompleted->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderbookingcompleted->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderbookingcompleted) && $emailproviderbookingcompleted->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderbookingcompleted) && $emailproviderbookingcompleted->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderbookingcompleted->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{--Payment Request Received --}}
                            <div class="tab-pane" id="providerpaymentreceived" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerpaymentreceived') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider payment request received?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-paymentreceived-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderpaymentreceived->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderPaymentReceived({{ $emailproviderpaymentreceived->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-paymentreceived-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerpaymentreceived-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerpaymentreceived-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerpaymentreceived-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerpaymentreceived-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Amount:</strong> $432
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerpaymentreceived-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerpaymentreceived-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerpaymentreceived-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerpaymentreceived-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerpaymentreceived-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerpaymentreceived-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerpaymentreceived-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerpaymentreceived-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerpaymentreceived-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerpaymentreceived-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerpaymentreceived') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderpaymentreceived) && $emailproviderpaymentreceived->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderpaymentreceived->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderpaymentreceived->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderpaymentreceived->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderpaymentreceived->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderpaymentreceived) && $emailproviderpaymentreceived->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderpaymentreceived) && $emailproviderpaymentreceived->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderpaymentreceived->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{--Payment Request Sent --}}
                            <div class="tab-pane" id="providerpaymentsent" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerpaymentsent') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider payment request sent?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-paymentsent-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderpaymentsent->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderPaymentSent({{ $emailproviderpaymentsent->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-paymentsent-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerpaymentsent-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerpaymentsent-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerpaymentsent-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerpaymentsent-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Amount:</strong> $432
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerpaymentsent-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerpaymentsent-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerpaymentsent-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerpaymentsent-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerpaymentsent-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerpaymentsent-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerpaymentsent-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerpaymentsent-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerpaymentsent-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerpaymentsent-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerpaymentsent') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderpaymentsent) && $emailproviderpaymentsent->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderpaymentsent->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderpaymentsent->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderpaymentsent->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderpaymentsent->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderpaymentsent) && $emailproviderpaymentsent->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderpaymentsent) && $emailproviderpaymentsent->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderpaymentsent->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{--Review Received --}}
                            <div class="tab-pane" id="providerreviewreceived" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-providerreviewreceived') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        Provider review received?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="provider-reviewreceived-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailproviderreviewreceived->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailProviderReviewReceived({{ $emailproviderreviewreceived->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="provider-reviewreceived-checkbox"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Js Code -->
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-4">
                                                    <h3 id="providerreviewreceived-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="providerreviewreceived-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="providerreviewreceived-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="providerreviewreceived-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <!-- Username -->
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Reviewer Name:</strong> JohnDoe123
                                                                    </div>

                                                                    <!-- Review Text -->
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Review:</strong> The handyman did an excellent job and was very professional.
                                                                    </div>

                                                                    <!-- Review Stars -->
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Rating:</strong>
                                                                        <span style="color: #f5c518;">
                                                                            ★★★★☆
                                                                        </span>
                                                                        (4/5 stars)
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="providerreviewreceived-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerreviewreceived-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerreviewreceived-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerreviewreceived-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="providerreviewreceived-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="providerreviewreceived-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="providerreviewreceived-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="providerreviewreceived-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="providerreviewreceived-facebooklink"
                                                            class="mx-1"><img src="images/socialmedialogo/facebook.png"
                                                                width="16" alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="providerreviewreceived-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-providerreviewreceived') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailproviderreviewreceived) && $emailproviderreviewreceived->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailproviderreviewreceived->logo) }}"
                                                                alt="Logo" style="max-width: 116px; height: 100px;">
                                                        </div>
                                                    @endif
                                                    <span class="error">{{ $errors->first('logo') }}</span>

                                                    <h6 class="mt-4">Header Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title"
                                                                value="{{ old('title', $emailproviderreviewreceived->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailproviderreviewreceived->body ?? '') }}</textarea>
                                                            <span class="error">{{ $errors->first('body') }}</span>
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4">Footer Content</h6>

                                                    <div class="bg-light p-3 rounded">
                                                        <div class="form-group">
                                                            <label for="section_text">Section Text</label>
                                                            <input type="text" name="section_text"
                                                                class="form-control" id="section_text"
                                                                placeholder="Ex: Please contact us for any queries."
                                                                value="{{ old('section_text', $emailproviderreviewreceived->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderreviewreceived) && $emailproviderreviewreceived->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label>Social Media Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                                @foreach (['twitter' => 'Twitter', 'linkedIn' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox" name="{{ $name }}"
                                                                            data-from="social-media"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailproviderreviewreceived) && $emailproviderreviewreceived->$name ? 'checked' : '' }}>
                                                                        <label class="mb-0 text-dark"
                                                                            for="{{ $name }}">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="form-group" style="padding-top: 15px;">
                                                            <label for="copyright_content">Copyright Content</label>
                                                            <input type="text" class="form-control"
                                                                id="copyright_content" name="copyright_content"
                                                                placeholder="Ex: 2024 sitreg. All rights reserved."
                                                                value="{{ old('copyright_content', $emailproviderreviewreceived->copyright_content ?? '') }}">

                                                            <span
                                                                class="error">{{ $errors->first('copyright_content') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Retrieve the active tab from localStorage
                const activeTab = localStorage.getItem('activeTabProvider');

                if (activeTab) {
                    // Activate the saved tab
                    const tabLink = document.querySelector(`a[href="${activeTab}"]`);
                    const tabPane = document.querySelector(activeTab);

                    if (tabLink && tabPane) {
                        tabLink.classList.add('active');
                        tabPane.classList.add('active', 'show');
                    }
                } else {
                    // Activate the default tab: #providerotpverify
                    const defaultTabLink = document.querySelector('.nav-link[href="#providerotpverify"]');
                    const defaultTabPane = document.querySelector('#providerotpverify');

                    if (defaultTabLink && defaultTabPane) {
                        defaultTabLink.classList.add('active');
                        defaultTabPane.classList.add('active', 'show');
                    }
                }

                // Add click event to all tabs
                document.querySelectorAll('.nav-link').forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Save the clicked tab's ID to localStorage
                        localStorage.setItem('activeTabProvider', this.getAttribute('href'));

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
