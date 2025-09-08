<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\BookingOrdersStatus;
use App\Models\CartItemsModel;
use App\Models\NotificationsPermissions;
use App\Models\OrdersModel;
use App\Models\ServiceProof;
use App\Models\ServiceReview;
use App\Models\HandymanReview;
use App\Models\UserAddressModel;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteSetup;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Request;

class BookingListController extends BaseController
{

    // index
    public function index(Request $request)
    {
        $query = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::with([
            'user' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            },
            'provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            },
            'cartItems' => function ($query) {
                $query->whereNotNull('service_id')
                    ->whereNull('product_id') // Filter condition added
                    ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                    ->with([
                        'provider' => function ($providerQuery) {
                            $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                        },
                        'bookingOrder' => function ($bookingQuery) {
                            $bookingQuery->select('cart_id', 'handyman_status') // Fetch handyman_status
                                ->whereNotNull('service_id')  // Filter for service_id
                                ->whereNull('product_id');    // Filter for product_id
                        }
                    ]);
            }
        ])
            ->when(
                $query,
                function ($queryBuilder) use ($query) {
                    return $queryBuilder->whereHas('user', function ($userQuery) use ($query) {
                        $userQuery->where('firstname', 'like', '%' . $query . '%')
                            ->orWhere('lastname', 'like', '%' . $query . '%');
                    });
                }
            )
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
                $providerFromCart = $record->cartItems->first()->provider ?? null;
                $handymanStatus = $record->cartItems->first()->bookingOrder->handyman_status ?? null;
                $actualProvider = $providerFromCart ?? $record->provider; // Ensure correct provider
                $providerId = $actualProvider?->id;

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


        return view('booking-list', compact('records', 'defaultCurrency'));
    }


    // deleteBooking
    public function deleteBooking($id)
    {
        $data = OrdersModel::where('id', $id)->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }


    // viewBooking
    public function viewBooking($id)
    {
        // Fetch order data with related cart items
        $data = OrdersModel::with([
            'cartItems.userAddress',
            'cartItems.provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
            }
        ])->find($id);

        if (!$data) {
            return abort(404, 'Order not found');
        }

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Initializ
        $bookingOrders = [];

        // Process each cart item
        foreach ($data->cartItems as $cartItem) {
            // Fetch booking order data using cart_id
            $bookingOrder = BookingOrders::where('cart_id', $cartItem->cart_id)->first();
            if ($bookingOrder) {
                $cartItem->booking_id = $bookingOrder->id;
                $cartItem->service_id = $bookingOrder->service_id;
                $cartItem->product_id = $bookingOrder->product_id;
                $cartItem->handymanStatus = $bookingOrder->handyman_status;
                $cartItem->payment = $bookingOrder->payment;
                $cartItem->quantity = $cartItem->quantity ?? 1; // Default to 1 if not found


                // Fetch service or product details
                if ($cartItem->service_id) {
                    $cartItem->serviceDetails = Service::find($cartItem->service_id);
                    $cartItem->price = $cartItem->serviceDetails->service_discount_price ?? $cartItem->serviceDetails->service_price;
                    $cartItem->type = 'Service';
                } elseif ($cartItem->product_id) {
                    $cartItem->productDetails = Product::find($cartItem->product_id);
                    $cartItem->price = $cartItem->productDetails->product_discount_price ?? $cartItem->productDetails->product_price;
                    $cartItem->type = 'Product';
                }

                $bookingOrders[] = $bookingOrder;
            }
        }



        // Return the view with all relevant data
        return view('booking-view', compact('data',  'defaultCurrency', 'bookingOrders'));
    }







    // public function innerbookingView($id)
    // {
    //     // Fetch booking data with related cart items and user details
    //     $data = BookingOrders::with([
    //         'cartItems.userAddress',
    //         'cartItems.product',
    //         'cartItems.service',
    //         'user' => function ($query) {
    //             $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
    //         },
    //         'cartItems.provider' => function ($query) {
    //             $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
    //         }
    //     ])->find($id);

    //     if (!$data) {
    //         return abort(404, 'Order not found');
    //     }

    //     // Fetch the default currency from SiteSetup
    //     $defaultCurrency = SiteSetup::first()->default_currency;

    //     // Fetch all unique provider_ids from cartItems related to the order
    //     $providerIds = $data->cartItems->pluck('provider_id')->unique();

    //     // Fetch the first provider from the cart items, if it exists
    //     $firstProvider = null;
    //     foreach ($data->cartItems as $cartItem) {
    //         if ($cartItem->provider) {
    //             $firstProvider = $cartItem->provider;
    //             break;
    //         }
    //     }


    //     $handymen = User::whereIn('provider_id', $providerIds)
    //         ->select('id', 'firstname', 'lastname')
    //         ->get();

    //     // Fetch assigned handyman if exists
    //     $assignedHandyman = null;
    //     $bookingOrder = null;
    //     foreach ($data->cartItems as $cartItem) {
    //         $bookingOrder = BookingOrders::where('cart_id', $cartItem->cart_id)->first();
    //         if ($bookingOrder && $bookingOrder->work_assign_id) {
    //             $assignedHandyman = User::find($bookingOrder->work_assign_id);
    //             break;
    //         }
    //     }

    //     // Process the cart items (fetch product or service details)
    //     foreach ($data->cartItems as $cartItem) {
    //         if ($cartItem->product_id) {
    //             $cartItem->productDetails = Product::find($cartItem->product_id);
    //             $cartItem->price = $cartItem->productDetails->product_discount_price ?? $cartItem->productDetails->product_price;
    //             $cartItem->type = 'Product';
    //         } elseif ($cartItem->service_id) {
    //             $cartItem->serviceDetails = Service::find($cartItem->service_id);
    //             $cartItem->price = $cartItem->serviceDetails->service_discount_price ?? $cartItem->serviceDetails->service_price;
    //             $cartItem->type = 'Service';
    //         }

    //         // Fetch the handyman status for each cart item
    //         $bookingOrderData = BookingOrders::where('cart_id', $cartItem->cart_id)->first();
    //         if ($bookingOrderData) {
    //             $cartItem->handymanStatus = $bookingOrderData->handyman_status;
    //         }
    //     }

    //     // Ensure $bookingOrder is set before accessing its properties
    //     $bookingId = $bookingOrder ? $bookingOrder->id : null;

    //     // dd($bookingId);

    //     // Call the API to fetch booking status history
    //     $apiUrl = 'http://145.223.23.5/api/admin_booking_status_history';
    //     $client = new \GuzzleHttp\Client();
    //     $response = $client->post($apiUrl, [
    //         'json' => [
    //             'provider_id' => $firstProvider->id ?? null,
    //             'booking_id' => $bookingId,
    //         ]
    //     ]);

    //     $statusHistory = json_decode($response->getBody()->getContents(), true);

    //     // Check if the API call was successful
    //     $allStatus = $statusHistory['response_code'] == "1" ? $statusHistory['all_status'] : [];

    //     // Return the view with the booking data, handymen users, first provider, assigned handyman, and status history
    //     return view('innerbooking-view', compact('data', 'handymen', 'firstProvider', 'assignedHandyman', 'allStatus', 'defaultCurrency'));
    // }









    // public function innerbookingView($id)
    // {
    //     // Fetch booking data based on the main booking order ID
    //     $data = BookingOrders::with([
    //         'user' => function ($query) {
    //             $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
    //         },
    //         'provider' => function ($query) {
    //             $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
    //         }
    //     ])->find($id);

    //     if (!$data) {
    //         return abort(404, 'Order not found');
    //     }

    //     // Fetch the default currency from SiteSetup
    //     $defaultCurrency = SiteSetup::first()->default_currency;

    //     // Fetch the provider_ids from the booking order
    //     $providerIds = $data->pluck('provider_id')->unique();

    //     // Fetch the first provider (associated with the booking order, not from cart items)
    //     $firstProvider = $data->provider;

    //     // Fetch handymen
    //     $handymen = User::whereIn('provider_id', $providerIds)
    //     ->select('id', 'firstname', 'lastname')
    //     ->get();

    //     // Fetch assigned handyman if exists
    //     $assignedHandyman = null;
    //     $bookingOrder = BookingOrders::where('id', $id)->first();
    //     if ($bookingOrder && $bookingOrder->work_assign_id) {
    //         $assignedHandyman = User::find($bookingOrder->work_assign_id);
    //     }

    //     // Fetch user_id from the booking_orders table
    //     $userId = $data->user_id;

    //     // Fetch the user's address from userAddress table
    //     $userAddress = UserAddressModel::where('user_id', $userId)->first();

    //     // Process the cart items (fetch product or service details)
    //     foreach ($data->cartItems as $cartItem) { // Use cartItems relation if defined in your model
    //         // Fetch the correct product or service details directly from BookingOrders
    //         if ($bookingOrder) {
    //             if ($cartItem->product_id) {
    //                 $cartItem->productDetails = Product::find($bookingOrder->product_id); // Use product_id from BookingOrders
    //                 $cartItem->price = $cartItem->productDetails->product_discount_price ?? $cartItem->productDetails->product_price;
    //                 $cartItem->type = 'Product';
    //             } elseif ($cartItem->service_id) {
    //                 $cartItem->serviceDetails = Service::find($bookingOrder->service_id); // Use service_id from BookingOrders
    //                 $cartItem->price = $cartItem->serviceDetails->service_discount_price ?? $cartItem->serviceDetails->service_price;
    //                 $cartItem->type = 'Service';
    //             }
    //         }

    //         // Fetch the handyman status for each cart item
    //         if ($bookingOrder) {
    //             $cartItem->handymanStatus = $bookingOrder->handyman_status;
    //         }
    //     }

    //     // Ensure $bookingOrder is set before accessing its properties
    //     $bookingId = $bookingOrder ? $bookingOrder->id : null;

    //     // Call the API to fetch booking status history
    //     $apiUrl = 'http://145.223.23.5/api/admin_booking_status_history';
    //     $client = new \GuzzleHttp\Client();
    //     $response = $client->post($apiUrl, [
    //         'json' => [
    //             'provider_id' => $firstProvider->id ?? null,
    //             'booking_id' => $bookingId,
    //         ]
    //     ]);

    //     $statusHistory = json_decode($response->getBody()->getContents(), true);

    //     // Check if the API call was successful
    //     $allStatus = $statusHistory['response_code'] == "1" ? $statusHistory['all_status'] : [];

    //     // Return the view with the booking data, handymen users, first provider, assigned handyman, and status history
    //     return view('innerbooking-view', compact('data', 'handymen', 'firstProvider', 'assignedHandyman', 'allStatus', 'defaultCurrency', 'userAddress'));
    // }


    public function innerbookingView($id)
    {
        // Fetch booking data based on the main booking order ID
        $data = BookingOrders::with([
            'user' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
            },
            'provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
            }
        ])->find($id);

        if (!$data) {
            return abort(404, 'Order not found');
        }

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch the provider_ids from the booking order
        $providerIds = $data->pluck('provider_id')->unique();

        // Fetch the first provider (associated with the booking order)
        $firstProvider = $data->provider;

        // Fetch handymen
        $handymen = User::whereIn('provider_id', $providerIds)
            ->select('id', 'firstname', 'lastname')
            ->get();

        // Fetch assigned handyman if exists
        $assignedHandyman = null;
        $avgHandymanReview = 0; // Default to 0 if no reviews exist
        $bookingOrder = BookingOrders::where('id', $id)->first();
        if ($bookingOrder && $bookingOrder->work_assign_id) {
            $assignedHandyman = User::find($bookingOrder->work_assign_id);

            // Fetch handyman average review
            if ($assignedHandyman) {
                $avgHandymanReview = HandymanReview::where('handyman_id', $assignedHandyman->id)
                ->avg('star_count') ?? 0; // Default to 0 if no reviews exist
            }
        }


        // Fetch user_id from the booking_orders table
        $userId = $data->user_id;

        // Fetch the user's address from userAddress table
        $userAddress = UserAddressModel::where('user_id', $userId)->first();

        // Fetch product or service details directly from BookingOrders
        $productDetails = null;
        $serviceDetails = null;

        if ($bookingOrder) {
            // Fetch product details if product_id is available
            if ($bookingOrder->product_id) {
                $productDetails = Product::find($bookingOrder->product_id);
            }

            // Fetch service details if service_id is available
            if ($bookingOrder->service_id) {
                $serviceDetails = Service::find($bookingOrder->service_id);
            }
        }

        // Fetch handyman status from the booking order
        $handymanStatus = $bookingOrder ? $bookingOrder->handyman_status : null;

        // Fetch cart_id from the booking order
        $cartId = $bookingOrder ? $bookingOrder->cart_id : null;


        // Fetch cart items to get quantity
        $cartItems = [];
        if ($bookingOrder && $bookingOrder->cart_id) {
            $cartItems = CartItemsModel::where('cart_id', $bookingOrder->cart_id)
            ->select('product_id', 'service_id', 'quantity')
            ->get();
        }


        // Determine quantity for product/service
        $quantity = null;
        if ($productDetails) {
            $quantity = $cartItems->where('product_id', $productDetails->product_id)->first()->quantity ?? 1;
        } elseif ($serviceDetails) {
            $quantity = $cartItems->where('service_id', $serviceDetails->id)->first()->quantity ?? 1;
        }

        // Fetch the provider ID from the booking order
        $providerId = $data->provider_id;




        // Fetch average review rating for the user
        $avgReview = ServiceProof::where('user_id', $userId)
            ->avg('rev_star') ?? 0; // Default to 0 if no reviews exist

        // Fetch avg review rating for the provider
        $avgProviderReview = ServiceReview::where('provider_id', $providerId)
            ->selectRaw('COALESCE(AVG(star_count), 0) as avg_star')
            ->value('avg_star'); // Get the single avg star rating value

        // $handymanId = $data->handyman_id;
        // $avgHandymanReview = HandymanReview::whereIn('handyman_id',
        //     $handymanId
        // )
        // ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
        // ->groupBy('handyman_id')
        // ->pluck('avg_star', 'handyman_id'); 

        // Ensure $bookingOrder is set before accessing its properties
        $bookingId = $bookingOrder ? $bookingOrder->id : null;

        // Call the API to fetch booking status history
        $apiUrl = 'http://145.223.23.5/api/admin_booking_status_history';
        $client = new \GuzzleHttp\Client();
        $response = $client->post($apiUrl, [
            'json' => [
                'provider_id' => $firstProvider->id ?? null,
                'booking_id' => $bookingId,
            ]
        ]);

        $statusHistory = json_decode($response->getBody()->getContents(), true);

        // Check if the API call was successful
        $allStatus = $statusHistory['response_code'] == "1" ? $statusHistory['all_status'] : [];

        // Return the view with the booking data, handymen users, first provider, assigned handyman, and status history
        return view('innerbooking-view', compact('data', 'handymen', 'firstProvider', 'assignedHandyman', 'allStatus', 'defaultCurrency', 'userAddress', 'productDetails', 'serviceDetails', 'handymanStatus', 'avgReview', 'avgProviderReview', 'avgHandymanReview'));
    }











    // assignHandyman
    public function assignHandyman(Request $request, $id)
    {


        // Validate the selected handyman ID
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        // Get the authenticated provider's ID
        $providerId = 1;
        $workAssignId = $request->input('id');
        $bookingId = $id; // Use the booking ID from the route parameter

        // Check if the selected handyman exists
        $handyman = User::find($workAssignId);
        if (!$handyman) {
            return redirect()->back()->withErrors('Selected handyman does not exist.');
        }


        // Fetch booking order and check if it exists
        $bookingOrder = BookingOrders::where('id', $bookingId)
            ->first();

        if (!$bookingOrder) {
            return redirect()->back()->withErrors('Booking order not found or unauthorized access.');
        }

        // Update the booking order with assigned handyman
        $bookingOrder->update([
            'work_assign_id' => $workAssignId,
            'handyman_status' => 1, // Assigned status
        ]);

        // Insert status history
        DB::table('booking_orders_status')->insert([
            'booking_id' => $bookingId,
            'provider_id' => $providerId,
            'work_assign_id' => $workAssignId,
            'status' => 1, // Assigned status
            'created_at' => now(),
        ]);

        // Flash success message
        session()->flash('message', 'Handyman assigned successfully.');

        // Redirect to the booking view page
        return redirect()->route('subbooking-view', $id);
    }











    // printInvoice
    public function printInvoice($id)
    {

        // Fetch order data with related cart items
        $data = OrdersModel::with([
            'cartItems.userAddress',
            'cartItems.provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
            }
        ])->find($id);

        if (!$data) {
            return abort(404, 'Order not found');
        }

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch the default currency from SiteSetup
        $profileimage = User::first()->profile_pic;

        // Initializ
        $bookingOrders = [];

        // Process each cart item
        foreach ($data->cartItems as $cartItem) {
            // Fetch booking order data using cart_id
            $bookingOrder = BookingOrders::where('cart_id', $cartItem->cart_id)->first();
            if ($bookingOrder) {
                $cartItem->booking_id = $bookingOrder->id;
                $cartItem->service_id = $bookingOrder->service_id;
                $cartItem->product_id = $bookingOrder->product_id;
                $cartItem->handymanStatus = $bookingOrder->handyman_status;
                $cartItem->payment = $bookingOrder->payment;
                $cartItem->quantity = $cartItem->quantity ?? 1; // Default to 1 if not found


                // Fetch service or product details
                if ($cartItem->service_id) {
                    $cartItem->serviceDetails = Service::find($cartItem->service_id);
                    $cartItem->price = $cartItem->serviceDetails->service_discount_price ?? $cartItem->serviceDetails->service_price;
                    $cartItem->type = 'Service';
                } elseif ($cartItem->product_id) {
                    $cartItem->productDetails = Product::find($cartItem->product_id);
                    $cartItem->price = $cartItem->productDetails->product_discount_price ?? $cartItem->productDetails->product_price;
                    $cartItem->type = 'Product';
                }

                $bookingOrders[] = $bookingOrder;
            }
        }

        // Pass data to the Blade template
        return view('print-invoice', compact('data', 'defaultCurrency', 'profileimage'));
    }
}
