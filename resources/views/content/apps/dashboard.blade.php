@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/rateyo/rateyo.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/card-analytics.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/rateyo/rateyo.js') }}"></script>

@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-ecommerce.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-bookinghistory.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-reviews.js') }}"></script>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-4">
            <div class="row">
                <div class="col-lg-6 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <div style="background-color: #fff; padding: 12px; border-radius: 8px;">
                                        <i class="menu-icon tf-icons bx bx-user"
                                            style="color: #696cff; font-size: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block">Total Users</span>
                            {{-- <h4 class="card-title mb-1">{{ $totalUsers }}</h4> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <div style="background-color: #fff; padding: 12px; border-radius: 8px;">
                                        <i class="menu-icon tf-icons tf-icons bx bx-customize"
                                            style="color: #696cff; font-size: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block">Total Services</span>
                            {{-- <h4 class="card-title mb-1">{{ $totalServices }}</h4> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <div style="background-color: #fff; padding: 12px; border-radius: 8px;">
                                        <i class="menu-icon tf-icons bx bx-aperture"
                                            style="color: #696cff; font-size: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block">Total Categories</span>
                            {{-- <h4 class="card-title mb-1">{{ $totalCategories }}</h4> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <div style="background-color: #fff; padding: 12px; border-radius: 8px;">
                                        <i class="menu-icon tf-icons bx bx-star"
                                            style="color: #696cff; font-size: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block">Total Reviews</span>
                            {{-- <h4 class="card-title mb-1">{{ $totalReviews }}</h4> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users Graph -->
        <div class="col-md-6 col-lg-8 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-8">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Total Users</h5>
                            <small class="card-subtitle">Yearly report overview</small>
                        </div>
                        <div class="card-body">
                            <div id="totalUsersChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Review List --}}
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-review table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th class="text-nowrap">Reviewer</th>
                        <th>Review</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Booking History List --}}
    <div class="card" style="margin-top: 30px;">
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top">
                <thead>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>User</th>
                        <th>Restaurant Name</th>
                        <th>Description</th>
                        <th>Payment Mode</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script>
        var months = @json($months);
        var monthCount = @json($monthCount);
    </script>
@endsection
