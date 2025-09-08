@extends('layouts.master')

@section('title')
    Unverified Handyman List
@endsection

@section('page-title')
    Unverified Handyman List
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
    <div class="row align-items-center">
        <div class="col-md-3" style="padding-top: 18px;">
            <div class="mb-3">
                <h5 class="card-title">Unverified Handyman List<span
                        class="text-muted fw-normal ms-2">({{ $users->total() }})</span>
                </h5>
                <p class="text-muted">Handyman / Unverified Handyman List</p>
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
                <input type="text" id="handymanSearchInput" class="form-control" placeholder="Search by name or email"
                    aria-label="Search" aria-describedby="search-icon"
                    style="border: none; box-shadow: none; outline: none; color: #495057;">
            </div>
        </div>
    </div>


    {{-- Provider Table --}}
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
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Handyman</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Joining Date</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Provider</th>
                                    <th scope="col" style="color: #ffff;">Commission</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Contact Number</th>
                                    <th scope="col" style="color: #ffff;">Wallet Amount</th>
                                    <th scope="col" style="color: #ffff;">Status</th>
                                    <th scope="col" style="width: 200px; color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody class="handyman-table-body">
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">No Handyman Found</td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div style="display: flex;align-items: center;">
                                                    <div>
                                                        {{-- User Image --}}
                                                        @if ($user->profile_pic)
                                                            <img src="{{ asset('images/user/' . $user->profile_pic) }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @else
                                                            {{-- Default User Image --}}
                                                            <img src="{{ asset('images/user/default_handyman.jpg') }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @endif
                                                    </div>

                                                    <div style="display: flex; flex-direction: column; width: fit-content;">
                                                        {{-- User Full Name with Highlight --}}
                                                        @php
                                                            $fullName = $user->firstname . ' ' . $user->lastname;
                                                            $highlightedName = $search
                                                                ? preg_replace(
                                                                    '/(' . preg_quote($search, '/') . ')/i',
                                                                    '<mark>$1</mark>',
                                                                    $fullName,
                                                                )
                                                                : '<span style="color: #246FC1;">' .
                                                                    $fullName .
                                                                    '</span>';
                                                        @endphp

                                                        <a href="{{ route('handyman-view', $user->id) }}"
                                                            class="text-body text-decoration-none">
                                                            <div class="text-body" style="color: #246FC1;">
                                                                {!! $highlightedName !!}</div>
                                                        </a>

                                                        <small class="text-muted">{{ $user->email ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $user->formatted_created_at ?? '' }}</td>

                                            <td>
                                                <div style="display: flex; align-items: center;">
                                                     <div>
                                                        {{-- User Image --}}
                                                        @if ($user->provider && $user->provider->profile_pic)
                                                            <img src="{{ asset('images/user/' . $user->provider->profile_pic) }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @else
                                                            {{-- Default User Image --}}
                                                            <img src="{{ asset('images/user/default_provider.jpg') }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @endif
                                                    </div>

                                                    <div style="display: flex; flex-direction: column; width: fit-content;">
                                                        {{-- User Full Name --}}
                                                        @if ($user->provider)
                                                            <div class="text-body">
                                                                <a href="{{ route('provider-view', $user->provider_id) }}"
                                                                    style="color: #246FC1; text-decoration: none;">
                                                                    {{ $user->provider->firstname }}
                                                                    {{ $user->provider->lastname }}
                                                                </a>
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ $user->provider->email ?? '' }}
                                                            </small>
                                                        @else
                                                            <div class="text-body">No Provider Assigned</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>


                                            <td>{{ $commission ?? '' }}%</td>

                                            <td>
                                                @if (!empty($user->country_code))
                                                    ({{ $user->country_code }})
                                                @endif
                                                {{ $user->mobile }}
                                            </td>


                                            <td>{{ $user->wallet_balance > 0 ? $defaultCurrency . $user->wallet_balance : $defaultCurrency . '0' }}
                                            </td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-primary btn-sm waves-effect waves-light"
                                                    onclick="handymanRequestApproval({{ $user->id }})">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </td>

                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('handyman-view', $user->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                                            class="px-2 text-secondary"><i
                                                                class="bx bx-show font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Ignore" class="px-2 text-danger"
                                                            onclick="ignoreHandyman({{ $user->id }})"><i
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
                <div class="handyman-entries-info">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of
                    {{ $users->total() }} entries
                </div>
                <div class="handyman-pagination">
                    @if ($users->hasPages())
                        <nav>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}"
                                            rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach (range(1, $users->lastPage()) as $page)
                                    @if ($page == 1 || $page == $users->lastPage() || abs($page - $users->currentPage()) <= 2)
                                        @if ($page == $users->currentPage())
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $users->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @elseif ($page == 2 || $page == $users->lastPage() - 1)
                                        {{-- Skip showing ellipsis for the second page and second last page --}}
                                        <li class="page-item disabled" aria-disabled="true">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($users->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}"
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
@endsection

<script>
    // Pass the default currency to JavaScript
    const defaultCurrency = "{{ $defaultCurrency }}"; // Fetch this from the controller
</script>



{{-- deleteService --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    // ignoreHandyman;
    function ignoreHandyman(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this handyman!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Ignore Handyman!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'handyman-ignore/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Ignored!',
                            text: 'Service Handyman has been ignored.',
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
                    text: 'Action Cancelled :)',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }


    // handymanRequestApproval
    function handymanRequestApproval(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this request!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Accept Request!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + 'handyman-requestapproval/' + id,
                    type: 'GET', // You can switch to 'POST' or 'PUT' depending on your API design
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        // Check if the backend responded with success
                        if (data.message === 'Request accepted successfully') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Service Handyman Request Accepted successfully.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(function() {
                                // Redirect after successful approval
                                window.location.href = baseUrl + 'handyman-list';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Unexpected response from the server.',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Display specific error if available
                        let errorMessage = 'There was an error changing the status.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Action Cancelled :)',
                    icon: 'info',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }
</script>




<!-- Search Ajax -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('handymanSearchInput');
        const handymanTableBody = document.querySelector('.handyman-table-body');
        const paginationContainer = document.querySelector('.handyman-pagination');
        const entriesInfo = document.querySelector('.handyman-entries-info');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value;

                // Toggle visibility of pagination and entries info
                if (paginationContainer) {
                    paginationContainer.style.display = query ? 'none' : 'block';
                }

                if (entriesInfo) {
                    entriesInfo.style.display = query ? 'none' : 'block';
                }

                // Send an AJAX request
                fetch(`{{ route('handyman-requestlist') }}?search=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        handymanTableBody.innerHTML = ''; // Clear the table

                        if (data.records.length > 0) {
                            data.records.forEach(record => {
                                const fullName = `${record.firstname} ${record.lastname}`;
                                const highlightedName =
                                    `<span style="color: #246FC1;">${fullName}</span>`;

                                handymanTableBody.innerHTML += `
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div>
    ${record.profile_pic
        ? `<img src="${record.profile_pic}" class="avatar rounded-circle img-thumbnail me-2">`
        : `<img src="images/user/default_handyman.jpg" class="avatar rounded-circle img-thumbnail me-2">`
    }
</div>
                                        <div style="display: flex; flex-direction: column; width: fit-content;">
                                            <a href="${record.view_url}" class="text-body text-decoration-none">
                                                ${highlightedName}
                                            </a>
                                            <small class="text-muted">${record.email ?? ''}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>${record.created_at ?? ''}</td>
                                <td>
    <div style="display: flex; align-items: center;">
        <div>
            ${record.provider.profile_pic
                ? `<img src="${record.provider.profile_pic}" class="avatar rounded-circle img-thumbnail me-2">`
                : `<img src="images/user/default_provider.jpg" class="avatar rounded-circle img-thumbnail me-2">`}
        </div>
        <div style="display: flex; flex-direction: column; width: fit-content;">
            <small><a href="${record.provider.profile_url}" style="color: #246FC1;">
                                                            ${record.provider.firstname} ${record.provider.lastname}
                                                        </a></small>
            <small class="text-muted">${record.provider.email}</small>
        </div>
    </div>
</td>

                                <td>${record.commission ?? ''}%</td>
                                <td>${record.country_code ? `(${record.country_code})` : ''} ${record.mobile}</td>
                            <td>${record.wallet_balance > 0 ? `${defaultCurrency}${record.wallet_balance}` : `${defaultCurrency}0`}</td>
                                <td>
                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="handymanRequestApproval(${record.id})">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="${record.view_url}" class="px-2 text-secondary" data-bs-toggle="tooltip" title="View"><i class="bx bx-show font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Ignore" class="px-2 text-danger" onclick="ignoreHandyman(${record.id})">
                                                    <i class="bx bx-trash-alt font-size-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                            </tr>`;
                            });
                        } else {
                            handymanTableBody.innerHTML = `
                        <tr>
                            <td colspan="8" class="text-center">No Handyman Found</td>
                        </tr>`;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });
</script>
