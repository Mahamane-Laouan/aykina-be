@extends('layouts.master')
@section('title')
    Booking Information
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">
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
                    <h5 class="card-title"> Overview Booking Information <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Booking Orders / Booking Information</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="{{ route('invoice.print', ['id' => $data->id]) }}" target="_blank"
                    class="btn btn-danger me-1 px-4 py-2 fw-bold shadow-sm rounded-pill">
                    <i class="fas fa-file-invoice-dollar me-2"></i> Invoice
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <div>
                                        <span class="badge bg-success-subtle text-success font-size-15 me-2">
                                            Paid
                                        </span>
                                        @php
                                            $paymentMethods = [
                                                'paypal' => ['class' => 'bg-dark text-white', 'label' => 'PayPal'],
                                                'wallet' => [
                                                    'class' => 'bg-warning-subtle text-warning',
                                                    'label' => 'Wallet',
                                                ],
                                                'google pay' => [
                                                    'class' => 'bg-info-subtle text-info',
                                                    'label' => 'Google Pay',
                                                ],
                                                'stripe' => [
                                                    'class' => 'bg-primary-subtle text-primary',
                                                    'label' => 'Stripe',
                                                ],
                                                'razor pay' => [
                                                    'class' => 'bg-danger-subtle text-danger',
                                                    'label' => 'Razor Pay',
                                                ],
                                                'flutter wave' => [
                                                    'class' => 'bg-success-subtle text-success',
                                                    'label' => 'Flutter Wave',
                                                ],
                                                'apple pay' => [
                                                    'class' => 'bg-secondary text-white',
                                                    'label' => 'Apple Pay',
                                                ],
                                            ];
                                        @endphp
                                        @if (isset($paymentMethods[$data->payment_mode]))
                                            <span
                                                class="badge {{ $paymentMethods[$data->payment_mode]['class'] }} font-size-15">
                                                {{ $paymentMethods[$data->payment_mode]['label'] }}
                                            </span>
                                        @endif
                                    </div>


                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Order Id:</h5>
                                        <p>#{{ $data->id }}</p>
                                    </div>

                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Booking Date:</h5>
                                        <p>{{ $data->created_at->format('d M, Y / h:i A') }}</p>
                                    </div>

                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Booking Placed Date:</h5>
                                        <p>{{ $data->created_at->format('d M, Y / h:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <h5 class="font-size-16 mb-3">Customer Details:</h5>
                                    @if (!empty($data->cartItems) && $data->cartItems->isNotEmpty())
                                        @php
                                            $cartItem = $data->cartItems->first();
                                        @endphp
                                        @if (!empty($cartItem->userAddress))
                                            <h5 class="font-size-15 mb-2">{{ $cartItem->userAddress->full_name ?? '' }}
                                            </h5>
                                            <p class="mb-1">{{ $cartItem->userAddress->phone ?? '' }}</p>
                                            <p class="mb-1">{{ $cartItem->userAddress->address ?? '' }}</p>
                                            <p class="mb-1">{{ $cartItem->userAddress->landmark ?? '' }}
                                            </p>
                                            <p class="mb-1">{{ $cartItem->userAddress->area_name ?? '' }}</p>
                                        @else
                                            <p class="mb-1">No address available.</p>
                                        @endif
                                    @else
                                        <p class="mb-1">No address available.</p>
                                    @endif
                                </div>
                            </div>


                        </div>

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold" style="width: 70px;">Sub Booking Id</th>
                                            <th class="fw-bold">Service/Product</th>
                                            <th class="fw-bold">Price</th>
                                            <th class="fw-bold">Quantity</th>
                                            <th class="text-end fw-bold" style="width: 120px;">Sub Booking Details</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        @if ($data->cartItems->isNotEmpty())
                                            @foreach ($data->cartItems as $cartItem)
                                                <tr>
                                                    <td><a href="{{ route('subbooking-view', ['id' => $cartItem->booking_id]) }}"
                                                            style="color: #246FC1;">
                                                            #{{ $cartItem->booking_id }}
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <div>
                                                            <h5 class="text-truncate font-size-14 mb-1">
                                                                @if ($cartItem->type == 'Product')
                                                                    {{ $cartItem->productDetails->product_name }}
                                                                    <span
                                                                        class="badge bg-danger-subtle text-danger font-size-13">Product</span>
                                                                @elseif ($cartItem->type == 'Service')
                                                                    {{ $cartItem->serviceDetails->service_name }}
                                                                    <span
                                                                        class="badge bg-primary-subtle text-primary font-size-13">Service</span>
                                                                @endif

                                                                @if (isset($cartItem->handymanStatus))
                                                                    @switch($cartItem->handymanStatus)
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
                                                                            <span class="badge bg-info text-white font-size-13">In
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
                                                                                In
                                                                                Progress</span>
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
                                                                @if ($cartItem->type == 'Product')
                                                                    Price:
                                                                    @if (!empty($cartItem->productDetails->product_discount_price))
                                                                        {{ $defaultCurrency }}{{ number_format($cartItem->productDetails->product_discount_price, 2) }}
                                                                    @else
                                                                        {{ $defaultCurrency }}{{ number_format($cartItem->productDetails->product_price, 2) }}
                                                                    @endif
                                                                @elseif ($cartItem->type == 'Service')
                                                                    Price:
                                                                    @if (!empty($cartItem->serviceDetails->service_discount_price))
                                                                        {{ $defaultCurrency }}{{ number_format($cartItem->serviceDetails->service_discount_price, 2) }}
                                                                    @else
                                                                        {{ $defaultCurrency }}{{ number_format($cartItem->serviceDetails->service_price, 2) }}
                                                                    @endif
                                                                    | Duration:
                                                                    @php
                                                                        $durationParts = explode(
                                                                            ':',
                                                                            $cartItem->serviceDetails->duration,
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

                                                    <td>{{ $defaultCurrency }}{{ number_format($cartItem->payment, 2) }}
                                                    </td>

                                                    <td>{{ $cartItem->quantity }}</td>

                                                    <td class="text-center">
                                                        <div
                                                            class="d-inline-block px-2 py-1 bg-light border rounded shadow-sm">
                                                            <a href="{{ route('subbooking-view', ['id' => $cartItem->booking_id]) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="View"
                                                                class="text-primary d-flex align-items-center">
                                                                <span class="ms-1">View</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No items to display</td>
                                            </tr>
                                        @endif


                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                Sub Total :
                                            </th>
                                            <td class="border-0 text-end">
                                                {{ $defaultCurrency }}{{ $data->sub_total ?? 0 }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                Discount :</th>
                                            <td class="border-0 text-end">-
                                                {{ $defaultCurrency }}{{ $data->coupon ?? 0 }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                Platform Charge :</th>
                                            <td class="border-0 text-end">
                                                {{ $defaultCurrency }}{{ $data->service_charge ?? 0 }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                Tax :</th>
                                            <td class="border-0 text-end">
                                                {{ $defaultCurrency }}{{ $data->tax ?? 0 }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                Total :</th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold">
                                                    {{ $defaultCurrency }}{{ $data->total ?? 0 }}</h4>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('scripts')
        <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/todo.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
