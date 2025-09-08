@extends('layouts.master')

@section('title')
    Coupon List
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
                <h5 class="card-title">Coupon List <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Coupons / Coupon List</p>
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
                <input type="text" id="searchInput" class="form-control" placeholder="Search by coupon code"
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

                <div class="d-flex justify-content-between align-items-center" style="padding-top: 15px;">

                    <h2 class="card-title" style="margin-left: 25px;">Coupon List</h2>

                    <a href="{{ route('coupon-add') }}" class="btn btn-primary" style="margin-right: 25px;">Add
                        Coupon</a>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="min-width: 10rem; color: #ffff;">Code</th>
                                    <th scope="col" style="color: #ffff;">Discount</th>
                                    <th scope="col" style="color: #ffff;">Discount Type</th>
                                    <th scope="col" style="color: #ffff;">Expire Date</th>
                                    <th scope="col" style="color: #ffff;">Coupon For</th>
                                    <th scope="col" style="color: #ffff;">Status</th>
                                    <th scope="col" style="color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($records->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-purchase-tag" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Coupons Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($records as $user)
                                        <tr>
                                            <td>
                                                <div class="text-body text-decoration-none">
                                                    <span style="color: #246FC1;">{{ $user->code ?? '' }}</span>
                                                </div>
                                            </td>

                                            <td>{{ $user->discount ?? '' }}</td>

                                            <td>
                                                @if ($user->type == 'Percentage')
                                                    <span class="badge bg-primary-subtle text-primary font-size-15">
                                                        Percentage
                                                    </span>
                                                @elseif ($user->type == 'Fixed')
                                                    <span class="badge bg-danger-subtle text-danger font-size-15">
                                                        Fixed
                                                    </span>
                                                @endif
                                            </td>


                                            <td>{{ $user->formatted_created_at ?? '' }}</td>


                                            <td>
                                                @if ($user->coupon_for == 'Product')
                                                    <span class="badge bg-success-subtle text-success font-size-15">
                                                        Product
                                                    </span>
                                                @elseif ($user->coupon_for == 'Service')
                                                    <span class="badge bg-primary-subtle text-primary font-size-15">
                                                        Service
                                                    </span>
                                                @endif
                                            </td>


                                            <td>
                                                <div class="form-check form-switch mb-3" dir="ltr"
                                                    style="padding-top: 10px;">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="customSwitch{{ $user->id }}"
                                                        {{ $user->status == 1 ? 'checked' : '' }}
                                                        onchange="changeCouponStatus({{ $user->id }}, this.checked)"
                                                        style="transform: scale(1.1);">
                                                    <label class="form-check-label" for="customSwitch{{ $user->id }}"
                                                        style="font-size: 1.2rem;"></label>
                                                </div>
                                            </td>


                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                            class="px-2 text-danger"
                                                            onclick="deleteCoupon({{ $user->id }})"><i
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

        function changeCouponStatus(id, isChecked) {
            console.log('Function triggered for user ID: ' + id); // Log when the function is triggered

            // Prepare the status message and background color based on the checkbox state (activated/deactivated)
            var statusMessage = isChecked ? "\u2714 Coupon Activated" : "\u26A0 Coupon Deactivated";
            var bgColor = isChecked ?
                "linear-gradient(to right, #5A9FE7, #164A8D)" // Light to Dark Blue Gradient
                :
                "linear-gradient(to right, #F4A261, #E76F51)"; // Warm Orange to Red Gradient


            // Send AJAX request to update the status
            $.ajax({
                url: baseUrl + 'change-couponstatus/' + id,
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


{{-- deleteCoupon --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    function deleteCoupon(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert coupon!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete coupon!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'coupon-delete/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Coupon has been removed.',
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
</script>


{{-- Search Ajax --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const couponTable = document.querySelector('tbody');
        const pagination = document.querySelector('.pagination-container'); // Pagination container
        const entriesInfo = document.querySelector('.entries-info'); // "Showing X to Y of Z entries" text

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value;

                // Hide pagination and entries info when search is active
                if (pagination) {
                    pagination.style.display = query ? 'none' : 'block';
                }

                if (entriesInfo) {
                    entriesInfo.style.display = query ? 'none' : 'block';
                }

                // Send an AJAX request
                fetch(`{{ route('coupon-list') }}?search=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        couponTable.innerHTML = ''; // Clear the table

                        if (data.records.length > 0) {
                            data.records.forEach(record => {
                                const blockedStatusTd = `
    <td>
        <div class="form-check form-switch mb-3" dir="ltr" style="padding-top: 10px;">
            <input type="checkbox" class="form-check-input"
                id="customSwitch${record.id}"
                ${record.status == 1 ? 'checked' : ''}
                onchange="changeCouponStatus(${record.id}, this.checked)" style="transform: scale(1.1);">
            <label class="form-check-label" for="customSwitch${record.id}"></label>
        </div>
    </td>
`;
                                couponTable.innerHTML += `
                                <tr>
                                    <td>
                                        <div class="text-body text-decoration-none">
                                            <span style="color: #246FC1;">${record.code || ''}</span>
                                        </div>
                                    </td>
                                    <td>${record.discount || ''}</td>
                                    <td>
                                        ${record.type === 'Percentage'
                                            ? '<span class="badge bg-primary-subtle text-primary font-size-15">Percentage</span>'
                                            : '<span class="badge bg-danger-subtle text-danger font-size-15">Fixed</span>'}
                                    </td>
                                    <td>${record.expire_date || ''}</td>
                                    <td>
                                        ${record.coupon_for === 'Product'
                                            ? '<span class="badge bg-success-subtle text-success font-size-15">Product</span>'
                                            : '<span class="badge bg-primary-subtle text-primary font-size-15">Service</span>'}
                                    </td>
                                                                       ${blockedStatusTd}

                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="px-2 text-danger" onclick="deleteCoupon(${record.id})">
                                                    <i class="bx bx-trash-alt font-size-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>`;
                            });
                        } else {
                            couponTable.innerHTML = `
                            <tr>
                                        <td colspan="7" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-purchase-tag" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Coupons Found</p>
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
