@extends('layouts.master')

@section('title')
    User Email
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

    <script src="{{ asset('build/js/useremail-detail.js') }}"></script>
    <script src="{{ asset('build/js/useremail-statuschange.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @section('content')
        {{-- Email Headline --}}
        <div class="row align-items-center">
            <div class="col-md-3" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">User Email <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Email / User Email</p>
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

                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userorderplacedservice" role="tab">
                                    <span class="d-none d-sm-block">Order Placed</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userotpverify" role="tab">
                                    <span class="d-none d-sm-block">Otp Verify</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userbookinghold" role="tab">
                                    <span class="d-none d-sm-block">Booking Hold</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userforgotpassword" role="tab">
                                    <span class="d-none d-sm-block">Forgot Password</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userbookingaccepted" role="tab">
                                    <span class="d-none d-sm-block">Booking Accepted</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userbookinginprogress" role="tab">
                                    <span class="d-none d-sm-block">Booking In Progress</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userbookingcancelled" role="tab">
                                    <span class="d-none d-sm-block">Booking Cancelled</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userbookingrejected" role="tab">
                                    <span class="d-none d-sm-block">Booking Completed</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userproductinprogress" role="tab">
                                    <span class="d-none d-sm-block">Product in Progress</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userproductdelivered" role="tab">
                                    <span class="d-none d-sm-block">Product Delivered</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#usercancelledbyprovider" role="tab">
                                    <span class="d-none d-sm-block">User Cancelled</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#userrefundbyprovider" role="tab">
                                    <span class="d-none d-sm-block">User Refund</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">

                            {{-- Otp Verify --}}
                            <div class="tab-pane" id="userotpverify" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userotpverify') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        User otp verify?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-otpverify-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserotpverify->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserOtpVerify({{ $emailuserotpverify->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-otpverify-checkbox"></label>
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
                                                    <h3 id="userotpverify-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userotpverify-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userotpverify-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h5 id="userotpverify-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h5>
                                                                    <h3
                                                                        style="text-align: center; margin-bottom: 20px; font-size: 28px;">
                                                                        3123123</h3>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="userotpverify-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userotpverify-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userotpverify-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userotpverify-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userotpverify-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userotpverify-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userotpverify-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userotpverify-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="userotpverify-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3" id="userotpverify-copyrightcontent"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userotpverify') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserotpverify) && $emailuserotpverify->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserotpverify->logo) }}"
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
                                                                value="{{ old('title', $emailuserotpverify->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserotpverify->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserotpverify->section_text ?? '') }}">
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
                                                                            {{ isset($emailuserotpverify) && $emailuserotpverify->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserotpverify) && $emailuserotpverify->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserotpverify->copyright_content ?? '') }}">

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
                            <div class="tab-pane" id="userforgotpassword" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userforgotpassword') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        User forgot password?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-forgotpassword-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserforgotpassword->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserForgotPassword({{ $emailuserforgotpassword->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-forgotpassword-checkbox"></label>
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
                                                    <h3 id="userforgotpassword-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userforgotpassword-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userforgotpassword-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h5 id="userforgotpassword-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h5>
                                                                    <h3
                                                                        style="text-align: center; margin-bottom: 20px; font-size: 28px;">
                                                                        545445</h3>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="userforgotpassword-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userforgotpassword-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userforgotpassword-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userforgotpassword-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userforgotpassword-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userforgotpassword-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userforgotpassword-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userforgotpassword-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="userforgotpassword-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3" id="userforgotpassword-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userforgotpassword') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserforgotpassword) && $emailuserforgotpassword->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserforgotpassword->logo) }}"
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
                                                                value="{{ old('title', $emailuserforgotpassword->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserforgotpassword->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserforgotpassword->section_text ?? '') }}">
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
                                                                            {{ isset($emailuserforgotpassword) && $emailuserforgotpassword->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserforgotpassword) && $emailuserforgotpassword->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserforgotpassword->copyright_content ?? '') }}">

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


                            {{-- Order Placed --}}
                            <div class="tab-pane" id="userorderplacedservice" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userorderplacedservice') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        User order placed service?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-orderplacedservice-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserorderplacedservice->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserOrderPlaced({{ $emailuserorderplacedservice->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-orderplacedservice-checkbox"></label>
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
                                                    <h3 id="userorderplacedservice-title" class="mb-4"
                                                        style="font-size: 1.2rem;"></h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                        <p id="userorderplacedservice-body"></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userorderplacedservice-logo" width="100"
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
                                                                id="userorderplacedservice-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userorderplacedservice-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userorderplacedservice-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userorderplacedservice-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userorderplacedservice-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userorderplacedservice-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userorderplacedservice-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userorderplacedservice-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="userorderplacedservice-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="userorderplacedservice-copyrightcontent"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userorderplacedservice') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserorderplacedservice) && $emailuserorderplacedservice->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserorderplacedservice->logo) }}"
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
                                                                value="{{ old('title', $emailuserorderplacedservice->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserorderplacedservice->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserorderplacedservice->section_text ?? '') }}">
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
                                                                            {{ isset($emailuserorderplacedservice) && $emailuserorderplacedservice->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserorderplacedservice) && $emailuserorderplacedservice->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserorderplacedservice->copyright_content ?? '') }}">

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
                            <div class="tab-pane" id="userbookingaccepted" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userbookingaccepted') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        User booking accepted?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-bookingaccepted-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserbookingaccepted->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserBookingAccepted({{ $emailuserbookingaccepted->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-bookingaccepted-checkbox"></label>
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
                                                    <h3 id="userbookingaccepted-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userbookingaccepted-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userbookingaccepted-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="userbookingaccepted-body"
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
                                                                id="userbookingaccepted-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingaccepted-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingaccepted-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingaccepted-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingaccepted-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userbookingaccepted-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userbookingaccepted-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userbookingaccepted-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="userbookingaccepted-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3" id="userbookingaccepted-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userbookingaccepted') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserbookingaccepted) && $emailuserbookingaccepted->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserbookingaccepted->logo) }}"
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
                                                                value="{{ old('title', $emailuserbookingaccepted->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserbookingaccepted->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserbookingaccepted->section_text ?? '') }}">
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
                                                                            {{ isset($emailuserbookingaccepted) && $emailuserbookingaccepted->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserbookingaccepted) && $emailuserbookingaccepted->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserbookingaccepted->copyright_content ?? '') }}">

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


                            {{-- Booking In Progress --}}
                            <div class="tab-pane" id="userbookinginprogress" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userbookinginprogress') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        User booking in progress?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-bookinginprogress-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserbookinginprogress->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserBookingInProgress({{ $emailuserbookinginprogress->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-bookinginprogress-checkbox"></label>
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
                                                    <h3 id="userbookinginprogress-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userbookinginprogress-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userbookinginprogress-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="userbookinginprogress-body"
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
                                                                id="userbookinginprogress-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookinginprogress-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookinginprogress-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookinginprogress-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookinginprogress-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userbookinginprogress-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userbookinginprogress-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userbookinginprogress-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="userbookinginprogress-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="userbookinginprogress-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userbookinginprogress') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserbookinginprogress) && $emailuserbookinginprogress->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserbookinginprogress->logo) }}"
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
                                                                value="{{ old('title', $emailuserbookinginprogress->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserbookinginprogress->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserbookinginprogress->section_text ?? '') }}">
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
                                                                            {{ isset($emailuserbookinginprogress) && $emailuserbookinginprogress->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserbookinginprogress) && $emailuserbookinginprogress->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserbookinginprogress->copyright_content ?? '') }}">

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


                            {{-- Booking Hold --}}
                            <div class="tab-pane" id="userbookinghold" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userbookinghold') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email
                                                        on
                                                        User booking hold?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch"
                                                            style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-bookinghold-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserbookinghold->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserBookingHold({{ $emailuserbookinghold->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-bookinghold-checkbox"></label>
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
                                                    <h3 id="userbookinghold-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userbookinghold-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userbookinghold-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="userbookinghold-body"
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
                                                                id="userbookinghold-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookinghold-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookinghold-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookinghold-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookinghold-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userbookinghold-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userbookinghold-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userbookinghold-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="userbookinghold-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3" id="userbookinghold-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userbookinghold') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserbookinghold) && $emailuserbookinghold->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserbookinghold->logo) }}"
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
                                                                value="{{ old('title', $emailuserbookinghold->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserbookinghold->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserbookinghold->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailuserbookinghold) && $emailuserbookinghold->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserbookinghold) && $emailuserbookinghold->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserbookinghold->copyright_content ?? '') }}">

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



                            {{-- Booking Cancelled --}}
                            <div class="tab-pane" id="userbookingcancelled" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userbookingcancelled') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email
                                                        on
                                                        User booking cancelled?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch"
                                                            style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-bookingcancelled-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserbookingcancelled->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserBookingCancelled({{ $emailuserbookingcancelled->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-bookingcancelled-checkbox"></label>
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
                                                    <h3 id="userbookingcancelled-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userbookingcancelled-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userbookingcancelled-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="userbookingcancelled-body"
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
                                                                id="userbookingcancelled-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingcancelled-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingcancelled-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingcancelled-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingcancelled-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userbookingcancelled-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userbookingcancelled-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userbookingcancelled-instagramlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="userbookingcancelled-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="userbookingcancelled-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userbookingcancelled') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserbookingcancelled) && $emailuserbookingcancelled->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserbookingcancelled->logo) }}"
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
                                                                value="{{ old('title', $emailuserbookingcancelled->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserbookingcancelled->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserbookingcancelled->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailuserbookingcancelled) && $emailuserbookingcancelled->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserbookingcancelled) && $emailuserbookingcancelled->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserbookingcancelled->copyright_content ?? '') }}">

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
                            <div class="tab-pane" id="userbookingrejected" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userbookingrejected') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email
                                                        on
                                                        User booking completed?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch"
                                                            style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-bookingrejected-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserbookingrejected->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserBookingRejected({{ $emailuserbookingrejected->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-bookingrejected-checkbox"></label>
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
                                                    <h3 id="userbookingrejected-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userbookingrejected-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userbookingrejected-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="userbookingrejected-body"
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
                                                                id="userbookingrejected-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingrejected-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingrejected-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingrejected-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userbookingrejected-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userbookingrejected-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userbookingrejected-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userbookingrejected-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="userbookingrejected-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="userbookingrejected-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userbookingrejected') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserbookingrejected) && $emailuserbookingrejected->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserbookingrejected->logo) }}"
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
                                                                value="{{ old('title', $emailuserbookingrejected->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserbookingrejected->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserbookingrejected->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailuserbookingrejected) && $emailuserbookingrejected->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserbookingrejected) && $emailuserbookingrejected->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserbookingrejected->copyright_content ?? '') }}">

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


                            {{-- Product in Progress --}}
                            <div class="tab-pane" id="userproductinprogress" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userproductinprogress') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email
                                                        on
                                                        User product in progress?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch"
                                                            style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-productinprogress-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserproductinprogress->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserProductInProgress({{ $emailuserproductinprogress->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-productinprogress-checkbox"></label>
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
                                                    <h3 id="userproductinprogress-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userproductinprogress-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userproductinprogress-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="userproductinprogress-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style=" margin-bottom: 10px;color: #555;">
                                                                        <strong>Product Name:</strong> Silver Color Box
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>

                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="userproductinprogress-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userproductinprogress-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userproductinprogress-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userproductinprogress-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userproductinprogress-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userproductinprogress-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userproductinprogress-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userproductinprogress-instagramlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="userproductinprogress-facebooklink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="userproductinprogress-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userproductinprogress') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserproductinprogress) && $emailuserproductinprogress->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserproductinprogress->logo) }}"
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
                                                                value="{{ old('title', $emailuserproductinprogress->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserproductinprogress->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserproductinprogress->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailuserproductinprogress) && $emailuserproductinprogress->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserproductinprogress) && $emailuserproductinprogress->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserproductinprogress->copyright_content ?? '') }}">

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


                            {{-- Product Delivered --}}
                            <div class="tab-pane" id="userproductdelivered" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userproductdelivered') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email
                                                        on
                                                        User product delivered?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch"
                                                            style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-productdelivered-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailuserproductdelivered->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserProductDelivered({{ $emailuserproductdelivered->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-productdelivered-checkbox"></label>
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
                                                    <h3 id="userproductdelivered-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userproductdelivered-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userproductdelivered-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="userproductdelivered-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Booking:</strong> #432121
                                                                    </div>
                                                                    <div style=" margin-bottom: 10px;color: #555;">
                                                                        <strong>Product Name:</strong> Silver Color Box
                                                                    </div>
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>

                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="userproductdelivered-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userproductdelivered-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userproductdelivered-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userproductdelivered-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userproductdelivered-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userproductdelivered-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userproductdelivered-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userproductdelivered-instagramlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="userproductdelivered-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="userproductdelivered-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userproductdelivered') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailuserproductdelivered) && $emailuserproductdelivered->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailuserproductdelivered->logo) }}"
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
                                                                value="{{ old('title', $emailuserproductdelivered->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailuserproductdelivered->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailuserproductdelivered->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($emailuserproductdelivered) && $emailuserproductdelivered->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailuserproductdelivered) && $emailuserproductdelivered->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailuserproductdelivered->copyright_content ?? '') }}">

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


                             {{-- User Cancelled --}}
                            <div class="tab-pane" id="usercancelledbyprovider" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-usercancelledbyprovider') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email
                                                        on
                                                        User cancelled by provider?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch"
                                                            style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-cancelledbyprovider-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $usercancelledbyprovider->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserCancelledbyProviderStatus({{ $usercancelledbyprovider->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-cancelledbyprovider-checkbox"></label>
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
                                                    <h3 id="usercancelledbyprovider-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="usercancelledbyprovider-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="usercancelledbyprovider-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="usercancelledbyprovider-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>

                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="usercancelledbyprovider-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="usercancelledbyprovider-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="usercancelledbyprovider-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="usercancelledbyprovider-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="usercancelledbyprovider-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="usercancelledbyprovider-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="usercancelledbyprovider-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="usercancelledbyprovider-instagramlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="usercancelledbyprovider-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="usercancelledbyprovider-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-usercancelledbyprovider') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($usercancelledbyprovider) && $usercancelledbyprovider->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $usercancelledbyprovider->logo) }}"
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
                                                                value="{{ old('title', $usercancelledbyprovider->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $usercancelledbyprovider->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $usercancelledbyprovider->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($usercancelledbyprovider) && $usercancelledbyprovider->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($usercancelledbyprovider) && $usercancelledbyprovider->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $usercancelledbyprovider->copyright_content ?? '') }}">

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






                             {{-- User Cancelled --}}
                            <div class="tab-pane" id="userrefundbyprovider" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-userrefundbyprovider') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email
                                                        on
                                                        User refund by provider?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch"
                                                            style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="user-refundbyprovider-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $userrefundbyprovider->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailUserRefundbyProviderStatus({{ $userrefundbyprovider->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="user-refundbyprovider-checkbox"></label>
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
                                                    <h3 id="userrefundbyprovider-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {UserName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="userrefundbyprovider-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="userrefundbyprovider-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="userrefundbyprovider-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <div style="color: #555;"><strong>Date:</strong> 31
                                                                        Aug, 2024 - 08:29 PM</div>

                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="userrefundbyprovider-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userrefundbyprovider-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userrefundbyprovider-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userrefundbyprovider-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="userrefundbyprovider-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="userrefundbyprovider-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="userrefundbyprovider-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="userrefundbyprovider-instagramlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="userrefundbyprovider-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="userrefundbyprovider-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-userrefundbyprovider') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($userrefundbyprovider) && $userrefundbyprovider->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $userrefundbyprovider->logo) }}"
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
                                                                value="{{ old('title', $userrefundbyprovider->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $userrefundbyprovider->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $userrefundbyprovider->section_text ?? '') }}">
                                                            <span
                                                                class="error">{{ $errors->first('section_text') }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label>Page Links</label>
                                                            <div class="d-flex flex-wrap align-items-center gap-3 pages">
                                                                @foreach (['privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'cancellation_policy' => 'Cancellation Policy', 'contact_us' => 'Contact Us'] as $name => $label)
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <input type="checkbox"
                                                                            name="{{ $name }}"
                                                                            data-from="pages"
                                                                            data-id="{{ $name }}"
                                                                            id="{{ $name }}"
                                                                            {{ isset($userrefundbyprovider) && $userrefundbyprovider->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($userrefundbyprovider) && $userrefundbyprovider->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $userrefundbyprovider->copyright_content ?? '') }}">

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
                const activeTab = localStorage.getItem('activetabUser');

                if (activeTab) {
                    // Activate the saved tab
                    const tabLink = document.querySelector(`a[href="${activeTab}"]`);
                    const tabPane = document.querySelector(activeTab);

                    if (tabLink && tabPane) {
                        tabLink.classList.add('active');
                        tabPane.classList.add('active', 'show');
                    }
                } else {
                    // Activate the default tab: #userorderplacedservice
                    const defaultTabLink = document.querySelector('.nav-link[href="#userorderplacedservice"]');
                    const defaultTabPane = document.querySelector('#userorderplacedservice');

                    if (defaultTabLink && defaultTabPane) {
                        defaultTabLink.classList.add('active');
                        defaultTabPane.classList.add('active', 'show');
                    }
                }

                // Add click event to all tabs
                document.querySelectorAll('.nav-link').forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Save the clicked tab's ID to localStorage
                        localStorage.setItem('activetabUser', this.getAttribute('href'));

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
