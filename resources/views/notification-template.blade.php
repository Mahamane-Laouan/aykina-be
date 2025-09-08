@extends('layouts.master')

@section('title')
    Notification Template
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
                <h5 class="card-title">Notification Template <span
                        class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>

                <p class="text-muted">Settings Management / Notification Template</p>
            </div>
        </div>

        <div class="col-md-3">
        </div>

        <div class="col-md-3">
        </div>

        {{-- Search Icon --}}
        <div class="col-md-3" style="padding-top: 18px;">
            <div class="input-group"
                style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden;">
                <span class="input-group-text" id="search-icon"
                    style="background-color: #f9f9f9; color: #6c757d; font-size: 1.25rem; border: none;">
                    <i class="bx bx-search"></i>
                </span>
                <input type="text" id="searchInput" class="form-control" placeholder="Search by notification title"
                    aria-label="Search" aria-describedby="search-icon"
                    style="border: none; box-shadow: none; outline: none; color: #495057;">
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="min-width: 16rem; color: #ffffff;">Template Name</th>
                                    <th scope="col" style="color: #ffff;">Role</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffffff;">Notification Title</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffffff;">Notification Description
                                    </th>
                                    <th scope="col" style="color: #ffff;">Status</th>
                                    <th scope="col" style="color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($records->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-clipboard" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Notification Template Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($records as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('notification-templateedit', $user->id) }}"
                                                    class="text-body text-decoration-none">
                                                    <span style="color: #246FC1;">{{ $user->label ?? '' }}</span>
                                                </a>
                                            </td>

                                            <td>
                                                @php
                                                    $roles = explode(',', $user->role_type); // Split roles if stored as comma-separated values
                                                @endphp

                                                @foreach ($roles as $role)
                                                    @if (trim($role) === 'Provider')
                                                        <span
                                                            class="badge bg-primary-subtle text-primary font-size-14">Provider</span>
                                                    @elseif (trim($role) === 'Handyman')
                                                        <span
                                                            class="badge bg-danger-subtle text-danger font-size-14">Handyman</span>
                                                    @elseif (trim($role) === 'User')
                                                        <span
                                                            class="badge bg-success-subtle text-success font-size-14">Customer</span>
                                                    @endif
                                                @endforeach
                                            </td>


                                            <td>
                                                <div class="text-body text-decoration-none">
                                                    <span>{{ $user->title ?? '' }}</span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="text-body text-decoration-none">
                                                    <span>{{ Str::limit($user->notify_desc ?? '', 50) }}</span>
                                                    <!-- Limit description to 50 characters -->
                                                </div>
                                            </td>


                                            <td>
                                                <div class="form-check form-switch mb-3" dir="ltr"
                                                    style="padding-top: 10px;">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="customSwitch{{ $user->id }}"
                                                        {{ $user->status == 1 ? 'checked' : '' }}
                                                        onchange="changeNotificationTemplateStatus ({{ $user->id }}, this.checked)"
                                                        style="transform: scale(1.1);">
                                                    <label class="form-check-label" for="customSwitch{{ $user->id }}"
                                                        style="font-size: 1.2rem;"></label>
                                                </div>
                                            </td>


                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('notification-templateedit', $user->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                            class="px-2 text-primary"><i
                                                                class="bx bx-pencil font-size-18"></i></a>
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

        function changeNotificationTemplateStatus(id, isChecked) {
            console.log('Function triggered for user ID: ' + id); // Log when the function is triggered

            // Prepare the status message and background color based on the checkbox state (activated/deactivated)
            var statusMessage = isChecked ? "\u2714 Notification Activated" : "\u26A0 Notification Deactivated";
            var bgColor = isChecked ?
                "linear-gradient(to right, #5A9FE7, #164A8D)" // Light to Dark Blue Gradient
                :
                "linear-gradient(to right, #F4A261, #E76F51)"; // Warm Orange to Red Gradient


            // Send AJAX request to update the status
            $.ajax({
                url: baseUrl + 'change-notificationtemplatestatus/' + id,
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



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const recordsTable = document.querySelector('tbody');
        const pagination = document.querySelector('.pagination-container'); // Pagination container
        const entriesInfo = document.querySelector('.entries-info'); // "Showing X to Y of Z entries" text

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.trim();

                // Hide pagination and entries info when search is active
                if (pagination) {
                    pagination.style.display = query ? 'none' : 'block';
                }

                if (entriesInfo) {
                    entriesInfo.style.display = query ? 'none' : 'block';
                }

                // Send an AJAX request
                fetch(`{{ route('notification-template') }}?search=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        recordsTable.innerHTML = ''; // Clear the table

                        if (data.records.length > 0) {
                            data.records.forEach(record => {
                                let rolesHtml = '';
                                const roles = record.role_type.split(',');
                                roles.forEach(role => {
                                    role = role.trim();
                                    if (role === 'Provider') {
                                        rolesHtml +=
                                            `<span class="badge bg-primary-subtle text-primary font-size-14">Provider</span> `;
                                    } else if (role === 'Handyman') {
                                        rolesHtml +=
                                            `<span class="badge bg-danger-subtle text-danger font-size-14">Handyman</span> `;
                                    } else if (role === 'User') {
                                        rolesHtml +=
                                            `<span class="badge bg-success-subtle text-success font-size-14">Customer</span> `;
                                    }
                                });

                                recordsTable.innerHTML += `
                                <tr>
                                    <td>
                                        <a href="${record.edit_url}" class="text-body text-decoration-none">
                                            <span style="color: #246FC1;">${record.label ?? ''}</span>
                                        </a>
                                    </td>

                                    <td>${rolesHtml}</td>

                                    <td>
                                        <div class="text-body text-decoration-none">
                                            <span>${record.title ?? ''}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="text-body text-decoration-none">
                                            <span>${record.notify_desc.length > 50 ? record.notify_desc.substring(0, 50) + '...' : record.notify_desc}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-check form-switch mb-3" dir="ltr" style="padding-top: 10px;">
                                            <input type="checkbox" class="form-check-input"
                                                id="customSwitch${record.id}"
                                                ${record.status == 1 ? 'checked' : ''}
                                                onchange="changeNotificationTemplateStatus(${record.id}, this.checked)"
                                                style="transform: scale(1.1);">
                                            <label class="form-check-label" for="customSwitch${record.id}"></label>
                                        </div>
                                    </td>

                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="${record.edit_url}" class="px-2 text-primary"><i class="bx bx-pencil font-size-18"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>`;
                            });
                        } else {
                            recordsTable.innerHTML = `
                            <tr>
                                        <td colspan="6" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-clipboard" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Notification Template Found</p>
                                            </div>
                                        </td>
                                    </tr>`;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });
</script>
