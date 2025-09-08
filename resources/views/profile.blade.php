@extends('layouts.master')

@section('title')
    Account Settings
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

@section('body')
@endsection

<style>
    input.form-control {
        background-color: #edeff166;
        border: 1px solid #edeff1;
        border-radius: calc(6px + .0025*(100vw - 320px));
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 400;
        color: #00162e;
    }

    .form-control {
        background-color: #edeff166;
        border: 1px solid #edeff1;
        border-radius: calc(6px + .0025*(100vw - 320px));
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 400;
        color: #00162e;
    }

    .choices__list--dropdown .choices__item {
        color: #000 !important;
    }


    .choices__inner {
        background-color: #edeff166 !important;
    }
</style>

@section('content')
    {{-- Privacy Policy Headline --}}
    <div class="row align-items-center">
        <div class="col-md-3" style="padding-top: 18px;">
            <div class="mb-3">
                <h5 class="card-title">Account Settings <span class="text-muted fw-normal ms-2"></span>
                </h5>
                <p class="text-muted">Profile / Account Settings</p>
            </div>
        </div>
    </div>

    <div class="row">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#profileTab" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Account</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#passwordTab" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Security</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Account Profile -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane show active" id="profileTab" role="tabpanel">
                            <div class="card shadow-sm border-0">
                                <div
                                    class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0" style="color: #ffff;">Account Profile</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile-save') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Profile Picture -->
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <img src="{{ $user && $user->profile_pic ? asset('images/user/' . $user->profile_pic) : asset('images/user/default_user.jpg') }}"
                                                alt="avatar" class="d-block rounded" height="100" width="100"
                                                id="uploadedAvatar">

                                            <div class="button-wrapper">
                                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                    <span class="d-none d-sm-block">Upload new photo</span>
                                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                                    <input type="file" id="upload" name="profile_pic"
                                                        class="account-file-input" hidden=""
                                                        accept="image/png, image/jpeg">
                                                </label>
                                                <p class="text-muted mb-0">Allowed JPG, GIF, or PNG. Max size of 800K</p>
                                            </div>
                                        </div>

                                        <!-- Profile Details -->
                                        <div class="row g-3 mt-3">
                                            <div class="col-md-6">
                                                <label for="firstname" class="form-label fw-bold text-dark">First
                                                    Name</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname"
                                                    placeholder="Enter First Name"
                                                    value="{{ old('firstname', $user->firstname ?? '') }}">
                                                <span class="text-danger small">{{ $errors->first('firstname') }}</span>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="lastname" class="form-label fw-bold text-dark">Last Name</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname"
                                                    placeholder="Enter Last Name"
                                                    value="{{ old('lastname', $user->lastname ?? '') }}">
                                                <span class="text-danger small">{{ $errors->first('lastname') }}</span>
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-3">
                                            <div class="col-md-6">
                                                <label for="email" class="form-label fw-bold text-dark">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Enter Email"
                                                    value="{{ old('email', $user->email ?? '') }}">
                                                <span class="text-danger small">{{ $errors->first('email') }}</span>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="mobile" class="form-label fw-bold text-dark">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile"
                                                    placeholder="Enter Phone Number"
                                                    value="{{ old('mobile', $user->mobile ?? '') }}">
                                                <span class="text-danger small">{{ $errors->first('mobile') }}</span>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="tab-pane show" id="passwordTab" role="tabpanel">
                            <div class="card shadow-sm border-0">
                                <div
                                    class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0" style="color: #ffff;">Change Password</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('password-save') }}" method="POST">
                                        @csrf

                                        <!-- Current Password -->
                                        <div class="row g-3 mt-3">
                                            <div class="col-md-12">
                                                <label for="current_password" class="form-label fw-bold text-dark">Current
                                                    Password</label>
                                                <input type="password" class="form-control" id="current_password"
                                                    name="current_password" placeholder="Enter Current Password">
                                                <span
                                                    class="text-danger small">{{ $errors->first('current_password') }}</span>
                                            </div>
                                        </div>

                                        <!-- New Password -->
                                        <div class="row g-3 mt-3">
                                            <div class="col-md-6">
                                                <label for="new_password" class="form-label fw-bold text-dark">New
                                                    Password</label>
                                                <input type="password" class="form-control" id="new_password"
                                                    name="new_password" placeholder="Enter New Password">
                                                <span
                                                    class="text-danger small">{{ $errors->first('new_password') }}</span>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="new_password_confirmation"
                                                    class="form-label fw-bold text-dark">Confirm New Password</label>
                                                <input type="password" class="form-control"
                                                    id="new_password_confirmation" name="new_password_confirmation"
                                                    placeholder="Confirm New Password">
                                                <span
                                                    class="text-danger small">{{ $errors->first('new_password_confirmation') }}</span>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        document.getElementById('upload').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('uploadedAvatar').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
