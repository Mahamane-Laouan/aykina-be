@extends('layouts.master')

@section('title')
    Handyman Information
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
                    <h5 class="card-title"> Handyman Information <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Handyman List / Handyman Information</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/providerhandyman-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Overall Handyman Information</h4>
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
                                <a class="nav-link" data-bs-toggle="tab" href="#handymanreview" role="tab">
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
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">

                            {{-- HandymanOverview --}}
                            <div class="tab-pane active" id="overviewprovider" role="tabpanel">
                                <div class="row">

                                    {{-- Earning Graph --}}
                                    <div class="col-xl-6">
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
                                                        class="apex-chart">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Booking Status --}}
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="card-title mb-4 text-truncate">Booking Status
                                                        </h5>
                                                    </div>

                                                </div>

                                                <!-- Pie chart -->
                                                <div id="saleing-categories" class="apex-charts" dir="ltr">
                                                </div>

                                                <div class="row mt-3 pt-1">
                                                    <!-- Status breakdown with percentages -->
                                                    <div class="col-md-6">
                                                        <div class="px-2 mt-2">
                                                            <div class="d-flex align-items-center mt-sm-0 mt-2">
                                                                <i class="mdi mdi-circle font-size-10 text-primary"></i>
                                                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                                                    <p class="font-size-15 mb-1 text-truncate">
                                                                        Pending</p>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                                                                    <span class="fw-bold" id="pending-percentage">0%</span>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center mt-2">
                                                                <i class="mdi mdi-circle font-size-10 text-success"></i>
                                                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                                                    <p class="font-size-15 mb-0 text-truncate">
                                                                        Accepted</p>
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
                                                                    <p class="font-size-15 mb-1 text-truncate">
                                                                        Rejected</p>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                                                                    <span class="fw-bold"
                                                                        id="rejected-percentage">0%</span>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center mt-2">
                                                                <i class="mdi mdi-circle font-size-10 text-secondary"></i>
                                                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                                                    <p class="font-size-15 mb-0 text-truncate">
                                                                        Completed
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
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $totalBooking }}
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
                                                                            class="bx bx-transfer font-size-24 mb-0 text-primary"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0 font-size-15">Withdrawn Balance
                                                                    </h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $defaultCurrency }}{{ $WithdrawnBalance }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-0 text-truncate">Total
                                                                            Withdrawn Balance</p>
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
                                                                    <h6 class="mb-0 font-size-15">Total Balance</h6>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mt-4 pt-1 mb-0 font-size-22">
                                                                    {{ $defaultCurrency }}{{ $totalProviderBalance }}
                                                                </h4>
                                                                <div class="d-flex mt-1 align-items-end overflow-hidden">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-0 text-truncate">Total
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


                                    {{-- Handyman Details --}}
                                    <div class="col-xl-6">

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start mb-2">
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title">Handyman Details</h5>
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
                                                                <img src="{{ asset('images/user/default_handyman.jpg') }}"
                                                                    alt=""
                                                                    style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover;">
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="col-md-7">

                                                        <span
                                                            class="badge bg-danger-subtle text-danger font-size-10 text-uppercase ls-05">
                                                            Handyman
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
                            <div class="tab-pane" id="handymanreview" role="tabpanel">
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
                                            @forelse ($latestReviews as $review)
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
                                                                    <div>
                                                                        {{ $review['firstname'] }}
                                                                        {{ Str::limit($review['lastname'], 20) }}
                                                                    </div>
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


                            {{-- Handyman Payout List --}}
                            <div class="tab-pane" id="providerpayoutlist" role="tabpanel">
                                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="color: #ffff;">Booking Id</th>
                                                <th scope="col" style="color: #ffff;">Amount</th>
                                                <th scope="col" style="color: #ffff;">Commission</th>
                                                <th scope="col" style="color: #ffff;">Date</th>
                                                <th scope="col" style="color: #ffff;">Payment Method</th>
                                                <th scope="col" style="color: #ffff;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($payouts as $payout)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('booking-view', $payout->booking_id) }}"
                                                            class="font-size-15"
                                                            style="color: #246FC1; text-decoration: none;">
                                                            #{{ $payout->booking_id ?? '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $defaultCurrency }}{{ number_format($payout->amount, 2) }}</td>
                                                    <td>{{ $payout->commision_persontage ? $payout->commision_persontage . '%' : '' }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($payout->created_at)->format('d M, Y / h:i A') }}
                                                    </td>
                                                    <td>
                                                        @if ($payout->payment_method === 'Online')
                                                            <button type="button"
                                                                class="btn btn-success btn-sm waves-effect waves-light">
                                                                Online
                                                            </button>
                                                        @elseif ($payout->payment_method === 'Cash')
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm waves-effect waves-light">
                                                                Cash
                                                            </button>
                                                        @else
                                                            <span></span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($payout->handman_status === 1)
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
                                                    <td colspan="7" class="text-center">
                                                        <div
                                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                            <div
                                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                                <i class="bx bx-wallet"
                                                                    style="font-size: 2.5rem; color: #fff;"></i>
                                                            </div>
                                                            <p
                                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                                No Payouts Available
                                                            </p>
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


        {{-- All Status Pie Chart --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Fetch the status counts for the provider from the backend
                const statusCounts = @json($statusCounts);

                const statuses = Object.keys(statusCounts); // ["Pending", "Accepted", "Rejected", "Completed"]
                const counts = Object.values(statusCounts); // [0, 2, 3, 6]

                const totalCount = counts.reduce((total, count) => total + count, 0);

                // Ensure no "NaN%" by setting percentages to "0%" if totalCount is 0
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
                fetch(`/handyman/${providerId}/earnings/${currentYear}`)
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
                        fetch(`/handyman/${providerId}/earnings/${selectedYear}`)
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
    @endsection
