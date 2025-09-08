@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<style>
    .responsive-overflow {

        /* Apply overflow only on small screens (600px or less) */
        @media (max-width: 600px) {
           height: 70rem !important;

        }
    }


    .salereport-overflow {

        /* Apply overflow only on small screens (600px or less) */
        @media (max-width: 600px) {
           height: 45rem !important;

        }
    }
</style>

@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Cards --}}
        <div class="row" style="padding-top: 35px;">
            <div class="col-xl-4">

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <div class="card" style="background-color: #F9EDD8; border: none; color: black;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="font-size-15">Total Earning</h6>
                                        <h4 class="mt-3 pt-1 mb-0 font-size-22">
                                            {{ $defaultCurrency }}{{ $totalAmount }}
                                        </h4>
                                    </div>
                                    <div class="">
                                        <div class="avatar">
                                            <div class="avatar-title rounded" style="background-color: #FFBC58;">
                                                <i class="bx bx-dollar-circle font-size-24 mb-0" style="color: white;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-xl-6">
                        <a href="/service-list" style="text-decoration: none;">
                            <div class="card" style="background-color: #E1E2E2; border: none; color: black;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-size-15">Total Services</h6>
                                            <h4 class="mt-3 pt-1 mb-0 font-size-22">
                                                {{ $totalServices }}
                                            </h4>
                                        </div>
                                        <div class="">
                                            <div class="avatar">
                                                <div class="avatar-title rounded" style="background-color: #898989;">
                                                    <i class="bx bx-briefcase font-size-24 mb-0" style="color: white;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <a href="/product-list" style="text-decoration: none;">
                            <div class="card" style="background-color: #CDEAD6; border: none; color: black;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-size-15">Total Products</h6>
                                            <h4 class="mt-3 pt-1 mb-0 font-size-22">
                                                {{ $totalProducts }}
                                            </h4>
                                        </div>
                                        <div class="">
                                            <div class="avatar">
                                                <div class="avatar-title rounded" style="background-color: #27AF4D;">
                                                    <i class="bx bx-package font-size-24 mb-0" style="color: white;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-6 col-xl-6">
                        <a href="/booking-list" style="text-decoration: none;">
                            <div class="card" style="background-color: #F9D6D6; border: none; color: black;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-size-15">Total Bookings</h6>
                                            <h4 class="mt-3 pt-1 mb-0 font-size-22">
                                                {{ $totalBooking }}
                                            </h4>
                                        </div>
                                        <div class="">
                                            <div class="avatar">
                                                <div class="avatar-title rounded" style="background-color: #FF4B4B;">
                                                    <i class="bx bx-calendar font-size-24 mb-0" style="color: white;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <a href="/providers-list" style="text-decoration: none;">
                            <div class="card" style="background-color: #E9D5FA; border: none; color: black;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-size-15">Total Provider</h6>
                                            <h4 class="mt-3 pt-1 mb-0 font-size-22">
                                                {{ $totalprovider }}
                                            </h4>
                                        </div>
                                        <div class="">
                                            <div class="avatar">
                                                <div class="avatar-title rounded" style="background-color: #AD46FF;">
                                                    <i class="bx bx-user font-size-24 mb-0" style="color: white;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-6 col-xl-6">
                        <a href="/user-list" style="text-decoration: none;">
                            <div class="card" style="background-color: #CCEEFF; border: none; color: black;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-size-15">Total Customer</h6>
                                            <h4 class="mt-3 pt-1 mb-0 font-size-22">
                                                {{ $totaluser }}
                                            </h4>
                                        </div>
                                        <div class="">
                                            <div class="avatar">
                                                <div class="avatar-title rounded" style="background-color: #00A8FF;">
                                                    <i class="bx bx-user font-size-24 mb-0" style="color: white;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">
                <div class="card responsive-overflow" style="height: 24rem;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Booking Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <a href="/pending-bookinglist" style="text-decoration: none;">
                                    <div class="card text-white" style="box-shadow: 0 4px 3px -2px #FFBC58;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="font-size-15">Pending</h6>
                                                    <h4 class="mt-3 font-size-22">{{ $pendingBookingCount }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <div class="avatar-title rounded" style="background-color: #FFBC58;">
                                                        <i class="bx bx-time-five font-size-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="/accepted-bookinglist" style="text-decoration: none;">
                                    <div class="card text-white" style="box-shadow: 0 4px 3px -2px #246FC1;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="font-size-15">Accepted</h6>
                                                    <h4 class="mt-3 font-size-22">{{ $acceptedBookingCount }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <div class="avatar-title rounded" style="background-color: #246FC1;">
                                                        <i class="bx bx-check-circle font-size-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="/rejected-bookinglist" style="text-decoration: none;">
                                    <div class="card text-white" style="box-shadow: 0 4px 3px -2px #FF4B4B;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="font-size-15">Rejected</h6>
                                                    <h4 class="mt-3 font-size-22">{{ $rejectedBookingCount }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <div class="avatar-title rounded" style="background-color: #FF4B4B;">
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

                                    <div class="card text-white" style="box-shadow: 0 4px 3px -2px #FF6F00;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="font-size-15">Hold</h6>
                                                    <h4 class="mt-3 font-size-22">{{ $holdBookingCount }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <div class="avatar-title rounded" style="background-color: #FF6F00;">
                                                        <i class="bx bx-pause-circle font-size-24"></i>
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
                                    <div class="card text-white" style="box-shadow: 0 4px 3px -2px #00A8FF;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="font-size-15">In Progress</h6>
                                                    <h4 class="mt-3 font-size-22">{{ $inprogressBookingCount }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <div class="avatar-title rounded" style="background-color: #00A8FF;">
                                                        <i class="bx bx-loader-circle font-size-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4">
                                <a href="/completed-bookinglist" style="text-decoration: none;">
                                    <div class="card text-white" style="box-shadow: 0 4px 3px -2px #27AF4D;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="font-size-15">Completed</h6>
                                                    <h4 class="mt-3 font-size-22">{{ $completedBookingCount }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <div class="avatar-title rounded" style="background-color: #27AF4D;">
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
                                    <div class="card text-white" style="box-shadow: 0 4px 3px -2px #898989;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="font-size-15">Cancelled</h6>
                                                    <h4 class="mt-3 font-size-22">{{ $cancelledBookingCount }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <div class="avatar-title rounded" style="background-color: #898989;">
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


        {{-- Sales Graph --}}
        {{-- <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Sales Report</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="fw-semibold">Sort By:</span>
                                        <span class="text-muted">{{ $year }} <i
                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @for ($y = date('Y'); $y >= date('Y') - 2; $y--)
                                            <a class="dropdown-item"
                                                href="{{ route('admin-dashboard', ['year' => $y]) }}">{{ $y }}</a>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Dynamically display total service and product payments -->
                                <h4 class="font-size-22">
                                    {{ $defaultCurrency }}{{ number_format($totalProductAndServicePayments, 2) }}</h4>
                            </div>
                            <div class="col-md-8">
                                <ul class="list-inline main-chart text-md-end mb-0">
                                    <li class="list-inline-item chart-border-left me-0 border-0">
                                        <h4 class="text-primary font-size-22">
                                            {{ $defaultCurrency }}{{ number_format($totalServicePayments, 2) }}
                                            <span
                                                class="text-muted d-inline-block font-size-14 align-middle ms-2">Services</span>
                                        </h4>
                                    </li>
                                    <li class="list-inline-item chart-border-left me-0">
                                        <h4 class="font-size-22">
                                            {{ $defaultCurrency }}{{ number_format($totalProductPayments, 2) }}
                                            <span
                                                class="text-muted d-inline-block font-size-14 align-middle ms-2">Products</span>
                                        </h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <div id="sales-report" data-colors='["#246FC1","#e6ecf9"]' class="apex-charts"
                                dir="ltr">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-xl-8">
                <div class="card salereport-overflow" style="height: 39rem;">
                    <div class="card-header">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Sales Report</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="fw-semibold">Year:</span>
                                        <span class="text-muted">{{ $year }} <i
                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @for ($y = date('Y'); $y >= date('Y') - 2; $y--)
                                            <a class="dropdown-item"
                                                href="{{ route('admin-dashboard', ['year' => $y, 'month' => $month]) }}">{{ $y }}</a>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-3">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="fw-semibold">Month:</span>
                                        <span class="text-muted">{{ $monthName }} <i
                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $index => $monthName)
                                            <a class="dropdown-item"
                                                href="{{ route('admin-dashboard', ['year' => $year, 'month' => $index + 1]) }}">{{ $monthName }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="font-size-22">
                                    {{ $defaultCurrency }}{{ number_format($totalProductAndServicePayments, 2) }}</h4>
                            </div>
                            <div class="col-md-8">
                                <ul class="list-inline main-chart text-md-end mb-0">
                                    <li class="list-inline-item chart-border-left me-0 border-0">
                                        <h4 class="text-primary font-size-22">
                                            {{ $defaultCurrency }}{{ number_format($totalServicePayments, 2) }}
                                            <span
                                                class="text-muted d-inline-block font-size-14 align-middle ms-2">Services</span>
                                        </h4>
                                    </li>
                                    <li class="list-inline-item chart-border-left me-0">
                                        <h4 class="font-size-22">
                                            {{ $defaultCurrency }}{{ number_format($totalProductPayments, 2) }}
                                            <span
                                                class="text-muted d-inline-block font-size-14 align-middle ms-2">Products</span>
                                        </h4>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <div id="sales-report" data-colors='["#246FC1","#e6ecf9"]' class="apex-charts"
                                dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Source of Purchases</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="fw-semibold">Year:</span>
                                        <span class="text-muted">{{ $year }} <i
                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @for ($y = date('Y'); $y >= date('Y') - 2; $y--)
                                            <a class="dropdown-item"
                                                href="{{ route('admin-dashboard', ['year' => $y, 'month' => $month]) }}">{{ $y }}</a>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="chart-radialBar"></div>
                        <div class="mt-4 px-1 pt-1">
                            <div class="mx-n4" data-simplebar style="max-height: 214px;">
                                <div class="border-bottom sale-social-box">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar">
                                                <div class="avatar-title rounded bg-primary-subtle">
                                                    <i class="bx bxs-briefcase font-size-24 mb-0 text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3 overflow-hidden">
                                            <h5 class="font-size-15 mb-1 text-truncate">
                                                <a href="/service-list" class="text-dark">Service</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0">
                                                {{ $totalServicesCount }} Counts
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="/service-list" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-bottom sale-social-box mt-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar">
                                                <div class="avatar-title rounded bg-success-subtle">
                                                    <i class="bx bxs-shopping-bag font-size-24 mb-0 text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3 overflow-hidden">
                                            <h5 class="font-size-15 mb-1 text-truncate">
                                                <a href="/product-list" class="text-dark">Product</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0">
                                                {{ $totalProductsCount }} Counts
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="/product-list" class="btn btn-success btn-sm">View</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- Recent Orders & Recent Users --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-2" style="justify-content: space-between;">
                            <h5 class="card-title">Recent Orders</h5>
                            <a href="/booking-list" class="view-all ml-auto d-flex align-items-center">
                                View All
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-arrow-right ml-1">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-centered align-middle table-nowrap mb-0 table-check">
                                <thead>
                                    <tr>
                                        <th>
                                            Order Id
                                        </th>
                                        <th style="min-width: 16rem;">Booking Date</th>
                                        <th style="min-width: 16rem;">Customer</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($records->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                    <div
                                                        style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                        <i class="bx bx-calendar"
                                                            style="font-size: 2.5rem; color: #fff;"></i>
                                                    </div>
                                                    <p
                                                        style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                        No Bookings Found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($records as $user)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('booking-view', $user->id) }}"
                                                        style="color: #246FC1;">
                                                        #{{ $user->id }}
                                                    </a>
                                                </td>
                                                <td>{{ $user->formatted_created_at ?? '' }}</td>

                                                <td>
                                                    <div style="display: flex; align-items: center;">
                                                        <div>
                                                            {{-- User Image --}}
                                                            @if ($user->user && $user->user->profile_pic)
                                                                <img src="{{ asset('images/user/' . $user->user->profile_pic) }}"
                                                                    class="avatar rounded-circle img-thumbnail me-2">
                                                            @else
                                                                {{-- Default User Image --}}
                                                                <img src="{{ asset('images/user/default_user.jpg') }}"
                                                                    class="avatar rounded-circle img-thumbnail me-2">
                                                            @endif
                                                        </div>

                                                        <div
                                                            style="display: flex; flex-direction: column; width: fit-content;">
                                                            {{-- User Full Name with Review --}}
                                                            @if ($user->user)
                                                                <div class="text-body"
                                                                    style="display: flex; align-items: center;">
                                                                    <a href="{{ route('user-view', $user->user_id) }}"
                                                                        style="color: #246FC1;">
                                                                        {{ $user->user->firstname }}
                                                                        {{ Str::limit($user->user->lastname ?? '', 20) }}
                                                                    </a>

                                                                    {{-- Review beside name --}}
                                                                    <span class="ms-1 d-flex align-items-center"
                                                                        style="color: #000000;">
                                                                        <i
                                                                            class="bx bxs-star font-size-14 text-warning"></i>
                                                                        <span class="font-size-14">
                                                                            {{ $user->user->avg_users_review ?? '0' }}
                                                                        </span>
                                                                    </span>
                                                                </div>

                                                                <small class="text-muted">
                                                                    {{ Str::limit($user->user->email ?? '', 30) }}
                                                                </small>
                                                            @else
                                                                <div class="text-body"></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>{{ $user->total > 0 ? $defaultCurrency . $user->total : $defaultCurrency . '0' }}
                                                </td>


                                                <td>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('booking-view', $user->id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="View" class="px-2 text-primary"><i
                                                                    class="bx bx-show font-size-18"></i></a>
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
            </div>


            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-2" style="justify-content: space-between;">
                            <h5 class="card-title">Recent Users</h5>
                            <a href="/all-users" class="view-all ml-auto d-flex align-items-center">
                                View All
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-arrow-right ml-1">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-centered align-middle table-nowrap mb-0 table-check">
                                <thead>
                                    <tr>
                                        <th style="min-width: 16rem;">User</th>
                                        <th>Role</th>
                                        <th style="min-width: 10rem;">Contact Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                    <div
                                                        style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                        <i class="bx bx-user" style="font-size: 2.5rem; color: #fff;"></i>
                                                    </div>
                                                    <p
                                                        style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                        No Users Found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div style="display: flex;align-items: center;">
                                                        <div>
                                                            {{-- User Image --}}
                                                            @if ($user->profile_pic)
                                                                <img src="{{ asset('images/user/' . $user->profile_pic) }}"
                                                                    class="avatar rounded-circle img-thumbnail me-2">
                                                            @else
                                                                {{-- Default Avatar based on people_id --}}
                                                                @php
                                                                    $defaultImages = [
                                                                        1 => 'default_provider.jpg',
                                                                        2 => 'default_handyman.jpg',
                                                                        3 => 'default_user.jpg',
                                                                    ];
                                                                    $defaultImage =
                                                                        $defaultImages[$user->people_id] ??
                                                                        'default_user.jpg';
                                                                @endphp
                                                                <img src="{{ asset('images/user/' . $defaultImage) }}"
                                                                    class="avatar rounded-circle img-thumbnail me-2">
                                                            @endif
                                                        </div>


                                                        <div
                                                            style="display: flex; flex-direction: column; width: fit-content;">
                                                            {{-- User Full Name with Highlight --}}
                                                            {{-- User Full Name with Highlight --}}
                                                            @php
                                                                $fullName = Str::limit(
                                                                    $user->firstname . ' ' . $user->lastname,
                                                                    25,
                                                                );
                                                                $highlightedName = $search
                                                                    ? preg_replace(
                                                                        '/' . preg_quote($search, '/') . '/i',
                                                                        '<mark>$0</mark>',
                                                                        $fullName,
                                                                    )
                                                                    : '<span style="color: #246FC1;">' .
                                                                        $fullName .
                                                                        '</span>';

                                                                // Determine the correct route based on people_id
                                                                $viewRoute = match ($user->people_id) {
                                                                    1 => route('provider-view', $user->id),
                                                                    2 => route('handyman-view', $user->id),
                                                                    3 => route('user-view', $user->id),
                                                                    default => route('user-view', $user->id),
                                                                };

                                                                // Set correct average review value based on people_id
                                                                $avgReview =
                                                                    $user->people_id == 1
                                                                        ? $user->avg_review ?? '0.0' // Provider rating
                                                                        : ($user->people_id == 2 ||
                                                                        $user->people_id == 3
                                                                            ? $user->avg_review ?? '0.0' // Handyman rating
                                                                            : '');
                                                            @endphp

                                                            <a href="{{ $viewRoute }}"
                                                                class="text-body text-decoration-none"
                                                                style="display: flex;">
                                                                <div class="text-body" style="color: #246FC1;">
                                                                    {!! $highlightedName !!}
                                                                </div>
                                                                {{-- Review beside name with black color --}}
                                                                @if ($user->people_id == 1 || $user->people_id == 2 || $user->people_id == 3)
                                                                    <span class="ms-1 d-flex align-items-center"
                                                                        style="color: #000000;">
                                                                        <i
                                                                            class="bx bxs-star font-size-14 text-warning"></i>
                                                                        <span
                                                                            class="font-size-14">{{ $avgReview }}</span>
                                                                    </span>
                                                                @endif
                                                            </a>

                                                            <small class="text-muted">
                                                                {{ Str::limit($user->email ?? '', 20) }}
                                                            </small>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td>
                                                    @if ($user->people_id === 1)
                                                        <span
                                                            class="badge bg-primary-subtle text-primary font-size-14">Provider</span>
                                                    @elseif ($user->people_id === 2)
                                                        <span
                                                            class="badge bg-danger-subtle text-danger font-size-14">Handyman</span>
                                                    @elseif ($user->people_id === 3)
                                                        <span
                                                            class="badge bg-success-subtle text-success font-size-14">Customer</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary-subtle text-secondary font-size-14"></span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (!empty($user->country_code))
                                                        ({{ $user->country_code }})
                                                    @endif
                                                    {{ $user->mobile }}
                                                </td>

                                                <td>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('user-view', $user->id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="View" class="px-2 text-primary"><i
                                                                    class="bx bx-show font-size-18"></i></a>
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
            </div>
        </div>


        {{-- Active Users --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Active Users</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="fw-semibold">Year:</span>
                                        <span class="text-muted">{{ $year }} <i
                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @for ($y = date('Y'); $y >= date('Y') - 2; $y--)
                                            <a class="dropdown-item"
                                                href="{{ route('admin-dashboard', ['year' => $y, 'month' => $month]) }}">{{ $y }}</a>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-3">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="fw-semibold">Month:</span>
                                        <span class="text-muted">{{ $monthLabel }} <i
                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $index => $monthLabel)
                                            <a class="dropdown-item"
                                                href="{{ route('admin-dashboard', ['year' => $year, 'month' => $index + 1]) }}">
                                                {{ $monthLabel }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="active_users_chart" data-colors='["#246FC1"]' class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Recent Services --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-2" style="justify-content: space-between;">
                            <h5 class="card-title">Recent Services</h5>
                            <a href="/service-list" class="view-all ml-auto d-flex align-items-center">
                                View All
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-arrow-right ml-1">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-centered align-middle table-nowrap mb-0 table-check">
                                <thead>
                                    <tr>
                                        <th style="min-width: 16rem;">Service</th>
                                        <th style="min-width: 16rem;">Provider</th>
                                        {{-- <th style="min-width: 16rem;">Category</th> --}}
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($services->isEmpty())
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
                                                    No Services Available</p>
                                            </div>
                                        </td>
                                    @else
                                        @foreach ($services as $user)
                                            <tr>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                                        {{-- Service Image --}}
                                                        {{-- Service Image --}}
                                                        <div>
                                                            @if ($user->serviceImages->isNotEmpty())
                                                                <img src="{{ asset('images/service_images/' . $user->serviceImages->first()->service_images) }}"
                                                                    alt="Service Image"
                                                                    class="avatar rounded-circle img-thumbnail"
                                                                    style="min-width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                {{-- Default Avatar --}}
                                                                <div class="avatar rounded-circle img-thumbnail"
                                                                    style="background-color: #246FC1; color: #fff; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; height: 50px;">
                                                                    <span style="font-size: 1.2rem;">
                                                                        {{ strtoupper(substr($user->service_name, 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Service Details --}}
                                                        {{-- Service Details --}}
                                                        <div style="flex: 1;">
                                                            {{-- Service Name with link, highlight, and limit --}}
                                                            <div class="text-body">
                                                                <a href="{{ route('service-edit', $user->id) }}"
                                                                    style="color: #246FC1; text-decoration: none;">
                                                                    @php
                                                                        $originalServiceName =
                                                                            $user->service_name ?? '';
                                                                        $limitedServiceName = Str::limit(
                                                                            $originalServiceName,
                                                                            20,
                                                                        );

                                                                        $highlightedServiceName = $search
                                                                            ? preg_replace(
                                                                                '/(' . preg_quote($search, '/') . ')/i',
                                                                                '<mark>$1</mark>',
                                                                                $limitedServiceName,
                                                                            )
                                                                            : $limitedServiceName;
                                                                    @endphp

                                                                    {!! $highlightedServiceName !!}
                                                                </a>
                                                            </div>

                                                            {{-- Service Description --}}
                                                            <small class="text-muted d-block">
                                                                Price:
                                                                @if (!empty($user->service_discount_price))
                                                                    {{ $defaultCurrency }}{{ number_format($user->service_discount_price, 2) }}
                                                                @else
                                                                    {{ $defaultCurrency }}{{ number_format($user->service_price, 2) }}
                                                                @endif
                                                                | Duration:
                                                                @php
                                                                    $durationParts = explode(':', $user->duration);
                                                                    $hours = (int) $durationParts[0];
                                                                    $minutes = (int) $durationParts[1];

                                                                    $formattedDuration = '';

                                                                    if ($hours > 0) {
                                                                        $formattedDuration .=
                                                                            $hours . ' hour' . ($hours > 1 ? 's' : '');
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


                                                {{-- Vendor Details --}}
                                                {{-- Vendor Details --}}
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                                        @if ($user->vendor && $user->vendor->profile_pic)
                                                            <img src="{{ asset('images/user/' . $user->vendor->profile_pic) }}"
                                                                alt="Vendor Image"
                                                                class="avatar rounded-circle img-thumbnail"
                                                                style="min-width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            {{-- Default User Image --}}
                                                            <img src="{{ asset('images/user/default_provider.jpg') }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @endif

                                                        <div>
                                                            <div class="text-body d-flex align-items-center">
                                                                @if (!empty($user->v_id))
                                                                    <a href="{{ route('provider-view', $user->v_id) }}"
                                                                        style="color: #246FC1; text-decoration: none;">
                                                                        {{ $user->vendor->firstname ?? '' }}
                                                                        {{ $user->vendor->lastname ?? '' }}
                                                                    </a>
                                                                @else
                                                                    {{ $user->vendor->firstname ?? '' }}
                                                                    {{ $user->vendor->lastname ?? '' }}
                                                                @endif

                                                                {{-- Review beside name with black color --}}
                                                                <span class="ms-1 d-flex align-items-center"
                                                                    style="color: #000000;">
                                                                    <i class="bx bxs-star font-size-14 text-warning"></i>
                                                                    <span
                                                                        class="font-size-14">{{ $user->vendor->avg_provider_review ?? '0' }}</span>
                                                                </span>
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ $user->vendor->email ?? '' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>


                                                {{-- <td>{{ Str::limit($user->category->c_name ?? '', 20) }}</td> --}}


                                                <td>
                                                    @if ($user->service_discount_price && $user->service_discount_price > 0)
                                                        <span
                                                            style="text-decoration: line-through; color: red;">{{ $defaultCurrency . $user->service_price }}</span>
                                                        <span
                                                            style="color: green;">{{ $defaultCurrency . $user->service_discount_price }}</span>
                                                    @else
                                                        <span
                                                            style="color: green;">{{ $defaultCurrency . $user->service_price }}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('service-edit', $user->id) }}"
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
                </div>
            </div>


            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-2" style="justify-content: space-between;">
                            <h5 class="card-title">Recent Products</h5>
                            <a href="/product-list" class="view-all ml-auto d-flex align-items-center">
                                View All
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-arrow-right ml-1">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-centered align-middle table-nowrap mb-0 table-check">
                                <thead>
                                    <tr>
                                        <th style="min-width: 16rem;">Product</th>
                                        <th style="min-width: 16rem;">Provider</th>
                                        <th>Price</th>
                                        <th>Action</th>
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
                                                        <i class="bx bx-box" style="font-size: 2.5rem; color: #fff;"></i>
                                                    </div>
                                                    <p
                                                        style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                        No Product Found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($products as $user)
                                            <tr>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                                        {{-- Service Image --}}
                                                        {{-- Service Image --}}
                                                        <div>
                                                            @if ($user->productImages->isNotEmpty())
                                                                <img src="{{ asset('images/product_images/' . $user->productImages->first()->product_image) }}"
                                                                    alt="Product Image"
                                                                    class="avatar rounded-circle img-thumbnail"
                                                                    style="min-width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                {{-- Default Avatar --}}
                                                                <div class="avatar rounded-circle img-thumbnail"
                                                                    style="background-color: #246FC1; color: #fff; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; height: 50px;">
                                                                    <span style="font-size: 1.2rem;">
                                                                        {{ strtoupper(substr($user->product_name, 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Service Details --}}
                                                        <div style="flex: 1;">
                                                            {{-- Service Name with link, highlight, and limit --}}
                                                            <div class="text-body">
                                                                <a href="{{ route('product-edit', $user->product_id) }}"
                                                                    style="color: #246FC1; text-decoration: none;">
                                                                    @php
                                                                        $limitedName = Str::limit(
                                                                            $user->product_name ?? '',
                                                                            30,
                                                                        );
                                                                    @endphp

                                                                    {!! $search
                                                                        ? preg_replace('/(' . preg_quote($search, '/') . ')/i', '<mark>$1</mark>', $limitedName)
                                                                        : $limitedName !!}
                                                                </a>
                                                            </div>

                                                            {{-- Service Description --}}
                                                            <small class="text-muted d-block">
                                                                Price:
                                                                @if (!empty($user->product_discount_price))
                                                                    {{ $defaultCurrency }}{{ number_format($user->product_discount_price, 2) }}
                                                                @else
                                                                    {{ $defaultCurrency }}{{ number_format($user->product_price, 2) }}
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>


                                                {{-- Vendor Details --}}
                                                {{-- Vendor Details --}}
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                                        @if ($user->vendor && $user->vendor->profile_pic)
                                                            <img src="{{ asset('images/user/' . $user->vendor->profile_pic) }}"
                                                                alt="Vendor Image"
                                                                class="avatar rounded-circle img-thumbnail"
                                                                style="min-width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            {{-- Default User Image --}}
                                                            <img src="{{ asset('images/user/default_provider.jpg') }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @endif

                                                        <div>
                                                            <div class="text-body d-flex align-items-center">
                                                                @if (!empty($user->vid))
                                                                    <a href="{{ route('provider-view', $user->vid) }}"
                                                                        style="color: #246FC1; text-decoration: none;">
                                                                        {{ $user->vendor->firstname ?? '' }}
                                                                        {{ $user->vendor->lastname ?? '' }}
                                                                    </a>
                                                                @else
                                                                    {{ $user->vendor->firstname ?? '' }}
                                                                    {{ $user->vendor->lastname ?? '' }}
                                                                @endif

                                                                {{-- Review beside name with black color --}}
                                                                <span class="ms-1 d-flex align-items-center"
                                                                    style="color: #000000;">
                                                                    <i class="bx bxs-star font-size-14 text-warning"></i>
                                                                    <span
                                                                        class="font-size-14">{{ $user->vendor->avg_provider_review ?? '0' }}</span>
                                                                </span>
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ $user->vendor->email ?? '' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>



                                                <td>
                                                    @if ($user->product_discount_price && $user->product_discount_price > 0)
                                                        <span
                                                            style="text-decoration: line-through; color: red;">{{ $defaultCurrency . $user->product_price }}</span>
                                                        <span
                                                            style="color: green;">{{ $defaultCurrency . $user->product_discount_price }}</span>
                                                    @else
                                                        <span
                                                            style="color: green;">{{ $defaultCurrency . $user->product_price }}</span>
                                                    @endif
                                                </td>


                                                <td>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('product-edit', $user->product_id) }}"
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
                </div>
            </div>
        </div>


    @endsection

    @section('scripts')
        <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            var servicePayments = @json($serviceData);
            var productPayments = @json($productData);
            var defaultCurrency = @json($defaultCurrency);
            var daysInMonth = @json($daysInMonth);
            var days =
                @json($days); // These will be the days in the selected month (e.g., '1 May', '2 May', etc.)



            function getChartColorsArray(chartId) {
                if (document.getElementById(chartId) !== null) {
                    var colors = document.getElementById(chartId).getAttribute("data-colors");
                    colors = JSON.parse(colors);
                    return colors.map(function(value) {
                        var newValue = value.replace(" ", "");
                        if (newValue.indexOf("--") != -1) {
                            var color = getComputedStyle(document.documentElement).getPropertyValue(
                                newValue
                            );
                            if (color) return color;
                        } else {
                            return newValue;
                        }
                    });
                }
            }


            var barchartColors = getChartColorsArray("sales-report");
            var options1 = {
                chart: {
                    type: 'area',
                    height: 500,
                    toolbar: {
                        show: false
                    },
                },
                series: [{
                        name: 'Service Bookings',
                        data: servicePayments
                    },
                    {
                        name: 'Product Bookings',
                        data: productPayments
                    }
                ],
                stroke: {
                    curve: 'straight',
                    width: ['4', '4'],
                },
                grid: {
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                },
                colors: barchartColors,
                xaxis: {
                    categories: days.map(function(day) {
                        // Format each day as "1 Jan", "2 Jan", etc.
                        const date = new Date(day);
                        const options = {
                            day: 'numeric',
                            month: 'short'
                        };
                        return date.toLocaleDateString('en-GB', options); // 'en-GB' for "1 Jan" format
                    }),
                },

                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return `${defaultCurrency} ${value.toLocaleString()}`;
                        }
                    }
                },
                legend: {
                    show: false,
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.40,
                        opacityTo: 0.1,
                        stops: [30, 100, 100, 100]
                    },
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: true,
                        formatter: function(value, opts) {
                            return options1.xaxis.categories[opts.dataPointIndex];
                        }
                    },
                    y: {
                        title: {
                            formatter: function(seriesName) {
                                return seriesName + ": ";
                            }
                        },
                        formatter: function(value) {
                            return `${defaultCurrency}${value.toLocaleString()}`;
                        }
                    },
                    marker: {
                        show: true
                    }
                }
            };

            new ApexCharts(document.querySelector("#sales-report"), options1).render();





            var activeUsersChartColors = ["#27AF4D", "#FF4B4B",
                "#247BC1"
            ]; // Blue for users, Orange for handymen, Red for providers

            var activeUsersOptions = {
                series: [{
                        name: "Providers",
                        data: @json($providerData)
                    },
                    {
                        name: "Handyman",
                        data: @json($handymanData)
                    },
                    {
                        name: "Customers",
                        data: @json($activeUserData)
                    }
                ],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                markers: {
                    size: 4,
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                colors: activeUsersChartColors,
                xaxis: {
                    categories: @json($days),
                    title: {
                        text: "Days of the Month"
                    },
                    labels: {
                        formatter: function(value) {
                            if (!value) return ""; // Prevents errors if value is undefined or empty

                            var parts = value.toString().split(" "); // Ensure it's a string before splitting
                            if (parts.length < 2) return value; // If the format is incorrect, return as is

                            return parts[1] + " " + parts[0].slice(0, 3); // Converts "February 1" to "1 Feb"
                        }
                    }
                },

                yaxis: {
                    title: {
                        text: "Active Users"
                    },
                    forceNiceScale: true, // Ensures the scale is evenly distributed
                    labels: {
                        formatter: function(val) {
                            return Math.round(val); // Convert floating numbers to whole numbers
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                }
            };

            var activeUsersChart = new ApexCharts(document.querySelector("#active_users_chart"), activeUsersOptions);
            activeUsersChart.render();
        </script>




        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var totalServicesCount = @json($totalServicesCount);
                var totalProductsCount = @json($totalProductsCount);

                var options = {
                    series: [totalServicesCount, totalProductsCount], // Dynamic data
                    chart: {
                        height: 350,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            dataLabels: {
                                name: {
                                    fontSize: '22px',
                                },
                                value: {
                                    fontSize: '16px',
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                }
                            }
                        }
                    },
                    labels: ['Service', 'Product']
                };

                var chart = new ApexCharts(document.querySelector("#chart-radialBar"), options);
                chart.render();
            });
        </script>
    @endsection
