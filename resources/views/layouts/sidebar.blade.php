<!-- ========== Left Sidebar Start ========== -->

<style>
    .vertical-menu {
        background: #00162e !important;
    }

    .navbar-brand-box {
        background-color: #00162e !important;
    }

    #sidebar-menu ul li.mm-active>a {
        background-color: #30343A;
        color: #ffffff !important;
        background: none !important;

    }

    #sidebar-menu ul li.mm-active {
        color: #ffffff !important;
    }

    .mm-active {
        color: #ffffff !important;
    }

    #sidebar-menu ul li ul.sub-menu li a:hover {
        color: #ffffff !important;
    }

    #sidebar-menu ul li a:hover {
        color: #ffffff !important;
    }

    /* General Badge Styling */
    .booking-status-badge {
        min-width: 22px;
        height: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        /* Slightly smaller for sleek design */
        font-weight: bold;
        border-radius: 50%;
        margin-left: 8px;
        text-align: center;
        padding: 2px 6px;
        transition: all 0.3s ease-in-out;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
    }

    /* Status Badges with Soft Gradient Shades */
    .pending-badge {
        background: linear-gradient(135deg, #FFECB3, #FFE082);
        /* Soft Golden Yellow */
        color: #4A3B1D;
    }

    .accepted-badge {
        background: linear-gradient(135deg, #D1C4E9, #B39DDB);
        /* Soft Lavender */
        color: #37284C;
    }

    .rejected-badge {
        background: linear-gradient(135deg, #FFCDD2, #EF9A9A);
        /* Soft Coral Red */
        color: #5C1E1E;
    }

    .inprogress-badge {
        background: linear-gradient(135deg, #B3E5FC, #81D4FA);
        /* Soft Sky Blue */
        color: #1A3A56;
    }

    .completed-badge {
        background: linear-gradient(135deg, #C8E6C9, #A5D6A7);
        /* Soft Mint Green */
        color: #2C5E2C;
    }

    .cancelled-badge {
        background: linear-gradient(135deg, #E0E0E0, #BDBDBD);
        /* Soft Grey */
        color: #4D4D4D;
    }

    .hold-badge {
        background: linear-gradient(135deg, #FFCC80, #FFA726);
        /* Soft Orange */
        color: #6B3300;
    }

    /* Hover Effect for Smooth UI */
    .booking-status-badge:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }

    .handy-fontfame {
        font-size: 14px;
        font-weight: 500;
        color: #fffc;
        text-transform: uppercase;
        margin-bottom: 0;
        letter-spacing: .75px;

    }
</style>


<!-- Add this in your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="vertical-menu">

    @php
        $user = Auth::guard('admin')->user();
    @endphp

    @if (Auth::guard('admin')->check())
        @php
            $user = Auth::guard('admin')->user();
        @endphp

        @if ($user->id == 1)
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <div class="logo logo-dark" style="padding-top: 24px;">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('images/logo/handyhue_icon.png') }}" alt="" height="26">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('images/logo/handyman_logo21.png') }}" alt="" height="28">
                    </span>
                </div>
            </div>
        @elseif($user->people_id == 1)
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <div class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('images/logo/handyhue_icon.png') }}" alt="" height="26">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('images/logo/handyman_logo21.png') }}" alt="" height="28">
                    </span>
                </div>
            </div>
        @endif
    @endif

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
        style="color: #ffff;">
        <i class="bx bx-menu align-middle"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">


        <!--- Sidemenu -->
        <div id="sidebar-menu">

            @if (Auth::guard('admin')->check())
                @php
                    $user = Auth::guard('admin')->user();
                @endphp

                @if ($user->id == 1)
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title handy-fontfame" data-key="t-menu">Dashboard</li>


                        <li>
                            <a href="/admin-dashboard">
                                <i class="bx bx-home-alt icon nav-icon"></i>
                                <span class="menu-item">Dashboard</span>
                            </a>
                        </li>


                        <li>
                            <a href="/booking-list">
                                <i class="bx bx-calendar icon nav-icon"></i>
                                <span class="menu-item">Booking Orders</span>
                            </a>
                        </li>


                        <li>
                            <a href="javascript:void(0);" class="has-arrow">
                                <i class="bx bx-notepad icon nav-icon"></i>
                                <span class="menu-item">Service Booking</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                {{-- <li><a href="/booking-list">All Bookings</a></li> --}}
                                <li><a href="/pending-bookinglist"
                                        style="display: flex; justify-content:space-between;">Pending <span
                                            id="pending-count" class="booking-status-badge pending-badge">0</span></a>
                                </li>
                                <li><a href="/accepted-bookinglist"
                                        style="display: flex; justify-content:space-between;">Accepted <span
                                            id="accepted-count" class="booking-status-badge accepted-badge">0</span></a>
                                </li>
                                <li><a href="/rejected-bookinglist"
                                        style="display: flex; justify-content:space-between;">Rejected <span
                                            id="rejected-count" class="booking-status-badge rejected-badge">0</span></a>
                                </li>
                                <li><a href="/inprogress-bookinglist"
                                        style="display: flex; justify-content:space-between;">In Progress <span
                                            id="inprogress-count"
                                            class="booking-status-badge inprogress-badge">0</span></a></li>
                                <li><a href="/completed-bookinglist"
                                        style="display: flex; justify-content:space-between;">Completed <span
                                            id="completed-count"
                                            class="booking-status-badge completed-badge">0</span></a></li>
                                <li><a href="/cancelled-bookinglist"
                                        style="display: flex; justify-content:space-between;">Cancelled <span
                                            id="cancelled-count"
                                            class="booking-status-badge cancelled-badge">0</span></a></li>
                                <li><a href="/hold-bookinglist"
                                        style="display: flex; justify-content:space-between;">Hold <span id="hold-count"
                                            class="booking-status-badge hold-badge">0</span></a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-cart icon nav-icon"></i>
                                <span class="menu-item">Product Orders</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                {{-- <li><a href="/all-productbookinglist">All Orders</a></li> --}}
                                <li><a href="/pending-productbookinglist"
                                        style="display: flex; justify-content:space-between;">Pending<span
                                            id="productpending-count"
                                            class="booking-status-badge pending-badge">0</span></a>
                                </li>
                                <li><a href="/inprogress-productbookinglist"
                                        style="display: flex; justify-content:space-between;">In Progress <span
                                            id="productinprogress-count"
                                            class="booking-status-badge inprogress-badge">0</span></a>
                                </li>
                                <li><a href="/delivered-productbookinglist"
                                        style="display: flex; justify-content:space-between;">Delivered <span
                                            id="productcompleted-count"
                                            class="booking-status-badge completed-badge">0</span></a>
                                </li>
                                <li><a href="/cancelled-productbookinglist"
                                        style="display: flex; justify-content:space-between;">Rejected <span
                                            id="productcancelled-count"
                                            class="booking-status-badge rejected-badge">0</span></a>
                                </li>
                                <li><a href="/cancelledbyuser-productbookinglist"
                                        style="display: flex; justify-content:space-between;">Cancelled by User
                                        <span id="cancelledbyuser-count"
                                            class="booking-status-badge cancelled-badge">0</span></a>
                                </li>
                            </ul>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">User Management</li>

                        <li>
                            <a href="/all-users">
                                <i class="bx bx-user icon nav-icon"></i>
                                <span class="menu-item">All Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="/user-list">
                                <i class="bx bx-user icon nav-icon"></i>
                                <span class="menu-item">Customers</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-user icon nav-icon"></i>
                                <span class="menu-item">Providers</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/provider-add">Add Provider</a></li>
                                <li><a href="/providers-list">Provider List</a></li>
                                {{-- <li><a href="/provider-requestlist"
                                        style="display: flex; justify-content:space-between;">Unverified Provider <span
                                            id="unverfiedprovider-count"
                                            class="booking-status-badge inprogress-badge">0</span></a></li> --}}
                            </ul>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-user icon nav-icon"></i>
                                <span class="menu-item">Handyman</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/handyman-add">Add Handyman</a></li>
                                <li><a href="/handyman-list">Handyman List</a></li>
                                {{-- <li><a href="/handyman-requestlist"
                                        style="display: flex; justify-content:space-between;">Unverified Handyman <span
                                            id="unverfiedhandyman-count"
                                            class="booking-status-badge inprogress-badge">0</span> </a></li> --}}
                            </ul>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">Service Management</li>


                        <li>
                            <a href="/category-list">
                                <i class="bx bx-aperture icon nav-icon"></i>
                                <span class="menu-item">Category List</span>
                            </a>
                        </li>

                        <li>
                            <a href="/subcategory-list">
                                <i class="bx bx-list-ul icon nav-icon"></i>
                                <span class="menu-item">Sub Category List</span>
                            </a>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-briefcase icon nav-icon"></i>
                                <span class="menu-item">Services</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/service-add">Add Service</a></li>
                                <li><a href="/service-list">Service List</a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-box icon nav-icon"></i>
                                <span class="menu-item">Product</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/product-add">Add Product</a></li>
                                <li><a href="/product-list">Product List</a></li>
                            </ul>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">Order Management</li>

                         <li>
                            <a href="/payout-listprovider">
                                <i class="bx bx-money icon nav-icon"></i>
                                <span class="menu-item">Payouts</span>
                            </a>
                        </li>

                        <li>
                            <a href="/payment-list">
                                <i class="bx bx-wallet icon nav-icon"></i>
                                <span class="menu-item">Transactions</span>
                            </a>
                        </li>

                        <li>
                            <a href="/earnings">
                                <i class="bx bx-dollar-circle icon nav-icon"></i>
                                <span class="menu-item">Earnings</span>
                            </a>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-star icon nav-icon"></i>
                                <span class="menu-item">Ratings</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/user-reviewlist">Customer Ratings List</a></li>
                                <li><a href="/provider-reviewlist">Provider Ratings List</a></li>
                                <li><a href="/handyman-reviewlist">Handyman Ratings List</a></li>

                            </ul>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">Marketing & Advertising</li>

                        <li>
                            <a href="/slider-list">
                                <i class="bx bx-slider icon nav-icon"></i>
                                <span class="menu-item">Slider</span>
                            </a>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-purchase-tag icon nav-icon"></i>
                                <span class="menu-item">Coupons</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/coupon-add">Add Coupon</a></li>
                                <li><a href="/coupon-list">Coupon List</a></li>
                            </ul>
                        </li>




                        <li class="menu-title handy-fontfame" data-key="t-menu">Financial Management</li>


                        <li>
                            <a href="/currencies-list">
                                <i class="bx bx-dollar icon nav-icon"></i>
                                <span class="menu-item">Currencies</span>
                            </a>
                        </li>

                        <li>
                            <a href="/tax-list">
                                <i class="bx bx-calculator icon nav-icon"></i>
                                <span class="menu-item">Tax</span>
                            </a>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">Content Management</li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-file-blank icon nav-icon"></i>
                                <span class="menu-item">Pages</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/privacy-policy">Privacy Policy</a></li>
                                <li><a href="/terms-conditions">Terms & Conditions</a></li>
                                <li><a href="/refund-policy">Refund Policy</a></li>
                                <li><a href="/cancel-policy">Cancellation Policy</a></li>
                                <li><a href="/about">About</a></li>
                                <li><a href="/contactus">Contact Us</a></li>
                            </ul>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">Settings Management</li>

                        <li>
                            <a href="/support-ticket">
                                <i class="bx bx-support icon nav-icon"></i>
                                <span class="menu-item">Support Ticket</span>
                            </a>
                        </li>


                        <li>
                            <a href="/notification-template">
                                <i class="bx bx-clipboard icon nav-icon"></i>
                                <span class="menu-item">Notification Template</span>
                            </a>
                        </li>

                        <li>
                            <a href="/payment-configuration">
                                <i class="bx bx-credit-card icon nav-icon"></i>
                                <span class="menu-item">Payment Method</span>
                            </a>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-envelope  icon nav-icon"></i>
                                <span class="menu-item">Email</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/useremail-detail">User Email</a></li>
                                <li><a href="/provideremail-detail">Provider Email</a></li>
                                <li><a href="/handymanemail-detail">Handyman Email</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="/language-list">
                                <i class="bx bx-globe icon nav-icon"></i>
                                <span class="menu-item">Language</span>
                            </a>
                        </li>


                        <li>
                            <a href="/settings">
                                <i class="bx bx-cog icon nav-icon"></i>
                                <span class="menu-item">Settings</span>
                            </a>
                        </li>
                    </ul>
                @elseif($user->people_id == 1)
                    <ul class="metismenu list-unstyled" id="side-menu">

                        <li class="menu-title handy-fontfame" data-key="t-menu">Dashboard</li>

                        <li>
                            <a href="/provider-dashboard">
                                <i class="bx bx-home-alt icon nav-icon"></i>
                                <span class="menu-item">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="/providerbooking-list">
                                <i class="bx bx-calendar icon nav-icon"></i>
                                <span class="menu-item">Booking Orders</span>
                            </a>
                        </li>


                        <li>
                            <a href="javascript:void(0);" class="has-arrow">
                                <i class="bx bx-notepad icon nav-icon"></i>
                                <span class="menu-item">Service Booking</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/providerpending-bookinglist"
                                        style="display: flex; justify-content:space-between;">Pending <span
                                            id="providerpending-count"
                                            class="booking-status-badge pending-badge">0</span></a>
                                </li>
                                <li><a href="/provideraccepted-bookinglist"
                                        style="display: flex; justify-content:space-between;">Accepted <span
                                            id="provideraccepted-count"
                                            class="booking-status-badge accepted-badge">0</span></a>
                                </li>
                                <li><a href="/providerrejected-bookinglist"
                                        style="display: flex; justify-content:space-between;">Rejected <span
                                            id="providerrejected-count"
                                            class="booking-status-badge rejected-badge">0</span></a>
                                </li>
                                <li><a href="/providerinprogress-bookinglist"
                                        style="display: flex; justify-content:space-between;">In Progress <span
                                            id="providerinprogress-count"
                                            class="booking-status-badge inprogress-badge">0</span></a></li>
                                <li><a href="/providercompleted-bookinglist"
                                        style="display: flex; justify-content:space-between;">Completed <span
                                            id="providercompleted-count"
                                            class="booking-status-badge completed-badge">0</span></a></li>
                                <li><a href="/providercancelled-bookinglist"
                                        style="display: flex; justify-content:space-between;">Cancelled <span
                                            id="providercancelled-count"
                                            class="booking-status-badge cancelled-badge">0</span></a></li>
                                <li><a href="/providerhold-bookinglist"
                                        style="display: flex; justify-content:space-between;">Hold <span
                                            id="providerhold-count"
                                            class="booking-status-badge hold-badge">0</span></a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-cart icon nav-icon"></i>
                                <span class="menu-item">Product Orders</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                {{-- <li><a href="/all-productbookinglist">All Orders</a></li> --}}
                                <li><a href="/providerpending-productbookinglist"
                                        style="display: flex; justify-content:space-between;">Pending<span
                                            id="providerproductpending-count"
                                            class="booking-status-badge pending-badge">0</span></a>
                                </li>
                                <li><a href="/providerinprogress-productbookinglist"
                                        style="display: flex; justify-content:space-between;">In Progress <span
                                            id="providerproductinprogress-count"
                                            class="booking-status-badge inprogress-badge">0</span></a>
                                </li>
                                <li><a href="/providerdelivered-productbookinglist"
                                        style="display: flex; justify-content:space-between;">Delivered <span
                                            id="providerproductcompleted-count"
                                            class="booking-status-badge completed-badge">0</span></a>
                                </li>
                                <li><a href="/providercancelled-productbookinglist"
                                        style="display: flex; justify-content:space-between;">Rejected <span
                                            id="providerproductcancelled-count"
                                            class="booking-status-badge rejected-badge">0</span></a>
                                </li>
                                <li><a href="/providercancelledbyuser-productbookinglist"
                                        style="display: flex; justify-content:space-between;">Cancelled by User
                                        <span id="providercancelledbyuser-count"
                                            class="booking-status-badge cancelled-badge">0</span></a>
                                </li>
                            </ul>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">User Management</li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-user icon nav-icon"></i>
                                <span class="menu-item">Handyman</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/providerhandyman-add">Add Handyman</a></li>
                                <li><a href="/providerhandyman-list">Handyman List</a></li>
                                <li><a href="/providerhandyman-earnings">Handyman Earnings</a></li>
                                <li><a href="/providerhandyman-reviewlist">Handyman Ratings List</a></li>
                                {{-- <li><a href="/handyman-commission">Handyman Commission</a></li> --}}
                            </ul>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">Service Management</li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-briefcase icon nav-icon"></i>
                                <span class="menu-item">Services</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/providerservice-add">Add Service</a></li>
                                <li><a href="/providerservice-list">Service List</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-box icon nav-icon"></i>
                                <span class="menu-item">Product</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/providerproduct-add">Add Product</a></li>
                                <li><a href="/providerproduct-list">Product List</a></li>
                            </ul>
                        </li>

                        <li class="menu-title handy-fontfame" data-key="t-menu">Order Management</li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-check-circle icon nav-icon"></i>
                                <span class="menu-item">Handyman Payment</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/providerhandyman-paymentrequest">Pending List</a></li>
                                <li><a href="/providerhandyman-approvedlist">Approved List</a></li>
                                <li><a href="/providerhandyman-rejectlist">Rejected List</a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="/providerwithdraw-request">
                                <i class="bx bx-transfer icon nav-icon"></i>
                                <span class="menu-item">Withdraw Request</span>
                            </a>
                        </li>


                        <li class="menu-title handy-fontfame" data-key="t-menu">Settings Management</li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bx bx-question-mark icon nav-icon"></i>
                                <span class="menu-item">Faq's</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/faq-add">Add Faq</a></li>
                                <li><a href="/faq-list">Faq List</a></li>
                            </ul>
                        </li>

                    </ul>
                @endif
            @endif
        </div>
        <!-- Sidebar -->

    </div>
</div>
<!-- Left Sidebar End -->

<script>
    // JavaScript to hide/show the logo
    $('#menuToggle').on('click', function() {
        $('#logo').toggle(); // Toggles visibility
    });
</script>


<script>
    document.getElementById('menuToggle').addEventListener('click', function() {
        let profileContainer = document.getElementById('profileImageContainer');
        if (document.body.classList.contains('sidebar-collapsed')) {
            // Sidebar is closed
            profileContainer.style.width = "80px";
            profileContainer.style.height = "80px";
        } else {
            // Sidebar is open
            profileContainer.style.width = "50px";
            profileContainer.style.height = "50px";
        }
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('/get-booking-counts') }}") // Adjust URL if needed
            .then(response => response.json())
            .then(data => {
                document.getElementById("pending-count").textContent = data.pending || 0;
                document.getElementById("accepted-count").textContent = data.accepted || 0;
                document.getElementById("rejected-count").textContent = data.rejected || 0;
                document.getElementById("inprogress-count").textContent = data.inprogress || 0;
                document.getElementById("completed-count").textContent = data.completed || 0;
                document.getElementById("cancelled-count").textContent = data.cancelled || 0;
                document.getElementById("hold-count").textContent = data.hold || 0;
            })
            .catch(error => console.error("Error fetching booking counts:", error));
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('/get-productbooking-counts') }}") // Adjust URL if needed
            .then(response => response.json())
            .then(data => {
                document.getElementById("productinprogress-count").textContent = data.inprogress;
                document.getElementById("productcompleted-count").textContent = data.completed;
                document.getElementById("productcancelled-count").textContent = data.cancelled;
                document.getElementById("productpending-count").textContent = data.pending;
                document.getElementById("cancelledbyuser-count").textContent = data.cancelledbyuser;


            })
            .catch(error => console.error("Error fetching booking counts:", error));
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('/get-providerbooking-counts') }}") // Adjust URL if needed
            .then(response => response.json())
            .then(data => {
                document.getElementById("providerpending-count").textContent = data.pending || 0;
                document.getElementById("provideraccepted-count").textContent = data.accepted || 0;
                document.getElementById("providerrejected-count").textContent = data.rejected || 0;
                document.getElementById("providerinprogress-count").textContent = data.inprogress || 0;
                document.getElementById("providercompleted-count").textContent = data.completed || 0;
                document.getElementById("providercancelled-count").textContent = data.cancelled || 0;
                document.getElementById("providerhold-count").textContent = data.hold || 0;
            })
            .catch(error => console.error("Error fetching booking counts:", error));
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('/get-providerproductbooking-counts') }}") // Adjust URL if needed
            .then(response => response.json())
            .then(data => {
                document.getElementById("providerproductinprogress-count").textContent = data.inprogress;
                document.getElementById("providerproductcompleted-count").textContent = data.completed;
                document.getElementById("providerproductcancelled-count").textContent = data.cancelled;
                document.getElementById("providerproductpending-count").textContent = data.pending;
                document.getElementById("providercancelledbyuser-count").textContent = data.cancelledbyuser;


            })
            .catch(error => console.error("Error fetching booking counts:", error));
    });
</script>
