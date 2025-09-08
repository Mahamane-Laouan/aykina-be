@extends('layouts/layoutMaster')

@section('title', 'Coupon List')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-calendar.css') }}" />
@endsection


@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/coupons-list.js') }}"></script>
    <script src="{{ asset('assets/js/app-calendar-events.js') }}"></script>
    <script src="{{ asset('assets/js/app-calendar.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Coupon /</span> Coupon List
    </h4>
    <div class="row g-4 mb-4">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
    </div>

    <!-- Coupon List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top">
                <thead>
                    <tr>
                        <th></th>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Discount Type</th>
                        <th>Expire Date</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
            aria-labelledby="addEventSidebarLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title mb-2" id="addEventSidebarLabel">Add Coupon</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form class="event-form pt-0" id="eventForm" method="post" action="{{ route('coupons-save') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="code">Code<span style="color: red;">
                                *</span></label>
                        <input type="text" id="code" value="{{ old('code') }}" placeholder="Enter Coupon Code"
                            name="code" class="form-control @error('code') is-invalid @enderror" />
                        @error('code')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="discount">Discount<span style="color: red;">
                                *</span></label>
                        <input type="number" id="discount" value="{{ old('discount') }}"
                            placeholder="Enter Coupon Discount" name="discount"
                            class="form-control @error('discount') is-invalid @enderror" />
                        @error('discount')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label mb-1 d-flex justify-content-between align-items-center" for="type">
                            <span>Discount Type<span style="color: red;">*</span></span><a href="javascript:void(0);"
                                class="fw-medium"></a>
                        </label>
                        <select id="type" class="select2 form-select" name="type" data-placeholder="Choose Type">
                            <option value="">Choose Type</option>
                            <option value="Fixed">Fixed</option>
                            <option value="Percentage">Percentage</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="coupon_for">Role<span style="color: red;">*</span></label>
                        <select id="coupon_for" class="form-select" name="coupon_for">
                            <option value="">Choose Role</option>
                            <option value="Product">Product</option>
                            <option value="Service">Service</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="switch">
                            <input type="checkbox" class="switch-input" name="status" />
                            <span class="switch-toggle-slider">
                                <span class="switch-on"></span>
                                <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Status</span>
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="expire_date">Expire Date</label>
                        <input type="text" class="form-control" id="eventStartDate" name="expire_date"
                            placeholder="Start Date" />
                    </div>

                    <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                        <div>
                            <button type="submit" class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                            <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                data-bs-dismiss="offcanvas">Cancel</button>
                        </div>
                        <div><button class="btn btn-label-danger btn-delete-event d-none">Delete</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
