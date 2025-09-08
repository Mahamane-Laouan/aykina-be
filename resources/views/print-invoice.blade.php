<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
</head>


<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

<body onload="window.print()">

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <!-- Logo Section -->
                        <!-- Logo Section -->
                        <div class="col-12 mb-4 text-start">
                            <img src="{{ asset('images/user/' . $profileimage) }}" alt="Handyhue Logo"
                                style="max-width: 100px; height: 100px;">
                        </div>

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
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @if ($data->cartItems->isNotEmpty())
                                        @foreach ($data->cartItems as $cartItem)
                                            <tr>
                                                <td>
                                                    <div style="color: #246FC1;">
                                                        #{{ $cartItem->booking_id }}
                                                    </div>
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

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No items to display</td>
                                        </tr>
                                    @endif


                                    <tr>
                                        <th scope="row" colspan="3" class="border-0 text-end fw-bold">
                                            Sub Total :
                                        </th>
                                        <td class="border-0 text-end">
                                            {{ $defaultCurrency }}{{ $data->sub_total ?? 0 }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row" colspan="3" class="border-0 text-end fw-bold">
                                            Discount :</th>
                                        <td class="border-0 text-end">-
                                            {{ $defaultCurrency }}{{ $data->coupon ?? 0 }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row" colspan="3" class="border-0 text-end fw-bold">
                                            Platform Charge :</th>
                                        <td class="border-0 text-end">
                                            {{ $defaultCurrency }}{{ $data->service_charge ?? 0 }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row" colspan="3" class="border-0 text-end fw-bold">
                                            Tax :</th>
                                        <td class="border-0 text-end">
                                            {{ $defaultCurrency }}{{ $data->tax ?? 0 }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row" colspan="3" class="border-0 text-end fw-bold">
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
</body>


</html>
