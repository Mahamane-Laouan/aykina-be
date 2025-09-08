<?php

namespace App\Http\Controllers;

use App\Models\OrdersModel;
use App\Models\Product;
use App\Models\BookingOrdersStatus;
use App\Models\Service;
use App\Models\BookingOrders;
use App\Models\SiteSetup;
use App\Models\HandymanReview;
use App\Models\ServiceProof;
use App\Models\ServiceReview;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the current year or the year from the request
        $year = $request->get('year', date('Y'));

        $month = $request->get('month', date('m')); // Default to current month

        // Fetch total services count
        $totalServices = Service::count();

        // Fetch total products count
        $totalProducts = Product::count();

        // Fetch total amount from the orders table
        $totalAmount = OrdersModel::sum('total');

        // Fetch total bookings count
        $totalBooking = OrdersModel::count();

        // Fetch total bookings count
        $totalprovider = User::where('people_id', 1)->count();

        $totaluser = User::where('people_id', 3)->count();

        // Fetch total bookings count
        // Fetch total bookings count
        $pendingBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 0); // Check for handyman_status as 0 (Pending)
                });
        })
            ->count();


        $acceptedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 2); // Check for handyman_status as 0 (Pending)
                });
        })
            ->count();


        $rejectedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 3); // Check for handyman_status as 0 (Pending)
                });
        })
            ->count();


        $inprogressBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 4); // Check for handyman_status as 0 (Pending)
                });
        })
            ->count();



        $completedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 6); // Check for handyman_status as 0 (Pending)
                });
        })
            ->count();


        $cancelledBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 8); // Check for handyman_status as 0 (Pending)
                });
        })
            ->count();


        $holdBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 7); // Check for handyman_status as 0 (Pending)
                });
        })
            ->count();

        // Fetch total service payments filtered by year (sum of payment)
        $servicePayments = DB::table('booking_orders')
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('SUM(payment) as total_payment'))
            ->whereNotNull('service_id')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->pluck('total_payment', 'day');

        $productPayments = DB::table('booking_orders')
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('SUM(payment) as total_payment'))
            ->whereNotNull('product_id')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->pluck('total_payment', 'day');

        // Fetch total service payments count for the selected year
        // Fetch total service payments for the selected year
        $totalServicePayments = DB::table('booking_orders')
            ->whereNotNull('service_id')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('payment');

        // Fetch total product payments for the selected year
        $totalProductPayments = DB::table('booking_orders')
            ->whereNotNull('product_id')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('payment');

        // Calculate the combined total payments (service + product)
        $totalProductAndServicePayments = $totalServicePayments + $totalProductPayments;

        // Initialize data arrays for all months
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $serviceData = [];
        $productData = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $serviceData[] = $servicePayments[$day] ?? 0;
            $productData[] = $productPayments[$day] ?? 0;
        }

        // Format month name
        $monthName = date('F', mktime(
            0,
            0,
            0,
            $month,
            1
        ));



        // Fetch booking records
        $query = $request->input('search');
        $records = OrdersModel::with([
            'user' => function ($query) {
                $query->select(
                    'id',
                    'firstname',
                    'lastname',
                    'email',
                    'profile_pic'
                );
            },
            'provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            },
            'cartItems' => function ($query) {
                $query->select('order_id', 'provider_id')->with([
                    'provider' => function ($providerQuery) {
                        $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                    }
                ]);
            }
        ])
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery->where('firstname', 'like', '%' . $query . '%')
                        ->orWhere('lastname', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)  // Limit to fetch only 5 records
            ->get();

                    // Fetch average review ratings for each provider
        $userIdsDataReview = $records->pluck('user.id')->filter(); // Get all user IDs from fetched orders

$avgUsersReviewsDashboardData = ServiceProof::whereIn('user_id', $userIdsDataReview) // Fix here
    ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
    ->groupBy('user_id')
    ->pluck('avg_star', 'user_id'); // Fetch avg star rating per user


        // Transform the created_at field for the main page view
        $records->transform(function ($record) use ($avgUsersReviewsDashboardData) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

                 // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviewsDashboardData[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });



        $search = $request->input('search');

        $users = User::where('id', '!=', 1) // Exclude user with ID 1
            ->when($search, function ($query, $search) {
                return $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$search}%"])
                ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)  // Limit to fetch only 5 records
            ->get(); // This returns a Collection, not a paginated object

        // Fetch the user IDs in collection
        $userIds = $users->pluck('id');

        // Fetch average reviews for handymen (people_id = 2)
        $avgHandymanReviews = HandymanReview::whereIn('handyman_id', $userIds)
        ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
        ->groupBy('handyman_id')
        ->pluck('avg_star', 'handyman_id');

        // Fetch average reviews for providers (people_id = 1)
        $avgProviderReviewsUser = ServiceReview::whereIn('provider_id', $userIds)
        ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
        ->groupBy('provider_id')
        ->pluck('avg_star', 'provider_id');

        // Fetch average reviews for providers (people_id = 1)
        $avgUsersDataReviews = ServiceProof::whereIn('user_id', $userIds)
        ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
        ->groupBy('user_id')
        ->pluck('avg_star', 'user_id');

        // Use transform directly on $users
        // Format created_at and attach correct review to users
        $users->transform(function ($record) use ($avgHandymanReviews, $avgProviderReviewsUser, $avgUsersDataReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Set correct review value based on people_id
            $record->avg_review = $record->people_id == 1
            ? number_format($avgProviderReviewsUser[$record->id] ?? 0.0, 1)
            : ($record->people_id == 2
            ? number_format($avgHandymanReviews[$record->id] ?? 0.0, 1)
            : ($record->people_id == 3
            ? number_format($avgUsersDataReviews[$record->id] ?? 0.0, 1)
            : '0.0'));

            return $record;
        });


        // Debug to check year and month values
        // dd($year, $month);

        $month = $request->get('month', date('m')); // Default to current month
        $month = sprintf('%02d', $month);  // Ensure the month is zero-padded

        // Get the month name for display
        $monthLabel = date('F', mktime(0, 0, 0, $month, 1));



        // Fetch active users data for the selected month and year
        // Fetch active users data for provider (people_id = 1)
        $activeProviders = DB::table('users')
            ->select(DB::raw('DAY(updated_at) as day'), DB::raw('COUNT(*) as count'))
            ->where('people_id', 1)
            // ->where('is_online', 1)
            ->whereYear('updated_at', $year)
            ->whereMonth('updated_at', $month)
            ->groupBy('day')
            ->pluck('count', 'day');

        // Fetch active users data for handyman (people_id = 2)
        $activeHandymen = DB::table('users')
            ->select(DB::raw('DAY(updated_at) as day'), DB::raw('COUNT(*) as count'))
            ->where('people_id', 2)
            // ->where('is_online', 1)
            ->whereYear('updated_at', $year)
            ->whereMonth('updated_at', $month)
            ->groupBy('day')
            ->pluck('count', 'day');

        // Fetch active users data for normal users (people_id = 3)
        $activeUsers = DB::table('users')
            ->select(DB::raw('DAY(updated_at) as day'), DB::raw('COUNT(*) as count'))
            ->where('people_id', 3)
            // ->where('is_online', 1)
            ->whereYear('updated_at', $year)
            ->whereMonth('updated_at', $month)
            ->groupBy('day')
            ->pluck('count', 'day');

        // Number of days in the selected month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Initialize days and active user data arrays
        $days = [];
        $providerData = [];
        $handymanData = [];
        $activeUserData = [];

        // Loop through each day of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $days[] = "$monthLabel $day"; // Format as "May 1", "May 2", etc.
            $providerData[] = $activeProviders[$day] ?? 0;
            $handymanData[] = $activeHandymen[$day] ?? 0;
            $activeUserData[] = $activeUsers[$day] ?? 0;
        }





        $service_search = $request->input('search');

        $services = Service::with(['category', 'serviceImages', 'vendor' => function ($query) {
            $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
        }])
            ->when($service_search, function ($query, $service_search) {
                $query->where('service_name', 'like', "%{$service_search}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)  // Limit to fetch only 5 records
            ->get();

        // Fetch average review ratings for each provider
        $providerIds = $services->pluck('vendor.id')->filter(); // Get unique provider IDs
        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider

        // Attach avg review ratings to users collection
        $services->transform(function ($record) use ($avgProviderReviews) {
            // Ensure provider exists before assigning avg review
            if ($record->vendor) {
                $record->vendor->avg_provider_review = number_format($avgProviderReviews[$record->vendor->id] ?? 0.0, 1);
            }
            return $record;
        });




        $product_search = $request->input('search');

        $products = Product::with(['category',  'productImages', 'vendor' => function ($query) {
            $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
        }])
            ->when($product_search, function ($query, $product_search) {
                $query->where('product_name', 'like', "%{$product_search}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)  // Limit to fetch only 5 records
            ->get();

            // Fetch average review ratings for each provider
        $providerIdsProduct = $services->pluck('vendor.id')->filter(); // Get unique provider IDs
        $avgProviderReviewsProduct = ServiceReview::whereIn('provider_id', $providerIdsProduct)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider

        // Attach avg review ratings to users collection
        $products->transform(function ($record) use ($avgProviderReviewsProduct) {
            // Ensure provider exists before assigning avg review
            if ($record->vendor) {
                $record->vendor->avg_provider_review = number_format($avgProviderReviewsProduct[$record->vendor->id] ?? 0.0, 1);
            }
            return $record;
        });

        $year = request()->get('year', date('Y')); // Get the selected year from the request, default to current year
        $month = request()->get('month'); // Get the selected month if needed

        // Filter by year and count the services and products
        $totalServicesCount = BookingOrders::whereNotNull('service_id')
            ->whereYear('created_at', $year)
            ->count();

        $totalProductsCount = BookingOrders::whereNotNull('product_id')
            ->whereYear('created_at', $year)
            ->count();

        // Pass the combined data to the view
        return view('admin-dashboard', compact(
            'totalServices',
            'totalProducts',
            'totalAmount',
            'totalBooking',
            'totalServicePayments',
            'totalProductPayments',
            'year',
            'servicePayments',
            'productPayments',
            'totalProductAndServicePayments',
            'records',
            'users',
            'search',
            'activeUserData',
            'services',
            'products',
            'serviceData',
            'productData',
            'monthName',
            'month',
            'days',
            'defaultCurrency',
            'totalprovider',
            'totaluser',
            'pendingBookingCount',
            'acceptedBookingCount',
            'rejectedBookingCount',
            'inprogressBookingCount',
            'completedBookingCount',
            'cancelledBookingCount',
            'holdBookingCount',
            'daysInMonth',
            'totalServicesCount',
            'totalProductsCount',
            'providerData',
            'handymanData',
            'monthLabel',
            'avgUsersReviewsDashboardData',
        ));
    }
}
