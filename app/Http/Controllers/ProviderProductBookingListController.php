<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\SiteSetup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceProof;
use App\Models\OrdersModel;
use Illuminate\Http\Request;

class ProviderProductBookingListController extends Controller
{

    // index
    public function index(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();
        $providerId = $user->id; // Get provider_id of the logged-in provider

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
                ->where('provider_id', $providerId) // Fetch only orders for the logged-in provider
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 9); // Only fetch handyman_status = 9
                });
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query
                        ->whereNotNull('product_id')
                        ->whereNull('service_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 9);
                            },
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic'); // Fetch provider details
                            }
                        ]);
                },
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery
                        ->where('firstname', 'like', '%' . $query . '%')
                        ->orWhere('lastname', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter();
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id');

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('providerinprogress-productbookinglist', compact('records', 'defaultCurrency'));
    }


    // deliveredproviderProductBooking
    public function deliveredproviderProductBooking(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();
        $providerId = $user->id; // Get provider_id of the logged-in provider

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
                $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
                ->where('provider_id', $providerId) // Fetch only orders for the logged-in provider
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 10); // Only fetch handyman_status = 9
                });
            })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query
                        ->whereNotNull('product_id')
                        ->whereNull('service_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 10);
                            },
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic'); // Fetch provider details
                            }
                        ]);
                },
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery
                        ->where('firstname', 'like', '%' . $query . '%')
                        ->orWhere('lastname', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter();
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
        ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
        ->groupBy('user_id')
        ->pluck('avg_star', 'user_id');

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('providerdelivered-productbookinglist', compact('records', 'defaultCurrency'));
    }


    // cancelledproviderProductBooking
    public function cancelledproviderProductBooking(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();
        $providerId = $user->id; // Get provider_id of the logged-in provider

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
                $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
                ->where('provider_id', $providerId) // Fetch only orders for the logged-in provider
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 5); // Only fetch handyman_status = 9
                });
            })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query
                        ->whereNotNull('product_id')
                        ->whereNull('service_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 5);
                            },
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic'); // Fetch provider details
                            }
                        ]);
                },
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery
                        ->where('firstname', 'like', '%' . $query . '%')
                        ->orWhere('lastname', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter();
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
        ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
        ->groupBy('user_id')
        ->pluck('avg_star', 'user_id');

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('providercancelled-productbookinglist', compact('records', 'defaultCurrency'));
    }



    // cancelledbyUserproviderProductBooking
    public function cancelledbyUserproviderProductBooking(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();
        $providerId = $user->id; // Get provider_id of the logged-in provider

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
                $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
                ->where('provider_id', $providerId) // Fetch only orders for the logged-in provider
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 12); // Only fetch handyman_status = 9
                });
            })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query
                        ->whereNotNull('product_id')
                        ->whereNull('service_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 12);
                            },
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic'); // Fetch provider details
                            }
                        ]);
                },
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery
                        ->where('firstname', 'like', '%' . $query . '%')
                        ->orWhere('lastname', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter();
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
        ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
        ->groupBy('user_id')
        ->pluck('avg_star', 'user_id');

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('providercancelledbyuser-productbookinglist', compact('records', 'defaultCurrency'));
    }




    // pendingproviderProductBooking
    public function pendingproviderProductBooking(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();
        $providerId = $user->id; // Get provider_id of the logged-in provider

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
                $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
                ->where('provider_id', $providerId) // Fetch only orders for the logged-in provider
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 0); // Only fetch handyman_status = 9
                });
            })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query
                        ->whereNotNull('product_id')
                        ->whereNull('service_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 0);
                            },
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic'); // Fetch provider details
                            }
                        ]);
                },
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery
                        ->where('firstname', 'like', '%' . $query . '%')
                        ->orWhere('lastname', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter();
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
        ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
        ->groupBy('user_id')
        ->pluck('avg_star', 'user_id');

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('providerpending-productbookinglist', compact('records', 'defaultCurrency'));
    }



    // getProviderProductBookingCounts
    public function getProviderProductBookingCounts()
    {
        // Get the currently authenticated provider
        $user = Auth::guard('admin')->user();
        $providerId = $user->id; // Get provider_id of the logged-in provider

        // Fetch orders where cartItems belong to the logged-in provider
        $counts = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
                ->where('provider_id', $providerId) // Filter by logged-in provider
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery
                        ->whereNotNull('product_id') // Ensure product_id exists in bookingOrder
                        ->whereNull('service_id'); // Ensure service_id is null in bookingOrder
                });
        })
            ->with(['cartItems.bookingOrder']) // Eager load the bookingOrder relationship
            ->get()
            ->reduce(
                function ($carry, $order) {
                    foreach ($order->cartItems as $cartItem) {
                        if ($cartItem->bookingOrder && $cartItem->bookingOrder->product_id) {
                            $status = $cartItem->bookingOrder->handyman_status;
                            // Increment the count for the corresponding handyman_status
                            if (array_key_exists($status, $carry)) {
                                $carry[$status]++;
                            }
                        }
                    }
                    return $carry;
                },
                [
                    9 => 0,  // In Progress
                    10 => 0, // Completed
                    5 => 0,  // Cancelled
                    0 => 0,  // Pending
                    12 => 0, // Cancelled by User
                ],
            );

        // Return the count in JSON format
        return response()->json([
            'inprogress' => $counts[9],
            'completed' => $counts[10],
            'cancelled' => $counts[5],
            'pending' => $counts[0],
            'cancelledbyuser' => $counts[12],
        ]);
    }

}
