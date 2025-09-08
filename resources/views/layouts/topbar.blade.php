<meta name="csrf-token" content="{{ csrf_token() }}">
<header id="page-topbar" class="isvertical-topbar">
    @php
        $user = Auth::guard('admin')->user();
    @endphp
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a id="logo">
                    <span>
                        <img src="{{ $user->profile_pic ? asset('images/user/' . $user->profile_pic) : URL::asset('images/user/default_user.jpg') }}"
                            alt="" height="40"
                            style="margin-top: 26px; height:40px; width:40px; border-radius: 50%; object-fit: cover;">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                <i class="bx bx-menu align-middle"></i>
            </button>

            <div class="page-title-box align-self-center d-none d-md-block">
                <h4 class="page-title mb-0">@yield('page-title')</h4>
            </div>
        </div>



        <div class="d-flex">

            @if (Auth::guard('admin')->check())
                @php
                    $user = Auth::guard('admin')->user();
                @endphp

                @if ($user->id == 1)

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon"
                            id="page-header-notifications-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-bell icon-sm align-middle"></i>
                            <span class="noti-dot bg-danger rounded-pill" id="notification-count">
                                {{ $notificationCount }}
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown-v">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-15"> Notifications </h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 250px;">
                                @if (count($withdrawalNotifications) > 0)

                                    @foreach ($withdrawalNotifications as $notification)
                                        <div class="text-reset notification-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    @if ($notification['profile_pic'])
                                                        <img src="{{ $notification['profile_pic'] }}"
                                                            class="rounded-circle avatar-sm" alt="user-pic">
                                                    @else
                                                        <div class="avatar-sm rounded-circle bg-warning text-white d-flex align-items-center justify-content-center"
                                                            style="width: 35px; height: 35px; font-size: 18px;">
                                                            W
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted font-size-13 mb-0 float-end">
                                                        {{ $notification['time'] }}</p>
                                                    <h6 class="mb-1">Withdraw Request</h6>
                                                    <p class="mb-0">{{ $notification['message'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="p-3 text-center">
                                        <p class="text-muted mb-0">No notifications to display</p>
                                    </div>
                                @endif
                            </div>
                            @if (count($withdrawalNotifications) > 0)
                                <div class="p-2 border-top d-grid" style="background: #246fc1;">
                                    <a class="btn btn-sm btn-link font-size-14 btn-block text-center"
                                        href="javascript:void(0);" id="view-more-btn">
                                        <i class="uil-arrow-circle-right me-1"></i> <span style="color: #fff;">View
                                            More..</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif

            @php
                $user = Auth::guard('admin')->user();
            @endphp

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center"
                    id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">

                    <!-- User Profile Picture -->
                    <img class="rounded-circle header-profile-user"
                        src="{{ $user && $user->profile_pic ? asset('images/user/' . $user->profile_pic) : URL::asset('images/user/default_user.jpg') }}"
                        alt="Header Avatar" style="object-fit: cover;">
                    <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">
                        {{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}
                    </span>
                </button>

                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0">
                            {{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}
                        </h6>
                        <p class="mb-0 font-size-11 text-muted">
                            {{ $user->email ?? '' }}
                        </p>
                    </div>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i>
                        <span class="align-middle">Profile</span>
                    </a>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i>
                        <span class="align-middle">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <div class="dropdown-divider"></div>
                </div>
            </div>
        </div>


    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewMoreButton = document.getElementById('view-more-btn');

        if (viewMoreButton) {
            viewMoreButton.addEventListener('click', function() {
                fetch('/mark-notifications-as-read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update notification count
                        document.querySelector('.noti-dot').textContent = '0';

                        // Optionally, you can update the view to reflect the marked notifications.
                        console.log(data.message); // success message or handle accordingly

                        // Redirect to notification data list page
                        window.location.href = '/notificationdata-list';
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });
</script>
