@extends('layouts.master')
@section('title')
    Slider List
@endsection
@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection
@section('body')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

    {{-- Heading detail --}}
    <div class="row align-items-center">
        <div class="col-md-3" style="padding-top: 18px;">
            <div class="mb-3">
                <h5 class="card-title">Slider List <span class="text-muted fw-normal ms-2">({{ $records->total() }})</span>
                </h5>
                <p class="text-muted">Marketing & Advertising / Slider List</p>
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

                <div class="d-flex justify-content-between align-items-center" style="padding-top: 15px;">
                    <!-- Title -->
                    <h2 class="card-title" style="margin-left: 25px;">Slider List</h2>

                    <!-- Add Faq Button -->
                    <a href="{{ route('slider-add') }}" class="btn btn-primary" style="margin-right: 25px;">Add
                        Slider</a>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="color: #ffff;">Slider</th>
                                    <th scope="col" style="color: #ffff;">Title</th>
                                    <th scope="col" style="color: #ffff;">Category</th>
                                    <th scope="col" style="color: #ffff;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($records->isEmpty())
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
                                                <div
                                                    style="background: linear-gradient(135deg, #246FC1, #1E5A97); padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                                    <i class="bx bx-slider" style="font-size: 2.5rem; color: #fff;"></i>
                                                </div>
                                                <p
                                                    style="margin-top: 0.6rem; font-size: 1.1rem; font-weight: 500; color: #444;">
                                                    No Slider Found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($records as $user)
                                        <tr>
                                            <td>
                                                @if ($user->banner_image)
                                                    <img src="{{ asset('images/banner_images/' . $user->banner_image) }}"
                                                        alt="Slider Image" style="height: 6rem; width: 6rem;"
                                                        class="avatar rounded-circle img-thumbnail me-2">
                                                @else
                                                @endif
                                            </td>

                                            <td>{{ $user->banner_name ?? '' }}</td>
                                            <td>{{ $user->category->c_name ?? '' }}</td>
                                            <td>
                                                <ul class="list-inline mb-0" style="gap: 0px; display: flex;">

                                                    <li class="list-inline-item">
                                                        <a href="{{ route('slider-edit', $user->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                            class="px-2 text-primary"><i
                                                                class="bx bx-pencil font-size-18"></i></a>
                                                    </li>

                                                    <li class="list-inline-item">
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                            class="px-2 text-danger"
                                                            onclick="deleteSlider({{ $user->id }})"><i
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
                <div>
                    Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of
                    {{ $records->total() }} entries
                </div>
                <div>
                    {{ $records->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection


{{-- deleteCategory --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var baseUrl = "{{ url('/') }}/";

    // deleteSlider
    function deleteSlider(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert slider!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete slider!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: baseUrl + 'slider-delete/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Slider has been removed.',
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
