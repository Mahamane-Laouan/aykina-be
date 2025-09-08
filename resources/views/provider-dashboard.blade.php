@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@php
    $user = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $user->firstname }} {{ $user->lastname }}
@endsection

@section('body')

    <body>
    @endsection
    @section('content')
        
        {{-- Cards --}}
        <div class="row">
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
                        <a href="/providerservice-list" style="text-decoration: none;">
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
                        <a href="/providerproduct-list" style="text-decoration: none;">
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
                        <a href="/providerbooking-list" style="text-decoration: none;">
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
                        <a href="/providerhandyman-list" style="text-decoration: none;">
                            <div class="card" style="background-color: #E9D5FA; border: none; color: black;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-size-15">Total Handyman</h6>
                                            <h4 class="mt-3 pt-1 mb-0 font-size-22">
                                                {{ $totalHandyman }}
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
                        <a href="/faq-list" style="text-decoration: none;">
                            <div class="card" style="background-color: #CCEEFF; border: none; color: black;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-size-15">Total FAQ's</h6>
                                            <h4 class="mt-3 pt-1 mb-0 font-size-22">
                                                {{ $totalFaqs }}
                                            </h4>
                                        </div>
                                        <div class="">
                                            <div class="avatar">
                                                <div class="avatar-title rounded" style="background-color: #00A8FF;">
                                                    <i class="bx bx-question-mark  font-size-24 mb-0"
                                                        style="color: white;"></i>
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
                <div class="card" style="height: 24rem;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Booking Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <a href="/providerpending-bookinglist" style="text-decoration: none;">
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
                                <a href="/provideraccepted-bookinglist" style="text-decoration: none;">
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
                                <a href="/providerrejected-bookinglist" style="text-decoration: none;">
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
                                <a href="/providerhold-bookinglist" style="text-decoration: none;">

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
                                <a href="/providerinprogress-bookinglist" style="text-decoration: none;">
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
                                <a href="/providercompleted-bookinglist" style="text-decoration: none;">
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
                                <a href="/providercancelled-bookinglist" style="text-decoration: none;">
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
        <div class="row">
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
                                                href="{{ route('provider-dashboard', ['year' => $y]) }}">{{ $y }}</a>
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
        </div>



        {{-- Recent Service Orders & Product Orders --}}
        <div class="row">

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-2" style="justify-content: space-between;">
                            <h5 class="card-title">Recent Orders</h5>
                            <a href="/providerbooking-list" class="view-all ml-auto d-flex align-items-center">
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

                                                        <div style="display: flex; flex-direction: column; width: fit-content;">
            {{-- User Full Name with Review --}}
            @if ($user->user)
                <div class="text-body" style="display: flex; align-items: center;">
                    <div>
                        {{ $user->user->firstname }}
                        {{ Str::limit($user->user->lastname ?? '', 20) }}
                    </div>
                    
                    {{-- Review beside name --}}
                    <span class="ms-1 d-flex align-items-center" style="color: #000000;">
                        <i class="bx bxs-star font-size-14 text-warning"></i>
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
                                                href="{{ route('provider-dashboard', ['year' => $y, 'month' => $month]) }}">{{ $y }}</a>
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
                                                <a href="/providerservice-list" class="text-dark">Service</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0">
                                                {{ $totalServicesCount }} Counts
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="/providerservice-list" class="btn btn-primary btn-sm">View</a>
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
                                                <a href="/providerproduct-list" class="text-dark">Product</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0">
                                                {{ $totalProductsCount }} Counts
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="/providerproduct-list" class="btn btn-success btn-sm">View</a>
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
        <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            // Stacked Area Charts
            var servicePayments = @json($serviceData); // Updated
            var productPayments = @json($productData); // Updated
            var defaultCurrency = @json($defaultCurrency);



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


            // Stacked Area Charts
            var barchartColors = getChartColorsArray("sales-report");
            var options1 = {
                chart: {
                    type: 'area',
                    height: 360,
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
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return `${defaultCurrency} ${value.toLocaleString()}`; // Add the currency symbol to Y-axis labels
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
                            // Return the corresponding month name from the categories array
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
