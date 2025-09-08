@extends('layouts.master')

@section('title')
    Edit Category
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

@section('css')
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">

    <style>
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
    </style>
@endsection

@section('body')

    <body>
    @endsection
    @section('content')
        {{-- Edit Category Headline --}}
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Edit Category <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Category List / Edit Category</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/category-list" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Category information</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('category-update', ['id' => $category->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="c_name" class="form-label">Category Name <span
                                        style="color: red;">*</span></label>
                                <input type="text" id="c_name" value="{{ $category->c_name }}"
                                    placeholder="Enter Category Name" name="c_name"
                                    class="form-control @error('c_name') is-invalid @enderror" />
                                @error('c_name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span style="color: red;">*</span></label>
                                <select class="form-control" data-trigger id="status" name="status">
                                    <option value="">Select an option</option>
                                    <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                <span id="status_error" class="error text-danger">{{ $errors->first('status') }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="img" class="form-label">Category Image <span
                                        style="color: red;">*</span></label>
                                <!-- File input for new images -->
                                <div class="custom-file">
                                    <input type="file" name="img" class="form-control form-control-lg" id="imgInput"
                                        onchange="previewImage(event)">
                                </div>

                                @if (!empty($existingImage))
                                    <div class="existing-images-preview"
                                        style="max-width: 150px; max-height: 140px; overflow: hidden;">
                                        <img id="existingImage"
                                            src="{{ asset('images/category_images/' . $existingImage) }}"
                                            alt="Existing Image"
                                            style="width: 100%; height: 100px; object-fit: contain; margin-block: 1rem"
                                            class="existing-image">
                                    </div>
                                @else
                                    <img id="existingImage" src="" alt="New Image"
                                        style="max-width: 150px; max-height: 140px; display: none;">
                                @endif
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
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
                const reader = new FileReader();
                const imageField = document.getElementById('existingImage');

                reader.onload = function() {
                    if (reader.readyState === 2) {
                        imageField.src = reader.result;
                    }
                };

                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
    @endsection
