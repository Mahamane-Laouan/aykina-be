@extends('layouts.master')

@section('title')
    Edit Product
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
        {{-- Add Product Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Edit your Product <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Product List / Edit Product</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/product-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <form action="{{ route('product-update', ['id' => $data->product_id]) }}" method="POST"
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
                                                    aria-label="Product title" value="{{ $data->product_name }}">
                                                <span class="text-danger">{{ $errors->first('product_name') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="vid" class="form-label">Provider <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" data-trigger id="vid" name="vid">
                                                    <option value="">Select Provider</option>
                                                    @foreach ($vendors as $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $data->vid ? 'selected style=color:green;' : '' }}>
                                                            {{ $value->firstname }} {{ $value->lastname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{ $errors->first('v_id') }}</span>
                                            </div>
                                        </div>

                                        <!-- Services -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="sub_category_id" class="form-label">Service</label>
                                                <select id="sub_category_id" name="service_id[]" class="form-select select2"
                                                    data-placeholder="Select Services" multiple>
                                                    <option value="">Select Services</option>
                                                    @foreach ($services as $sub)
                                                        <option value="{{ $sub->id }}"
                                                            {{ in_array($sub->id, explode(',', $data->service_id)) ? 'selected' : '' }}>
                                                            {{ $sub->service_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span id="sub_category_error" class="text-danger"></span>
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
                                                        aria-label="Product Price" value="{{ $data->product_price }}">
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
                                                        value="{{ $data->product_discount_price }}">
                                                </div>
                                                <span
                                                    class="text-danger">{{ $errors->first('product_discount_price') }}</span>
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

                                    {{-- Row 4  --}}
                                    {{-- <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cat_id" class="form-label">Category <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" data-trigger id="cat_id" name="cat_id">
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
                                    </div> --}}


                                    <!-- Service Description -->
                                    <div class="mb-3">
                                        <label for="product_description" class="form-label">
                                            Product Description <span style="color: red;">*</span>
                                        </label>
                                        <div id="snow-editor" style="height: 200px; background-color: #edeff166;">
                                            {!! $data ? $data->product_description : '' !!}
                                        </div>
                                        <!-- Hidden Input to Store Quill Content -->
                                        <input type="hidden" name="product_description" id="product_description"
                                            value="{{ old('product_description', $data ? $data->product_description : '') }}" />
                                    </div>


                                    {{-- Is Featured --}}
                                    <div class="d-flex border-top pt-3">
                                        <span class="mb-0 h6 me-3">Is Featured</span>
                                        <div>
                                            <label class="form-check form-switch mb-3" dir="ltr"
                                                style="transform: scale(1.1);">
                                                <input type="checkbox" class="form-check-input" id="is_features"
                                                    name="is_features" {{ $data->is_features == 1 ? 'checked' : '' }}>
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
                                        <span class="error">{{ $errors->first('product_image') }}</span>
                                        <div id="imagePreview" class="d-flex flex-wrap mt-4">
                                            <!-- Existing Images -->
                                            @if ($data->productImages && count($data->productImages) > 0)
                                                @foreach ($data->productImages as $value)
                                                    <div class="image-container position-relative me-4 mb-3 border rounded"
                                                        id="image-preview_{{ $value->id }}"
                                                        style="width: 100px; height: 100px; overflow: hidden;">
                                                        <img src="{{ asset('images/product_images/' . $value->product_image) }}"
                                                            class="img-fluid"
                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                        <button type="button"
                                                            class="remove-image btn btn-danger btn-sm position-absolute"
                                                            style="top: -6px; right: -6px; width: 28px; height: 28px; font-size: 22px; font-weight: bold; color: white; background: linear-gradient(135deg, #ff6666, #cc3333); border: none; display: flex; align-items: center; justify-content: center; border-radius: 50%; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2); transition: transform 0.2s, box-shadow 0.2s;"
                                                            onclick="imageDeleteProduct({{ $value->id }}, this)">
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
            function imageDeleteProduct(id, element) {
                fetch(`{{ url('product-imagedelete') }}/${id}`, {
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


































        {{-- <script>
            function imageDeleteProduct(id, element) {
                $.ajax({
                    url: "{{ url('product-imagedelete') }}" + "/" + id,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        // Remove only the specific image preview element
                        $(element).closest('div').remove();
                    }
                });
            }
        </script>


        <script>
            $(document).ready(function() {
                // On category change, fetch and populate the subcategories

                // Image Upload Preview
                $('#imageUpload').on('change', function() {
                    var files = $(this)[0].files;
                    var existingImages = $('#imagePreview img').map(function() {
                        return $(this).attr('src');
                    }).get();

                    $('#imagePreview').html('');
                    for (var i = 0; i < existingImages.length; i++) {
                        $('#imagePreview').append('<img src="' + existingImages[i] +
                            '" width="80" height="80px" class="me-4 border">');
                    }
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
        </script> --}}


        <script>
            // Initialize Quill editor
            var quill = new Quill('#snow-editor', {
                theme: 'snow'
            });

            // Load existing content into Quill if available
            var existingContent = `{!! old('product_description', $data->product_description ?? '') !!}`;
            if (existingContent.trim() !== '') {
                quill.clipboard.dangerouslyPasteHTML(existingContent);
            }

            // Ensure the editor content is passed to the hidden input before submitting
            document.getElementById('termsConditionForm').addEventListener('submit', function() {
                document.getElementById('product_description').value = quill.root.innerHTML;
            });
        </script>
    @endsection
