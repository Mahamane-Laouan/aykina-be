@extends('layouts.master')

@section('title')
    Tax List
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
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
                <h5 class="card-title">Tax List <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Financial Management / Tax List</p>
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

                    <h2 class="card-title" style="margin-left: 25px;">Tax List</h2>

                    <a href="{{ route('tax-add') }}" class="btn btn-primary" style="margin-right: 25px;">Add
                        Tax</a>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="min-width: 10rem; color: #ffff;">Tax Name</th>
                                    <th scope="col" style="color: #ffff;">Tax Rate</th>
                                    <th scope="col" style="color: #ffff;">Type</th>
                                    <th scope="col" style="color: #ffff;">Status</th>
                                    <th scope="col" style="color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($records->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-calculator" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Tax Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($records as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('tax-edit', $user->id) }}"
                                                    class="text-body text-decoration-none">
                                                    <span style="color: #246FC1;">{{ $user->name ?? '' }}</span>
                                                </a>
                                            </td>

                                            <td>{{ $user->tax_rate ?? '' }}</td>


                                            {{-- <td>
                                                @if ($user->type === '0')
                                                    <span
                                                        class="badge bg-primary-subtle text-primary font-size-14">Percentage</span>
                                                @elseif ($user->type === '1')
                                                    <span
                                                        class="badge bg-danger-subtle text-danger font-size-14">Fixed</span>
                                                @endif
                                            </td> --}}

                                            <td>
                                                <span class="badge badge-toggle" data-user-id="{{ $user->id }}" 
                                                    data-user-type="{{ $user->type }}" onclick="toggleUserType(this)"
                                                    style="cursor: pointer; padding: 6px 12px; font-size: 14px;
                                                           background-color: {{ $user->type == 0 ? '#007bff26' : '#dc354526' }};
                                                           color: {{ $user->type == 0 ? '#007bff' : '#dc3545' }};">
                                                    {{ $user->type == 0 ? 'Percentage' : 'Fixed' }}
                                                </span>
                                            </td>


                                            <td>
                                                <div class="form-check form-switch mb-3" dir="ltr"
                                                    style="padding-top: 10px;">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="customSwitch{{ $user->id }}"
                                                        {{ $user->status == 1 ? 'checked' : '' }}
                                                        onchange="changeTaxStatus ({{ $user->id }}, this.checked)"
                                                        style="transform: scale(1.1);">
                                                    <label class="form-check-label" for="customSwitch{{ $user->id }}"
                                                        style="font-size: 1.2rem;"></label>
                                                </div>
                                            </td>


                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('tax-edit', $user->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                            class="px-2 text-primary"><i
                                                                class="bx bx-pencil font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                            class="px-2 text-danger"
                                                            onclick="deleteTax({{ $user->id }})"><i
                                                                class="bx bx-trash-alt font-size-18"></i></a>
                                                    </li>
                                                </ul>
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

        function changeTaxStatus(id, isChecked) {
            console.log('Function triggered for user ID: ' + id); // Log when the function is triggered

            // Prepare the status message and background color based on the checkbox state (activated/deactivated)
            var statusMessage = isChecked ? "\u2714 Tax Activated" : "\u26A0 Tax Deactivated";
            var bgColor = isChecked ?
                "linear-gradient(to right, #5A9FE7, #164A8D)" // Light to Dark Blue Gradient
                :
                "linear-gradient(to right, #F4A261, #E76F51)"; // Warm Orange to Red Gradient


            // Send AJAX request to update the status
            $.ajax({
                url: baseUrl + 'change-taxstatus/' + id,
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
@endsection


{{-- deleteTax --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    function deleteTax(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert tax!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete tax!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'tax-delete/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Tax has been removed.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(function() {
                            location.reload(); // Refresh the page
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Cancelled Delete :)',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }

    function toggleUserType(element) {
        let button = $(element);
        let id = button.data('user-id');
        let currentType = parseInt(button.data('user-type'));
        let newType = currentType === 0 ? 1 : 0;

        $.ajax({
            url: "{{ route('toggle-user-type') }}",
            type: "POST",
            data: {
                id: id, // ✅ Ensure correct key
                type: newType,
                _token: $('meta[name="csrf-token"]').attr('content') // ✅ Ensure CSRF token
            },
            success: function(response) {
                if (response.success) {
                    // ✅ Update button dynamically
                    button.data('user-type', newType);
                    button.text(newType === 0 ? 'Percentage' : 'Fixed');
                    button.css({
                        'background-color': newType === 0 ? '#007bff26' : '#dc354526',
                        'color': newType === 0 ? '#007bff' : '#dc3545'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to update type!',
                        confirmButtonClass: 'btn btn-danger'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Something went wrong!',
                    confirmButtonClass: 'btn btn-danger'
                });
                console.error(xhr.responseText);
            }
        });
    }
</script>
