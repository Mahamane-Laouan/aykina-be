@extends('layouts.master')
@section('title')
    Booking Information
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<style>
    .select2-container--default .select2-selection--multiple {
        min-height: 39px !important;
        border-radius: 9px !important;
        border: 1px solid #EFF0F2 !important;
    }

    .choices__inner {
        display: inline-block !important;
        vertical-align: top !important;
        width: 100% !important;
        border: 1px solid #eff0f2 !important;
        background-color: #ffff !important;
        border-radius: 9.5px !important;
        font-size: 14px !important;
        min-height: 44px !important;
        overflow: hidden !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #246FC1 !important;
        color: #fff !important;
    }


    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff !important;
    }
</style>

@section('page-title')
    Booking Information
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
                    <h5 class="card-title"> Overview Booking Information <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Bookings / Booking Information</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/providerbooking-list" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="row">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            {{-- Booking details --}}
            <div class="col-xxl-3">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="user-profile-img">
                            <img src="{{ URL::asset('images/logo/orderback.jpg') }}"
                                class="profile-img profile-foreground-img rounded-top" style="height: 120px;"
                                alt="">
                            <div class="overlay-content rounded-top">
                                <div>
                                    <div class="user-nav p-3">
                                        <div class="d-flex justify-content-end">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end user-profile-img -->


                        <div class="p-4 pt-0">

                            <div class="mt-n5 position-relative text-center border-bottom pb-3">
                                <img src="{{ URL::asset('images/logo/orderlogo.jpg') }}" alt=""
                                    class="avatar-xl rounded-circle img-thumbnail">

                                <div class="mt-3">
                                    <h5 class="mb-2" style="font-weight: bold;">Booking Details</h5>
                                    <p style="margin: 0; color: #6c757d;">
                                        <span style="font-weight: bold;">Order ID:</span> #{{ $data->id }}
                                    </p>
                                </div>

                            </div>

                            <div class="table-responsive mt-3 border-bottom pb-3" style="overflow: hidden;">
                                <table
                                    class="table align-middle table-sm table-nowrap table-borderless table-centered mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="fw-bold" style="font-size: 15px;">
                                                Booking Placed :</th>
                                            <td class="text-muted" style="font-size: 13px;">
                                                {{ $data->created_at->format('d M, Y / h:i A') }}
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="fw-bold" style="font-size: 15px;">
                                                Booking Date :</th>
                                            <td class="text-muted" style="font-size: 13px;">
                                                {{ $data->created_at->format('d M, Y / h:i A') }}
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="fw-bold" style="font-size: 15px;">
                                                Total Amount :</th>
                                            <td class="text-muted" style="font-size: 13px;">
                                                {{ $defaultCurrency }}{{ $data->total ?? '' }}</td>
                                        </tr>

                                        <tr>
                                            <th class="fw-bold" style="font-size: 15px;">Payment Method :</th>
                                            <td class="text-muted" style="font-size: 13px;">
                                                @if ($data->payment_mode == 'paypal')
                                                    <span class="badge bg-dark text-white font-size-13">PayPal</span>
                                                @elseif($data->payment_mode == 'wallet')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning font-size-13">Wallet</span>
                                                @elseif($data->payment_mode == 'google pay')
                                                    <span class="badge bg-info-subtle text-info font-size-13">Google
                                                        Pay</span>
                                                @elseif($data->payment_mode == 'stripe')
                                                    <span
                                                        class="badge bg-primary-subtle text-primary font-size-13">Stripe</span>
                                                @elseif($data->payment_mode == 'razor pay')
                                                    <span class="badge bg-danger-subtle text-danger font-size-13">Razor
                                                        Pay</span>
                                                @elseif($data->payment_mode == 'flutter wave')
                                                    <span class="badge bg-success-subtle text-success font-size-13">Flutter
                                                        Wave</span>
                                                @elseif($data->payment_mode == 'apple pay')
                                                    <span class="badge bg-secondary text-white font-size-13">Apple
                                                        Pay</span>
                                                @else
                                                
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="fw-bold" style="font-size: 15px;">Payment Status :</th>
                                            <td class="text-muted" style="font-size: 13px;">
                                                <span class="badge bg-success-subtle text-success font-size-14">
                                                    Paid
                                                </span>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>

                            @if (!$assignedHandyman)
                                <div class="pt-2 text-center border-bottom pb-4" style="margin-top: 12px;">
                                    <a href="#" class="btn btn-primary waves-effect waves-light btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#assignHandymanModal">
                                        Assign Handyman <i class="bx bx-send ms-1 align-middle"></i>
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-9">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#overview" role="tab">
                                    <span>Overview</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                    <span>Booking Status</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tab content -->
                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="text-muted">
                                            <h5 class="font-size-16 mb-3">Billed To:</h5>
                                            @if ($data->cartItems->isNotEmpty())
                                                @php
                                                    $cartItem = $data->cartItems->first(); // Get the first cart item
                                                @endphp
                                                @if ($cartItem->userAddress)
                                                    <h5 class="font-size-15 mb-2">{{ $cartItem->userAddress->full_name }}
                                                    </h5>
                                                    <p class="mb-1">{{ $cartItem->userAddress->address }}</p>
                                                    <p class="mb-1">{{ $cartItem->userAddress->landmark }}</p>
                                                    <p class="mb-1">{{ $cartItem->userAddress->city }},
                                                        {{ $cartItem->userAddress->state }} -
                                                        {{ $cartItem->userAddress->zip_code }}
                                                    </p>
                                                    <p class="mb-1">{{ $cartItem->userAddress->country }}</p>
                                                    <p>{{ $cartItem->userAddress->phone }}</p>
                                                @else
                                                    <p class="mb-1">No address available.</p>
                                                @endif
                                            @else
                                                <p class="mb-1">No address available.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- end col -->
                                    <div class="col-sm-6">
                                        <div class="text-muted text-sm-end">
                                            <div>
                                                <span class="badge bg-success-subtle text-success font-size-14">
                                                    Paid
                                                </span>
                                            </div>
                                            <div class="mt-4">
                                                <h5 class="font-size-15 mb-1">Order Id:</h5>
                                                <p>#{{ $data->id }}</p>
                                            </div>
                                            <div class="mt-4">
                                                <h5 class="font-size-15 mb-1">Order Date:</h5>
                                                <p>{{ $data->created_at->format('d M, Y / h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="py-2">
                                    <h5 class="font-size-15">Order Summary</h5>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold" style="width: 70px;">No.</th>
                                                    <th class="fw-bold">Item</th>
                                                    <th class="fw-bold">Price</th>
                                                    <th class="fw-bold">Quantity</th>
                                                    <th class="text-end fw-bold" style="width: 120px;">Total</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                @if ($data->cartItems->isNotEmpty())
                                                    @foreach ($data->cartItems as $cartItem)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>
                                                                <div>
                                                                    <h5 class="text-truncate font-size-14 mb-1">
                                                                        @if ($cartItem->type == 'Product')
                                                                            {{ $cartItem->productDetails->product_name }}
                                                                            <span
                                                                                class="badge bg-danger-subtle text-danger font-size-13">Product</span>
                                                                            @if (isset($cartItem->handymanStatus))
                                                                                @switch($cartItem->handymanStatus)
                                                                                    @case(0)
                                                                                        <span
                                                                                            class="badge bg-warning text-white font-size-13">Pending
                                                                                        </span>
                                                                                    @break

                                                                                    @case(1)
                                                                                        <span
                                                                                            class="badge bg-primary text-white font-size-13">Provider
                                                                                            Accepted</span>
                                                                                    @break

                                                                                    @case(2)
                                                                                        <span
                                                                                            class="badge bg-primary text-white font-size-13">
                                                                                            Accepted</span>
                                                                                    @break

                                                                                    @case(3)
                                                                                        <span
                                                                                            class="badge bg-danger text-white font-size-13">
                                                                                            Rejected</span>
                                                                                    @break

                                                                                    @case(4)
                                                                                        <span
                                                                                            class="badge bg-info text-white font-size-13">In
                                                                                            Progress</span>
                                                                                    @break

                                                                                    @case(5)
                                                                                        <span
                                                                                            class="badge bg-danger text-white font-size-13">Provider
                                                                                            Rejected</span>
                                                                                    @break

                                                                                    @case(6)
                                                                                        <span
                                                                                            class="badge bg-success text-white font-size-13">Completed</span>
                                                                                    @break

                                                                                    @case(7)
                                                                                        <span
                                                                                            class="badge bg-dark text-white font-size-13">Hold</span>
                                                                                    @break

                                                                                    @case(8)
                                                                                        <span
                                                                                            class="badge bg-secondary text-white font-size-13">Cancelled</span>
                                                                                    @break

                                                                                    @case(9)
                                                                                        <span
                                                                                            class="badge bg-info text-white font-size-13">Provider
                                                                                            In
                                                                                            Progress</span>
                                                                                    @break

                                                                                    @case(10)
                                                                                        <span
                                                                                            class="badge bg-success text-white font-size-13">Provider
                                                                                            Delivered</span>
                                                                                    @break

                                                                                    @case(11)
                                                                                        <span
                                                                                            class="badge bg-secondary text-white font-size-13">User
                                                                                            Cancel
                                                                                            Order</span>
                                                                                        <!-- Same as "Provider Delivered" -->
                                                                                    @break

                                                                                    @default
                                                                                @endswitch
                                                                            @endif
                                                                        @elseif ($cartItem->type == 'Service')
                                                                            {{ $cartItem->serviceDetails->service_name }}
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary font-size-13">Service</span>
                                                                            @if (isset($cartItem->handymanStatus))
                                                                                @switch($cartItem->handymanStatus)
                                                                                     @case(0)
                                                                                        <span
                                                                                            class="badge bg-warning text-white font-size-13">Pending</span>
                                                                                    @break

                                                                                    @case(1)
                                                                                        <span
                                                                                            class="badge bg-primary text-white font-size-13">Provider
                                                                                            Accepted</span>
                                                                                    @break

                                                                                    @case(2)
                                                                                        <span
                                                                                            class="badge bg-primary text-white font-size-13">
                                                                                            Accepted</span>
                                                                                    @break

                                                                                    @case(3)
                                                                                        <span
                                                                                            class="badge bg-danger text-white font-size-13">
                                                                                            Rejected</span>
                                                                                    @break

                                                                                    @case(4)
                                                                                        <span
                                                                                            class="badge bg-info text-white font-size-13">In
                                                                                            Progress</span>
                                                                                    @break

                                                                                    @case(5)
                                                                                        <span
                                                                                            class="badge bg-danger text-white font-size-13">Provider
                                                                                            Rejected</span>
                                                                                    @break

                                                                                    @case(6)
                                                                                        <span
                                                                                            class="badge bg-success text-white font-size-13">Completed</span>
                                                                                    @break

                                                                                    @case(7)
                                                                                        <span
                                                                                            class="badge bg-dark text-white font-size-13">Hold</span>
                                                                                    @break

                                                                                    @case(8)
                                                                                        <span
                                                                                            class="badge bg-seondary text-white font-size-13">Cancelled</span>
                                                                                    @break

                                                                                    @case(9)
                                                                                        <span
                                                                                            class="badge bg-info text-white font-size-13">Provider
                                                                                            In
                                                                                            Progress</span>
                                                                                    @break

                                                                                    @case(10)
                                                                                        <span
                                                                                            class="badge bg-success text-white font-size-13">Completed</span>
                                                                                    @break

                                                                                    @case(11)
                                                                                        <span
                                                                                            class="badge bg-secondary text-white font-size-13">User
                                                                                            Cancel
                                                                                            Order</span>
                                                                                    @break

                                                                                    @default
                                                                                @endswitch
                                                                            @endif
                                                                        @endif
                                                                    </h5>

                                                                    <p class="text-muted mb-0">
                                                                        @if ($cartItem->type == 'Product')
                                                                            {{ \Illuminate\Support\Str::limit($cartItem->productDetails->product_description ?? '', 50) }}
                                                                        @elseif ($cartItem->type == 'Service')
                                                                            {{ \Illuminate\Support\Str::limit($cartItem->serviceDetails->service_description ?? '', 50) }}
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if ($cartItem->type == 'Product')
                                                                    {{ $defaultCurrency }}{{ number_format($cartItem->price, 2) }}
                                                                @elseif ($cartItem->type == 'Service')
                                                                    {{ $defaultCurrency }}{{ number_format($cartItem->price, 2) }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $cartItem->quantity }}</td>
                                                            <td class="text-end">
                                                                {{ $defaultCurrency }}{{ number_format($cartItem->price * $cartItem->quantity, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center">No items to display</td>
                                                    </tr>
                                                @endif


                                                <!-- end tr -->
                                                <tr>
                                                    <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                        Sub Total :
                                                    </th>
                                                    <td class="border-0 text-end">
                                                        {{ $defaultCurrency }}{{ $data->sub_total ?? 0 }}</td>
                                                </tr>
                                                <!-- end tr -->
                                                <tr>
                                                    <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                        Discount :</th>
                                                    <td class="border-0 text-end">-
                                                        {{ $defaultCurrency }}{{ $data->coupon ?? 0 }}</td>
                                                </tr>
                                                <!-- end tr -->
                                                <tr>
                                                    <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                        Shipping Charge :</th>
                                                    <td class="border-0 text-end">
                                                        {{ $defaultCurrency }}{{ $data->shipping_charge ?? 0 }}</td>
                                                </tr>
                                                <!-- end tr -->
                                                <tr>
                                                    <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                        Tax :</th>
                                                    <td class="border-0 text-end">
                                                        {{ $defaultCurrency }}{{ $data->tax ?? 0 }}</td>
                                                </tr>
                                                <!-- end tr -->
                                                <tr>
                                                    <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                        Total :</th>
                                                    <td class="border-0 text-end">
                                                        <h4 class="m-0 fw-semibold">
                                                            {{ $defaultCurrency }}{{ $data->total ?? 0 }}</h4>
                                                    </td>
                                                </tr>
                                                <!-- end tr -->
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->
                                    {{-- <div class="d-print-none mt-4">
                                        <div class="float-end">
                                            <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                                    class="fa fa-print"></i></a>
                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Booking Status TimeLine --}}
                    <div class="tab-pane" id="messages" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-xl-10">
                                        <div class="timeline">
                                            <div class="timeline-container">
                                                <!-- Show only if there is data in $allStatus -->
                                                @if (!empty($allStatus))
                                                    <div class="timeline-end">
                                                        <p>Start</p>
                                                    </div>
                                                    <div class="timeline-continue">
                                                        @foreach ($allStatus as $index => $status)
                                                            <div
                                                                class="row {{ $index % 2 === 0 ? 'timeline-right' : 'timeline-left' }}">
                                                                <div
                                                                    class="col-md-6 {{ $index % 2 === 1 ? 'd-md-none d-block' : '' }}">
                                                                    <div class="timeline-icon">
                                                                        <!-- Icon space left for future enhancement -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="timeline-box">
                                                                        <div
                                                                            class="timeline-date text-center rounded bg-primary">
                                                                            <h3 class="text-white mb-0 font-size-20">
                                                                                {{ \Carbon\Carbon::parse($status['date'])->format('d') }}
                                                                            </h3>
                                                                            <p class="mb-0 text-white-50">
                                                                                {{ \Carbon\Carbon::parse($status['date'])->format('M') }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="event-content">
                                                                            <div class="timeline-text">
                                                                                <h3 class="font-size-17">
                                                                                    {{ $status['title'] }}
                                                                                </h3>
                                                                                <p class="mb-0 mt-2 pt-1 text-muted">
                                                                                    {{ $status['message'] }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-6 {{ $index % 2 === 0 ? 'd-md-none d-block' : '' }}">
                                                                    <div class="timeline-icon">
                                                                        <!-- Icon space left for future enhancement -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if ($allStatus[array_key_last($allStatus)]['last_status'] == 1)
                                                        <div class="timeline-start">
                                                            <p>End</p>
                                                        </div>
                                                        <div class="timeline-launch">
                                                            <div class="timeline-box">
                                                                <div class="timeline-text">
                                                                    <h3 class="font-size-17">
                                                                        Order Completed on
                                                                        {{ \Carbon\Carbon::parse($allStatus[array_key_last($allStatus)]['date'])->format('d M, Y') }}
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="text-center">
                                                        <p>No booking status found.</p>
                                                    </div>
                                                @endif
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
        <!-- end row -->


        {{-- Users Cards --}}
        <div class="row mt-2">
            {{-- User --}}
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <!-- Display the user's profile picture or first letter of the first name -->
                                @if ($data->user->profile_pic)
                                    <img src="{{ URL::asset('images/user/' . $data->user->profile_pic) }}"
                                        alt="User Avatar" class="avatar-md rounded-circle img-thumbnail">
                                @else
                                    {{-- Default User Image --}}
                                        <img src="{{ asset('images/user/default_user.jpg') }}"
                                            class="avatar rounded-circle img-thumbnail me-2"
                                            style="height: 56px; width:56px;">
                                @endif
                            </div>
                            <div class="flex-1 ms-3">
                                <!-- Display the user's full name -->
                                <h5 class="font-size-16 mb-1">
                                    <div class="text-body">{{ $data->user->firstname }}
                                        {{ $data->user->lastname }}</div>
                                </h5>
                                <!-- Display user role, if available -->
                                <span
                                    class="badge bg-success-subtle text-success mb-0">{{ $data->user->role ?? 'User' }}</span>
                            </div>
                        </div>

                        <div class="mt-3 pt-1">
                            <!-- Display user phone, email, and address -->
                            <p class="mb-0">
                                <i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                ({{ $data->user->country_code ?? '' }}) {{ $data->user->mobile ?? 'No phone available' }}
                            </p>

                            <p class="mb-0 mt-2">
                                <i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                {{ $data->user->email ?? 'No email available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Provider --}}
            @if (isset($cartItem->provider) && $cartItem->provider)
                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    @if (isset($cartItem->provider) && $cartItem->provider->profile_pic)
                                        <!-- Display profile image if available -->
                                        <img src="{{ URL::asset('images/user/' . $cartItem->provider->profile_pic) }}"
                                            alt="Provider Avatar" class="avatar-md rounded-circle img-thumbnail">
                                    @else
                                        {{-- Default User Image --}}
                                        <img src="{{ asset('images/user/default_provider.jpg') }}"
                                            class="avatar rounded-circle img-thumbnail me-2"
                                            style="height: 56px; width:56px;">
                                    @endif
                                </div>
                                <div class="flex-1 ms-3">
                                    <!-- Check if provider exists before displaying the name -->
                                    <h5 class="font-size-16 mb-1">
                                        <div class="text-body">
                                            {{ $cartItem->provider->firstname ?? '' }}
                                            {{ $cartItem->provider->lastname ?? '' }}
                                        </div>
                                    </h5>
                                    <!-- Display provider role if available -->
                                    <span class="badge bg-primary-subtle text-primary mb-0">
                                        {{ $cartItem->provider->role ?? 'Provider' }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-3 pt-1">
                                <!-- Check if provider exists before displaying the phone number -->
                                <p class="mb-0">
                                    <i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                    ({{ $cartItem->provider->country_code ?? '' }})
                                    {{ $cartItem->provider->mobile ?? 'No phone available' }}
                                </p>

                                <p class="mb-0 mt-2">
                                    <i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                    {{ $cartItem->provider->email ?? 'No email available' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            {{-- Handyman --}}
            @if ($assignedHandyman)
                <div class="col-xl-4 col-sm-6" id="handymanCard">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    @if ($assignedHandyman->profile_pic)
                                        <!-- Display profile image if available -->
                                        <img src="{{ URL::asset('images/user/' . $assignedHandyman->profile_pic) }}"
                                            alt="Provider Avatar" class="avatar-md rounded-circle img-thumbnail">
                                    @else
                                        {{-- Default User Image --}}
                                        <img src="{{ asset('images/user/default_handyman.jpg') }}"
                                            class="avatar rounded-circle img-thumbnail me-2"
                                            style="height: 56px; width:56px;">
                                    @endif
                                </div>

                                <div class="flex-1 ms-3">
                                    <h5 class="font-size-16 mb-1">
                                        <div class="text-body">
                                            {{ $assignedHandyman->firstname ?? '' }}
                                            {{ $assignedHandyman->lastname ?? '' }}
                                        </div>
                                    </h5>
                                    <span class="badge bg-danger-subtle text-danger mb-0">Handyman</span>
                                </div>
                            </div>

                            <div class="mt-3 pt-1">
                                <p class="mb-0"><i
                                        class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                    {{ $assignedHandyman->mobile ?? 'No phone available' }}
                                </p>
                                <p class="mb-0 mt-2"><i
                                        class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                    {{ $assignedHandyman->email ?? 'No email available' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Modal for Assign Handyman -->
        <div class="modal fade" id="assignHandymanModal" tabindex="-1" aria-labelledby="assignHandymanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignHandymanModalLabel">Assign Handyman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('assign.providerhandyman', $data->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="id" class="form-label">Handyman <span
                                        style="color: red;">*</span></label>
                                <select class="form-control" data-trigger id="id" name="id">
                                    <option value="">Select Handyman</option>
                                    @foreach ($handymen as $handyman)
                                        <option value="{{ $handyman->id }}">{{ $handyman->firstname }}
                                            {{ $handyman->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('id') }}</span>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Assign Handyman</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    @endsection
    @section('scripts')
        <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/profile.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/ecommerce-choices.init.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endsection
