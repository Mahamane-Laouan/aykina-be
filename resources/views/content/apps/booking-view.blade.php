@extends('layouts/layoutMaster')

@section('title', 'Booking - Booking View')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('/assets/js/offcanvas-add-payment.js') }}"></script>
    <script src="{{ asset('/assets/js/offcanvas-send-invoice.js') }}"></script>
@endsection

@section('vendor-script')
    <script src="{{ asset('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="py-4 mb-6">
                <span class="text-muted fw-light">Bookings /</span> Booking View
            </h4>
        </div>

        <div class="text-end">
            <button type="button" id="backButton" class="btn btn-outline-secondary">Back</button>
        </div>
    </div>
    <div class="row g-4 mb-4">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
    </div>

    <div class="row invoice-preview">
        <!-- Booking View -->
        <div class="col-xl-12 col-md-8 col-12 mb-md-0 mb-4">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div
                        class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                        <div class="mb-xl-0 mb-4">
                            <div class="d-flex svg-illustration mb-3 gap-2">
                                <div>
                                    <h4>Order id : <strong style="color: #2D72BE">{{ $booking->order_id }}</strong></h4>
                                    <div class="mb-2">
                                        <span class="me-1">Booking Placed :</span>
                                        <span
                                            class="fw-medium">{{ date('M d, Y', strtotime($booking->created_at)) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#assignHandymanModal"
                                style="color: #2D72BE; border-color: #2D72BE; background-color: transparent;">
                                Assign
                            </button>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row p-sm-3 p-0 gap-4">
                        <!-- Payment Method Section -->
                        <div class="col-xl-4 col-md-6 col-sm-4 col-6 mb-4">
                            <h5 class="pb-2">Payment Method :</h5>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="pe-3">Payment Method :</td>
                                        <td style="color: #2D72BE"><strong>{{ $booking->payment_method }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="pe-3">Total Amount :</td>
                                        <td><strong>{{ $booking->payment }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Booking Description Section -->
                        <div class="col-xl-4 col-md-6 col-sm-4 col-6 mb-4">
                            <h5 class="pb-2">Booking Description :</h5>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="pe-3">Booking Status :</td>
                                        <td>
                                            @if ($booking->booking_status == 'Completed')
                                                <span
                                                    class="badge bg-label-success text-capitalized">{{ $booking->booking_status }}</span>
                                            @elseif($booking->booking_status == 'Cancelled')
                                                <span
                                                    class="badge bg-label-danger text-capitalized">{{ $booking->booking_status }}</span>
                                            @elseif($booking->booking_status == 'Pending')
                                                <span
                                                    class="badge bg-label-warning text-capitalized">{{ $booking->booking_status }}</span>
                                            @else
                                                <span
                                                    class="badge bg-label-secondary text-capitalized">{{ $booking->booking_status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pe-3">Payment Status :</td>
                                        <td>
                                            @if ($booking->payment_status == 'Paid')
                                                <span
                                                    class="badge bg-label-success text-capitalized">{{ $booking->payment_status }}</span>
                                            @elseif($booking->payment_status == 'Pending')
                                                <span
                                                    class="badge bg-label-secondary text-capitalized">{{ $booking->payment_status }}</span>
                                            @else
                                                <span
                                                    class="badge bg-label-secondary text-capitalized">{{ $booking->payment_status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pe-3">Booking Date :</td>
                                        <td>{{ date('M d, Y', strtotime($booking->created_at)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Customer Information Section -->
                        <div class="col-xl-4 col-md-12 col-sm-4 col-12 mb-4"
                            style="background-color: #F5F6FB; padding: 1rem; border-radius: .5rem;">
                            <h5 class="pb-2">Customer Information :</h5>
                            <div style="margin-bottom: 1.5rem; color:#2D72BE">
                                <strong>{{ $customerDetails->firstname ?? '' }}
                                    {{ $customerDetails->lastname ?? '' }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0rem;">
                                <p>Email</p>
                                <p>{{ $customerDetails->email ?? '' }}</p>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0;">
                                <p>Phone</p>
                                <p><strong>{{ $customerDetails->mobile ?? '' }}</strong></p>
                            </div>
                        </div>

                        <!-- Provider Information Section -->
                        <div class="col-xl-4 col-md-12 col-sm-4 col-12 mb-4"
                            style="background-color: #F5F6FB; padding: 1rem; border-radius: .5rem;">
                            <h5 class="pb-2">Provider Information :</h5>
                            <div style="margin-bottom: 1.5rem; color:#2D72BE">
                                <strong>{{ $providerDetails->firstname ?? '' }}
                                    {{ $providerDetails->lastname ?? '' }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0rem;">
                                <p>Email</p>
                                <p>{{ $providerDetails->email ?? '' }}</p>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0;">
                                <p>Phone</p>
                                <p><strong>{{ $providerDetails->mobile ?? '' }}</strong></p>
                            </div>
                        </div>

                        <!-- Handyman Information Section -->
                        <div class="col-xl-3 col-md-12 col-sm-4 col-12 mb-4"
                            style="background-color: #F5F6FB; padding: 1rem; border-radius: .5rem;">
                            <h5 class="pb-2">Handyman Information :</h5>
                            <div style="margin-bottom: 1.5rem; color:#2D72BE">
                                <strong>{{ $handymanDetails->firstname ?? '' }}
                                    {{ $handymanDetails->lastname ?? '' }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0rem;">
                                <p>Email</p>
                                <p>{{ $handymanDetails->email ?? '' }}</p>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0;">
                                <p>Phone</p>
                                <p><strong>{{ $handymanDetails->mobile ?? '' }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Datatables --}}
                <div class="table-responsive">
                    <table class="table border-top m-0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Service</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td></td>
                                    <td class="text-nowrap">{{ $service->service_name }}</td>
                                    <td>{{ $service->quantity }}</td>
                                    <td>
                                        <del>${{ $service->service_price }}</del>
                                        ${{ $service->service_discount_price }}
                                    </td>
                                    <td>${{ $service->service_price * $service->quantity }}</td>
                                    <!-- Calculate total price per item -->
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="align-top px-4 py-3">
                                    <p class="mb-2"></p>
                                </td>
                                <td class="text-end px-4 py-3">
                                    <p class="mb-2">Subtotal:</p>
                                    <p class="mb-2">Discount:</p>
                                    <p class="mb-0">Total:</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="fw-medium mb-2">${{ $subTotal }}</p>
                                    <p class="fw-medium mb-2">${{ $discount_amount }}</p>
                                    <p class="fw-medium mb-0">${{ $total }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Handyman Modal -->
    <div class="modal fade" id="assignHandymanModal" tabindex="-1" aria-labelledby="assignHandymanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('handyman-assign', ['id' => $booking->id]) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignHandymanModalLabel">Assign Handyman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="handyman_id" class="form-label">Select Handyman</label>
                            <select class="form-select" id="handyman_id" name="handyman_id">
                                @foreach ($handymen as $handyman)
                                    <option value="{{ $handyman->id }}">
                                        {{ $handyman->firstname }} {{ $handyman->lastname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('_partials/_offcanvas/offcanvas-send-invoice')
    @include('_partials/_offcanvas/offcanvas-add-payment')
@endsection




<script>
    document.addEventListener("DOMContentLoaded", function() {
        var backButton = document.getElementById("backButton");
        backButton.addEventListener("click", function() {
            window.location.href = "{{ route('booking-history') }}";
        });
    });
</script>
