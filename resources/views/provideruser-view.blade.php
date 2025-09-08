@extends('layouts.master')

@section('title')
View User
@endsection

@section('page-title')
View User
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
                <h5 class="card-title"> View User <span class="text-muted fw-normal ms-2"></span>
                </h5>
                <p class="text-muted">User / View User</p>
            </div>
        </div>

        <div class="col-3 text-end">
            <a href="/provider-dashboard" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Overall User Data</h4>
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
                                                    <h5 class="card-title">User Details</h5>
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
                                                            style="border-radius: 50%; width: 192px; height: 150px; object-fit: cover;">
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-md-7">

                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary font-size-10 text-uppercase ls-05">
                                                        User
                                                    </span>

                                                    <h5 class="mt-2 font-size-16">
                                                        <div class="text-body">
                                                            {{ $user->firstname . ' ' . $user->lastname }}
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


                        {{-- Booked Services List --}}
                        <div class="tab-pane" id="providerpayoutlist" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="color: #ffff;">Order Id</th>
                                            <th scope="col" style="min-width: 16rem; color: #ffff;">Booking Date</th>
                                            <th scope="col" style="min-width: 16rem; color: #ffff;">User</th>
                                            <th scope="col" style="min-width: 16rem; color: #ffff;">Provider</th>
                                            <th scope="col" style="color: #ffff;">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $user)
                                        <tr>

                                            <td>
                                                <a href="{{ route('providerbooking-view', $user->id) }}"
                                                    style="color: #246FC1;">
                                                    #{{ $user->id }}
                                                </a>
                                            </td>

                                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y / h:i A') }}
                                            </td>

                                            <td>
                                                <div style="display: flex; align-items: center;">
                                                    <div>
                                                        {{-- User Image --}}
                                                        @if ($user->user && $user->user->profile_pic)
                                                        <img src="{{ asset('images/user/' . $user->user->profile_pic) }}"
                                                            class="avatar rounded-circle img-thumbnail me-2">
                                                        @else
                                                        {{-- Default Avatar --}}
                                                        <span class="avatar rounded-circle img-thumbnail me-2"
                                                            style="background-color: #ddd; color: #fff; display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px;">
                                                            {{ $user->user ? strtoupper(substr($user->user->firstname . ' ' . $user->user->lastname, 0, 1)) : '?' }}
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <div
                                                        style="display: flex; flex-direction: column; width: fit-content;">
                                                        {{-- User Full Name --}}
                                                        @if ($user->user)
                                                        <div class="text-body">
                                                            <a href="{{ route('provideruser-view', $user->user_id) }}"
                                                                style="color: #246FC1;">
                                                                {{ $user->user->firstname }}
                                                                {{ $user->user->lastname }}
                                                            </a>
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ $user->user->email ?? '' }}
                                                        </small>
                                                        @else
                                                        <div class="text-body"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div style="display: flex; align-items: center;">
                                                    <div>
                                                        {{-- Provider Image from cart_items --}}
                                                        @if (
                                                        $user->cartItems &&
                                                        $user->cartItems->first() &&
                                                        $user->cartItems->first()->provider &&
                                                        $user->cartItems->first()->provider->profile_pic)
                                                        <img src="{{ asset('images/user/' . $user->cartItems->first()->provider->profile_pic) }}"
                                                            class="avatar rounded-circle img-thumbnail me-2">
                                                        @else
                                                        {{-- Default Avatar --}}
                                                        <span class="avatar rounded-circle img-thumbnail me-2"
                                                            style="background-color: #ddd; color: #fff; display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px;">
                                                            {{ $user->cartItems && $user->cartItems->first() && $user->cartItems->first()->provider
                                                                            ? strtoupper(
                                                                                substr(
                                                                                    $user->cartItems->first()->provider->firstname . ' ' . $user->cartItems->first()->provider->lastname,
                                                                                    0,
                                                                                    1,
                                                                                ),
                                                                            )
                                                                            : '?' }}
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <div
                                                        style="display: flex; flex-direction: column; width: fit-content;">
                                                        {{-- Provider Full Name from cart_items --}}
                                                        @if ($user->cartItems && $user->cartItems->first() && $user->cartItems->first()->provider)
                                                        <div class="text-body">
                                                            <div>
                                                                {{ $user->cartItems->first()->provider->firstname }}
                                                                {{ $user->cartItems->first()->provider->lastname }}
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ $user->cartItems->first()->provider->email ?? '' }}
                                                        </small>
                                                        @else
                                                        <div class="text-body">No Provider Assigned</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $defaultCurrency }}{{ number_format($user->total, 2) }}</td>

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No orders found for this user.
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
