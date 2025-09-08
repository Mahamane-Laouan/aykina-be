<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\BookingProviderHistory;
use App\Models\Product;
use App\Models\ProviderBankdetails;
use App\Models\ProviderHistory;
use App\Models\ProviderReqModel;
use App\Models\Service;
use App\Models\HandymanReview;
use App\Models\OrdersModel;
use App\Models\ServiceReview;
use App\Models\ServiceProof;
use App\Models\SiteSetup;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderViewController extends Controller
{
    // viewProvider
    public function viewProvider($id, $year = null)
    {
        // Fetch the user details
        $user = User::findOrFail($id);

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $bankDetails = ProviderBankdetails::where('provider_id', $id)->first(); // Assuming a provider has one bank account, otherwise you can use get() if multiple

        // Get the total number of services where v_id matches the user's id (if no data, return 0)
        $totalServices = Service::where('v_id', $id)->count() ?? 0;

        // Get the total number of products where vid matches the user's id (if no data, return 0)
        $totalProducts = Product::where('vid', $id)->count() ?? 0;

        $totalBooking = BookingOrders::where('provider_id', $id)->count() ?? 0;

        $WalletBalance = ProviderHistory::where('provider_id', $id)->sum('available_bal') ?? 0;

        $WithdrawnBalance = ProviderReqModel::where('provider_id', $id)->where('status', 1)->sum('amount') ?? 0;

        $totalProviderBalance = ProviderHistory::where('provider_id', $id)->sum('total_bal') ?? 0;

        // Get the average review star count for the provider (if no review, return 0.0)
        $avgReview = ServiceReview::where('provider_id', $id)->avg('star_count') ?? 0.0;


        $pendingBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($id) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
            ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder',
                    function ($bookingQuery) use ($id) {
                        $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 0) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $id); // Filter by logged-in provider
                    }
                );
        })->count();


        $acceptedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($id) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
            ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder',
                    function ($bookingQuery) use ($id) {
                        $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 2) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $id); // Filter by logged-in provider
                    }
                );
        })->count();


        $rejectedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($id) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
            ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder',
                    function ($bookingQuery) use ($id) {
                        $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 3) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $id); // Filter by logged-in provider
                    }
                );
        })->count();


        $inprogressBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($id) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
            ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder',
                    function ($bookingQuery) use ($id) {
                        $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 4) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $id); // Filter by logged-in provider
                    }
                );
        })->count();


        $completedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($id) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
            ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder',
                    function ($bookingQuery) use ($id) {
                        $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 6) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $id); // Filter by logged-in provider
                    }
                );
        })->count();


        $cancelledBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($id) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
            ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder',
                    function ($bookingQuery) use ($id) {
                        $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 8) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $id); // Filter by logged-in provider
                    }
                );
        })->count();


        $holdBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($id) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
            ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder',
                    function ($bookingQuery) use ($id) {
                        $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 7) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $id); // Filter by logged-in provider
                    }
                );
        })->count();



        // Fetch all services related to the provider (v_id) with their details, associated images, and sales count
        // Fetch all services related to the provider (v_id) with their details, associated images, sales count, and category name
        $services = Service::with('serviceImages', 'category') // Eager load service images and category
            ->where('v_id', $id)
            ->orderBy('created_at', 'desc')
            ->get(['service_name', 'service_description', 'service_price', 'service_discount_price', 'id', 'cat_id', 'status', 'duration', 'id']) // Fetch cat_id
            ->map(function ($service) {
                // Calculate the sales count for the current service
                $service->sales_count = BookingOrders::where('service_id', $service->id)->count() ?? 0;
                // Add category name to the service object
                $service->c_name = $service->category ? $service->category->c_name : '';
                return $service;
            });

        // Fetch the latest customers dynamically through provider_id
        $latestCustomers = ServiceReview::where('provider_id', $id)
            ->with('user') // Eager load the user relationship
            ->get()
            ->filter(fn($review) => $review->user !== null) // Ensure user exists
            ->map(function ($review) {
                return [
                    'id' => $review->user->id,
                    'firstname' => $review->user->firstname ?? '',
                    'lastname' => $review->user->lastname ?? '',
                    'email' => $review->user->email ?? '',
                    'profile_pic' => $review->user->profile_pic ?? 'default_user.jpg', // Fallback for profile picture
                    'star_count' => $review->star_count,
                    'text' => $review->text ?? '', // Fallback for review text
                    'created_at' => Carbon::parse($review->created_at)->format('d F, Y'),
                ];
            });

        // Month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // If a year is provided, use it; otherwise, use the current year
        $year = $year ?: date('Y');

        // Fetch monthly earnings for the provider based on the selected year
        $monthlyEarnings = [];
        foreach ($monthNames as $index => $month) {
            $earnings = BookingProviderHistory::where('provider_id', $id)
                ->whereYear('created_at', $year) // Filter by selected year
                ->whereMonth('created_at', $index + 1)
                ->sum('amount'); // Sum the earnings for the provider in that month

            // Add the earnings for the month to the data array
            $monthlyEarnings[] = [
                'x' => $month,
                'Earnings' => $earnings ?? 0, // Default to 0 if no earnings for that month
            ];
        }

        // Get the available years based on the created_at column in BookingProviderHistory for this provider
        $availableYears = BookingProviderHistory::where('provider_id', $id)
            ->selectRaw('YEAR(created_at) as year') // Get the year part of created_at
            ->distinct() // Make sure we only get distinct years
            ->orderByDesc('year') // Order from most recent to oldest
            ->pluck('year');

        $payouts = ProviderReqModel::where('provider_id', $id)->select('amount', 'status', 'created_at')->get();

        // Fetch average review ratings for each provider
        // Fetch average review ratings for each provider
        $handymanIds = HandymanReview::where('provider_id', $id)->pluck('handyman_id')->filter(); // Get all provider IDs

        $avgHandymansReviews = HandymanReview::whereIn('handyman_id', $handymanIds)->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')->groupBy('handyman_id')->pluck('avg_star', 'handyman_id'); // Fetch avg star rating per provider

        // Fetch handymen for the provider through provider_id in the users table
        $handymen = User::where('provider_id', $id)
            ->select('firstname', 'lastname', 'email', 'mobile', 'country_code', 'profile_pic', 'id')
            ->get()
            ->map(function ($handyman) use ($avgHandymansReviews) {
                // Provide a default profile picture if not available
                $handyman->profile_pic = $handyman->profile_pic ?? 'default_handyman.jpg';
                // Attach the average handyman review
                $handyman->avg_handyman_review = $avgHandymansReviews[$handyman->id] ?? 0;
                return $handyman;
            });

        // Fetch all products related to the provider (vid) with their details, associated services, and product images
        $products = Product::with([
            'productImages',
            'service' => function ($query) {
                $query->select('id', 'service_name', 'service_description', 'service_price', 'service_discount_price');
            },
        ])
            ->where('vid', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($product) {
                // Add associated service details to the product object
                $product->service_details = $product->service;

                return $product;
            });

        // Fetch the counts for each booking status for the provider
        $statusCounts = [
            'Pending' => BookingOrders::where('provider_id', $id)->where('handyman_status', 0)->count(),
            'Accepted' => BookingOrders::where('provider_id', $id)->where('handyman_status', 2)->count(),
            'Rejected' => BookingOrders::where('provider_id', $id)->where('handyman_status', 3)->count(),
            'Completed' => BookingOrders::where('provider_id', $id)->where('handyman_status', 6)->count(),
        ];

        // Fetch average review ratings for each provider
        $userIds = ServiceReview::where('provider_id', $id)->pluck('user_id')->filter(); // Get all provider IDs

        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')->groupBy('user_id')->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        // Fetch the latest customers dynamically through provider_id
        $latestCustomersofProvider = ServiceReview::where('provider_id', $id)
            ->with('user') // Eager load the user relationship
            ->get()
            ->filter(fn($review) => $review->user !== null) // Ensure user exists
            ->map(function ($review) use ($avgUsersReviews) {
                return [
                    'id' => $review->user->id,
                    'firstname' => $review->user->firstname ?? '',
                    'lastname' => $review->user->lastname ?? '',
                    'email' => $review->user->email ?? '',
                    'profile_pic' => $review->user->profile_pic ?? 'default_user.jpg', // Fallback for profile picture
                    'star_count' => $review->star_count,
                    'text' => $review->text ?? '', // Fallback for review text
                    'created_at' => Carbon::parse($review->created_at)->format('d F, Y'),
                    'avg_users_review' => number_format($avgUsersReviews[$review->user->id] ?? 0.0, 1), // Fetch avg review rating
                ];
            });

        // Transform the created_at field for the main page view
        // $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
        //     $record->formatted_created_at = $record->created_at
        //         ? $record->created_at->format('d M, Y / g:i A')
        //         : '';

        //     // Ensure provider exists before assigning avg review
        //     if ($record->user) {
        //         $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
        //     }
        //     return $record;
        // });

        // Pass the values to the view
        return view('provider-view', compact('user', 'totalServices', 'totalProducts', 'avgReview', 'services', 'latestCustomers', 'monthlyEarnings', 'availableYears', 'totalBooking', 'WalletBalance', 'WithdrawnBalance', 'totalProviderBalance', 'bankDetails', 'payouts', 'handymen', 'products', 'statusCounts', 'defaultCurrency', 'latestCustomersofProvider', 'avgUsersReviews',
            'pendingBookingCount',
            'acceptedBookingCount',
            'rejectedBookingCount',
            'inprogressBookingCount',
            'completedBookingCount',
            'cancelledBookingCount',
            'holdBookingCount',));
    }

    // getMonthlyEarnings
    public function getMonthlyEarnings($id, $year)
    {
        // Month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Fetch monthly earnings for the provider based on the selected year
        $monthlyEarnings = [];
        foreach ($monthNames as $index => $month) {
            $earnings = BookingProviderHistory::where('provider_id', $id)
                ->whereYear('created_at', $year) // Filter by selected year
                ->whereMonth('created_at', $index + 1)
                ->sum('amount'); // Sum the earnings for the provider in that month

            // Add the earnings for the month to the data array
            $monthlyEarnings[] = [
                'x' => $month,
                'Earnings' => $earnings ?? 0, // Default to 0 if no earnings for that month
            ];
        }

        // Return the earnings data as JSON
        return response()->json(['monthlyEarnings' => $monthlyEarnings]);
    }
}
