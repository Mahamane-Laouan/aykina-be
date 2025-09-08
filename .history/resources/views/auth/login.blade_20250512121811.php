@extends('layouts.master-without-nav')
@section('title')
    Login
@endsection
@section('page-title')
    Login
@endsection

<style>
    .btn-primary:hover {
        background-color: #246FC1 !important;
        border-color: #246FC1 !important;
    }

    .copy-button {
        background-color: #246FC1;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
    }

    .copy-button:hover {
        background-color: #246FC1;
    }

    .error-message {
        color: red;
    }

    .auth-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 25px;
    }

    .auth-buttons button {
        width: 48%;
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
</style>

@section('body')

    <body>
    @endsection

    @section('content')
        <div class="authentication-bg min-vh-100">
            <div class="bg-overlay bg-light"></div>
            <div class="container">
                <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <a href="/" class="d-block auth-logo">
                                            <img src="{{ URL::asset('images/logo/handyman_logo.png') }}" alt="Handyman"
                                                height="30" class="auth-logo-dark me-start" style="height: 200px;">
                                            <img src="{{ URL::asset('images/logo/handyman_logo.png') }}" alt="Handyman"
                                                height="30" class="auth-logo-light me-start" style="height: 200px;">
                                        </a>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <form method="POST" action="{{ route('auth-login') }}" class="auth-input">
                                            @csrf

                                            <div class="mb-2">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>

                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" autocomplete="email"
                                                    placeholder="Enter Email" autofocus>
                                                @if ($errors->has('email'))
                                                    <p class="error-message">{{ $errors->first('email') }}</p>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative ">
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Enter Password" id="password" name="password"
                                                        autocomplete="current-password">

                                                    @if (!$errors->has('password'))
                                                        <button type="button"
                                                            class="btn btn-link position-absolute h-100 end-0 top-0"
                                                            id="password-addon">
                                                            <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                        </button>
                                                    @endif

                                                    @if ($errors->has('password'))
                                                        <p class="error-message">{{ $errors->first('password') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Error Message -->
                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif


                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                            </div>

                                            <!-- Auth buttons -->
                                            <div class="auth-buttons">
                                                <button type="button" class="btn btn-outline-primary"
                                                    onclick="fillCredentials('admin')">Admin</button>
                                                <button type="button" class="btn btn-outline-primary"
                                                    onclick="fillCredentials('provider')">Provider</button>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>

                        </div><!-- end col -->
                    </div><!-- end row -->

                </div>
            </div><!-- end container -->
        </div>
        <!-- end authentication section -->
    @endsection

    @section('scripts')
    @endsection

    {{-- Copy js --}}
    <script>
        function fillCredentials(role) {
            if (role === 'admin') {
                document.getElementById('email').value = 'admin@gmail.com';
                document.getElementById('password').value = '123456';
            } else if (role === 'provider') {
                document.getElementById('email').value = 'provider@gmail.com';
                document.getElementById('password').value = '123456';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordAddon = document.getElementById('password-addon');
            if (passwordAddon) {
                passwordAddon.addEventListener('click', function() {
                    var passwordInput = document.getElementById("password");
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                    } else {
                        passwordInput.type = "password";
                    }
                });
            }
        });
    </script>
