@extends('layouts.master')

@section('title')
    Provider Information
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Provider Information <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Provider List / Provider Information</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/providers-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Overall Provider Information</h4>
                    </div>

                    <div class="card-body">
                        {{-- All Tabs --}}
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#overviewprovider" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Overall</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#serviceprovider" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Service</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerproduct" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Product</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerhandyman" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Handyman</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerreview" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Reviews</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerpayoutlist" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Payout List</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerbank" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Bank List</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">

                            {{-- ProviderOverview --}}
                            <div class="tab-pane active" id="overviewprovider" role="tabpanel">
                                <div class="row">

                                    {{-- Provider Details --}}
                                    <div class="col-xl-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start mb-2">
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title">Provider Details</h5>
                                                    </div>
                                                </div>

                                                <div class="row align-items-center">
                                                    <div class="col-md-5">
                                                        <div class="popular-product-img p-2">
                                                            @if ($user->profile_pic)
                                                                <img src="{{ asset('images/user/' . $user->profile_pic) }}"
                                                                    alt=""
                                                                    style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover;">
                                                            @else
                                                                <img src="{{ asset('images/user/default_provider.jpg') }}"
                                                                    alt=""
                                                                    style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover;">
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="col-md-7">

                                                        <span
                                                            class="badge bg-primary-subtle text-primary font-size-10 text-uppercase ls-05">
                                                            Provider
                                                        </span>

                                                        <h5 class="mt-2 font-size-16">
                                                            <div class="text-body">
                                                                {{ $user->firstname . ' ' . $user->lastname }}
                                                                <i class="bx bxs-star font-size-14 text-warning"></i>
                                                                {{ number_format($avgReview, 1) }}
                                                            </div>
                                                        </h5>

                                                        <!-- Display user phone, email, and address -->
                                                        <p class="mb-0">
                                                            <i
                                                                class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                                            ({{ $user->country_code ?? '' }})
                                                            {{ $user->mobile ?? 'No phone available' }}
                                                        </p>

                                                        <p class="mb-0 mt-2">
                                                            <i
                                                                class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                                            {{ $user->email ?? 'No email available' }}
                                                        </p>

                                                        <div class="row g-0 mt-3 pt-1 align-items-end">
                                                            <div class="col-4">
                                                                <div class="mt-1">
                                                                    <h4 class="font-size-16">{{ $totalServices }}
                                                                    </h4>
                                                                    <p class="text-muted mb-1">Total Service</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="mt-1">
                                                                    <h4 class="font-size-16">{{ $totalProducts }}
                                                                    </h4>
                                                                    <p class="text-muted mb-1">Total Product</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mx-n4" data-simplebar style="max-height: 205px;">
                                                    @if ($services->isEmpty())
                                                        <div
                                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                            <div
                                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                                <i class="bx bx-briefcase"
                                                                    style="font-size: 2.5rem; color: #fff;"></i>
                                                            </div>
                                                            <p
                                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                                No Services Found</p>
                                                        </div>
                                                    @else
                                                        @foreach ($services as $service)
                                                            <div class="popular-product-box rounded my-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="avatar-md">
                                                                            <div
                                                                                class="rounded-circle product-img avatar-title img-thumbnail bg-primary-subtle border-0">
                                                                                @if ($service->serviceImages->isNotEmpty())
                                                                                    <img src="{{ asset('images/service_images/' . $service->serviceImages->first()->service_images) }}"
                                                                                        class="img-fluid" alt=""
                                                                                        style="height: 50px; width: 50px; object-fit: cover; border-radius: 50%;">
                                                                                @else
                                                                                    {{-- Default Avatar --}}
                                                                                    <div class="avatar rounded-circle img-thumbnail"
                                                                                        style="background-color: #246FC1; color: #fff; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; height: 50px;">
                                                                                        <span style="font-size: 1.2rem;">
                                                                                            {{ strtoupper(substr($service->service_name, 0, 1)) }}
                                                                                        </span>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                                                        <h5 class="mb-1 text-truncate">
                                                                            <a href="{{ route('service-edit', $service->id) }}"
                                                                                class="font-size-15 text-body"
                                                                                style="color: #246FC1; text-decoration: none;">
                                                                                {{ \Illuminate\Support\Str::limit($service->service_name, 20) }}
                                                                            </a>
                                                                        </h5>

                                                                        <p
                                                                            class="text-muted fw-semibold mb-0 text-truncate">
                                                                            Price:
                                                                            @if (!empty($service->service_discount_price))
                                                                                {{ $defaultCurrency }}{{ number_format($service->service_discount_price, 2) }}
                                                                            @else
                                                                                {{ $defaultCurrency }}{{ number_format($service->service_price, 2) }}
                                                                            @endif
                                                                            | Duration:
                                                                            @php
                                                                                $durationParts = explode(
                                                                                    ':',
                                                                                    $service->duration,
                                                                                );
                                                                                $hours = (int) $durationParts[0];
                                                                                $minutes = (int) $durationParts[1];

                                                                                $formattedDuration = '';

                                                                                if ($hours > 0) {
                                                                                    $formattedDuration .=
                                                                                        $hours .
                                                                                        ' hour' .
                                                                                        ($hours > 1 ? 's' : '');
                                                                                }

                                                                                if ($minutes > 0) {
                                                                                    $formattedDuration .=
                                                                                        ($formattedDuration
                                                                                            ? ' '
                                                                                            : '') .
                                                                                        $minutes .
                                                                                        ' minute' .
                                                                                        ($minutes > 1 ? 's' : '');
                                                                                }
                                                                            @endphp
                                                                            {{ $formattedDuration }}
                                                                        </p>
                                                                    </div>

                                                                    <div class="flex-shrink-0 text-end ms-3">
                                                                        @if ($service->service_discount_price && $service->service_discount_price > 0)
                                                                            <span
                                                                                style="text-decoration: line-through; color: red;">
                                                                                {{ $defaultCurrency }}{{ $service->service_price }}
                                                                            </span>
                                                                            <span style="color: green;">
                                                                                {{ $defaultCurrency }}{{ $service->service_discount_price }}
                                                                            </span>
                                                                        @elseif ($service->service_price && $service->service_price > 0)
                                                                            <span style="color: green;">
                                                                                {{ $defaultCurrency }}{{ $service->service_price }}
                                                                            </span>
                                                                        @else
                                                                            <span
                                                                                style="color: green;">{{ $defaultCurrency }}0</span>
                                                                        @endif
                                                                        <p class="text-muted fw-semibold mb-0">
                                                                            {{ $service->sales_count }} Sales
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- Earning Graph --}}
                                    <div class="col-xl-8">
                                        <div class="card">
                                            <div class="card-body pb-0">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title mb-4">Earning Overview</h5>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="dropdown">
                                                            <a class="dropdown-toggle text-reset" href="#"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <span class="fw-semibold">Sort By:</span>
                                                                <span class="text-muted" id="yearDropdownLabel">
                                                                    {{ !empty($availableYears) && isset($availableYears[0]) ? $availableYears[0] : 'No Data Available' }}
                                                                    <!-- Display the first year by default -->
                                                                    <i class="mdi mdi-chevron-down ms-1"></i>
                                                                </span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end"
                                                                id="yearDropdownMenu">
                                                                <!-- Year options will be dynamically added here -->
                                                                @foreach ($availableYears as $year)
                                                                    <a class="dropdown-item" href="#"
                                                                        data-year="{{ $year }}">{{ $year }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div id="user-overview-chart" data-colors='["#246FC1", "#e6ecf9"]'
                                                        class="apex-chart"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="row">

                                    {{-- All The Cards --}}
                                    <div class="col-xl-4">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="card"
                                                    style="background-color: #F9D6D6; border: none; color: black;">
                                                    <div class="card-body">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar">
                                                                    <div class="avatar-title rounded"
                                                                        style="background-color: #FF4B4B;">
                                                                        <i class="bx bx-calendar font-size-24 mb-0"
                                                                            style="color: white;"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0 font-size-15">Total Booking</h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $totalBooking }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-black mb-0 text-truncate">Total
                                                                            Booking</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="card"
                                                    style="background-color: #CDEAD6; border: none; color: black;">
                                                    <div class="card-body">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar">
                                                                    <div class="avatar-title rounded"
                                                                        style="background-color: #27AF4D;">
                                                                        <i class="bx bx-wallet font-size-24 mb-0"
                                                                            style="color: white;"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0 font-size-15">Wallet Balance</h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $defaultCurrency }}{{ $WalletBalance }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-black mb-0 text-truncate">Total
                                                                            Wallet Balance</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="card"
                                                    style="background-color: #F9EDD8; border: none; color: black;">
                                                    <div class="card-body">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar">
                                                                    <div class="avatar-title rounded"
                                                                        style="background-color: #FFBC58;">
                                                                        <i class="bx bx-transfer font-size-24 mb-0"
                                                                            style="color: white;"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0 font-size-15">Withdrawn Balance</h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $defaultCurrency }}{{ $WithdrawnBalance }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-black mb-0 text-truncate">Total
                                                                            Withdrawn Balance</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="card"
                                                    style="background-color: #CCEEFF; border: none; color: black;">
                                                    <div class="card-body">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar">
                                                                    <div class="avatar-title rounded"
                                                                        style="background-color: #00A8FF;">
                                                                        <i class="bx bx-wallet font-size-24 mb-0"
                                                                            style="color: white;"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0 font-size-15">Total Balance</h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $defaultCurrency }}{{ $totalProviderBalance }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-black mb-0 text-truncate">Total
                                                                            Balance</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Booking Status --}}
                                    <div class="col-xl-8">
                                        <div class="card" style="height: 24rem;">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Booking Status</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <a href="/pending-bookinglist" style="text-decoration: none;">
                                                            <div class="card text-white"
                                                                style="box-shadow: 0 4px 3px -2px #FFBC58;">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <h6 class="font-size-15">Pending</h6>
                                                                            <h4 class="mt-3 font-size-22">
                                                                                {{ $pendingBookingCount }}</h4>
                                                                        </div>
                                                                        <div class="avatar">
                                                                            <div class="avatar-title rounded"
                                                                                style="background-color: #FFBC58;">
                                                                                <i
                                                                                    class="bx bx-time-five font-size-24"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <a href="/accepted-bookinglist" style="text-decoration: none;">
                                                            <div class="card text-white"
                                                                style="box-shadow: 0 4px 3px -2px #246FC1;">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <h6 class="font-size-15">Accepted</h6>
                                                                            <h4 class="mt-3 font-size-22">
                                                                                {{ $acceptedBookingCount }}</h4>
                                                                        </div>
                                                                        <div class="avatar">
                                                                            <div class="avatar-title rounded"
                                                                                style="background-color: #246FC1;">
                                                                                <i
                                                                                    class="bx bx-check-circle font-size-24"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <a href="/rejected-bookinglist" style="text-decoration: none;">
                                                            <div class="card text-white"
                                                                style="box-shadow: 0 4px 3px -2px #FF4B4B;">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <h6 class="font-size-15">Rejected</h6>
                                                                            <h4 class="mt-3 font-size-22">
                                                                                {{ $rejectedBookingCount }}</h4>
                                                                        </div>
                                                                        <div class="avatar">
                                                                            <div class="avatar-title rounded"
                                                                                style="background-color: #FF4B4B;">
                                                                                <i class="bx bx-x-circle font-size-24"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <a href="/hold-bookinglist" style="text-decoration: none;">

                                                            <div class="card text-white"
                                                                style="box-shadow: 0 4px 3px -2px #FF6F00;">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <h6 class="font-size-15">Hold</h6>
                                                                            <h4 class="mt-3 font-size-22">
                                                                                {{ $holdBookingCount }}</h4>
                                                                        </div>
                                                                        <div class="avatar">
                                                                            <div class="avatar-title rounded"
                                                                                style="background-color: #FF6F00;">
                                                                                <i
                                                                                    class="bx bx-pause-circle font-size-24"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>


                                                <div class="row mt-3">

                                                    <div class="col-md-4">
                                                        <a href="/inprogress-bookinglist" style="text-decoration: none;">
                                                            <div class="card text-white"
                                                                style="box-shadow: 0 4px 3px -2px #00A8FF;">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <h6 class="font-size-15">In Progress</h6>
                                                                            <h4 class="mt-3 font-size-22">
                                                                                {{ $inprogressBookingCount }}</h4>
                                                                        </div>
                                                                        <div class="avatar">
                                                                            <div class="avatar-title rounded"
                                                                                style="background-color: #00A8FF;">
                                                                                <i
                                                                                    class="bx bx-loader-circle font-size-24"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <a href="/completed-bookinglist" style="text-decoration: none;">
                                                            <div class="card text-white"
                                                                style="box-shadow: 0 4px 3px -2px #27AF4D;">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <h6 class="font-size-15">Completed</h6>
                                                                            <h4 class="mt-3 font-size-22">
                                                                                {{ $completedBookingCount }}</h4>
                                                                        </div>
                                                                        <div class="avatar">
                                                                            <div class="avatar-title rounded"
                                                                                style="background-color: #27AF4D;">
                                                                                <i class="bx bx-task font-size-24"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <a href="/cancelled-bookinglist" style="text-decoration: none;">
                                                            <div class="card text-white"
                                                                style="box-shadow: 0 4px 3px -2px #898989;">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <h6 class="font-size-15">Cancelled</h6>
                                                                            <h4 class="mt-3 font-size-22">
                                                                                {{ $cancelledBookingCount }}</h4>
                                                                        </div>
                                                                        <div class="avatar">
                                                                            <div class="avatar-title rounded"
                                                                                style="background-color: #898989;">
                                                                                <i class="bx bx-block font-size-24"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="row">

                                    {{-- All The Cards --}}
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start mb-2">
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title">Latest Customers</h5>
                                                    </div>
                                                </div>

                                                <div class="mx-n4" data-simplebar style="max-height: 421px;">
                                                    @forelse ($latestCustomers as $customer)
                                                        <div class="border-bottom loyal-customers-box pt-2">
                                                            <div class="d-flex align-items-center">

                                                                <img src="{{ asset($customer['profile_pic'] ? 'images/user/' . $customer['profile_pic'] : 'images/user/default_user.jpg') }}"
                                                                    class="rounded-circle avatar img-thumbnail"
                                                                    alt="">

                                                                <div class="flex-grow-1 ms-3 overflow-hidden">
                                                                    <h5 class="font-size-15 mb-1 text-truncate">
                                                                        <a href="{{ route('user-view', ['id' => $customer['id']]) }}"
                                                                            class="text-dark text-decoration-none">
                                                                            {{ $customer['firstname'] . ' ' . $customer['lastname'] }}
                                                                        </a>
                                                                    </h5>
                                                                    <p class="text-muted text-truncate mb-0">
                                                                        {{ \Illuminate\Support\Str::limit($customer['email'], 20, '...') }}
                                                                    </p>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <h5
                                                                        class="font-size-14 mb-0 text-truncate w-xs bg-light p-2 rounded text-center">
                                                                        <i
                                                                            class="bx bxs-star font-size-14 text-warning ms-1"></i>
                                                                        {{ number_format($customer['star_count'], 1) }}

                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="text-muted text-center"
                                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                            <div
                                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 1rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); width: 70px; height: 70px;">
                                                                <i class="bx bx-user"
                                                                    style="font-size: 2.5rem; color: #fff;"></i>
                                                            </div>
                                                            <p
                                                                style="margin-top: 0.8rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                                No latest customer found</p>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="card-title mb-4 text-truncate">Booking Status</h5>
                                                    </div>

                                                </div>

                                                <!-- Pie chart -->
                                                <div id="saleing-categories" class="apex-charts" dir="ltr"></div>

                                                <div class="row mt-3 pt-1">
                                                    <!-- Status breakdown with percentages -->
                                                    <div class="col-md-6">
                                                        <div class="px-2 mt-2">
                                                            <div class="d-flex align-items-center mt-sm-0 mt-2">
                                                                <i class="mdi mdi-circle font-size-10 text-primary"></i>
                                                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                                                    <p class="font-size-15 mb-1 text-truncate">Pending</p>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                                                                    <span class="fw-bold"
                                                                        id="pending-percentage">0%</span>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center mt-2">
                                                                <i class="mdi mdi-circle font-size-10 text-success"></i>
                                                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                                                    <p class="font-size-15 mb-0 text-truncate">Accepted</p>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                                                                    <span class="fw-bold"
                                                                        id="accepted-percentage">0%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="px-2 mt-2">
                                                            <div class="d-flex align-items-center mt-sm-0 mt-2">
                                                                <i class="mdi mdi-circle font-size-10 text-info"></i>
                                                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                                                    <p class="font-size-15 mb-1 text-truncate">Rejected</p>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                                                                    <span class="fw-bold"
                                                                        id="rejected-percentage">0%</span>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center mt-2">
                                                                <i class="mdi mdi-circle font-size-10 text-secondary"></i>
                                                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                                                    <p class="font-size-15 mb-0 text-truncate">Completed
                                                                    </p>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                                                                    <span class="fw-bold"
                                                                        id="completed-percentage">0%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{-- Service Table --}}
                            <div class="tab-pane" id="serviceprovider" role="tabpanel">
                                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="min-width: 16rem; color: #ffff;">Service</th>
                                                <th scope="col" style="color: #ffff;">Category</th>
                                                <th scope="col" style="color: #ffff;">Price</th>
                                                <th scope="col" style="color: #ffff;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($services->isEmpty())
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <div
                                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                            <div
                                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                                <i class="bx bx-briefcase"
                                                                    style="font-size: 2.5rem; color: #fff;"></i>
                                                            </div>
                                                            <p
                                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                                No Services Found</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($services as $service)
                                                    <tr>
                                                        <td>
                                                            <div style="display: flex; align-items: center; gap: 1rem;">

                                                                <div>
                                                                    @if ($service->serviceImages->isNotEmpty())
                                                                        <img src="{{ asset('images/service_images/' . $service->serviceImages->first()->service_images) }}"
                                                                            alt="Service Image"
                                                                            class="avatar rounded-circle img-thumbnail"
                                                                            style="min-width: 50px; height: 50px; object-fit: cover;">
                                                                    @else
                                                                        {{-- Default Avatar --}}
                                                                        <div class="avatar rounded-circle img-thumbnail"
                                                                            style="background-color: #246FC1; color: #fff; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; height: 50px;">
                                                                            <span style="font-size: 1.2rem;">
                                                                                {{ strtoupper(substr($service->service_name, 0, 1)) }}
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <!-- Service Details -->
                                                                {{-- Service Details --}}
                                                                <div style="flex: 1;">
                                                                    {{-- Service Name with link and limit --}}
                                                                    <div class="text-body">
                                                                        <a href="{{ route('service-edit', $service->id) }}"
                                                                            style="color: #246FC1; text-decoration: none;">
                                                                            @php
                                                                                $limitedName = Str::limit(
                                                                                    $service->service_name ?? '',
                                                                                    30,
                                                                                );
                                                                            @endphp
                                                                            {{ $limitedName }}
                                                                        </a>
                                                                    </div>

                                                                    {{-- Service Description --}}
                                                                    <small class="text-muted d-block">
                                                                        Price:
                                                                        @if (!empty($service->service_discount_price))
                                                                            {{ $defaultCurrency }}{{ number_format($service->service_discount_price, 2) }}
                                                                        @else
                                                                            {{ $defaultCurrency }}{{ number_format($service->service_price, 2) }}
                                                                        @endif
                                                                        | Duration:
                                                                        @php
                                                                            $durationParts = explode(
                                                                                ':',
                                                                                $service->duration,
                                                                            );
                                                                            $hours = (int) $durationParts[0];
                                                                            $minutes = (int) $durationParts[1];

                                                                            $formattedDuration = '';

                                                                            if ($hours > 0) {
                                                                                $formattedDuration .=
                                                                                    $hours .
                                                                                    ' hour' .
                                                                                    ($hours > 1 ? 's' : '');
                                                                            }

                                                                            if ($minutes > 0) {
                                                                                $formattedDuration .=
                                                                                    ($formattedDuration ? ' ' : '') .
                                                                                    $minutes .
                                                                                    ' minute' .
                                                                                    ($minutes > 1 ? 's' : '');
                                                                            }
                                                                        @endphp
                                                                        {{ $formattedDuration }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>


                                                        <td>
                                                            @if ($service->category)
                                                                <a href="{{ route('category-edit', $service->category->id) }}"
                                                                    style="color: #246FC1; text-decoration: none;">
                                                                    {{ Str::limit($service->category->c_name, 20) }}
                                                                </a>
                                                            @else
                                                                <span class="text-muted"></span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($service->service_price && $service->service_discount_price && $service->service_discount_price > 0)
                                                                <span
                                                                    style="text-decoration: line-through; color: red;">{{ $defaultCurrency }}{{ $service->service_price }}</span>
                                                                <span
                                                                    style="color: green;">{{ $defaultCurrency }}{{ $service->service_discount_price }}</span>
                                                            @elseif (!$service->service_price && !$service->service_discount_price)
                                                                <span style="color: green;">{{ $defaultCurrency }}0</span>
                                                            @else
                                                                <span
                                                                    style="color: green;">{{ $defaultCurrency }}{{ $service->service_price }}</span>
                                                            @endif
                                                        </td>


                                                        <td>
                                                            <ul class="list-inline mb-0">
                                                                <li class="list-inline-item">
                                                                    <a href="{{ route('service-edit', $service->id) }}"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Edit" class="px-2 text-primary"><i
                                                                            class="bx bx-pencil font-size-18"></i></a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            {{-- Product Table --}}
                            <div class="tab-pane" id="providerproduct" role="tabpanel">
                                <div class="card-body">
                                    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                        <table class="table table-nowrap align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Product
                                                    </th>
                                                    <th scope="col" style="color: #ffff;">Service
                                                    </th>
                                                    <th scope="col" style="color: #ffff;">Price</th>
                                                    <th scope="col" style="color: #ffff;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($products->isEmpty())
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            <div
                                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                                <div
                                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                                    <i class="bx bx-box"
                                                                        style="font-size: 2.5rem; color: #fff;"></i>
                                                                </div>
                                                                <p
                                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                                    No Product Found</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>
                                                                <div
                                                                    style="display: flex; align-items: center; gap: 1rem;">
                                                                    <!-- Product Image -->
                                                                    <div>
                                                                        @if ($product->productImages->isNotEmpty())
                                                                            <img src="{{ asset('images/product_images/' . $product->productImages->first()->product_image) }}"
                                                                                alt="Product Image"
                                                                                class="avatar rounded-circle img-thumbnail"
                                                                                style="min-width: 50px; height: 50px; object-fit: cover;">
                                                                        @else
                                                                            {{-- Default Avatar --}}
                                                                            <div class="avatar rounded-circle img-thumbnail"
                                                                                style="background-color: #246FC1; color: #fff; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; height: 50px;">
                                                                                <span style="font-size: 1.2rem;">
                                                                                    {{ strtoupper(substr($product->product_name, 0, 1)) }}
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <!-- Product Details -->
                                                                    <div style="flex: 1;">
                                                                        <div class="text-body">
                                                                            <a href="{{ route('product-edit', $product->product_id) }}"
                                                                                style="color: #246FC1; text-decoration: none;">
                                                                                @php
                                                                                    $limitedName = Str::limit(
                                                                                        $product->product_name ?? '',
                                                                                        30,
                                                                                    );
                                                                                @endphp
                                                                                {{ $limitedName }}
                                                                            </a>
                                                                        </div>
                                                                        {{-- Service Description --}}
                                                                        <small class="text-muted d-block">
                                                                            Price:
                                                                            @if (!empty($product->product_discount_price))
                                                                                {{ $defaultCurrency }}{{ number_format($product->product_discount_price, 2) }}
                                                                            @else
                                                                                {{ $defaultCurrency }}{{ number_format($product->product_price, 2) }}
                                                                            @endif
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div>
                                                                    <div class="text-body">
                                                                        @if ($product->service_details)
                                                                            <a href="{{ route('service-edit', $product->service_details->id) }}"
                                                                                style="color: #246FC1; text-decoration: none;">
                                                                                {{ Str::limit($product->service_details->service_name, 20) }}
                                                                            </a>
                                                                        @else
                                                                            <span class="text-muted"></span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                @if ($product->product_price && $product->product_discount_price && $product->product_discount_price > 0)
                                                                    <span
                                                                        style="text-decoration: line-through; color: red;">{{ $defaultCurrency }}{{ $product->product_price }}</span>
                                                                    <span
                                                                        style="color: green;">{{ $defaultCurrency }}{{ $product->product_discount_price }}</span>
                                                                @elseif (!$product->product_price && !$product->product_discount_price)
                                                                    <span
                                                                        style="color: green;">{{ $defaultCurrency }}0</span>
                                                                @else
                                                                    <span
                                                                        style="color: green;">{{ $defaultCurrency }}{{ $product->product_price }}</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <ul class="list-inline mb-0">
                                                                    <li class="list-inline-item">
                                                                        <a href="{{ route('product-edit', $product->product_id) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Edit"
                                                                            class="px-2 text-primary"><i
                                                                                class="bx bx-pencil font-size-18"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            {{-- Handyman List --}}
                            <div class="tab-pane" id="providerhandyman" role="tabpanel">
                                <div class="row mt-2">
                                    @forelse ($handymen as $handyman)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <img src="{{ URL::asset('images/user/' . $handyman->profile_pic) }}"
                                                                alt=""
                                                                class="avatar-md rounded-circle img-thumbnail">
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <a
                                                                href="{{ route('handyman-view', ['id' => $handyman->id]) }}">
                                                                <h5
                                                                    class="font-size-16 mb-1 text-body d-flex align-items-center">
                                                                    {{ $handyman->firstname }} {{ $handyman->lastname }}
                                                                    <span class="d-flex align-items-center ms-1"
                                                                        style="color: #000000;">
                                                                        <i
                                                                            class="bx bxs-star font-size-14 text-warning"></i>
                                                                        <span class="font-size-14">
                                                                            {{ number_format($handyman->avg_handyman_review, 1) }}
                                                                        </span>
                                                                    </span>
                                                                </h5>
                                                            </a>
                                                            <span
                                                                class="badge bg-danger-subtle text-danger mb-0">Handyman</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 pt-1">
                                                        <p class="mb-0">
                                                            <i
                                                                class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                                            {{ $handyman->country_code }} {{ $handyman->mobile }}
                                                        </p>
                                                        <p class="mb-0 mt-2">
                                                            <i
                                                                class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                                            {{ $handyman->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <div class="table-light" style="padding-top: 23px;">
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                    <div
                                                        style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                        <i class="bx bx-user" style="font-size: 2.5rem; color: #fff;"></i>
                                                    </div>
                                                    <p
                                                        style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                        No Handyman Available
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>


                            {{-- Review Table --}}
                            <div class="tab-pane" id="providerreview" role="tabpanel">
                                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="color: #fff; min-width: 16rem;">Customer</th>
                                                <th scope="col" style="color: #fff;">Date</th>
                                                <th scope="col" style="color: #fff;">Review</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($latestCustomersofProvider as $review)
                                                <tr>
                                                    <td>
                                                        <div style="display: flex; align-items: center;">
                                                            <div>
                                                                {{-- Provider Image --}}
                                                                @if ($review['profile_pic'])
                                                                    <img src="{{ asset('images/user/' . $review['profile_pic']) }}"
                                                                        class="avatar rounded-circle img-thumbnail me-2"
                                                                        alt="Provider Profile Picture">
                                                                @else
                                                                    {{-- Default User Image --}}
                                                                    <img src="{{ asset('images/user/default_provider.jpg') }}"
                                                                        class="avatar rounded-circle img-thumbnail me-2">
                                                                @endif
                                                            </div>

                                                            <div
                                                                style="display: flex; flex-direction: column; width: fit-content;">
                                                                <div style="display: flex; align-items: center;">
                                                                    <a href="{{ route('user-view', $review['id']) }}"
                                                                        style="color: #246FC1; margin-right: 5px;">
                                                                        {{ $review['firstname'] }}
                                                                        {{ Str::limit($review['lastname'], 20) }}
                                                                    </a>
                                                                    <span class="d-flex align-items-center"
                                                                        style="color: #000000;">
                                                                        <i
                                                                            class="bx bxs-star font-size-14 text-warning"></i>
                                                                        <span class="font-size-14">
                                                                            {{ $review['avg_users_review'] ?? '0' }}
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <small class="text-muted">
                                                                    {{ Str::limit($review['email'], 30) }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <!-- Format created_at -->
                                                        {{ $review['created_at'] }}
                                                    </td>
                                                    <td style="word-wrap: break-word; max-width: 300px;">
                                                        <div>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="{{ $i <= $review['star_count'] ? 'fas' : 'far' }} fa-star text-warning"></i>
                                                            @endfor
                                                            <div>{{ $review['text'] }}</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        <div
                                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                            <div
                                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                                <i class="bx bx-star"
                                                                    style="font-size: 2.5rem; color: #fff;"></i>
                                                            </div>
                                                            <p
                                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                                No Reviews Available
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            {{-- Provider Payout List --}}
                            <div class="tab-pane" id="providerpayoutlist" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="color: #ffff;">Amount</th>
                                                <th scope="col" style="color: #ffff;">Date</th>
                                                <th scope="col" style="color: #ffff;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($payouts as $payout)
                                                <tr>
                                                    <td>{{ $defaultCurrency }}{{ number_format($payout->amount, 2) }}
                                                    </td>
                                                    <td>
                                                        <!-- Format created_at -->
                                                        {{ \Carbon\Carbon::parse($payout->created_at)->format('d M, Y / h:i A') }}
                                                    </td>
                                                    <td>
                                                        @if ($payout->status === 1)
                                                            <button type="button"
                                                                class="btn btn-success btn-sm waves-effect waves-light">
                                                                Approved
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm waves-effect waves-light">
                                                                Not Approved
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        <div
                                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                            <div
                                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                                <i class="bx bx-wallet"
                                                                    style="font-size: 2.5rem; color: #fff;"></i>
                                                            </div>
                                                            <p
                                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                                No Payouts Available</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            {{-- Bank Details --}}
                            <div class="tab-pane" id="providerbank" role="tabpanel">
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="color: #ffff;">Bank Name</th>
                                                <th scope="col" style="min-width: 5rem; color: #ffff;">Branch Name</th>
                                                <th scope="col" style="min-width: 16rem; color: #ffff;">Account No</th>
                                                <th scope="col" style="color: #ffff;">IFSC Code</th>
                                                <th scope="col" style="color: #ffff;">Mobile No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (
                                                $bankDetails &&
                                                    ($bankDetails->bank_name ||
                                                        $bankDetails->branch_name ||
                                                        $bankDetails->acc_number ||
                                                        $bankDetails->ifsc_code ||
                                                        $bankDetails->mobile_number))
                                                <tr>
                                                    <td>{{ $bankDetails->bank_name ?? '' }}</td>
                                                    <td>{{ $bankDetails->branch_name ?? '' }}</td>
                                                    <td>{{ $bankDetails->acc_number ?? '' }}</td>
                                                    <td>{{ $bankDetails->ifsc_code ?? '' }}</td>
                                                    <td>{{ $bankDetails->mobile_number ?? '' }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <div
                                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                            <div
                                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                                <i class="bx bx-money"
                                                                    style="font-size: 2.5rem; color: #fff;"></i>
                                                            </div>
                                                            <p
                                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                                No Bank Details Available
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>


        {{-- Earning Graph --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fetch the provider ID and default currency from the Blade view variable
                const providerId = @json($user->id);
                const defaultCurrency = @json($defaultCurrency);

                // Get the data from your Blade variable
                const providerMonthData = @json($monthlyEarnings);

                // Extract data for chart
                const months = providerMonthData.map(item => item.x);
                const earnings = providerMonthData.map(item => item.Earnings);

                const options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 5,
                            horizontal: false,
                        }
                    },
                    series: [{
                        name: 'Total Earnings',
                        data: earnings
                    }],
                    xaxis: {
                        categories: months
                    },
                    yaxis: {
                        tickAmount: 5,
                        labels: {
                            formatter: function(val) {
                                return `${defaultCurrency}${Math.round(val).toLocaleString()}`; // Format with currency symbol
                            }
                        }
                    },
                    colors: ['#246FC1'],
                    dataLabels: {
                        enabled: false
                    },
                };

                const chart = new ApexCharts(document.querySelector("#user-overview-chart"), options);
                chart.render();

                // Get the current year and set it as the default selection
                const currentYear = new Date().getFullYear();
                const yearDropdownLabel = document.getElementById('yearDropdownLabel');
                yearDropdownLabel.textContent = currentYear; // Set the current year as the label

                // Fetch data for the current year
                fetch(`/provider/${providerId}/earnings/${currentYear}`)
                    .then(response => response.json())
                    .then(data => {
                        const newEarnings = data.monthlyEarnings.map(item => item.Earnings);
                        chart.updateOptions({
                            series: [{
                                name: 'Total Earnings',
                                data: newEarnings
                            }]
                        });
                    });

                // Year dropdown click event
                const yearDropdownMenu = document.getElementById('yearDropdownMenu');

                // Add event listeners to the dynamically created year options
                yearDropdownMenu.querySelectorAll('.dropdown-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const selectedYear = item.getAttribute('data-year');
                        yearDropdownLabel.textContent =
                            selectedYear; // Update label to the selected year

                        // Fetch data for the selected year via AJAX
                        fetch(`/provider/${providerId}/earnings/${selectedYear}`)
                            .then(response => response.json())
                            .then(data => {
                                const newEarnings = data.monthlyEarnings.map(item => item.Earnings);
                                chart.updateOptions({
                                    series: [{
                                        name: 'Total Earnings',
                                        data: newEarnings
                                    }]
                                });
                            });
                    });
                });
            });
        </script>


        {{-- All Status Pie Chart --}}
        <script>
            // document.addEventListener("DOMContentLoaded", function() {
            //     // Fetch the status counts for the provider from the backend
            //     const statusCounts = @json($statusCounts);

            //     const statuses = Object.keys(statusCounts); // ["Pending", "Accepted", "Rejected", "Completed"]
            //     const counts = Object.values(statusCounts); // [0, 2, 3, 6]

            //     const totalCount = counts.reduce((total, count) => total + count, 0);
            //     const percentages = counts.map(count => ((count / totalCount) * 100).toFixed(1));

            //     const colors = ['#246FC1', '#4976cf', '#6a92e1', '#e6ecf9']; // Custom colors as per user's request

            //     // Update the percentage values dynamically
            //     document.getElementById('pending-percentage').textContent = `${percentages[0]}%`;
            //     document.getElementById('accepted-percentage').textContent = `${percentages[1]}%`;
            //     document.getElementById('rejected-percentage').textContent = `${percentages[2]}%`;
            //     document.getElementById('completed-percentage').textContent = `${percentages[3]}%`;

            //     // Render the pie chart using ApexCharts
            //     const options = {
            //         series: counts,
            //         chart: {
            //             type: 'pie',
            //             height: 350
            //         },
            //         labels: statuses,
            //         colors: colors.slice(0, statuses.length), // Assign colors dynamically
            //         responsive: [{
            //             breakpoint: 480,
            //             options: {
            //                 chart: {
            //                     width: 200
            //                 },
            //                 legend: {
            //                     position: 'bottom'
            //                 }
            //             }
            //         }]
            //     };

            //     const chart = new ApexCharts(document.querySelector("#saleing-categories"), options);
            //     chart.render();
            // });


            document.addEventListener("DOMContentLoaded", function() {
                // Fetch the status counts for the provider from the backend
                const statusCounts = @json($statusCounts);

                const statuses = Object.keys(statusCounts); // ["Pending", "Accepted", "Rejected", "Completed"]
                const counts = Object.values(statusCounts); // [0, 2, 3, 6]

                const totalCount = counts.reduce((total, count) => total + count, 0);

                // Avoid NaN% by setting default value to 0% if totalCount is 0
                const percentages = totalCount === 0 ?
                    counts.map(() => '0%') :
                    counts.map(count => ((count / totalCount) * 100).toFixed(1) + '%');

                const colors = ['#246FC1', '#4976cf', '#6a92e1', '#e6ecf9']; // Custom colors

                // Update the percentage values dynamically
                document.getElementById('pending-percentage').textContent = percentages[0];
                document.getElementById('accepted-percentage').textContent = percentages[1];
                document.getElementById('rejected-percentage').textContent = percentages[2];
                document.getElementById('completed-percentage').textContent = percentages[3];

                // Render the pie chart using ApexCharts
                const options = {
                    series: totalCount === 0 ? [1] : counts, // Default to [1] if no data
                    chart: {
                        type: 'pie',
                        height: 350
                    },
                    labels: totalCount === 0 ? ["No Data"] : statuses,
                    colors: totalCount === 0 ? ['#6a92e1'] : colors.slice(0, statuses
                        .length), // Default gray color for no data
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                const chart = new ApexCharts(document.querySelector("#saleing-categories"), options);
                chart.render();
            });
        </script>
    @endsection
