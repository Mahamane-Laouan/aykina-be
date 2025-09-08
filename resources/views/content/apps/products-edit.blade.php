@extends('layouts/layoutMaster')

@section('title', 'Edit Product')

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
    <script src="{{ asset('assets/js/services-edit.js') }}"></script>
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
        <span class="text-muted fw-light">Products /</span><span> Edit Product</span>
    </h4>

    <div class="app-ecommerce">
        <!-- Edit Product -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Edit Product</h4>
                <p class="text-muted">Feel free to make any necessary edits</p>
            </div>

            <div class="text-end">
                <button type="button" id="backButton" class="btn btn-outline-secondary">Back</button>
            </div>
        </div>

        <form class="edit-service pt-0" id="editServiceForm" method="post"
            action="{{ route('products-update', ['id' => $service->product_id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Product Information -->
                <div class="col-12 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Product information</h5>
                        </div>
                        <div class="card-body">

                            <!-- Product Name -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="product_name">Product Name<span
                                            style="color: red;">*</span></label>
                                    <input type="text" id="product_name" value="{{ $service->product_name }}"
                                        placeholder="Enter Service Name" name="product_name"
                                        class="form-control @error('product_name') is-invalid @enderror" />
                                    @error('product_name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category Dropdown -->
                                <div class="col-md-6" style="margin-top: 4px; padding-bottom: 24px">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="cat_id">
                                        <span>Category<span style="color: red;">*</span></span>
                                    </label>
                                    <select id="cat_id" name="cat_id" class="select2 form-select"
                                        data-placeholder="Select Category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $service->cat_id ? 'selected' : '' }}>
                                                {{ $category->c_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Featured Category Services Checkbox -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="1" id="status" name="status"
                                    {{ $service->status ? 'checked' : '' }}>
                                <label class="form-label" for="status">Featured Product Services</label>
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
                                    <input type="hidden" id="res_desc_input" name="product_description"
                                        value="{{ old('product_description', $service->product_description) }}" />
                                    <div class="comment-editor border-0 pb-4" id="product_description">
                                        {!! old('product_description', $service->product_description) !!}</div>
                                </div>
                            </div>

                            <!-- Phone Number, Website -->
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="product_price">Price<span
                                            style="color: red;">*</span></label>
                                    <input type="text" id="product_price" value="{{ $service->product_price }}"
                                        placeholder="Enter Price" name="product_price"
                                        class="form-control @error('product_price') is-invalid @enderror" />
                                    @error('product_price')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label" for="product_price">Sale Price<span
                                            style="color: red;">*</span></label>
                                    <input type="text" id="product_price" value="{{ $service->product_price }}"
                                        placeholder="Enter Price" name="product_price"
                                        class="form-control @error('product_price') is-invalid @enderror" />
                                    @error('product_price')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            {{-- Provider and Sub category dropdown --}}
                            <div class="row mb-3">
                                <div class="mb-3 col ecommerce-select2-dropdown" style="margin-top: 7px">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="subc_id">
                                        <span>Sub Category<span style="color: red;">*</span></span>
                                    </label>
                                    <select id="subc_id" name="subc_id" class="select2 form-select"
                                        data-placeholder="Select Sub Category">
                                        <option value="">Select Sub Category</option>
                                        @foreach ($subcategorys as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ $subcategory->id == $service->subc_id ? 'selected' : '' }}>
                                                {{ $subcategory->c_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Vendor Dropdown -->
                                <div class="mb-3 col ecommerce-select2-dropdown" style="margin-top: 7px">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="vid">
                                        <span>Provider<span style="color: red;">*</span></span>
                                    </label>
                                    <select id="vid" name="vid" class="select2 form-select"
                                        data-placeholder="Select Provider">
                                        <option value="">Select Provider</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}"
                                                {{ $vendor->id == $service->vid ? 'selected' : '' }}>
                                                {{ $vendor->firstname }} {{ $vendor->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            {{-- Image Upload --}}
                            <div class="form-group" style="padding-bottom: 20px;">
                                <label class="form-label" for="product_name">Product Images (Multiple Images Possible to
                                    Upload)<span style="color: red;">*</span></label>

                                <!-- File input for new images -->
                                <div class="custom-file">
                                    <input type="file" name="product_image[]" class="form-control form-control-lg"
                                        id="exampleInputFile" multiple>
                                </div>

                                <!-- Display existing images -->
                                @if (!empty($existingImages))
                                    <div class="existing-images-preview" style="display: flex; gap:0.5rem">
                                        @foreach ($existingImages as $image)
                                            <div class="existing-image"
                                                style="max-width: 150px; max-height: 140px; overflow: hidden;">
                                                <img src="{{ asset('/assets/images/product/' . $image) }}"
                                                    alt="Existing Image"
                                                    style="width: 100%; height: 100px; margin-block: 1rem"
                                                    class="existing-image">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
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
            window.location.href = "{{ route('products-list') }}";
        });
    });
</script>
