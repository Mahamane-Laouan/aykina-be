@extends('layouts/layoutMaster')

@section('title', 'Provider List')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/providers-requestlist.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Provider /</span> Provider Request List
    </h4>
    <div class="row g-4 mb-4">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
    </div>

    <!-- Provider List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top">
                <thead>
                    <tr>
                        <th></th>
                        <th>Provider</th>
                        <th>Joining Date</th>
                        <th>Contact No</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- Status Modal --}}
        @foreach ($users as $user)
            <div class="modal fade" id="editStatusModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Provider Request Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editUserStatusForm{{ $user->id }}" method="post"
                                action="{{ route('providers-requestupdate', ['id' => $user->id]) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="confirmation{{ $user->id }}" class="form-label">Status</label>
                                    <select id="confirmation{{ $user->id }}" name="confirmation" class="form-select">
                                        <option value="1" @if ($user->confirmation === '1') selected @endif>Approved
                                        </option>
                                        <option value="0" @if ($user->confirmation === '0') selected @endif>Deny
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary"
                                onclick="saveUserStatus({{ $user->id }})">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
