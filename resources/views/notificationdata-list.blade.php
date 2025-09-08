@extends('layouts.master')

@section('title')
    List Notifications
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

        .notification-setting {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .notification-item-roll {
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            height: 77px;
        }

        .notification-content {
            display: flex;
            flex: 1;
        }

        .profile-pic {
            margin-right: 15px;
        }

        .rounded-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .notification-text h4 {
            font-size: 16px;
            margin: 0;
            color: #333;
        }

        .notification-text .provider-name {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
        }

        .notification-time {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 12px;
            color: #666;
            display: flex;
            align-items: center;
        }

        .notification-time svg {
            margin-right: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .notification-item-roll {
                padding: 10px;
                margin-bottom: 12px;
            }

            .rounded-img {
                width: 35px;
                height: 35px;
            }

            .notification-text h4 {
                font-size: 14px;
            }

            .notification-text .provider-name {
                font-size: 12px;
            }

            .notification-time {
                font-size: 10px;
                top: 5px;
                right: 10px;
            }

            .notification-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .notification-time {
                position: relative;
                top: 0;
                right: 0;
            }
        }

        @media (max-width: 576px) {
            .notification-item-roll {
                flex-direction: column;
                padding: 8px;
            }

            .profile-pic {
                margin-bottom: 10px;
            }

            .notification-time {
                font-size: 10px;
                position: relative;
                top: 0;
                right: 0;
            }

            .rounded-img {
                width: 30px;
                height: 30px;
            }

            .notification-text h4 {
                font-size: 12px;
            }

            .notification-text .provider-name {
                font-size: 10px;
            }
        }
    </style>
@endsection

@section('body')
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    
    <div class="row" style="padding-top: 50px;">
        <div class="m-auto col-xl-10 col-xxl-8">
            <div class="card tab2-card">
                <div class="card-header">
                    <h5>List Notifications</h5>
                </div>
                <div class="card-body" style="background-color: #f9f9f9; padding: 20px;">
                    <ul class="notification-setting">
                        @foreach ($withdrawalFormattedNotifications as $notification)
                            <li class="notification-item-roll" data-id="{{ $notification['id'] }}"
                                style="background-color: {{ $notification['is_color'] == 0 ? '#DBE5EF' : '#fff' }};">
                                <div class="notification-content">
                                    <div class="profile-pic">
                                        @if ($notification['profile_pic'])
                                            <img src="{{ $notification['profile_pic'] }}" alt="Vendor's Profile Picture"
                                                class="rounded-img">
                                        @else
                                            <div class="rounded-img"
                                                style="background-color: #ccc; display: flex; justify-content: center; align-items: center; width: 40px; height: 40px;">
                                                <span style="color: #fff; font-size: 18px;">W</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="notification-text">
                                        <h4>Withdraw Request</h4>
                                        <p class="provider-name">{{ $notification['message'] }}</p>
                                    </div>
                                </div>
                                <div class="notification-time">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    {{ $notification['time'] }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to update notification color
        function updateNotificationColor(notificationId) {
            fetch(`/update-notification-color/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        is_color: 1,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notificationItem = document.querySelector(
                            `.notification-item-roll[data-id="${notificationId}"]`);
                        if (notificationItem) {
                            notificationItem.style.backgroundColor = '#fff'; // Update the color locally
                        }
                    } else {
                        console.log('Error updating color');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // 1. Update color when clicking a notification
        document.querySelectorAll('.notification-item-roll').forEach(item => {
            item.addEventListener('click', function() {
                const notificationId = this.getAttribute('data-id');
                updateNotificationColor(notificationId);
            });
        });

        // 2. Update color for all notifications only when manually refreshing
        if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
            // This is a manual refresh, so update the colors
            document.querySelectorAll('.notification-item-roll').forEach(item => {
                const notificationId = item.getAttribute('data-id');
                updateNotificationColor(notificationId);
            });
        }
    });
</script>
