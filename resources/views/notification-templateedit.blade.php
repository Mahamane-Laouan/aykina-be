@extends('layouts.master')

@section('title')
    Edit Notification Template
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
    <link href="{{ URL::asset('build/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />

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
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">Edit Notification Template <span class="text-muted fw-normal ms-2"></span></h5>
                    <p class="text-muted">Notification Template / Edit Notification Template</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/notification-template" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Notification Template Information</h4>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title mb-0">Parameters</h4>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button type="button" class="btn btn-outline-primary">Booking ID</button>
                            <button type="button" class="btn btn-outline-primary">Handyman Name</button>
                            <button type="button" class="btn btn-outline-primary">Provider Name</button>
                            <button type="button" class="btn btn-outline-primary">Service Name</button>
                            <button type="button" class="btn btn-outline-primary">Booked Service Name</button>
                            <button type="button" class="btn btn-outline-primary">Amount</button>
                            <button type="button" class="btn btn-outline-primary">Username</button>
                            <button type="button" class="btn btn-outline-primary">Rating</button>
                            <button type="button" class="btn btn-outline-primary">Product Name</button>
                            <button type="button" class="btn btn-outline-primary">Currency</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('notification-templateupdate', ['id' => $notifytemp->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="mb-3">
                                        <label for="label" class="form-label">Template Name <span
                                                style="color: red;">*</span></label>
                                        <input type="text" id="label" value="{{ $notifytemp->label }}"
                                            placeholder="Enter Template Name" name="label"
                                            style="background-color: #edeff166;"
                                            class="form-control @error('label') is-invalid @enderror" disabled />
                                        @error('label')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Notification Title <span
                                                style="color: red;">*</span></label>
                                        <input type="text" id="title" value="{{ $notifytemp->title }}"
                                            placeholder="Enter Template Title" name="title"
                                            class="form-control @error('title') is-invalid @enderror" />
                                        @error('title')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Notification Text <span
                                                style="color: red;">*</span></label>
                                        <div id="snow-editor" style="height: 300px;  background-color: #edeff166;">
                                            {!! $notifytemp ? $notifytemp->description : '' !!}</div>
                                        <!-- Add a textarea to store Quill content -->
                                        <textarea name="description" id="description" style="display: none;"></textarea> <!-- Hidden textarea -->
                                    </div>

                                    <div class="mb-3">
                                        <label for="notify_desc" class="form-label">
                                            Description <span style="color: red;">*</span>
                                        </label>
                                        <textarea id="notify_desc" name="notify_desc" rows="4" placeholder="Enter Description"
                                            class="form-control @error('notify_desc') is-invalid @enderror">{{ old('notify_desc', $notifytemp->notify_desc) }}</textarea>

                                        @error('notify_desc')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control" data-trigger id="status" name="status">
                                            <option value="">Select an option</option>
                                            <option value="1"
                                                {{ old('status', $notifytemp->status) == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0"
                                                {{ old('status', $notifytemp->status) == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                        <span id="status_error"
                                            class="error text-danger">{{ $errors->first('status') }}</span>
                                    </div>

                                    <div>
                                        <!-- Update the submit button to call the function on click -->
                                        <button type="submit" class="btn btn-primary w-md"
                                            onclick="handleFormSubmission(event)">Update</button>
                                    </div>

                                </div>
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
        <script src="{{ URL::asset('build/libs/quill/quill.min.js') }}"></script>

        <script>
            // Initialize the Quill editor
            var quill = new Quill('#snow-editor', {
                theme: 'snow'
            });

            // Set initial content in the editor
            var initialContent = `{!! addslashes($notifytemp ? $notifytemp->description : '') !!}`;
            quill.root.innerHTML = initialContent;

            // Map parameter buttons to their corresponding placeholders
            const parameters = {
                "Booking ID": "[[ booking_id ]]",
                "Handyman Name": "[[ handyman_name ]]",
                "Provider Name": "[[ providername ]]",
                "Service Name": "[[ service_name ]]",
                "Booked Service Name": "[[ booking_services_name ]]",
                "Amount": "[[ amount ]]",
                "Username": "[[ user_name ]]",
                "Rating": "[[ rating ]]",
                "Product Name": "[[ product_name ]]",
                "Currency": "[[ currency ]]",
            };

            // Highlight buttons if their parameter exists in the content
            function highlightButtons() {
                const content = quill.root.innerHTML;
                document.querySelectorAll('.btn-outline-primary').forEach(button => {
                    const parameterText = parameters[button.textContent.trim()];
                    if (content.includes(parameterText)) {
                        button.classList.add('btn-primary');
                        button.classList.remove('btn-outline-primary');
                    } else {
                        button.classList.add('btn-outline-primary');
                        button.classList.remove('btn-primary');
                    }
                });
            }

            // Insert parameter into the editor at cursor position
            document.querySelectorAll('.btn-outline-primary').forEach(button => {
                button.addEventListener('click', () => {
                    const parameterText = parameters[button.textContent.trim()];
                    const range = quill.getSelection(true);
                    if (range) {
                        quill.insertText(range.index, parameterText);
                        quill.setSelection(range.index + parameterText.length);
                        highlightButtons(); // Update button highlights
                    }
                });
            });

            // Ensure the editor content is passed to the hidden input before the form is submitted
            // Function to handle the form submission
            function handleFormSubmission(event) {
                // Prevent form submission
                event.preventDefault();

                // Get Quill editor content
                var content = quill.root.innerHTML.trim();

                // Remove only <p> tags, keeping other HTML tags
                var cleanedContent = content.replace(/<\/?p>/g, ""); // This removes only <p> tags

                // Set the cleaned content in the hidden textarea
                document.getElementById('description').value = cleanedContent;

                // Check if the content is correctly set (optional)
                console.log('Description: ', document.getElementById('description').value);

                // Manually submit the form
                var form = event.target.closest('form');
                form.submit();
            }

            // Highlight buttons on page load
            highlightButtons();
        </script>
    @endsection
