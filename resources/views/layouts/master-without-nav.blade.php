<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Handyman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">

    <!-- include head css -->
    @include('layouts.head-css')
</head>

<style>
    .btn-primary {
        background-color: #246FC1 !important;
    }


    .btn:hover {
        background-color: #246FC1 !important;
        border-color: #246FC1 !important;
    }
</style>

<body>

    @yield('content')

    <!-- vendor-scripts -->
    @include('layouts.vendor-scripts')

</body>

</html>
