@extends('layouts.master')
@section('title')
    Sub Booking Information
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

    .handy-info {
        background: #246fc1;
        padding: 15px !important;
    }

    .handy-inflid {
        padding: 10px;
    }

    a.text-body.handy-namedata {
        color: #fff !important;

    }

    .card-body.overview {
        padding: 5px;
    }
</style>

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
                    <h5 class="card-title"> Overview Sub Booking Information <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Booking Orders / Sub Booking Information</p>
                </div>
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
                            <img src="{{ URL::asset('images/logo/bookingback.png') }}"
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

                                <div class="mt-3">
                                    <h5 class="mb-2" style="font-weight: bold; padding-top:50px;">Sub Booking Details</h5>
                                    <p style="margin: 0; color: #6c757d;">
                                        <span style="font-weight: bold;">Sub Booking ID:</span> #{{ $data->id }}
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
                                                Price :</th>
                                            <td class="text-muted" style="font-size: 13px;">
                                                {{ $defaultCurrency }}{{ $data->payment ?? '' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="fw-bold" style="font-size: 15px;">Payment Method :</th>
                                            <td class="text-muted" style="font-size: 13px;">
                                                @if ($data->payment_method == 'paypal')
                                                    <span class="badge bg-dark text-white font-size-13">PayPal</span>
                                                @elseif($data->payment_method == 'wallet')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning font-size-13">Wallet</span>
                                                @elseif($data->payment_method == 'google pay')
                                                    <span class="badge bg-info-subtle text-info font-size-13">Google
                                                        Pay</span>
                                                @elseif($data->payment_method == 'stripe')
                                                    <span
                                                        class="badge bg-primary-subtle text-primary font-size-13">Stripe</span>
                                                @elseif($data->payment_method == 'razor pay')
                                                    <span class="badge bg-danger-subtle text-danger font-size-13">Razor
                                                        Pay</span>
                                                @elseif($data->payment_method == 'flutter wave')
                                                    <span class="badge bg-success-subtle text-success font-size-13">Flutter
                                                        Wave</span>
                                                @elseif($data->payment_method == 'apple pay')
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

                            {{-- <div class="pt-2 text-center border-bottom pb-4" style="margin-top: 12px;">
                                <a href="#"
                                    class="btn btn-primary waves-effect waves-light btn-sm {{ $assignedHandyman ? 'disabled bg-secondary' : '' }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="{{ $assignedHandyman ? '' : '#assignHandymanModal' }}">
                                    Assign Handyman <i class="bx bx-send ms-1 align-middle"></i>
                                </a>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-9">
                <div class="card">
                    <div class="card-body overview">
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
                                <div class="py-2">
                                    <h5 class="font-size-15">Booking Summary</h5>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold">No.</th>
                                                    <th class="fw-bold">Item</th>
                                                    <th class="fw-bold">Quantity</th>
                                                    <th class="fw-bold">Price</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                @if ($productDetails || $serviceDetails)
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>
                                                            <div>
                                                                <h5 class="text-truncate font-size-14 mb-1">
                                                                    @if ($productDetails)
                                                                        {{ $productDetails->product_name }}
                                                                        <span
                                                                            class="badge bg-danger-subtle text-danger font-size-13">Product</span>
                                                                    @elseif ($serviceDetails)
                                                                        {{ $serviceDetails->service_name }}
                                                                        <span
                                                                            class="badge bg-primary-subtle text-primary font-size-13">Service</span>
                                                                    @endif

                                                                    @if (isset($handymanStatus))
                                                                        @switch($handymanStatus)
                                                                            @case(0)
                                                                                <span
                                                                                    class="badge bg-warning text-white font-size-13">Pending</span>
                                                                            @break

                                                                            @case(1)
                                                                                <span
                                                                                    class="badge bg-primary text-white font-size-13">
                                                                                    Accepted</span>
                                                                            @break

                                                                            @case(2)
                                                                                <span
                                                                                    class="badge bg-primary text-white font-size-13">Accepted</span>
                                                                            @break

                                                                            @case(3)
                                                                                <span
                                                                                    class="badge bg-danger text-white font-size-13">Rejected</span>
                                                                            @break

                                                                            @case(4)
                                                                                <span
                                                                                    class="badge bg-info text-white font-size-13">In
                                                                                    Progress</span>
                                                                            @break

                                                                            @case(5)
                                                                                <span
                                                                                    class="badge bg-danger text-white font-size-13">
                                                                                    Rejected</span>
                                                                            @break

                                                                            @case(6)
                                                                                <span
                                                                                    class="badge bg-success text-white font-size-13">Completed</span>
                                                                            @break

                                                                           @case(7)
    <span class="badge" style="background-color: #FF6F00; color: white; font-size: 13px;">
        Hold
    </span>
@break

                                                                            @case(8)
                                                                                <span
                                                                                    class="badge bg-danger text-white font-size-13">Cancelled</span>
                                                                            @break

                                                                            @case(9)
                                                                                <span
                                                                                    class="badge bg-info text-white font-size-13">
                                                                                    In Progress</span>
                                                                            @break

                                                                            @case(10)
                                                                                <span
                                                                                    class="badge bg-success text-white font-size-13">
                                                                                    Delivered</span>
                                                                            @break

                                                                            @case(12)
                                                                                <span
                                                                                    class="badge bg-danger text-white font-size-13">Cancelled
                                                                                    By User</span>
                                                                            @break

                                                                            @default
                                                                        @endswitch
                                                                    @endif
                                                                </h5>

                                                                <p class="text-muted mb-0">
                                                                    @if ($productDetails)
                                                                        Price:
                                                                        @if (!empty($productDetails->product_discount_price))
                                                                            {{ $defaultCurrency }}{{ number_format($productDetails->product_discount_price, 2) }}
                                                                        @else
                                                                            {{ $defaultCurrency }}{{ number_format($productDetails->product_price, 2) }}
                                                                        @endif
                                                                    @elseif ($serviceDetails)
                                                                        Price:
                                                                        @if (!empty($serviceDetails->service_discount_price))
                                                                            {{ $defaultCurrency }}{{ number_format($serviceDetails->service_discount_price, 2) }}
                                                                        @else
                                                                            {{ $defaultCurrency }}{{ number_format($serviceDetails->service_price, 2) }}
                                                                        @endif
                                                                        | Duration:
                                                                        @php
                                                                            $durationParts = explode(
                                                                                ':',
                                                                                $serviceDetails->duration,
                                                                            );
                                                                            $hours = (int) $durationParts[0];
                                                                            $minutes = (int) $durationParts[1];
                                                                            $formattedDuration =
                                                                                ($hours > 0
                                                                                    ? $hours .
                                                                                        ' hour' .
                                                                                        ($hours > 1 ? 's' : '') .
                                                                                        ' '
                                                                                    : '') .
                                                                                ($minutes > 0
                                                                                    ? $minutes .
                                                                                        ' minute' .
                                                                                        ($minutes > 1 ? 's' : '')
                                                                                    : '');
                                                                        @endphp
                                                                        {{ trim($formattedDuration) }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td>{{ $quantity ?? '1' }}</td>
                                                        <td>
                                                            @if ($productDetails)
                                                                {{ $defaultCurrency }}{{ number_format($productDetails->product_discount_price ?? $productDetails->product_price, 2) }}
                                                            @elseif ($serviceDetails)
                                                                {{ $defaultCurrency }}{{ number_format($serviceDetails->service_discount_price ?? $serviceDetails->service_price, 2) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="3" class="text-center">No items to display</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
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
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
        <div style="
            background: linear-gradient(135deg, #246FC1, #1E5A97); 
            padding: 1rem; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 70px; 
            height: 70px;">
            <i class="bx bx-calendar-x" style="font-size: 2.5rem; color: #fff;"></i>
        </div>
        <p style="margin-top: 0.6rem; font-size: 1.2rem; font-weight: 500; color: #333;">
            No Booking Status Found
        </p>
    </div>
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
            @if ($data->user)
                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body handy-info">
                            <div class="d-flex align-items-center">
                                <div>
                                    @if ($data->user->profile_pic)
                                        <img src="{{ URL::asset('images/user/' . $data->user->profile_pic) }}"
                                            alt="User Avatar" class="avatar-md rounded-circle img-thumbnail">
                                    @else
                                        <img src="{{ asset('images/user/default_user.jpg') }}"
                                            class="avatar rounded-circle img-thumbnail me-2"
                                            style="height: 56px; width:56px;">
                                    @endif
                                </div>
                                <div class="flex-1 ms-3">
                                    <h5 class="font-size-16 mb-1 d-flex align-items-center">
                                       <div 
                                             style="color: #fff;">
                                            {{ $data->user->firstname }} {{ $data->user->lastname }}
                                        </div>
                                        <span class="ms-2 d-flex align-items-center" style="color: #fff;">
                                            <i class="bx bxs-star font-size-14 text-warning"></i>
                                            <span class="font-size-14">{{ number_format($avgReview, 1) }}</span>
                                        </span>
                                    </h5>
                                    <span class="badge bg-success-subtle text-success mb-0">Customer</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-1 handy-inflid">
                            <p class="mb-0">
                                <i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                ({{ $data->user->country_code ?? '' }})
                                {{ $data->user->mobile ?? 'No phone available' }}
                            </p>

                            <p class="mb-0 mt-2">
                                <i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                {{ $data->user->email ?? 'No email available' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif


            {{-- Provider --}}
            @if (isset($data->provider) && $data->provider)
                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body handy-info">
                            <div class="d-flex align-items-center">
                                <div>
                                    @if ($data->provider->profile_pic)
                                        <img src="{{ URL::asset('images/user/' . $data->provider->profile_pic) }}"
                                            alt="Provider Avatar" class="avatar-md rounded-circle img-thumbnail">
                                    @else
                                        {{-- Default User Image --}}
                                        <img src="{{ asset('images/user/default_provider.jpg') }}"
                                            class="avatar rounded-circle img-thumbnail me-2"
                                            style="height: 56px; width:56px;">
                                    @endif
                                </div>
                                <div class="flex-1 ms-3">
                                    <h5 class="font-size-16 mb-1 d-flex align-items-center">
                                   <div 
                                             style="color: #fff;">
                                            {{ $data->provider->firstname ?? '' }}
                                            {{ $data->provider->lastname ?? '' }}
                                        </div>
                                        <span class="ms-2 d-flex align-items-center" style="color: #fff;">
                                            <i class="bx bxs-star font-size-14 text-warning"></i>
                                            <span class="font-size-14">{{ number_format($avgProviderReview, 1) }}</span>
                                        </span>
                                    </h5>
                                    <span class="badge bg-primary-subtle text-primary mb-0">
                                        Provider
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-1 handy-inflid">
                            <p class="mb-0">
                                <i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                ({{ $data->provider->country_code ?? '' }})
                                {{ $data->provider->mobile ?? 'No phone available' }}
                            </p>

                            <p class="mb-0 mt-2">
                                <i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                {{ $data->provider->email ?? 'No email available' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Handyman --}}
            @if ($assignedHandyman)
                <div class="col-xl-4 col-sm-6" id="handymanCard">
                    <div class="card">
                        <div class="card-body handy-info">
                            <div class="d-flex align-items-center">
                                <div>
                                    @if ($assignedHandyman->profile_pic)
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
                                    <h5 class="font-size-16 mb-1 d-flex align-items-center">
                                        <div 
                                             style="color: #fff;">
                                            {{ $assignedHandyman->firstname ?? '' }}
                                            {{ $assignedHandyman->lastname ?? '' }}
                                        </div>
                                        <span class="ms-2 d-flex align-items-center" style="color: #fff;">
                                            <i class="bx bxs-star font-size-14 text-warning"></i>
                                            <span class="font-size-14">{{ number_format($avgHandymanReview, 1) }}</span>
                                        </span>
                                    </h5>
                                    <span class="badge bg-danger-subtle text-danger mb-0">Handyman</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-1 handy-inflid">
                            <p class="mb-0"><i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                {{ $assignedHandyman->mobile ?? 'No phone available' }}
                            </p>
                            <p class="mb-0 mt-2"><i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                {{ $assignedHandyman->email ?? 'No email available' }}
                            </p>
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
                        <form method="POST" action="{{ route('assign.handyman', $data->id) }}">
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
