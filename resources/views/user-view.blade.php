@extends('layouts.master')

@section('title')
    Customer Information
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
                    <h5 class="card-title"> Customer Information <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Customers / Customer Information</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/user-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>

        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Overall Customer Information</h4>
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
                                <a class="nav-link" data-bs-toggle="tab" href="#userreview" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Reviews</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#providerpayoutlist" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Booked Services</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">

                            {{-- User Overview --}}
                            <div class="tab-pane active" id="overviewprovider" role="tabpanel">
                                <div class="row">

                                    {{-- All The Cards --}}
                                    <div class="col-xl-6">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar">
                                                                    <div class="avatar-title rounded bg-primary-subtle">
                                                                        <i
                                                                            class="bx bx-calendar font-size-24 mb-0 text-primary"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0 font-size-15">Total Booking</h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">{{ $totalBooking }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-0 text-truncate">Total
                                                                            Service and Product Booking</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar">
                                                                    <div class="avatar-title rounded bg-primary-subtle">
                                                                        <i
                                                                            class="bx bx-wallet font-size-24 mb-0 text-primary"></i>

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
                                                                        <p class="text-muted mb-0 text-truncate">Total
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
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar">
                                                                    <div class="avatar-title rounded bg-primary-subtle">
                                                                        <i
                                                                            class="bx bx-heart font-size-24 mb-0 text-primary"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0 font-size-15">Total Likes</h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $totallikes }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-0 text-truncate">Total
                                                                            Likes</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar">
                                                                    <div class="avatar-title rounded bg-primary-subtle">
                                                                        <i
                                                                            class="bx bx-comment font-size-24 mb-0 text-primary"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0 font-size-15">Total Reviews</h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $totalreviews }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-0 text-truncate">Total
                                                                            Reviews</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- User Details --}}
                                    <div class="col-xl-6">

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start mb-2">
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title">Customer Details</h5>
                                                    </div>
                                                </div>

                                                <div class="row align-items-center">
                                                    <div class="col-md-5">
                                                        <div class="popular-product-img p-2">
                                                            @if ($user->profile_pic)
                                                                <img src="{{ asset('images/user/' . $user->profile_pic) }}"
                                                                    alt=""
                                                                    style="border-radius: 50%; width: 160px; height: 150px; object-fit: cover;">
                                                            @else
                                                                <img src="{{ asset('images/user/default_user.jpg') }}"
                                                                    alt=""
                                                                    style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover;">
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="col-md-7">

                                                        <span
                                                            class="badge bg-success-subtle text-success font-size-10 text-uppercase ls-05">
                                                            Customer
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Review Table --}}
                            <div class="tab-pane" id="userreview" role="tabpanel">
                                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="color: #fff; min-width: 16rem;">Handyman</th>
                                                <th scope="col" style="color: #fff;">Date</th>
                                                <th scope="col" style="color: #fff;">Review</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($latestCustomersofUser as $review)
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
                                                                    <img src="{{ asset('images/user/default_handyman.jpg') }}"
                                                                        class="avatar rounded-circle img-thumbnail me-2">
                                                                @endif
                                                            </div>

                                                            <div
                                                                style="display: flex; flex-direction: column; width: fit-content;">
                                                                <div style="display: flex; align-items: center;">
                                                                    <a href="{{ route('handyman-view', $review['id']) }}"
                                                                        style="color: #246FC1; margin-right: 5px;">
                                                                        {{ $review['firstname'] }}
                                                                        {{ Str::limit($review['lastname'], 20) }}
                                                                    </a>
                                                                    <span class="d-flex align-items-center"
                                                                        style="color: #000000;">
                                                                        <i
                                                                            class="bx bxs-star font-size-14 text-warning"></i>
                                                                        <span class="font-size-14">
                                                                            {{ $review['avg_handyman_review'] ?? '0' }}
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
                                                                    class="{{ $i <= $review['rev_star'] ? 'fas' : 'far' }} fa-star text-warning"></i>
                                                            @endfor
                                                            <div>{{ $review['rev_text'] }}</div>
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


                            {{-- Booked Services List --}}
                            <div class="tab-pane" id="providerpayoutlist" role="tabpanel">
                                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="color: #ffff;">Booking Id</th>
                                                <th scope="col" style="min-width: 16rem; color: #ffff;">Booking Date
                                                </th>
                                                <th scope="col" style="color: #ffff;">Total Amount</th>
                                                <th scope="col" style="color: #ffff;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders as $user)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('booking-view', $user->id) }}"
                                                            style="color: #246FC1;">
                                                            #{{ $user->id }}
                                                        </a>
                                                    </td>

                                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y / h:i A') }}
                                                    </td>

                                                    <td>{{ $defaultCurrency }}{{ number_format($user->total, 2) }}</td>

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
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">
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
                                            @endforelse
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
    @endsection
