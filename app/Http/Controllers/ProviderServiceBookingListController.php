<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\CartItemsModel;
use App\Models\OrdersModel;
use App\Models\ServiceProof;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProviderServiceBookingListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

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
                'cartItems' => function ($query) use ($providerId) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) use ($providerId) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 0)
                                    ->where('provider_id', $providerId); // Ensure provider_id matches logged-in provider
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->whereHas('cartItems.bookingOrder', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider


        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('providerpending-bookinglist', compact('records', 'defaultCurrency'));
    }


    // provideracceptedBookingList
    public function provideracceptedBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

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
                'cartItems' => function ($query) use ($providerId) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) use ($providerId) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 2)
                                    ->where('provider_id', $providerId); // Ensure provider_id matches logged-in provider
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->whereHas('cartItems.bookingOrder', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider


        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('provideraccepted-bookinglist', compact('records', 'defaultCurrency'));
    }


    // providerrejectedBookingList
    public function providerrejectedBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

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
                'cartItems' => function ($query) use ($providerId) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) use ($providerId) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 3)
                                    ->where('provider_id', $providerId); // Ensure provider_id matches logged-in provider
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->whereHas('cartItems.bookingOrder', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider


        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('providerrejected-bookinglist', compact('records', 'defaultCurrency'));
    }


    // providerinprogressBookingList
    public function providerinprogressBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

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
                'cartItems' => function ($query) use ($providerId) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) use ($providerId) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 4)
                                    ->where('provider_id', $providerId); // Ensure provider_id matches logged-in provider
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->whereHas('cartItems.bookingOrder', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider


        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('providerinprogress-bookinglist', compact('records', 'defaultCurrency'));
    }


    // providercompletedBookingList
    public function providercompletedBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

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
                'cartItems' => function ($query) use ($providerId) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) use ($providerId) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 6)
                                    ->where('provider_id', $providerId); // Ensure provider_id matches logged-in provider
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->whereHas('cartItems.bookingOrder', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider


        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('providercompleted-bookinglist', compact('records', 'defaultCurrency'));
    }


    // providercancelledBookingList
    public function providercancelledBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

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
                'cartItems' => function ($query) use ($providerId) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) use ($providerId) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 8)
                                    ->where('provider_id', $providerId); // Ensure provider_id matches logged-in provider
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->whereHas('cartItems.bookingOrder', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider


        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('providercancelled-bookinglist', compact('records', 'defaultCurrency'));
    }


    // providerholdBookingList
    public function providerholdBookingList(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

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
                'cartItems' => function ($query) use ($providerId) {
                    $query->whereNotNull('service_id')
                        ->whereNull('product_id')
                        ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                        ->with([
                            'provider' => function ($providerQuery) {
                                $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                            },
                            'bookingOrder' => function ($bookingQuery) use ($providerId) {
                                $bookingQuery->select('cart_id', 'handyman_status')
                                    ->where('handyman_status', 7)
                                    ->where('provider_id', $providerId); // Ensure provider_id matches logged-in provider
                            },
                            'service' => function ($serviceQuery) {
                                $serviceQuery->select('id', 'service_name'); // Fetch service_name
                            }
                        ]);
                }
            ])
            ->whereHas('cartItems.bookingOrder', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
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
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider


        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('providerhold-bookinglist', compact('records', 'defaultCurrency'));
    }


    // getproviderBookingCounts
    public function getproviderBookingCounts()
    {
        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Get provider_id of the logged-in provider
        $providerId = $user->id;

        // Fetch orders where cartItems have service_id and relate to bookingOrders with handyman_status
        $counts = OrdersModel::whereHas('cartItems', function ($cartQuery) use ($providerId) {
            $cartQuery->whereNotNull('service_id')  // Ensure service_id exists
                ->whereNull('product_id')  // Ensure product_id is null
                ->where('provider_id', $providerId) // Filter by logged-in provider
                ->whereHas('bookingOrder', function ($bookingQuery) {
                    $bookingQuery->whereNotNull('service_id')  // Ensure service_id exists in bookingOrder
                        ->whereNull('product_id');  // Ensure product_id is null in bookingOrder
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
