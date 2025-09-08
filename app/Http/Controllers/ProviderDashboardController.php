<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\BookingProviderHistory;
use App\Models\Faq;
use App\Models\OrdersModel;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceProof;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProviderDashboardController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the current year or the year from the request
        $year = $request->get('year', date('Y'));

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

        // Fetch total services count for the logged-in provider
        $totalServices = Service::where('v_id', $providerId)->count();

        // Fetch total products count for the logged-in provider
        $totalProducts = Product::where('vid', $providerId)->count();

        // Fetch total amount from the orders table for the logged-in provider
        $totalAmount = BookingOrders::where('provider_id', $providerId)->sum('payment');

        // Fetch total bookings count for the logged-in provider
        $totalBooking = BookingProviderHistory::where('provider_id', $providerId)->count();


        $totalHandyman = User::where('people_id', 2)
            ->where('provider_id', $providerId)
            ->count();

        $totalFaqs = Faq::where('user_id', $providerId)
            ->count();



        $pendingBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) use ($providerId) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 0) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $providerId); // Filter by logged-in provider
                });
        })->count();


        $acceptedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) use ($providerId) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 2) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $providerId); // Filter by logged-in provider
                });
        })->count();


        $rejectedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) use ($providerId) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 3) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $providerId); // Filter by logged-in provider
                });
        })->count();


        $inprogressBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) use ($providerId) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 4) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $providerId); // Filter by logged-in provider
                });
        })->count();


        $completedBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) use ($providerId) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 6) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $providerId); // Filter by logged-in provider
                });
        })->count();


        $cancelledBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) use ($providerId) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 8) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $providerId); // Filter by logged-in provider
                });
        })->count();


        $holdBookingCount = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) use ($providerId) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id')  // Ensure product_id is null in bookingOrder as well
                        ->where('handyman_status', 7) // Check for handyman_status as 0 (Pending)
                        ->where('provider_id', $providerId); // Filter by logged-in provider
                });
        })->count();




        // Fetch total service payments filtered by year (sum of payment)
        // Fetch total service payments filtered by year and provider_id
        $servicePayments = DB::table('booking_orders')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(payment) as total_payment'))
            ->whereNotNull('service_id')
            ->where('provider_id', $providerId)
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total_payment', 'month');

        // Fetch total product payments filtered by year (sum of payment)
        $productPayments = DB::table('booking_orders')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(payment) as total_payment'))
            ->whereNotNull('product_id')
            ->where('provider_id', $providerId)
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total_payment', 'month');

        // Fetch total service payments count for the selected year
        $totalServicePayments = DB::table('booking_orders')
            ->whereNotNull('service_id')
            ->where('provider_id', $providerId)
            ->whereYear('created_at', $year)
            ->sum('payment');

        // Fetch total product payments count for the selected year
        $totalProductPayments = DB::table('booking_orders')
            ->whereNotNull('product_id')
            ->where('provider_id', $providerId)
            ->whereYear('created_at', $year)
            ->sum('payment');

        // Calculate the combined total payments (service + product)
        $totalProductAndServicePayments = $totalServicePayments + $totalProductPayments;

        // Initialize data arrays for all months
        $months = range(1, 12);
        $serviceData = [];
        $productData = [];

        foreach ($months as $month) {
            $serviceData[] = $servicePayments[$month] ?? 0;
            $productData[] = $productPayments[$month] ?? 0;
        }



        // Fetch booking records
        // Fetch booking records
        // Fetch booking records
        $query = $request->input('search');
        $records = OrdersModel::with([
            'user' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
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
        // Filter orders where at least one cart item belongs to the logged-in provider
        ->whereHas('cartItems', function ($query) use ($providerId) {
            $query->where('provider_id', $providerId);
        })
        ->when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->whereHas('user', function ($userQuery) use ($query) {
                $userQuery->where('firstname', 'like', '%' . $query . '%')
                ->orWhere('lastname', 'like', '%' . $query . '%');
            });
        })
        ->orderBy('created_at', 'desc')
        ->limit(7) // Limit to fetch only 5 records
            ->get();

        // Fetch average review ratings for each provider
        $userIdsDataReview = $records->pluck('user.id')->filter(); // Get all user IDs from fetched orders

        $avgUsersReviewsDashboardData = ServiceProof::whereIn('user_id', $userIdsDataReview)
        ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
        ->groupBy('user_id')
        ->pluck('avg_star', 'user_id'); // Fetch avg star rating per user

        // Transform the created_at field for the main page view
        $records->transform(function ($record) use ($avgUsersReviewsDashboardData) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure user exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviewsDashboardData[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });





        $provider_query = $request->input('search');

        $product_provider = OrdersModel::with([
            'user' => function ($provider_query) {
                $provider_query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            },
            'cartItems' => function ($provider_query) {
                $provider_query->select('order_id', 'provider_id', 'cart_id', 'product_id')
                    ->with([
                        'bookingOrder' => function ($bookingQuery) {
                            $bookingQuery->select('cart_id', 'handyman_status', 'provider_id')
                                ->whereNotNull('product_id') // Ensure product_id is present
                                ->whereNull('service_id');   // Ensure service_id is NULL
                        }
                    ]);
            }
        ])
            ->whereHas(
                'cartItems.bookingOrder',
                function ($provider_query) use ($providerId) {
                    $provider_query->whereNotNull('product_id') // Ensure product is present
                        ->whereNull('service_id') // Ensure it's not a service
                        ->where('provider_id', $providerId); // Fetch only for specific provider
                }
            )
            ->when(!empty($provider_query), function ($queryBuilder) use ($provider_query) {
                return $queryBuilder->whereHas('user', function ($userProductQuery) use ($provider_query) {
                    $userProductQuery->where('firstname', 'like', '%' . $provider_query . '%')
                        ->orWhere('lastname', 'like', '%' . $provider_query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Transform the created_at field for formatting
        $product_provider->transform(function ($record) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';
            return $record;
        });













        $year = request()->get('year', date('Y')); // Get the selected year from the request, default to current year
        $month = request()->get('month'); // Get the selected month if needed

        // Filter by year and provider_id, and count the services and products
        $totalServicesCount = BookingOrders::whereNotNull('service_id')
        ->whereYear('created_at', $year)
        ->where('provider_id', $providerId)
        ->count();

        $totalProductsCount = BookingOrders::whereNotNull('product_id')
        ->whereYear('created_at', $year)
        ->where('provider_id', $providerId)
        ->count();







        // Pass the combined data to the view
        return view('provider-dashboard', compact(
            'totalServices',
            'totalProducts',
            'totalAmount',
            'totalBooking',
            'defaultCurrency',
            'serviceData',
            'productData',
            'totalProductAndServicePayments',
            'year',
            'totalServicePayments',
            'totalProductPayments',
            'records',
            'product_provider',
            'pendingBookingCount',
            'acceptedBookingCount',
            'rejectedBookingCount',
            'inprogressBookingCount',
            'completedBookingCount',
            'cancelledBookingCount',
            'holdBookingCount',
            'totalHandyman',
            'totalFaqs',
            'totalServicesCount',
            'totalProductsCount',
            'month',
        ));
    }
}
