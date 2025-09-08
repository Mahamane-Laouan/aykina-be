@extends('layouts.master')

@section('title')
    Bookings
@endsection

@section('page-title')
    Bookings
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
                <h5 class="card-title">Bookings <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Product Orders / Bookings</p>
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
                <input type="text" id="searchSubCategoryInput" class="form-control" placeholder="Search by user name"
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
                                    <th scope="col" style="color: #ffff;">Order Id</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Booking Date</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">User</th>
                                    <th scope="col" style="color: #ffff;">Total Product</th>
                                    <th scope="col" style="color: #ffff;">Total Amount</th>
                                    <th scope="col" style="color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($records->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No Bookings Found</td>
                                    </tr>
                                @else
                                    @foreach ($records as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('booking-view', $user->id) }}" style="color: #246FC1;">
                                                    #{{ $user->id }}
                                                </a>
                                            </td>

                                            <td>{{ $user->formatted_created_at ?? '' }}</td>

                                            <td>
                                                <div style="display: flex; align-items: center;">
                                                    <div>
                                                        {{-- User Image --}}
                                                        @if ($user->user && $user->user->profile_pic)
                                                            <img src="{{ asset('images/user/' . $user->user->profile_pic) }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @else
                                                            {{-- Default User Image --}}
                                                            <img src="{{ asset('images/user/default_user.jpg') }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @endif
                                                    </div>

                                                    <div style="display: flex; flex-direction: column; width: fit-content;">
                                                        {{-- User Full Name --}}
                                                        @if ($user->user)
                                                            <div class="text-body">
                                                                <a href="{{ route('user-view', $user->user_id) }}"
                                                                    style="color: #246FC1;">
                                                                    {{ $user->user->firstname }}
                                                                    {{ $user->user->lastname }}
                                                                </a>
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ $user->user->email ?? '' }}
                                                            </small>
                                                        @else
                                                            <div class="text-body"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $user->total_product_count }}</td>


                                            <td>{{ $user->total > 0 ? $defaultCurrency . $user->total : $defaultCurrency . '0' }}
                                            </td>

                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('booking-view', $user->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                                            class="px-2 text-primary"><i
                                                                class="bx bx-show font-size-18"></i></a>
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
@endsection


{{-- deleteBooking --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    function deleteBooking(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert booking!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete Booking!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'booking-delete/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Booking has been removed.',
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

<script>
    // Pass the default currency to JavaScript
    const defaultCurrency = "{{ $defaultCurrency }}"; // Fetch this from the controller
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchSubCategoryInput');
        const categoryTable = document.querySelector('tbody');
        const pagination = document.querySelector('.pagination-container');
        const entriesInfo = document.querySelector('.entries-info');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value;

                // Hide pagination and entries info when search is active
                if (pagination) pagination.style.display = query ? 'none' : 'block';
                if (entriesInfo) entriesInfo.style.display = query ? 'none' : 'block';

                // Send an AJAX request
                fetch(`{{ route('all-productbookinglist') }}?search=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        categoryTable.innerHTML = ''; // Clear the table

                        if (data.records.length > 0) {
                            data.records.forEach(record => {
                                const userProfile = record.user.profile_pic ?
                                    `<img src="${record.user.profile_pic}" alt="User Image" class="avatar rounded-circle img-thumbnail" style="min-width: 50px; height: 50px; object-fit: cover;">` :
                                    `<img src="images/user/default_user.jpg" class="avatar rounded-circle img-thumbnail me-2">`;


                                categoryTable.innerHTML += `
                                <tr>
                                    <td>
                                        <a href="${record.edit_url}" style="color: #246FC1;">
                                            #${record.id}
                                        </a>
                                    </td>
                                    <td>${record.created_at}</td>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div>${userProfile}</div>
                                            <div>
                                                <div class="text-body">
                                                    <a href="${record.user.profile_url}" style="color: #246FC1;">
                                                        ${record.user.firstname} ${record.user.lastname}
                                                    </a>
                                                </div>
                                                <small class="text-muted">${record.user.email}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${record.total_product_count}</td> <!-- Display total_product_count -->
                                    <td>${record.total > 0 ? `${record.currency}${record.total}` : `${record.currency}0`}</td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="${record.edit_url}" class="px-2 text-primary" data-bs-toggle="tooltip" title="View"><i class="bx bx-show font-size-18"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>`;
                            });
                        } else {
                            categoryTable.innerHTML = `
                            <tr>
                                <td colspan="6" class="text-center">No Bookings Found</td>
                            </tr>`;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });
</script>
