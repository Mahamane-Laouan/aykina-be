@extends('layouts.master')

@section('title')
    Edit Service
@endsection

<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

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

    .dropzone {
        border: dotted !important;
        border-color: lightgrey !important;
    }

    .choices__list--multiple .choices__item {
        display: inline-block;
        vertical-align: middle;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 500;
        margin-right: 3.75px;
        margin-bottom: 3.75px;
        background-color: #246FC1 !important;
        border: 1px solid #246FC1 !important;
        color: #fff;
        word-break: break-all;
        box-sizing: border-box;
    }
</style>


@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

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
                    <h5 class="card-title"> Edit your Service <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Service List / Edit Service</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/providerservice-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <form action="{{ route('providerservice-update', ['id' => $data->id]) }}" method="POST"
                        enctype="multipart/form-data" id="termsConditionForm">
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
                                                    aria-label="Service title" value="{{ $data->service_name }}">
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
                                                            {{ $value->id == $data->cat_id ? 'selected' : '' }}>
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
                                                    <!-- Subcategories will be populated dynamically -->
                                                </select>
                                                <span id="sub_category_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Add Product Addon -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="product_id" class="form-label">Add Product Addon</label>
                                                <select class="form-control" data-trigger id="product_id" name="product_id">
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

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="duration">
                                                    Service Duration <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control timepicker flatpickr-input"
                                                    id="duration" name="duration" placeholder="Select Service Duration"
                                                    value="{{ $data->duration }}" readonly          style="background-color: #edeff166;">
                                                <span class="text-danger">{{ $errors->first('duration') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" data-trigger id="status" name="status">
                                                    <option value="">Select an option</option>
                                                    <option value="1"
                                                        {{ old('status', $data->status) == '1' ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0"
                                                        {{ old('status', $data->status) == '0' ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                </select>
                                                <span id="status_error"
                                                    class="error text-danger">{{ $errors->first('status') }}</span>
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
                                                        aria-label="Service Price" value="{{ $data->service_price }}">
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
                                                        value="{{ $data->service_discount_price }}">
                                                </div>

                                                <span
                                                    class="text-danger">{{ $errors->first('service_discount_price') }}</span>
                                            </div>
                                        </div>

                                        
                                    </div>


                                    <!-- Service Description -->
                                    <div class="mb-3">
                                        <label for="service_description" class="form-label">
                                            Service Description <span style="color: red;">*</span>
                                        </label>
                                        <div id="snow-editor" style="height: 200px; background-color: #edeff166;">
                                             {!! $data ? $data->service_description : '' !!}
                                        </div>
                                        <!-- Hidden Input to Store Quill Content -->
                                        <input type="hidden" name="service_description" id="service_description"
                                            value="{{ old('service_description', $data ? $data->service_description : '') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="address">Service Location<span
                                                style="color: red;">*</span></label>
                                        <textarea style="position: relative;" class="form-control" name="address" rows="2"
                                            placeholder="Enter Your Service Location" id="pac-input">{{ $data->address }}</textarea>
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>

                                    {{-- Map --}}
                                    <div class="form-group creat-map-img" style="padding-bottom: 20px">
                                        <div class="text-lg-center alert-danger" id="info"></div>
                                        <div id="map" data-lat="{{ $data->lat }}"
                                            data-lng="{{ $data->lon }}" style="height: 400px; width: 100%;"></div>
                                    </div>


                                    {{-- Is Featured --}}
                                    <div class="d-flex border-top pt-3">
                                        <span class="mb-0 h6 me-3">Is Featured</span>
                                        <div>
                                            <label class="form-check form-switch mb-3" dir="ltr" style="transform: scale(1.1);">
                                                <input type="checkbox" class="form-check-input" id="is_features"
                                                    name="is_features" {{ $data->is_features == 1 ? 'checked' : '' }} style="transform: scale(1.1);">
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
                                        <span class="error">{{ $errors->first('service_images') }}</span>
                                        <div id="imagePreview" class="d-flex flex-wrap mt-4">
                                            <!-- Existing Images -->
                                            @if ($data->ServiceImages && count($data->ServiceImages) > 0)
                                                @foreach ($data->ServiceImages as $value)
                                                    <div class="image-container position-relative me-4 mb-3 border rounded"
                                                        id="image-preview_{{ $value->id }}"
                                                        style="width: 100px; height: 100px; overflow: hidden;">
                                                        <img src="{{ asset('images/service_images/' . $value->service_images) }}"
                                                            class="img-fluid"
                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                        <button type="button"
                                                            class="remove-image btn btn-danger btn-sm position-absolute"
                                                            style="top: -6px; right: -6px; width: 28px; height: 28px; font-size: 22px; font-weight: bold; color: white; background: linear-gradient(135deg, #ff6666, #cc3333); border: none; display: flex; align-items: center; justify-content: center; border-radius: 50%; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2); transition: transform 0.2s, box-shadow 0.2s;"
                                                            onclick="deleteImage({{ $value->id }}, this)">
                                                            &times;
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p style="padding-top: 20px; margin-left: 10px;">No images uploaded yet.
                                                </p>
                                            @endif
                                        </div>

                                    </div>
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
                                                    aria-label="Meta title" value="{{ $data->meta_title }}">
                                                <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label" for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Enter Meta Description"
                                            cols="30" rows="5">{{ old('meta_description', $data->meta_description) }}</textarea>
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
                    placeholderValue: 'Select Sub Category',
                    shouldSort: false
                });

                // Function to fetch and populate subcategories
                function fetchSubcategories(categoryId, selectedSubcategories = []) {
                    if (categoryId) {
                        fetch(`/get-subcategories/${categoryId}`)
                            .then(response => response.json())
                            .then(data => {
                                // Clear existing subcategory choices
                                subCategoryDropdown.clearChoices();

                                // Add new subcategory choices
                                subCategoryDropdown.setChoices(data.map(subCategory => ({
                                    value: subCategory.id,
                                    label: subCategory.c_name,
                                    selected: selectedSubcategories.includes(subCategory.id
                                        .toString()) // Preselect if in selectedSubcategories
                                })));
                            })
                            .catch(error => {
                                console.error('Failed to fetch subcategories:', error);
                            });
                    } else {
                        // Reset subcategory dropdown if no category is selected
                        subCategoryDropdown.clearChoices();
                        subCategoryDropdown.setChoices([{
                            value: '',
                            label: 'Select Sub Category',
                            selected: true,
                            disabled: true
                        }]);
                    }
                }

                // Event listener for category dropdown change
                document.getElementById('cat_id').addEventListener('change', function(event) {
                    const categoryId = event.detail.value;
                    fetchSubcategories(categoryId);
                });

                // On page load, if editing, fetch and preselect subcategories
                const initialCategoryId = '{{ $data->cat_id }}';
                const initialSubcategories = '{{ $data->res_id }}'.split(',');
                if (initialCategoryId) {
                    fetchSubcategories(initialCategoryId, initialSubcategories);
                }
            });
        </script>



        {{-- <script>
            $(document).ready(function() {
                // Image Upload Preview
                $('#imageUpload').on('change', function() {
                    $('#imagePreview').html(''); // Clear previous image previews
                    var files = $(this)[0].files;

                    for (var i = 0; i < files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var imageContainer = `
                    <div class="image-container position-relative me-4 mb-3 border rounded" style="display: inline-block; width: 100px; height: 100px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <img src="${e.target.result}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                        <button class="remove-image btn btn-sm btn-light position-absolute top-0 end-0 p-0"
                            style="border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; color: #ff6b6b; background-color: rgba(255, 255, 255, 0.8); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>`;
                            $('#imagePreview').append(imageContainer);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                });

                // Remove Image on Close Icon Click
                $('#imagePreview').on('click', '.remove-image', function(e) {
                    e.preventDefault(); // Prevent redirection
                    var imageElement = $(this).closest('.image-container');
                    var imageId = imageElement.data(
                    'id'); // Make sure to set the image ID here for server-side deletion

                    // AJAX request to delete image from server
                    $.ajax({
                        url: "{{ url('service-imagedelete') }}" + "/" + imageId,
    type: "POST",
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
    if (response.success) {
    imageElement.remove(); // Remove the image element from the DOM
    } else {
    alert('Failed to delete image.');
    }
    }
    });
    });
    });
    </script> --}}

      <script>
            document.getElementById('imageUpload').addEventListener('change', function() {
                const files = this.files;
                const imagePreview = document.getElementById('imagePreview');

                // Preview selected images
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imageContainer = document.createElement('div');
                        imageContainer.className = 'image-container position-relative me-4 mb-3 border rounded';
                        imageContainer.style.cssText = 'width: 100px; height: 100px; overflow: hidden;';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-fluid';
                        img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';

                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.className = 'remove-image position-absolute';
                        removeButton.style.cssText =
                            'top: -6px; right: -6px; width: 28px; height: 28px; font-size: 22px; font-weight: bold; color: white; background: linear-gradient(135deg, #ff6666, #cc3333); border: none; display: flex; align-items: center; justify-content: center; border-radius: 50%; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2); transition: transform 0.2s, box-shadow 0.2s;';
                        removeButton.innerHTML = '&times;';
                        removeButton.onclick = function() {
                            imageContainer.remove();
                        };

                        imageContainer.appendChild(img);
                        imageContainer.appendChild(removeButton);
                        imagePreview.appendChild(imageContainer);
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>

        <script>
            function deleteImage(id, element) {
                fetch(`{{ url('providerservice-imagedelete') }}/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'POST'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            element.closest('.image-container').remove();
                        } else {
                            console.error('Failed to delete the image.');
                        }
                    })
                    .catch(error => {
                        console.error('An error occurred while deleting the image:', error);
                    });
            }
        </script>



<script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMZ4GbRFYSevy7tMaiH5s0JmMBBXc0qBA&callback=initAutocomplete&libraries=places&v=weekly"
            async></script>


        <script>
            function initAutocomplete() {
                const map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: parseFloat(document.getElementById('map').getAttribute('data-lat')),
                        lng: parseFloat(document.getElementById('map').getAttribute('data-lng'))
                    },
                    zoom: 13,
                    mapTypeId: 'roadmap'
                });
                // Create the search box and link it to the UI element.
                const input = document.getElementById('pac-input');
                if (input) {
                    const searchBox = new google.maps.places.SearchBox(input);

                    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                    map.addListener('bounds_changed', () => {
                        searchBox.setBounds(map.getBounds());
                    });

                    let markers = [];

                    // more details for that place.
                    searchBox.addListener('places_changed', () => {
                        const places = searchBox.getPlaces();

                        if (places.length == 0) {
                            return;
                        }

                        // Clear out the old markers.
                        markers.forEach(marker => {
                            marker.setMap(null);
                        });
                        markers = [];

                        // For each place, get the icon, name and location.
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

                            // Create a marker for each place.
                            markers.push(
                                new google.maps.Marker({
                                    map,
                                    icon,
                                    title: place.name,
                                    position: place.geometry.location
                                })
                            );
                            if (place.geometry.viewport) {
                                // Only geocodes have viewport.
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
            var existingContent = `{!! old('service_description', $data->service_description ?? '') !!}`;
            if (existingContent.trim() !== '') {
                quill.clipboard.dangerouslyPasteHTML(existingContent);
            }

            // Ensure the editor content is passed to the hidden input before submitting
            document.getElementById('termsConditionForm').addEventListener('submit', function() {
                document.getElementById('service_description').value = quill.root.innerHTML;
            });
        </script>
    @endsection
