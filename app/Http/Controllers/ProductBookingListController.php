<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\SiteSetup;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceProof;
use App\Models\OrdersModel;
use Illuminate\Http\Request;

class ProductBookingListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
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
                        ->whereNotNull('product_id') // Ensure product_id is not null
                        ->whereNull('service_id') // Ensure service_id is null
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 9); // Only fetch handyman_status = 9
                            },
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')->groupBy('user_id')->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id ? route('user-view', $record->user->id) : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('inprogress-productbookinglist', compact('records', 'defaultCurrency'));
    }

    // allProductBookingList
    public function allProductBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('product_id')->whereNull('service_id');
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query->whereNotNull('product_id')->whereNull('service_id')->select('order_id', 'provider_id', 'cart_id', 'product_id');
                },
            ])
            ->withCount([
                'cartItems as total_product_count' => function ($query) {
                    $query->whereNotNull('product_id')->whereNull('service_id');
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

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency) {
                $cartItem = $record->cartItems->first();
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'total_product_count' => $record->total_product_count, // Add total_product_count here
                    'edit_url' => route('booking-view', $record->id),
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id ? route('user-view', $record->user->id) : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        $records->getCollection()->transform(function ($record) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';
            return $record;
        });

        return view('all-productbookinglist', compact('records', 'defaultCurrency'));
    }

    // deleteProductBooking
    public function deleteProductBooking($id)
    {
        $data = BookingOrders::where('id', $id)->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }

    // deliveredProductBooking
    public function deliveredProductBooking(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
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
                        ->whereNotNull('product_id') // Ensure product_id is not null
                        ->whereNull('service_id') // Ensure service_id is null
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 10); // Only fetch handyman_status = 9
                            },
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')->groupBy('user_id')->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id ? route('user-view', $record->user->id) : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('delivered-productbookinglist', compact('records', 'defaultCurrency'));
    }

    // cancelledProductBooking
    public function cancelledProductBooking(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
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
                        ->whereNotNull('product_id') // Ensure product_id is not null
                        ->whereNull('service_id') // Ensure service_id is null
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 5); // Only fetch handyman_status = 9
                            },
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')->groupBy('user_id')->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id ? route('user-view', $record->user->id) : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('cancelled-productbookinglist', compact('records', 'defaultCurrency'));
    }

    // pendingProductBooking
    public function pendingProductBooking(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
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
                        ->whereNotNull('product_id') // Ensure product_id is not null
                        ->whereNull('service_id') // Ensure service_id is null
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 0); // Only fetch handyman_status = 9
                            },
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')->groupBy('user_id')->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id ? route('user-view', $record->user->id) : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

         $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('pending-productbookinglist', compact('records', 'defaultCurrency'));
    }

    // cancelledbyUserProductBooking
    public function cancelledbyUserProductBooking(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery
                ->whereNotNull('product_id') // Ensure product_id is not null
                ->whereNull('service_id') // Ensure service_id is null
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
                        ->whereNotNull('product_id') // Ensure product_id is not null
                        ->whereNull('service_id') // Ensure service_id is null
                        ->select('order_id', 'provider_id', 'cart_id', 'product_id')
                        ->with([
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')->where('handyman_status', 12); // Only fetch handyman_status = 9
                            },
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')->groupBy('user_id')->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id ? route('user-view', $record->user->id) : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at ? $record->created_at->format('d M, Y / g:i A') : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('cancelledbyuser-productbookinglist', compact('records', 'defaultCurrency'));
    }

    public function getProductBookingCounts()
    {
        // Fetch orders where cartItems have service_id and relate to bookingOrders with handyman_status
        $counts = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery
                ->whereNotNull('product_id') // Ensure service_id exists
                ->whereNull('service_id') // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery
                        ->whereNotNull('product_id') // Ensure service_id exists in bookingOrder
                        ->whereNull('service_id'); // Ensure product_id is null in bookingOrder as well
                }); // Ensure there is a related bookingOrder with service_id
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
                    9 => 0, // Pending
                    10 => 0, // Accepted
                    5 => 0, // Rejected
                    0 => 0, // Rejected
                    12 => 0, // Rejected
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
