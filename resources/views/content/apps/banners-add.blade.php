@extends('layouts/layoutMaster')

@section('title', 'Add Banners')

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
    <script src="{{ asset('assets/js/banners-add.js') }}"></script>
@endsection


@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Banners /</span><span> Add Banners</span>
    </h4>

    <div class="app-ecommerce">

        <!-- Add Banners -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Add Banners</h4>
                <p class="text-muted">Explore and add banners</p>
            </div>
        </div>

        <form class="add-banners pt-0" id="addBannerForm" method="post" action="{{ route('banners-save') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Banner Information -->
                <div class="col-12 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Banner information</h5>
                        </div>
                        <div class="card-body">

                            <!-- Banner Name -->
                            <div class="row">
                                <div class="col-md-12" style="padding-bottom: 20px;">
                                    <label class="form-label" for="banners_name">Banner Name<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="banners_name" value="{{ old('banners_name') }}"
                                        placeholder="Enter Banner Name" name="banners_name"
                                        class="form-control @error('banners_name') is-invalid @enderror" />
                                    @error('banners_name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Image Upload --}}
                                <div class="form-group" style="padding-bottom: 20px;">
                                    <label class="form-label" for="image">Banners<span style="color: red;">
                                            *</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="form-control form-control-lg"
                                            id="exampleInputFile">
                                    </div>
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
