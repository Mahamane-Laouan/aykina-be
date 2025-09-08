@extends('layouts.master')

@section('title')
    Handyman Pending List
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
                <h5 class="card-title">Handyman Pending List<span
                        class="text-muted fw-normal ms-2">({{ $users->total() }})</span>
                </h5>
                <p class="text-muted">Handyman Payment / Handyman Pending List</p>
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
                                    <th scope="col" style="color: #ffff;">Booking Id</th>
                                    <th scope="col" style="color: #ffff;">Service</th>
                                    <th scope="col" style="color: #ffff;">Commission</th>
                                    <th scope="col" style="color: #ffff;">Amount</th>
                                    <th scope="col" style="color: #ffff;">Payment Mode</th>
                                    <th scope="col" style="color: #ffff;">Status</th>
                                    <th scope="col" style="width: 200px; color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody class="handyman-table-body">
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-check-circle"
                                                        style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Pending List Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center;">
                                                    <div>
                                                        {{-- User Image --}}
                                                        @if ($user->handyman->profile_pic)
                                                            <img src="{{ asset('images/user/' . $user->handyman->profile_pic) }}"
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
                                                            $fullName =
                                                                $user->handyman->firstname .
                                                                ' ' .
                                                                $user->handyman->lastname;
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

                                                        <a href="{{ route('providerhandyman-view', $user->handyman->id) }}"
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
                                                                        class="font-size-14">{{ $user->handyman->avg_handyman_review ?? '0' }}</span>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        <small class="text-muted">{{ $user->handyman->email ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <a href="{{ route('subbooking-view', $user->booking_id) }}"
                                                    style="color: #246FC1;">
                                                    #{{ $user->booking_id ?? '' }}
                                                </a>
                                            </td>


                                            <td>
                                                <a href="{{ route('providerservice-edit', $user->service->id) }}"
                                                    style="color: #246FC1;">
                                                    {{ Str::limit($user->service->service_name, 20) }}
                                                </a>
                                            </td>

                                            <td>{{ $user->commision_persontage ?? '' }}%</td>

                                            <td>{{ $user->amount > 0 ? $defaultCurrency . $user->amount : $defaultCurrency . '0' }}
                                            </td>

                                            <td>
                                                @if ($user->payment_method === 'Cash')
                                                    <span
                                                        class="badge bg-primary-subtle text-primary font-size-15">Cash</span>
                                                @elseif ($user->payment_method === 'Online')
                                                    <span
                                                        class="badge bg-success-subtle text-success font-size-15">Online</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary font-size-15"></span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($user->handman_status == 1)
                                                    <span class="badge bg-success-subtle text-success font-size-15">
                                                        Approved
                                                    </span>
                                                @elseif ($user->handman_status == 0)
                                                    <span class="badge bg-warning-subtle text-warning font-size-15">
                                                        Pending
                                                    </span>
                                                @elseif ($user->handman_status == 2)
                                                    <span class="badge bg-danger-subtle text-danger font-size-15">
                                                        Rejected
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-primary btn-sm waves-effect waves-light"
                                                    onclick="ProviderhandymanPaymentRequestApproval({{ $user->id }}, 1)">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>

                                                <button type="button"
                                                    class="btn btn-danger btn-sm waves-effect waves-light"
                                                    onclick="rejectPaymentProviderHandyman({{ $user->id }}, 2)">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
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
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">&raquo;</a>
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




{{-- deleteService --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    function rejectPaymentProviderHandyman(id, status) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this handyman payment rejection!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reject Handyman Payment!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + 'providerhandyman-paymentreject/' + id,
                    type: 'POST',
                    data: {
                        status: status
                    }, // Passing the rejection status dynamically
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Rejected!',
                            text: 'Handyman payment request has been rejected successfully.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(function() {
                            window.location.href = baseUrl +
                                'providerhandyman-rejectlist';
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON?.message || 'Something went wrong!',
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
                    icon: 'info',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }



    // ProviderhandymanPaymentRequestApproval
    function ProviderhandymanPaymentRequestApproval(id, status) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this request!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Accept Payment Request!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + 'providerhandyman-paymentrequestapproval/' + id,
                    type: 'Get', // Use POST for better security and compliance
                    data: {
                        status: status
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.message === 'Request accepted successfully') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Payment Request accepted successfully.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(function() {
                                window.location.href = baseUrl +
                                    'providerhandyman-approvedlist';
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
                    error: function(xhr) {
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
