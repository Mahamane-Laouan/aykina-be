@extends('layouts/layoutMaster')

@section('title', 'Edit Sub Category')

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
    <script src="{{ asset('assets/js/categories-edit.js') }}"></script>
@endsection


@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Sub Category /</span><span> Edit Sub Category</span>
    </h4>

    <div class="app-ecommerce">

        <!-- Edit Sub Category -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Edit Sub Category</h4>
                <p class="text-muted">Explore and edit sub category</p>
            </div>

            <div class="text-end">
                <button type="button" id="backButton" class="btn btn-outline-secondary">Back</button>
            </div>
        </div>

        <form class="edit-category pt-0" id="editCategoryForm" method="post"
            action="{{ route('subcategories-update', ['id' => $category->id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Sub Category Information -->
                <div class="col-12 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Sub Category information</h5>
                        </div>
                        <div class="card-body">

                            <!-- Sub Category Name -->
                            <div class="row">
                                <div class="col-md-12" style="padding-bottom: 20px;">
                                    <label class="form-label" for="c_name">Sub Category Name<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="c_name" value="{{ $category->c_name }}"
                                        placeholder="Enter Sub Category Name" name="c_name"
                                        class="form-control @error('c_name') is-invalid @enderror" />
                                    @error('c_name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-12" style="padding-bottom: 20px;">
                                    <label class="form-label" for="description">Sub Category Description<span
                                            style="color: red;"> *</span></label>
                                    <textarea id="description" placeholder="Enter Sub Category Description" name="description" rows="4"
                                        class="form-control @error('description') is-invalid @enderror">{{ $category->description }}</textarea>
                                    @error('description')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="row" style="padding-bottom: 8px;">
                                    <div class="mb-3 col ecommerce-select2-dropdown" style="padding-top: 4px;">
                                        <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                            for="is_features">
                                            <span>Featured<span style="color: red;">*</span></span><a
                                                href="javascript:void(0);" class="fw-medium"></a>
                                        </label>
                                        <select id="is_features" class="select2 form-select" name="is_features"
                                            data-placeholder="Choose Status">
                                            <option value="">Choose Status</option>
                                            <option value="1" {{ $category->is_features == '1' ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                            <option value="0" {{ $category->is_features == '0' ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col ecommerce-select2-dropdown" style="padding-top: 4px;">
                                        <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                            for="status">
                                            <span>Status<span style="color: red;">*</span></span><a
                                                href="javascript:void(0);" class="fw-medium"></a>
                                        </label>
                                        <select id="status" class="select2 form-select" name="status"
                                            data-placeholder="Choose Status">
                                            <option value="">Choose Status</option>
                                            <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>On
                                            </option>
                                            <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>Off
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                {{-- Image Upload --}}
                                <div class="form-group" style="padding-bottom: 20px;">
                                    <label class="form-label" for="img">Sub Category Image<span
                                            style="color: red;">*</span></label>

                                    <!-- File input for new images -->
                                    <div class="custom-file">
                                        <input type="file" name="img" class="form-control form-control-lg"
                                            id="exampleInputFile">
                                    </div>

                                    <!-- Display existing images -->
                                    @if (!empty($existingImage))
                                        <div class="existing-images-preview" style="display: flex; gap:0.5rem">
                                            @foreach ($existingImage as $image)
                                                <div class="existing-image"
                                                    style="max-width: 150px; max-height: 140px; overflow: hidden;">
                                                    <img src="{{ asset('/assets/images/subcategory/' . $image) }}"
                                                        alt="Existing Image"
                                                        style="width: 100%; height: 100px; margin-block: 1rem"
                                                        class="existing-image">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
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
            window.location.href = "{{ route('subcategories-list') }}";
        });
    });
</script>
