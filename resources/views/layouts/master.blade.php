<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Handyman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('images/logo/handyman_logo.png') }}">

    <!-- include head css -->
    @include('layouts.head-css')
</head>

<style>
    .btn-primary {
        background-color: #246FC1 !important;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #246FC1 !important;
    }

    .text-primary {
        color: #246FC1 !important;
    }

    .nav-tabs-custom .nav-item .nav-link.active {
        color: #246FC1 !important;
        background-color: #1f58c74d;
    }

    .form-check-input:checked {
        background-color: #246FC1 !important;
        border-color: #246FC1 !important;
    }

    .card-header.bg-primary {
        background-color: #246FC1 !important;
    }

    .table-light {

        --bs-table-bg: #246FC1 !important;

    }

    .btn-outline-primary {
        --bs-btn-color: #246FC1 !important;
        --bs-btn-border-color: #246FC1 !important;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #246FC1 !important;
        --bs-btn-hover-border-color: #246FC1 !important;
        --bs-btn-focus-shadow-rgb: 31, 88, 199;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #246FC1 !important;
        --bs-btn-active-border-color: #246FC1 !important;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
        --bs-btn-disabled-color: #246FC1 !important;
        --bs-btn-disabled-bg: transparent;
        --bs-btn-disabled-border-color: #246FC1 !important;
        --bs-gradient: none;
    }


    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
        background-color: #246FC1 !important;
    }

    .timeline .timeline-end p,
    .timeline .timeline-start p,
    .timeline .timeline-year p {

        background-color: #246FC1 !important;

    }


    .timeline .timeline-icon:after {

        background: #246FC1 !important;
    }


    .bg-primary {
        background-color: #246FC1 !important;
    }

    .page-link.active,
    .active>.page-link {

        background-color: #246FC1 !important;
        border-color: #246FC1 !important;
    }


    .chat-conversation .right .conversation-list .ctext-wrap .ctext-wrap-content {

        background-color: #246FC1 !important;

    }

    .nav-tabs-custom .nav-item .nav-link:after {
        background: #246FC1 !important;

    }

    .page-content {
        background: #ffff !important;

    }
</style>

@yield('body')

<!-- Begin page -->
<div id="layout-wrapper">
    <!-- topbar -->
    @include('layouts.topbar')

    <!-- sidebar components -->
    @include('layouts.sidebar')
    @include('layouts.horizontal')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <!-- footer -->
        @include('layouts.footer')

    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- customizer -->
@include('layouts.right-sidebar')

<!-- vendor-scripts -->
@include('layouts.vendor-scripts')

</body>

</html>
