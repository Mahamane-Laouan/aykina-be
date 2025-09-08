@extends('layouts.master')
@section('title')
    View Service
@endsection
@section('page-title')
    View Service
@endsection
<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">
@section('css')
    <!-- choices css -->
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- color picker css -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" />
    <!-- 'nano' theme -->

    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<style>
    .select2-container--default .select2-selection--multiple {
        height: 39px !important;
        border-radius: 9px !important;
        border: 1px solid #ced4da !important;
    }

    .choices__inner {
        display: inline-block !important;
        vertical-align: top !important;
        width: 100% !important;
        border: 1px solid #ced4da;
        !important;
        background-color: #F9F9F9 !important;
        border-radius: 9.5px !important;
        /* padding: 0px !important; */
        font-size: 14px !important;
        min-height: 44px !important;
        overflow: hidden !important;
        color: #6c757d !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #246FC1 !important;
        color: #fff !important;
    }


    /* .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #ffff !important;
    } */
</style>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#duration", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // Hours and minutes format
            time_24hr: true // 24-hour time format
        });

    });
</script>


@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Add Service Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> View your Service <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Services / View Service</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/service-list" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="row">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Service Information --}}
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Service Information</h4>
                        </div>
                        <div class="card-body">

                            {{-- Row 1 --}}
                            <div class="row">
                                <!-- Service Name -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="service_name" class="form-label">Service Name <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="service_name" name="service_name"
                                            placeholder="Enter Service Name" aria-label="Service title"
                                            value="{{ $data->service_name }}" disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                        <span class="text-danger">{{ $errors->first('service_name') }}</span>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="cat_id" class="form-label">Category <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-trigger id="cat_id" name="cat_id" disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ $value->id == $data->cat_id ? 'selected' : '' }}>
                                                    {{ $value->c_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('cat_id') }}</span>
                                    </div>
                                </div>

                                <!-- Sub Category -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sub_category_id" class="form-label">Sub Category</label>
                                        <select id="sub_category_id" name="res_id[]" class="form-select select2"
                                            data-placeholder="Select Sub Category" multiple disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                            <option value="">Select Sub Category</option>
                                            @foreach ($subcategory as $sub)
                                                <option value="{{ $sub->id }}"
                                                    {{ in_array($sub->id, explode(',', $data->res_id)) ? 'selected' : '' }}>
                                                    {{ $sub->c_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="sub_category_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>


                            {{-- Row 2 --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="v_id" class="form-label">Provider <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-trigger id="v_id" name="v_id" disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                            <option value="">Select Provider</option>
                                            @foreach ($vendors as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ $value->id == $data->v_id ? 'selected' : '' }}>
                                                    {{ $value->firstname }} {{ $value->lastname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('v_id') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="service_phone">
                                            Phone Number <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="service_phone"
                                            placeholder="Enter Phone Number" name="service_phone"
                                            aria-label="Service phone number" value="{{ $data->service_phone }}" disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                        <span class="text-danger">{{ $errors->first('service_phone') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="duration">
                                            Service Duration <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control timepicker flatpickr-input"
                                            id="duration" name="duration" placeholder="Select Service Duration"
                                            value="{{ $data->duration }}" readonly disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                        <span class="text-danger">{{ $errors->first('duration') }}</span>
                                    </div>
                                </div>
                            </div>


                            {{-- Row 3  --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="service_price">
                                            Service Price <span class="text-danger">*</span>
                                        </label>
                                        </label>
                                        <input type="text" class="form-control" id="service_price"
                                            placeholder="Enter Service Price" name="service_price"
                                            aria-label="Service Price" value="{{ $data->service_price }}" disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                        <span class="text-danger">{{ $errors->first('service_price') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="service_discount_price">
                                            Service Discount Price
                                        </label>
                                        <input type="text" class="form-control" id="service_discount_price"
                                            placeholder="Enter Service Discount Price" name="service_discount_price"
                                            aria-label="Service Discount Price"
                                            value="{{ $data->service_discount_price }}" disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                        <span class="text-danger">{{ $errors->first('service_discount_price') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-trigger id="status" name="status" disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                            <option value="">Select an option</option>
                                            <option value="1"
                                                {{ old('status', $data->status) == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0"
                                                {{ old('status', $data->status) == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                        <span id="status_error"
                                            class="error text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>


                            </div>


                            {{-- Row 4  --}}
                            <div class="row">

                                <!-- Add Product Addon -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="product_id" class="form-label">Add Product Addon <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-trigger id="product_id" name="product_id"
                                            disabled
                                            style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                                            <option value="">Select Product</option>
                                            @foreach ($products as $value)
                                                <option value="{{ $value->product_id }}"
                                                    {{ $value->product_id == $data->product_id ? 'selected' : '' }}>
                                                    {{ $value->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                    </div>
                                </div>
                            </div>


                            {{-- Service Description --}}
                            <div class="mb-3">
                                <label for="service_description" class="form-label">Service Description <span
                                        style="color: red;">*</span></label>
                                <textarea name="service_description" class="form-control" id="service_description"
                                    placeholder="Enter Service Description" cols="30" rows="5" disabled
                                    style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">{{ old('service_description', $data->service_description) }}</textarea>
                                <span class="text-danger">{{ $errors->first('service_description') }}</span>
                            </div>

                            {{-- Is Featured --}}
                            <div class="d-flex border-top pt-3">
                                <span class="mb-0 h6 me-3">Is Featured</span>
                                <div>
                                    <label class="form-check form-switch mb-3" dir="ltr">
                                        <input type="checkbox" class="form-check-input" id="is_features"
                                            name="is_features" {{ $data->is_features == 1 ? 'checked' : '' }} disabled>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Service Images --}}
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Service Images</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-0">Service Images <small class="text-muted">(Multiple images can be
                                    uploaded)</small><span style="color: red;">*</span></h5>
                            <input type="file" name="service_image[]" class="form-control" multiple id="imageUpload"
                                accept="image/*" style="margin-top: 15px;" disabled
                                style="background-color: #F9F9F9; color: #6c757d; border-color: #ced4da;">
                            <span class="error">{{ $errors->first('service_image') }}</span>

                            <div id="imagePreview" style="padding-top: 15px;"></div>

                            @if ($data->service_image)
                                <div style="display: flex; gap:1.5rem; ">
                                    @php
                                        $images = explode('::::', $data->service_image);
                                    @endphp
                                    @foreach ($images as $key => $image)
                                        <div id="image-preview_{{ $key }}">
                                            <img src="{{ asset('images/service_images/' . $image) }}"
                                                style="width: 100px; height: 100px;" class="img-thumbnail mb-2">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="padding-top: 20px; margin-left: 10px;">No images uploaded yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </form>
        </div>
    @endsection

    @section('scripts')
        <!-- choices js -->
        <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

        <!-- color picker js -->
        <script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

        <!-- datepicker js -->
        <script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // On category change, fetch and populate the subcategories


                // Image Upload Preview
                $('#imageUpload').on('change', function() {
                    $('#imagePreview').html('');
                    var files = $(this)[0].files;
                    for (var i = 0; i < files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#imagePreview').append('<img src="' + e.target.result +
                                '" width="80" height="80px" class="me-4 border">');
                        };
                        reader.readAsDataURL(files[i]);
                    }
                });

            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Select2 for the subcategory dropdown
                $('#sub_category_id').select2({
                    placeholder: "Select Sub Category", // Add placeholder text
                    width: '100%' // Make the dropdown 100% width
                });

                // On category change, fetch subcategories dynamically
                document.getElementById('cat_id').addEventListener('change', function() {
                    var categoryId = this.value;
                    console.log('Selected Category ID:', categoryId); // Debugging line

                    // Clear the error message before new selection
                    document.getElementById('sub_category_error').textContent = '';

                    if (categoryId) {
                        // Make an Ajax request to fetch subcategories based on the selected category
                        fetch(`/get-subcategories/${categoryId}`) // Ensure this endpoint is correct
                            .then(response => response.json())
                            .then(data => {
                                console.log('Fetched Subcategories:', data); // Debugging line

                                // Clear the current subcategory options
                                const subCategorySelect = document.getElementById('sub_category_id');
                                subCategorySelect.innerHTML =
                                    '<option value="">Select Sub Category</option>'; // Reset dropdown

                                // Check if data is not empty and contains the expected structure
                                if (Array.isArray(data) && data.length > 0) {
                                    // Populate the subcategory dropdown with the received data
                                    data.forEach(subCategory => {
                                        const option = document.createElement('option');
                                        option.value = subCategory.id; // Ensure correct property
                                        option.textContent = subCategory
                                            .c_name; // Ensure correct property
                                        subCategorySelect.appendChild(option);
                                    });
                                } else {
                                    // Handle case when no subcategories are returned
                                    const option = document.createElement('option');
                                    option.value = '';
                                    option.textContent = 'No subcategories available';
                                    subCategorySelect.appendChild(option);
                                }

                                // Re-initialize Select2 after adding the new options
                                $('#sub_category_id').trigger(
                                    'change'); // Trigger a change to update Select2 with new options
                            })
                            .catch(error => {
                                console.error('Failed to fetch subcategories:', error);
                            });
                    } else {
                        // Clear the subcategory options if no category is selected
                        const subCategorySelect = document.getElementById('sub_category_id');
                        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                        $('#sub_category_id').trigger('change'); // Trigger Select2 to reset
                    }
                });
            });
        </script>
    @endsection
