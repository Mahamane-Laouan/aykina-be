<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\CartItemsModel;
use App\Models\OrdersModel;
use App\Models\Product;
use App\Models\ServiceProof;
use App\Models\ServiceReview;
use App\Models\Service;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ServiceBookingListController extends Controller
{

    // index
    public function index(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')
                ->whereNull('product_id') // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 0); // Only fetch handyman_status = 0
                });
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'provider' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 0); // Only fetch handyman_status = 0
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('cartItems', function ($cartQuery) use ($query) {
                    $cartQuery->whereHas('service', function ($serviceQuery) use ($query) {
                        $serviceQuery->where('service_name', 'like', '%' . $query . '%');
                    })
                        ->orWhereHas('provider', function ($providerQuery) use ($query) {
                            $providerQuery->where('firstname', 'like', '%' . $query . '%')
                                ->orWhere('lastname', 'like', '%' . $query . '%');
                        });
                });
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Fetch average review ratings for each provider
        $providerIds = $records->flatMap(function ($record) {
            return [
                $record->provider?->id,
                $record->cartItems->first()?->provider?->id
            ];
        })->filter();



        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider


        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $providerFromCart = $cartItem->provider ?? null;
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;
                $serviceName = $cartItem->service->service_name ?? '';
                $serviceUrl = $cartItem->service && $cartItem->service->id
                    ? route('service-edit', $cartItem->service->id)
                    : null;
                $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider
                $providerId = $actualProvider?->id;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'service_name' => $serviceName, // Include service_name
                    'service_url' => $serviceUrl, // Ensure the service_url is set properly
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id
                            ? route('user-view', $record->user->id)
                            : null,
                    ],
                    'provider' => [
                        'firstname' => $providerFromCart->firstname ?? '',
                        'lastname' => $providerFromCart->lastname ?? '',
                        'email' => $providerFromCart->email ?? '',
                        'avg_provider_review' => number_format($avgProviderReviews[$providerId] ?? 0.0, 1), // Ensure correct review fetch
                        'profile_pic' => $providerFromCart && $providerFromCart->profile_pic ? asset('images/user/' . $providerFromCart->profile_pic) : '',
                        'profile_url' => $providerFromCart && $providerFromCart->id
                            ? route('provider-view', $providerFromCart->id)
                            : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Ensure correct provider's avg review is assigned before sending to the view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews, $avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            $providerFromCart = $record->cartItems->first()->provider ?? null;
            $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider

            if ($actualProvider) {
                $actualProvider->avg_provider_review = number_format($avgProviderReviews[$actualProvider->id] ?? 0.0, 1);
            }

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('pending-bookinglist', compact('records', 'defaultCurrency'));
    }


    // deleteServiceBooking
    public function deleteServiceBooking($id)
    {
        $data = BookingOrders::where('id', $id)->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }


    // acceptedBookingList
    public function acceptedBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')
                ->whereNull('product_id') // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 2); // Only fetch handyman_status = 0
                });
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'provider' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 2); // Only fetch handyman_status = 0
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('cartItems', function ($cartQuery) use ($query) {
                    $cartQuery->whereHas('service', function ($serviceQuery) use ($query) {
                        $serviceQuery->where('service_name', 'like', '%' . $query . '%');
                    })
                        ->orWhereHas('provider', function ($providerQuery) use ($query) {
                            $providerQuery->where('firstname', 'like', '%' . $query . '%')
                                ->orWhere('lastname', 'like', '%' . $query . '%');
                        });
                });
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $providerIds = $records->flatMap(function ($record) {
            return [
                $record->provider?->id,
                $record->cartItems->first()?->provider?->id
            ];
        })->filter();



        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider


        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $providerFromCart = $cartItem->provider ?? null;
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;
                $serviceName = $cartItem->service->service_name ?? '';
                $serviceUrl = $cartItem->service && $cartItem->service->id
                    ? route('service-edit', $cartItem->service->id)
                    : null;

                $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider
                $providerId = $actualProvider?->id;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'service_name' => $serviceName, // Include service_name
                    'service_url' => $serviceUrl, // Ensure the service_url is set properly
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_url' => $record->user && $record->user->id
                            ? route('user-view', $record->user->id)
                            : null,
                    ],
                    'provider' => [
                        'firstname' => $providerFromCart->firstname ?? '',
                        'lastname' => $providerFromCart->lastname ?? '',
                        'email' => $providerFromCart->email ?? '',
                        'avg_provider_review' => number_format($avgProviderReviews[$providerId] ?? 0.0, 1), // Ensure correct review fetch
                        'profile_pic' => $providerFromCart && $providerFromCart->profile_pic ? asset('images/user/' . $providerFromCart->profile_pic) : '',
                        'profile_url' => $providerFromCart && $providerFromCart->id
                            ? route('provider-view', $providerFromCart->id)
                            : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Ensure correct provider's avg review is assigned before sending to the view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews, $avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            $providerFromCart = $record->cartItems->first()->provider ?? null;
            $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider

            if ($actualProvider) {
                $actualProvider->avg_provider_review = number_format($avgProviderReviews[$actualProvider->id] ?? 0.0, 1);
            }

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('accepted-bookinglist', compact('records', 'defaultCurrency'));
    }


    // rejectedBookingList
    public function rejectedBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')
                ->whereNull('product_id') // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 3); // Only fetch handyman_status = 0
                });
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'provider' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 3); // Only fetch handyman_status = 0
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('cartItems', function ($cartQuery) use ($query) {
                    $cartQuery->whereHas('service', function ($serviceQuery) use ($query) {
                        $serviceQuery->where('service_name', 'like', '%' . $query . '%');
                    })
                        ->orWhereHas('provider', function ($providerQuery) use ($query) {
                            $providerQuery->where('firstname', 'like', '%' . $query . '%')
                                ->orWhere('lastname', 'like', '%' . $query . '%');
                        });
                });
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Fetch average review ratings for each provider
        $providerIds = $records->flatMap(function ($record) {
            return [
                $record->provider?->id,
                $record->cartItems->first()?->provider?->id
            ];
        })->filter();



        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider


        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $providerFromCart = $cartItem->provider ?? null;
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;
                $serviceName = $cartItem->service->service_name ?? '';
                $serviceUrl = $cartItem->service && $cartItem->service->id
                    ? route('service-edit', $cartItem->service->id)
                    : null;

                $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider
                $providerId = $actualProvider?->id;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'service_name' => $serviceName, // Include service_name
                    'service_url' => $serviceUrl, // Ensure the service_url is set properly
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_url' => $record->user && $record->user->id
                            ? route('user-view', $record->user->id)
                            : null,
                    ],
                    'provider' => [
                        'firstname' => $providerFromCart->firstname ?? '',
                        'lastname' => $providerFromCart->lastname ?? '',
                        'email' => $providerFromCart->email ?? '',
                        'profile_pic' => $providerFromCart && $providerFromCart->profile_pic ? asset('images/user/' . $providerFromCart->profile_pic) : '',
                        'avg_provider_review' => number_format($avgProviderReviews[$providerId] ?? 0.0, 1), // Ensure correct review fetch
                        'profile_url' => $providerFromCart && $providerFromCart->id
                            ? route('provider-view', $providerFromCart->id)
                            : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Ensure correct provider's avg review is assigned before sending to the view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews, $avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            $providerFromCart = $record->cartItems->first()->provider ?? null;
            $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider

            if ($actualProvider) {
                $actualProvider->avg_provider_review = number_format($avgProviderReviews[$actualProvider->id] ?? 0.0, 1);
            }

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('rejected-bookinglist', compact('records', 'defaultCurrency'));
    }



    // inprogressBookingList
    public function inprogressBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')
                ->whereNull('product_id') // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 4); // Only fetch handyman_status = 0
                });
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'provider' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 4); // Only fetch handyman_status = 0
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('cartItems', function ($cartQuery) use ($query) {
                    $cartQuery->whereHas('service', function ($serviceQuery) use ($query) {
                        $serviceQuery->where('service_name', 'like', '%' . $query . '%');
                    })
                        ->orWhereHas('provider', function ($providerQuery) use ($query) {
                            $providerQuery->where('firstname', 'like', '%' . $query . '%')
                                ->orWhere('lastname', 'like', '%' . $query . '%');
                        });
                });
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Fetch average review ratings for each provider
        $providerIds = $records->flatMap(function ($record) {
            return [
                $record->provider?->id,
                $record->cartItems->first()?->provider?->id
            ];
        })->filter();



        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider


        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $providerFromCart = $cartItem->provider ?? null;
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;
                $serviceName = $cartItem->service->service_name ?? '';
                $serviceUrl = $cartItem->service && $cartItem->service->id
                    ? route('service-edit', $cartItem->service->id)
                    : null;


                $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider
                $providerId = $actualProvider?->id;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'service_name' => $serviceName, // Include service_name
                    'service_url' => $serviceUrl, // Ensure the service_url is set properly
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id
                            ? route('user-view', $record->user->id)
                            : null,
                    ],
                    'provider' => [
                        'firstname' => $providerFromCart->firstname ?? '',
                        'lastname' => $providerFromCart->lastname ?? '',
                        'email' => $providerFromCart->email ?? '',
                        'avg_provider_review' => number_format($avgProviderReviews[$providerId] ?? 0.0, 1), // Ensure correct review fetch
                        'profile_pic' => $providerFromCart && $providerFromCart->profile_pic ? asset('images/user/' . $providerFromCart->profile_pic) : '',
                        'profile_url' => $providerFromCart && $providerFromCart->id
                            ? route('provider-view', $providerFromCart->id)
                            : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Ensure correct provider's avg review is assigned before sending to the view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews, $avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            $providerFromCart = $record->cartItems->first()->provider ?? null;
            $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider

            if ($actualProvider) {
                $actualProvider->avg_provider_review = number_format($avgProviderReviews[$actualProvider->id] ?? 0.0, 1);
            }

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('inprogress-bookinglist', compact('records', 'defaultCurrency'));
    }


    // completedBookingList
    public function completedBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')
                ->whereNull('product_id') // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 6); // Only fetch handyman_status = 0
                });
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'provider' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 6); // Only fetch handyman_status = 0
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('cartItems', function ($cartQuery) use ($query) {
                    $cartQuery->whereHas('service', function ($serviceQuery) use ($query) {
                        $serviceQuery->where('service_name', 'like', '%' . $query . '%');
                    })
                        ->orWhereHas('provider', function ($providerQuery) use ($query) {
                            $providerQuery->where('firstname', 'like', '%' . $query . '%')
                                ->orWhere('lastname', 'like', '%' . $query . '%');
                        });
                });
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Fetch average review ratings for each provider
        $providerIds = $records->flatMap(function ($record) {
            return [
                $record->provider?->id,
                $record->cartItems->first()?->provider?->id
            ];
        })->filter();


        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider


        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider


        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $providerFromCart = $cartItem->provider ?? null;
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;
                $serviceName = $cartItem->service->service_name ?? '';
                $serviceUrl = $cartItem->service && $cartItem->service->id
                    ? route('service-edit', $cartItem->service->id)
                    : null;

                $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider
                $providerId = $actualProvider?->id;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'service_name' => $serviceName, // Include service_name
                    'service_url' => $serviceUrl, // Ensure the service_url is set properly
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_url' => $record->user && $record->user->id
                            ? route('user-view', $record->user->id)
                            : null,
                    ],
                    'provider' => [
                        'firstname' => $providerFromCart->firstname ?? '',
                        'lastname' => $providerFromCart->lastname ?? '',
                        'email' => $providerFromCart->email ?? '',
                        'profile_pic' => $providerFromCart && $providerFromCart->profile_pic ? asset('images/user/' . $providerFromCart->profile_pic) : '',
                        'avg_provider_review' => number_format($avgProviderReviews[$providerId] ?? 0.0, 1), // Ensure correct review fetch
                        'profile_url' => $providerFromCart && $providerFromCart->id
                            ? route('provider-view', $providerFromCart->id)
                            : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Ensure correct provider's avg review is assigned before sending to the view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews, $avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            $providerFromCart = $record->cartItems->first()->provider ?? null;
            $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider

            if ($actualProvider) {
                $actualProvider->avg_provider_review = number_format($avgProviderReviews[$actualProvider->id] ?? 0.0, 1);
            }

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('completed-bookinglist', compact('records', 'defaultCurrency'));
    }


    // cancelledBookingList
    public function cancelledBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')
                ->whereNull('product_id') // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 8); // Only fetch handyman_status = 0
                });
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'provider' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 8); // Only fetch handyman_status = 0
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('cartItems', function ($cartQuery) use ($query) {
                    $cartQuery->whereHas('service', function ($serviceQuery) use ($query) {
                        $serviceQuery->where('service_name', 'like', '%' . $query . '%');
                    })
                        ->orWhereHas('provider', function ($providerQuery) use ($query) {
                            $providerQuery->where('firstname', 'like', '%' . $query . '%')
                                ->orWhere('lastname', 'like', '%' . $query . '%');
                        });
                });
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Fetch average review ratings for each provider
        $providerIds = $records->flatMap(function ($record) {
            return [
                $record->provider?->id,
                $record->cartItems->first()?->provider?->id
            ];
        })->filter();


        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider


        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $providerFromCart = $cartItem->provider ?? null;
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;
                $serviceName = $cartItem->service->service_name ?? '';
                $serviceUrl = $cartItem->service && $cartItem->service->id
                    ? route('service-edit', $cartItem->service->id)
                    : null;

                $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider
                $providerId = $actualProvider?->id;


                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'service_name' => $serviceName, // Include service_name
                    'service_url' => $serviceUrl, // Ensure the service_url is set properly
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_url' => $record->user && $record->user->id
                            ? route('user-view', $record->user->id)
                            : null,
                    ],
                    'provider' => [
                        'firstname' => $providerFromCart->firstname ?? '',
                        'lastname' => $providerFromCart->lastname ?? '',
                        'email' => $providerFromCart->email ?? '',
                        'profile_pic' => $providerFromCart && $providerFromCart->profile_pic ? asset('images/user/' . $providerFromCart->profile_pic) : '',
                        'avg_provider_review' => number_format($avgProviderReviews[$providerId] ?? 0.0, 1), // Ensure correct review fetch
                        'profile_url' => $providerFromCart && $providerFromCart->id
                            ? route('provider-view', $providerFromCart->id)
                            : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Ensure correct provider's avg review is assigned before sending to the view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews, $avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            $providerFromCart = $record->cartItems->first()->provider ?? null;
            $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider

            if ($actualProvider) {
                $actualProvider->avg_provider_review = number_format($avgProviderReviews[$actualProvider->id] ?? 0.0, 1);
            }

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });


        return view('cancelled-bookinglist', compact('records', 'defaultCurrency'));
    }


    // holdBookingList
    public function holdBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')
                ->whereNull('product_id') // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->where('handyman_status', 7); // Only fetch handyman_status = 0
                });
        })
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'provider' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 7); // Only fetch handyman_status = 0
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('cartItems', function ($cartQuery) use ($query) {
                    $cartQuery->whereHas('service', function ($serviceQuery) use ($query) {
                        $serviceQuery->where('service_name', 'like', '%' . $query . '%');
                    })
                        ->orWhereHas('provider', function ($providerQuery) use ($query) {
                            $providerQuery->where('firstname', 'like', '%' . $query . '%')
                                ->orWhere('lastname', 'like', '%' . $query . '%');
                        });
                });
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Fetch average review ratings for each provider
        $providerIds = $records->flatMap(function ($record) {
            return [
                $record->provider?->id,
                $record->cartItems->first()?->provider?->id
            ];
        })->filter();


        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider


        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews, $avgUsersReviews) {
                $cartItem = $record->cartItems->first();
                $providerFromCart = $cartItem->provider ?? null;
                $handymanStatus = $cartItem->bookingOrder->handyman_status ?? null;
                $serviceName = $cartItem->service->service_name ?? '';
                $serviceUrl = $cartItem->service && $cartItem->service->id
                    ? route('service-edit', $cartItem->service->id)
                    : null;

                $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider
                $providerId = $actualProvider?->id;

                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'handyman_status' => $handymanStatus,
                    'total' => $record->total,
                    'edit_url' => route('booking-view', $record->id),
                    'service_name' => $serviceName, // Include service_name
                    'service_url' => $serviceUrl, // Ensure the service_url is set properly
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_url' => $record->user && $record->user->id
                            ? route('user-view', $record->user->id)
                            : null,
                    ],
                    'provider' => [
                        'firstname' => $providerFromCart->firstname ?? '',
                        'lastname' => $providerFromCart->lastname ?? '',
                        'email' => $providerFromCart->email ?? '',
                        'profile_pic' => $providerFromCart && $providerFromCart->profile_pic ? asset('images/user/' . $providerFromCart->profile_pic) : '',
                        'avg_provider_review' => number_format($avgProviderReviews[$providerId] ?? 0.0, 1), // Ensure correct review fetch
                        'profile_url' => $providerFromCart && $providerFromCart->id
                            ? route('provider-view', $providerFromCart->id)
                            : null,
                    ],
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Ensure correct provider's avg review is assigned before sending to the view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews, $avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            $providerFromCart = $record->cartItems->first()->provider ?? null;
            $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider

            if ($actualProvider) {
                $actualProvider->avg_provider_review = number_format($avgProviderReviews[$actualProvider->id] ?? 0.0, 1);
            }

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }

            return $record;
        });

        return view('hold-bookinglist', compact('records', 'defaultCurrency'));
    }


    // getBookingCounts
    public function getBookingCounts()
    {
        // Fetch orders where cartItems have service_id and relate to bookingOrders with handyman_status
        $counts = OrdersModel::whereHas('cartItems', function ($cartQuery) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id');  // Ensure product_id is null in bookingOrder as well
                }); // Ensure there is a related bookingOrder with service_id
        })
            ->with(['cartItems.bookingOrder'])  // Eager load the bookingOrder relationship
            ->get()
            ->reduce(function ($carry, $order) {
                foreach ($order->cartItems as $cartItem) {
                    if ($cartItem->bookingOrder && $cartItem->bookingOrder->service_id) {
                        $status = $cartItem->bookingOrder->handyman_status;
                        // Increment the count for the corresponding handyman_status
                        if (array_key_exists($status, $carry)) {
                            $carry[$status]++;
                        }
                    }
                }
                return $carry;
            }, [
                0 => 0, // Pending
                2 => 0, // Accepted
                3 => 0, // Rejected
                4 => 0, // In Progress
                6 => 0, // Completed
                8 => 0, // Cancelled
                7 => 0, // Hold
            ]);

        // Return the count in JSON format
        return response()->json([
            'pending' => $counts[0],
            'accepted' => $counts[2],
            'rejected' => $counts[3],
            'inprogress' => $counts[4],
            'completed' => $counts[6],
            'cancelled' => $counts[8],
            'hold' => $counts[7],
        ]);
    }
}
