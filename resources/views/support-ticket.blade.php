@extends('layouts.master')

@section('title')
    Support Ticket
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
                <h5 class="card-title">Support Ticket <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Settings Management / Support Ticket</p>
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
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">User</th>
                                    <th scope="col" style="color: #ffff;">Subject</th>
                                    <th scope="col" style="color: #ffff;">Date</th>
                                    <th scope="col" style="color: #ffff;">Type</th>
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
                                                    <i class="bx bx-support" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Tickets Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($records as $ticket)
                                        <tr>
                                            <td>
                                                <a href="{{ route('booking-view', $ticket->order_id) }}"
                                                    class="text-body text-decoration-none">
                                                    <span style="color: #246FC1;">#{{ $ticket->order_id }}</span>
                                                </a>
                                            </td>

                                            <td>
                                                <div style="display: flex; align-items: center;">
                                                    {{-- User Image --}}
                                                    <div>
                                                        @if ($ticket->user && $ticket->user->profile_pic)
                                                            <img src="{{ asset('images/user/' . $ticket->user->profile_pic) }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @else
                                                            {{-- Default User Image --}}
                                                            <img src="{{ asset('images/user/default_user.jpg') }}"
                                                                class="avatar rounded-circle img-thumbnail me-2">
                                                        @endif
                                                    </div>

                                                    <div style="display: flex; flex-direction: column; width: fit-content;">
                                                        {{-- User Full Name and Review --}}
                                                        @if ($ticket->user)
                                                            <div class="text-body">
                                                                <a href="{{ route('user-view', $ticket->user_id) }}"
                                                                    style="color: #246FC1; text-decoration: none;">
                                                                    <span class="d-inline-flex align-items-center">
                                                                        {{ $ticket->user->firstname }}
                                                                        {{ Str::limit($ticket->user->lastname ?? '', 30) }}
                                                                        {{-- Review beside name --}}
                                                                        <span class="ms-1 d-flex align-items-center"
                                                                            style="color: #000000;">
                                                                            <i
                                                                                class="bx bxs-star font-size-14 text-warning"></i>
                                                                            <span class="font-size-14">
                                                                                {{ $ticket->user->avg_users_review ?? '0' }}
                                                                            </span>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            {{-- User Email --}}
                                                            <small class="text-muted">
                                                                {{ Str::limit($ticket->user->email ?? '', 30) }}
                                                            </small>
                                                        @else
                                                            <div class="text-body"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>



                                            <td>{{ Str::limit($ticket->subject ?? '', 20) }}</td>

                                            <td>{{ $ticket->formatted_created_at ?? '' }}</td>

                                            <td>
                                                @if ($ticket->type === 'Product')
                                                    <span
                                                        class="badge bg-danger-subtle text-danger font-size-15">Product</span>
                                                @elseif ($ticket->type === 'Service')
                                                    <span
                                                        class="badge bg-primary-subtle text-primary font-size-15">Service</span>
                                                @endif
                                            </td>


                                            <td>
                                                @if ($ticket->supportChatStatus && $ticket->supportChatStatus->status == 0)
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm waves-effect waves-light">
                                                        In Progress
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm waves-effect waves-light">
                                                        Closed
                                                    </button>
                                                @endif
                                            </td>

                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('ticket-view', $ticket->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                                            class="px-2 text-primary">
                                                            <i class="bx bx-show font-size-18"></i>
                                                        </a>
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
