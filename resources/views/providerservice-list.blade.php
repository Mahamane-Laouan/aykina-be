@extends('layouts.master')

@section('title')
    Service List
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

@section('body')
@section('css')
    <style>
        .list-inline-item {
            margin-right: -0.5rem !important;
        }
    </style>
@endsection

<style>
    .table-light {

        --bs-table-bg: #246FC1 !important;

    }
</style>

@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

{{-- Heading detail --}}
<div class="row align-items-center">
    <div class="col-md-3" style="padding-top: 18px;">
        <div class="mb-3">
            <h5 class="card-title">Service List <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
            </h5>
            <p class="text-muted">Services / Service List</p>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Search by service name"
                aria-label="Search" aria-describedby="search-icon"
                style="border: none; box-shadow: none; outline: none; color: #495057;">
        </div>
    </div>
</div>


{{-- Service List Table --}}
<div class="row" style="padding-top: 20px;">

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="col-lg-12">
        <div class="card">

            <div class="d-flex justify-content-between align-items-center" style="padding-top: 15px;">
                <h2 class="card-title" style="margin-left: 25px;">Service List</h2>

                <a href="{{ route('providerservice-add') }}" class="btn btn-primary" style="margin-right: 25px;">Add
                    Service</a>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="min-width: 25rem; color: #ffff;">Service</th>
                                <th scope="col" style="min-width: 10rem; color: #ffff;">Category</th>
                                <th scope="col" style="color: #ffff;">Price</th>
                                <th scope="col" style="color: #ffff;">Featured</th>
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
                                                <i class="bx bx-briefcase" style="font-size: 2.5rem; color: #fff;"></i>
                                            </div>
                                            <p
                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                No Services Available</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($records as $user)
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 1rem;">

                                                {{-- Service Image --}}
                                                <div>
                                                    @if ($user->serviceImages->isNotEmpty())
                                                        <img src="{{ asset('images/service_images/' . $user->serviceImages->first()->service_images) }}"
                                                            alt="Service Image"
                                                            class="avatar rounded-circle img-thumbnail"
                                                            style="min-width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        {{-- Default Avatar --}}
                                                        <div class="avatar rounded-circle img-thumbnail"
                                                            style="background-color: #246FC1; color: #fff; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; height: 50px;">
                                                            <span style="font-size: 1.2rem;">
                                                                {{ strtoupper(substr($user->service_name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Service Details --}}
                                                <div style="flex: 1;">
                                                    {{-- Service Name with link, highlight, and limit --}}
                                                    <div class="text-body">
                                                        <a href="{{ route('providerservice-edit', $user->id) }}"
                                                            style="color: #246FC1; text-decoration: none;">
                                                            @php
                                                                $limitedName = Str::limit(
                                                                    $user->service_name ?? '',
                                                                    30,
                                                                );
                                                            @endphp

                                                            {!! $search
                                                                ? preg_replace('/(' . preg_quote($search, '/') . ')/i', '<mark>$1</mark>', $limitedName)
                                                                : $limitedName !!}
                                                        </a>
                                                    </div>

                                                    {{-- Service Description --}}
                                                    <small class="text-muted d-block">
                                                        Price:
                                                        @if (!empty($user->service_discount_price))
                                                            {{ $defaultCurrency }}{{ number_format($user->service_discount_price, 2) }}
                                                        @else
                                                            {{ $defaultCurrency }}{{ number_format($user->service_price, 2) }}
                                                        @endif
                                                        | Duration:
                                                        @php
                                                            $durationParts = explode(':', $user->duration);
                                                            $hours = (int) $durationParts[0];
                                                            $minutes = (int) $durationParts[1];

                                                            $formattedDuration = '';

                                                            if ($hours > 0) {
                                                                $formattedDuration .=
                                                                    $hours . ' hour' . ($hours > 1 ? 's' : '');
                                                            }

                                                            if ($minutes > 0) {
                                                                $formattedDuration .=
                                                                    ($formattedDuration ? ' ' : '') .
                                                                    $minutes .
                                                                    ' minute' .
                                                                    ($minutes > 1 ? 's' : '');
                                                            }
                                                        @endphp
                                                        {{ $formattedDuration }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>


                                        <td>{{ Str::limit($user->category->c_name ?? '', 20) }}</td>


                                        <td>
                                            @if ($user->service_discount_price && $user->service_discount_price > 0)
                                                <span
                                                    style="text-decoration: line-through; color: red;">{{ $defaultCurrency . $user->service_price }}</span>
                                                <span
                                                    style="color: green;">{{ $defaultCurrency . $user->service_discount_price }}</span>
                                            @else
                                                <span
                                                    style="color: green;">{{ $defaultCurrency . $user->service_price }}</span>
                                            @endif
                                        </td>


                                        <td>
                                            <div class="form-check form-switch mb-3" dir="ltr"
                                                style="padding-top: 10px;">
                                                <input type="checkbox" class="form-check-input"
                                                    id="customSwitch{{ $user->id }}"
                                                    {{ $user->is_features == 1 ? 'checked' : '' }}
                                                    onchange="ChangeProviderServiceStatus({{ $user->id }}, this.checked)"
                                                    style="transform: scale(1.1);">

                                                <label class="form-check-label"
                                                    for="customSwitch{{ $user->id }}"></label>
                                            </div>
                                        </td>


                                        <td>
                                            <div class="form-check form-switch mb-3" dir="ltr"
                                                style="padding-top: 10px;">
                                                <input type="checkbox" class="form-check-input"
                                                    id="customSwitch{{ $user->id }}"
                                                    {{ $user->status == 1 ? 'checked' : '' }}
                                                    onchange="changeProviderServiceLinkStatus ({{ $user->id }}, this.checked)"
                                                    style="transform: scale(1.1);">
                                                <label class="form-check-label" for="customSwitch{{ $user->id }}"
                                                    style="font-size: 1.2rem;"></label>
                                            </div>
                                        </td>

                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('providerservice-edit', $user->id) }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                        class="px-2 text-primary"><i
                                                            class="bx bx-pencil font-size-18"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete" class="px-2 text-danger"
                                                        onclick="deleteProviderService({{ $user->id }})"><i
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
<!-- App js -->
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<!-- Toastify CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" />

<!-- Toastify JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    function changeProviderServiceLinkStatus(id, isChecked) {
        console.log('Function triggered for user ID: ' + id); // Log when the function is triggered

        // Prepare the status message and background color based on the checkbox state (activated/deactivated)
        var statusMessage = isChecked ? "\u2714 Service Activated" : "\u26A0 Service Deactivated";
        var bgColor = isChecked ?
            "linear-gradient(to right, #5A9FE7, #164A8D)" // Light to Dark Blue Gradient
            :
            "linear-gradient(to right, #F4A261, #E76F51)"; // Warm Orange to Red Gradient


        // Send AJAX request to update the status
        $.ajax({
            url: baseUrl + 'change-providerservicelinkstatus/' + id,
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


{{-- deleteProviderService --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    // deleteProviderService;
    function deleteProviderService(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this service!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete service!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'providerservice-delete/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Service has been removed.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(function() {
                            location.reload(); // Refresh the page
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.message || 'Something went wrong!',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
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


    // ChangeProviderServiceStatus;
    function ChangeProviderServiceStatus(id, type) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this status!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change status!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + 'change-providerservicestatus/' + id,
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Changed!',
                            text: 'Status changed successfully.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(function() {
                            location.reload(); // Reload the page to see changes
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'There was an error changing the status.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Action cancelled :)',
                    icon: 'info',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }
</script>

<script>
    // Pass the default currency to JavaScript
    const defaultCurrency = "{{ $defaultCurrency }}"; // Fetch this from the controller
</script>


<!-- Search Ajax -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput'); // The search input field
        const serviceTable = document.querySelector('tbody'); // The table body
        const pagination = document.querySelector('.pagination-container'); // Pagination container
        const entriesInfo = document.querySelector('.entries-info'); // Entries info container

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.trim();

                // Toggle visibility of pagination and entries info
                if (pagination) {
                    pagination.style.display = query ? 'none' : 'block';
                }
                if (entriesInfo) {
                    entriesInfo.style.display = query ? 'none' : 'block';
                }

                // Send an AJAX request to the server
                fetch(`{{ route('providerservice-list') }}?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        serviceTable.innerHTML = ''; // Clear current table rows

                        if (data.records.length > 0) {
                            // Populate the table with fetched data
                            data.records.forEach(record => {
                                const discountedPrice = record.service_discount_price > 0 ?
                                    `<span style="text-decoration: line-through; color: red;">${defaultCurrency}${record.service_price}</span>
                                       <span style="color: green;">${defaultCurrency}${record.service_discount_price}</span>` :
                                    `<span style="color: green;">${defaultCurrency}${record.service_price}</span>`;


                                const serviceImage = record.service_images ?
                                    `<img src="${record.service_images}" alt="Service Image" class="avatar rounded-circle img-thumbnail" style="min-width: 50px; height: 50px; object-fit: cover;">` :
                                    `<div class="avatar rounded-circle img-thumbnail" style="background-color: #246FC1; color: #fff; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; height: 50px;">
                 <span style="font-size: 1.2rem;">${record.service_name.charAt(0).toUpperCase()}</span>
             </div>`;

             const blockedStatusTd = `
    <td>
        <div class="form-check form-switch mb-3" dir="ltr" style="padding-top: 10px;">
            <input type="checkbox" class="form-check-input"
                id="customSwitch${record.id}"
                ${record.status == 1 ? 'checked' : ''}
                onchange="changeProviderServiceLinkStatus(${record.id}, this.checked)" style="transform: scale(1.1);">
            <label class="form-check-label" for="customSwitch${record.id}"></label>
        </div>
    </td>
`;

                                serviceTable.innerHTML += `
                                <tr>
                                    <td>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <!-- Service Image -->
        <div>
            ${serviceImage}
        </div>

        <!-- Service Details -->
        <div style="flex: 1;">
            <a href="${record.edit_url}" style="color: #246FC1; text-decoration: none;">
                ${record.service_name}
            </a>
            <small class="text-muted d-block">
    Price: 
    ${
        record.service_discount_price && record.service_discount_price > 0
            ? `<span>${defaultCurrency}${Number(record.service_discount_price).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>`
            : `<span>${defaultCurrency}${Number(record.service_price).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>`
    } |
    Duration: ${
        (() => {
            const durationParts = record.duration.split(':');
            const hours = parseInt(durationParts[0], 10);
            const minutes = parseInt(durationParts[1], 10);
            let formattedDuration = '';

            if (hours > 0) {
                formattedDuration += `${hours} hour${hours > 1 ? 's' : ''}`;
            }
            if (minutes > 0) {
                formattedDuration += (formattedDuration ? ' ' : '') + `${minutes} minute${minutes > 1 ? 's' : ''}`;
            }
            return formattedDuration;
        })()
    }
</small>

        </div>
    </div>
</td>
                                    <td>${record.c_name}</td>
                                    <td>${discountedPrice}</td>
                                    <td>
    <div class="form-check form-switch" style="padding-top: 2px;">
        <input type="checkbox" class="form-check-input" id="customSwitch${record.id}" ${record.is_features == 1 ? 'checked' : ''} onchange="ChangeProviderServiceStatus(${record.id}, this.checked)" style="transform: scale(1.1);">
        <label class="form-check-label" for="customSwitch${record.id}"></label>
    </div>
</td>


                                    ${blockedStatusTd}
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="${record.edit_url}" class="px-2 text-primary" data-bs-toggle="tooltip" title="Edit"><i class="bx bx-pencil font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#" class="px-2 text-danger" onclick="deleteProviderService(${record.id})" data-bs-toggle="tooltip" title="Delete"><i class="bx bx-trash-alt font-size-18"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>`;
                            });
                        } else {
                            // Display "No Services Found" if no data is returned
                            serviceTable.innerHTML = `
                           <tr>
                                    <td colspan="6" class="text-center">
                                        <div
                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                            <div
                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                <i class="bx bx-briefcase" style="font-size: 2.5rem; color: #fff;"></i>
                                            </div>
                                            <p
                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                No Services Available</p>
                                        </div>
                                    </td>
                                </tr>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            });
        }
    });
</script>
