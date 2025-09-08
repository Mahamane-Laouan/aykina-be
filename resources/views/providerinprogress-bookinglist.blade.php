@extends('layouts.master')

@section('title')
    In Progress Bookings
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
                <h5 class="card-title">In Progress Bookings <span
                        class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Service Booking / In Progress Bookings</p>
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
                                    <th scope="col" style="color: #ffff;">Service</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Booking Date</th>
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Customer</th>
                                    <th scope="col" style="color: #ffff;">Total Amount</th>
                                    <th scope="col" style="color: #ffff;">Service Status</th>
                                    <th scope="col" style="color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($records->isEmpty())
                                    <td colspan="7" class="text-center">
                                        <div
                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                            <div
                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                <i class="bx bx-notepad" style="font-size: 2.5rem; color: #fff;"></i>
                                            </div>
                                            <p
                                                style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                No In Progress Bookings Found</p>
                                        </div>
                                    </td>
                                @else
                                    @foreach ($records as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('booking-view', $user->id) }}" style="color: #246FC1;">
                                                    #{{ $user->id }}
                                                </a>
                                            </td>

                                            <td>
                                                @if ($user->cartItems->isNotEmpty() && $user->cartItems->first()->service)
                                                    <a href="{{ route('providerservice-edit', $user->cartItems->first()->service->id) }}"
                                                        style="color: #246FC1;">
                                                        {{ Str::limit($user->cartItems->first()->service->service_name, 20) }}
                                                    </a>
                                                @else
                                                @endif
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
                                                        {{-- User Full Name with Review --}}
                                                        @if ($user->user)
                                                            <div class="text-body"
                                                                style="display: flex; align-items: center;">
                                                                <div>
                                                                    {{ $user->user->firstname }}
                                                                    {{ Str::limit($user->user->lastname ?? '', 20) }}
                                                                </div>

                                                                {{-- Review beside name --}}
                                                                <span class="ms-1 d-flex align-items-center"
                                                                    style="color: #000000;">
                                                                    <i class="bx bxs-star font-size-14 text-warning"></i>
                                                                    <span class="font-size-14">
                                                                        {{ $user->user->avg_users_review ?? '0' }}
                                                                    </span>
                                                                </span>
                                                            </div>

                                                            <small class="text-muted">
                                                                {{ Str::limit($user->user->email ?? '', 30) }}
                                                            </small>
                                                        @else
                                                            <div class="text-body"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>


                                            <td>{{ $user->total > 0 ? $defaultCurrency . $user->total : $defaultCurrency . '0' }}
                                            </td>

                                            <td>
                                                <span class="badge bg-info text-white font-size-14"
                                                    style="height: 30px; padding-top: 8px;">In Progress</span>
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
