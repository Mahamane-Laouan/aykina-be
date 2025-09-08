@extends('layouts/layoutMaster')

@section('title', 'Edit Tax')

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
    <script src="{{ asset('assets/js/categories-add.js') }}"></script>
@endsection


@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Tax Rate /</span><span> Edit Tax</span>
    </h4>

    <div class="app-ecommerce">

        <!-- Edit Tax -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Edit Tax</h4>
                <p class="text-muted">Editing Value, One Tax at a Time</p>
            </div>
        </div>

        <form class="add-category pt-0" id="addCategoryForm" method="post"
            action="{{ route('taxrate-update', ['id' => $taxRate->id]) }}">
            @csrf
            <div class="row">
                <!-- Tax Rate Information -->
                <div class="col-12 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Tax Rate information</h5>
                        </div>
                        <div class="card-body">

                            <!-- Tax Name -->
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-category-title">Tax Name<span
                                            class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="title" name="name"
                                        aria-label="category title" placeholder="Enter Tax Name"
                                        value="{{ $taxRate->name }}">
                                    <span id="title-error" class="error">{{ $errors->first('name') }}</span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-category-title">Tax Rate<span
                                            class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="tax_rate" name="tax_rate"
                                        aria-label="category title" placeholder="Enter Tax Rate"
                                        value="{{ $taxRate->tax_rate }}">
                                    <span id="title-error" class="error">{{ $errors->first('tax_rate') }}</span>
                                </div>
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <div class="mb-3 ecommerce-select2-dropdown">
                                        <label class="form-label" for="ecommerce-country">Type<span class="text-danger">
                                                *</span></label>
                                        <select id="type" name="type" class="select2 form-select"
                                            data-placeholder="Select Type">
                                            <option value="">Select Type</option>
                                            <option value="0"{{ 0 == $taxRate->type ? 'selected' : '' }}>Percentage
                                            </option>
                                            <option value="1" {{ 1 == $taxRate->type ? 'selected' : '' }}>Fix Amount
                                            </option>
                                        </select>
                                        <span id="type" class="error">{{ $errors->first('type') }}</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-3">
                                    <span class="mb-0 h6">Status<span class="text-danger">*</span></span>
                                    <div class="w-25 d-flex justify-content-end">
                                        <input type="hidden" name="status" value="0">
                                        <label class="switch switch-primary switch-sm me-4 pe-2">
                                            <input type="checkbox" name="status" class="switch-input"
                                                {{ $taxRate->status == 1 ? 'checked' : '' }}>

                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <span class="switch-off"></span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <span class="text-muted fw-light">(Please Select Status)</span><br>
                                <span id="status-error" class="error"></span><br>
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
