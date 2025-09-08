@extends('layouts.master')

@section('title')
    Earnings
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
                <h5 class="card-title">Earnings <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Order Management / Earnings</p>
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
                <input type="text" id="searchSubCategoryInput" class="form-control" placeholder="Search by name or email"
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
                                    <th scope="col" style="min-width: 16rem; color: #ffff;">Provider</th>
                                    <th scope="col" style="color: #ffff;">Total Booking</th>
                                    <th scope="col" style="color: #ffff;">Provider Commission</th>
                                    <th scope="col" style="color: #ffff;">Provider Earning</th>
                                    <th scope="col" style="color: #ffff;">Admin Earning</th>
                                    <th scope="col" style="color: #ffff;">Provider Withdraw</th>
                                    <th scope="col" style="color: #ffff;">Provider Wallet</th>
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
                                                    <i class="bx bx-dollar-circle" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Earnings Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($records as $user)
                                        <tr>

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
            <a href="{{ route('provider-view', $user->provider_id) }}" style="color: #246FC1;">
                {{ $user->provider->firstname }}
                {{ Str::limit($user->provider->lastname ?? '', 20) }}
            </a>

            {{-- Review beside name with black color --}}
            <span class="ms-1 d-flex align-items-center" style="color: #000000;">
                <i class="bx bxs-star font-size-14 text-warning"></i>
                <span class="font-size-14">{{ $user->provider->avg_provider_review ?? '0' }}</span>
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

                                            <td class="{{ $user->total_bookings ? 'text-primary' : 'text-muted' }}">
                                                {{ $user->total_bookings ?? '' }}
                                            </td>

                                            <td class="{{ $user->commission_value ? 'text-success' : 'text-danger' }}">
                                                {{ $user->commission_value ?? '' }}%
                                            </td>

                                            <td class="{{ $user->provider_earning > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $user->provider_earning > 0 ? $defaultCurrency . $user->provider_earning : $defaultCurrency . '0' }}
                                            </td>

                                            <td class="{{ $user->admin_earning > 0 ? 'text-primary' : 'text-danger' }}">
                                                {{ $user->admin_earning > 0 ? $defaultCurrency . $user->admin_earning : $defaultCurrency . '0' }}
                                            </td>

                                            <td class="{{ $user->net_earning > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $user->net_earning > 0 ? $defaultCurrency . $user->net_earning : $defaultCurrency . '0' }}
                                            </td>

                                            <td class="{{ $user->total_balance > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $user->total_balance > 0 ? $defaultCurrency . $user->total_balance : $defaultCurrency . '0' }}
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

<script>
    // Pass the default currency to JavaScript
    const defaultCurrency = "{{ $defaultCurrency }}"; // Fetch this from the controller
</script>



{{-- Search Ajax --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchSubCategoryInput');
        const categoryTable = document.querySelector('tbody');
        const pagination = document.querySelector('.pagination-container'); // Pagination container
        const entriesInfo = document.querySelector('.entries-info'); // "Showing X to Y of Z entries" text

        function truncateText(text, maxLength) {
            if (!text) return '';
            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
        }

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
                fetch(`{{ route('earnings') }}?search=${query}`, {
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
                                const userProfile = record.provider.profile_pic ?
                                    `<img src="${record.provider.profile_pic}" alt="User Image" class="avatar rounded-circle img-thumbnail me-2" style="min-width: 50px; height: 50px; object-fit: cover;">` :
                                    `<img src="images/user/default_provider.jpg" class="avatar rounded-circle img-thumbnail me-2">`;

                                // Dynamically calculate and format values
                                const providerEarning = record.provider_earning > 0 ?
                                    `${defaultCurrency}${record.provider_earning}` :
                                    `${defaultCurrency}0`;
                                const adminEarning = record.admin_earning > 0 ?
                                    `${defaultCurrency}${record.admin_earning}` :
                                    `${defaultCurrency}0`;
                                const netEarning = record.net_earning > 0 ?
                                    `${defaultCurrency}${record.net_earning}` :
                                    `${defaultCurrency}0`;
                                const totalBalance = record.total_balance > 0 ?
                                    `${defaultCurrency}${record.total_balance}` :
                                    `${defaultCurrency}0`;
                                const commissionValue = record.commission_value ?
                                    `${record.commission_value}%` : '';

                                categoryTable.innerHTML += `
                                    <tr>
                                        <td>
    <div style="display: flex; align-items: center;">
        <div>${userProfile}</div>
        <div style="display: flex; flex-direction: column; width: fit-content; margin-left: 8px;">
            <div style="display: flex; align-items: center;">
                <a href="${record.provider.profile_url}" style="color: #246FC1;">
                    ${record.provider.firstname} ${truncateText(record.provider.lastname ?? '', 20)}
                </a>
                <span style="display: flex; align-items: center; margin-left: 5px; color: #000000;">
                    <i class="bx bxs-star font-size-14 text-warning"></i>
                    <span class="font-size-14" style="margin-left: 2px;">
                        ${record.provider.avg_provider_review ?? '0'}
                    </span>
                </span>
            </div>
            <small class="text-muted">${truncateText(record.provider.email ?? '', 30)}</small>
        </div>
    </div>
</td>
                                        <td class="${record.total_bookings ? 'text-primary' : 'text-muted'}">${record.total_bookings ?? ''}</td>
                                        <td class="${record.commission_value ? 'text-success' : 'text-danger'}">${commissionValue}</td>
                                        <td class="${record.provider_earning > 0 ? 'text-success' : 'text-danger'}">
    £${isNaN(record.provider_earning) ? '0' : parseFloat(record.provider_earning).toFixed(2)}
</td>
<td class="${record.admin_earning > 0 ? 'text-primary' : 'text-danger'}">
    £${isNaN(record.admin_earning) ? '0' : parseFloat(record.admin_earning).toFixed(2)}
</td>
<td class="${record.net_earning > 0 ? 'text-success' : 'text-danger'}">
    £${isNaN(record.net_earning) ? '0' : parseFloat(record.net_earning).toFixed(2)}
</td>
<td class="${record.total_balance > 0 ? 'text-success' : 'text-danger'}">
    £${isNaN(record.total_balance) ? '0' : parseFloat(record.total_balance).toFixed(2)}
</td>


                                    </tr>`;
                            });
                        } else {
                            categoryTable.innerHTML = `
                                <tr>
                                        <td colspan="7" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-dollar-circle" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Earnings Found</p>
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
