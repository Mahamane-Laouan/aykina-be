<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// Use Defuse\Crypto\File;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Models\User;
use App\Models\UserReferal;
// use File;
// use Twilio\Rest\Client;
use App\Services\Msg91Service;
use Illuminate\Support\Facades\Log;
use App\Models\Bankdetails;
use App\Mail\OtpSend;
use GuzzleHttp\Client;
use Twilio\Rest\Client as TwilioClient;
use App\Mail\UserOtpVerify;
use App\Models\UserEmailOtpVerify;
use App\Mail\ProviderOtpVerify;
use App\Models\ProviderEmailOtpVerify;
use App\Mail\HandymanOtpVerify;
use App\Models\HandymanEmailOtpVerify;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Models\SiteSetup;


class AuthController extends BaseController
{

  protected $msg91Service;

  public function __construct(Msg91Service $msg91Service)
  {
    // $this->msg91Service = $msg91Service;
    // dd($msg91Service);
    $this->msg91ApiKey = "420844ActrLUqz662a3de3P1";
    $this->otpTemplateId = "67650b08d6fc054ac165ea32";
    $this->twilioSid = "AC1b0ddd7b5a21005c86614e93d75a8a81";
    $this->twilioAuthToken = "7d88f12bcc00722f13889a5265e73ea4";
    $this->twilioFrom = "+19293963070";
  }

  public function sendOtp(Request $request)
  {
    $mobileNumber = $request->input('mobile');
    $otp = rand(1000, 9999); // Generate a 4-digit OTP

    // Log::info('Generated OTP', ['mobile' => $mobileNumber, 'otp' => $otp]);

    $response = $this->msg91Service->sendOtp($mobileNumber, $otp);

    if (isset($response['type']) && $response['type'] == 'error') {
      // Log::error('Failed to send OTP', ['response' => $response]);
      return response()->json(['message' => 'Failed to send OTP', 'error' => $response['message']], 500);
    }

    // Log::info('OTP sent successfully', ['response' => $response]);
    return response()->json(['message' => 'OTP sent successfully', 'response' => $response]);
  }

  public function login(Request $request)
  {
    // dd(bcrypt($request->password));
    $validator = Validator::make($request->all(), [
      'email' => 'required|exists:users',
      'password' => 'required',
    ]);

    if ($validator->fails()) {
      // return $this->sendError('Error validation', $validator->errors());
      $result["success"] = "failure";
      $result["message"] = "Users Not Found";
      // $result['users'] = $users;
      // $result["status"] = "failure";
      // echo json_encode($result);

      return response()->json($result);
    }

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      // $authUser = Auth::user();
      $authUser = User::where('email', $request->email)->first();
      // 'token' => $otpVerifcation->createToken('MyApp')->plainTextToken,
      $success['token'] =  $authUser->createToken('MyAuthApp')->accessToken;
      $success['email'] =  $authUser->email;
      $success['id'] =  $authUser->id;
      $success['user_role'] =  $authUser->user_role;
      $success['people_id'] =  (string)$authUser->people_id ?? "";

      return $this->sendResponse($success, 'User signed in');
    } else {
      // return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);

      $result["success"] = "failure";
      $result["message"] = "Users Not Found";
      // $result['users'] = $users;
      // $result["status"] = "failure";
      // echo json_encode($result);

      return response()->json($result);
    }
  }

  public function username_email_check(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'username' => 'required',
      'password' => 'required|min:6', // Adjust the minimum length as needed
      'firstname' => 'required',
      'lastname' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'response_code' => 0,
        'message' => 'Validation failed',
        'status' => 'failure',
        'errors' => $validator->errors(),
      ]);
    }

    $user_check = User::where(function ($query) use ($request) {
      $query->where('username', '=', $request->username)
        ->orWhere('email', '=', $request->email);
    })->count();

    if ($user_check != 0) {
      return response()->json([
        'response_code' => 0,
        'message' => 'Username or Email ID already registered',
        'status' => 'failure',
      ]);
    }

    $fullname = $request->firstname . ' ' . $request->lastname;

    $user = User::create([
      'username' => $request->username,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'fullname' => $fullname,
    ]);

    $token = $user->createToken('MyAuthApp')->accessToken;

    return response()->json([
      'response_code' => "1",
      'message' => 'user register success',
      'status' => 'success',
      'user' => new UserResource($user),
      'token' => $token,
    ]);
  }

  public function register_new(Request $request)
  {
    // dd($request->all());
    $validator = Validator::make($request->all(), [
      'firstname' => 'required',
      'lastname' => 'required',
      'email' => 'required',
      'password' => 'required|min:8',
      // 'confirm_password' => 'required|same:password',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Error validation', $validator->errors());
    }

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $refer_code = '';
    $max = strlen($characters) - 1;

    for ($i = 0; $i < 7; $i++) {
      $refer_code .= $characters[mt_rand(0, $max)];
    }



    $input = $request->all();
    if (User::where('email', $input['email'])->where('otp_status', "1")->exists()) {
      return $this->sendError('Email Already Register..!');
    }
    $input['refer_code'] = $refer_code;

    $user_refer_code = $request->input('user_refer_code');



    $mobile = $request->input('mobile');
    $user_role = $request->input('user_role');
    $login_type = $request->input('login_type');
    $country_code = $request->input('country_code');
    $country_flag = $request->input('country_flag');
    $main_password = $request->input('password');
    $latitude = $request->input('lat');
    $longitude = $request->input('lon');
    $people_id = $request->input('people_id');



    $input['password'] = bcrypt($input['password']);
    $confirmationCode = rand(1000, 9999);
    $input['otp'] = $confirmationCode;
    $user = User::create($input);
    // $confirmationCode = rand(100000, 999999);

    // if ($user) {

    //     $toEmail = $request->email;
    //     $username = $request->firstname . "." . $request->lastname;;
    //     $mailData = array('code' => $confirmationCode, 'username' => $username);

    //     Mail::to($toEmail)->send(new OtpSend($mailData));
    //     // User::where('email', $request->email)->update(['otp' => $confirmationCode]);
    // }

    $firstname = $request->firstname;
    $email = $request->email;
    $otp = $confirmationCode;

    if ($people_id == "3") {
      $emailPreference = UserEmailOtpVerify::where('get_email', 1)->first();

      if ($emailPreference) {
        // Send email on successful OTP verification
        Mail::to($email)->send(
          new UserOtpVerify($email, $otp, $firstname)
        );
      }
    }

    if ($people_id == "1") {
      $emailPreference = ProviderEmailOtpVerify::where('get_email', 1)->first();

      if ($emailPreference) {
        // Send email on successful OTP verification
        Mail::to($email)->send(
          new ProviderOtpVerify($email, $otp, $firstname)
        );
      }
    }

    if ($people_id == "2") {
      $emailPreference = HandymanEmailOtpVerify::where('get_email', 1)->first();

      if ($emailPreference) {
        // Send email on successful OTP verification
        Mail::to($email)->send(
          new HandymanOtpVerify($email, $otp, $firstname)
        );
      }
    }

    if ($request->user_refer_code != '') {
      $use_refer_user = User::where('refer_code', $request->user_refer_code)->first();

      //   $users = User::where('refer_code', $request->use_refer_code)->first();


      if ($use_refer_user) {

        $userReferal = [
          'user_id' => $user->id,
          'refer_code' => $refer_code,
          'user_refer_code' => $request->user_refer_code,
          'use_refer_code_by' => $use_refer_user->id,
        ];
        UserReferal::create($userReferal);


        $total_amount = User::where('id', $user->id)->first();

        User::where('id', $user->id)->update([
          'wallet_balance' => 20 + $total_amount->wallet_balance
        ]);

        $total_amount_done = User::where('id', $use_refer_user->id)->first();

        User::where('id', $use_refer_user->id)->update([
          'wallet_balance' => 20 + $total_amount_done->wallet_balance
        ]);


        $FcmToken = User::where('id', $use_refer_user->id)->value('device_token');

        $data = [
          'title' => "Message",
          'message' => "Your reference code applied by $request->firstname.",
          'type' => "Referal Code",
          'booking_id' => $use_refer_user->id,
          'order_id' => $user->id,
        ];

        //  dd($data);

        //  $this->sendNotification(new Request($data), $FcmToken);

        if ($FcmToken) {

          $this->sendNotification(new Request($data), $FcmToken);
        } else {

          // \Log::warning("Provider with ID {$use_refer_user->id} has no valid device token.");
        }
      }
    }
    $success['token'] =  $user->createToken('MyAuthApp')->accessToken;

    //  $token = $user->createToken('MyAuthApp')->accessToken;
    $success['id'] =  $user->id;
    $success['name'] =  $user->firstname;
    $success['user_role'] =  $user->user_role;
    return $this->sendResponse($success, 'User created successfully.');
  }

  public function social_login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'login_type' => 'required',
      'email' => 'required',
      // 'device_token' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'data' => $validator->errors(),
      ]);
    }
    $input = $request->all();
    // $username = $request->('username');
    $firstname = $request->input('firstname');

    $input['latitude'] = $request->input('lat');
    $input['longitude'] = $request->input('lon');

    $profile_pic = $request->input('profile_pic');

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $refer_code = '';
    $max = strlen($characters) - 1;

    for ($i = 0; $i < 7; $i++) {
      $refer_code .= $characters[mt_rand(0, $max)];
    }

    $input['refer_code'] = $refer_code;
    $people_id = $request->input('people_id');

    $user_refer_code = $request->input('user_refer_code');






    //  if ($request->file('image_url')) {

    //         $file = $request->file('image_url');
    //         $filename = "user". date('YmdHis') . $file->getClientOriginalName();
    //         // $filename = str_replace(" ", "", $filename);
    //         $file->move(public_path('/images/user/'), $filename);
    //         // $profile_pic = $filename;
    //           $input['profile_pic'] = $filename;
    //         // if (File::exists('images/user/' . $user->image)) {
    //         //     File::delete('images/profile_pic/' . $user->image);
    //         // }
    //     }

    // dd($input);
    if (User::where('email', $request->email)->exists()) {
      $user = User::where('email', $request->email)->first();
      $user->update($input);
      // return response()->json([
      //   'success' => false,
      //   'data' => array("token" => $user->createToken('MyApp')->accessToken, "login_type" => (string)$user->login_type), "Login success.",
      // ]);

      $updates = [
        'id' => (string)$user->id ?? "",
        'firstname' => $user->firstname ?? "",
        'lastname' => $user->lastname ?? "",
        'email' => $user->email ?? "",
        'mobile' => $user->mobile ?? "",
        'password' => $user->password ?? "",
        'login_type' => $user->login_type ?? "",
        'country_flag' => $user->country_flag ?? "",
        'country_code' => $user->country_code ?? "",
        'google_id' => $user->google_id ?? "",
        'profile_pic' => $user->profile_pic ?? "",
        'device_token' => $user->device_token ?? "",
        'create_date' => $user->create_date ?? "",
        'people_id' => (string)$user->people_id ?? "",
        // 'user_role' => $user->user_role ?? "",
      ];
      return response([
        'status' => "true",
        // 'user_id' => (string) $user->id,
        'token' => $user->createToken('MyAuthApp')->accessToken,
        'user_role' => (string)$user->user_role,
        'message' => "Login success.",
        'user' => $updates,
        'response_code' => "1",
      ]);
    }
    User::create($input);
    $user = User::where('email', $request->email)->first();

    if ($request->user_refer_code != '') {
      $use_refer_user = User::where('refer_code', $request->user_refer_code)->first();

      //   $users = User::where('refer_code', $request->use_refer_code)->first();


      if ($use_refer_user) {

        $userReferal = [
          'user_id' => $user->id,
          'refer_code' => $refer_code,
          'user_refer_code' => $request->user_refer_code,
          'use_refer_code_by' => $use_refer_user->id,
        ];
        UserReferal::create($userReferal);


        $total_amount = User::where('id', $user->id)->first();

        User::where('id', $user->id)->update([
          'wallet_balance' => 20 + $total_amount->wallet_balance
        ]);

        $total_amount_done = User::where('id', $use_refer_user->id)->first();

        User::where('id', $use_refer_user->id)->update([
          'wallet_balance' => 20 + $total_amount_done->wallet_balance
        ]);

        $FcmToken = User::where('id', $use_refer_user->id)->value('device_token');

        $data = [
          'title' => "Message",
          'message' => "Your reference code applied by $request->firstname.",
          'type' => "Referal Code",
          'booking_id' => $use_refer_user->id,
          'order_id' => $user->id,
        ];

        //  dd($data);

        //  $this->sendNotification(new Request($data), $FcmToken);

        if ($FcmToken) {

          $this->sendNotification(new Request($data), $FcmToken);
        } else {

          // \Log::warning("Provider with ID {$use_refer_user->id} has no valid device token.");
        }
      }
    }

    $updates = [
      'id' => (string)$user->id ?? "",
      'firstname' => $user->firstname ?? "",
      'lastname' => $user->lastname ?? "",
      'email' => $user->email ?? "",
      'mobile' => $user->mobile ?? "",
      'password' => $user->password ?? "",
      'login_type' => $user->login_type ?? "",
      'country_flag' => $user->country_flag ?? "",
      'country_code' => $user->country_code ?? "",
      // 'age' => $age,
      'google_id' => $user->google_id ?? "",
      'profile_pic' => $user->profile_pic ?? "",
      'device_token' => $user->device_token ?? "",
      'create_date' => $user->create_date ?? "",
      'people_id' => (string)$user->people_id ?? "",
      // 'user_role' => $user->user_role ?? "",
    ];
    // return response()->json([
    //   'success' => false,
    //   'data' => array("token" => $user->createToken('MyApp')->accessToken, "login_type" => (string)$user->login_type), "Signup success.",
    // ]);
    return response([
      'status' => "true",
      //   'user_id' => (string) $user->id,
      'token' => $user->createToken('MyAuthApp')->accessToken,
      'user_role' => (string)$user->user_role,
      'message' => "Signup success.",
      'user' => $updates,
      'response_code' => "1",
    ]);
  }

  public function send_otp_old(Request $request)
  {
    if (!empty($request->mobile)) {

      $e164Mobile = $request->country_code . $request->mobile;

      if (User::where('mobile', $request->mobile)->where('country_code', $request->country_code)->exists()) {


        try {
          //code...
          $account_sid = "AC1b0ddd7b5a21005c86614e93d75a8a81";
          $auth_token = "7d88f12bcc00722f13889a5265e73ea4";
          $twilio_number = "+19293963070";
          $client = new Client($account_sid, $auth_token);
          $rno = rand(1000, 9999);
          $message = "Your Handyman login OTP is $rno..!";
          // $client->messages->create($request->phone, ['from' => $twilio_number, 'body' => $message]);

          if ($client->messages->create($e164Mobile, ['from' => $twilio_number, 'body' => $message])) {

            // $data = array(
            //     "mobile" => $request->mobile,
            //     'device_token' => $request->device_token
            // );
            // User::where('mobile', $request->mobile)->update($data);


            $device_token = request('device_token');

            if (!empty($device_token)) {
              User::where('mobile', $request->mobile)->update(['device_token' => $device_token]);
            }

            $country_flag = request('country_flag');
            if (!empty($country_flag)) {
              User::where('mobile', $request->mobile)->update(['country_flag' => $country_flag]);
            }

            User::where('mobile', $request->mobile)->where('country_code', $request->country_code)->update(['otp' => $rno]);

            $user = User::where('mobile', $request->mobile)->where('country_code', $request->country_code)->first();

            $user_id = $user->id;
            $mobile_number = $user->mobile;
            $token =  $user->createToken('MyAuthApp')->accessToken;

            // return $this->sendResponse(new UserResource(User::where('phone', $request->phone)->first()), "User registered successfully");

            // return $this->sendMessage("Message not created");
            return response()->json([
              'message' => 'User registered successfully',
              // 'user_id' => $user_id,
              'mobile' => $mobile_number,
              // 'token' => $token,
              'status' => "success",
            ]);
          }
        } catch (\Throwable $th) {
          //throw $th;
          // return $this->sendError("Otp not send", $th->getMessage());
          $response = [
            'message' => 'User Not registered successfully',
            // 'user_id' => 0,
            'mobile' => "",
            'status' => "failure",
          ];
          return response()->json($response, 400);
          // return response()->json([
          //     'message' => $th->getMessage(),
          //     // 'access_token' => $accessToken,
          // ]);
        }
      } else {
        // return " not exist";
        try {
          //code...
          $account_sid = "AC1b0ddd7b5a21005c86614e93d75a8a81";
          $auth_token = "7d88f12bcc00722f13889a5265e73ea4";
          $twilio_number = "+19293963070";
          $client = new Client($account_sid, $auth_token);
          $rno = rand(1000, 9999);
          $message = "Your Handyman login OTP is $rno..!";
          // $client->messages->create($request->phone, ['from' => $twilio_number, 'body' => $message]);


          $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $refer_code = '';
          $max = strlen($characters) - 1;

          for ($i = 0; $i < 7; $i++) {
            $refer_code .= $characters[mt_rand(0, $max)];
          }

          $user_refer_code = $request->input('user_refer_code');



          if ($client->messages->create($e164Mobile, ['from' => $twilio_number, 'body' => $message])) {

            // User::where('phone', $request->phone)->update(['otp'=> $rno]);
            User::create([
              'mobile' => $request->mobile,
              'otp' => $rno,
              'country_code' => $request->country_code,
              'device_token' => $request->device_token,
              'login_type' => $request->login_type,
              'country_flag' => $request->country_flag,
              'refer_code' => $refer_code,
              'user_refer_code' => $user_refer_code,
              'user_role' => $request->user_role,

            ]);


            $user = User::where('mobile', $request->mobile)->first();

            if ($request->user_refer_code != '') {
              $use_refer_user = User::where('refer_code', $request->user_refer_code)->first();

              //   $users = User::where('refer_code', $request->use_refer_code)->first();


              if ($use_refer_user) {

                $userReferal = [
                  'user_id' => $user->id,
                  'refer_code' => $refer_code,
                  'user_refer_code' => $request->user_refer_code,
                  'use_refer_code_by' => $use_refer_user->id,
                ];
                UserReferal::create($userReferal);

                $total_amount = User::where('id', $user->id)->first();

                User::where('id', $user->id)->update([
                  'wallet_balance' => 20 + $total_amount->wallet_balance
                ]);

                $total_amount_done = User::where('id', $use_refer_user->id)->first();

                User::where('id', $use_refer_user->id)->update([
                  'wallet_balance' => 20 + $total_amount_done->wallet_balance
                ]);
              }
            }

            $token =  $user->createToken('MyAuthApp')->accessToken;

            $user_id = $user->id;
            $mobile_number = $user->mobile;
            return response()->json([
              'message' => 'User registered successfully',
              // 'user_id' => $user_id,
              'mobile' => $mobile_number,
              // 'token' => $token,
              'status' => "success",
            ]);
            // return $this->sendResponse(new UserResource(User::where('phone', $request->phone)->first()), "User registered successfully");
            // return $this->sendMessage("User registered successfully");
          }

          // return response()->json([
          //     'message' => 'User registered  ',
          //     // 'access_token' => $accessToken,
          // ]);
        } catch (\Throwable $th) {
          // throw $th;
          // return $this->sendError("Otp not send", $th->getMessage());
          $response = [
            'message' => 'User Not registered successfully',
            // 'user_id' => 0,
            'mobile' => "",
            'status' => "failure",
          ];
          return response()->json($response, 400);
          // return response()->json([
          //     'message' => $th->getMessage(),
          //     // 'access_token' => $accessToken,
          // ]);
        }
      }
    }
    // return "done";

    return $this->sendError("Enter phone or email.");

    // return "done";F
    // Create a new user record in the database
  }

  public function send_otp(Request $request)
  {
    $request->validate([
      'mobile' => 'required|numeric',
      'country_code' => 'required|numeric'
    ]);

    $mobileNumber = $request->input('mobile');
    $countryCode = $request->input('country_code');
    $e164Mobile = $countryCode . $mobileNumber;
    $otp = rand(1000, 9999); // Generate a random OTP

    try {
      if ($countryCode == '91') {
        // Send OTP using MSG91 for Indian numbers
        $client = new Client();
        $response = $client->post('https://api.msg91.com/api/v5/otp', [
          'json' => [
            'authkey' => $this->msg91ApiKey,
            'mobile' => $e164Mobile,
            'otp' => $otp,
            'template_id' => $this->otpTemplateId,
          ],
          'headers' => [
            'Content-Type' => 'application/json',
          ],
        ]);

        if ($response->getStatusCode() == 200) {
          $body = json_decode($response->getBody(), true);
          if ($body['type'] == 'success') {
            return $this->handleUserOtp($mobileNumber, $countryCode, $otp, $request);
          } else {
            return response()->json(['error' => 'Failed to send OTP via MSG91: ' . $body['message']], 400);
          }
        } else {
          return response()->json(['error' => 'HTTP error: ' . $response->getStatusCode()], 500);
        }
      } else {
        // Send OTP using Twilio for non-Indian numbers
        $twilioClient = new TwilioClient($this->twilioSid, $this->twilioAuthToken);
        $message = $twilioClient->messages->create(
          $e164Mobile,
          [
            'from' => $this->twilioFrom,
            'body' => 'Your OTP is ' . $otp
          ]
        );

        if ($message->sid) {
          return $this->handleUserOtp($mobileNumber, $countryCode, $otp, $request);
        } else {
          return response()->json(['error' => 'Failed to send OTP via Twilio'], 500);
        }
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
    }
  }

  private function handleUserOtp($mobileNumber, $countryCode, $otp, $request)
  {
    // Save the OTP in the user's record if the user exists
    if (User::where('mobile', $mobileNumber)->where('country_code', $countryCode)->exists()) {
      $deviceToken = $request->input('device_token', null);

      $user = User::where('mobile', $mobileNumber)->where('country_code', $countryCode)->first();
      $country_flag = $request->input('country_flag', null);
      $lat = $request->input('lat', null);
      $lon = $request->input('lon', null);
      $people_id = $request->input('people_id', $user->people_id);

      User::where('mobile', $mobileNumber)->where('country_code', $countryCode)->update(['otp' => $otp, 'device_token' => $deviceToken, 'country_flag' => $country_flag, 'latitude' => $lat, 'longitude' => $lon, 'people_id' => $people_id]);

      $user = User::where('mobile', $mobileNumber)->where('country_code', $countryCode)->first();
      return response()->json([
        'response_code' => "1",
        'message' => 'OTP sent successfully!',
        'mobile' => $user->mobile,
        'status' => 'success',
      ], 200);
    } else {
      // Create a new user record if it doesn't exist

      $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $refer_code = '';
      $max = strlen($characters) - 1;

      for ($i = 0; $i < 7; $i++) {
        $refer_code .= $characters[mt_rand(0, $max)];
      }

      $user_refer_code = $request->input('user_refer_code');
      User::create([
        'mobile' => $mobileNumber,
        'otp' => $otp,
        'country_code' => $countryCode,
        'device_token' => $request->input('device_token'),
        'login_type' => $request->input('login_type', 'mobile'),
        'latitude' => $request->input('lat'),
        'longitude' => $request->input('lon'),
        'people_id' => $request->input('people_id'),
        'refer_code' => $refer_code,
        'user_refer_code' => $user_refer_code,
      ]);


      $user = User::where('mobile', $request->mobile)->first();

      if ($request->user_refer_code != '') {
        $use_refer_user = User::where('refer_code', $request->user_refer_code)->first();

        //   $users = User::where('refer_code', $request->use_refer_code)->first();


        if ($use_refer_user) {

          $userReferal = [
            'user_id' => $user->id,
            'refer_code' => $refer_code,
            'user_refer_code' => $request->user_refer_code,
            'use_refer_code_by' => $use_refer_user->id,
          ];
          UserReferal::create($userReferal);

          $total_amount = User::where('id', $user->id)->first();

          User::where('id', $user->id)->update([
            'wallet_balance' => 20 + $total_amount->wallet_balance
          ]);

          $total_amount_done = User::where('id', $use_refer_user->id)->first();

          User::where('id', $use_refer_user->id)->update([
            'wallet_balance' => 20 + $total_amount_done->wallet_balance
          ]);
        }
      }

      $user = User::where('mobile', $mobileNumber)->where('country_code', $countryCode)->first();
      return response()->json([
        'response_code' => "1",
        'message' => 'User registered and OTP sent successfully!',
        'mobile' => $user->mobile,
        'status' => 'success',
      ], 200);
    }
  }


  public function check_otp(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'mobile' => 'required',
      'otp' => 'required',
    ]);
    if ($validator->fails()) {

      return $this->sendError("Enter this field", $validator->errors(), 422);
      //     return response()->json([
      //         'errors' => $validator->errors(),
      //     ], 422); // Return a HTTP status code 422 (Unprocessable Entity)
    }

    try {
      // $phone = $request->input('phone');
      // $otp = $request->input('otp');
      // $where = 'mobile_no="' . $mob_no . '"';
      // $user_data = $this->User_api_model->getById3($where, 'users');
      $user = User::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
      $token =  $user->createToken('MyAuthApp')->accessToken;
      $user_id = $user->id;
      $user_role = $user->user_role;

      if (!empty($user)) {

        User::where('mobile', $request->mobile)->where('otp', $request->otp)->update(['mobile_verified_otp' => "1"]);
        //  $user = User::where('mobile', $request->mobile)->where('otp', $request->otp)->update();
        // return $this->sendResponse(new UserResource($user),"Successfully login");
        // return $this->sendResponse(new UserInterResource($user), "Successfully login");

        $response = [
          'responseCode' => "1",
          'status' => 'success',
          'message' => 'User Login Successfully',
          'mobile' => $request->mobile,
          'user_id' => (string)$user_id,
          'token' => $token,
          'user_role' => $user_role ?? "",
          'email' => $user->email ?? "",
          'people_id' => (string)$user->people_id ?? "",
          // 'data' => new UserInterResource($user),
          // 'about' => new UseraboutResource($user),
        ];
        return response()->json($response);

        //  'data' => new UserInterResource($user),
      } else {
        // return response()->json(['error' => "Invalid otp..!"]);
        // return $this->sendError("Invalid otp");
        $response = [
          'responseCode' => "0",
          'status' => 'failure',
          'message' => 'User Login Not Successfully',
          'mobile' => $request->mobile,
          'user_id' => "0",
          'token' => "",
          'user_role' => "",
          'email' => "",
          'people_id' => "",
          // 'data' => new UserInterResource($user),
          // 'about' => new UseraboutResource($user),
        ];
        return response()->json($response);
      }
      // print_r($user_data); 
      // echo $user_data['mobile_no'];
      // if (isset($user_data['mobile_no'])) {echo"yes";}else{echo "no";}

      // exit;
    } catch (\Throwable $th) {
      //throw $th;
      // return $this->sendError("Mobile not Register", $th->getMessage());
      // return response()->json([
      //     'message' => $th->getMessage(),
      //     // 'access_token' => $accessToken,
      // ]);

      $response = [
        'responseCode' => "0",
        'status' => 'failure',
        'message' => 'User Login Not Successfully',
        'mobile' => $request->mobile,
        'user_id' => "0",
        'token' => "",
        'user_role' => "",
        'email' => "",
        'people_id' => "",
        // 'data' => new UserInterResource($user),
        // 'about' => new UseraboutResource($user),
      ];
      return response()->json($response);
    }
  }

  public function user_update_status(Request $request)
  {
    $validator = Validator::make($request->all(), [
      // 'user_id' => 'required',
      // 'device_token' => 'required',
    ]);
    if ($validator->fails()) {

      return $this->sendError("Enter this field", $validator->errors(), 422);
    }

    $user_id = Auth::user()->token()->user_id;
    // $user_role = Auth::user()->token()->user_role;
    $user_role = $request->user_role;
    $people_id = $request->people_id;

    $device_token = $request->input('device_token');
    // $device_token = $request->input('device_token');

    try {
      // $phone = $request->input('phone');
      // $otp = $request->input('otp');
      // $where = 'mobile_no="' . $mob_no . '"';
      $data = array(
        "device_token" => $device_token,
        "user_role" => $user_role,
        "people_id" => $people_id,
      );
      User::where('id', $user_id)->update($data);

      // $approve = Chat::where('to_user', $request->user_id)->where('message_read', '0')->count();

      $temp = [
        "response_code" => "1",
        "message" => "User Status Update successfully",
        "status" => "success",
        // "unread_count" => $approve,
      ];

      return response()->json($temp);

      // return $this->sendMessage("User Online Update successfully");
      // print_r($user_data); 
      // echo $user_data['mobile_no'];
      // if (isset($user_data['mobile_no'])) {echo"yes";}else{echo "no";}

      // exit;
    } catch (\Throwable $th) {
      //throw $th;
      return $this->sendError("User not Successfully", $th->getMessage());
      // return response()->json([
      //     'message' => $th->getMessage(),
      //     // 'access_token' => $accessToken,
      // ]);
    }
  }

  public function new_handyman_add_by_provider(Request $request)
  {
    // dd($request->all());

    $user_id = Auth::user()->token()->user_id;
    $validator = Validator::make($request->all(), [
      'firstname' => 'required',
      'lastname' => 'required',
      // 'email' => 'required|email|unique:users',
      'email' => 'required',
      // 'password' => 'required|min:8',
      'password' => 'required',
      // 'confirm_password' => 'required|same:password',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Error validation', $validator->errors());
    }




    $input = $request->all();
    if (User::where('email', $input['email'])->exists()) {
      // return $this->sendError('Email Already Register..!');
      $response = [
        'responseCode' => "0",
        'message' => 'Email Already Register..!',
        'status' => 'failure',
      ];
      return response()->json($response);
    }
    $input['password'] = bcrypt($input['password']);

    $mobile = $request->input('mobile');
    // $user_role = $request->input('user_role');
    $input['user_role'] = "Handyman";
    $input['provider_id'] = $user_id;
    $input['login_type'] = "email";
    $input['people_id'] = "2";
    // $login_type = $request->input('login_type');
    $country_code = $request->input('country_code');
    $country_flag = $request->input('country_flag');
    $mobile = $request->input('mobile');
    // $main_password = $request->input('password');

    $input['main_password'] = $request->input('password');

    $user = User::create($input);
    $success['token'] =  $user->createToken('MyAuthApp')->accessToken;

    //  $token = $user->createToken('MyAuthApp')->accessToken;
    $success['id'] =  $user->id;


    $success['name'] =  $user->firstname;
    $success['user_role'] =  $user->user_role;

    $done['branch_name'] = $request->input('branch_name');
    $done['bank_name'] = $request->input('bank_name');
    $done['acc_number'] = $request->input('acc_number');
    $done['ifsc_code'] = $request->input('ifsc_code');
    $done['mobile_number'] = $request->input('mobile_number');
    $done['user_id'] = $user->id;
    $done['provider_id'] = $user_id;

    $provider = Bankdetails::create($done);

    return $this->sendResponse($success, 'User created successfully.');
  }

  public function email_check_otp(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required',
      'otp' => 'required',
    ]);
    if ($validator->fails()) {

      return $this->sendError("Enter this field", $validator->errors(), 422);
      //     return response()->json([
      //         'errors' => $validator->errors(),
      //     ], 422); // Return a HTTP status code 422 (Unprocessable Entity)
    }

    try {
      // $phone = $request->input('phone');
      // $otp = $request->input('otp');
      // $where = 'mobile_no="' . $mob_no . '"';
      // $user_data = $this->User_api_model->getById3($where, 'users');
      $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
      // $token =  $user->createToken('MyAuthApp')->accessToken;
      // $user_id = $user->id;
      // $username = $user->username;

      $token = $user->createToken('MyAuthApp')->accessToken;
      $id =  $user->id;
      $name =  $user->firstname;
      $user_role =  $user->user_role;
      $people_id = $user->people_id;


      if (!empty($user)) {

        User::where('email', $request->email)->update(['otp_status' => "1"]);
        // update(['otp_status' => "1"]);

        // return $this->sendResponse(new UserResource($user),"Successfully login");
        // return $this->sendResponse(new UserInterResource($user), "Successfully login");

        return response()->json([
          'response_code' => "1",
          'message' => 'Otp Verified Successfully',
          'status' => 'success',
          // 'user' => new LoginResource($user),
          // 'user' => new LoginResource($user),
          // // 'user' => new UserResource($user),
          'token' => $token,
          'id' => $id,
          'name' => $name,
          'user_role' => $user_role,
          'people_id' => (string)$people_id,
        ]);

        // $response = [
        //     'responseCode' => "1",
        //     'status' => 'success',
        //     'message' => 'Login Successfully',
        //     'phone' => $request->phone,
        //     'user_id' => (string)$user_id,
        //     'username' => $username ?? "",
        //     'token' => $token,
        //     'user' => new LoginResource($user),
        //     // 'data' => new UserInterResource($user),
        //     // 'about' => new UseraboutResource($user),
        // ];
        // return response()->json($response);

        //  'data' => new UserInterResource($user),
      } else {
        // return response()->json(['error' => "Invalid otp..!"]);
        // return $this->sendError("Invalid otp");
        $response = [
          'responseCode' => "0",
          'message' => 'Otp is Not Correct',
          'status' => 'failure',

          // 'phone' => $request->phone,
          // 'user_id' => "0",
          // 'username' => "",
          // 'token' => "",
          // 'data' => new UserInterResource($user),
          // 'about' => new UseraboutResource($user),
        ];
        return response()->json($response);
      }
      // print_r($user_data); 
      // echo $user_data['mobile_no'];
      // if (isset($user_data['mobile_no'])) {echo"yes";}else{echo "no";}

      // exit;
    } catch (\Throwable $th) {
      //throw $th;
      // return $this->sendError("Mobile not Register", $th->getMessage());
      // return response()->json([
      //     'message' => $th->getMessage(),
      //     // 'access_token' => $accessToken,
      // ]);

      $response = [
        'responseCode' => "0",
        'message' => 'Otp is Not Correct',
        'status' => 'failure',

        // 'phone' => $request->phone,
        // 'user_id' => "0",
        // 'username' => "",
        // 'token' => "",
        // 'data' => new UserInterResource($user),
        // 'about' => new UseraboutResource($user),
      ];
      return response()->json($response);
    }
  }

  public function my_referalcode_list(Request $request)
  {
    $user_id = Auth::user()->token()->user_id;

    $notifications = UserReferal::where('use_refer_code_by', $user_id)->get();

    $list_notification = [];

    foreach ($notifications as $notification) {
      $questions_list['user_id'] = (string)$notification->user_id ?? "";
      $questions_list['user_refer_code'] = $notification->user_refer_code ?? "";
      $questions_list['name'] = $notification->name ?? "";
      $questions_list['use_refer_code_by'] = (string)$notification->use_refer_code_by ?? "";
      $questions_list['created_at'] = $notification->created_at ?? "";

      if (!empty($notification->user_id)) {
        $user = User::where('id', $notification->user_id)->first();

        $questions_list['name'] = $user->firstname . ' ' . $user->lastname;

        $questions_list['profile_pic'] =  $user->profile_pic ? url('public/images/user/' . $user->profile_pic) : "";
      } else {

        $questions_list['name'] = "";
        $questions_list['profile_pic'] = "";
      }

      $list_notification[] = $questions_list;
    }



    if (!empty($list_notification)) {
      $result['response_code'] = "1";
      $result['message'] = "My Referalcode List Found";
      $result['all_referalcode_list'] = $list_notification;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "My Referalcode List Not Found";
      $result['all_referalcode_list'] = [];
      $result["status"] = "failure";
    }

    return response()->json($result);
  }
  public function social_send_otp(Request $request)
  {
    $request->validate([
      'mobile' => 'required|numeric',
      'country_code' => 'required|numeric'
    ]);
    $user_id = Auth::user()->token()->user_id;

    $mobileNumber = $request->input('mobile');
    $countryCode = $request->input('country_code');
    $e164Mobile = $countryCode . $mobileNumber;
    $otp = rand(1000, 9999); // Generate a random OTP

    try {
      if ($countryCode == '91') {
        // Send OTP using MSG91 for Indian numbers
        $client = new Client();
        $response = $client->post('https://api.msg91.com/api/v5/otp', [
          'json' => [
            'authkey' => $this->msg91ApiKey,
            'mobile' => $e164Mobile,
            'otp' => $otp,
            'template_id' => $this->otpTemplateId,
          ],
          'headers' => [
            'Content-Type' => 'application/json',
          ],
        ]);

        if ($response->getStatusCode() == 200) {
          $body = json_decode($response->getBody(), true);
          if ($body['type'] == 'success') {
            return $this->handleUserOtp($mobileNumber, $countryCode, $otp, $request);
          } else {
            return response()->json(['error' => 'Failed to send OTP via MSG91: ' . $body['message']], 400);
          }
        } else {
          return response()->json(['error' => 'HTTP error: ' . $response->getStatusCode()], 500);
        }
      } else {
        // Send OTP using Twilio for non-Indian numbers
        $twilioClient = new TwilioClient($this->twilioSid, $this->twilioAuthToken);
        $message = $twilioClient->messages->create(
          $e164Mobile,
          [
            'from' => $this->twilioFrom,
            'body' => 'Your OTP is ' . $otp
          ]
        );

        if ($message->sid) {
          return $this->handleUserOtpDone($user_id, $mobileNumber, $countryCode, $otp, $request);
        } else {
          return response()->json(['error' => 'Failed to send OTP via Twilio'], 500);
        }
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
    }
  }

  private function handleUserOtpDone($user_id, $mobileNumber, $countryCode, $otp, $request)
  {
    // Save the OTP in the user's record if the user exists
    if (User::where('id', $user_id)->exists()) {

      User::where('id', $user_id)->update(['otp' => $otp, 'mobile' => $mobileNumber, 'country_code' => $countryCode]);

      $user = User::where('mobile', $mobileNumber)->where('country_code', $countryCode)->first();
      return response()->json([
        'response_code' => "1",
        'message' => 'OTP sent successfully!',
        'mobile' => $user->mobile,
        'status' => 'success',
      ], 200);
    }
  }
  public function validatePurchase(Request $request)
  {
    try {
      $purchaseCode = $request->input('purchase_code');
      $username = $request->input('username');

      $response = Http::withHeaders([
        "Content-Type" => "application/json",
        "Accept" => "application/json",
        "User-Agent" => "Your User Agent",
        "X-MAC-Address" => $this->getMacAddress(),
        "X-Device-IP" => $this->getServerIP(),
      ])->post("https://validator.whoxachat.com/validate", [
        "purchase_code" => $purchaseCode,
        "username" => $username,
      ]);

      $data = $response->json();

      // dd($data);
      // Log::error('Validation API Response:', $data);

      if (isset($data['error']) && str_contains($data['error'], 'Deactivate')) {
        return response()->json(['error' => 'The license is already activated on another machine. Please deactivate it first.'], 400);
      }

      if (in_array($data['status'], ['used', 'error', 'invalid'])) {
        return response()->json(['error' => $data['message']], 400);
      }

      $token = $data['token'];
      File::put(storage_path('app/validatedToken.txt'), $token);

      SiteSetup::where('id', "1")->update(['purchase_code' => $purchaseCode]);

      return response()->json(['message' => 'Validation successful!', 'token' => $token]);
    } catch (\Exception $e) {
      // Log::error('Validation Error:', ['exception' => $e->getMessage()]);
      return response()->json(['error' => 'Validation failed!'], 400);
    }
  }

  private function getMacAddress()
  {
    return exec('getmac');
  }

  private function getServerIP()
  {
    return request()->ip();
  }

  public function verifyToken()
  {
    try {
      // die('API verifyToken method reached!');
      // Path to the token file
      $tokenFilePath = storage_path('app/validatedToken.txt');

      // Check if the file exists
      if (!File::exists($tokenFilePath)) {
        // Log::error("Token file not found: " . $tokenFilePath);
        return response()->json(['error' => 'Token file not found.'], 400);
      }

      // Read the token from the file
      $token = File::get($tokenFilePath);

      // Send verification request
      $response = Http::post("https://validator.whoxachat.com/verify_new", [
        "server_ip" => $this->getServerIP(),
        "mac_address" => $this->getMacAddress(),
        "token" => trim($token), // Trim any unwanted spaces or newlines
      ]);

      $data = $response->json();

      // Log response for debugging
      // Log::info('Verification API Response:', $data);

      if (!isset($data['success']) || !$data['success']) {
        // Log::error("Token verification failed. Removing current directory...");
        return response()->json(['error' => 'Token verification failed.'], 400);
      }

      return response()->json(['message' => 'Token verification successful!', 'success' => true]);
    } catch (\Exception $e) {
      // Log::error('Verification Error:', ['exception' => $e->getMessage()]);
      return response()->json(['error' => 'Verification failed!'], 400);
    }
  }
  public function expireToken(Request $request)
  {
    try {
      // Retrieve purchase code from request
      // $purchaseCode = $request->input('purchase_code');

      // Path to the token file
      $tokenFilePath = storage_path('app/validatedToken.txt');

      // Check if the file exists
      if (!File::exists($tokenFilePath)) {
        // Log::error("Token file not found: " . $tokenFilePath);
        return response()->json(['error' => 'Token file not found.'], 400);
      }

      // Read the token from the file
      $token = File::get($tokenFilePath);

      // Send verification request
      $response = Http::post("https://validator.whoxachat.com/de-activate", [
        "server_ip" => $this->getServerIP(),
        "mac_address" => $this->getMacAddress(),
        "token" => trim($token), // Trim any unwanted spaces or newlines
      ]);

      $data = $response->json();

      // Log response for debugging
      // Log::info('Verification API Response:', $data);

      if (!isset($data['success']) || !$data['success']) {
        // Log::error("Token verification failed. Removing current directory...");
        return response()->json(['error' => 'Token verification failed.'], 400);
      }

      // If verification is successful, delete the file
      if (File::exists($tokenFilePath)) {
        File::delete($tokenFilePath);

        SiteSetup::where('id', "1")->update(['purchase_code' => ""]);
        // Log::info("Token file deleted successfully: " . $tokenFilePath);
      }

      return response()->json(['message' => 'Token verification successful and file deleted!', 'success' => true]);
    } catch (\Exception $e) {
      // Log::error('Verification Error:', ['exception' => $e->getMessage()]);
      return response()->json(['error' => 'Verification failed!'], 400);
    }
  }

  public function orderPlaced(Request $request)
  {
    try {
      //code...

      $payment_mode = $request->input('payment_mode');
      // $myId = $request->user()->token()->user_id;
      $myId = Auth::user()->token()->user_id;
      $product_subtotal = $request->input('product_subtotal');
      $service_subtotal = $request->input('service_subtotal');
      $sub_total = $request->input('sub_total');
      $total = $request->input('total');
      $coupon = $request->input('coupon');
      $tax = $request->input('tax');
      $service_charge = $request->input('service_charge');
      $mrp_sub_total = $request->input('mrp_sub_total');
      $coupon_type = $request->input('coupon_type');
      $coupon_percentage = $request->input('coupon_percentage');

      $booking_date = $request->input('booking_date');
      $booking_time = $request->input('booking_time');
      $notes = $request->input('notes');

      $total_items = 0;
      $shipping_charge = 0;
      $address = 0;
      $allItms = CartItemsModel::where('user_id', $myId)->where('checked', 0)->OrderByDesc('cart_id')->get();
      // print_r($allItms);

      if (count($allItms) <= 0) {
        return $this->sendError('Order items not found.');
      }

      $bookingTimes = str_replace("\xE2\x80\xAF", " ", $booking_time);


      if ($payment_mode == "wallet") {

        $user = User::where('id', $myId)->first();

        // Check if wallet balance is sufficient
        if ($user->wallet_balance < $total) {
          return response()->json(
            [
              'status' => false,
              'message' => 'Insufficient wallet balance...!',
            ],
            400
          );
        }

        $user->wallet_balance -= $total;
        $user->save();
      }

      $allItms_done = CartItemsModel::where('user_id', $myId)->where('checked', 0)->where('service_id', "!=", "")->first();

      if ($allItms_done) {

        $update =  CartItemsModel::where('user_id', $myId)->where('checked', 0)->where('service_id', "!=", "")->update([
          'booking_date' => $booking_date,
          'booking_time' => $bookingTimes,
          'notes' => $notes,
        ]);
      }

      // $productItms_done = CartItemsModel::where('user_id', $myId)->where('checked', 0)->where('product_id', "!=", "")->get();

      $productItms_done = CartItemsModel::join('products', 'cart_items.product_id', '=', 'products.product_id')
        ->where('cart_items.user_id', $myId)
        ->where('cart_items.checked', 0)
        ->whereNotNull('cart_items.product_id')
        ->select(
          'cart_items.*',
          'products.product_name as product_name',
          DB::raw('IF(products.product_discount_price IS NOT NULL AND products.product_discount_price > 0, products.product_discount_price, products.product_price) as product_price')
        )
        ->get();


      foreach ($allItms as $booking) {

        $booking_items['user_id'] = $booking->user_id;
        $booking_items['product_id'] = $booking->product_id;
        $booking_items['service_id'] = $booking->service_id;
        if ($booking->service_id) {

          $price = Service::where('id', $booking->service_id)->first();
          $final_price = $price->service_discount_price ? $price->service_discount_price : $price->service_price;
          $provider_id = $price->v_id;
        } else {

          $price = Product::where('product_id', $booking->product_id)->first();
          $final_price = $price->product_discount_price ? $price->product_discount_price : $price->product_price;

          $provider_id = $price->vid;


          $sub_total_done = $price->product_discount_price ? ($price->product_discount_price * $booking->quantity) : ($price->product_price * $booking->quantity);


          // $commissions_value_pro = Commissions::where('user_role', "Provider")->where('type', "Product")->first();

          // $commissions_value_pro = Commissions::where('people_id', "2")->where('type', "Product")->first();

          //     $commissions_done_pro = $commissions_value_pro->value;

          //     $calculation_pro = ($commissions_done_pro * $sub_total / 100 );

          // $prvider_new = ProviderHistory::where('provider_id', $provider_id)->first();

          // if($prvider_new)
          // {

          //     $prvider_new->update([
          //       'total_bal' => $prvider_new->total_bal + $calculation_pro,
          //       'available_bal' => $prvider_new->available_bal + $calculation_pro,
          // ]);

          // }else{

          //     ProviderHistory::create([
          //     'provider_id' => $provider_id,
          //     'total_bal' => $calculation_pro,
          //     'available_bal' => $calculation_pro,
          // ]);

          // }






        }
        $booking_items['total'] = $booking->quantity * $final_price;
        $booking_items['provider_id'] = $provider_id;
        $booking_items['payment_method'] = $booking->payment_mode;

        //   $booking = BookingOrders::create($booking_items);

        $created_at = now();

        $otp = rand(1000, 9999);

        $orderItems = [
          'user_id' => $myId,
          'product_id' => $booking->product_id,
          'service_id' => $booking->service_id,
          'payment' => $booking->quantity * $final_price,
          'provider_id' => $provider_id,
          'payment_method' => $payment_mode,
          'cart_id' => $booking->cart_id,
          'created_at' => $created_at,
          'updated_at' => $created_at,
          'otp' => $otp,
          'location' => $booking->address_id,
        ];

        // $newBookingOrder = BookingOrders::insert($orderItems);

        $newBookingOrder = BookingOrders::create($orderItems);

        $newBookingOrderId = $newBookingOrder->id;

        $booking_id = $newBookingOrderId;

        $provider_id_done = BookingOrders::where('id', $newBookingOrderId)->first();


        $pro_id = $provider_id_done->provider_id;

        $FcmToken = User::where('id', $pro_id)->value('device_token');

        $customer = User::where('id', $myId)->first();

        $customer_name = $customer->firstname;


        $proviver_all_noti = NotificationsPermissions::where('id', "23")->where('status', "1")->first();


        if ($booking->product_id == "") {
          $type = "Service";
          $booking_services_name =  Service::where('id', $booking->service_id)->value('service_name');
        } else {
          $type = "Product";
          $booking_services_name =  Product::where('product_id', $booking->product_id)->value('product_name');
        }

        // Replace placeholders with actual values
        $message = str_replace(
          ['[[ booking_id ]]', '[[ booking_services_name ]]', '[[ customer_name ]]'],
          ['#' . $booking_id, $booking_services_name, $customer_name],
          $proviver_all_noti->description
        );


        $data = [
          // 'title' => $type . $proviver_all_noti->title,
          'title' => $proviver_all_noti->title,
          'message' => '#' . $newBookingOrderId . $proviver_all_noti->description,
          // 'message' => '#'.$newBookingOrderId . ' ' . $proviver_all_noti->description,
          'message' => $message,
          'type' => $type,
          'booking_id' => $newBookingOrderId,
          'order_id' => 0,
        ];
        // $now = now();

        if ($FcmToken) {

          $this->sendNotification(new Request($data), $FcmToken);
        } else {

          // \Log::warning("Provider with ID {$provider_id_done} has no valid device token.");
        }


        // Replace placeholders with actual values
        // $message = str_replace(
        //     ['[[ booking_id ]]'],
        //     ['#' . $booking_id],
        //     $proviver_all_noti->description
        // );


        $not_all_done = [
          'booking_id' => $newBookingOrderId,
          'handyman_id' => 0,
          'provider_id' => $pro_id,
          // 'user_id' => $myId,
          // 'title' => $type . $proviver_all_noti->title,
          'title' => $proviver_all_noti->title,
          // 'message' => "Booking Id #$newBookingOrderId .$proviver_all_noti->description",
          'message' => $message,
          'type' => $type,
          'created_at' => now(),
        ];

        $done = DB::table('user_notification')->insert($not_all_done);

        $user_all_noti = NotificationsPermissions::where('id', "1")->where('status', "1")->first();

        $message = str_replace(
          ['[[ booking_id ]]'],
          ['#' . $booking_id],
          $user_all_noti->description
        );
        $userFcmToken = User::where('id', $myId)->value('device_token');

        $notificationData = [
          'title' => $user_all_noti->title,
          // 'message' => "Your Booking Id #$newBookingOrderId successfully placed.",
          'message' => $message,
          'type' => $type,
          'booking_id' => $newBookingOrderId,
          'order_id' => 0,
        ];

        if ($userFcmToken) {

          $this->sendNotification(new Request($notificationData), $userFcmToken);
        } else {

          // \Log::warning("User with ID {$myId} has no valid device token.");
        }





        $not_all = [
          // 'booking_id' => "0",
          'booking_id' => $newBookingOrderId,
          'handyman_id' => "0",
          'provider_id' => "0",
          'user_id' => $myId,
          'title' => $user_all_noti->title,
          // 'message' => "Your Booking Id #$newBookingOrderId successfully placed.",
          'message' => $message,
          'type' => $type,
          'created_at' => now(),
        ];

        $done = DB::table('user_notification')->insert($not_all);
      }

      //   $commissions_value_pro = Commissions::where('user_role', "Provider")->where('type', "Product")->first();

      //     $commissions_done_pro = $commissions_value_pro->value;

      //     $calculation_pro = ($commissions_done_pro * $product_subtotal / 100 );

      //     $prvider_new = ProviderHistory::where('provider_id', $provider_id)->first();

      //     if($prvider_new)
      //     {

      //         $prvider_new->update([
      //           'total_bal' => $prvider_new->total_bal + $calculation_pro,
      //           'available_bal' => $prvider_new->available_bal + $calculation_pro,
      //     ]);

      //     }else{

      //         ProviderHistory::create([
      //         'provider_id' => $provider_id,
      //         'total_bal' => $calculation_pro,
      //         'available_bal' => $calculation_pro,
      //     ]);

      //     }

      // $sub_total_done = $product_subtotal + $service_subtotal - $coupon;

      $orderDetails = array(
        'user_id' => $myId,
        'total' => $total,
        'shipping_charge' => $shipping_charge,
        'product_subtotal' => $product_subtotal,
        'service_subtotal' => $service_subtotal,
        // 'sub_total' => $sub_total_done,
        'sub_total' => $sub_total,
        'coupon' => $coupon,
        'service_charge' => $service_charge,
        'tax' => $tax,
        'items' => $total_items,
        'payment_mode' => $payment_mode,
        'address' => $address,
        'number' => UserAddressModel::select('phone')->where('address_id', $address)->exists() ? UserAddressModel::select('phone')->where('address_id', 4)->first()->phone : "0",
        'mrp_sub_total' => $mrp_sub_total,
        // 'txn_id' => ,
        'p_status' => "1",
        'p_date' => now(),
        'order_status' => 0,
        // 'sales_id' => ,
        'erning_status' => 0,
        'order_otp' => rand(100000, 999999),
        'coupon_type' => $coupon_type,
        'coupon_percentage' => $coupon_percentage,
      );
      $orderID = OrdersModel::create($orderDetails);


      //   $commissions_value_pro = Commissions::where('user_role', "Provider")->where('id', "3")->first();

      //     $commissions_done_pro = $commissions_value_pro->value;

      //     $calculation_pro = ($commissions_done_pro * $product_subtotal / 100 );


      //      BookingProviderHistory::create([
      //         'handyman_id' => 0,
      //         'provider_id' => $provider_id,
      //         'booking_id' => 0,
      //         'amount' => $calculation_pro,
      //         'service_id' => 0,
      //         'user_id' => $myId,
      //         'commision_persontage' => $commissions_done_pro,
      //     ]);



      // $email =  User::where('id', $myId)->first();
      // $toEmail = $email->email;

      // $order_id = $orderID->id;


      // $sale_price = $sub_total;
      // $total_payment = $sale_price + $shipping_charge;
      // $mailData = $total_payment;

      $allItm = CartItemsModel::where('user_id', $myId)->where('checked', 0)->OrderByDesc('cart_id')->first();
      // $vendor_id = $allItm->vendor_id;

      // $email_done =  User::where('id', $vendor_id)->first();
      // $toEmails = $email_done->email;
      // $to_name = $email_done->name;
      $address_id = $allItm->address_id;

      // $user_name =  User::where('id', $myId)->first();
      // $my_name = $user_name->firstname;

      // $address = UserAddressModel::where('address_id', $address_id)->first();
      // $add_name = $address->address;
      // $landmark = $address->landmark;
      // $area_name = $address->area_name;
      // $city = $address->city;
      // $state = $address->state;
      // $country = $address->country;
      // $zip_code = $address->zip_code;

      // $addressString = $add_name . ', ' . $landmark . ', ' . $area_name . ', ' . $city . ', ' . $state . ', ' . $country . ', ' . $zip_code;




      // $product_name = $product->product_name;


      // //    print_r($mailData);
      // //    die;

      $user_all_done =  User::where('id', $myId)->first();
      $email = $user_all_done->email;
      $firstname = $user_all_done->firstname;

      // $order_date = Carbon::now()->format('d M, Y - h:i A');

      $order_date = now();

      $order_id = $orderID->id;

      // $emailPreference = UserEmailOrderPlacedService::where('get_email', 1)->first();

      // if ($emailPreference) {
      //     // Send email on successful OTP verification
      //     Mail::to($email)->send(
      //         new UserOrderPlacedService($email, $product_subtotal, $service_subtotal, $sub_total, $total, $coupon, $tax, $service_charge, $firstname, $order_id, $order_date, $addressString, $my_name, $allItms_done, $booking_services_name, $final_price, $productItms_done)
      //     );
      // }

      // $mail = Mail::to($toEmail)->send(new UserSide($mailData, $sale_price, $sub_total, $shipping_charge, $currency, $product_name, $add_name, $my_name, $order_id, $total_items, $to_name, $addressString));
      // $mail = Mail::to($toEmails)->send(new VendorSide($mailData, $sale_price, $sub_total, $shipping_charge, $currency, $product_name, $addressString, $to_name, $order_id, $total_items, $my_name));
      if ($orderID) {

        CartItemsModel::where('user_id', $myId)->where('checked', 0)->update([
          'checked' => true,
          'order_id' => $orderID->id,
        ]);
        // return $this->sendMessage('Order Placed success.');


        $fromUser = User::where('id', $myId)->value('firstname');

        $order_id = $orderID->id;

        $type = "Order";


        // Prepare the data for the notification User ne

        // Call the sendNotification method from BaseController
        // $this->sendNotification(new Request($data), $FcmToken);

        //   $userFcmToken = User::where('id', $myId)->value('device_token');

        //   $notificationData = [
        //     'title' => "Order Placed",
        //     'message' => "Your Booking Id #$order_id successfully placed.",
        //     'type' => $type,
        //     'booking_id' => 0,
        //     'order_id' => $order_id,
        // ];

        //  if ($userFcmToken) {

        //     $this->sendNotification(new Request($notificationData), $userFcmToken);
        //      }else{

        //          \Log::warning("User with ID {$myId} has no valid device token.");
        //      }





        //  $not_all = [
        //     'booking_id' => "0",
        //     'booking_id' => $newBookingOrderId,
        //     'handyman_id' => "0",
        //     'provider_id' => $provider_id,
        //     'user_id' => $myId,
        //     'title' => "Order Placed",
        //     'message' => "Your Booking Id #$order_id successfully placed.",
        //     'type' => "Order",
        //     'created_at' => now(),
        // ];

        // $done = DB::table('user_notification')->insert($not_all);


        // $commissions_value_pro = Commissions::where('user_role', "Provider")-where('id', "3")->first();

        // $commissions_done_pro = $commissions_value_pro->value;

        // $calculation_pro = ($commissions_done_pro * $product_subtotal / 100 );


        //  BookingProviderHistory::create([
        //     'handyman_id' => 0,
        //     'provider_id' => $provider_id,
        //     'booking_id' => 0,
        //     'amount' => $calculation_pro,
        //     'service_id' => 0,
        //     'user_id' => $user_id,
        //     'commision_persontage' => $commissions_done_pro,
        // ]);

        if (!empty($orderID)) {
          $result['response_code'] = "1";
          $result['message'] = "Order Placed success.";
          $result['order_id'] = $orderID->id;
          $result['payment_mode'] = $payment_mode;
          $result['total'] = $total;
          $result["status"] = "success";
          return response()->json($result);
        }
      } else {
        return $this->sendError('Failed.');
      }
    } catch (\Throwable $th) {
      //throw $th;
      // dd($th);
      return $this->sendError('SolveThisError', $th->getMessage());
    }
  }
}
