@extends('layouts.master')

@section('title')
Faq List
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
            <h5 class="card-title">Faq List <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
            </h5>
            <p class="text-muted">Settings Management / Faq List</p>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Search by question"
                aria-label="Search" aria-describedby="search-icon"
                style="border: none; box-shadow: none; outline: none; color: #495057;">
        </div>
    </div>

</div>


{{-- Faq List Table --}}
<div class="row" style="padding-top: 20px;">

    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    <div class="col-lg-12">
        <div class="card">

            <div class="d-flex justify-content-between align-items-center" style="padding-top: 15px;">

                <h2 class="card-title" style="margin-left: 25px;">Faq List</h2>

                <a href="{{ route('faq-add') }}" class="btn btn-primary" style="margin-right: 25px;">Add
                    Faq</a>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="color: #ffff;">Service</th>
                                <th scope="col" style="min-width: 16rem; color: #ffff;">Question</th>
                                <th scope="col" style="min-width: 16rem; color: #ffff;">Answer</th>
                                <th scope="col" style="color: #ffff;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($records->isEmpty())
                            <tr>
                                        <td colspan="4" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-question-mark" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Faq Found</p>
                                            </div>
                                        </td>
                                    </tr>
                            @else
                            @foreach ($records as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('providerservice-edit', $user->service_id) }}"
                                        style="color: #246FC1;">
                                        {{ Str::limit($user->service->service_name, 20) }}
                                    </a>
                                </td>

                                <td style="text-wrap: auto;">{{ $user->title ?? '' }}</td>

                                <td style="text-wrap: auto;">{{ $user->description ?? '' }}</td>

                                <td>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="{{ route('faq-edit', $user->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                class="px-2 text-primary"><i
                                                    class="bx bx-pencil font-size-18"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                class="px-2 text-danger"
                                                onclick="deleteFaq({{ $user->id }})"><i
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
                            @if ($page==$records->currentPage())
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


{{-- deleteFaq --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    function deleteFaq(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert faq!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete faq!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'faq-delete/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Faq has been removed.',
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
        const categoryTable = document.querySelector('tbody');
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
                fetch(`{{ route('faq-list') }}?search=${query}`, {
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
                                categoryTable.innerHTML += `
                                <tr>
                                    <td>
                                        <a href="${record.service_url}" style="color: #246FC1;">
                                            ${record.service_name.length > 20 ? record.service_name.substring(0, 20) + '...' : record.service_name}
                                        </a>
                                    </td>
                                    <td style="text-wrap: auto;">${record.title}</td>
                                    <td style="text-wrap: auto;">${record.description}</td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="${record.edit_url}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="px-2 text-primary">
                                                    <i class="bx bx-pencil font-size-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="px-2 text-danger" onclick="deleteFaq(${record.id})">
                                                    <i class="bx bx-trash-alt font-size-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>`;
                            });
                        } else {
                            categoryTable.innerHTML = `
                           <tr>
                                        <td colspan="4" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-question-mark" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Faq Found</p>
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
