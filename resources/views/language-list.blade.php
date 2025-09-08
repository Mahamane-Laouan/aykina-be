@extends('layouts.master')

@section('title')
    Language
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->first_name }} {{ $userwelcomedata->last_name }}
@endsection

@section('css')
    <style>
        .list-inline-item {
            margin-right: -0.5rem !important;
        }
    </style>
@endsection

@section('body')
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

    {{-- Heading detail --}}
    <div class="row align-items-center">
        <div class="col-md-3" style="padding-top: 18px;">
            <div class="mb-3">
                <h5 class="card-title">Language <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Settings Managment / Language</p>
            </div>
        </div>
    </div>


    {{-- Category List Table --}}
    <div class="row" style="padding-top: 20px;">

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="col-lg-12">
            <div class="card">

                <div class="d-flex justify-content-between align-items-center" style="padding-top: 15px;">

                    <h2 class="card-title" style="margin-left: 25px;">Language</h2>

                    <a href="{{ route('language-add') }}" class="btn btn-primary" style="margin-right: 25px;">Add
                        Language</a>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="min-width: 10rem; color: #ffff;">Language</th>
                                    <th scope="col" style="color: #ffff;">Alignment</th>
                                    <th scope="col" style="color: #ffff;">Status</th>
                                    <th scope="col" style="color: #ffff;">Default</th>
                                    <th scope="col" style="color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($records->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                <i class="bx bx-globe" style="font-size: 2.5rem; color: #fff;"></i>
                                            </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #222E50;">
                                                    No Languages Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($records as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('language-edit', $user->status_id) }}"
                                                    class="text-body text-decoration-none">
                                                    <span style="color: #0046AE;">{{ $user->language ?? '' }}</span>
                                                </a>
                                            </td>

                                            <td>
                                                <div class="text-body text-decoration-none">
                                                    <span>
                                                        {{ $user->language_alignment == 'ltr' ? 'LTR' : ($user->language_alignment == 'rtl' ? 'RTL' : '') }}
                                                    </span>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="form-check form-switch mb-3" dir="ltr"
                                                    style="padding-top: 10px;">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="customSwitch{{ $user->status_id }}"
                                                        {{ $user->status == 1 ? 'checked' : '' }}
                                                        onchange="changeLanguageListStatus ({{ $user->status_id }}, this.checked)"
                                                        style="transform: scale(1.3);">
                                                    <label class="form-check-label"
                                                        for="customSwitch{{ $user->status_id }}"
                                                        style="font-size: 1.2rem;"></label>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="form-check form-switch mb-3" dir="ltr"
                                                    style="padding-top: 10px;">
                                                    <input type="checkbox" class="form-check-input default-status-toggle"
                                                        id="customSwitchDefault{{ $user->status_id }}"
                                                        {{ $user->default_status == 1 ? 'checked' : '' }}
                                                        onchange="changeLanguageListeDefaultStatus({{ $user->status_id }}, this.checked)"
                                                        style="transform: scale(1.3);">
                                                    <label class="form-check-label"
                                                        for="customSwitchDefault{{ $user->status_id }}"
                                                        style="font-size: 1.2rem;"></label>
                                                </div>
                                            </td>



                                            <td>
                                                <a href="{{ route('language-edit', $user->status_id) }}"
                                                    class="btn btn-primary btn-md waves-effect waves-light">
                                                    Edit
                                                </a>
                                                <a href="{{ route('language-translatelist', $user->status_id) }}"
                                                    class="btn btn-danger btn-md waves-effect waves-light">
                                                    Translate
                                                </a>
                                            </td>


                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Pagination --}}
    <div class="row">
        <div class="col-md-12" style="padding-top: 17px;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="entries-info">
                    Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of
                    {{ $records->total() }} entries
                </div>
                <div class="pagination-container">
                    @if ($records->hasPages())
                        <nav>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($records->onFirstPage())
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $records->previousPageUrl() }}"
                                            rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach (range(1, $records->lastPage()) as $page)
                                    @if ($page == 1 || $page == $records->lastPage() || abs($page - $records->currentPage()) <= 2)
                                        @if ($page == $records->currentPage())
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $records->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @elseif ($page == 2 || $page == $records->lastPage() - 1)
                                        {{-- Skip showing ellipsis for the second page and second last page --}}
                                        <li class="page-item disabled" aria-disabled="true">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($records->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $records->nextPageUrl() }}"
                                            rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>



    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" />

    <!-- Toastify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

    <script>
        var baseUrl = "{{ url('/') }}/";

        function changeLanguageListStatus(status_id, isChecked) {
            console.log('Function triggered for user ID: ' + status_id); // Log when the function is triggered

            // Prepare the status message and background color based on the checkbox state (activated/deactivated)
            var statusMessage = isChecked ? "\u2714 Language Activated" : "\u26A0 Language Deactivated";
            var bgColor = isChecked ?
                "linear-gradient(to right, #5A9FE7, #164A8D)" // Light to Dark Blue Gradient
                :
                "linear-gradient(to right, #F4A261, #E76F51)"; // Warm Orange to Red Gradient


            // Send AJAX request to update the status
            $.ajax({
                url: baseUrl + 'change-languageliststatus/' + status_id,
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log('AJAX request successful. Response: ', data); // Log success response

                    // Show success message using Toastify
                    Toastify({
                        text: statusMessage,
                        duration: 2000,
                        gravity: "top",
                        position: "center",
                        offset: {
                            y: 80
                        }, // Move the toast a bit down
                        backgroundColor: bgColor,
                        stopOnFocus: true,
                        close: true,
                        style: {
                            borderRadius: "12px",
                            boxShadow: "0px 6px 15px rgba(0, 0, 0, 0.3)",
                            fontSize: "18px",
                            padding: "14px 24px",
                            fontWeight: "bold",
                            color: "#fff",
                            textShadow: "1px 1px 2px rgba(0, 0, 0, 0.2)"
                        },
                        callback: function() {
                            console.log('Toast message closed'); // Log when the toast is closed
                        }
                    }).showToast();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed. Error: ', error); // Log the error if the request fails

                    // Show error message using Toastify
                    Toastify({
                        text: "\u26A0 There was an error changing the status.",
                        duration: 2000,
                        gravity: "top",
                        position: "center",
                        offset: {
                            y: 80
                        }, // Move the toast a bit down
                        backgroundColor: "linear-gradient(to right, #FF7F7F, #B22222)",
                        stopOnFocus: true,
                        close: true,
                        style: {
                            borderRadius: "12px",
                            boxShadow: "0px 6px 15px rgba(0, 0, 0, 0.3)",
                            fontSize: "18px",
                            padding: "14px 24px",
                            fontWeight: "bold",
                            color: "#fff",
                            textShadow: "1px 1px 2px rgba(0, 0, 0, 0.2)"
                        }
                    }).showToast();

                    // Revert the checkbox if the request failed (to maintain the correct status on the UI)
                    $('#customSwitch' + id).prop('checked', !isChecked);
                }
            });
        }
    </script>



    <script>
        var baseUrl = "{{ url('/') }}/";

        function changeLanguageListeDefaultStatus(status_id, isChecked) {
            console.log('Function triggered for status ID: ' + status_id);

            var default_status = isChecked ? 1 : 0;

            $.ajax({
                url: baseUrl + 'change-languagelistdefaultstatus',
                type: 'POST',
                data: {
                    status_id: status_id,
                    default_status: default_status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log('AJAX request successful. Response: ', data);

                    // If setting one as default (checked), uncheck all others
                    if (default_status === 1) {
                        $('.default-status-toggle').each(function() {
                            if (this.id !== 'customSwitchDefault' + status_id) {
                                $(this).prop('checked', false);
                            }
                        });
                    }

                    // Show success message using Toastify
                    Toastify({
                        text: isChecked ? "\u2714 Language Set as Default" :
                            "\u26A0 Language Deactivated",
                        duration: 2000,
                        gravity: "top",
                        position: "center",
                        offset: {
                            y: 80
                        },
                        backgroundColor: isChecked ?
                            "linear-gradient(to right, #5A9FE7, #164A8D)" :
                            "linear-gradient(to right, #F4A261, #E76F51)",
                        stopOnFocus: true,
                        close: true,
                        style: {
                            borderRadius: "12px",
                            boxShadow: "0px 6px 15px rgba(0, 0, 0, 0.3)",
                            fontSize: "18px",
                            padding: "14px 24px",
                            fontWeight: "bold",
                            color: "#fff",
                            textShadow: "1px 1px 2px rgba(0, 0, 0, 0.2)"
                        }
                    }).showToast();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed. Error: ', error);

                    // Show error message
                    Toastify({
                        text: "\u26A0 There was an error changing the status.",
                        duration: 2000,
                        gravity: "top",
                        position: "center",
                        offset: {
                            y: 80
                        },
                        backgroundColor: "linear-gradient(to right, #FF7F7F, #B22222)",
                        stopOnFocus: true,
                        close: true,
                        style: {
                            borderRadius: "12px",
                            boxShadow: "0px 6px 15px rgba(0, 0, 0, 0.3)",
                            fontSize: "18px",
                            padding: "14px 24px",
                            fontWeight: "bold",
                            color: "#fff",
                            textShadow: "1px 1px 2px rgba(0, 0, 0, 0.2)"
                        }
                    }).showToast();

                    // Revert checkbox state if request fails
                    $('#customSwitchDefault' + status_id).prop('checked', !isChecked);
                }
            });
        }
    </script>
@endsection
