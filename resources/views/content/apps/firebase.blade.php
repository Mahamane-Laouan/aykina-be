@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Firebase')

@section('page-script')
    <script src="{{ asset('assets/js/firebase.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Settings /</span> Firebase
    </h4>
    <div class="row g-4 mb-4">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
    </div>
    <div class="row g-4">
        <!-- Options -->
        <div class="col-12 col-lg-8 pt-4 pt-lg-0">
            <div class="tab-content p-0">
                <!-- Payment Mode -->
                <div class="tab-pane fade show active" id="store_details" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">Firebase</h5>
                        </div>
                        <div class="card-body">
                            <form id="addFirebase" method="post" action="{{ route('firebase-save') }}">
                                @csrf
                                <!-- Firebase Key -->
                                <div class="row mb-3 g-3">
                                    <div class="col-12 col-md-12">
                                        <label class="form-label" for="firebase_key">Firebase Key<span style="color: red;">
                                                *</span></label>
                                        <input type="text" placeholder="Enter Firebase Key" name="firebase_key"
                                            value="{{ old('firebase_key') }}" id="firebase_key"
                                            class="form-control @error('firebase_key') is-invalid @enderror" />
                                        @error('firebase_key')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <input type="submit" class="btn btn-primary me-sm-3 me-1 data-submit" value="Submit"
                                    onclick="submitForm(event)">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('_partials/_modals/modal-select-payment-providers')
    @include('_partials/_modals/modal-select-payment-methods')

@endsection
