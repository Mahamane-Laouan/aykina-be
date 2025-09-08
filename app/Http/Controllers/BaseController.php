<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => "true",
            'message' => $message,
            'data' => $result
        ];
        return response()->json($response, 200);
    }

    public function sendResponses($result, $message)
    {
        $response = [
            'success' => "true",
            'message' => $message,
            'languages' => $result
        ];
        return response()->json($response, 200);
    }

    public function sendRespo($result, $message)
    {
        $response = [
            'success' => "true",
            'message' => $message,
            'religions' => $result
        ];
        return response()->json($response, 200);
    }

    public function sendRes($result, $message)
    {
        $response = [
            'success' => "true",
            'message' => $message,
            'starsigns' => $result
        ];
        return response()->json($response, 200);
    }

    public function sendRe($result, $message)
    {
        $response = [
            'success' => "true",
            'message' => $message,
            'interest1' => $result
        ];
        return response()->json($response, 200);
    }

    public function sendRespon($result, $message)
    {
        $response = [
            'success' => "true",
            'message' => $message,
            'events' => $result
        ];
        return response()->json($response, 200);
    }

    public function sendResponces($result, $message, $is_view)
    {
        $response = [
            'success' => "true",
            'message' => $message,
            'events' => $result,
            'is_notification' => $is_view,
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
                'y' => $count
            ];
        }
        return $data;
    }

    public function monthlyUsersChart()
    {
        $usersPerYear = DB::table('users')
            ->select(DB::raw('MONTHNAME(created_at) as x'), DB::raw('count(*) as y'), DB::raw('max(created_at) as createdAt'))
            ->where('user_plan', 'Normal')
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
            ->where('user_plan', 'Subsciber User')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])->groupBy('x')->orderBy('createdAt')->get();

        $months = $this->getAllMonths();
        $data = $this->fillMissingMonths($usersPerYear, $months);

        return $data;
    }

    public function monthlySelling()
    {
        $sellPerYear = DB::table('tickets')
            ->select(DB::raw('MONTHNAME(created_at) as x'), DB::raw('sum(price) as y'), DB::raw('max(created_at) as createdAt'))
            // ->where('order_status', 2)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])->groupBy('x')->orderBy('createdAt')->get();

        $months = $this->getAllMonths();
        $data = $this->fillMissingMonths($sellPerYear, $months);

        return $data;
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
        ]);

        // Initialize the Firebase SDK with your credentials
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
            ]
        ]);

        // Log the message and token
        Log::info('Sending notification', [
            'token' => $FcmToken,
            'message' => $message
        ]);

        // Send the message to the specific device token
        try {
            $report = $messaging->send($message);
            // Return success response
            return response()->json(['status' => 'success', 'report' => $report], 200);
        } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
            Log::error('FCM token not found', [
                'error' => $e->getMessage(),
                'token' => $FcmToken,
                'message' => $message
            ]);
            return response()->json(['status' => 'error', 'message' => 'FCM token not found'], 404);
        } catch (Exception $e) {
            // Handle other errors
            Log::error('Error sending notification', [
                'error' => $e->getMessage(),
                'token' => $FcmToken,
                'message' => $message
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
