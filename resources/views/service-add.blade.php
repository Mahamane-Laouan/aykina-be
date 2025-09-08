@extends('layouts.master')

@section('title')
    Add Service
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- quill css -->
    <link href="{{ URL::asset('build/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
@endsection

<style>
    .select2-container--default .select2-selection--multiple {
        min-height: 39px !important;
        border-radius: 9px !important;
        border: 1px solid #edeff166 !important;
    }

    .choices__inner {
        display: inline-block !important;
        vertical-align: top !important;
        width: 100% !important;
        border: 1px solid #edeff166 !important;
        background-color: #edeff166 !important;
        border-radius: 9.5px !important;
        font-size: 14px !important;
        min-height: 44px !important;
        overflow: hidden !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #246FC1 !important;
        color: #fff !important;
    }


    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff !important;
    }

    .choices__input {
    background-color: #F8F9F9 !important;
    margin-bottom: 0;
}

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

    .select2-container--default .select2-selection--multiple {
        background-color: #edeff166 !important;

    }

    .flatpickr-input[readonly],
    .input[readonly] {
        background-color: #edeff166 !important;
    }

    .choices__list--multiple .choices__item {
        background-color: #246FC1 !important;
        border-color: #1f58c7 !important;
        margin-bottom: 0;
        margin-right: 0;
        font-weight: 400;
    }
</style>


@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#duration", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultHour: 1,
            defaultMinute: 0,
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
                    <h5 class="card-title"> Add a new Service <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Service List / Add Service</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/service-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <form action="{{ url('service-save') }}" method="POST" enctype="multipart/form-data"
                        id="termsConditionForm">
                        @csrf
                        <div class="card">
                            <a href="#addproduct-productinfo-collapse" class="text-body" data-bs-toggle="collapse"
                                aria-expanded="true" aria-controls="addproduct-productinfo-collapse">
                                <div class="p-4">

                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                    <h5 class="text-primary font-size-17 mb-0">01</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-16 mb-1">Service Info</h5>
                                            <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                        </div>

                                    </div>

                                </div>
                            </a>

                            <div id="addproduct-productinfo-collapse" class="collapse show"
                                data-bs-parent="#addproduct-accordion">
                                <div class="p-4 border-top">

                                    <div class="row">
                                        <!-- Service Name -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="service_name" class="form-label">Service Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="service_name"
                                                    name="service_name" placeholder="Enter Service Name"
                                                    aria-label="Service title" value="{{ old('service_name') }}">
                                                <span class="text-danger">{{ $errors->first('service_name') }}</span>
                                            </div>
                                        </div>

                                        <!-- Category Dropdown -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cat_id" class="form-label">Category <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" id="cat_id" name="cat_id">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ old('cat_id') == $value->id ? 'selected' : '' }}>
                                                            {{ $value->c_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{ $errors->first('cat_id') }}</span>
                                            </div>
                                        </div>

                                        <!-- Subcategory Dropdown -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="sub_category_id" class="form-label">Sub Category</label>
                                                <select id="sub_category_id" name="res_id[]" class="form-select" multiple>
                                                    <option value="">Select Sub Category</option>
                                                    <!-- Subcategories will be populated dynamically based on the selected category -->
                                                </select>
                                                <span id="sub_category_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Provider Dropdown -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="v_id" class="form-label">Provider <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" id="v_id" name="v_id">
                                                    <option value="">Select Provider</option>
                                                    @foreach ($vendors as $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ old('v_id') == $value->id ? 'selected' : '' }}>
                                                            {{ $value->firstname }} {{ $value->lastname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{ $errors->first('v_id') }}</span>
                                            </div>
                                        </div>

                                        <!-- Add Product Addon -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="product_id" class="form-label">Add Product Addon</label>
                                                <select class="form-control" id="product_id" name="product_id"
                                                    style="background-color: #edeff166;">
                                                    <option value="" style="color: #888;">Select Product</option>
                                                    <!-- Muted text for default option -->
                                                </select>
                                                <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="duration">
                                                    Service Duration <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control timepicker flatpickr-input"
                                                    id="duration" name="duration" placeholder="Select Service Duration"
                                                    value="{{ old('duration', '01:00') }}" readonly>
                                                <span class="text-danger">{{ $errors->first('duration') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="service_price">
                                                    Service Price <span class="text-danger">*</span>
                                                </label>

                                                <div class="input-group">
                                                    <!-- Default Currency Display -->
                                                    <span class="input-group-text"
                                                        style="background: #D0D3D9; color: #000; font-size: 18px;">
                                                        {{ $defaultCurrency }}
                                                    </span>
                                                    <input type="text" class="form-control" id="service_price"
                                                        placeholder="Enter Service Price" name="service_price"
                                                        aria-label="Service Price" value="{{ old('service_price') }}">
                                                </div>

                                                <span class="text-danger">{{ $errors->first('service_price') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="service_discount_price">
                                                    Service Discount Price
                                                </label>

                                                <div class="input-group">
                                                    <!-- Default Currency Display -->
                                                    <span class="input-group-text"
                                                        style="background: #D0D3D9; color: #000; font-size: 18px;">
                                                        {{ $defaultCurrency }}
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        id="service_discount_price"
                                                        placeholder="Enter Service Discount Price"
                                                        name="service_discount_price" aria-label="Service Discount Price"
                                                        value="{{ old('service_discount_price') }}">
                                                </div>
                                                <span
                                                    class="text-danger">{{ $errors->first('service_discount_price') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" id="status" name="status" data-trigger>
                                                    <option value="">Select an option</option>
                                                    <option value="1"
                                                        {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                                <span id="status_error"
                                                    class="error text-danger">{{ $errors->first('status') }}</span>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Service Description -->
                                    <div class="mb-3">
                                        <label for="service_description" class="form-label">Service Description <span
                                                style="color: red;">*</span></label>
                                        <div id="snow-editor" style="height: 200px;   background-color: #edeff166;">
                                        </div>
                                        <!-- Hidden Input to Store Quill Content -->
                                        <input type="hidden" name="service_description" id="text"
                                            value="{{ old('service_description', $service_description ?? '') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="address">Service Location<span
                                                style="color: red;">
                                                *</span></label>
                                        <textarea style="position: relative; background-color: #edeff166;" class="form-control" name="address"
                                            rows="2" placeholder="Enter Your Service Location" id="pac-input"></textarea>
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>

                                    {{-- Map --}}
                                    <div class="form-group creat-map-img" style="padding-bottom: 20px">
                                        <div class="text-lg-center alert-danger" id="info"></div>
                                        <div id="map" style="height: 400px; width: 100%;"></div>
                                    </div>


                                    {{-- Is Featured --}}
                                    <div class="d-flex border-top pt-3">
                                        <span class="mb-0 h6 me-3">Is Featured</span>
                                        <div>
                                            <label class="form-check form-switch mb-3" dir="ltr"
                                                style="transform: scale(1.1);">
                                                <input type="checkbox" class="form-check-input" id="is_features"
                                                    name="is_features">
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <span class="switch-off"></span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <a href="#addproduct-img-collapse" class="text-body collbodyd" data-bs-toggle="collapse"
                                aria-haspopup="true" aria-expanded="false" aria-controls="addproduct-img-collapse">
                                <div class="p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                    <h5 class="text-primary font-size-17 mb-0">02</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-16 mb-1">Service Image</h5>
                                            <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <div id="addproduct-img-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="dropzone">
                                        <input name="service_images[]" type="file" id="imageUpload"
                                            multiple="multiple">
                                        <div id="imagePreview" class="d-flex flex-wrap mt-4"></div>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('service_images') }}</span>
                                </div>
                            </div>
                        </div>



                        <div class="card">
                            <a href="#addproduct-metadata-collapse" class="text-body collbodyd" data-bs-toggle="collapse"
                                aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                                aria-controls="addproduct-metadata-collapse">
                                <div class="p-4">

                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                    <h5 class="text-primary font-size-17 mb-0">03</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-16 mb-1">Meta Data</h5>
                                            <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                        </div>

                                    </div>

                                </div>
                            </a>

                            <div id="addproduct-metadata-collapse" class="collapse"
                                data-bs-parent="#addproduct-accordion">
                                <div class="p-4 border-top">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="meta_title">Meta Title</label>
                                                <input type="text" class="form-control" id="meta_title"
                                                    name="meta_title" placeholder="Enter Meta Title"
                                                    aria-label="Meta title" value="{{ old('meta_title') }}">
                                                <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label" for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Enter Meta Description"
                                            cols="30" rows="5" style="background-color: #edeff166">{{ old('meta_description') }}</textarea>
                                        <span class="text-danger">{{ $errors->first('meta_description') }}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary me-sm-3 me-1 data-submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('scripts')
        <!-- choices js -->

        {{-- <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

        
        <!-- dropzone plugin -->
        <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/ecommerce-choices.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <!-- quill js -->
        <script src="{{ URL::asset('build/libs/quill/quill.min.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Choices.js on the category dropdown
                const categoryDropdown = new Choices('#cat_id', {
                    searchEnabled: true,
                    placeholderValue: 'Select Category',
                    shouldSort: false
                });

                // Initialize Choices.js on the subcategory dropdown with removeItemButton enabled
                const subCategoryDropdown = new Choices('#sub_category_id', {
                    searchEnabled: true,
                    removeItemButton: true, // Enable 'x' icon for removable items
                    // placeholderValue: 'Select Sub Category',
                    shouldSort: false
                });

                // Event listener for category dropdown change
                document.getElementById('cat_id').addEventListener('change', function(event) {
                    const categoryId = event.detail.value;

                    if (categoryId) {
                        fetch(`/get-subcategories/${categoryId}`)
                            .then(response => response.json())
                            .then(data => {
                                // Clear existing subcategory choices
                                subCategoryDropdown.clearChoices();

                                // Add new subcategory choices
                                subCategoryDropdown.setChoices(data.map(subCategory => ({
                                    value: subCategory.id,
                                    label: subCategory.c_name
                                })));
                            })
                            .catch(error => {
                                console.error('Failed to fetch subcategories:', error);
                            });
                    } else {
                        // Reset subcategory dropdown if no category is selected
                        subCategoryDropdown.clearChoices();

                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                let selectedFiles = []; // Store selected files

                // Image Upload and Preview
                $('#imageUpload').on('change', function(event) {
                    let files = event.target.files;
                    let dt = new DataTransfer(); // Create a DataTransfer object to update input field

                    for (let i = 0; i < files.length; i++) {
                        let file = files[i];

                        // Prevent duplicate images
                        if (selectedFiles.some(f => f.name === file.name)) {
                            continue;
                        }

                        selectedFiles.push(file); // Store file in array

                        let reader = new FileReader();
                        reader.onload = function(e) {
                            let imageContainer = `
            <div class="image-container position-relative me-4 mb-3 border rounded" data-name="${file.name}" 
                style="display: inline-block; width: 100px; height: 100px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                
                <img src="${e.target.result}" class="img-fluid" 
                    style="width: 100%; height: 100%; object-fit: cover;">
                
                <button type="button" class="remove-image position-absolute"
                    style="top: -6px; right: -6px; width: 28px; height: 28px; font-size: 22px; font-weight: bold; 
                           color: white; background: linear-gradient(135deg, #ff6666, #cc3333); border: none;
                           display: flex; align-items: center; justify-content: center; border-radius: 50%; 
                           box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2); transition: transform 0.2s, box-shadow 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)'; this.style.boxShadow='0px 4px 10px rgba(0, 0, 0, 0.3)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 2px 6px rgba(0, 0, 0, 0.2)';">
                    &times;
                </button>
            </div>`;
                            document.getElementById('imagePreview').insertAdjacentHTML('beforeend',
                                imageContainer);
                        };
                        reader.readAsDataURL(file);
                    }

                    // Update input field with only the selected files
                    selectedFiles.forEach(file => dt.items.add(file));
                    document.getElementById('imageUpload').files = dt.files;
                });

                // Remove Image
                $('#imagePreview').on('click', '.remove-image', function() {
                    let container = $(this).closest('.image-container');
                    let fileName = container.attr('data-name');

                    // Remove file from selectedFiles array
                    selectedFiles = selectedFiles.filter(f => f.name !== fileName);

                    // Remove image preview
                    container.remove();

                    // Update the file input field
                    let dt = new DataTransfer();
                    selectedFiles.forEach(file => dt.items.add(file));
                    document.getElementById('imageUpload').files = dt.files;
                });
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Choices.js on the provider dropdown with search enabled
                const providerDropdown = new Choices('#v_id', {
                    searchEnabled: true,
                    placeholderValue: 'Select Provider',
                    shouldSort: false
                });

                // Initialize Choices.js on the product dropdown
                const productDropdown = new Choices('#product_id', {
                    searchEnabled: true,
                    // placeholderValue: 'Select Product',
                    shouldSort: false
                });

                // Event listener for provider dropdown change
                document.getElementById('v_id').addEventListener('change', function(event) {
                    const v_id = event.detail.value;

                    if (v_id) {
                        fetch(`/get-products/${v_id}`)
                            .then(response => response.json())
                            .then(data => {
                                // Clear existing options
                                productDropdown.clearChoices();

                                // Add default placeholder option
                                productDropdown.setChoices([{
                                    value: '',
                                    label: 'Select Product',
                                    selected: true,
                                    disabled: true
                                }]);

                                // Add new options from the fetched data
                                data.forEach(item => {
                                    productDropdown.setChoices([{
                                        value: item.product_id,
                                        label: item.product_name
                                    }], 'value', 'label', false);
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching products:', error);
                            });
                    } else {
                        // If no provider is selected, reset the product dropdown
                        productDropdown.clearChoices();
                        productDropdown.setChoices([{
                            value: '',
                            label: 'Select Product',
                            selected: true,
                            disabled: true
                        }]);
                    }
                });
            });
        </script>

        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMZ4GbRFYSevy7tMaiH5s0JmMBBXc0qBA&callback=initAutocomplete&libraries=places&v=weekly"
            async></script>


        <script>
            function initAutocomplete() {
                const map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: 40.704047,
                        lng: -74.1623959
                    },
                    zoom: 10,
                    mapTypeId: 'roadmap'
                });
                const input = document.getElementById('pac-input');
                if (input) {
                    const searchBox = new google.maps.places.SearchBox(input);

                    map.addListener('bounds_changed', () => {
                        searchBox.setBounds(map.getBounds());
                    });

                    let markers = [];

                    searchBox.addListener('places_changed', () => {
                        const places = searchBox.getPlaces();
                        if (places.length === 0) {
                            return;
                        }

                        markers.forEach(marker => marker.setMap(null));
                        markers = [];

                        const bounds = new google.maps.LatLngBounds();
                        places.forEach(place => {
                            if (!place.geometry || !place.geometry.location) {
                                console.log('Returned place contains no geometry');
                                return;
                            }

                            const icon = {
                                url: place.icon,
                                size: new google.maps.Size(71, 71),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(17, 34),
                                scaledSize: new google.maps.Size(25, 25)
                            };

                            markers.push(
                                new google.maps.Marker({
                                    map,
                                    icon,
                                    title: place.name,
                                    position: place.geometry.location
                                })
                            );

                            if (place.geometry.viewport) {
                                bounds.union(place.geometry.viewport);
                            } else {
                                bounds.extend(place.geometry.location);
                            }
                        });
                        map.fitBounds(bounds);
                    });
                }
            }

            // Ensure the function is globally available
            window.initAutocomplete = initAutocomplete;
        </script>

        <script>
            // Initialize Quill editor
            var quill = new Quill('#snow-editor', {
                theme: 'snow'
            });

            // Load existing content into Quill if available
            var existingContent = `{!! old('service_description', $service_description ?? '') !!}`;
            quill.root.innerHTML = existingContent;

            // Ensure the editor content is passed to the hidden input before submitting
            document.getElementById('termsConditionForm').onsubmit = function() {
    document.getElementById('text').value = quill.root.innerHTML; // Stores proper HTML
};

        </script>
    @endsection
