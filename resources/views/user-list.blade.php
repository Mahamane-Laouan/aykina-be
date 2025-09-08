@extends('layouts.master')

@section('title')
    Customers
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
    <div class="row align-items-center">
        <div class="col-md-3" style="padding-top: 18px;">
            <div class="mb-3">
                <h5 class="card-title">Customers<span class="text-muted fw-normal ms-2">({{ $users->total() }})</span>
                </h5>
                <p class="text-muted">User Management / Customers</p>
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
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Customer</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Joining Date</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Contact Number</th>
                                    <th scope="col" style="color: #ffff;">Login Type</th>
                                    <th scope="col" style="color: #ffff;">Wallet Balance</th>
                                    <th scope="col" style="color: #ffff;">Status</th>
                                    <th scope="col" style="color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody class="user-table-body">
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-user" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Customers Found</p>
                                            </div>
                                        </td>
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
                                                            <img src="{{ asset('images/user/default_user.jpg') }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @endif
                                                    </div>

                                                    <div style="display: flex; flex-direction: column; width: fit-content;">
                                                        {{-- User Full Name with Highlight --}}
                                                        @php
                                                            $fullName = Str::limit(
                                                                $user->firstname . ' ' . $user->lastname,
                                                                25,
                                                            ); // Limit name length to 25 characters
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

                                                       <a href="{{ route('user-view', $user->id) }}"
                                                            class="text-body text-decoration-none">
                                                            <div class="text-body"
                                                                style="color: #246FC1; display: flex; align-items: center">
                                                                <div>
                                                                    {!! $highlightedName !!}
                                                                </div>

                                                                <div class="d-flex align-items-center">
                                                                    <i
                                                                        class="bx bxs-star font-size-14 text-warning ms-1"></i>
                                                                    <span
                                                                        class="font-size-14">{{ $user->avg_review ?? '0' }}</span>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        <small class="text-muted"> {{ Str::limit($user->email ?? '', 30) }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $user->formatted_created_at ?? '' }}</td>

                                            <td>
                                                @if (!empty($user->country_code))
                                                    ({{ $user->country_code }})
                                                @endif
                                                {{ $user->mobile }}
                                            </td>

                                            <td>
                                                @if ($user->login_type === 'email')
                                                    <span
                                                        class="badge bg-danger-subtle text-danger font-size-14">Email</span>
                                                @elseif ($user->login_type === 'apple')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning font-size-14">Apple</span>
                                                @elseif ($user->login_type === 'mobile')
                                                    <span
                                                        class="badge bg-primary-subtle text-primary font-size-14">Phone Number</span>
                                                @elseif ($user->login_type === 'google')
                                                    <span
                                                        class="badge bg-success-subtle text-success font-size-14">Google</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary font-size-14"></span>
                                                @endif
                                            </td>

                                            <td>{{ $user->wallet_balance > 0 ? $defaultCurrency . $user->wallet_balance : $defaultCurrency . '0' }}
                                            </td>


                                            <td>
                                                <div class="form-check form-switch mb-3" dir="ltr"
                                                    style="padding-top: 10px;">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="customSwitch{{ $user->id }}"
                                                        {{ $user->is_blocked == 1 ? 'checked' : '' }}
                                                        onchange="ChangeUserListBlocked({{ $user->id }}, this.checked)"
                                                        style="transform: scale(1.1);">
                                                    <label class="form-check-label"
                                                        for="customSwitch{{ $user->id }}"></label>
                                                </div>
                                            </td>

                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('user-view', $user->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                                            class="px-2 text-secondary"><i
                                                                class="bx bx-show font-size-18"></i></a>
                                                    </li>

                                                    <li class="list-inline-item">
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                            class="px-2 text-danger"
                                                            onclick="deleteUser({{ $user->id }})"><i
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

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" />

    <!-- Toastify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

    <script>
        var baseUrl = "{{ url('/') }}/";

        function ChangeUserListBlocked(id, isChecked) {
            console.log('Function triggered for user ID: ' + id); // Log when the function is triggered

            // Prepare the status message and background color based on the checkbox state (activated/deactivated)
            var statusMessage = isChecked ? "\u2714 User Account Activated" : "\u26A0 User Account Deactivated";
            var bgColor = isChecked ?
                "linear-gradient(to right, #5A9FE7, #164A8D)" // Light to Dark Blue Gradient
                :
                "linear-gradient(to right, #F4A261, #E76F51)"; // Warm Orange to Red Gradient

            // Send AJAX request to update the status
            $.ajax({
                url: baseUrl + 'change-userlistblocked/' + id,
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

    {{-- deleteCategory --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    // deleteSlider
    function deleteUser(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert user!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete user!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'user-delete/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'User has been removed.',
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
@endsection

<script>
    // Pass the default currency to JavaScript
    const defaultCurrency = "{{ $defaultCurrency }}"; // Fetch this from the controller
</script>


<!-- Search Ajax -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('handymanSearchInput');
        const handymanTableBody = document.querySelector('.user-table-body');
        const paginationContainer = document.querySelector('.handyman-pagination');
        const entriesInfo = document.querySelector('.handyman-entries-info');

        function getLoginBadge(loginType) {
            switch (loginType) {
                case 'email':
                    return '<span class="badge bg-danger-subtle text-danger font-size-14">Email</span>';
                case 'apple':
                    return '<span class="badge bg-warning-subtle text-warning font-size-14">Apple</span>';
                case 'mobile':
                    return '<span class="badge bg-primary-subtle text-primary font-size-14">Phone Number</span>';
                case 'google':
                    return '<span class="badge bg-success-subtle text-success font-size-14">Google</span>';
                default:
                    return '<span class="badge bg-secondary-subtle text-secondary font-size-14"></span>';
            }
        }

        function truncateText(text, maxLength) {
            if (!text) return '';
            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
        }

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
                fetch(`{{ route('user-list') }}?search=${query}`, {
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
                                const fullName = truncateText(
                                    `${record.firstname} ${record.lastname}`, 25
                                ); // Limit name to 25 characters
                                const highlightedName =
                                    `<span style="color: #246FC1;">${fullName}</span>`;
                                const loginStatusBadge = getLoginBadge(record.login_type);

                                const blockedStatusTd = `
    <td>
    <div class="form-check form-switch mb-3" dir="ltr" style="padding-top: 10px;">
            <input type="checkbox" class="form-check-input"
                id="customSwitch${record.id}"
                ${record.is_blocked == 1 ? 'checked' : ''}
                onchange="ChangeUserListBlocked(${record.id}, this.checked)" style="transform: scale(1.1);">
            <label class="form-check-label" for="customSwitch${record.id}"></label>
        </div>
    </td>
`;

                                handymanTableBody.innerHTML += `
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div>
    ${record.profile_pic
        ? `<img src="${record.profile_pic}" class="avatar rounded-circle img-thumbnail me-2">`
        : `<img src="images/user/default_user.jpg" class="avatar rounded-circle img-thumbnail me-2">`
    }
</div>

                                        <div style="display: flex; flex-direction: column; width: fit-content;">
                <a href="${record.view_url}" class="text-body text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="text-body" style="color: #246FC1;">
                            ${highlightedName}
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bx bxs-star font-size-14 text-warning ms-1"></i>
                            <span class="font-size-14">${record.avg_review ?? '0'}</span>
                        </div>
                    </div>
                </a>
                <small class="text-muted">${truncateText(record.email ?? '', 30)}</small>
            </div>
                                    </div>
                                </td>
                                <td>${record.created_at ?? ''}</td>
                                <td>${record.country_code ? `(${record.country_code})` : ''} ${record.mobile}</td>
                                <td>${loginStatusBadge}</td>
                                <td>${record.wallet_balance > 0 ? `${defaultCurrency}${record.wallet_balance}` : `${defaultCurrency}0`}</td>
                                                                    ${blockedStatusTd}

                                <td>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                                <a href="${record.view_url}" class="px-2 text-secondary" data-bs-toggle="tooltip" title="View"><i class="bx bx-show font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a class="px-2 text-danger" onclick="deleteUser(${record.id})"><i class="bx bx-trash-alt font-size-18"></i></a>
                                            </li>
                                    </ul>
                                </td>
                            </tr>`;
                            });
                        } else {
                            handymanTableBody.innerHTML = `
                        <tr>
                                        <td colspan="7" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-user" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Customers Found</p>
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
