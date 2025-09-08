@extends('layouts/layoutMaster')

@section('title', 'Add Provider')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/vendors-add.js') }}"></script>
@endsection


@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Provider /</span><span> Add Provider</span>
    </h4>

    <div class="app-ecommerce">

        <!-- Add Provider -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Add Provider</h4>
                <p class="text-muted">Discover, Connect, Thrive: Expand Your Network with Ease!</p>
            </div>
            <div class="text-end">
                <button type="button" id="backButton" class="btn btn-outline-secondary">Back</button>
            </div>
        </div>

        <form class="add-vendor pt-0" id="addVendorForm" method="post" action="{{ route('providers-save') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Provider Information -->
                <div class="col-12 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Provider information</h5>
                        </div>
                        <div class="card-body">

                            <!-- First Name -->
                            <div class="row" style="padding-bottom: 20px;">
                                <div class="col-md-6">
                                    <label class="form-label" for="firstname">First Name<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="firstname" value="{{ old('firstname') }}"
                                        placeholder="Enter First Name" name="firstname"
                                        class="form-control @error('firstname') is-invalid @enderror" />
                                    @error('firstname')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="lastname">Last Name<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="lastname" value="{{ old('lastname') }}"
                                        placeholder="Enter Last Name" name="lastname"
                                        class="form-control @error('lastname') is-invalid @enderror" />
                                    @error('lastname')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone Number & Email -->
                            <div class="row" style="padding-bottom: 20px;">

                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="email" value="{{ old('email') }}"
                                        placeholder="Enter Email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" />
                                    @error('email')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="mobile">Contact Number<span style="color: red;">
                                            *</span></label>
                                    <input type="number" id="mobile" value="{{ old('mobile') }}"
                                        placeholder="Enter Contact Number" name="mobile"
                                        class="form-control @error('mobile') is-invalid @enderror" />
                                    @error('mobile')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password & Confirm Password -->
                            <div class="row" style="padding-bottom: 20px;">
                                <div class="col-md-6">
                                    <label class="form-label" for="password">Password<span class="text-muted"> (Should
                                            contain alphabets, numbers & special
                                            characters)</span><span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="password" value="{{ old('password') }}"
                                        placeholder="Enter Password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" />
                                    @error('password')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="password">Confirm Password<span class="text-muted">
                                            (Should
                                            contain alphabets, numbers & special
                                            characters)</span><span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="confirm_password"
                                        value="{{ old('password_confirmation') }}" placeholder="Enter Confirm Password"
                                        name="password_confirmation"
                                        class="form-control @error('password') is-invalid @enderror" />
                                </div>
                            </div>

                            <div class="row" style="padding-bottom: 8px;">
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="user_role">Role<span
                                            style="color: red;">*</span></label>
                                    <select id="user_role" class="select2 form-select" name="user_role"
                                        data-placeholder="Choose Role">
                                        <option value="">Choose Role</option>
                                        <option value="handyman">Handyman</option>
                                        <option value="provider">Provider</option>
                                    </select>
                                </div>
                                <div class="mb-3 col ecommerce-select2-dropdown" style="padding-top: 4px;">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="is_online">
                                        <span>Status<span style="color: red;">*</span></span><a href="javascript:void(0);"
                                            class="fw-medium"></a>
                                    </label>
                                    <select id="is_online" class="select2 form-select" name="is_online"
                                        data-placeholder="Choose Status">
                                        <option value="">Choose Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Image Upload --}}
                            <div class="form-group" style="padding-bottom: 10px;">
                                <label class="form-label" for="profile_image">
                                    Profile Image<span style="color: red;">
                                        *</span></label>
                                <div class="custom-file">
                                    <input type="file" name="profile_image" class="form-control form-control-lg"
                                        id="exampleInputFile">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary me-sm-3 me-1 data-submit" value="Submit"
                                onclick="submitForm(event)">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var backButton = document.getElementById("backButton");
        backButton.addEventListener("click", function() {
            window.location.href = "{{ route('providers-list') }}";
        });
    });
</script>
