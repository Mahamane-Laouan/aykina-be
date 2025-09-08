@extends('layouts/layoutMaster')

@section('title', 'Add Service')

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
    <script src="{{ asset('assets/js/services-add.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMZ4GbRFYSevy7tMaiH5s0JmMBBXc0qBA&callback=initAutocomplete&libraries=places&v=weekly"
        async></script>
@endsection

<style>
    .ql-editor {
        min-height: 0rem !important;
        background: #fff;
    }
</style>

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Services /</span><span> Add Service</span>
    </h4>

    <div class="app-ecommerce">

        <!-- Add Service -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Add a new Service</h4>
                <p class="text-muted">Discover the range of available services</p>
            </div>

            <div class="text-end">
                <button type="button" id="backButton" class="btn btn-outline-secondary">Back</button>
            </div>
        </div>

        <form class="add-service pt-0" id="addServiceForm" method="post" action="{{ route('services-save') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Service Information -->
                <div class="col-12 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Service information</h5>
                        </div>
                        <div class="card-body">

                            <!-- Service Name -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="service_name">Service Name<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="service_name" value="{{ old('service_name') }}"
                                        placeholder="Enter Service Name" name="service_name"
                                        class="form-control @error('service_name') is-invalid @enderror" />
                                    @error('service_name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category Dropdown -->
                                <div class="col-md-6" style="margin-top: 7px; padding-bottom: 24px">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="cat_id">
                                        <span>Category<span style="color: red;">*</span></span>
                                    </label>
                                    <select id="cat_id" name="cat_id" class="select2 form-select"
                                        data-placeholder="Select Category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->c_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Featured Category Services Checkbox -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="1" id="status"
                                    name="status">
                                <label class="form-label" for="status">
                                    Featured Category Services
                                </label>
                            </div>

                            {{-- Description --}}
                            <div style="padding-bottom: 20px;">
                                <label class="form-label">Description<span style="color: red;">*</span> <span
                                        class="text-muted"></span></label>
                                <div class="form-control p-0 pt-1">
                                    <div class="comment-toolbar border-0 border-bottom">
                                        <div class="d-flex justify-content-start">
                                            <span class="ql-formats me-0">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                                <button class="ql-link"></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Add a hidden input field to store Quill editor content -->
                                    <input type="hidden" id="res_desc_input" name="service_description" />
                                    <div class="comment-editor border-0 pb-4" id="service_description"></div>
                                </div>
                            </div>

                            <!-- Phone Number, Website -->
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="service_phone">Phone Number<span style="color: red;">
                                            *</span></label>
                                    <input type="number" id="service_phone" value="{{ old('service_phone') }}"
                                        placeholder="Enter Phone Number" name="service_phone"
                                        class="form-control @error('service_phone') is-invalid @enderror" />
                                    @error('service_phone')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label" for="service_price">Price<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="service_price" value="{{ old('service_price') }}"
                                        placeholder="Enter Service Price" name="service_price"
                                        class="form-control @error('service_price') is-invalid @enderror" />
                                    @error('service_price')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Service Promo Offer and Vendor Dropdown --}}
                            <div class="row mb-3">
                                <div class="mb-3 col ecommerce-select2-dropdown" style="padding-top: 4px;">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="price_unit">
                                        <span>Service Price Unit<span style="color: red;">*</span></span><a
                                            href="javascript:void(0);" class="fw-medium"></a>
                                    </label>
                                    <select id="price_unit" class="select2 form-select" name="price_unit"
                                        data-placeholder="Choose Price Unit">
                                        <option value="">Choose Price Unit</option>
                                        <option value="Fixed">Fixed</option>
                                        <option value="Hourly">Hourly</option>
                                        <option value="Free">Free</option>
                                    </select>
                                </div>

                                <!-- Vendor Dropdown -->
                                <div class="mb-3 col ecommerce-select2-dropdown" style="margin-top: 7px">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="v_id">
                                        <span>Provider<span style="color: red;">*</span></span>
                                    </label>
                                    <select id="v_id" name="v_id" class="select2 form-select"
                                        data-placeholder="Select Provider">
                                        <option value="">Select Provider</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->firstname }}
                                                {{ $vendor->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="promo_offer">Service Promo Offer<span
                                            style="color: red;">
                                            *</span></label>
                                    <input type="text" id="promo_offer" value="{{ old('promo_offer') }}"
                                        placeholder="Enter Service Promo Offer" name="promo_offer"
                                        class="form-control @error('promo_offer') is-invalid @enderror" />
                                    @error('promo_offer')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col ecommerce-select2-dropdown" style="margin-top: 7px">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="subc_id">
                                        <span>Sub Category<span style="color: red;">*</span></span>
                                    </label>
                                    <select id="subc_id" name="subc_id" class="select2 form-select"
                                        data-placeholder="Select Sub Category">
                                        <option value="">Select Sub Category</option>
                                        @foreach ($subcategorys as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->c_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Image Upload --}}
                            <div class="form-group" style="padding-bottom: 20px;">
                                <label class="form-label" for="service_name">Service Images (Multiple Images Possible to
                                    Upload)<span style="color: red;">
                                        *</span></label>
                                <div class="custom-file">
                                    <input type="file" name="service_image[]" class="form-control form-control-lg"
                                        id="exampleInputFile" multiple>
                                </div>
                            </div>


                            {{-- Days --}}
                            <div class="mb-3 col ecommerce-select2-dropdown">
                                <label class="form-label mb-1" for="vendor">
                                    Days<span style="color: red;">
                                        *</span>
                                </label>
                                <select class="select2 form-select" data-placeholder="Select Days" name="day[]"
                                    multiple="multiple">
                                    <option value="Mon">Monday</option>
                                    <option value="Tue">Tuesday</option>
                                    <option value="Wed">Wednesday</option>
                                    <option value="Thu">Thursday</option>
                                    <option value="Fri">Friday</option>
                                    <option value="Sat">Saturday</option>
                                    <option value="Sun">Sunday</option>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <!-- Slot Time Dropdown -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="slot_book">
                                        <span>Slot Time<span style="color: red;">*</span></span>
                                    </label>
                                    <select id="slot_book" name="slot_book" class="select2 form-select"
                                        data-placeholder="Select Slot">
                                        <option value="">Select Slot</option>
                                        <!-- JavaScript loop to generate options for 1 to 8 hours -->
                                        <script>
                                            for (let i = 1; i <= 8; i++) {
                                                document.write('<option value="' + i + '">' + i + ' Hours' + '</option>');
                                            }
                                            document.write('<option value="Full Day">Full Day</option>');
                                        </script>
                                    </select>
                                </div>

                                <!-- Open Time Dropdown -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="open_time">Open Time<span
                                            style="color: red;">*</span></label>
                                    <select id="open_time" name="open_time" class="select2 form-select"
                                        data-placeholder="Open Time">
                                        <option value="">Open Time</option>
                                        <?php
                                        for ($hour = 1; $hour <= 12; $hour++) {
                                            echo "<option value=\"$hour:00 AM\">$hour:00 AM</option>";
                                        }
                                        ?>
                                        <?php
                                        for ($hour = 1; $hour <= 12; $hour++) {
                                            echo "<option value=\"$hour:00 PM\">$hour:00 PM</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Close Time Dropdown -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="close_time">Close Time<span
                                            style="color: red;">*</span></label>
                                    <select id="close_time" name="close_time" class="select2 form-select"
                                        data-placeholder="Close Time">
                                        <option value="">Close Time</option>
                                        <?php
                                        for ($hour = 1; $hour <= 12; $hour++) {
                                            echo "<option value=\"$hour:00 AM\">$hour:00 AM</option>";
                                        }
                                        ?>
                                        <?php
                                        for ($hour = 1; $hour <= 12; $hour++) {
                                            echo "<option value=\"$hour:00 PM\">$hour:00 PM</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                {{-- Service Location --}}
                                <div class="form-group">
                                    <label class="form-label" for="address">Service Location<span style="color: red;">
                                            *</span></label>
                                    <textarea style="position: relative;" class="form-control" name="address" rows="2"
                                        placeholder="Enter Your Service Location" id="pac-input"></textarea>
                                </div>
                            </div>

                            {{-- Map --}}
                            <div class="form-group creat-map-img" style="padding-bottom: 20px">
                                <div class="text-lg-center alert-danger" id="info"></div>
                                <div id="map" style="height: 400px; width: 100%;"></div>
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
            window.location.href = "{{ route('services-list') }}";
        });
    });
</script>
