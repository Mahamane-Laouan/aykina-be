<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ReelResource;
use App\Http\Resources\TagResource;

use App\Models\User;
use App\Models\BookingOrders;
use App\Models\CartItems;
use App\Models\Service;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Mail\ForgetPass;
use App\Models\Posts_report;
use App\Models\Setting;
use App\Models\User_report;
use App\Models\Wallet;
use Razorpay\Api\Api;


class RazorPayController extends BaseController
{


     public function AddWalletRazorPay(Request $request)
    {
        try {
        // $user = Auth::guard('sanctum')->user();
        
        $user = Auth::user()->token()->user_id;
        
        if (!$user) {
            return response()->json(['error' => 'authentication_error', 'message' => 'User is not authenticated.'], 401);
        }
        
        $userId = $user;

        $razorpayKeyId = 'rzp_test_ktbxSvVI7dsfn2';
        $razorpayKeySecret = 'bV0o6z2nrLvgSmiA1eIMCGYx';

        $api = new Api($razorpayKeyId, $razorpayKeySecret);

        // $yourDomain = 'https://ecommerce.theprimoapp.com';
        
         $yourDomain = 'https://handyman.theprimocys.com';

        // Amount to be added to the wallet
        $amountToAdd = $request->input('amount');

        // Create order
        $orderData = [
            'receipt' => 'wallet_rcptid_' . time(),
            'amount' => $amountToAdd * 100, // amount in paise
            'currency' => 'INR',
            'payment_capture' => 1 // auto capture payment
        ];

        $order = $api->order->create($orderData);
        
        
         $data = [
            'user_id' => $userId,
            'payment_method' => "Razorpay",
            'amount' => $request->input('amount'),
            'status' => "add",
            'success' => "true",
        ];
        
            $done = DB::table('wallet')->insert($data);
        

        return response()->json(['order_id' => $order['id']], 200);
        } catch (\Throwable $th) {
        return response()->json(['error' => 'error', 'message' => $th->getMessage()], 500);
         }
    }
    
    
    public function RazorPaycheckout(Request $request)
  {
    try {
    //   $user = Auth::guard('sanctum')->user();
    
     $user = Auth::user()->token()->user_id;
      if (!$user) {
        return response()->json(['error' => 'authentication_error', 'message' => 'User is not authenticated.'], 401);
      }

      $razorpayKeyId = 'rzp_test_ktbxSvVI7dsfn2';
      $razorpayKeySecret = 'bV0o6z2nrLvgSmiA1eIMCGYx';

      $api = new Api($razorpayKeyId, $razorpayKeySecret);

      // Validate the request input
      $request->validate([
        'amount' => 'required|numeric|min:1'
      ]);

      $amount = $request->input('amount');

      $orderData = [
        'receipt' => 'order_rcptid_' . time(),
        'amount' => $amount * 100, // amount in paise
        'currency' => 'USD',
      ];

      $order = $api->order->create($orderData);

      return response()->json(['order_id' => $order['id']], 200);
    } catch (\Throwable $th) {
      return response()->json(['error' => 'error', 'message' => $th->getMessage()], 500);
    }
  }
    
}