@extends('layouts.master')

@section('title')
    Support Ticket Chat
@endsection

@php
    $userwelcomedata = Auth::guard('admin')->user();
@endphp

@section('page-title')
    Welcome, {{ $userwelcomedata->firstname }} {{ $userwelcomedata->lastname }}
@endsection

<link href="{{ asset('build/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/app.min.css') }}" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
    .conversation-time {
        font-size: 0.75rem;
        color: #999;
        text-align: right;
        /* For right-side messages */
        margin-top: 5px;
    }

    li.right .conversation-time {
        text-align: right;
        color: #ffff;
        /* For left-side admin messages */
    }
</style>

@section('body')

    <body>
    @endsection

    @section('content')
        <div class="row align-items-center">
            <div class="col-9" style="padding-top: 18px;">
                <div class="mb-3">
                    <h5 class="card-title"> Support Ticket Chat <span class="text-muted fw-normal ms-2"></span>
                    </h5>
                    <p class="text-muted">Support Ticket / Support Ticket Chat</p>
                </div>
            </div>

            <div class="col-3 text-end">
                <a href="/support-ticket" class="btn btn-primary">
                    <i class="bx bx-arrow-back me-2"></i> Back
                </a>
            </div>

        </div>


        <div class="d-lg-flex" style="padding-top: 10px;">
            <!-- Chat Container -->
            <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-3">
                <div class="card shadow-sm">
                    <!-- Chat Header -->
                    <div class="card-body">
                        <div class="row align-items-center mb-4">
                            <div class="col-md-9">
                                <h5 class="card-title mb-0">Ticket ID #{{ $ticket->id }}</h5>
                                <p class="text-muted mb-0">Support Chat Regarding {{ $ticket->subject }}</p>
                            </div>
                            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                @if ($ticket->supportChatStatus && $ticket->supportChatStatus->status == 0)
                                    <button type="button" class="btn btn-danger w-md waves-effect waves-light"
                                        id="close-ticket-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Close Ticket">
                                        Close Ticket
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="row border-bottom pb-3">
    <div class="col-md-8 d-flex align-items-center">
        <!-- User Avatar -->
        <div class="avatar me-3">
            <img src="{{ asset('images/user/' . ($ticket->user->profile_pic ?? 'default_user.jpg')) }}"
                class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
        </div>
        <!-- User Info -->
        <div>
            <h6 class="mb-1 text-truncate">
                <a href="{{ route('user-view', $ticket->user_id) }}"
                    style="color: #246FC1; text-decoration: none;">
                    {{ $ticket->user->firstname ?? '' }} {{ $ticket->user->lastname ?? '' }}
                </a>
                <span class="ms-1" style="color: #000000;">
                    <i class="bx bxs-star font-size-14 text-warning"></i>
                    <span class="font-size-14">
                        {{ $ticket->user->avg_users_review ?? '0' }}
                    </span>
                </span>
            </h6>
            <p class="text-muted mb-0 text-truncate">{{ $ticket->user->email ?? '' }}</p>
        </div>
    </div>
</div>

                    </div>

                    <!-- Chat Conversation -->
                    <!-- Chat Conversation -->
                    <div class="chat-conversation p-3" data-simplebar style="padding-bottom: 100px;">
                        <ul class="list-unstyled mb-0">
                            @foreach ($chatMessages as $message)
                                <!-- Day Title -->
                                @if (
                                    $loop->first ||
                                        $loop->index == 0 ||
                                        $chatMessages[$loop->index - 1]->created_at->toDateString() !== $message->created_at->toDateString())
                                    <li class="chat-day-title">
                                        <span class="title">
                                            @if ($message->created_at->isToday())
                                                Today
                                            @elseif ($message->created_at->isYesterday())
                                                Yesterday
                                            @else
                                                {{ $message->created_at->format('l, d M Y') }}
                                            @endif
                                        </span>
                                    </li>
                                @endif

                                <!-- Chat Messages -->
                                @if ($message->admin_message == 0)
                                    <!-- User Message (Left Side) -->
                                    <li>
                                        <div class="conversation-list">
                                            <div class="d-flex">
                                                <img src="{{ asset('images/user/' . ($ticket->user->profile_pic ?? 'default_user.jpg')) }}"
                                                    class="rounded-circle avatar me-3" alt="">
                                                <div class="flex-1">
                                                    <div class="ctext-wrap">
                                                        <div class="ctext-wrap-content">
                                                            <!-- Check if the message contains an image URL -->
                                                            @if ($message->url)
                                                                <div class="chat-image"
                                                                    style="max-width: 300px; max-height: 80px; overflow: hidden;">
                                                                    <img src="{{ asset('images/support_chat_images/' . $message->url) }}"
                                                                        class="img-fluid" alt="Message Image"
                                                                        style="width: 80%; height: 80px; object-fit: contain;">
                                                                </div>
                                                            @endif
                                                            <p class="mb-0"> {{ $message->message }}</p>
                                                            <div class="conversation-time">
                                                                <span>{{ $message->created_at->format('H:i') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @elseif($message->admin_message == 1)
                                    <!-- Admin Message (Right Side) -->
                                    <li class="right">
                                        <div class="conversation-list">
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <div class="ctext-wrap">
                                                        <div class="ctext-wrap-content">
                                                            <!-- Check if the message contains an image URL -->
                                                            @if ($message->url)
                                                                <div class="chat-image"
                                                                    style="max-width: 300px; max-height: 80px; overflow: hidden;">
                                                                    <img src="{{ asset('images/support_chat_images/' . $message->url) }}"
                                                                        class="img-fluid" alt="Message Image"
                                                                        style="width: 80%; height: 80px; object-fit: contain;">
                                                                </div>
                                                            @endif
                                                            <p class="mb-0 text-start">{{ $message->message }}</p>
                                                            <div class="conversation-time">
                                                                <span>{{ $message->created_at->format('H:i') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="{{ asset('images/user/' . ($admin->profile_pic ?? 'default_user.jpg')) }}"
                                                    class="rounded-circle avatar ms-3" alt="">
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach

                            <!-- Display "Ticket is Closed" message if chat status is closed -->
                            @if ($ticket->supportChatStatus && $ticket->supportChatStatus->status == 1)
                                <li class="ticket-closed-message">
                                    <p class="text-center text-muted">Ticket is closed</p>
                                </li>
                            @endif
                        </ul>
                    </div>

                    @if ($ticket->supportChatStatus && $ticket->supportChatStatus->status == 0)
                        <div class="p-3 border-top">
                            <div class="row align-items-center">
                                <!-- Image Preview (Above message input) -->
                                <div id="image-preview" class="col-12 mb-3" style="display: none;">
                                    <img id="preview-img" src="#" alt="Image Preview"
                                        style="max-width: 70px; height: 70px;" />
                                </div>

                                <!-- Message Input Field -->
                                <div class="col">
                                    <input type="text" class="form-control border bg-light-subtle rounded"
                                        id="message-input" placeholder="Enter your message..." />
                                </div>

                                <!-- Attachment Icon -->
                                <div class="col-auto">
                                    <label for="attach-doc" class="form-label mb-0">
                                        <i class="bx bx-paperclip bx-sm cursor-pointer text-secondary mx-2"></i>
                                        <input type="file" id="attach-doc" name="file" accept="image/*" hidden />
                                    </label>
                                </div>

                                <!-- Send Button -->
                                <div class="col-auto">
                                    <button type="button" id="send-message"
                                        class="btn btn-primary chat-send d-flex align-items-center px-3">
                                        <span class="d-none d-sm-inline-block me-2">Send</span>
                                        <i class="mdi mdi-send"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            // Show image preview when a file is selected
            document.getElementById('attach-doc').addEventListener('change', function(event) {
                var file = event.target.files[0];

                // Check if a file is selected and if it is an image
                if (file && file.type.startsWith('image')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imagePreview = document.getElementById('image-preview');
                        var previewImg = document.getElementById('preview-img');

                        // Display the image preview
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Hide the image preview if no image is selected
                    document.getElementById('image-preview').style.display = 'none';
                }
            });

            // Handle message sending with image (if selected)
            // Handle message sending with image (if selected)
            document.getElementById('send-message').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                var message = document.getElementById('message-input').value;
                var fileInput = document.getElementById('attach-doc');
                var formData = new FormData();

                // Check if there's a message or image
                if (message.trim() !== "" || fileInput.files[0]) {
                    // Append message and other data if available
                    if (message.trim() !== "") {
                        formData.append('message', message);
                    }
                    formData.append('order_number', '{{ $orderNumber }}');
                    formData.append('from_user', 1);
                    formData.append('to_user', '{{ $ticket->user ? $ticket->user->id : '' }}');
                    formData.append('admin_message', 1);

                    // Add the image if selected
                    if (fileInput.files[0]) {
                        formData.append('url', fileInput.files[0]);
                    }

                    // Send the message via AJAX
                    fetch("{{ route('sendMessage') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Clear the message input field and reset the image preview
                                document.getElementById('message-input').value = "";
                                document.getElementById('image-preview').style.display = 'none';

                                // Optionally, append the message or image to the chat container
                                var chatContainer = document.querySelector('.chat-conversation .list-unstyled');
                                var messageHtml = `
                    <li class="right">
                        <div class="conversation-list">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            ${data.message ? `<p class="mb-0 text-start">${data.message}</p>` : ''}
                                            ${data.imageUrl ? `<div class="chat-image" style="max-width: 300px; max-height: 80px; overflow: hidden;"><img src="{{ asset('images/support_chat_images') }}/${data.imageUrl}" class="img-fluid" style="width: 80%; height: 80px; object-fit: contain;"></div>` : ''}
                                            <div class="conversation-time">
                                                <span>${data.time}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img src="{{ asset('images/logo/' . ($admin->image ?? 'default_user.jpg')) }}" class="rounded-circle avatar ms-3" alt=""/>
                            </div>
                        </div>
                    </li>
                    `;
                                chatContainer.insertAdjacentHTML('beforeend', messageHtml);

                                // Reload the window on success
                                window.location.reload();
                            } else {
                                alert("Message could not be sent.");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        </script>


        <script>
            document.getElementById('close-ticket-btn').addEventListener('click', function() {
                Swal.fire({
                    title: 'Are you sure you want to close this ticket?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, close it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('closeTicket', ['id' => $ticket->id]) }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({})
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Closed!', data.message, 'success');
                                    document.getElementById('close-ticket-btn').style.display = 'none';
                                } else {
                                    Swal.fire('Error', 'There was an error closing the ticket.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error', 'There was an error processing your request.', 'error');
                            });
                    }
                });
            });
        </script>
    @endsection
