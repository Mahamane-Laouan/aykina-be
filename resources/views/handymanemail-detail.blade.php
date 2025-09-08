@extends('layouts.master')

@section('title')
    Handyman Email
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

    <script src="{{ asset('build/js/handymanemail-detail.js') }}"></script>
    <script src="{{ asset('build/js/handymanemail-statuschange.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @section('content')
        {{-- Email Headline --}}
        <div class="row align-items-center">
            <div class="col-md-3" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Handyman Email <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Email / Handyman Email</p>
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
                                <a class="nav-link" data-bs-toggle="tab" href="#handymanotpverify" role="tab">
                                    <span class="d-none d-sm-block">Otp Verify</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#handymanforgotpassword" role="tab">
                                    <span class="d-none d-sm-block">Forgot Password</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#handymanassignfororder" role="tab">
                                    <span class="d-none d-sm-block">Assign for Order</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#handymanacceptbooking" role="tab">
                                    <span class="d-none d-sm-block">Payment Request Accepted</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#handymanrejectbooking" role="tab">
                                    <span class="d-none d-sm-block">Payment Request Cancelled</span>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#handymancompletedbooking" role="tab">
                                    <span class="d-none d-sm-block">Booking Completed</span>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#handymanreviewreceived" role="tab">
                                    <span class="d-none d-sm-block">Review Received</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">

                            {{-- Otp Verify --}}
                            <div class="tab-pane" id="handymanotpverify" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-handymanotpverify') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        handyman otp verify?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="handyman-otpverify-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailhandymanotpverify->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailHandymanOtpVerify({{ $emailhandymanotpverify->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="handyman-otpverify-checkbox"></label>
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
                                                    <h3 id="handymanotpverify-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {HandymanName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="handymanotpverify-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="handymanotpverify-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h5 id="handymanotpverify-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h5>
                                                                    <h3
                                                                        style="text-align: center; margin-bottom: 20px; font-size: 28px;">
                                                                        523621</h3>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="handymanotpverify-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanotpverify-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanotpverify-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanotpverify-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanotpverify-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="handymanotpverify-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="handymanotpverify-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="handymanotpverify-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="handymanotpverify-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3" id="handymanotpverify-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-handymanotpverify') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailhandymanotpverify) && $emailhandymanotpverify->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailhandymanotpverify->logo) }}"
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
                                                                value="{{ old('title', $emailhandymanotpverify->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailhandymanotpverify->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailhandymanotpverify->section_text ?? '') }}">
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
                                                                            {{ isset($emailhandymanotpverify) && $emailhandymanotpverify->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailhandymanotpverify) && $emailhandymanotpverify->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailhandymanotpverify->copyright_content ?? '') }}">

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
                            <div class="tab-pane" id="handymanforgotpassword" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-handymanforgotpassword') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        handyman forgot password?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="handyman-forgotpassword-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailhandymanforgotpassword->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailHandymanForgotPassword({{ $emailhandymanforgotpassword->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="handyman-forgotpassword-checkbox"></label>
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
                                                    <h3 id="handymanforgotpassword-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {HandymanName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="handymanforgotpassword-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="handymanforgotpassword-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h5 id="handymanforgotpassword-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h5>
                                                                    <h3
                                                                        style="text-align: center; margin-bottom: 20px; font-size: 28px;">
                                                                        523621</h3>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                </div>
                                                            </div>
                                                            <p style="margin-top: 20px; color: #555;"
                                                                id="handymanforgotpassword-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanforgotpassword-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanforgotpassword-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanforgotpassword-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanforgotpassword-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="handymanforgotpassword-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="handymanforgotpassword-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="handymanforgotpassword-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="handymanforgotpassword-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="handymanforgotpassword-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-handymanforgotpassword') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailhandymanforgotpassword) && $emailhandymanforgotpassword->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailhandymanforgotpassword->logo) }}"
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
                                                                value="{{ old('title', $emailhandymanforgotpassword->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailhandymanforgotpassword->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailhandymanforgotpassword->section_text ?? '') }}">
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
                                                                            {{ isset($emailhandymanforgotpassword) && $emailhandymanforgotpassword->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailhandymanforgotpassword) && $emailhandymanforgotpassword->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailhandymanforgotpassword->copyright_content ?? '') }}">

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


                            {{-- Assign for Order --}}
                            <div class="tab-pane" id="handymanassignfororder" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-handymanassignfororder') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        handyman assign for order?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="handyman-assignorder-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailhandymanassignfororder->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailHandymanAssignForOrder({{ $emailhandymanassignfororder->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="handyman-assignorder-checkbox"></label>
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
                                                    <h3 id="handymanassignfororder-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {HandymanName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="handymanassignfororder-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="handymanassignfororder-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="handymanassignfororder-body"
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
                                                                id="handymanassignfororder-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>
                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanassignfororder-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanassignfororder-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanassignfororder-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanassignfororder-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="handymanassignfororder-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="handymanassignfororder-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="handymanassignfororder-instagramlink"
                                                            class="mx-1"><img src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="handymanassignfororder-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="handymanassignfororder-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-handymanassignfororder') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailhandymanassignfororder) && $emailhandymanassignfororder->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailhandymanassignfororder->logo) }}"
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
                                                                value="{{ old('title', $emailhandymanassignfororder->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailhandymanassignfororder->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailhandymanassignfororder->section_text ?? '') }}">
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
                                                                            {{ isset($emailhandymanassignfororder) && $emailhandymanassignfororder->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailhandymanassignfororder) && $emailhandymanassignfororder->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailhandymanassignfororder->copyright_content ?? '') }}">

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
                            <div class="tab-pane" id="handymanacceptbooking" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-handymanacceptbooking') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        handyman Payment Request Accepted? 
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="handyman-acceptbooking-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailhandymanacceptbooking->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailHandymanAcceptBooking({{ $emailhandymanacceptbooking->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="handyman-acceptbooking-checkbox"></label>
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
                                                    <h3 id="handymanacceptbooking-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {HandymanName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="handymanacceptbooking-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="handymanacceptbooking-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="handymanacceptbooking-body"
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
                                                                id="handymanacceptbooking-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>
                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanacceptbooking-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanacceptbooking-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanacceptbooking-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanacceptbooking-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="handymanacceptbooking-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="handymanacceptbooking-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="handymanacceptbooking-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="handymanacceptbooking-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="handymanacceptbooking-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-handymanacceptbooking') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailhandymanacceptbooking) && $emailhandymanacceptbooking->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailhandymanacceptbooking->logo) }}"
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
                                                                value="{{ old('title', $emailhandymanacceptbooking->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailhandymanacceptbooking->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailhandymanacceptbooking->section_text ?? '') }}">
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
                                                                            {{ isset($emailhandymanacceptbooking) && $emailhandymanacceptbooking->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailhandymanacceptbooking) && $emailhandymanacceptbooking->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailhandymanacceptbooking->copyright_content ?? '') }}">

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
                            <div class="tab-pane" id="handymanrejectbooking" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-handymanrejectbooking') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        handyman Payment request cancelled?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="handyman-rejectbooking-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailhandymanrejectbooking->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailHandymanRejectBooking({{ $emailhandymanrejectbooking->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="handyman-rejectbooking-checkbox"></label>
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
                                                    <h3 id="handymanrejectbooking-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {HandymanName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="handymanrejectbooking-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="handymanrejectbooking-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="handymanrejectbooking-body"
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
                                                                id="handymanrejectbooking-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>
                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanrejectbooking-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanrejectbooking-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanrejectbooking-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanrejectbooking-contactus">Contact Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="handymanrejectbooking-twitterlink" class="mx-1"><img
                                                                src="images/socialmedialogo/twitter.png" width="16"
                                                                alt="Twitter"></span>
                                                        <span id="handymanrejectbooking-linkdlnlink" class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="handymanrejectbooking-instagramlink" class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png" width="16"
                                                                alt="Instagram"></span>
                                                        <span id="handymanrejectbooking-facebooklink" class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="handymanrejectbooking-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-handymanrejectbooking') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailhandymanrejectbooking) && $emailhandymanrejectbooking->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailhandymanrejectbooking->logo) }}"
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
                                                                value="{{ old('title', $emailhandymanrejectbooking->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailhandymanrejectbooking->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailhandymanrejectbooking->section_text ?? '') }}">
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
                                                                            {{ isset($emailhandymanrejectbooking) && $emailhandymanrejectbooking->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailhandymanrejectbooking) && $emailhandymanrejectbooking->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailhandymanrejectbooking->copyright_content ?? '') }}">

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


                            {{-- Booking Completed --}}
                            <div class="tab-pane" id="handymancompletedbooking" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-handymancompletedbooking') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email on
                                                        handyman Booking Completed?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch" style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="handyman-completebooking-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailhandymancompledtedbooking->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailHandymanCompletedBooking({{ $emailhandymancompledtedbooking->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="handyman-completebooking-checkbox"></label>
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
                                                    <h3 id="handymancompletedbooking-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {HandymanName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="handymancompletedbooking-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="handymancompletedbooking-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="handymancompletedbooking-body"
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
                                                                id="handymancompletedbooking-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>
                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymancompletedbooking-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymancompletedbooking-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymancompletedbooking-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymancompletedbooking-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="handymancompletedbooking-twitterlink"
                                                            class="mx-1"><img src="images/socialmedialogo/twitter.png"
                                                                width="16" alt="Twitter"></span>
                                                        <span id="handymancompletedbooking-linkdlnlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="handymancompletedbooking-instagramlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="handymancompletedbooking-facebooklink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="handymancompletedbooking-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST"
                                                action="{{ route('email-handymancompletedbooking') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailhandymancompledtedbooking) && $emailhandymancompledtedbooking->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailhandymancompledtedbooking->logo) }}"
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
                                                                value="{{ old('title', $emailhandymancompledtedbooking->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailhandymancompledtedbooking->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailhandymancompledtedbooking->section_text ?? '') }}">
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
                                                                            {{ isset($emailhandymancompledtedbooking) && $emailhandymancompledtedbooking->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailhandymancompledtedbooking) && $emailhandymancompledtedbooking->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailhandymancompledtedbooking->copyright_content ?? '') }}">

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


                            {{-- Review Received --}}
                            <div class="tab-pane" id="handymanreviewreceived" role="tabpanel">

                                <div class="row">

                                    {{-- Title Text --}}
                                    <div class="card mb-3" style="max-width: 1470px; margin: auto;">
                                        <div class="card-body" style="padding: 15px;">
                                            <form action="{{ route('email-handymanreviewreceived') }}" method="post"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="border rounded border-color-c1 px-3 py-2 d-flex justify-content-between mb-1"
                                                    style="align-items: center;">
                                                    <h6 class="mb-0 text-capitalize" style="font-size: 14px;">Get email
                                                        on
                                                        handyman review received?
                                                    </h6>
                                                    <div class="position-relative">
                                                        <div class="form-check form-switch"
                                                            style="padding-left: 43rem;">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="handyman-reviewreceived-checkbox"
                                                                style="width: 2rem; height: 1.2rem;"
                                                                {{ $emailhandymanreviewreceived->get_email ? 'checked' : '' }}
                                                                onchange="changeEmailHandymanReviewReceived({{ $emailhandymanreviewreceived->id }})">
                                                            <label class="form-check-label ms-2"
                                                                for="handyman-reviewreceived-checkbox"></label>
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
                                                    <h3 id="handymanreviewreceived-title" class="mb-4"
                                                        style="font-size: 1.2rem;">
                                                    </h3>

                                                    <div class="mb-4">
                                                        <p><b>Hi {ProviderName},</b></p>
                                                    </div>

                                                    <div style="background-color: #4C7FDB; padding: 1rem; ">
                                                        <div class="text-center mb-4">
                                                            <img id="handymanreviewreceived-logo" width="100"
                                                                class="mb-3 rounded-circle" alt="Logo"
                                                                style="background-color: white; padding: 10px;">
                                                        </div>

                                                        <h4 class="text-center mb-3" style="color: #ffff;"
                                                            id="handymanreviewreceived-title2">
                                                        </h4>

                                                        <div
                                                            style="background-color: #f8f9fa; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                            <div
                                                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <div
                                                                    style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                                    <h6 id="handymanreviewreceived-body"
                                                                        style="margin-bottom: 15px; color: #333;"></h6>
                                                                    <hr
                                                                        style="border-top: 1px solid #ddd; margin-bottom: 20px;">
                                                                    <!-- Username -->
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Reviewer Name:</strong> JohnDoe123
                                                                    </div>

                                                                    <!-- Review Text -->
                                                                    <div style="margin-bottom: 10px; color: #555;">
                                                                        <strong>Review:</strong> The handyman did an
                                                                        excellent job and was very professional.
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
                                                                id="handymanreviewreceived-sectionuscontact"></p>
                                                            <p style="margin-top: 20px; color: #555;">Thanks &
                                                                Regards,<br><strong>{{ $generalSettings }}</strong></p>
                                                        </div>

                                                    </div>


                                                    <div id="policy-links" class="d-flex justify-content-center mt-4">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanreviewreceived-privacypolicy">Privacy
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanreviewreceived-refundpolicy">Refund
                                                                    Policy</span>
                                                            </li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanreviewreceived-cancellationpolicy">Cancellation
                                                                    Policy</span></li>
                                                            <li class="list-inline-item"><span class="text-dark"
                                                                    id="handymanreviewreceived-contactus">Contact
                                                                    Us</span>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div id="social-media-links" class="text-center mt-3">
                                                        <span id="handymanreviewreceived-twitterlink"
                                                            class="mx-1"><img src="images/socialmedialogo/twitter.png"
                                                                width="16" alt="Twitter"></span>
                                                        <span id="handymanreviewreceived-linkdlnlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/linkedin.png" width="16"
                                                                alt="LinkedIn"></span>
                                                        <span id="handymanreviewreceived-instagramlink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/instagram.png"
                                                                width="16" alt="Instagram"></span>
                                                        <span id="handymanreviewreceived-facebooklink"
                                                            class="mx-1"><img
                                                                src="images/socialmedialogo/facebook.png" width="16"
                                                                alt="Facebook"></span>
                                                    </div>

                                                    <p class="text-center mt-3"
                                                        id="handymanreviewreceived-copyrightcontent">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Controller Code --> --}}
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <form method="POST" action="{{ route('email-handymanreviewreceived') }}"
                                                id="email-template-status-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <h6 class="card-title">Logo</h6>
                                                    <input type="file" name="logo" class="form-control mt-3"
                                                        id="logo" accept="image/*">
                                                    @if (isset($emailhandymanreviewreceived) && $emailhandymanreviewreceived->logo)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/socialmedialogo/' . $emailhandymanreviewreceived->logo) }}"
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
                                                                value="{{ old('title', $emailhandymanreviewreceived->title ?? '') }}">
                                                            <span class="error">{{ $errors->first('title') }}</span>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="body">Mail Body</label>
                                                            <textarea class="form-control" id="body" name="body" rows="5"
                                                                placeholder="Enter your email body text here.">{{ old('body', $emailhandymanreviewreceived->body ?? '') }}</textarea>
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
                                                                value="{{ old('section_text', $emailhandymanreviewreceived->section_text ?? '') }}">
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
                                                                            {{ isset($emailhandymanreviewreceived) && $emailhandymanreviewreceived->$name ? 'checked' : '' }}>
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
                                                                            {{ isset($emailhandymanreviewreceived) && $emailhandymanreviewreceived->$name ? 'checked' : '' }}>
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
                                                                value="{{ old('copyright_content', $emailhandymanreviewreceived->copyright_content ?? '') }}">

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
                const activeTab = localStorage.getItem('activeTabHandyman');

                if (activeTab) {
                    // Activate the saved tab
                    const tabLink = document.querySelector(`a[href="${activeTab}"]`);
                    const tabPane = document.querySelector(activeTab);

                    if (tabLink && tabPane) {
                        tabLink.classList.add('active');
                        tabPane.classList.add('active', 'show');
                    }
                } else {
                    // Activate the default tab: #handymanotpverify
                    const defaultTabLink = document.querySelector('.nav-link[href="#handymanotpverify"]');
                    const defaultTabPane = document.querySelector('#handymanotpverify');

                    if (defaultTabLink && defaultTabPane) {
                        defaultTabLink.classList.add('active');
                        defaultTabPane.classList.add('active', 'show');
                    }
                }

                // Add click event to all tabs
                document.querySelectorAll('.nav-link').forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Save the clicked tab's ID to localStorage
                        localStorage.setItem('activeTabHandyman', this.getAttribute('href'));

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
