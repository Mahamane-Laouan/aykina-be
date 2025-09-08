@extends('layouts.master')

@section('title')
    Settings
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<!-- Include Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<style>
    .choices__list--dropdown .choices__item {
        color: #000 !important;
    }

    input[switch]+label:after {
        height: 17px !important;
        width: 17px !important;
    }

    input[switch]+label {
        width: 40px !important;
        height: 22px !important;
    }

    input[switch]:checked+label:after {
        left: 21px !important;
    }


    .choices__input {
        display: block !important;


    }

    .choices__inner {
        background-color: #edeff166 !important;
    }

    .nav-link.active {
        background-color: #0046AE;
        color: #fff;
    }

    a.home-setup-tab {
        margin: 0 0 10px;
        position: relative;
        width: 100%;
        text-align: left;
        padding: 12px 25px;
        display: flex;
        align-items: center;
        gap: 13px;
        text-transform: capitalize;
        background-color: #edeff166;
        border: 1px solid #edeff1;
        font-size: 16px;
        font-weight: 200 !important;
        transition: all 0.3s ease-in-out;
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

    .select2 {
        background-color: #edeff166 !important;
    }

    .got-color {
        background-color: #edeff166 !important;
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
                    <h5 class="card-title">Settings <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Settings Management / Settings</p>
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
                        <div class="row">

                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link home-setup-tab active" id="site-setup-tab" data-bs-toggle="pill"
                                        href="#site-setup-id" aria-selected="false" role="tab">
                                        <i class="bx bx-cog"></i> General Settings
                                    </a>

                                    <a class="nav-link home-setup-tab" id="mobile-url-tab" data-bs-toggle="pill"
                                        href="#mobile-url-id" aria-selected="false" role="tab">
                                        <i class="bx bx-mobile-alt"></i> Mobile App Url
                                    </a>

                                    <a class="nav-link home-setup-tab" id="social-media-tab" data-bs-toggle="pill"
                                        href="#social-media-id" aria-selected="false" role="tab">
                                        <i class="bx bx-share-alt"></i> Social Media
                                    </a>

                                    <a class="nav-link home-setup-tab" id="service-configurations-tab" data-bs-toggle="pill"
                                        href="#service-configurations-id" aria-selected="false" role="tab">
                                        <i class="bx bx-lock-alt"></i> Login Configurations
                                    </a>

                                    <a class="nav-link home-setup-tab" id="sms-configurations-tab" data-bs-toggle="pill"
                                        href="#sms-configurations-id" aria-selected="false" role="tab">
                                        <i class="bx bx-message-square-dots"></i> SMS Configurations
                                    </a>

                                    <a class="nav-link home-setup-tab" id="commissions-tab" data-bs-toggle="pill"
                                        href="#commissions-id" aria-selected="false" role="tab">
                                        <i class="bx bx-wallet"></i> Commissions
                                    </a>

                                    <a class="nav-link home-setup-tab" id="mailsetup-tab" data-bs-toggle="pill"
                                        href="#mailsetup-id" aria-selected="false" role="tab">
                                        <i class="bx bx-envelope"></i> Mail Setup
                                    </a>

                                    <a class="nav-link home-setup-tab" id="nearby-distance-tab" data-bs-toggle="pill"
                                        href="#nearby-distance-id" aria-selected="false" role="tab">
                                        <i class="bx bx-map"></i> Nearby Distance
                                    </a>


                                    <a class="nav-link home-setup-tab" id="purchase-code-tab" data-bs-toggle="pill"
                                        href="#purchase-code-id" aria-selected="false" role="tab">
                                        <i class="bx bx-key"></i> Purchase Code
                                    </a>

                                </div>
                            </div>


                            <div class="col-md-9">
                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                                    {{-- General Settings --}}
                                    <div class="tab-pane fade active show" id="site-setup-id" role="tabpanel"
                                        aria-labelledby="site-setup-tab">
                                        <form action="{{ url('sitesetup-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="d-flex gap-3">
                                                <!-- Logo Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="light_logo" class="form-label" style="color: #000;">
                                                        Logo</label>
                                                    <input class="form-control" type="file" id="light_logo"
                                                        name="light_logo" onchange="previewImage(event, 'logo_preview')">
                                                    <span id="image_error"
                                                        class="error text-danger">{{ $errors->first('light_logo') }}</span>
                                                    <img id="logo_preview"
                                                        src="{{ $sitesetup && $sitesetup->light_logo ? asset('images/logo/' . $sitesetup->light_logo) : '#' }}"
                                                        alt="Logo Preview"
                                                        style="{{ $sitesetup && $sitesetup->light_logo ? 'display: block;' : 'display: none;' }} max-height: 100px; margin-top: 10px;">
                                                </div>

                                                <!-- Footer Logo Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="dark_logo" class="form-label" style="color: #000;">Footer
                                                        Logo</label>
                                                    <input class="form-control" type="file" id="dark_logo"
                                                        name="dark_logo"
                                                        onchange="previewImage(event, 'dark_logo_preview')">
                                                    <span id="image_error"
                                                        class="error text-danger">{{ $errors->first('dark_logo') }}</span>
                                                    <img id="dark_logo_preview"
                                                        src="{{ $sitesetup && $sitesetup->dark_logo ? asset('images/logo/' . $sitesetup->dark_logo) : '#' }}"
                                                        alt="Footer Logo Preview"
                                                        style="{{ $sitesetup && $sitesetup->dark_logo ? 'display: block;' : 'display: none;' }} max-height: 100px; margin-top: 10px;">
                                                </div>
                                            </div>

                                            <div class="d-flex gap-3">
                                                <!-- Fav Icon Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="fav_icon" class="form-label" style="color: #000;">Fav
                                                        Icon</label>
                                                    <input class="form-control" type="file" id="fav_icon"
                                                        name="fav_icon"
                                                        onchange="previewImage(event, 'fav_icon_preview')">
                                                    <span id="image_error"
                                                        class="error text-danger">{{ $errors->first('fav_icon') }}</span>
                                                    <img id="fav_icon_preview"
                                                        src="{{ $sitesetup && $sitesetup->fav_icon ? asset('images/logo/' . $sitesetup->fav_icon) : '#' }}"
                                                        alt="Fav Icon Preview"
                                                        style="{{ $sitesetup && $sitesetup->fav_icon ? 'display: block;' : 'display: none;' }} max-height: 100px; margin-top: 10px;">
                                                </div>
                                            </div>


                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1" style="width: 22%; position: relative;">
                                                    <label for="name" class="form-label"
                                                        style="color: #000;">Name</label>
                                                    <input type="text" class="form-control" id="name"
                                                        placeholder="Enter Name" name="name"
                                                        value="{{ old('name', $sitesetup->name ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_1"
                                                        class="error text-danger">{{ $errors->first('name') }}</span>
                                                </div>

                                                <!-- Time Zone Dropdown -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="time_zone" class="form-label" style="color: #000;">Time
                                                        Zone</label>
                                                    <div class="position-relative">
                                                        <select class="form-select select2" id="time_zone"
                                                            name="time_zone" style="height: 48px;">
                                                            <option value="">Select Time Zone</option>
                                                            <option value="UTC"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'UTC' ? 'selected' : '' }}>
                                                                UTC</option>
                                                            <option value="America/New_York"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'America/New_York' ? 'selected' : '' }}>
                                                                America/New York (EST)</option>
                                                            <option value="America/Chicago"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'America/Chicago' ? 'selected' : '' }}>
                                                                America/Chicago (CST)</option>
                                                            <option value="America/Denver"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'America/Denver' ? 'selected' : '' }}>
                                                                America/Denver (MST)</option>
                                                            <option value="America/Los_Angeles"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'America/Los_Angeles' ? 'selected' : '' }}>
                                                                America/Los Angeles (PST)</option>
                                                            <option value="Europe/London"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Europe/London' ? 'selected' : '' }}>
                                                                Europe/London (GMT)</option>
                                                            <option value="Europe/Paris"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Europe/Paris' ? 'selected' : '' }}>
                                                                Europe/Paris (CET)</option>
                                                            <option value="Asia/Dubai"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Dubai' ? 'selected' : '' }}>
                                                                Asia/Dubai (GST)</option>

                                                            <!-- India Time Zones -->
                                                            <option value="Asia/Kolkata"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Kolkata' ? 'selected' : '' }}>
                                                                India Standard Time (IST) - Kolkata</option>
                                                            <option value="Asia/Colombo"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Colombo' ? 'selected' : '' }}>
                                                                Sri Lanka Standard Time - Colombo</option>

                                                            <option value="Asia/Shanghai"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Shanghai' ? 'selected' : '' }}>
                                                                Asia/Shanghai (CST)</option>
                                                            <option value="Asia/Tokyo"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Tokyo' ? 'selected' : '' }}>
                                                                Asia/Tokyo (JST)</option>
                                                            <option value="Australia/Sydney"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Australia/Sydney' ? 'selected' : '' }}>
                                                                Australia/Sydney (AEST)</option>

                                                            <!-- More Asian Time Zones -->
                                                            <option value="Asia/Bangkok"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Bangkok' ? 'selected' : '' }}>
                                                                Asia/Bangkok (ICT)</option>
                                                            <option value="Asia/Jakarta"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Jakarta' ? 'selected' : '' }}>
                                                                Asia/Jakarta (WIB)</option>
                                                            <option value="Asia/Seoul"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Seoul' ? 'selected' : '' }}>
                                                                Asia/Seoul (KST)</option>
                                                            <option value="Asia/Singapore"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Singapore' ? 'selected' : '' }}>
                                                                Asia/Singapore (SGT)</option>
                                                            <option value="Asia/Kuala_Lumpur"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Asia/Kuala_Lumpur' ? 'selected' : '' }}>
                                                                Asia/Kuala Lumpur (MYT)</option>

                                                            <!-- African Time Zones -->
                                                            <option value="Africa/Nairobi"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Africa/Nairobi' ? 'selected' : '' }}>
                                                                Africa/Nairobi (EAT)</option>
                                                            <option value="Africa/Lagos"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Africa/Lagos' ? 'selected' : '' }}>
                                                                Africa/Lagos (WAT)</option>

                                                            <!-- South America Time Zones -->
                                                            <option value="America/Sao_Paulo"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'America/Sao_Paulo' ? 'selected' : '' }}>
                                                                America/Sao Paulo (BRT)</option>
                                                            <option value="America/Argentina/Buenos_Aires"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'America/Argentina/Buenos_Aires' ? 'selected' : '' }}>
                                                                America/Buenos Aires (ART)</option>

                                                            <!-- Pacific Time Zones -->
                                                            <option value="Pacific/Auckland"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Pacific/Auckland' ? 'selected' : '' }}>
                                                                Pacific/Auckland (NZST)</option>
                                                            <option value="Pacific/Fiji"
                                                                {{ old('time_zone', $sitesetup->time_zone ?? '') == 'Pacific/Fiji' ? 'selected' : '' }}>
                                                                Pacific/Fiji (FJT)</option>
                                                        </select>
                                                    </div>
                                                    <span id="c_time_zone_error_2"
                                                        class="error text-danger">{{ $errors->first('time_zone') }}</span>
                                                </div>

                                            </div>


                                            <div class="d-flex gap-3">
                                                <!-- Platform Fees Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="platform_fees" class="form-label"
                                                        style="color: #000;">Platform Fees</label>
                                                    <div class="input-group">
                                                        <!-- Default Currency Display -->
                                                        <span class="input-group-text"
                                                            style="background: #D0D3D9; color: #000; font-size: 18px;">
                                                            {{ $sitesetup->default_currency ?? '$' }}
                                                        </span>
                                                        <input type="text" class="form-control" id="platform_fees"
                                                            placeholder="Enter Platform Fees" name="platform_fees"
                                                            value="{{ old('platform_fees', $sitesetup->platform_fees ?? '') }}"
                                                            aria-label="Platform Fees">
                                                    </div>
                                                    <span id="c_name_error_1"
                                                        class="error text-danger">{{ $errors->first('platform_fees') }}</span>
                                                </div>


                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="min_amountbook" class="form-label"
                                                        style="color: #000;">Min
                                                        Booking Amount</label>

                                                    <div class="input-group">
                                                        <!-- Default Currency Display -->
                                                        <span class="input-group-text"
                                                            style="background: #D0D3D9; color: #000; font-size: 18px;">
                                                            {{ $sitesetup->default_currency ?? '$' }}
                                                        </span>
                                                        <input type="text" class="form-control" id="min_amountbook"
                                                            placeholder="Enter Min Booking Amount" name="min_amountbook"
                                                            value="{{ old('min_amountbook', $sitesetup->min_amountbook ?? '') }}"
                                                            aria-label="Plan Name">
                                                    </div>
                                                    <span id="c_min_amountbook_error_2"
                                                        class="error text-danger">{{ $errors->first('min_amountbook') }}</span>
                                                </div>

                                            </div>

                                            <div class="d-flex gap-3">

                                                <!-- Currency Input -->
                                                <div class="mb-3" style="width: 49%; position: relative;">
                                                    <label style="color: #000;">Currency</label>
                                                    <div
                                                        style="display: flex; align-items: center; border: 1px solid #F1F2F4; border-radius: 5px; height: 47px; background: #f8f9fa; position: relative;">
                                                        <!-- Default Currency Display -->
                                                        <span id="currency-symbol"
                                                            style="height: 100%; padding-top: 9px !important; padding: 0.7rem; background: #D0D3D9; color: #000; padding: 5px 10px; border-radius: 5px; margin-right: 8px; font-size: 18px; min-width: 35px; text-align: center;">
                                                            {{ $sitesetup->default_currency ?? '$' }}
                                                        </span>

                                                        <!-- Selected Currency Name Display -->
                                                        <span id="currency-name" style="font-size: 16px; color: #000;">
                                                            {{ $sitesetup->default_currency_name ?? 'USD' }}
                                                        </span>

                                                        <!-- Dropdown Icon -->
                                                        <span
                                                            style="position: absolute; right: 10px; pointer-events: none;">
                                                            <i class="fas fa-chevron-down"></i> <!-- FontAwesome Icon -->
                                                        </span>

                                                        <!-- Currency Dropdown -->
                                                        <select class="form-select select2" id="currency-select"
                                                            style="border: none; background: transparent; width: 100%; outline: none; appearance: none; font-size: 16px; position: absolute; left: 0; opacity: 0;"
                                                            onchange="updateCurrencyFields()">
                                                            @foreach ($currencies as $currency)
                                                                <option value="{{ $currency->currency }}"
                                                                    data-symbol="{{ $currency->currency }}"
                                                                    data-name="{{ $currency->name }}"
                                                                    {{ old($sitesetup->default_currency_name ?? '') == $currency->currency ? 'selected' : '' }}>
                                                                    {{ $currency->currency }} {{ $currency->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>

                                                <!-- Hidden Inputs to Store Selected Currency -->
                                                <input type="hidden" name="default_currency" id="default_currency"
                                                    value="{{ $sitesetup->default_currency ?? '' }}">
                                                <input type="hidden" name="default_currency_name"
                                                    id="default_currency_name"
                                                    value="{{ $sitesetup->default_currency_name ?? '' }}">



                                                <!-- Second Category Input -->
                                                <div class="mb-3" style="width: 49%;">
                                                    <label for="copyright_text" class="form-label"
                                                        style="color: #000;">Copyright Text</label>
                                                    <input type="text" class="form-control" id="copyright_text"
                                                        placeholder="Enter Copyright Text" name="copyright_text"
                                                        value="{{ old('copyright_text', $sitesetup->copyright_text ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_2"
                                                        class="error text-danger">{{ $errors->first('copyright_text') }}</span>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-3">
                                                <!-- Color Settings -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="color_code" class="form-label" style="color: #000;">Color
                                                        Settings</label>
                                                    <input class="form-control" type="color" id="color_code"
                                                        name="color_code"
                                                        value="{{ $sitesetup ? $sitesetup->color_code : '' }}"
                                                        style="padding: 5px 16px;">
                                                    <span id="color_error"
                                                        class="error text-danger">{{ $errors->first('color_code') }}</span>
                                                </div>
                                            </div>


                                            <div style="padding-top: 12px;">
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>

                                        </form>
                                    </div>


                                    {{-- Mobile Url --}}
                                    <div class="tab-pane fade" id="mobile-url-id" role="tabpanel"
                                        aria-labelledby="mobile-url-tab">
                                        <form action="{{ url('mobileurl-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="d-flex gap-3">
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="android_url" class="form-label"
                                                        style="color: #000;">Android Play Store Url</label>
                                                    <input type="text" class="form-control" id="android_url"
                                                        placeholder="Enter Android Play Store Url" name="android_url"
                                                        value="{{ old('android_url', $mobileurl->android_url ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_1"
                                                        class="error text-danger">{{ $errors->first('android_url') }}</span>
                                                </div>

                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="android_provider_url	" class="form-label"
                                                        style="color: #000;">Android Play Store Provider Url</label>
                                                    <input type="text" class="form-control" id="android_provider_url	"
                                                        placeholder="Enter Android Play Store Provider Url"
                                                        name="android_provider_url"
                                                        value="{{ old('android_provider_url	', $mobileurl->android_provider_url ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_2"
                                                        class="error text-danger">{{ $errors->first('android_provider_url	') }}</span>
                                                </div>
                                            </div>


                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="ios_url" class="form-label" style="color: #000;">IOS
                                                        Play Store Url</label>
                                                    <input type="text" class="form-control" id="ios_url"
                                                        placeholder="Enter IOS Play Store Url" name="ios_url"
                                                        value="{{ old('ios_url', $mobileurl->ios_url ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_1"
                                                        class="error text-danger">{{ $errors->first('ios_url') }}</span>
                                                </div>

                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="ios_provider_url" class="form-label"
                                                        style="color: #000;">IOS Play Store Provider Url</label>
                                                    <input type="text" class="form-control" id="ios_provider_url"
                                                        placeholder="Enter IOS Play Store Provider Url"
                                                        name="ios_provider_url"
                                                        value="{{ old('ios_provider_url', $mobileurl->ios_provider_url ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_2"
                                                        class="error text-danger">{{ $errors->first('ios_provider_url') }}</span>
                                                </div>
                                            </div>


                                            <div style="padding-top: 12px;">
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>

                                        </form>
                                    </div>


                                    {{-- Social Media --}}
                                    <div class="tab-pane fade" id="social-media-id" role="tabpanel"
                                        aria-labelledby="social-media-tab">
                                        <form action="{{ url('socialmedia-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="facebook_link" class="form-label"
                                                        style="color: #000;">Facebook URL</label>
                                                    <input type="text" class="form-control" id="facebook_link"
                                                        placeholder="Enter Facebook URL" name="facebook_link"
                                                        value="{{ old('facebook_link', $socialmedia->facebook_link ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_facebook_link_error_1"
                                                        class="error text-danger">{{ $errors->first('facebook_link') }}</span>
                                                </div>

                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="instagram_link" class="form-label"
                                                        style="color: #000;">Instagram URL</label>
                                                    <input type="text" class="form-control" id="instagram_link"
                                                        placeholder="Enter Instagram URL" name="instagram_link"
                                                        value="{{ old('instagram_link', $socialmedia->instagram_link ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_instagram_link_error_2"
                                                        class="error text-danger">{{ $errors->first('instagram_link') }}</span>
                                                </div>
                                            </div>


                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="twitter_link" class="form-label"
                                                        style="color: #000;">Twitter URL</label>
                                                    <input type="text" class="form-control" id="twitter_link"
                                                        placeholder="Enter Twitter URL" name="twitter_link"
                                                        value="{{ old('twitter_link', $socialmedia->twitter_link ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_1"
                                                        class="error text-danger">{{ $errors->first('twitter_link') }}</span>
                                                </div>

                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="youtube_link" class="form-label"
                                                        style="color: #000;">Youtube URL</label>
                                                    <input type="text" class="form-control" id="youtube_link"
                                                        placeholder="Enter Youtube URL" name="youtube_link"
                                                        value="{{ old('youtube_link', $socialmedia->youtube_link ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_2"
                                                        class="error text-danger">{{ $errors->first('youtube_link') }}</span>
                                                </div>
                                            </div>




                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="linkdln_link" class="form-label"
                                                        style="color: #000;">Linkdln URL</label>
                                                    <input type="text" class="form-control" id="linkdln_link"
                                                        placeholder="Enter Linkdln URL" name="linkdln_link"
                                                        value="{{ old('linkdln_link', $socialmedia->linkdln_link ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_1"
                                                        class="error text-danger">{{ $errors->first('linkdln_link') }}</span>
                                                </div>

                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="whatsapp_link	" class="form-label"
                                                        style="color: #000;">Whatsapp URL</label>
                                                    <input type="text" class="form-control" id="whatsapp_link	"
                                                        placeholder="Enter Whatsapp URL" name="whatsapp_link"
                                                        value="{{ old('whatsapp_link	', $socialmedia->whatsapp_link ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_2"
                                                        class="error text-danger">{{ $errors->first('whatsapp_link	') }}</span>
                                                </div>
                                            </div>

                                            <div style="padding-top: 12px;">
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>

                                        </form>
                                    </div>


                                    {{-- Login Configurations --}}
                                    {{-- Login Configurations --}}
                                    <div class="tab-pane fade" id="service-configurations-id" role="tabpanel"
                                        aria-labelledby="service-configurations-tab">
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#userstatuswork" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                                                    <span class="d-none d-sm-block">User</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#handymanstatuswork" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-tools"></i></span>
                                                    <span class="d-none d-sm-block">Provider/Handyman</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            {{-- User Status Form --}}
                                            <div class="tab-pane fade show active" id="userstatuswork" role="tabpanel"
                                                style="padding-top: 35px;">
                                                <form action="{{ url('serverconfig-save/user') }}" method="POST">
                                                    @csrf
                                                    @foreach ($serverconfig as $config)
                                                        <div class="row mb-3 align-items-center border p-3 got-color">
                                                            <div class="col-md-6">
                                                                <label for="{{ $config->text }}_service"
                                                                    class="form-label" style="color: #000;">
                                                                    {{ ucfirst($config->text) }}
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check form-switch"
                                                                    style="transform: scale(1.5); margin-left: 31rem;">
                                                                    <input type="hidden" name="{{ $config->text }}"
                                                                        value="0">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="{{ $config->text }}Switch"
                                                                        name="{{ $config->text }}" value="1"
                                                                        style="width: 1.7rem; height: 0.8rem;"
                                                                        {{ $config->status ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="{{ $config->text }}Switch"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="mt-4">
                                                        <button type="submit"
                                                            class="btn btn-primary w-md">Submit</button>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- Handyman Status Form --}}
                                            <div class="tab-pane fade" id="handymanstatuswork" role="tabpanel"
                                                style="padding-top: 35px;">
                                                <form action="{{ url('serverconfig-save/handyman') }}" method="POST">
                                                    @csrf
                                                    @foreach ($serverconfig as $config)
                                                        <div class="row mb-3 align-items-center border p-3 got-color">
                                                            <div class="col-md-6">
                                                                <label for="{{ $config->text }}_handyman_service"
                                                                    class="form-label" style="color: #000;">
                                                                    {{ ucfirst($config->text) }}
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check form-switch"
                                                                    style="transform: scale(1.5); margin-left: 31rem;">
                                                                    <input type="hidden"
                                                                        name="{{ $config->text }}_handyman"
                                                                        value="0">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="{{ $config->text }}HandymanSwitch"
                                                                        name="{{ $config->text }}_handyman"
                                                                        value="1"
                                                                        style="width: 1.7rem; height: 0.8rem;"
                                                                        {{ $config->handyman_status ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="{{ $config->text }}HandymanSwitch"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="mt-4">
                                                        <button type="submit"
                                                            class="btn btn-primary w-md">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>



                                    {{-- SMS Configurations --}}
                                    <div class="tab-pane fade" id="sms-configurations-id" role="tabpanel"
                                        aria-labelledby="sms-configurations-tab">
                                        <form action="{{ url('smsconfig-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab"
                                                        data-bs-target="#twiliioswork" role="tab">
                                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                        <span class="d-none d-sm-block">Twillio</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#msg91wakes"
                                                        role="tab">
                                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                        <span class="d-none d-sm-block">MSG 91</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content mt-3">
                                                {{-- Twilio SMS Settings --}}
                                                <div class="tab-pane fade show active" id="twiliioswork" role="tabpanel">
                                                    <div class="sms-settings-section">

                                                        <div class="d-flex gap-3">
                                                            <div class="mb-3 flex-grow-1">
                                                                <label for="twilio_sid" class="form-label"
                                                                    style="color: #000;">Twilio Account SID</label>
                                                                <input type="text" class="form-control"
                                                                    id="twilio_sid" name="twilio_sid"
                                                                    placeholder="Enter Twilio Account SID"
                                                                    value="{{ old('twilio_sid', $smsConfig->twilio_sid ? '******' : '') }}"
                                                                    onfocus="this.value=''">
                                                                <span
                                                                    class="error text-danger">{{ $errors->first('twilio_sid') }}</span>
                                                            </div>
                                                            <div class="mb-3 flex-grow-1">
                                                                <label for="twilio_auth_token" class="form-label"
                                                                    style="color: #000;">Twilio Auth Token</label>
                                                                <input type="text" class="form-control"
                                                                    id="twilio_auth_token" name="twilio_auth_token"
                                                                    placeholder="Enter Twilio Auth Token"
                                                                    value="{{ old('twilio_auth_token', $smsConfig->twilio_auth_token ? '******' : '') }}"
                                                                    onfocus="this.value=''">
                                                                <span
                                                                    class="error text-danger">{{ $errors->first('twilio_auth_token') }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="twilio_phone_number" class="form-label"
                                                                style="color: #000;">Twilio Phone Number</label>
                                                            <input type="text" class="form-control"
                                                                id="twilio_phone_number" name="twilio_phone_number"
                                                                placeholder="Enter Twilio Phone Number"
                                                                value="{{ old('twilio_phone_number', $smsConfig->twilio_phone_number ? '******' : '') }}"
                                                                onfocus="this.value=''">
                                                            <span
                                                                class="error text-danger">{{ $errors->first('twilio_phone_number') }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- MSG91 SMS Settings --}}
                                                <div class="tab-pane fade" id="msg91wakes" role="tabpanel">
                                                    <div class="sms-settings-section mt-4">

                                                        <div class="d-flex gap-3">
                                                            <div class="mb-3 flex-grow-1">
                                                                <label for="msg91_auth_key" class="form-label"
                                                                    style="color: #000;">MSG91 Auth Key</label>
                                                                <input type="text" class="form-control"
                                                                    id="msg91_auth_key" name="msg91_auth_key"
                                                                    placeholder="Enter MSG91 Auth Key"
                                                                    value="{{ old('msg91_auth_key', $smsConfig->msg91_auth_key ? '******' : '') }}"
                                                                    onfocus="this.value=''">
                                                                <span
                                                                    class="error text-danger">{{ $errors->first('msg91_auth_key') }}</span>
                                                            </div>
                                                            <div class="mb-3 flex-grow-1">
                                                                <label for="msg91_private_key" class="form-label"
                                                                    style="color: #000;">MSG91 Private Key</label>
                                                                <input type="text" class="form-control"
                                                                    id="msg91_private_key" name="msg91_private_key"
                                                                    placeholder="Enter MSG91 Private Key"
                                                                    value="{{ old('msg91_private_key', $smsConfig->msg91_private_key ? '******' : '') }}"
                                                                    onfocus="this.value=''">
                                                                <span
                                                                    class="error text-danger">{{ $errors->first('msg91_private_key') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Save Configuration Button --}}
                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-primary w-md">Save
                                                    Configuration</button>
                                            </div>
                                        </form>
                                    </div>



                                    {{-- Commission --}}
                                    <div class="tab-pane fade" id="commissions-id" role="tabpanel"
                                        aria-labelledby="commissions-tab">
                                        <form action="{{ route('commissions-save') }}" method="POST">
                                            @csrf
                                            <div class="d-flex gap-3">
                                                <!-- Handyman Commission -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="handyman_commission" class="form-label"
                                                        style="color: #000;">Handyman Commission (%)</label>
                                                    <input type="text" class="form-control" id="handyman_commission"
                                                        placeholder="Enter Handyman Commission" name="handyman_commission"
                                                        value="{{ old('handyman_commission', $handymanCommission->value ?? '') }}">
                                                    <span
                                                        class="error text-danger">{{ $errors->first('handyman_commission') }}</span>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-3">
                                                <!-- Provider Service Commission -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="provider_service_commission" class="form-label"
                                                        style="color: #000;">Provider Service Commission (%)</label>
                                                    <input type="text" class="form-control"
                                                        id="provider_service_commission"
                                                        placeholder="Enter Provider Service Commission"
                                                        name="provider_service_commission"
                                                        value="{{ old('provider_service_commission', $providerServiceCommission->value ?? '') }}">
                                                    <span
                                                        class="error text-danger">{{ $errors->first('provider_service_commission') }}</span>
                                                </div>

                                                <!-- Provider Product Commission -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="provider_product_commission" class="form-label"
                                                        style="color: #000;">Provider Product Commission (%)</label>
                                                    <input type="text" class="form-control"
                                                        id="provider_product_commission"
                                                        placeholder="Enter Provider Product Commission"
                                                        name="provider_product_commission"
                                                        value="{{ old('provider_product_commission', $providerProductCommission->value ?? '') }}">
                                                    <span
                                                        class="error text-danger">{{ $errors->first('provider_product_commission') }}</span>
                                                </div>
                                            </div>

                                            <div style="padding-top: 12px;">
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>
                                        </form>
                                    </div>


                                    {{-- Mail Setup --}}
                                    <div class="tab-pane fade" id="mailsetup-id" role="tabpanel"
                                        aria-labelledby="mailsetup-tab">
                                        <form action="{{ url('mailsetup-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="mail_mailer" class="form-label" style="color: #000;">Mail
                                                        Mailer <span class="text-muted"> (Ex: smtp
                                                            )</span> </label>
                                                    <input type="text" class="form-control" id="mail_mailer"
                                                        placeholder="Enter Mail Mailer" name="mail_mailer"
                                                        value="{{ old('mail_mailer', $mailsetup->mail_mailer ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_mail_mailer_error_1"
                                                        class="error text-danger">{{ $errors->first('mail_mailer') }}</span>
                                                </div>

                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="mail_host" class="form-label" style="color: #000;">Mail
                                                        Host <span class="text-muted"> (Ex: smtp.gmail.com
                                                            )</span> </label>
                                                    <input type="text" class="form-control" id="mail_host"
                                                        placeholder="Enter Mail Host" name="mail_host"
                                                        value="{{ old('mail_host', $mailsetup->mail_host ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_mail_host_error_2"
                                                        class="error text-danger">{{ $errors->first('mail_host') }}</span>
                                                </div>
                                            </div>


                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="mail_port" class="form-label" style="color: #000;">Mail
                                                        Port <span class="text-muted"> (Ex: 587
                                                            )</span> </label>
                                                    <input type="text" class="form-control" id="mail_port"
                                                        placeholder="Enter Mail Port" name="mail_port"
                                                        value="{{ old('mail_port', $mailsetup->mail_port ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_1"
                                                        class="error text-danger">{{ $errors->first('mail_port') }}</span>
                                                </div>

                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="mail_encryption" class="form-label"
                                                        style="color: #000;">Mail Encryption <span class="text-muted">
                                                            (Ex: tls
                                                            )</span> </label>
                                                    <input type="text" class="form-control" id="mail_encryption"
                                                        placeholder="Enter Mail Encryption" name="mail_encryption"
                                                        value="{{ old('mail_encryption', $mailsetup->mail_encryption ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_2"
                                                        class="error text-danger">{{ $errors->first('mail_encryption') }}</span>
                                                </div>
                                            </div>




                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1" style="width: 560px;">
                                                    <label for="mail_username" class="form-label"
                                                        style="color: #000;">Mail Username <span class="text-muted"> (Ex:
                                                            hadyman.primo@gmail.com
                                                            )</span> </label>
                                                    <input type="text" class="form-control" id="mail_username"
                                                        placeholder="Enter Mail Username" name="mail_username"
                                                        value="{{ old('mail_username', $mailsetup->mail_username ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_1"
                                                        class="error text-danger">{{ $errors->first('mail_username') }}</span>
                                                </div>

                                                <!-- Second Category Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="mail_password" class="form-label" style="color: #000;">
                                                        Mail Password
                                                        <span class="text-muted">
                                                            (Follow
                                                            <a href="https://document.handyhue.com/docs/email-smtp"
                                                                target="_blank"
                                                                style="color: #246FC1; text-decoration: underline;">
                                                                https://document.handyhue.com/docs/email-smtp
                                                            </a>)
                                                        </span>
                                                    </label>
                                                    <input type="text" class="form-control" id="mail_password"
                                                        placeholder="Enter Mail Password" name="mail_password"
                                                        value="{{ old('mail_password', $mailsetup->mail_password ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_name_error_2"
                                                        class="error text-danger">{{ $errors->first('mail_password') }}</span>
                                                </div>

                                            </div>



                                            <div class="mb-0">
                                                <label for="mail_from" class="form-label" style="color: #000;">Mail from
                                                    Address <span class="text-muted"> (Ex: hadyman.primo@gmail.com
                                                        )</span> </label>
                                                <input type="text" class="form-control" id="mail_from"
                                                    placeholder="Enter Mail from Address" name="mail_from"
                                                    value="{{ old('mail_from', $mailsetup->mail_from ?? '') }}"
                                                    aria-label="Plan Name">
                                                <span id="c_name_error_1"
                                                    class="error text-danger">{{ $errors->first('mail_from') }}</span>
                                            </div>


                                            <div style="padding-top: 12px;">
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>

                                        </form>
                                    </div>


                                    {{-- Nearby Distance --}}
                                    <div class="tab-pane fade" id="nearby-distance-id" role="tabpanel"
                                        aria-labelledby="nearby-distance-tab">
                                        <form action="{{ url('nearbydistance-save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="d-flex gap-3">
                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="distance" class="form-label"
                                                        style="color: #000;">Distance</label>
                                                    <input type="text" class="form-control" id="distance"
                                                        placeholder="Enter Distance" name="distance"
                                                        value="{{ old('distance', $nearbydistance->distance ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_distance_error_1"
                                                        class="error text-danger">{{ $errors->first('distance') }}</span>
                                                </div>

                                                <!-- First Input -->
                                                <div class="mb-3 flex-grow-1">
                                                    <label for="distance_type" class="form-label"
                                                        style="color: #000;">Distance Type</label>
                                                    <input type="text" class="form-control" id="distance_type"
                                                        placeholder="Enter Distance Type" name="distance_type"
                                                        value="{{ old('distance_type', $nearbydistance->distance_type ?? '') }}"
                                                        aria-label="Plan Name">
                                                    <span id="c_distance_error_1"
                                                        class="error text-danger">{{ $errors->first('distance_type') }}</span>
                                                </div>
                                            </div>


                                            <div style="padding-top: 12px;">
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>

                                        </form>
                                    </div>


                                    <!-- Purchase -->
                                    <div class="tab-pane fade" id="purchase-code-id" role="tabpanel"
                                        aria-labelledby="purchase-code-tab">
                                        <form id="purchaseVerificationCode" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="purchase_code" class="form-label"
                                                    style="color: #000;">Purchase Code</label>
                                                <input type="text" class="form-control" id="purchase_code"
                                                    placeholder="Enter Purchase Code" name="purchase_code"
                                                    value="{{ old('purchase_code', isset($purchasecode->purchase_code) ? substr($purchasecode->purchase_code, 0, 10) . ' ********************' : '') }}"
                                                    aria-label="Purchase Code">
                                                <span id="c_purchase_code_error"
                                                    class="error text-danger">{{ $errors->first('purchase_code') }}</span>
                                            </div>
                                            <button type="submit" class="btn btn-danger d-flex align-items-center"
                                                id="deactivateBtn">
                                                <span>Deactivate</span>
                                                <svg id="loadingSpinner"
                                                    class="hidden ms-2 w-5 h-5 text-white animate-spin"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                                </svg>
                                            </button>

                                        </form>
                                    </div>



                                </div>
                            </div><!--  end col -->
                        </div><!-- end row -->
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            function previewImage(event, previewId) {
                const imageInput = event.target;
                const preview = document.getElementById(previewId);

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
        </script>

        <!-- Initialize Select2 -->
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%' // Ensure it spans the full width
                });
            });
        </script>


        {{-- Active Links --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Retrieve the active tab from localStorage
                const activeTab = localStorage.getItem('activetabHome');

                if (activeTab) {
                    // Activate the saved tab
                    const tabLink = document.querySelector(`a[href="${activeTab}"]`);
                    const tabPane = document.querySelector(activeTab);

                    if (tabLink && tabPane) {
                        tabLink.classList.add('active');
                        tabPane.classList.add('active', 'show');
                    }
                } else {
                    // Activate the default tab: #index-data-id
                    const defaultTabLink = document.querySelector('.nav-link[href="#site-setup-id"]');
                    const defaultTabPane = document.querySelector('#site-setup-id');

                    if (defaultTabLink && defaultTabPane) {
                        defaultTabLink.classList.add('active');
                        defaultTabPane.classList.add('active', 'show');
                    }
                }

                // Add click event to all tabs
                document.querySelectorAll('.nav-link').forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Save the clicked tab's ID to localStorage
                        localStorage.setItem('activetabHome', this.getAttribute('href'));

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
        </script> --}}

        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Retrieve the active tab from localStorage
                const activeTab = localStorage.getItem('activehometab');

                if (activeTab) {
                    // Activate the saved tab
                    const tabLink = document.querySelector(`a[href="${activeTab}"]`);
                    const tabPane = document.querySelector(activeTab);

                    if (tabLink && tabPane) {
                        tabLink.classList.add('active');
                        tabPane.classList.add('active', 'show');
                    }
                } else {
                    // Activate the default tab: #site-setup-id
                    const defaultTabLink = document.querySelector('.nav-link[href="#site-setup-id"]');
                    const defaultTabPane = document.querySelector('#site-setup-id');

                    if (defaultTabLink && defaultTabPane) {
                        defaultTabLink.classList.add('active');
                        defaultTabPane.classList.add('active', 'show');
                    }
                }

                // Add click event to all tabs
                document.querySelectorAll('.nav-link').forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Save the clicked tab's ID to localStorage
                        localStorage.setItem('activehometab', this.getAttribute('href'));

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
        </script> --}}

        <!-- JavaScript to Update Hidden Fields -->
        <!-- JavaScript to Update Hidden Fields -->
        <script>
            function updateCurrencyFields() {
                var select = document.getElementById("currency-select");
                var selectedOption = select.options[select.selectedIndex];

                // Update hidden fields
                document.getElementById("default_currency").value = selectedOption.getAttribute("data-symbol");
                document.getElementById("default_currency_name").value = selectedOption.getAttribute("data-name");

                // Update visible display
                document.getElementById("currency-symbol").innerText = selectedOption.getAttribute("data-symbol");
                document.getElementById("currency-name").innerText = selectedOption.getAttribute("data-name");
            }
        </script>




        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById("purchaseVerificationCode").addEventListener("submit", function(event) {
                event.preventDefault();

                const form = this;
                const baseUrl = "{{ url('/') }}/";
                const apiUrl = baseUrl + "api/expireToken";
                const purchaseCode = document.getElementById("purchase_code").value.trim();
                const csrfToken = document.querySelector('input[name="_token"]').value;
                const spinner = document.getElementById("loadingSpinner");

                if (!purchaseCode || purchaseCode === "********") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning!',
                        text: 'Please enter a valid purchase code.',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-warning'
                        }
                    });
                    return;
                }

                // Show spinner before showing confirmation
                spinner.classList.remove("hidden");

                setTimeout(() => {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Are you sure?',
                        text: 'Are you sure you want to deactivate the project? This action cannot be undone.',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Deactivate',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-secondary'
                        }
                    }).then((result) => {
                        // Hide spinner while waiting for confirmation response
                        spinner.classList.add("hidden");

                        if (result.isConfirmed) {
                            // Show spinner again after user confirms
                            spinner.classList.remove("hidden");

                            fetch(apiUrl, {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "Accept": "application/json",
                                        "X-CSRF-TOKEN": csrfToken
                                    },
                                    body: JSON.stringify({
                                        purchase_code: purchaseCode
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    spinner.classList.add("hidden");
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Deleted!',
                                            text: 'Project deactivated successfully.',
                                            confirmButtonText: 'OK',
                                            customClass: {
                                                confirmButton: 'btn btn-success'
                                            }
                                        }).then(() => {
                                            window.location.href = baseUrl;
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: data.message ||
                                                'Failed to deactivate project.',
                                            confirmButtonText: 'OK',
                                            customClass: {
                                                confirmButton: 'btn btn-danger'
                                            }
                                        });
                                    }
                                })
                                .catch(error => {
                                    spinner.classList.add("hidden");
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Something went wrong! Please try again.',
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            confirmButton: 'btn btn-danger'
                                        }
                                    });
                                });
                        }
                    });
                }, 100); // Small delay so spinner is visible
            });
        </script>
    @endsection
