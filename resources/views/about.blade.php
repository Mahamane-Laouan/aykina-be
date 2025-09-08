@extends('layouts.master')
@section('title')
    About
@endsection
@section('css')
    <!-- quill css -->
    <link href="{{ URL::asset('build/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
@endsection
@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        {{-- About Headline --}}
        <div class="row align-items-center">
            <div class="col-md-3" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title">About <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Pages / About</p>
                </div>
            </div>
        </div>

        <div class="row">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="col-lg-12" style="padding-top: 25px;">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">About</h4>
                    </div>
                    <div class="card-body">



                        <form action="{{ route('aboutsave') }}" method="POST" id="aboutsaveForm">
                            @csrf
                            <div id="snow-editor" style="height: 300px;">
                                {!! $policy ? $policy->text : '' !!}
                            </div>
                            <input type="hidden" name="text" id="text"
                                value="{{ old('text', $policy ? $policy->text : '') }}" />
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @section('scripts')
        <!-- quill js -->
        <script src="{{ URL::asset('build/libs/quill/quill.min.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            // Initialize the Quill editor
            var quill = new Quill('#snow-editor', {
                theme: 'snow'
            });

            // Ensure the editor content is passed to the hidden input before the form is submitted
            document.getElementById('aboutsaveForm').onsubmit = function() {
                var text = document.querySelector('#snow-editor .ql-editor').innerHTML;
                document.getElementById('text').value = text;
            };
        </script>
    @endsection
