<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\CartItemsModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\MulticastSendReport;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    protected $firebase;
    protected $messaging;

    // public function __construct()
    // {
    //     $this->firebase = (new Factory)
    //         ->withServiceAccount(config_path('firebase_credentials.json'));
    //     $this->messaging = $this->firebase->createMessaging();
    // }


    public function sendResponse($result, $message)
    {
        $response = [
            'success' => "true",
            'message' => $message,
            'data' => $result
        ];
        return response()->json($response, 200);
    }
    public function sendMessage($message)
    {
        $response = [
            'success' => "true",
            'message' => $message
        ];
        return response()->json($response, 200);
    }
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => "false",
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }


    public function s3FetchFile($filekey)
    {
        if (Storage::disk('s3')->exists($filekey)) {
            // $url = Storage::disk('s3')->temporaryUrl($filekey, now()->addMinutes(10));
            //public url
            $url = Storage::disk('s3')->url($filekey);
            return (string)$url;
        }
        return false;
    }
    public function s3DeleteFile($filekey)
    {
        // $deleted = Storage::disk('s3')->delete($filekey);
        return Storage::disk('s3')->delete($filekey);
    }

    public function monthlyUsersChart()
    {
        $usersPerYear = DB::table('users')
            ->select(DB::raw('MONTHNAME(created_at) as x'), DB::raw('count(*) as y'), DB::raw('max(created_at) as createdAt'))
            ->where('user_type', 'Normal')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])->groupBy('x')->orderBy('createdAt')->get();

        $months = $this->getAllMonths();
        $data = $this->fillMissingMonths($usersPerYear, $months);

        return $data;
    }

    public function monthlyVendorChart()
    {
        $usersPerYear = DB::table('users')
            ->select(DB::raw('MONTHNAME(created_at) as x'), DB::raw('count(*) as y'), DB::raw('max(created_at) as createdAt'))
            ->where('user_type', 'Vendor')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])->groupBy('x')->orderBy('createdAt')->get();

        $months = $this->getAllMonths();
        $data = $this->fillMissingMonths($usersPerYear, $months);

        return $data;
    }

    private function getAllMonths()
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
    }
    private function fillMissingMonths($usersPerYear, $months)
    {
        $data = [];
        foreach ($months as $month) {
            $matchingRecord = $usersPerYear->firstWhere('x', $month);
            $count = $matchingRecord ? $matchingRecord->y : 0;
            $data[] = [
                'x' => $month,
                'y' => (int)$count
            ];
        }
        return $data;
    }

    public function monthlySelling()
    {
        $sellPerYear = DB::table('orders')
            ->select(DB::raw('MONTHNAME(created_at) as x'), DB::raw('sum(total) as y'), DB::raw('max(created_at) as createdAt'))
            ->where('order_status', 2)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])->groupBy('x')->orderBy('createdAt')->get();

        $months = $this->getAllMonths();
        $data = $this->fillMissingMonths($sellPerYear, $months);

        return $data;
    }

    public function monthlySellingOfvendor($vendor_id)
    {
        // $sellPerYear = DB::table('orders')
        //     ->select(DB::raw('MONTHNAME(created_at) as x'), DB::raw('sum(total) as y'), DB::raw('max(created_at) as createdAt'))
        //     ->where('order_status', 2)
        //     ->whereBetween('created_at', [
        //         Carbon::now()->startOfYear(),
        //         Carbon::now()->endOfYear(),
        //     ])->groupBy('x')->orderBy('createdAt')->get();
        try {
            //code...
            $sellPerYear = CartItemsModel::join('orders', 'orders.id', '=', 'cart_items.order_id')
                // ->join('products', 'cart_items.product_id', '=', 'products.product_id')
                ->select(
                    DB::raw('MONTHNAME(cart_items.updated_at) as x'),
                    // DB::raw('SUM(cart_items.total) as y'),
                    DB::raw('SUM(cart_items.price + cart_items.shipping_charge) as y'),
                    DB::raw('MAX(cart_items.updated_at) as createdAt')
                )
                ->where('cart_items.checked', 1)
                ->where('cart_items.vendor_id', $vendor_id)
                ->whereBetween('orders.updated_at', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ])
                ->groupBy('x')
                ->orderBy('createdAt')
                ->get();
            $months = $this->getAllMonths();
            $data = $this->fillMissingMonths($sellPerYear, $months);
            return $data;
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('SolvThisErrors', $th->getMessage());
        }
    }

    function sendNotification2($data)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $serverKey = "AAAAlA1mt_c:APA91bFRlO3IAv2MmAiD658oICfevFgeXjm-Kg2g8QVOrUSV8k8Svr_396-APLTnqCWiFJs2dqF63kIv9KyIS44pZWWF-N6h9NFLhNAkAu2ZR36GfNZR3Stv_sDegOsG41acp79IqtUz";
        $encodedData = json_encode($data);
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return true;
    }

    public function sendNotification_done($title, $message, $data = [], $userIds = [])
    {
        $deviceTokens = [];

        if (!empty($userIds)) {
            $users = User::whereIn('id', $userIds)->get();
            foreach ($users as $user) {
                if ($user->device_token) {
                    $deviceTokens[] = $user->device_token;
                }
            }
        }

        if (!empty($deviceTokens)) {
            // $notification = Notification::create($title, $message);
            $cloudMessage = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data);

            try {
                $report = $this->messaging->sendMulticast($cloudMessage, $deviceTokens);
                return $report;
            } catch (\Exception $e) {
                // Log any errors during the notification sending process
                // \Log::error('Error sending notification: ' . $e->getMessage());
                return null;
            }
        }

        // \Log::info('No device tokens found for the provided user IDs.');
        return null;
    }

    public function sendNotification_06(Request $request, $FcmToken)
    {
        // Initialize the Firebase SDK with your credentials
        $firebase = (new Factory)
            ->withServiceAccount(config_path('firebase_credentials.json'));

        // Get the Firebase Messaging instance
        $messaging = $firebase->createMessaging();

        // Create the message
        $message = CloudMessage::fromArray([
            'token' => $FcmToken,
            'notification' => [
                'title' => $request->title,
                'body' => $request->message,
            ],
            'data' => [
                'type' => "Service",
                'booking_id' => $booking_id,
                'order_id' => $order_id,
            ]
        ]);

        // Send the message to the specific device token
        $report = $messaging->send($message);

        // Return the report or handle it as needed
        return response()->json($report);
    }

    public function sendNotification_1609(Request $request, $FcmToken)
    {
        // Validate incoming request
        $validated = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
            'booking_id' => 'required|integer',
            'order_id' => 'required|integer',
        ]);

        // Initialize the Firebase SDK with your credentials
        $firebase = (new Factory)
            ->withServiceAccount(config_path('firebase_credentials.json'));

        // dd($firebase);
        // Get the Firebase Messaging instance
        $messaging = $firebase->createMessaging();

        // Create the message
        $message = CloudMessage::fromArray([
            'token' => $FcmToken,
            'notification' => [
                'title' => $validated['title'],
                'body' => $validated['message'],
            ],
            'data' => [
                'type' => $validated['type'],
                'booking_id' => (string) $validated['booking_id'],
                'order_id' => (string) $validated['order_id'],
                // Add more key-value pairs as needed
            ]
        ]);

        // Send the message to the specific device token
        try {
            $report = $messaging->send($message);
            // Return success response
            return response()->json(['status' => 'success', 'report' => $report], 200);
        } catch (Exception $e) {
            // Handle sending error
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function sendNotification(Request $request, $FcmToken)
    {
        // Validate incoming request
        $validated = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
            'booking_id' => 'required|integer',
            'order_id' => 'required|integer',
            'profile_image' => 'string',
        ]);

        // Initialize the Firebase SDK with your credentials
        $firebase = (new Factory)
            ->withServiceAccount(config_path('firebase_credentials.json'));

        // Get the Firebase Messaging instance
        $messaging = $firebase->createMessaging();

        // Create the message
        $message = CloudMessage::fromArray([
            'token' => $FcmToken,
            'notification' => [
                'title' => $validated['title'],
                'body' => $validated['message'],
            ],
            'data' => [
                'type' => $validated['type'],
                'booking_id' => (string) $validated['booking_id'],
                'order_id' => (string) $validated['order_id'],
                // 'profile_image' => $validated['profile_image'] ?? "",
                'profile_image' => "http://145.223.23.5/images/user/user.jpg",
            ]
        ]);

        // dd($message);

        // Log the message and token
        // Log::info('Sending notification', [
        //     'token' => $FcmToken,
        //     'message' => $message
        // ]);

        // Send the message to the specific device token
        try {
            $report = $messaging->send($message);
            // Return success response
            return response()->json(['status' => 'success', 'report' => $report], 200);
        } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
            // Log::error('FCM token not found', [
            //     'error' => $e->getMessage(),
            //     'token' => $FcmToken,
            //     'message' => $message
            // ]);
            return response()->json(['status' => 'error', 'message' => 'FCM token not found'], 404);
        } catch (Exception $e) {
            // Handle other errors
            // Log::error('Error sending notification', [
            //     'error' => $e->getMessage(),
            //     'token' => $FcmToken,
            //     'message' => $message
            // ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function sendNotification_chat(Request $request, $FcmToken)
    {
        // Validate incoming request
        $validated = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
            'booking_id' => 'required|integer',
            'order_id' => 'required|integer',
            'profile_image' => 'string',
        ]);

        // Initialize the Firebase SDK with your credentials
        $firebase = (new Factory)
            ->withServiceAccount(config_path('firebase_credentials.json'));

        // Get the Firebase Messaging instance
        $messaging = $firebase->createMessaging();

        // Create the message
        $message = CloudMessage::fromArray([
            'token' => $FcmToken,
            'notification' => [
                'title' => $validated['title'],
                'body' => $validated['message'],
            ],
            'data' => [
                'type' => $validated['type'],
                'booking_id' => (string) $validated['booking_id'],
                'order_id' => (string) $validated['order_id'],
                // 'profile_image' => $validated['profile_image'] ?? "",
                'profile_image' => "http://145.223.23.5/images/user/user.jpg",
                "username" => $validated['title'],
            ]
        ]);

        // dd($message);

        // Log the message and token
        // Log::info('Sending notification', [
        //     'token' => $FcmToken,
        //     'message' => $message
        // ]);

        // Send the message to the specific device token
        try {
            $report = $messaging->send($message);
            // Return success response
            return response()->json(['status' => 'success', 'report' => $report], 200);
        } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
            // Log::error('FCM token not found', [
            //     'error' => $e->getMessage(),
            //     'token' => $FcmToken,
            //     'message' => $message
            // ]);
            return response()->json(['status' => 'error', 'message' => 'FCM token not found'], 404);
        } catch (Exception $e) {
            // Handle other errors
            // Log::error('Error sending notification', [
            //     'error' => $e->getMessage(),
            //     'token' => $FcmToken,
            //     'message' => $message
            // ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
