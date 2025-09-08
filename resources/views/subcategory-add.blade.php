@extends('layouts.master')

@section('title')
    Add Sub Category
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">
@endsection

<style>
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

    .choices__list--dropdown .choices__item {
        color: #000 !important;
    }


    .choices__inner {
        background-color: #edeff166 !important;
    }
</style>

@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Add Sub Category Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Add a new Sub Category <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Sub Category List / Add Sub Category</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/subcategory-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Sub Category information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('subcategory-save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="c_name" class="form-label">Sub Category Name<span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="c_name"
                                    placeholder="Enter Sub Category Name" name="c_name" value="{{ old('c_name') }}"
                                    aria-label="Plan Name">
                                <span id="c_name_error" class="error text-danger">{{ $errors->first('c_name') }}</span>
                            </div>


                            <div class="mb-3">
                                <label for="choices-single-groups" class="form-label">Select Parent Category <span
                                        style="color: red;">*</span></label>
                                <select class="form-control" data-trigger id="cat_id" name="cat_id">

                                    <option value="">Select Parent Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->c_name }}</option>
                                    @endforeach
                                </select>
                                <span id="cat_id_error" class="error text-danger">{{ $errors->first('cat_id') }}</span>
                            </div>


                             <div class="mb-3">
                                <label for="img" class="form-label">SubCategory Icon </label>
                                <input class="form-control" type="file" id="img" name="img"
                                    onchange="previewImage(event)">
                                <span id="image_error" class="error text-danger">{{ $errors->first('img') }}</span>
                            </div>


                            <div class="mb-3">
                                <label for="image_preview" class="form-label"></label>
                                <img id="image_preview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 150px; max-height: 150px;" />
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span style="color: red;">*</span></label>
                                <select class="form-control" data-trigger id="status" name="status">
                                    <option value="">Select an option</option>
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <span id="status_error" class="error text-danger">{{ $errors->first('status') }}</span>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

         <script>
            function previewImage(event) {
                const imageInput = event.target;
                const preview = document.getElementById('image_preview');

                if (imageInput.files && imageInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(imageInput.files[0]);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            }
        </script>
    @endsection
