@extends('layouts.master')

@section('title')
    Language Translation
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->first_name }} {{ $userwelcomedata->last_name }}
@endsection

<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

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
        <div class="col-9" style="padding-top: 18px;">
            <div class="mb-3">
                <h5 class="card-title"> Language Translation <span class="text-muted fw-normal ms-2"></span>
                </h5>
                <p class="text-muted">
                    <a href="/language-list" class="text-muted">Language</a> / Language Translation
                </p>
            </div>
        </div>
    </div>

    <div class="row" style="padding-top: 20px;">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="col-lg-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center" style="padding-top: 15px;">
                    <h2 class="card-title" style="margin-left: 25px;">Language Translation</h2>
                    <div>
                        <a class="btn btn-danger add-keytrns" id="addkeytrnsbtndata" style="margin-right: 8px;">Add Key</a>
                        <a href="javascript:void(0);" class="btn btn-primary" id="translateAllBtn"
                            style="margin-right: 25px;">Translate All</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle" id="languageTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="color: #fff;">Setting ID</th>
                                    <th scope="col" style="color: #fff;">Key</th>
                                    <th scope="col" style="color: #fff;">Value</th>
                                    <th scope="col" style="color: #fff;">Auto Translate</th>
                                    <th scope="col" style="color: #fff;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="languageData">
                                {{-- Dynamic Data Will Be Injected Here --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Key Modal -->
    <div class="modal fade" id="addKeyModal" tabindex="-1" aria-labelledby="addKeyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Centered modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKeyModalLabel">Add New Key</h5>
                </div>
                <div class="modal-body">
                    <label for="keyInput">Enter Key:</label>
                    <input type="text" id="keyInput" style="background-color: #edeff166;" class="form-control" placeholder="Enter key here">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submitKeyBtn" class="btn btn-success">Submit</button>
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

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let currentPage = 1;
        const itemsPerPage = 9;
        let languageData = [];

        $(document).ready(function() {
            let status_id = getStatusIdFromUrl();
            if (status_id) {
                fetchLanguageData(status_id);
            } else {
                console.error("Status ID not found in the URL.");
            }
        });

        var baseUrl = "{{ url('/') }}/";

        function getStatusIdFromUrl() {
            let url = window.location.href;
            let parts = url.split('/');
            return parts[parts.length - 1]; // Assuming status_id is the last segment
        }

        function fetchLanguageData(status_id) {
            $.ajax({
                url: baseUrl + "api/fetchDefaultLanguage",
                type: "POST",
                data: {
                    status_id: status_id
                },
                success: function(response) {
                    if (response.success) {
                        languageData = response.results;
                        currentPage = 1; // Reset to first page
                        renderTable();
                    } else {
                        displayMessage("No Data Found");
                    }
                },
                error: function() {
                    displayMessage("Error Fetching Data");
                }
            });
        }

        function displayMessage(message) {
            $("#languageData").html(`
        <tr>
            <td colspan="5" class="text-center">
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                    <div
                                                style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                <i class="bx bx-globe" style="font-size: 2.5rem; color: #fff;"></i>
                                            </div>
                    <p style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #222E50;">No Data Found</p>
                </div>
            </td>
        </tr>
    `);
        }


        function renderTable() {
            let tableBody = "";
            let start = (currentPage - 1) * itemsPerPage;
            let end = start + itemsPerPage;
            let paginatedItems = languageData.slice(start, end);

            paginatedItems.forEach(item => {
                tableBody += `
            <tr>
                <td>${item.setting_id}</td>
                <td><input type="text" class="form-control key-input" value="${item.key}" style="background-color: #edeff166;"></td>
                <td><input type="text" class="form-control adetri-key" value="${item.Translation}" style="background-color: #edeff166;"></td>
                <td>
                    <button type="button" class="btn btn-primary trans-btn btn-md" data-setting-id="${item.setting_id}">Translate</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger updatelng-btn btn-md" data-setting-id="${item.setting_id}">Update</button>
                </td>
            </tr>
        `;
            });

            $("#languageData").html(tableBody);
            renderPagination();

            // Add event listener for translation button
            $(".trans-btn").on("click", function() {
                let settingId = $(this).data("setting-id");
                let statusId = getStatusIdFromUrl();
                let newValue = $(this).closest("tr").find(".key-input").val();
                translateKeyword(settingId, statusId, newValue);
            });


            // Add event listener for translation button
            $(".updatelng-btn").on("click", function() {
                let settingId = $(this).data("setting-id");
                let statusId = getStatusIdFromUrl();
                let newValue = $(this).closest("tr").find(".adetri-key").val();
                updateKeywordLanguage(settingId, statusId, newValue);
            });
        }

        function translateKeyword(settingId, statusId, newValue) {
            $.ajax({
                url: baseUrl + "api/translateoneKeywords",
                type: "POST",
                data: {
                    setting_id: settingId,
                    status_id: statusId,
                    newValue: newValue
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Translation Successful",
                            text: "The keyword has been translated successfully."
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Translation Failed",
                            text: "Something went wrong. Please try again."
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Error occurred while translating."
                    });
                }
            });
        }


        function updateKeywordLanguage(settingId, statusId, newValue) {
            $.ajax({
                url: baseUrl + "api/translateoneKeywords",
                type: "POST",
                data: {
                    setting_id: settingId,
                    status_id: statusId,
                    newValue: newValue
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Translation Successful",
                            text: "The keyword has been translated successfully."
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Translation Failed",
                            text: "Something went wrong. Please try again."
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Error occurred while translating."
                    });
                }
            });
        }

        function renderPagination() {
            let totalPages = Math.ceil(languageData.length / itemsPerPage);
            let paginationHtml = "";

            if (totalPages > 1) {
                paginationHtml += `<nav><ul class="pagination">`;

                // Previous button
                paginationHtml += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">&laquo;</a>
        </li>`;

                for (let i = 1; i <= totalPages; i++) {
                    if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                        paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>`;
                    } else if (i === 2 || i === totalPages - 1) {
                        paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }
                }

                // Next button
                paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">&raquo;</a>
        </li>`;

                paginationHtml += `</ul></nav>`;
            }

            $(".pagination-container").html(paginationHtml);
            updateEntriesInfo();
        }

        function updateEntriesInfo() {
            let start = (currentPage - 1) * itemsPerPage + 1;
            let end = Math.min(start + itemsPerPage - 1, languageData.length);
            $(".entries-info").text(`Showing ${start} to ${end} of ${languageData.length} entries`);
        }

        function changePage(page) {
            if (page < 1 || page > Math.ceil(languageData.length / itemsPerPage)) return;
            currentPage = page;
            renderTable();
        }
    </script>

    <script>
        $(document).ready(function() {
            let status_id = getStatusIdFromUrl();

            if (!status_id) {
                console.error("Status ID not found in the URL.");
            }

            var baseUrl = "{{ url('/') }}/";

            // Click event for "Translate All" button
            $(".btn-primary").click(function(event) {
                event.preventDefault(); // Prevent default link behavior

                if (!status_id) {
                    Swal.fire("Error", "Invalid status ID.", "error");
                    return;
                }

                // Show loader
                Swal.fire({
                    title: "Translating...",
                    text: "Please wait while we translate all keywords.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Call API
                $.ajax({
                    url: baseUrl + "api/translateAllKeywords",
                    type: "POST",
                    data: {
                        status_id: status_id
                    },
                    success: function(response) {
                        Swal.close(); // Close loader

                        if (response.success) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                location.reload(); // Refresh page
                            });
                        } else {
                            Swal.fire("Error", "Translation failed. Please try again.",
                                "error");
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire("Error", "An error occurred while translating.", "error");
                    }
                });
            });
        });

        function getStatusIdFromUrl() {
            let url = window.location.href;
            let parts = url.split('/');
            return parts[parts.length - 1]; // Assuming status_id is the last segment
        }
    </script>



    <script>
        $(document).ready(function() {
            let baseUrl = "{{ url('/') }}/";

            // Show modal when "Add Key" button is clicked
            $("#addkeytrnsbtndata").click(function() {
                $("#addKeyModal").modal("show");
            });

            // Submit new key
            $("#submitKeyBtn").click(function() {
                let key = $("#keyInput").val().trim();

                if (key === "") {
                    Swal.fire("Error", "Key field cannot be empty.", "error");
                    return;
                }

                Swal.fire({
                    title: "Adding Key...",
                    text: "Please wait while we add the key.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: baseUrl + "api/addKey",
                    type: "POST",
                    data: {
                        key: key
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.success) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                location.reload(); // Refresh page after success
                            });
                        } else {
                            Swal.fire("Error", "Failed to add key. Please try again.", "error");
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire("Error", "An error occurred while adding the key.", "error");
                    }
                });
            });
        });
    </script>
@endsection
