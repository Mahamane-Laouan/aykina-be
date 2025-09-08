@extends('layouts.master')

@section('title')
    Payouts
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
                <h5 class="card-title">Payouts <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Order Management / Payouts</p>
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
                                    <th style="min-width: 10rem; color: #ffff;">Provider</th>
                                    <th style="color: #ffff;">Amount</th>
                                    <th style="color: #ffff;">Bank Details</th>
                                    <th style="color: #ffff;">Date</th>
                                    <th style="color: #ffff;">Status</th>
                                    <th style="color: #ffff;">Action</th>
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
                                                    <i class="bx bx-money" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Payouts Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($records as $user)
                                        <tr>
                                            <!-- Provider Details -->
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
                                                            <div class="text-body d-flex align-items-center">
                                                                <a href="{{ route('provider-view', $user->provider_id) }}"
                                                                    style="color: #246FC1;">
                                                                    {{ $user->provider->firstname }}
                                                                    {{ Str::limit($user->provider->lastname ?? '', 20) }}
                                                                </a>

                                                                {{-- Review beside name with black color --}}
                                                                <span class="ms-1 d-flex align-items-center"
                                                                    style="color: #000000;">
                                                                    <i class="bx bxs-star font-size-14 text-warning"></i>
                                                                    <span
                                                                        class="font-size-14">{{ $user->provider->avg_provider_review ?? '0' }}</span>
                                                                </span>
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ Str::limit($user->provider->email ?? '', 30) }}
                                                            </small>
                                                        @else
                                                            <div class="text-body"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Amount -->
                                            <td>{{ $defaultCurrency }}{{ $user->amount ?? '' }}</td>

                                            <!-- Bank Details -->
                                            <td>
                                                <strong>Bank Name:</strong> {{ $user->bankDetails->bank_name ?? '' }}
                                                <br>
                                                <strong>Branch Name:</strong>
                                                {{ $user->bankDetails->branch_name ?? '' }} <br>
                                                <strong>Acc No:</strong> {{ $user->bankDetails->acc_number ?? '' }}
                                                <br>
                                                <strong>IFSC Code:</strong> {{ $user->bankDetails->ifsc_code ?? '' }}
                                            </td>

                                            <!-- Date -->
                                            <td>{{ $user->formatted_created_at }}</td>

                                            <!-- Status -->
                                            <td>
                                                @if ($user->status === 0)
                                                    <span
                                                        class="badge bg-warning-subtle text-warning font-size-14">Pending</span>
                                                @elseif ($user->status === 1)
                                                    <span
                                                        class="badge bg-success-subtle text-success font-size-14">Approved</span>
                                                @endif
                                            </td>

                                            <!-- Action Buttons -->
                                            <td>
                                                @if ($user->status === 0)
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="ChangeProviderPayoutListStatus({{ $user->id }})">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                @elseif ($user->status === 1)
                                                    <span
                                                        class="badge bg-success-subtle text-success font-size-14">Approved</span>
                                                @endif
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


{{-- deleteTax --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    function ChangeProviderPayoutListStatus(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve Payout Request!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'change-payoutlistprovider/' + id, // Corrected URL
                    type: 'GET', // Matching the Laravel route
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Approved!',
                            text: response.message,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(function() {
                            location.reload(); // Refresh the page
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to update status.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            }
        });
    }
</script>
