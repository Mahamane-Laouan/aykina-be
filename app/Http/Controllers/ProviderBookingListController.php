<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\BookingOrdersStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItemsModel;
use App\Models\NotificationsPermissions;
use App\Models\OrdersModel;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteSetup;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Request;

class ProviderBookingListController extends Controller
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

        // Fetch orders filtered by the logged-in provider's provider_id
        $records = OrdersModel::with([
                'user' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'provider' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
                'cartItems' => function ($query) use ($providerId) {
                    $query->whereNotNull('service_id')
                    ->whereNull('product_id') // Filter condition added
                    ->select('order_id', 'provider_id', 'cart_id', 'service_id')
                    ->with([
                        'provider' => function ($providerQuery) {
                            $providerQuery->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                        },
                        'bookingOrder' => function ($bookingQuery) use ($providerId) {
                            $bookingQuery->select('cart_id', 'handyman_status', 'provider_id') // Fetch handyman_status
                            ->whereNotNull('service_id')  // Filter for service_id
                            ->whereNull('product_id')    // Filter for product_id
                            ->where('provider_id', $providerId); // Ensure provider_id matches logged-in provider
                        }
                    ]);
                }
            ])
            ->whereHas('cartItems.bookingOrder', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
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


        // Transform the created_at field for the main page view
        $records->getCollection()->transform(function ($record) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';
            return $record;
        });

        return view('providerbooking-list', compact('records', 'defaultCurrency'));
    }



    // deleteProviderBooking
    public function deleteProviderBooking($id)
    {
        $data = OrdersModel::where('id', $id)->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }



    // viewProviderBooking
    public function viewProviderBooking($id)
    {
        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch booking data with related cart items and user details
        $data = OrdersModel::with([
            'cartItems.userAddress',
            'cartItems.product',
            'cartItems.service',
            'user' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
            },
            'cartItems.provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic', 'country_code', 'mobile');
            }
        ])->find($id);

        if (!$data) {
            return abort(404, 'Order not found');
        }

        // Fetch all unique provider_ids from cartItems related to the order
        $providerIds = $data->cartItems->pluck('provider_id')->unique();

        // Fetch the first provider from the cart items, if it exists
        $firstProvider = null;
        foreach ($data->cartItems as $cartItem) {
            if ($cartItem->provider) {
                $firstProvider = $cartItem->provider;
                break;
            }
        }


        $handymen = User::whereIn('provider_id', $providerIds)
            ->select('id', 'firstname', 'lastname')
            ->get();

        // Fetch assigned handyman if exists
        $assignedHandyman = null;
        $bookingOrder = null;
        foreach ($data->cartItems as $cartItem) {
            $bookingOrder = BookingOrders::where('cart_id', $cartItem->cart_id)->first();
            if ($bookingOrder && $bookingOrder->work_assign_id) {
                $assignedHandyman = User::find($bookingOrder->work_assign_id);
                break;
            }
        }

        // Process the cart items (fetch product or service details)
        foreach ($data->cartItems as $cartItem) {
            if ($cartItem->product_id) {
                $cartItem->productDetails = Product::find($cartItem->product_id);
                $cartItem->price = $cartItem->productDetails->product_discount_price ?? $cartItem->productDetails->product_price;
                $cartItem->type = 'Product';
            } elseif ($cartItem->service_id) {
                $cartItem->serviceDetails = Service::find($cartItem->service_id);
                $cartItem->price = $cartItem->serviceDetails->service_discount_price ?? $cartItem->serviceDetails->service_price;
                $cartItem->type = 'Service';
            }

            // Fetch the handyman status for each cart item
            $bookingOrderData = BookingOrders::where('cart_id', $cartItem->cart_id)->first();
            if ($bookingOrderData) {
                $cartItem->handymanStatus = $bookingOrderData->handyman_status;
            }
        }

        // Ensure $bookingOrder is set before accessing its properties
        $bookingId = $bookingOrder ? $bookingOrder->id : null;

        // dd($bookingId);

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
        return view('providerbooking-view', compact('data', 'handymen', 'firstProvider', 'assignedHandyman', 'allStatus', 'defaultCurrency'));
    }



    // assignProviderHandyman
    public function assignProviderHandyman(Request $request, $id)
    {
        // Validate the selected handyman ID
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        // Get the selected handyman (provider)
        $handymanId = $request->input('id');

        // Find the main order by its ID
        $order = OrdersModel::findOrFail($id);

        // Fetch all cart items related to this order with non-null service_id
        $cartItems = CartItemsModel::where('order_id', $order->id)
            ->whereNotNull('service_id')
            ->get();

        foreach ($cartItems as $cartItem) {
            // Find the corresponding booking order where cart_id matches
            $bookingOrder = BookingOrders::where('cart_id', $cartItem->cart_id)->first();

            // Check if the booking order exists and has a service_id
            if ($bookingOrder && !empty($bookingOrder->service_id)) {
                // Update the booking_orders table with the provider (handyman) and work_assign_id
                $bookingOrder->work_assign_id = $handymanId;
                $bookingOrder->save();

                // Insert a new entry in the booking_orders_status table
                $bookingStatus = new BookingOrdersStatus();
                $bookingStatus->booking_id = $bookingOrder->id;
                $bookingStatus->provider_id = $cartItem->provider_id;
                $bookingStatus->work_assign_id = $handymanId;
                $bookingStatus->status = '1';
                $bookingStatus->save();

                // Fetch FCM token and other details for notifications
                $FcmToken = User::where('id', $handymanId)->value('device_token');
                $fromUser = User::where('id', $handymanId)->value('firstname');
                $proviver_noti = NotificationsPermissions::where('id', "29")->first();

                // Ensure $cartItem->provider_id and $bookingOrder->id are valid
                if ($cartItem->provider_id && $bookingOrder->id) {
                    $user_ser = BookingOrders::where('provider_id', $cartItem->provider_id)
                        ->where('id', $bookingOrder->id)
                        ->first();

                    if ($user_ser) {
                        $FcmToken_done = User::where('id', $user_ser->user_id)->value('device_token');
                        $all_user_id = $user_ser->user_id;
                        $all_cart_id = $user_ser->cart_id;
                        $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();

                        if ($all_order__id) {
                            $order_id = $all_order__id->order_id;

                            $type = "Service";
                            $data = [
                                'title' => $proviver_noti->title,
                                'message' => '#' . $bookingOrder->id . ' ' . $proviver_noti->description . ' ' . $fromUser,
                                'type' => $type,
                                'booking_id' => $bookingOrder->id,
                                'order_id' => $order_id,
                            ];

                            // Send notifications
                            $this->sendNotification(new Request($data), $FcmToken);
                            $this->sendNotification(new Request($data), $FcmToken_done);

                            // Insert notification into the database
                            $not_all = [
                                'booking_id' => $bookingOrder->id,
                                'provider_id' => $cartItem->provider_id,
                                'handyman_id' => $handymanId,
                                'user_id' => $all_user_id,
                                'title' => $proviver_noti->title,
                                'message' => '#' . $bookingOrder->id . ' ' . $proviver_noti->description . ' ' . $fromUser,
                                'type' => "Service",
                                'created_at' => now(),
                            ];

                            DB::table('user_notification')->insert($not_all);
                        }
                    }
                }
            }
        }

        // Flash success message to the session
        session()->flash('message', 'Handyman assigned successfully');

        // Redirect to the booking view page
        return redirect()->route('providerbooking-view', $id);
    }
}
