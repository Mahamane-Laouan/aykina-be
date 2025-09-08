@extends('layouts.master')

@section('title')
    Add Product
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
        {{-- Add Product Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Add a new Product <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Product List / Add Product</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/providerproduct-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <form action="{{ url('providerproduct-save') }}" method="POST" enctype="multipart/form-data"
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
                                            <h5 class="font-size-16 mb-1">Product Info</h5>
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
                                        <!-- Product Name -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Product Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="product_name"
                                                    name="product_name" placeholder="Enter Product Name"
                                                    aria-label="Product title" value="{{ old('product_name') }}">
                                                <span class="text-danger">{{ $errors->first('product_name') }}</span>
                                            </div>
                                        </div>

                                        <!-- Add Product Addon -->
                                        {{-- <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cat_id" class="form-label">Category <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" data-trigger id="cat_id" name="cat_id"
                                                    style="padding: 10px; font-size: 16px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('cat_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->c_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{ $errors->first('cat_id') }}</span>
                                            </div>
                                        </div> --}}

                                        <!-- Services -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="sub_category_id"
                                                    class="form-label font-weight-bold">Services</label>
                                                <select id="sub_category_id" name="service_id[]"
                                                    class="form-control select2" multiple="multiple"
                                                    data-placeholder="Select Services" style="width: 100%;">
                                                    <option value="">Select Services</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}"
                                                            {{ old('service_id') && in_array($service->id, old('service_id')) ? 'selected' : '' }}>
                                                            {{ $service->service_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span id="sub_category_error" class="text-danger"
                                                    style="font-size: 14px;"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" data-trigger id="status" name="status">
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

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="product_price">
                                                    Product Price <span class="text-danger">*</span>
                                                </label>

                                                <div class="input-group">
                                                    <!-- Default Currency Display -->
                                                    <span class="input-group-text"
                                                        style="background: #D0D3D9; color: #000; font-size: 18px;">
                                                        {{ $defaultCurrency }}
                                                    </span>
                                                    <input type="text" class="form-control" id="product_price"
                                                        placeholder="Enter Product Price" name="product_price"
                                                        aria-label="Product Price" value="{{ old('product_price') }}">
                                                </div>
                                                <span class="text-danger">{{ $errors->first('product_price') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="product_discount_price">
                                                    Product Discount Price
                                                </label>

                                                <div class="input-group">
                                                    <!-- Default Currency Display -->
                                                    <span class="input-group-text"
                                                        style="background: #D0D3D9; color: #000; font-size: 18px;">
                                                        {{ $defaultCurrency }}
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        id="product_discount_price"
                                                        placeholder="Enter Product Discount Price"
                                                        name="product_discount_price" aria-label="Product Discount Price"
                                                        value="{{ old('product_discount_price') }}">
                                                </div>

                                                <span
                                                    class="text-danger">{{ $errors->first('product_discount_price') }}</span>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="mb-3">
                                        <label for="product_description" class="form-label">Product Description <span
                                                style="color: red;">*</span></label>
                                        <div id="snow-editor" style="height: 200px;   background-color: #edeff166;">
                                        </div>
                                        <!-- Hidden Input to Store Quill Content -->
                                        <input type="hidden" name="product_description" id="text"
                                            value="{{ old('product_description', $product_description ?? '') }}" />
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
                                            <h5 class="font-size-16 mb-1">Product Image</h5>
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
                                        <input name="product_image[]" type="file" id="imageUpload"
                                            multiple="multiple">
                                        <div id="imagePreview" class="d-flex flex-wrap mt-4"></div>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('product_images') }}</span>
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
        <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

        <!-- dropzone plugin -->
        <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/ecommerce-choices.init.js') }}"></script>

        <!-- quill js -->
        <script src="{{ URL::asset('build/libs/quill/quill.min.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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
                // Initialize Select2
                $('.select2').select2({
                    width: '100%',
                    placeholder: "Select an option",
                });

                // Provider dropdown change handler (if needed for dynamic services fetching)
                document.getElementById('vid')?.addEventListener('change', function() {
                    const providerId = this.value;
                    const serviceDropdown = document.getElementById('sub_category_id');
                    serviceDropdown.innerHTML = '<option value="">Loading...</option>';

                    if (providerId) {
                        fetch(`/get-services/${providerId}`)
                            .then((response) => response.json())
                            .then((data) => {
                                serviceDropdown.innerHTML = '<option value="">Select Services</option>';
                                data.forEach((service) => {
                                    const option = document.createElement('option');
                                    option.value = service.id;
                                    option.textContent = service.service_name;
                                    serviceDropdown.appendChild(option);
                                });
                                $('.select2').trigger('change'); // Reinitialize Select2
                            })
                            .catch((error) => {
                                console.error('Error fetching services:', error);
                                serviceDropdown.innerHTML =
                                    '<option value="">Failed to load services</option>';
                            });
                    } else {
                        serviceDropdown.innerHTML = '<option value="">Select Services</option>';
                    }
                });
            });
        </script>


        <script>
            // Initialize Quill editor
            var quill = new Quill('#snow-editor', {
                theme: 'snow'
            });

            // Load existing content into Quill if available
            var existingContent = `{!! old('product_description', $product_description ?? '') !!}`;
            quill.root.innerHTML = existingContent;

            // Ensure the editor content is passed to the hidden input before submitting
            document.getElementById('termsConditionForm').onsubmit = function() {
                document.getElementById('text').value = quill.root.innerHTML;
            };
        </script>
    @endsection
