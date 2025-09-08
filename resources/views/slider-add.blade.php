@extends('layouts.master')
@section('title')
    Add Slider
@endsection
@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
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
        {{-- Add Slider Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Add a new Slider <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Slider List / Add Slider</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/slider-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Slider information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('slider-save') }}" method="POST" enctype="multipart/form-data">
                            @csrf


                            <div class="mb-3">
                                <label for="banner_name" class="form-label">Slider Title<span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="banner_name"
                                    placeholder="Enter Sub Category Name" name="banner_name" value="{{ old('banner_name') }}"
                                    aria-label="Plan Name">
                                <span id="banner_name_error" class="error text-danger">{{ $errors->first('banner_name') }}</span>
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
                                <label for="banner_image" class="form-label">Slider Image <span class="text-muted" >(Recommended size: 390px*192px
                                    )</span> <span
                                        style="color: red;">*</span></label>
                                <input class="form-control" type="file" id="banner_image" name="banner_image"
                                    onchange="previewImage(event)">
                                <span id="image_error" class="error text-danger">{{ $errors->first('banner_image') }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="image_preview" class="form-label"></label>
                                <img id="image_preview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 150px; max-height: 150px;" />
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
