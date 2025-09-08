<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ReelResource;
use App\Http\Resources\UserAddressRes;
use App\Http\Resources\TagResource;
use App\Http\Resources\CartRes;
use App\Http\Resources\CartSerRes;
use App\Http\Resources\SupportchatResouece;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Models\BookingOrders;
use App\Models\CartItems;
use App\Models\OrdersModel;
use App\Models\Review;
use App\Models\ServiceProof;
use App\Models\user_notification;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Models\ProductReview;
use App\Models\Profile_blocklist;
use App\Models\Comment_report;
use App\Models\Reel;
use App\Models\Reel_Comment;
use App\Models\Reel_Like;
use App\Models\post_user_tag;
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
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ServiceLike;
use App\Models\ProductLike;
use App\Models\ProviderLike;
use App\Models\ProductCategory;
use App\Models\UserAddressModel;
use App\Models\Coupon;
use App\Models\CartItemsModel;
use App\Models\SupportChat;
use App\Models\SupportChatstatus;
use App\Models\Ticket;
use App\Models\Faq;
use App\Models\BookingOrdersStatus;
use Stripe;
use Stripe\PaymentIntent;
use Stripe\Stripe as StripeStripe;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\Commissions;
use App\Models\BookingHandymanHistory;
use App\Models\Bankdetails;
use App\Models\ProviderHistory;
use App\Models\BookingCancelOrder;
use App\Models\NotificationsPermissions;
use App\Models\HandymanReview;
use App\Models\BookingProviderHistory;
use App\Models\AddonProduct;
use App\Models\Chat;
use App\Models\PaymentGatewayKey;
use App\Models\UserLoginStatus;
use App\Models\UserEmailForgotPassword;
use App\Mail\UserForgotPassword;
use App\Models\HandymanEmailBookingAccepted;
use App\Mail\HandymanBookingAccepted;
use App\Models\HandymanEmailBookingRejected;
use App\Mail\HandymanBookingRejected;
use App\Models\HandymanEmailBookingCompleted;
use App\Mail\HandymanBookingCompleted;
use App\Models\HandymanEmailReviewReceived;
use App\Mail\HandymanReviewReceived;
use App\Models\ProviderEmailBookingAccepted;
use App\Mail\ProviderBookingAccepted;
use App\Models\ProviderEmailBookingRejected;
use App\Mail\ProviderBookingRejected;
use App\Models\ProviderEmailBookingHold;
use App\Mail\ProviderBookingHold;
use App\Models\ProviderEmailBookingCompleted;
use App\Mail\ProviderBookingCompleted;
use App\Models\ProviderEmailOrderInProgress;
use App\Mail\ProviderOrderInProgress;
use App\Models\ProviderEmailPaymentRequestReceived;
use App\Mail\ProviderPaymentRequestReceived;
use App\Models\ProviderEmailReviewReceived;
use App\Mail\ProviderReviewReceived;
use App\Models\UserEmailBookingHold;
use App\Mail\UserBookingHold;
use App\Models\UserEmailBookingInProgress;
use App\Mail\UserBookingInProgress;
use App\Models\UserEmailOrderPlacedService;
use App\Mail\UserOrderPlacedService;
use App\Models\PeopoleRole;
use App\Models\DefaultImage;
use App\Mail\ProviderForgotPassword;
use App\Models\ProviderEmailForgotPassword;
use App\Mail\HandymanForgotPassword;
use App\Models\HandymanEmailForgotPassword;
use App\Models\SiteSetup;
use App\Models\NearbyDistance;
use App\Models\ProviderEmailRejectHandyman;
use App\Mail\ProviderRejectHandyman;
use App\Models\TaxRate;
use App\Mail\UserBookingCompleted;
use App\Models\UserEmailBookingRejected;
use App\Mail\ProviderOrderCancelled;
use App\Models\ProviderEmailAssignHandyman;
use App\Models\UserRefundbyProvider;
use App\Mail\UserRefundbyallProvider;
use App\Models\ServiceImages;
use App\Models\ProductImages;
use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;
use App\Models\About;

class UserController extends BaseController
{
    public function search_users(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;
        $text = $request->input('text');

        if (empty($text)) {
            $result["response_code"] = "0";
            $result["message"] = "Users Not Found";
            $result['users'] = $users;
            $result["status"] = "failure";
            return response()->json($result);
        }

        $users = User::where('username', 'like', "%$text%")
            ->orderByDesc('id')
            ->get();

        foreach ($users as $user) {
            if (!empty($user->profile_pic)) {
                $url = explode(":", $user->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $user->profile_pic = $user->profile_pic;
                } else {
                    $user->profile_pic =  url('/images/user/' . $user->profile_pic);
                }
            } else {
                $user->profile_pic = "";
            }
        }

        if (!empty($users)) {
            $result['response_code'] = "1";
            $result['message'] = "Users Found";
            $result['users'] = $users;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Users Not Found";
            $result['users'] = $users;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function account_delete(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $user = User::where('id', $user_id)->delete();

        if ($user) {
            // $user->delete();

            $result["response_code"] = "1";
            $result["message"] = "Users all data deleted sucess..!";
            $result["status"] = "sucess";
            // return json_encode($result);
            return response()->json($result);

            // return response()->json(['message' => 'User account deleted successfully']);
        } else {
            // return response()->json(['message' => 'User already deleted']);
            $result["response_code"] = "0";
            $result["message"] = "Data base error.. User not deleted..!";
            $result["status"] = "fail";

            return response()->json($result);
        }
    }

    public function change_password(Request $request)
    {
        $id = Auth::user()->id;

        if (!User::where('id', $id)->exists()) {
            return response()->json(['error' => "Invalid User..!"]);
        }

        if (!empty($request->password)) {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'npassword' => 'required', // Adjust the minimum length as needed
                'cpassword' => 'required|same:npassword',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $user = User::find($id);

            // if ($user && $user->password == md5($request->password)) {
            if ($user && Hash::check($request->password, $user->password)) {

                $user->update(['email_verified_at' => now(), 'password' => bcrypt($request->npassword)]);

                return $this->sendMessage('Password reset success.');
            } else {
                return $this->sendError('Invalid Password.');
            }
        }

        return $this->sendError('Password field is required.');
    }

    public function forget_pass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            // return $this->sendError($validator->errors());
            return response()->json([
                'success' => false,
                'message' => 'Email not found...!'
            ]);
        }

        if (!User::where('email', $request->email)->exists()) {
            // return response()->json(['error' => "Invalid Email id..!"]);
            return response()->json([
                'success' => false,
                'message' => 'Email not found...!'
            ]);
        }

        if (!empty($request->email)) {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                // 'otp' => 'required',
                // 'password' => 'required',
                // 'cnf_pass' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $confirmationCode = rand(10000, 999999);

            //  print_r($confirmationCode);

            if (User::where('email', $request->email)->exists()) {
                User::where('email', $request->email)->update(['email_verified_at' => now(), 'password' => bcrypt($confirmationCode)]);

                return $this->sendMessage('Password reset success.');
            } else {
                return $this->sendError('Invelid otp.');
            }
        }

        //send mail
        $confirmationCode = rand(1000, 9999);
        $toEmail = $request->email;

        $mailData = array('code' => $confirmationCode);
        try {
            if (Mail::to($toEmail)->send(new ForgetPass($mailData))) {
                User::where('email', $request->email)->update(['password' => $confirmationCode]);
                return $this->sendResponse("", "Emails send successfully.");
            }
        } catch (Exception $e) {
            return $this->sendError("Email faild..", $e->getMessage());
        }
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users'
        ]);

        if ($validator->fails()) {
            // return $this->sendError('Error validation', $validator->errors());
            return response()->json([
                'success' => false,
                'message' => 'Email not found...!'
            ]);
        }

        if ($request->email != '') {
            if (!User::where('email', $request->email)->first()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not found...!'
                ]);
            } else {
                $email = $request->email;
                // $otp = Str::random(8);
                $otp = rand(1000, 9999);
                User::where('email', $request->email)->update(['verified_code' => $otp]);
                $userDetails = User::where('email', $request->email)->first();
                $messageData = ['email' => $userDetails->email, 'otp' => $otp];

                try {
                    // Mail::send('otp', $messageData, function ($message) use ($email) {
                    //     $message->to($email)->subject('Your OTP');
                    // });

                    $user = User::where('email', $request->email)->first();
                    $people_id = $user->people_id;
                    $firstname = $user->firstname;

                    if ($people_id == "3") {

                        $emailPreference = UserEmailForgotPassword::where('get_email', 1)->first();

                        if ($emailPreference) {
                            // Send email on successful OTP verification
                            Mail::to($email)->send(
                                new UserForgotPassword($email, $otp, $firstname)
                            );
                        }
                    }

                    if ($people_id == "1") {

                        $emailPreference = ProviderEmailForgotPassword::where('get_email', 1)->first();

                        if ($emailPreference) {
                            // Send email on successful OTP verification
                            Mail::to($email)->send(
                                new ProviderForgotPassword($email, $otp, $firstname)
                            );
                        }
                    }

                    if ($people_id == "2") {

                        $emailPreference = HandymanEmailForgotPassword::where('get_email', 1)->first();

                        if ($emailPreference) {
                            // Send email on successful OTP verification
                            Mail::to($email)->send(
                                new HandymanForgotPassword($email, $otp, $firstname)
                            );
                        }
                    }


                    return response()->json([
                        'success' => true,
                        'user_id' => $userDetails->id,
                        'email' => $request->email,
                        'message' => 'OTP sent successfully'
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to send OTP',
                        'error' => $e->getMessage()
                    ], 400);
                }
            }
        }
    }

    public function reset_pass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        if (!User::where('email', $request->email)->exists()) {
            return response()->json(['error' => "Invalid Email id..!"]);
        }

        if (!empty($request->email)) {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                // 'otp' => 'required',
                'password' => 'required',
                'cnf_pass' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            if (User::where('email', $request->email)->exists()) {
                User::where('email', $request->email)->update(['email_verified_at' => now(), 'password' => bcrypt($request->password)]);

                return $this->sendMessage('Password reset success.');
            } else {
                return $this->sendError('Invelid otp.');
            }
        }

        // //send mail
        // // $confirmationCode = rand(1000, 9999);
        // $toEmail = $request->email;

        // $mailData = array('code' => $confirmationCode);
        // try {
        //     if (Mail::to($toEmail)->send(new ForgetPass($mailData))) {
        //         User::where('email', $request->email)->update(['otp' => $confirmationCode]);
        //         return $this->sendResponse("", "Emails send successfully.");
        //     }
        // } catch (Exception $e) {
        //     return $this->sendError("Email faild..", $e->getMessage());
        // }
    }

    public function check_verified_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        if (!User::where('email', $request->email)->exists()) {
            return response()->json(['error' => "Invalid Email id..!"]);
        }

        if (!empty($request->otp)) {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp' => 'required',
                // 'password' => 'required',
                // 'cnf_pass' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            if (User::where('email', $request->email)->where('verified_code', $request->otp)->exists()) {
                // User::where('email', $request->email)->where('verified_code', $request->otp)->update(['email_verified_at' => now(), 'password' => bcrypt($request->password)]);

                return $this->sendMessage('Verified Code success.');
            } else {
                return $this->sendError('Invelid otp.');
            }
        }

        // //send mail
        // // $confirmationCode = rand(1000, 9999);
        // $toEmail = $request->email;

        // $mailData = array('code' => $confirmationCode);
        // try {
        //     if (Mail::to($toEmail)->send(new ForgetPass($mailData))) {
        //         User::where('email', $request->email)->update(['otp' => $confirmationCode]);
        //         return $this->sendResponse("", "Emails send successfully.");
        //     }
        // } catch (Exception $e) {
        //     return $this->sendError("Email faild..", $e->getMessage());
        // }
    }

    public function user_online(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required',
            'is_online' => 'required',
        ]);
        if ($validator->fails()) {

            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        $user_id = Auth::user()->token()->user_id;

        $is_online = $request->input('is_online');
        // $device_token = $request->input('device_token');

        try {
            // $phone = $request->input('phone');
            // $otp = $request->input('otp');
            // $where = 'mobile_no="' . $mob_no . '"';
            $data = array(
                "is_online" => $is_online,
                "updated_at" => now(),
                //  "device_token" => $device_token,
            );
            User::where('id', $user_id)->update($data);

            // $approve = Chat::where('to_user', $request->user_id)->where('message_read', '0')->count();

            $temp = [
                "response_code" => "1",
                "message" => "User Online Update successfully",
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

    public function user_update_devicetoken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required',
            'device_token' => 'required',
        ]);
        if ($validator->fails()) {

            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        $user_id = Auth::user()->token()->user_id;

        $device_token = $request->input('device_token');
        // $device_token = $request->input('device_token');

        try {
            // $phone = $request->input('phone');
            // $otp = $request->input('otp');
            // $where = 'mobile_no="' . $mob_no . '"';
            $data = array(
                "device_token" => $device_token,
                //  "device_token" => $device_token,
            );
            User::where('id', $user_id)->update($data);

            // $approve = Chat::where('to_user', $request->user_id)->where('message_read', '0')->count();

            $temp = [
                "response_code" => "1",
                "message" => "User Devicetoken Update successfully",
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

    public function get_all_settings(Request $request)
    {

        $private_key = $request->input('private_key');
        $account_sid = "Qs8UW8(xKjv3dIPRMC";

        $category = Setting::first();

        $result["name"] = (string)$category->name;

        $result["email"] = (string)$category->email;

        $result["text"] = (string)$category->text;

        $result["color"] = (string)$category->color;

        $result["logo"] = (string)$category->logo ? url('public/assets/images/' . $category->logo) : "";

        $result["agora_key"] = (string)$category->agora_key;

        $result["notify_key"] = (string)$category->notify_key;

        $result["prv_pol_url"] = (string)$category->prv_pol_url;

        $result["tnc_url"] = (string)$category->tnc_url;

        // url('public/assets/images/1711540762.jpg');



        return $this->sendResponse($result, "Privacy Policy Done");


        // $category = PrivacyModel::select('privacy_policy','term_conditions')->first();

        // $category = $query->row();

        // $result["response_code"] = "1";

        // $result["message"] = "Privacy Policy Done";


    }

    public function booking_list(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;


        $users = BookingOrders::where('work_assign_id', $user_id)
            ->orderByDesc('id')
            ->get();

        foreach ($users as $user) {

            $date = date('d D Y', strtotime($user->created_at));

            $time = date('h:i', strtotime($user->created_at));


            $user->date = $date;
            $user->time = $time;
            $users_all = User::where('id', $user->user_id)->first();

            $user->firstname = $users_all->firstname . ' ' . $users_all->lastname;

            $all_image = DefaultImage::where('people_id', "3")->first();
            $my_image = $all_image->image;

            if (!empty($users_all->profile_pic)) {
                $url = explode(":", $users_all->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $user->profile_pic = $users_all->profile_pic;
                } else {
                    $user->profile_pic =  url('/images/user/' . $users_all->profile_pic);
                }
            } else {
                $user->profile_pic =  url('/images/user/' . $my_image);
            }
        }

        if (!empty($users)) {
            $result['response_code'] = "1";
            $result['message'] = "Users Found";
            $result['users'] = $users;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Users Not Found";
            $result['users'] = $users;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function home2(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;


        $users = BookingOrders::where('work_assign_id', $user_id)
            ->where('service_id', '!=', "")
            ->orderByDesc('id')
            ->get();

        $activeBookings = [];
        $canceledBookings = [];

        foreach ($users as $user) {

            $date = date('d D Y', strtotime($user->created_at));

            $time = date('h:i', strtotime($user->created_at));

            $users_online = Service::where('id', $user->service_id)->first();

            $user->service_name = $users_online->service_name ?? "";
            $user->cat_name = $user->cat_name ?? "";
            // $user->location = $user->location ?? "";
            $user->on_status = $user->on_status ?? "";
            $user->payment_method = $user->payment_method ?? "";
            $user->handyman_status = $user->handyman_status ?? "";
            $user->booking_status = $user->handyman_status ?? "";
            $user->date = $date;
            $user->time = $time;
            $user->created_at = $user->created_at ?? "";

            $location = $user->location;

            $users_online = CartItemsModel::where('cart_id', $user->cart_id)->first();

            $user->order_id = $users_online ? (string)$users_online->order_id : "";

            $address_data = UserAddressModel::where('address_id', $location)->first();
            if ($address_data) {
                $fields = [
                    $address_data->address,
                    $address_data->address_type,
                    $address_data->landmark,
                    $address_data->city,
                    $address_data->state,
                    $address_data->country,
                    $address_data->area_name,
                    $address_data->zip_code
                ];

                $filtered_fields = array_filter($fields);
                $user->location = implode(', ', $filtered_fields);
            } else {
                $user->location  = '';
            }

            $user->product_id = "";
            $users_all = User::where('id', $user->user_id)->first();

            $user->firstname = $users_all->firstname . ' ' . $users_all->lastname;

            if (!empty($users_all->profile_pic)) {
                $url = explode(":", $users_all->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $user->profile_pic = $users_all->profile_pic;
                } else {
                    $user->profile_pic =  url('/images/user/' . $users_all->profile_pic);
                }
            } else {
                $user->profile_pic = "";
            }

            $activeBookings[] = $user;
        }

        $users_done = BookingCancelOrder::where('handyman_id', $user_id)
            ->orderByDesc('id')
            ->get();


        foreach ($users_done as $cancel_booking) {

            $booking_all = BookingOrders::where('id', $cancel_booking->booking_order_id);

            $date = date('d D Y', strtotime($booking_all->created_at));

            $time = date('h:i', strtotime($booking_all->created_at));

            $users_online = Service::where('id', $booking_all->service_id)->first();

            $booking_done->service_name = $users_online->service_name ?? "";
            $booking_done->cat_name = $booking_all->cat_name ?? "";
            // $user->location = $booking_all->location ?? "";
            $booking_done->on_status = $booking_all->on_status ?? "";
            $booking_done->payment_method = $booking_all->payment_method ?? "";
            $booking_done->handyman_status = $booking_all->handyman_status ?? "";
            $booking_done->booking_status = $booking_all->handyman_status ?? "";
            $booking_done->date = $date;
            $booking_done->time = $time;
            $booking_done->created_at = $booking_all->created_at ?? "";

            $location = $booking_all->location;

            $users_online = CartItemsModel::where('cart_id', $booking_all->cart_id)->first();

            $booking_done->order_id = $users_online ? (string)$users_online->order_id : "";

            $address_data = UserAddressModel::where('address_id', $location)->first();
            if ($address_data) {
                $fields = [
                    $address_data->address,
                    $address_data->address_type,
                    $address_data->landmark,
                    $address_data->city,
                    $address_data->state,
                    $address_data->country,
                    $address_data->area_name,
                    $address_data->zip_code
                ];

                $filtered_fields = array_filter($fields);
                $booking_done->location = implode(', ', $filtered_fields);
            } else {
                $booking_done->location  = '';
            }

            $booking_done->product_id = "";
            $users_all = User::where('id', $booking_all->user_id)->first();

            $booking_done->firstname = $users_all->firstname . ' ' . $users_all->lastname;

            if (!empty($users_all->profile_pic)) {
                $url = explode(":", $users_all->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $booking_done->profile_pic = $users_all->profile_pic;
                } else {
                    $booking_done->profile_pic =  url('/images/user/' . $users_all->profile_pic);
                }
            } else {
                $booking_done->profile_pic = "";
            }

            $canceledBookings[] = $booking_done;
        }


        // Merge both active and canceled bookings
        $mergedBookings = array_merge($activeBookings, $canceledBookings);

        // Sort the merged array by created_at date in descending order
        usort($mergedBookings, function ($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });


        $users_all_count = Review::where('send_user_review_id', $user_id)->count();

        $users_online = User::where('id', $user_id)->first();

        $total_req = BookingOrders::where('work_assign_id', $user_id)
            ->where('service_id', '!=', "")->where('handyman_status', "1")->where('booking_status', "0")->count();

        $online = $users_online->is_online;

        BookingOrders::where('work_assign_id', $user_id)->update(['booking_status' => "1"]);


        $todayAmount = BookingHandymanHistory::where('handyman_id', $user_id)->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $totalAmount = BookingHandymanHistory::where('handyman_id', $user_id)
            ->sum('amount');

        $totaljobdone = BookingHandymanHistory::where('handyman_id', $user_id)
            ->count();

        $all_service = BookingHandymanHistory::where('handyman_id', $user_id)
            ->get();

        $total_avg_count = "0";

        foreach ($all_service as $handyman) {

            $restaurant = [];
            $restaurant['service_id'] = (string)$handyman->service_id;


            $ServiceReview =  ServiceReview::where('service_id', $handyman->service_id);

            $totalStarCount = $ServiceReview->sum('star_count');

            $totalReviewCount = $ServiceReview->count();

            if ($totalReviewCount) {
                $total_avg_count = $totalStarCount / $totalReviewCount;
            }
        }




        if (!empty($users)) {
            $result['response_code'] = "1";
            $result['message'] = "Users Found";
            $result['users'] = $users;
            $result['is_online'] = $online;
            $result['today_earning'] = (string)$todayAmount;
            $result['total_job_done'] = (string)$totaljobdone;
            $result['total_ratings'] = (string)$total_avg_count;
            $result['total_earned'] = (string)$totalAmount;
            $result['total_members_rating'] = $users_all_count;
            $result['total_pending_request'] = $total_req;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Users Not Found";
            $result['users'] = [];
            $result['is_online'] = "";
            $result['today_earning'] = "";
            $result['total_job_done'] = "";
            $result['total_ratings'] = "";
            $result['total_earned'] = "";
            $result['total_members_rating'] = 0;
            $result['total_pending_request'] = 0;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }


    public function home(Request $request)
    {
        $result = [];
        $activeBookings = [];
        $canceledBookings = [];
        $user_id = Auth::user()->token()->user_id;

        // Fetch active booking orders assigned to the current user
        $users = BookingOrders::where('work_assign_id', $user_id)
            ->where('service_id', '!=', "")
            ->where('is_online', "1")
            ->orderByDesc('updated_at')
            ->get();

        foreach ($users as $user) {
            $date = date('d D Y', strtotime($user->created_at));
            $time = date('h:i', strtotime($user->created_at));

            // $user->booking_id = $user->id ?? "";
            $users_online = Service::where('id', $user->service_id)->first();

            $user->service_name = $users_online->service_name ?? "";
            $user->cat_name = $user->cat_name ?? "";
            $user->on_status = $user->on_status ?? "";
            $user->payment_method = $user->payment_method ?? "";
            $user->handyman_status = (string)$user->handyman_status ?? "";
            $user->booking_status = (string)$user->handyman_status ?? "";
            $user->work_assign_id = (string)$user->work_assign_id ?? "";
            // $user->date = $date;
            // $user->time = $time;

            if ($user->cart_id) {
                $cart = CartItemsModel::where('cart_id', $user->cart_id)->first();

                $user->date = $cart->booking_date;
                $user->time = $cart->booking_time;
            } else {

                $user->date = "";
                $user->time = "";
            }
            $user->updated_at = $user->updated_at ?? "";

            $location = $user->location;

            $users_online = CartItemsModel::where('cart_id', $user->cart_id)->first();
            $user->order_id = $users_online ? (string)$users_online->order_id : "";

            $address_data = UserAddressModel::where('address_id', $location)->first();
            if ($address_data) {
                $fields = [
                    $address_data->address,
                    $address_data->address_type,
                    $address_data->landmark,
                    $address_data->city,
                    $address_data->state,
                    $address_data->country,
                    $address_data->area_name,
                    $address_data->zip_code
                ];

                $filtered_fields = array_filter($fields);
                $user->location = implode(', ', $filtered_fields);
            } else {
                $user->location = '';
            }

            $user->product_id = "";
            $users_all = User::where('id', $user->user_id)->first();
            $user->firstname = $users_all->firstname . ' ' . $users_all->lastname;

            $all_image = DefaultImage::where('people_id', "3")->first();
            $my_image = $all_image->image;


            if (!empty($users_all->profile_pic)) {
                $url = explode(":", $users_all->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $user->profile_pic = $users_all->profile_pic;
                } else {
                    $user->profile_pic = url('/images/user/' . $users_all->profile_pic);
                }
            } else {
                $user->profile_pic =  url('/images/user/' . $my_image);
            }

            $activeBookings[] = $user;
        }

        // Fetch canceled booking orders for the current user
        $users_done = BookingCancelOrder::where('handyman_id', $user_id)
            ->orderByDesc('id')
            ->get();

        foreach ($users_done as $cancel_booking) {
            $booking_all = BookingOrders::where('id', $cancel_booking->booking_order_id)->first();

            // Check if booking_all is found
            if ($booking_all) {
                $date = date('d D Y', strtotime($booking_all->created_at));
                $time = date('h:i', strtotime($booking_all->created_at));

                $users_online = Service::where('id', $booking_all->service_id)->first();

                $booking_all->service_name = $users_online->service_name ?? "";
                $booking_all->cat_name = $booking_all->cat_name ?? "";
                $booking_all->on_status = $booking_all->on_status ?? "";
                $booking_all->payment_method = $booking_all->payment_method ?? "";
                $booking_all->handyman_status = (string)$booking_all->handyman_status ?? "";
                $booking_all->booking_status = (string)$cancel_booking->handyman_status ?? "";
                $booking_all->work_assign_id = (string)$booking_all->work_assign_id ?? "";
                // $booking_all->date = $date;
                // $booking_all->time = $time;
                $booking_all->updated_at = $booking_all->updated_at ?? "";

                $location = $booking_all->location;

                if ($booking_all->cart_id) {
                    $cart = CartItemsModel::where('cart_id', $booking_all->cart_id)->first();

                    $booking_all->date = $cart->booking_date;
                    $booking_all->time = $cart->booking_time;
                } else {

                    $booking_all->date = "";
                    $booking_all->time = "";
                }

                $users_online = CartItemsModel::where('cart_id', $booking_all->cart_id)->first();
                $booking_all->order_id = $users_online ? (string)$users_online->order_id : "";

                $address_data = UserAddressModel::where('address_id', $location)->first();
                if ($address_data) {
                    $fields = [
                        $address_data->address,
                        $address_data->address_type,
                        $address_data->landmark,
                        $address_data->city,
                        $address_data->state,
                        $address_data->country,
                        $address_data->area_name,
                        $address_data->zip_code
                    ];

                    $filtered_fields = array_filter($fields);
                    $booking_all->location = implode(', ', $filtered_fields);
                } else {
                    $booking_all->location = '';
                }

                $booking_all->product_id = "";
                $users_all = User::where('id', $booking_all->user_id)->first();
                $booking_all->firstname = $users_all->firstname . ' ' . $users_all->lastname;


                $all_image = DefaultImage::where('people_id', "3")->first();
                $my_image = $all_image->image;


                if (!empty($users_all->profile_pic)) {
                    $url = explode(":", $users_all->profile_pic);

                    if ($url[0] == "https" || $url[0] == "http") {
                        $booking_all->profile_pic = $users_all->profile_pic;
                    } else {
                        $booking_all->profile_pic = url('/images/user/' . $users_all->profile_pic);
                    }
                } else {
                    // $booking_all->profile_pic = "";
                    // $booking_all->profile_pic =  url('/images/user/defaultuser.png');
                    $booking_all->profile_pic =  url('/images/user/' . $my_image);
                }

                $canceledBookings[] = $booking_all;
            }
        }

        // Merge both active and canceled bookings
        $mergedBookings = array_merge($activeBookings, $canceledBookings);

        // Sort the merged array by created_at date in descending order
        usort($mergedBookings, function ($a, $b) {
            return strtotime($b->updated_at) - strtotime($a->updated_at);
        });

        $users_all_count = HandymanReview::where('handyman_id', $user_id)->count();

        $users_online = User::where('id', $user_id)->first();

        $total_req = BookingOrders::where('work_assign_id', $user_id)
            ->where('service_id', '!=', "")
            ->where('handyman_status', "1")
            ->where('booking_status', "0")
            ->count();

        $online = $users_online->is_online;

        BookingOrders::where('work_assign_id', $user_id)->where('booking_status', "")->update(['booking_status' => "1"]);

        $todayAmount = BookingHandymanHistory::where('handyman_id', $user_id)->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $totalAmount = BookingHandymanHistory::where('handyman_id', $user_id)
            ->sum('amount');

        $totaljobdone = BookingHandymanHistory::where('handyman_id', $user_id)
            ->count();

        $all_service = BookingHandymanHistory::where('handyman_id', $user_id)
            ->get();

        $total_avg_count = "0";

        foreach ($all_service as $handyman) {
            $restaurant = [];
            $restaurant['service_id'] = (string)$handyman->service_id;

            $ServiceReview = HandymanReview::where('handyman_id', $user_id);

            $totalStarCount = $ServiceReview->sum('star_count');
            $totalReviewCount = $ServiceReview->count();

            if ($totalReviewCount) {
                $total_avg_count = $totalStarCount / $totalReviewCount;
            }
        }

        $is_user = User::where('id', $user_id)->first();

        if ($is_user->is_online == "1") {

            $total_pending_request = BookingOrders::where('work_assign_id', $user_id)
                ->where('service_id', '!=', "")
                ->where('is_online', "0")
                ->count();
        } else {
            $total_pending_request = 0;
        }


        //   $total_pending_request = BookingOrders::where('BookingOrders', work_assign_id)
        // ->where('service_id', '!=', "")->update('is_online' => "1");

        $is_user = User::where('id', $user_id)->first();

        if ($is_user->is_online == "1") {

            BookingOrders::where('work_assign_id', $user_id)->where('is_online', "0")->where('service_id', '!=', "")->update([
                'is_online' => "1",
            ]);
        }


        $unread_count = user_notification::where('handyman_id', $user_id)->where('read_handyman', "0")->count();

        if (!empty($mergedBookings)) { // Use $mergedBookings instead of $users
            $result['response_code'] = "1";
            $result['message'] = "Users Found";
            $result['users'] = $mergedBookings; // Use $mergedBookings instead of $users
            $result['is_online'] = $online;
            $result['today_earning'] = (string)$todayAmount;
            $result['total_job_done'] = (string)$totaljobdone;
            // $result['total_ratings'] = (string)$total_avg_count;

            $result['total_ratings'] = number_format($total_avg_count, 1);

            $result['total_earned'] = (string)$totalAmount;
            $result['total_members_rating'] = $users_all_count;
            $result['total_offline_request'] = $total_req;
            $result['total_pending_request'] = $total_pending_request;
            $result['unread_notification_count'] = $unread_count;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Users Not Found";
            $result['users'] = [];
            $result['is_online'] = $online;
            $result['today_earning'] = "";
            $result['total_job_done'] = "";
            $result['total_ratings'] = "";
            $result['total_earned'] = "";
            $result['total_members_rating'] = 0;
            $result['total_pending_request'] = 0;
            $result['total_offline_request'] = 0;
            $result['unread_notification_count'] = 0;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }


    public function booking_filter(Request $request)
    {
        try {

            $date = $request->input('date');
            $booking_status = $request->input('booking_status');
            // $age = $request->input('age');
            // $gender = $request->input('gender');
            // $state = $request->input('state');
            $user_id = Auth::user()->token()->user_id;


            $users = BookingOrders::query();

            // if ($booking_status) {

            //     $input = $booking_status; // Remove square brackets
            //     $booking_status = explode(',', $input);
            //     if (count($booking_status) > 0) {

            //         $users->whereIn('booking_status', $booking_status);
            //         // $users->where('id', '!=', $user_id);

            //         foreach ($booking_status as $row) {
            //             $users->where('booking_status', $row);
            //             // $users->where('id', '!=', $user_id);
            //         }
            //     }
            // }

            // $current_date = date('Y-m-d');

            // $users->whereDate('created_at', $current_date);

            if ($booking_status && $date) {
                // Remove square brackets from $booking_status
                $input = $booking_status;
                $booking_status = explode(',', $input);

                // Filter based on booking_status
                if (count($booking_status) > 0) {
                    $users->whereIn('booking_status', $booking_status);
                }

                // Filter based on date
                $users->whereDate('created_at', $date);
            }


            $users->OrderByDesc('id');
            $items = $users->get();
            $array = array();

            foreach ($items as $row) {
                $restaurant = [];
                $restaurant['id'] = (string)$row->id;
                $restaurant['cat_name'] = $row->cat_name ?  $row->cat_name : "";
                $restaurant['payment'] = $row->payment  ?  $row->payment : "";
                $restaurant['location'] = $row->location ?  $row->location : "";
                $restaurant['booking_status'] = $row->booking_status ?  $row->booking_status : "";
                $restaurant['user_id'] = $row->user_id ?  $row->user_id : "";
                $restaurant['on_status'] = $row->on_status ?  $row->on_status : "";
                $restaurant['work_assign_id'] = $row->work_assign_id ?  $row->work_assign_id : "";

                $date = date('d D Y', strtotime($row->created_at));

                $time = date('h:i', strtotime($row->created_at));


                $restaurant['date'] = $date;
                $restaurant['time'] = $time;


                $users_all = User::where('id', $row->user_id)->first();

                $all_image = DefaultImage::where('people_id', "3")->first();
                $my_image = $all_image->image;


                $restaurant['firstname'] = $users_all->firstname . ' ' . $users_all->lastname;

                if (!empty($users_all->profile_pic)) {
                    $url = explode(":", $users_all->profile_pic);

                    if ($url[0] == "https" || $url[0] == "http") {
                        $restaurant['profile_pic'] = $users_all->profile_pic;
                    } else {
                        $restaurant['profile_pic'] =  url('/images/user/' . $users_all->profile_pic);
                    }
                } else {
                    // $restaurant['profile_pic'] = url('/images/user/defaultuser.png');

                    $restaurant['profile_pic'] =  url('/images/user/' . $my_image);
                }



                $array[] = $restaurant;
            }

            if (empty($array)) {

                $response = [
                    "response_code" => "0",
                    "message" => "Booking List Not Found..!",
                    "status" => "failure",
                    'booking' => [],
                ];

                return response()->json($response, 200);
            }

            $response = [
                "response_code" => "1",
                "message" => "Booking List Found",
                "status" => "success",
                'booking' => $array,

            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError("Booking List not Found", $th->getMessage());
        }
    }

    public function booking_details2(Request $request)
    {
        try {

            // $date = $request->input('date');
            $booking_id = $request->input('booking_id');
            // $age = $request->input('age');
            // $gender = $request->input('gender');
            // $state = $request->input('state');
            $user_id = Auth::user()->token()->user_id;


            $items = BookingOrders::where('id', $booking_id)->first();


            // $users->OrderByDesc('id');
            // $items = $users->get();
            // $array = array();

            foreach ($items as $row) {
                $restaurant = [];
                $restaurant['id'] = (string)$row->id;
                $restaurant['cat_name'] = $row->cat_name ?  $row->cat_name : "";
                $restaurant['payment'] = $row->payment  ?  $row->payment : "";
                $restaurant['location'] = $row->location ?  $row->location : "";
                $restaurant['booking_status'] = $row->booking_status ?  $row->booking_status : "";
                $restaurant['user_id'] = $row->user_id ?  $row->user_id : "";
                $restaurant['on_status'] = $row->on_status ?  $row->on_status : "";
                $restaurant['work_assign_id'] = $row->work_assign_id ?  $row->work_assign_id : "";

                $date = date('d D Y', strtotime($row->created_at));

                $time = date('h:i', strtotime($row->created_at));


                $restaurant['date'] = $date;
                $restaurant['time'] = $time;


                $users_all = User::where('id', $row->user_id)->first();

                $restaurant['firstname'] = $users_all->firstname . ' ' . $users_all->lastname;

                if (!empty($users_all->profile_pic)) {
                    $url = explode(":", $users_all->profile_pic);

                    if ($url[0] == "https" || $url[0] == "http") {
                        $restaurant['profile_pic'] = $users_all->profile_pic;
                    } else {
                        $restaurant['profile_pic'] =  url('/images/user/' . $users_all->profile_pic);
                    }
                } else {
                    $restaurant['profile_pic'] = "";
                }



                // $array[] = $restaurant;
            }

            // if (empty($restaurant)) {

            //     $response = [
            //         "response_code" => "0",
            //         "message" => "Booking List Not Found..!",
            //         "status" => "failure",
            //         'booking' => [],
            //     ];

            //     return response()->json($response, 200);
            // }

            $response = [
                "response_code" => "1",
                "message" => "Booking List Found",
                "status" => "success",
                'booking' => $restaurant,

            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError("Booking List not Found", $th->getMessage());
        }
    }
    public function booking_details(Request $request)
    {
        try {
            $booking_id = $request->input('booking_id');
            $user_id = Auth::user()->id;

            $bookingOrder = BookingOrders::where('id', $booking_id)->first();

            if (!$bookingOrder) {
                return response()->json([
                    "response_code" => "0",
                    "message" => "Booking List Not Found..!",
                    "status" => "failure",
                    'booking' => [],
                ], 200);
            }

            $restaurant = [
                'id' => (string)$bookingOrder->id,
                // 'cat_name' => $bookingOrder->cat_name ?? "",
                // 'cat_name' => "",
                'payment' => $bookingOrder->payment ?? "",
                // 'location' => $bookingOrder->location ?? "",
                'booking_status' => (string)$bookingOrder->handyman_status ?? "",
                'payment_method' => $bookingOrder->payment_method ?? "",
                'user_id' => $bookingOrder->user_id ?? "",
                'on_status' => $bookingOrder->on_status ?? "",
                'work_assign_id' => (string)$bookingOrder->work_assign_id ?? "",
                // 'date' => date('d D Y', strtotime($bookingOrder->created_at)),
                // 'time' => date('h:i', strtotime($bookingOrder->created_at)),
                'provider_id' => (string)$bookingOrder->provider_id,
                'service_id' => $bookingOrder->service_id ?? "",
            ];

            $user = User::find($bookingOrder->user_id);

            $don_all = BookingOrdersStatus::where('booking_id', $booking_id)->first();
            $restaurant['reason'] = $don_all->reason ?? "";

            $location = $bookingOrder->location;

            $address_data = UserAddressModel::where('address_id', $location)->first();
            if ($address_data) {
                $fields = [
                    $address_data->address,
                    $address_data->address_type,
                    $address_data->landmark,
                    $address_data->city,
                    $address_data->state,
                    $address_data->country,
                    $address_data->area_name,
                    $address_data->zip_code
                ];

                $restaurant['contact_number'] = $address_data->phone ?? "";
                $filtered_fields = array_filter($fields);
                $restaurant['location'] = implode(', ', $filtered_fields);
            } else {
                $restaurant['location'] = '';
            }

            $restaurant['lat'] = $address_data->lat ?? "";
            $restaurant['lon'] = $address_data->lon ?? "";
            // $services_all = Service::where('id', $bookingOrder->service_id)->first();

            // $restaurant['cat_name'] = $services_all->service_name;
            // $images = explode("::::", $services_all->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // $restaurant['cat_image'] = $imgsa;

            $services_all = Service::where('id', $bookingOrder->service_id)->with('serviceImages')->first();

            $restaurant['cat_name'] = $services_all->service_name;
            $imgsa = [];



            foreach ($services_all->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images);
            }

            $restaurant['cat_image'] = $imgsa;

            $all_image = DefaultImage::where('people_id', "3")->first();
            $my_image = $all_image->image;


            if ($user) {
                $restaurant['firstname'] = $user->firstname . ' ' . $user->lastname;
                $restaurant['email'] = $user->email ?? "";
                $restaurant['profile_pic'] = $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);
            } else {
                $restaurant['firstname'] = "";
                $restaurant['email'] = "";
                $restaurant['profile_pic'] = "";
            }

            $cart_items = CartItemsModel::where('cart_id', $bookingOrder->cart_id)->first();


            $restaurant['order_id'] = $cart_items ? (string)$cart_items->order_id : "";

            $order_items_done = $cart_items->order_id;

            $restaurant['date'] = $cart_items->booking_date ?? "";
            $restaurant['time'] = $cart_items->booking_time ?? "";

            $order_items = OrdersModel::where('id', $order_items_done)->first();




            if ($order_items) {
                $restaurant['price'] = $order_items->sub_total ?? "";
                $restaurant['coupon'] = $order_items->coupon ?? "";
                $restaurant['tax'] = $order_items->tax ?? "";
                $restaurant['sub_total'] =  $order_items->sub_total;
                $restaurant['total'] =  $order_items->total;
                $restaurant['quantity'] = $order_items->quantity ?? "";
                $restaurant['service_charge'] = $order_items->service_charge ?? "";
            } else {
                $restaurant['price'] = $order_items->sub_total;
                $restaurant['coupon'] = $order_items->coupon ?? "";
                $restaurant['tax'] = $order_items->tax ?? "";
                $restaurant['sub_total'] =  $order_items->sub_total;
                $restaurant['total'] =  $order_items->total;
                $restaurant['quantity'] = $order_items->quantity ?? "";
                $restaurant['service_charge'] = $order_items->service_charge ?? "";
            }

            $service_proof = ServiceProof::where('booking_id', $booking_id)->first();

            $restaurant['service_proof_status'] = $service_proof ? "1" : "0";

            // $review_list = Review::where('cat_id', $bookingOrder->cat_name)->get();


            // foreach ($review_list as $row) {
            //     $res = [];
            //     $res['id'] = (string)$row->id;
            //     $res['user_id'] = $row->user_id ?  $row->user_id : "";
            //     $res['text'] = $row->text  ?  $row->text : "";
            //     $res['star_count'] = $row->star_count ?  $row->star_count : "";
            //     $res['cat_id'] = $row->cat_id ?  $row->cat_id : "";

            //     $date = date('d D Y', strtotime($row->created_at));

            //     $time = date('h:i', strtotime($row->created_at));


            //     $res['date'] = $date;
            //     $res['time'] = $time;


            //     $users_all = User::where('id', $row->user_id)->first();

            //     $res['firstname'] = $users_all->firstname . ' ' . $users_all->lastname;

            //     if (!empty($users_all->profile_pic)) {
            //         $url = explode(":", $users_all->profile_pic);

            //         if ($url[0] == "https" || $url[0] == "http") {
            //             $res['profile_pic'] = $users_all->profile_pic;
            //         } else {
            //             $res['profile_pic'] =  url('/images/user/' . $users_all->profile_pic);
            //         }
            //     } else {
            //         $res['profile_pic'] = "";
            //     }



            //     $array[] = $res;
            // }


            $all_reviews = ServiceReview::where('service_id', $bookingOrder->service_id)
                ->orderByDesc('id')
                ->limit('3')
                ->get();


            $list_review_done = [];

            foreach ($all_reviews as $review_done) {
                $review_all_list['review_id'] = $review_done->id;
                $review_all_list['user_id'] = (string)$review_done->user_id;
                $review_all_list['service_id'] = (string)$review_done->service_id;
                $review_all_list['text'] = $review_done->text ?? "";
                $review_all_list['star_count'] = $review_done->star_count;
                $review_all_list['created_at'] = $review_done->created_at ?? "";

                $user = User::where('id', $review_done->user_id)->first();

                $all_image = DefaultImage::where('people_id', "3")->first();
                $my_image = $all_image->image;

                $review_all_list['username'] = $user->firstname ?? "";
                $review_all_list['user_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
                $list_review_done[] = $review_all_list;
            }

            $booking_done = BookingOrdersStatus::where('booking_id', $booking_id)->where('reason', '!=', null)->get();

            foreach ($booking_done as $row_list) {
                $res_done = [];
                $res_done['id'] = (string)$row_list->id;
                $res_done['reason'] = $row_list->reason ?  $row_list->reason : "";

                $array_list[] = $res_done;
            }


            $response = [
                "response_code" => "1",
                "message" => "Booking List Found",
                "status" => "success",
                'booking' => $restaurant,
                'review' => $list_review_done ?? [],
                // 'reason' => $array_list ?? [],
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return $this->sendError("Booking List not Found", $th->getMessage());
        }
    }
    public function user_profile(Request $request)
    {

        try {
            //code...

            $user_id = Auth::user()->token()->user_id;
            $user = User::find($user_id);


            // $user = User::where('id', $request->input('user_id'))->first();
            if (!$user) {
                $response = [
                    'status' => 'failed',
                    'data' => 'user not found',
                ];
                return response()->json($response);
            }

            $updates = [
                'firstname' => $request->input('firstname', $user->firstname),
                'lastname' => $request->input('lastname', $user->lastname),
                'email' => $request->input('email', $user->email),
                'mobile' => $request->input('mobile', $user->mobile),
                'country_code' => $request->input('country_code', $user->country_code),
                'device_token' => $request->input('device_token', $user->device_token),
                'city' => $request->input('city', $user->city),
                'state' => $request->input('state', $user->state),
                'location' => $request->input('location', $user->location),
                'country_flag' => $request->input('country_flag', $user->country_flag),
                'user_role' => $request->input('user_role', $user->user_role),
                'latitude' => $request->input('lat', $user->latitude),
                'longitude' => $request->input('lon', $user->longitude),
                'people_id' => $request->input('people_id', $user->people_id),
            ];



            // if ($request->hasFile('profile_pic')) {
            //     $file = $request->file('profile_pic');
            //     $image_exts = ['tif', 'jpg', 'jpeg', 'gif', 'png'];
            //     $extension = $file->getClientOriginalExtension();
            //     if (!in_array($extension, $image_exts)) {
            //         $response = [
            //             'status' => 'failure',
            //             'message' => 'Image Type Error',
            //         ];
            //         return response()->json($response);
            //     }
            //     $fileName = 'pi_1-' . uniqid() . '.' . $extension;
            //     $file->move(public_path('/images/user/'), $fileName);
            //     $updates = [
            //         'profile_pic' => $fileName,
            //     ];
            // }
            if ($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');
                $image_exts = ['tif', 'jpg', 'jpeg', 'gif', 'png'];
                $extension = $file->getClientOriginalExtension();
                if (!in_array($extension, $image_exts)) {
                    $response = [
                        'status' => 'failure',
                        'message' => 'Image Type Error',
                    ];
                    return response()->json($response);
                }
                $fileName = 'pi_1-' . uniqid() . '.' . $extension;
                $file->move(public_path('/images/user/'), $fileName);
                // Add profile_pic to updates array
                $updates['profile_pic'] = $fileName;
            }
            $user->update($updates);


            // return $this->sendResponse(new UserResource($user), "User Details");
            $response = [
                'status' => 'success',
                'data' => new UserResource($user),
            ];
            return response()->json($response);
        } catch (\Throwable $th) {
            //throw $th;
            // return $this->sendError('erros', $th->getMessage());


            // return $this->sendResponse(new UserResource($user),"Successfully login");
            $response = [
                'status' => 'False',
                'message' => 'Email is already exists',
            ];
            return response()->json($response, 401);
        }
    }

    public function notification_list_old(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        $notifications = user_notification::where('to_user', $user_id)->orderBy('not_id', 'DESC')->get();

        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['not_id'] = $notification->not_id;
            $questions_list['from_user'] = $notification->from_user;
            $questions_list['to_user'] = $notification->to_user;
            $questions_list['type'] = $notification->type;
            $questions_list['booking_id'] = $notification->booking_id;
            $questions_list['title'] = $notification->title;
            $questions_list['order_id'] = $notification->order_id;
            $questions_list['message'] = $notification->message;
            $questions_list['read_status'] = $notification->read_status;
            $questions_list['date'] = $notification->date;
            // $questions_list['time'] = $notification->created_at->diffForHumans();
            // $questions_list['is_view'] = $notification->is_view ? $notification->is_view : "0" ;


            // $createdAt = $notification->created_at->startOfDay();
            // $today = Carbon::today();
            // $yesterday = Carbon::yesterday();
            // $date = "";
            // if ($createdAt->eq($today)) {
            //     $date = 'Today';
            // } elseif ($createdAt->eq($yesterday)) {
            //     $date = 'Yesterday';
            // } else {
            //     $date = $createdAt->format('d M');
            // }

            // $questions_list['time'] = $date;

            $user = User::find($notification->from_user);

            if (!empty($user)) {
                $questions_list['firstname'] = $user->firstname ?? "";
                $questions_list['lastname'] = $user->lastname ?? "";

                // Assuming you store the profile_pic in the 'profile_pics' directory within 'public' folder
                $profile_pic = $user->profile_pic;
                if (!empty($profile_pic)) {
                    $url = explode(":", $profile_pic);
                    if ($url[0] == "https" || $url[0] == "http") {
                        $questions_list['profile_pic'] = $profile_pic;
                    } else {
                        $questions_list['profile_pic'] = url('/images/user/' . $profile_pic);
                    }
                } else {
                    $questions_list['profile_pic'] = "";
                }
            } else {
                $questions_list['profile_pic'] = "";
                $questions_list['username'] = "";
            }

            $list_notification[] = $questions_list;
        }

        if ($list_notification) {
            $result = [
                "response_code" => "1",
                "message" => "found notification",
                "detail" => $list_notification,
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Not found notification",
                "detail" => $list_notification,
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }

    public function notification_list(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }



        $notifications = user_notification::where('user_id', $user_id)
            ->orderBy('created_at', 'DESC') // Order by created_at for proper grouping
            ->get()
            ->groupBy(function ($notification) {
                // Group notifications by date
                return $notification->created_at->format('Y-m-d');
            })
            ->map(function ($groupedNotifications, $date) {
                // Format the date
                $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d\TH:i:s.u\Z');
                return [
                    'date' => $formattedDate,

                    'notifications' => $groupedNotifications->map(function ($notification) {
                        $questions_list = [];
                        $questions_list['not_id'] = $notification->not_id;
                        $questions_list['from_user'] = (int)$notification->user_id;
                        $questions_list['to_user'] = (int)$notification->handyman_id;
                        $questions_list['type'] = $notification->type;
                        $questions_list['booking_id'] = $notification->booking_id;
                        $questions_list['title'] = $notification->title;

                        $questions_list['message'] = $notification->message;
                        $questions_list['read_status'] = (int)$notification->read_user;
                        $questions_list['inside_date'] = $notification->created_at;
                        $cart_id = BookingOrders::where('id', $notification->booking_id)->first();

                        if ($cart_id) {

                            $all_cart_id = $cart_id->cart_id;
                            $booking_id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                            // $questions_list['order_id'] = $booking_id->order_id;

                            if ($booking_id) {
                                $questions_list['order_id'] = $booking_id->order_id;
                            } else {
                                $questions_list['order_id'] = 0;
                            }
                        } else {
                            $questions_list['order_id'] = 0;
                        }

                        $user = User::find($notification->from_user);

                        if (!empty($user)) {
                            $questions_list['firstname'] = $user->firstname ?? "";
                            $questions_list['lastname'] = $user->lastname ?? "";

                            $profile_pic = $user->profile_pic;
                            if (!empty($profile_pic)) {
                                $url = explode(":", $profile_pic);
                                if ($url[0] == "https" || $url[0] == "http") {
                                    $questions_list['profile_pic'] = $profile_pic;
                                } else {
                                    $questions_list['profile_pic'] = url('/images/user/' . $profile_pic);
                                }
                            } else {
                                $questions_list['profile_pic'] = "";
                            }
                        } else {
                            $questions_list['profile_pic'] = "";
                            $questions_list['firstname'] = ""; // Added missing firstname key
                            $questions_list['lastname'] = "";  // Added missing lastname key
                        }

                        return $questions_list;
                        // }
                    }),
                ];
            });

        // $data = array(
        //     "read_user" =>  "1",
        // );

        // user_notification::where('user_id', $user_id)
        //     ->update($data);

        if ($notifications->isNotEmpty()) {
            $result = [
                "response_code" => "1",
                "message" => "Found notifications",
                "detail" => $notifications->values()->all(),
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "No notifications found",
                "detail" => [],
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }


    public function notification_verified(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;
        $not_id = $request->input('not_id');

        if (!$not_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        $data = array(
            "read_user" =>  "1",
        );

        $seen_notification =  user_notification::where('not_id', $not_id)->where('user_id', $user_id)
            ->update($data);

        if ($seen_notification) {
            $result = [
                "response_code" => "1",
                "message" => "Notification Seen Done",
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Notification not seen",
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }

    public function handyman_notification_list(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }




        $notifications = user_notification::where('handyman_id', $user_id)
            ->orderBy('created_at', 'DESC') // Order by created_at for proper grouping
            ->get()
            ->groupBy(function ($notification) {
                // Group notifications by date
                return $notification->created_at->format('Y-m-d');
            })
            ->map(function ($groupedNotifications, $date) {
                // Format the date
                $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d\TH:i:s.u\Z');
                return [
                    'date' => $formattedDate,

                    'notifications' => $groupedNotifications->map(function ($notification) {
                        $questions_list = [];
                        $questions_list['not_id'] = $notification->not_id;
                        $questions_list['from_user'] = (int)$notification->user_id;
                        $questions_list['to_user'] = (int)$notification->handyman_id;
                        $questions_list['type'] = $notification->type;
                        $questions_list['booking_id'] = $notification->booking_id;
                        $questions_list['title'] = $notification->title;

                        $questions_list['message'] = $notification->message;
                        $questions_list['read_status'] = (int)$notification->read_handyman;
                        $questions_list['inside_date'] = $notification->created_at;
                        $cart_id = BookingOrders::where('id', $notification->booking_id)->first();

                        $all_cart_id = $cart_id->cart_id;
                        $booking_id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                        $questions_list['order_id'] = $booking_id->order_id;

                        $user = User::find($notification->from_user);

                        $all_image = DefaultImage::where('people_id', "2")->first();
                        $my_image = $all_image->image;


                        if (!empty($user)) {
                            $questions_list['firstname'] = $user->firstname ?? "";
                            $questions_list['lastname'] = $user->lastname ?? "";

                            $profile_pic = $user->profile_pic;
                            if (!empty($profile_pic)) {
                                $url = explode(":", $profile_pic);
                                if ($url[0] == "https" || $url[0] == "http") {
                                    $questions_list['profile_pic'] = $profile_pic;
                                } else {
                                    $questions_list['profile_pic'] = url('/images/user/' . $profile_pic);
                                }
                            } else {
                                // $questions_list['profile_pic'] = "";
                                $questions_list['profile_pic'] =  url('/images/user/' . $my_image);
                            }
                        } else {
                            $questions_list['profile_pic'] = "";
                            $questions_list['firstname'] = ""; // Added missing firstname key
                            $questions_list['lastname'] = "";  // Added missing lastname key
                        }

                        return $questions_list;
                    }),
                ];
            });

        // $data = array(
        //     "read_handyman" =>  "1",
        // );

        // user_notification::where('handyman_id', $user_id)
        //     ->update($data);

        if ($notifications->isNotEmpty()) {
            $result = [
                "response_code" => "1",
                "message" => "Found notifications",
                "detail" => $notifications->values()->all(),
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "No notifications found",
                "detail" => [],
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }

    public function handyman_notification_verified(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;
        $not_id = $request->input('not_id');

        if (!$not_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        $data = array(
            "read_handyman" =>  "1",
        );

        $seen_notification =  user_notification::where('not_id', $not_id)->where('handyman_id', $user_id)
            ->update($data);

        if ($seen_notification) {
            $result = [
                "response_code" => "1",
                "message" => "Notification Seen Done",
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Notification not seen",
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }



    public function handyman_update_status_old(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'handyman_status' => 'required',
        ]);
        if ($validator->fails()) {

            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        $user_id = Auth::user()->token()->user_id;

        $handyman_status = $request->input('handyman_status');
        $booking_id = $request->input('booking_id');

        try {
            // $phone = $request->input('phone');
            // $otp = $request->input('otp');
            // $where = 'mobile_no="' . $mob_no . '"';

            if ($handyman_status == "3" || $handyman_status == "8") {
                $datas = array(
                    "work_assign_id" => "",
                    "handyman_status" => $handyman_status,
                );

                BookingOrders::where('id', $booking_id)->update($datas);


                BookingCancelOrder::create([
                    'handyman_id' => $user_id,
                    'booking_order_id' => $booking_id,
                    'handyman_status' => $handyman_status,
                ]);
            } else {
                $data_arr = array(
                    "handyman_status" => $handyman_status,
                );
                BookingOrders::where('work_assign_id', $user_id)->where('id', $booking_id)->update($data_arr);
            }

            $data_done = array(
                "status" => $handyman_status,
                "electricity_on" => $request->input('electricity_on'),
                "reason" => $request->input('reason'),
            );

            BookingOrdersStatus::where('work_assign_id', $user_id)->where('booking_id', $booking_id)->update($data_done);

            if ($handyman_status == "6") {

                $cart_value = BookingOrders::where('id', $booking_id)->first();

                $cart_id = $cart_value->cart_id;
                $provider_id = $cart_value->provider_id;
                $handyman_id = $cart_value->work_assign_id;

                $order_value = CartItemsModel::where('cart_id', $cart_id)->first();

                $order_id = $order_value->order_id;
                $service_id = $order_value->service_id;
                $user_id = $order_value->user_id;

                $service_value = OrdersModel::where('id', $order_id)->first();

                $service_subtotal = $service_value->service_subtotal;

                $commissions_value = Commissions::where('user_role', "Handyman")->first();

                $commissions_done = $commissions_value->value;

                $calculation = ($commissions_done * $service_subtotal / 100);

                BookingHandymanHistory::create([
                    'handyman_id' => $handyman_id,
                    'provider_id' => $provider_id,
                    'booking_id' => $booking_id,
                    'amount' => $calculation,
                    'handman_status' => "0",
                    'service_id' => $service_id,
                    'user_id' => $user_id,
                    'commision_persontage' => $commissions_done,
                ]);


                $commissions_value_pro = Commissions::where('user_role', "Provider")->first();

                $commissions_done_pro = $commissions_value_pro->value;

                $calculation_pro = ($commissions_done_pro * $service_subtotal / 100);

                $prvider_new = ProviderHistory::where('provider_id', $provider_id)->first();

                if ($prvider_new) {

                    $prvider_new->update([
                        'total_bal' => $prvider_new->total_bal + $calculation_pro,
                        'available_bal' => $prvider_new->available_bal + $calculation_pro,
                    ]);
                } else {

                    ProviderHistory::create([
                        'provider_id' => $provider_id,
                        'total_bal' => $calculation_pro,
                        'available_bal' => $calculation_pro,
                    ]);
                }
            }

            if ($handyman_status == "6") {

                $booking_id = $request->input('booking_id');
                $cart_value_done = BookingOrders::where('id', $booking_id)->first();

                $provider_id_done = $cart_value_done->provider_id;



                $FcmToken = User::where('id', $provider_id_done)->value('device_token');




                $data = [
                    'title' => "Update Booking",
                    'message' => "Your Booking Id #$booking_id has been updated from in progress to completed.",
                ];



                $this->sendNotification(new Request($data), $FcmToken);
            }

            $temp = [
                "response_code" => "1",
                "message" => "Handyman Status Update successfully",
                "status" => "success",
                // "unread_count" => $approve,
            ];

            return response()->json($temp);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError("User not Successfully", $th->getMessage());
        }
    }



    public function handyman_update_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'handyman_status' => 'required',
        ]);
        if ($validator->fails()) {

            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        $user_id = Auth::user()->token()->user_id;

        $handyman_status = $request->input('handyman_status');
        $booking_id = $request->input('booking_id');

        try {
            // $phone = $request->input('phone');
            // $otp = $request->input('otp');
            // $where = 'mobile_no="' . $mob_no . '"';

            if ($handyman_status == "3" || $handyman_status == "8") {
                $datas = array(
                    "work_assign_id" => 0,
                    "handyman_status" => $handyman_status,
                );

                BookingOrders::where('id', $booking_id)->update($datas);


                BookingCancelOrder::create([
                    'handyman_id' => $user_id,
                    'booking_order_id' => $booking_id,
                    'handyman_status' => $handyman_status,
                ]);


                if ($handyman_status == "8") {
                    $cart_value_done = BookingOrders::where('id', $booking_id)->first();

                    $provider_id_done = $cart_value_done->provider_id;

                    $all_cart_id = $cart_value_done->cart_id;
                    $all_order_id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                    $order_id = $all_order_id->order_id;


                    $service = $cart_value_done->service_id;



                    if ($service) {

                        $name  = Service::where('id', $service)->first();
                        $service_name = $name->service_name;
                    }



                    $emailPreference = ProviderEmailRejectHandyman::where('get_email', 1)->first();

                    // $booking_date_all = now();
                    $booking_date_all = $cart_value_done->created_at;

                    $user_all_done =  User::where('id', $user_id)->first();
                    //  $email = $user_all_done->email;
                    $provider_name = $user_all_done->firstname;
                    $handyman_name = $user_all_done->firstname;

                    $provider_all_done =  User::where('id', $provider_id_done)->first();
                    $email = $provider_all_done->email;
                    $firstname = $provider_all_done->firstname;


                    $dateTime = new \DateTime($booking_date_all);

                    // Format the date and time
                    $booking_date = $dateTime->format('d M, Y - h:i A');

                    if ($emailPreference) {
                        // Send email on successful OTP verification
                        Mail::to($email)->send(
                            new ProviderRejectHandyman($email, $booking_id, $handyman_name, $booking_date, $firstname, $service_name)
                        );
                    }
                    $cart_value_do_it = BookingOrders::where('id', $booking_id)->first();

                    $provider_id_do = $cart_value_do_it->provider_id;

                    $all_cart_id_do = $cart_value_do_it->cart_id;
                    $all_order_id_do = CartItemsModel::where('cart_id', $all_cart_id_do)->first();
                    $order_id = $all_order_id_do->order_id;

                    $FcmToken = User::where('id', $provider_id_done)->value('device_token');

                    // $FcmToken_done = User::where('id', $all_order_id_do->user_id)->value('device_token');


                    $proviver_noti = NotificationsPermissions::where('id', "26")->where('status', "1")->first();


                    $username =  User::where('id', $user_id)->first();

                    // $firstname = $username->firstname;

                    $handyman_name = $username->firstname . ' ' . $username->lastname;

                    // Replace placeholders with actual values
                    $message = str_replace(
                        ['[[ booking_id ]]', '[[ handyman_name ]]'],
                        ['#' . $booking_id, $handyman_name],
                        $proviver_noti->description
                    );


                    $type = "Service";


                    $data = [
                        'title' => $proviver_noti->title,
                        // 'message' => '#'.$booking_id . ' ' . $proviver_noti->description . ' '.  $firstname,
                        'message' => $message,
                        'type' => $type,
                        'booking_id' => $booking_id,
                        'order_id' => $order_id,
                    ];

                    $this->sendNotification(new Request($data), $FcmToken);

                    // $this->sendNotification(new Request($data), $FcmToken_done);

                    $user_ser = BookingOrders::where('id', $booking_id)->first();

                    $all_user_id = $user_ser->user_id;
                    $provider_id = $user_ser->provider_id;


                    $not_all = [
                        'booking_id' => $request->input('booking_id'),
                        'handyman_id' => 0,
                        'provider_id' => $provider_id,
                        'user_id' => 0,
                        'title' => $proviver_noti->title,
                        // 'message' => '#'.$booking_id . ' ' . $proviver_noti->description . ' '.  $firstname,
                        'message' => $message,
                        'type' => "Service",
                        'created_at' => now(),
                    ];

                    // dd($not_all);

                    $done = DB::table('user_notification')->insert($not_all);
                }

                if ($handyman_status == "3") {

                    $cart_value_done = BookingOrders::where('id', $booking_id)->first();

                    $provider_id_done = $cart_value_done->provider_id;

                    $all_cart_id = $cart_value_done->cart_id;
                    $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                    $order_id = $all_order__id->order_id;

                    // $emailPreference = HandymanEmailBookingRejected::where('get_email', 1)->first();



                    // // $booking_date_all = now();
                    // $booking_date_all = $cart_value_done->created_at;

                    // $user_all_done =  User::where('id', $user_id)->first();
                    // //  $email = $user_all_done->email;
                    // $provider_name = $user_all_done->firstname;

                    // $provider_all_done =  User::where('id', $user_id)->first();
                    // $email = $provider_all_done->email;
                    // $firstname = $provider_all_done->firstname;

                    // $dateTime = new \DateTime($booking_date_all);

                    // // Format the date and time
                    // $booking_date = $dateTime->format('d M, Y - h:i A');

                    // if ($emailPreference) {
                    //     // Send email on successful OTP verification
                    //     Mail::to($email)->send(
                    //         new HandymanBookingRejected($email, $booking_id, $provider_name, $booking_date, $firstname)
                    //     );
                    // }



                    $emailPreference = ProviderEmailBookingRejected::where('get_email', 1)->first();



                    // $booking_date_all = now();
                    $booking_date_all = $cart_value_done->created_at;

                    $user_all_done =  User::where('id', $user_id)->first();
                    //  $email = $user_all_done->email;
                    $handyman_name = $user_all_done->firstname;

                    $provider_all_done =  User::where('id', $provider_id_done)->first();
                    $email = $provider_all_done->email;
                    $firstname = $provider_all_done->firstname;

                    $dateTime = new \DateTime($booking_date_all);

                    // Format the date and time
                    $booking_date = $dateTime->format('d M, Y - h:i A');

                    if ($emailPreference) {
                        // Send email on successful OTP verification
                        Mail::to($email)->send(
                            new ProviderBookingRejected($email, $booking_id, $handyman_name, $booking_date, $firstname)
                        );
                    }




                    $FcmToken = User::where('id', $provider_id_done)->value('device_token');

                    // dd($FcmToken);

                    // $FcmToken_done = User::where('id', $all_order__id->user_id)->value('device_token');

                    $proviver_noti = NotificationsPermissions::where('id', "36")->where('status', "1")->first();

                    $username =  User::where('id', $user_id)->first();

                    // $firstname = $username->firstname;
                    $handyman_name = $username->firstname . ' ' . $username->lastname;

                    $type = "Service";

                    // Replace placeholders with actual values
                    $message = str_replace(
                        ['[[ booking_id ]]', '[[ handyman_name ]]'],
                        ['#' . $booking_id, $handyman_name],
                        $proviver_noti->description
                    );

                    $data = [
                        'title' => $proviver_noti->title,
                        // 'message' => '#'.$booking_id . ' ' . $proviver_noti->description . ' '.  $firstname,
                        'message' => $message,
                        'type' => $type,
                        'booking_id' => $booking_id,
                        'order_id' => $order_id,
                    ];


                    $this->sendNotification(new Request($data), $FcmToken);

                    // $this->sendNotification(new Request($data), $FcmToken_done);

                    $user_ser = BookingOrders::where('id', $booking_id)->first();

                    $all_user_id = $user_ser->user_id;
                    $provider_id = $user_ser->provider_id;


                    $not_all = [
                        'booking_id' => $request->input('booking_id'),
                        'handyman_id' => "0",
                        'provider_id' => $provider_id,
                        'user_id' => "0",
                        'title' => $proviver_noti->title,
                        // 'message' => '#'.$booking_id . ' ' . $proviver_noti->description . ' '.  $firstname,
                        'message' => $message,
                        'type' => "Service",
                        'created_at' => now(),
                    ];

                    $done = DB::table('user_notification')->insert($not_all);
                }
            } else {
                $data_arr = array(
                    "handyman_status" => $handyman_status,
                );
                BookingOrders::where('work_assign_id', $user_id)->where('id', $booking_id)->update($data_arr);
            }

            $data_done = array(
                "status" => $handyman_status,
                "electricity_on" => $request->input('electricity_on'),
                "reason" => $request->input('reason'),
            );

            BookingOrdersStatus::where('work_assign_id', $user_id)->where('booking_id', $booking_id)->update($data_done);

            if ($handyman_status == "6") {

                $booking_id = $request->input('booking_id');
                $cart_value_done = BookingOrders::where('id', $booking_id)->first();

                $provider_id_done = $cart_value_done->provider_id;
                $handyman_id_done = $cart_value_done->work_assign_id;
                $user_id_done = $cart_value_done->user_id;

                $all_cart_id = $cart_value_done->cart_id;
                $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                $order_id = $all_order__id->order_id;
                $service = $cart_value_done->service_id;

                if ($service) {

                    $name  = Service::where('id', $service)->first();
                    $service_name = $name->service_name;
                }

                // $emailPreference = HandymanEmailBookingCompleted::where('get_email', 1)->first();




                // // $booking_date_all = now();
                // $booking_date_all = $cart_value_done->created_at;

                // $user_all_done =  User::where('id', $user_id)->first();
                // //  $email = $user_all_done->email;
                // $provider_name = $user_all_done->firstname;

                // $provider_all_done =  User::where('id', $user_id)->first();
                // $email = $provider_all_done->email;
                // $firstname = $provider_all_done->firstname;

                // $dateTime = new \DateTime($booking_date_all);

                // // Format the date and time
                // $booking_date = $dateTime->format('d M, Y - h:i A');

                // if ($emailPreference) {
                //     // Send email on successful OTP verification
                //     Mail::to($email)->send(
                //         new HandymanBookingCompleted($email, $booking_id, $provider_name, $booking_date, $firstname)
                //     );
                // }

                $emailPreference = ProviderEmailBookingCompleted::where('get_email', 1)->first();



                // $booking_date_all = now();
                $booking_date_all = $cart_value_done->created_at;

                $user_all_done =  User::where('id', $user_id)->first();
                //  $email = $user_all_done->email;
                $provider_name = $user_all_done->firstname;
                $handyman_name = $user_all_done->firstname;

                $provider_all_done =  User::where('id', $provider_id_done)->first();
                $email = $provider_all_done->email;
                $firstname = $provider_all_done->firstname;

                $dateTime = new \DateTime($booking_date_all);

                // Format the date and time
                $booking_date = $dateTime->format('d M, Y - h:i A');

                if ($emailPreference) {
                    // Send email on successful OTP verification
                    Mail::to($email)->send(
                        new ProviderBookingCompleted($email, $booking_id, $handyman_name, $booking_date, $firstname, $service_name)
                    );
                }

                $emailPreference = UserEmailBookingRejected::where('get_email', 1)->first();



                // $booking_date_all = now();
                $booking_date_all = $cart_value_done->created_at;

                $user_all_done =  User::where('id', $user_id)->first();
                //  $email = $user_all_done->email;
                $provider_name = $user_all_done->firstname;
                $handyman_name = $user_all_done->firstname;

                $provider_all_done =  User::where('id', $user_id_done)->first();
                $email = $provider_all_done->email;
                $firstname = $provider_all_done->firstname;

                $dateTime = new \DateTime($booking_date_all);

                // Format the date and time
                $booking_date = $dateTime->format('d M, Y - h:i A');

                if ($emailPreference) {
                    // Send email on successful OTP verification
                    Mail::to($email)->send(
                        new UserBookingCompleted($email, $booking_id, $handyman_name, $booking_date, $firstname, $service_name)
                    );
                }




                $FcmToken = User::where('id', $provider_id_done)->value('device_token');

                $FcmToken_done = User::where('id', $cart_value_done->user_id)->value('device_token');

                // $FcmToken_done_all = User::where('id', $user_id)->value('device_token');

                $proviver_all_noti = NotificationsPermissions::where('id', "25")->where('status', "1")->first();

                $message = str_replace(
                    ['[[ booking_id ]]'],
                    ['#' . $booking_id],
                    $proviver_all_noti->description
                );


                //     $username =  User::where('id', $user_id)->first();

                // $firstname = $username->firstname;
                $type = "Service";


                $data = [
                    'title' => $proviver_all_noti->title,
                    // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
                    'message' => $message,
                    'type' => $type,
                    'booking_id' => $booking_id,
                    'order_id' => $order_id,
                ];



                $this->sendNotification(new Request($data), $FcmToken);

                $this->sendNotification(new Request($data), $FcmToken_done);

                // $this->sendNotification(new Request($data), $FcmToken_done_all);

                //   $user_ser_done = BookingOrders::where('id', $booking_id)->first();

                //  $all_user_id = $user_ser_done->user_id;
                //  $provider_id = $user_ser_done->provider_id;


                $not_all_done_ask = [
                    'booking_id' => $request->input('booking_id'),
                    'handyman_id' => $handyman_id_done,
                    'provider_id' => $provider_id_done,
                    'user_id' => $user_id_done,
                    'title' => $proviver_all_noti->title,
                    // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
                    'message' => $message,
                    'type' => "Service",
                    'created_at' => now(),
                    'requests_status' => "1",
                ];

                $done = DB::table('user_notification')->insert($not_all_done_ask);

                // }

                //   if($handyman_status == "6"){

                $cart_value = BookingOrders::where('id', $booking_id)->first();



                $cart_id = $cart_value->cart_id;
                $provider_id = $cart_value->provider_id;
                $handyman_id = $cart_value->work_assign_id;

                $order_value = CartItemsModel::where('cart_id', $cart_id)->first();

                $order_id = $order_value->order_id;
                $service_id = $order_value->service_id;
                $user_id = $order_value->user_id;

                $service_value = OrdersModel::where('id', $order_id)->first();

                $service_subtotal = $service_value->service_subtotal;

                // $commissions_value = Commissions::where('user_role', "Handyman")->first();

                $commissions_value = Commissions::where('people_id', "2")->where('type', "Service")->first();

                $commissions_done = $commissions_value->value;

                $calculation = ($commissions_done * $service_subtotal / 100);

                BookingHandymanHistory::create([
                    'handyman_id' => $handyman_id,
                    'provider_id' => $provider_id,
                    'booking_id' => $booking_id,
                    'amount' => $calculation,
                    'handman_status' => "0",
                    'service_id' => $service_id,
                    'user_id' => $user_id,
                    'commision_persontage' => $commissions_done,
                ]);


                // $commissions_value_pro = Commissions::where('user_role', "Provider")->where('id', "2")->first();

                $commissions_value_pro = Commissions::where('people_id', "1")->where('type', "Service")->first();

                $commissions_done_pro = $commissions_value_pro->value;

                $calculation_pro = ($commissions_done_pro * $service_subtotal / 100);

                // dd($calculation_pro);


                BookingProviderHistory::create([
                    'handyman_id' => $handyman_id,
                    'provider_id' => $provider_id,
                    'booking_id' => $booking_id,
                    'amount' => $calculation_pro,
                    'service_id' => $service_id,
                    'user_id' => $user_id,
                    'commision_persontage' => $commissions_done_pro,
                ]);



                //     $provider_per_done = [
                //             'handyman_id' => $handyman_id,
                //             'provider_id' => $provider_id,
                //             'booking_id' => $booking_id,
                //             'amount' => $calculation_pro,
                //             'service_id' => $service_id,
                //             'user_id' => $user_id,
                //             'commision_persontage' => $commissions_done_pro,
                // ];


                //     // dd($provider_per_done);
                // $done_res = DB::table('booking_provider_history')->insert($provider_per_done);

                $prvider_new = ProviderHistory::where('provider_id', $provider_id)->first();

                if ($prvider_new) {

                    $prvider_new->update([
                        'total_bal' => $prvider_new->total_bal + $calculation_pro,
                        'available_bal' => $prvider_new->available_bal + $calculation_pro,
                    ]);
                } else {

                    ProviderHistory::create([
                        'provider_id' => $provider_id,
                        'total_bal' => $calculation_pro,
                        'available_bal' => $calculation_pro,
                    ]);
                }
            }



            if ($handyman_status == "7") {
                $cart_value_done = BookingOrders::where('id', $booking_id)->first();

                $provider_id_done = $cart_value_done->provider_id;
                $all_cart_id = $cart_value_done->cart_id;
                $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                $order_id = $all_order__id->order_id;

                $emailPreference = ProviderEmailBookingHold::where('get_email', 1)->first();

                // $booking_date_all = now();
                $booking_date_all = $cart_value_done->created_at;

                $user_all_done =  User::where('id', $user_id)->first();
                //  $email = $user_all_done->email;
                $handyman_name = $user_all_done->firstname;

                $provider_all_done =  User::where('id', $provider_id_done)->first();
                $email = $provider_all_done->email;
                $firstname = $provider_all_done->firstname;

                $dateTime = new \DateTime($booking_date_all);

                // Format the date and time
                $booking_date = $dateTime->format('d M, Y - h:i A');

                if ($emailPreference) {
                    // Send email on successful OTP verification
                    Mail::to($email)->send(
                        new ProviderBookingHold($email, $booking_id, $handyman_name, $booking_date, $firstname)
                    );
                }


                $emailPreference = UserEmailBookingHold::where('get_email', 1)->first();

                // $booking_date_all = now();
                $booking_date_all = now();

                $user_all_done =  User::where('id', $cart_value_done->user_id)->first();
                $email = $user_all_done->email;
                $firstname = $user_all_done->firstname;
                $handyman_name = $user_all_done->firstname;

                $dateTime = new \DateTime($booking_date_all);

                // Format the date and time
                $booking_date = $dateTime->format('d M, Y - h:i A');

                if ($emailPreference) {
                    // Send email on successful OTP verification
                    Mail::to($email)->send(
                        new UserBookingHold($email, $booking_id, $handyman_name, $booking_date, $firstname)
                    );
                }





                $FcmToken_done = User::where('id', $all_order__id->user_id)->value('device_token');

                $FcmToken = User::where('id', $provider_id_done)->value('device_token');

                $proviver_noti = NotificationsPermissions::where('id', "28")->where('status', "1")->first();

                $username =  User::where('id', $user_id)->first();



                // $firstname = $username->firstname;
                $handyman_name = $username->firstname . ' ' . $username->lastname;

                $message = str_replace(
                    ['[[ booking_id ]]', '[[ handyman_name ]]'],
                    ['#' . $booking_id, $handyman_name],
                    $proviver_noti->description
                );


                $type = "Service";


                $data = [
                    'title' => $proviver_noti->title,
                    //   'message' => '#'.$booking_id . ' ' . $proviver_noti->description . ' '.  $firstname,
                    'message' => $message,
                    'type' => $type,
                    'booking_id' => $booking_id,
                    'order_id' => $order_id,
                ];


                $this->sendNotification(new Request($data), $FcmToken);

                $this->sendNotification(new Request($data), $FcmToken_done);



                $user_ser = BookingOrders::where('id', $booking_id)->first();

                $all_user_id = $user_ser->user_id;
                $provider_id = $user_ser->provider_id;


                $not_all = [
                    'booking_id' => $request->input('booking_id'),
                    'handyman_id' => $user_id,
                    'provider_id' => $provider_id,
                    'user_id' => $all_user_id,
                    'title' => $proviver_noti->title,
                    // 'message' => $booking_id . ' ' . $proviver_noti->description . ' '.  $firstname,
                    'message' => $message,
                    'type' => "Service",
                    'created_at' => now(),
                ];

                $done = DB::table('user_notification')->insert($not_all);
            }



            if ($handyman_status == "4") {

                $booking_id = $request->input('booking_id');
                $cart_value_done = BookingOrders::where('id', $booking_id)->first();

                $user = User::where('id', $user_id)->first();

                $provider_id_done = $cart_value_done->provider_id;
                // $handyman_id_done = $cart_value_done->work_assign_id;
                $user_id_done = $cart_value_done->user_id;
                $all_cart_id = $cart_value_done->cart_id;
                $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                $order_id = $all_order__id->order_id;



                $FcmToken = User::where('id', $user_id_done)->value('device_token');

                $FcmToken_done = User::where('id', $provider_id_done)->value('device_token');

                $proviver_all_noti = NotificationsPermissions::where('id', "37")->where('status', "1")->first();


                $username =  User::where('id', $user_id)->first();

                // $firstname = $username->firstname;
                $handyman_name = $username->firstname . ' ' . $username->lastname;


                $message = str_replace(
                    ['[[ booking_id ]]', '[[ handyman_name ]]'],
                    ['#' . $booking_id, $handyman_name],
                    $proviver_all_noti->description
                );
                $type = "Service";


                $data = [
                    'title' => $proviver_all_noti->title,
                    // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description. ' '.  $firstname,
                    'message' => $message,
                    'type' => $type,
                    'booking_id' => $booking_id,
                    'order_id' => $order_id,
                ];

                //  dd($data);

                $this->sendNotification(new Request($data), $FcmToken);

                $this->sendNotification(new Request($data), $FcmToken_done);

                $user_ser_done = BookingOrders::where('id', $booking_id)->first();

                //  $all_user_id = $user_ser_done->user_id;
                //  $provider_id = $user_ser_done->provider_id;


                $not_all_done = [
                    'booking_id' => $request->input('booking_id'),
                    // 'handyman_id' => $handyman_id_done,
                    'provider_id' => $provider_id_done,
                    'user_id' => $user_id_done,
                    'title' => $proviver_all_noti->title,
                    // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description. ' '.  $firstname,
                    'message' => $message,
                    'type' => "Service",
                    'created_at' => now(),
                    'requests_status' => "0",
                ];

                $done = DB::table('user_notification')->insert($not_all_done);
            }

            if ($handyman_status == "2") {

                $booking_id = $request->input('booking_id');



                // $emailPreference = HandymanEmailBookingAccepted::where('get_email', 1)->first();

                // $booking_date_all = now();

                // $user_all_done =  User::where('id', $user_id)->first();
                // //  $email = $user_all_done->email;
                // $provider_name = $user_all_done->firstname;

                // $provider_all_done = User::where('id', $user_id)->first();
                // $email = $provider_all_done->email;
                // $firstname = $provider_all_done->firstname;

                // $dateTime = new \DateTime($booking_date_all);

                // // Format the date and time
                // $booking_date = $dateTime->format('d M, Y - h:i A');

                // if ($emailPreference) {
                //     // Send email on successful OTP verification
                //     Mail::to($email)->send(
                //         new HandymanBookingAccepted($email, $booking_id, $provider_name, $booking_date, $firstname)
                //     );
                // }



                $emailPreference_all = ProviderEmailBookingAccepted::where('get_email', 1)->first();

                $booking_date_all = now();

                $user_all_do =  User::where('id', $user_id)->first();
                //  $email = $user_all_done->email;
                $provider_name = $user_all_do->firstname;
                $handyman_name = $user_all_do->firstname;

                $cart_value_done = BookingOrders::where('id', $booking_id)->first();
                // $pro_id = $cart_value_done->provider_id;


                $all_cart_id = $cart_value_done->cart_id;
                $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                $order_id = $all_order__id->order_id;

                $provider_all_doit = User::where('id', $cart_value_done->provider_id)->first();
                $to_email = $provider_all_doit->email;


                $firstname = $provider_all_doit->firstname;

                $dateTime = new \DateTime($booking_date_all);

                // Format the date and time
                $booking_date = $dateTime->format('d M, Y - h:i A');

                if ($emailPreference_all) {
                    // Send email on successful OTP verification
                    Mail::to($to_email)->send(
                        new ProviderBookingAccepted($to_email, $booking_id, $handyman_name, $booking_date, $firstname)
                    );
                }


                $provider_id_done = $cart_value_done->provider_id;

                $user_id_done = $cart_value_done->user_id;

                $FcmToken = User::where('id', $provider_id_done)->value('device_token');



                $proviver_all_noti = NotificationsPermissions::where('id', "42")->where('status', "1")->first();

                $user_dynamic = User::where('id', $user_id)->first();
                $handyman_name = $user_dynamic->firstname;


                // $message = str_replace(
                //     ['[[ booking_id ]]'],
                //     ['#' . $booking_id],
                //     $proviver_all_noti->description
                // );

                $message = str_replace(
                    ['[[ booking_id ]]', '[[ handyman_name ]]'],
                    ['#' . $booking_id, $handyman_name],
                    $proviver_all_noti->description
                );


                // $username =  User::where('id', $user_id)->first();

                // $firstname = $username->firstname;
                // $firstname = $username->firstname . ' ' . $username->lastname;
                $type = "Service";


                $data = [
                    'title' => $proviver_all_noti->title,
                    // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
                    'message' => $message,
                    'type' => $type,
                    'booking_id' => $booking_id,
                    'order_id' => $order_id,
                ];
                // dd($data);


                $this->sendNotification(new Request($data), $FcmToken);

                // $this->sendNotification(new Request($data), $FcmToken_token);



                $user_ser_done = BookingOrders::where('id', $booking_id)->first();

                //  $all_user_id = $user_ser_done->user_id;
                //  $provider_id = $user_ser_done->provider_id;


                $not_all_done = [
                    'booking_id' => $request->input('booking_id'),
                    'handyman_id' => "0",
                    'provider_id' => $provider_id_done,
                    'user_id' => "0",
                    'title' => $proviver_all_noti->title,
                    //  'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
                    'message' => $message,
                    'type' => "Service",
                    'created_at' => now(),
                    // 'requests_status' => "1",
                ];

                $done = DB::table('user_notification')->insert($not_all_done);

                $FcmToken_token = User::where('id', $provider_id_done)->value('device_token');




                // $proviver_all_noti_does = NotificationsPermissions::where('id', "42")->where('status', "1")->first();

                // $user_dynamic = User::where('id', $user_id)->first();
                // $handyman_name = $user_dynamic->firstname();

                // $message = str_replace(
                //     ['[[ booking_id ]]', '[[ handyman_name ]]'],
                //     ['#' . $booking_id],
                //     $proviver_all_noti_does->description
                // );

                // $type = "Service";


                // $data_pro = [
                //     'title' => $proviver_all_noti_does->title,
                //     // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
                //     'message' => $message,
                //     'type' => $type,
                //     'booking_id' => $booking_id,
                //     'order_id' => $order_id,
                // ];

                // $this->sendNotification(new Request($data_pro), $FcmToken_token);


                // $not_all_done_res = [
                //     'booking_id' => $request->input('booking_id'),
                //     'handyman_id' => "0",
                //     'provider_id' => $provider_id_done,
                //     'user_id' => "0",
                //     'title' => $proviver_all_noti->title,
                //     //  'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
                //     'message' => $message,
                //     'type' => "Service",
                //     'created_at' => now(),
                //     // 'requests_status' => "1",
                // ];

                // $done = DB::table('user_notification')->insert($not_all_done_res);
            }



            $temp = [
                "response_code" => "1",
                "message" => "Handyman Status Update successfully",
                "status" => "success",
                // "unread_count" => $approve,
            ];

            return response()->json($temp);
        } catch (\Throwable $th) {
            //throw $th;
            // return $this->sendError("User not Successfully", $th->getMessage());
            $temp = [
                "response_code" => "1",
                "message" => "Handyman Status Update successfully",
                "status" => "success",
                // "unread_count" => $approve,
            ];

            return response()->json($temp);
        }
    }

    public function handyman_wallet_list_old(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        $notifications = BookingHandymanHistory::where('handyman_id', $user_id)->orderBy('id', 'DESC')->get();

        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list = [];

            $questions_list['id'] = $notification->id;
            $questions_list['handyman_id'] = $notification->handyman_id;
            $questions_list['provider_id'] = $notification->provider_id;
            $questions_list['booking_id'] = $notification->booking_id;
            $questions_list['service_id'] = $notification->service_id;
            $questions_list['user_id'] = $notification->user_id;
            $questions_list['commision_persontage'] = $notification->commision_persontage;
            $questions_list['amount'] = $notification->amount;
            $questions_list['created_at'] = $notification->created_at;
            $questions_list['handman_status'] = $notification->handman_status;

            $user = User::find($notification->user_id);

            $questions_list['customer_name'] = $user->firstname . ' ' . $user->lastname;

            $user_all = User::find($notification->provider_id);

            $questions_list['provider_name'] = $user_all->firstname . ' ' . $user_all->lastname;

            $service = Service::where('id', $notification->service_id)->first();

            $questions_list['service_name'] = $service->service_name;



            $list_notification[] = $questions_list;
        }

        $totalAmount = BookingHandymanHistory::where('handyman_id', $user_id)
            ->where('handman_status', '0')
            ->orwhere('handman_status', '1')
            ->sum('amount');


        if (Bankdetails::where('user_id', $user_id)->where('bank_name', '!=', null)->where('branch_name', '!=', null)->where('acc_number', '!=', null)->where('ifsc_code', '!=', null)->where('mobile_number', '!=', null)->exists()) {
            $login_status = "1";
        } else {
            $login_status = "0";
        }


        $bank_details = Bankdetails::where('user_id', $user_id)->first();

        if ($bank_details) {

            $bank_details->id = $bank_details->id;
            $bank_details->user_id = (string)$bank_details->user_id;
            $bank_details->provider_id = $bank_details->provider_id ?? "";
            $bank_details->bank_name = $bank_details->bank_name;
            $bank_details->branch_name = $bank_details->branch_name;
            $bank_details->acc_number = $bank_details->acc_number;
            $bank_details->ifsc_code = $bank_details->ifsc_code;
            $bank_details->mobile_number = $bank_details->mobile_number;
        }



        if ($list_notification) {
            $result = [
                "response_code" => "1",
                "message" => "Handyman Wallet List Found.",
                "detail" => $list_notification,
                "totalAmount" => (string)$totalAmount,
                "add_bank_details" => $login_status,
                "bank_details" => $bank_details,
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Handyman Wallet List Not Found",
                "detail" => $list_notification,
                "totalAmount" => (string)$totalAmount,
                "add_bank_details" => $login_status,
                "bank_details" => $bank_details,
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }

    public function handyman_wallet_list(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        $notifications = BookingHandymanHistory::where('handyman_id', $user_id)->orderBy('id', 'DESC')->get();

        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list = [];
            $questions_list['id'] = $notification->id;
            $questions_list['handyman_id'] = $notification->handyman_id;
            $questions_list['provider_id'] = $notification->provider_id;
            $questions_list['booking_id'] = $notification->booking_id;
            $questions_list['service_id'] = $notification->service_id;
            $questions_list['user_id'] = $notification->user_id;
            $questions_list['commision_persontage'] = $notification->commision_persontage;
            $questions_list['amount'] = $notification->amount;
            $questions_list['created_at'] = $notification->created_at;
            $questions_list['handman_status'] = $notification->handman_status;
            $questions_list['payment_method'] = $notification->payment_method ?? "";

            // Fetch user details
            $user = User::find($notification->user_id);
            if ($user) {
                $questions_list['customer_name'] = $user->firstname . ' ' . $user->lastname;
            } else {
                $questions_list['customer_name'] = 'Unknown Customer';
            }

            // Fetch provider details
            $provider = User::find($notification->provider_id);
            if ($provider) {
                $questions_list['provider_name'] = $provider->firstname . ' ' . $provider->lastname;
            } else {
                $questions_list['provider_name'] = 'Unknown Provider';
            }

            // Fetch service details
            $service = Service::find($notification->service_id);
            if ($service) {
                $questions_list['service_name'] = $service->service_name;
            } else {
                $questions_list['service_name'] = 'Unknown Service';
            }

            $list_notification[] = $questions_list;
        }

        // Total amount calculation with proper condition grouping
        // $totalAmount = BookingHandymanHistory::where('handyman_id', $user_id)
        //     ->where(function ($query) {
        //         $query->where('handman_status', '0')
        //             ->orWhere('handman_status', '1');
        //     })
        //     ->sum('amount');

        $totalAmount = BookingHandymanHistory::where('handyman_id', $user_id)
            ->where('handman_status', '!=', '2')
            ->sum('amount');

        // Check if bank details exist
        $login_status = Bankdetails::where('user_id', $user_id)
            ->whereNotNull('bank_name')
            ->whereNotNull('branch_name')
            ->whereNotNull('acc_number')
            ->whereNotNull('ifsc_code')
            ->whereNotNull('mobile_number')
            ->exists() ? "1" : "0";

        // Fetch bank details
        $bank_details = Bankdetails::where('user_id', $user_id)->first();

        if ($list_notification) {
            $result = [
                "response_code" => "1",
                "message" => "Handyman Wallet List Found.",
                "detail" => $list_notification,
                "totalAmount" => (string)$totalAmount,
                "add_bank_details" => $login_status,
                "bank_details" => $bank_details,
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Handyman Wallet List Not Found",
                "detail" => $list_notification,
                "totalAmount" => (string)$totalAmount,
                "add_bank_details" => $login_status,
                "bank_details" => $bank_details,
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }


    public function withdrawMoney_handyman(Request $request)
    {
        try {
            //code...
            $validator = FacadesValidator::make($request->all(), [
                'amount' => 'required',
                'booking_id' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('error', $validator->errors(), 401);
            }

            //   $myId = Auth::user()->id;
            $myId = Auth::user()->token()->user_id;
            $booking_id = $request->input('booking_id');

            $v_store = BookingHandymanHistory::where('handyman_id', $myId)->where('booking_id', $booking_id)->first();
            if (
                BookingHandymanHistory::where('handyman_id', $myId)->where('booking_id', $booking_id)
                ->where('handman_status', "1")
                ->exists()
            ) {
                $response = [
                    'success' => 'false',
                    'message' => 'Not Pending Request Added.',
                ];
                return response()->json($response, 200);
            }


            if ($request->amount <= $v_store->amount) {
                // $totalreq = ProviderReqModel::where('provider_id', $myId)->sum('amount');
                // $totalreq = VendorReqModel::where('v_id', $myId)->where('status', 0)->sum('amount');

                $v_store->update([
                    'handman_status' => "1",
                ]);



                $FcmToken = User::where('id', $v_store->provider_id)->value('device_token');

                $proviver_all_noti = NotificationsPermissions::where('id', "39")->where('status', "1")->first();


                $emailPreference = ProviderEmailPaymentRequestReceived::where('get_email', 1)->first();

                $provider_id = $v_store->provider_id;
                $provider_all_done =  User::where('id', $v_store->provider_id)->first();
                $booking_date_all = now();
                $firstname = $provider_all_done->firstname;
                $email = $provider_all_done->email;

                $user_all_done =  User::where('id', $myId)->first();

                $provider_name = $user_all_done->firstname;
                $handyman_name = $user_all_done->firstname;

                $service_name =  Service::where('id', $v_store->service_id)->value('service_name');

                $dateTime = new \DateTime($booking_date_all);
                $amount = $v_store->amount;

                // Format the date and time
                $booking_date = $dateTime->format('d M, Y - h:i A');

                if ($emailPreference) {
                    // Send email on successful OTP verification
                    Mail::to($email)->send(
                        new ProviderPaymentRequestReceived($email, $booking_id, $handyman_name, $booking_date, $firstname, $amount, $service_name)
                    );
                }


                $booking_services_name =  Service::where('id', $v_store->service_id)->value('service_name');

                $username =  User::where('id', $myId)->first();

                // $firstname = $username->firstname;
                $handyman_name = $username->firstname . ' ' . $username->lastname;

                // $amount = $v_store->amount;

                $message = str_replace(
                    ['[[ booking_services_name ]]', '[[ amount ]]', '[[ handyman_name ]]'],
                    [$booking_services_name, $amount, $handyman_name],
                    $proviver_all_noti->description
                );

                // $firstname = $username->firstname;
                $type = "payment_requests";


                $data = [
                    'title' => $proviver_all_noti->title,
                    // 'message' => $servicename . ' ' . $proviver_all_noti->description . ' '. '$'.$v_store->amount,
                    'message' => $message,
                    'type' => $type,
                    'booking_id' => $booking_id,
                    'order_id' => 0,
                ];

                $this->sendNotification(new Request($data), $FcmToken);

                $not_all_done = [
                    'booking_id' => $booking_id,
                    'handyman_id' => 0,
                    'provider_id' => $provider_id,
                    'user_id' => "0",
                    'title' => $proviver_all_noti->title,
                    // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description. ' '.  $firstname,
                    'message' => $message,
                    'type' => "payment_requests",
                    'created_at' => now(),
                    'requests_status' => "0",
                    'review_noti' => "1",
                ];

                $done = DB::table('user_notification')->insert($not_all_done);

                return $this->sendMessage('Requset send successfully.');


                // if ($totalreq + $request->amount <= $v_store->available_bal) {
                //   ProviderReqModel::create([
                //     'provider_id' => $myId,
                //     'amount' => $request->amount,
                //     'status' => 0,
                //   ]);
                //   $v_store->update([
                //     'available_bal' => $v_store->available_bal - $request->amount,
                //   ]);
                //   return $this->sendMessage('Requset send successfully.');
                // }
                // $response = [
                //     'success' => "false",
                //     'message' => "Maximum Request Added."
                // ];
                // return response()->json($response, 200);
                // return $this->sendError("Maximum Request Added.");
            }
            $response = [
                'success' => 'false',
                'message' => 'Insufficient balance.',
            ];
            return response()->json($response, 200);
            // return $this->sendError("Insufficient balance.");
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('Solve this error.', $th->getMessage());
        }
    }

    public function handyman_wallet_transaction_history(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        $notifications = BookingHandymanHistory::where('handyman_id', $user_id)->where('handman_status', "2")->orderBy('id', 'DESC')->get();

        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['id'] = $notification->id;
            $questions_list['handyman_id'] = $notification->handyman_id;
            $questions_list['provider_id'] = $notification->provider_id;
            $questions_list['booking_id'] = $notification->booking_id;
            $questions_list['service_id'] = $notification->service_id;
            // $questions_list['user_id'] = $notification->user_id;
            $questions_list['commision_persontage'] = $notification->commision_persontage;
            $questions_list['amount'] = $notification->amount;
            $questions_list['date_of_transfer'] = $notification->updated_at;
            $questions_list['handman_status'] = $notification->handman_status;

            // $user = User::find($notification->user_id);

            // $questions_list['customer_name'] = $user->firstname . ' ' . $user->lastname;

            $user_all = User::find($notification->provider_id);

            $questions_list['provider_name'] = $user_all->firstname . ' ' . $user_all->lastname;

            $service = Service::where('id', $notification->service_id)->first();

            $questions_list['service_name'] = $service->service_name;



            $list_notification[] = $questions_list;
        }

        $totalAmount = BookingHandymanHistory::where('handyman_id', $user_id)
            ->where('handman_status', '0')
            ->orwhere('handman_status', '1')
            ->sum('amount');

        if ($list_notification) {
            $result = [
                "response_code" => "1",
                "message" => "Handyman Wallet List Found.",
                "detail" => $list_notification,
                // "totalAmount" => $totalAmount,
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Handyman Wallet List Not Found",
                "detail" => $list_notification,
                // "totalAmount" => $totalAmount,
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }

    public function handyman_add_bank_details(Request $request)
    {
        // dd($request->all());

        $user_id = Auth::user()->token()->user_id;
        // $id = $request->input('id');

        // if($id){

        $handyman = Bankdetails::where('user_id', $user_id)->first();

        if ($handyman) {
            $itemDtl = Bankdetails::where('user_id', $user_id)->first();

            $input = [
                'bank_name' => $request->bank_name ? $request->bank_name : $itemDtl->bank_name,
                'branch_name' => $request->branch_name ? $request->branch_name : $itemDtl->branch_name,
                'acc_number' => $request->acc_number ? $request->acc_number : $itemDtl->acc_number,
                'ifsc_code' => $request->ifsc_code ? $request->ifsc_code : $itemDtl->ifsc_code,
                'mobile_number' => $request->mobile_number ? $request->mobile_number : $itemDtl->mobile_number,

            ];
            // print_r($input);
            // exit;

            Bankdetails::where('user_id', $user_id)->update($input);

            return $this->sendResponse($input, 'Handyman Bank Details Added successfully.');
        }
        // }

        // $handyman = Bankdetails::where('user_id', $user_id)->first();

        // if($handyman){


        //      $result = [
        //         "response_code" => "0",
        //         "message" => "Handyman Bank Details is already added.",
        //         "status" => "failure",
        //     ];
        //     return response()->json($result);

        // }

        $validator = Validator::make($request->all(), [
            'branch_name' => 'required',
            'bank_name' => 'required',
            'acc_number' => 'required',
            'ifsc_code' => 'required',
            'mobile_number' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }




        // $input = $request->all();

        $done['branch_name'] = $request->input('branch_name');
        $done['bank_name'] = $request->input('bank_name');
        $done['acc_number'] = $request->input('acc_number');
        $done['ifsc_code'] = $request->input('ifsc_code');
        $done['mobile_number'] = $request->input('mobile_number');
        $done['user_id'] = $user_id;

        $provider = Bankdetails::create($done);

        return $this->sendResponse($done, 'Handyman Bank Details Added successfully.');
    }

    public function handyman_check_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'otp' => 'required',
        ]);
        if ($validator->fails()) {

            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        $user_id = Auth::user()->token()->user_id;

        $otp = $request->input('otp');
        $booking_id = $request->input('booking_id');


        try {
            // $phone = $request->input('phone');
            // $otp = $request->input('otp');
            // $where = 'mobile_no="' . $mob_no . '"';
            // $data = array(
            //     "handyman_status" => $handyman_status,
            //     //  "device_token" => $device_token,
            // );
            $book_all = BookingOrders::where('work_assign_id', $user_id)->where('id', $booking_id)->where('otp', $otp)->first();

            if ($book_all) {


                $data = array(
                    "handyman_status" => "4",
                    //  "device_token" => $device_token,
                );
                BookingOrders::where('work_assign_id', $user_id)->where('id', $booking_id)->update($data);


                $provider_id_done = BookingOrders::where('id', $booking_id)->first();


                $pro_id = $provider_id_done->provider_id;
                $handyman_id_done = $provider_id_done->work_assign_id;
                $user_id_done = $provider_id_done->user_id;


                $all_cart_id = $provider_id_done->cart_id;
                $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                $order_id = $all_order__id->order_id;



                $booking_date_all = $provider_id_done->created_at;
                $user_all_done =  User::where('id', $pro_id)->first();
                $email = $user_all_done->email;
                $firstname = $user_all_done->firstname;

                $emailPreference = ProviderEmailOrderInProgress::where('get_email', 1)->first();

                $provider_all_done =  User::where('id', $user_id)->first();
                $handyman_name = $provider_all_done->firstname;

                $dateTime = new \DateTime($booking_date_all);

                // Format the date and time
                $booking_date = $dateTime->format('d M, Y - h:i A');

                if ($emailPreference) {
                    // Send email on successful OTP verification
                    Mail::to($email)->send(
                        new ProviderOrderInProgress($email, $booking_id, $handyman_name, $booking_date, $firstname)
                    );
                }


                $user_id_done = $provider_id_done->user_id;


                $booking_date_all = now();
                $user_all_done =  User::where('id', $user_id_done)->first();
                $email = $user_all_done->email;
                $firstname = $user_all_done->firstname;

                $emailPreference = UserEmailBookingInProgress::where('get_email', 1)->first();

                $provider_all_done =  User::where('id', $pro_id)->first();
                $provider_name = $provider_all_done->firstname;

                $dateTime = new \DateTime($booking_date_all);

                // Format the date and time
                $booking_date = $dateTime->format('d M, Y - h:i A');

                if ($emailPreference) {
                    // Send email on successful OTP verification
                    Mail::to($email)->send(
                        new UserBookingInProgress($email, $booking_id, $provider_name, $booking_date, $firstname)
                    );
                }



                $FcmToken = User::where('id', $pro_id)->value('device_token');

                $FcmToken_done = User::where('id', $user_id_done)->value('device_token');

                $proviver_all_noti = NotificationsPermissions::where('id', "24")->where('status', "1")->first();

                $type = "Service";

                $message = str_replace(
                    ['[[ booking_id ]]'],
                    ['#' . $booking_id],
                    $proviver_all_noti->description
                );


                $data = [
                    'title' => $proviver_all_noti->title,
                    // 'message' => '#' . $booking_id . ' ' . $proviver_all_noti->description,
                    'message' => $message,
                    'type' => $type,
                    'booking_id' => $booking_id,
                    'order_id' => $order_id,
                ];

                //  dd($data);

                $this->sendNotification(new Request($data), $FcmToken);

                $this->sendNotification(new Request($data), $FcmToken_done);


                $user_ser_done = BookingOrders::where('id', $booking_id)->first();

                //  $all_user_id = $user_ser_done->user_id;
                //  $provider_id = $user_ser_done->provider_id;


                $not_all_done = [
                    'booking_id' => $request->input('booking_id'),
                    'handyman_id' => $handyman_id_done,
                    'provider_id' => $pro_id,
                    'user_id' => $user_id_done,
                    'title' => $proviver_all_noti->title,
                    // 'message' => '#' . $booking_id . ' ' . $proviver_all_noti->description,
                    'message' => $message,
                    'type' => "Service",
                    'created_at' => now(),
                ];

                $done = DB::table('user_notification')->insert($not_all_done);
            }


            // $approve = Chat::where('to_user', $request->user_id)->where('message_read', '0')->count();

            if ($book_all) {
                $temp = [
                    "response_code" => "1",
                    "message" => "Handyman Verified Otp.",
                    "status" => "success",

                ];

                return response()->json($temp);
            } else {


                $temp = [
                    "response_code" => "0",
                    "message" => "Handyman Not Verified Otp",
                    "status" => "success",
                    // "unread_count" => $approve,
                ];

                return response()->json($temp);
            }

            // return $this->sendMessage("User Online Update successfully");
            // print_r($user_data); 
            // echo $user_data['mobile_no'];
            // if (isset($user_data['mobile_no'])) {echo"yes";}else{echo "no";}

            // exit;
        } catch (\Throwable $th) {
            //throw $th;
            // return $this->sendError("User not Successfully", $th->getMessage());
            $temp = [
                "response_code" => "1",
                "message" => "Handyman Verified Otp",
                "status" => "success",
                // "unread_count" => $approve,
            ];

            return response()->json($temp);
        }
    }

    public function add_service_proof(Request $request)
    {

        $user_id = Auth::user()->id;
        // $request->validate([
        //     'cat_id' => 'required|integer',
        //     'store_id' => 'required|integer',
        //     'service_name' => 'required|string|max:255',
        //     'service_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max file size is 2MB
        //     'v_id' => 'nullable|integer',
        //     'service_price' => 'nullable|numeric',
        //     'service_description' => 'nullable|string',
        //     'price_unit' => 'nullable|string',
        //     'duration' => 'nullable|string',
        // ]);


        $res_image = array();

        if (request()->hasFile('image')) {
            $files = request()->file('image');

            foreach ($files as $file) {
                $validator = Validator::make(['image' => $file], [
                    'image' => 'required|mimes:gif,jpg,png,jpeg',
                ]);

                if ($validator->fails()) {
                    $temp["response_code"] = "0";
                    $temp["message"] = $validator->errors()->first();
                    $temp["status"] = "failure";
                    return response()->json($temp);
                }

                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                // $filePath = 'assets/images/posts';

                $file->move(public_path('images/proof_images'), $fileName);

                // Move the uploaded file to the desired location
                // $file->move($filePath, $fileName);

                array_push($res_image, $fileName);
            }
        }
        $booking_id = $request->input('booking_id');
        $all_user = BookingOrders::where('id', $booking_id)->first();
        $user_id_done = $all_user->user_id;

        $data = [
            'service_name' => $request->input('service_name'),
            'notes' => $request->input('notes'),
            'handyman_id' => $user_id,
            'booking_id' => $request->input('booking_id'),
            'rev_star' => $request->input('rev_star'),
            'rev_text' => $request->input('rev_text'),
            'image' => implode('::::', $res_image),
            'user_id' => $user_id_done,
            // 'created_date' => now()->timestamp,
        ];

        if (DB::table('service_proof')->insert($data)) {
            return response()->json([
                'response_code' => '1',
                'message' => 'Service Proof Added Success',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'response_code' => '0',
                'msg' => 'Database Error',
                'status' => 'failure'
            ]);
        }
    }


    public function provider_info_by_handyman(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        $provider_info = User::where('id', $user_id)->first();

        // print_r($provider_info);
        // die;

        // $provider = $provider_info->provider_id;

        $provider_details = User::where('id', $provider_info->provider_id)->first();

        $all_image = DefaultImage::where('people_id', "1")->first();
        $my_image = $all_image->image;


        // $list_notification = [];


        $questions_list = [
            'firstname' => $provider_details->firstname ?? "",
            'lastname' => $provider_details->lastname ?? "",
            'email' => $provider_details->email ?? "",
            'mobile' => $provider_details->mobile ?? "",
            'country_code' => $provider_details->country_code ?? "",
            'user_role' => $provider_details->user_role ?? "",
            'location' => $provider_details->location ?? "",
            'profile_pic' => $provider_details ?  url('/images/user/' . $provider_details->profile_pic) : url('/images/user/' . $my_image),
        ];

        // $products = DB::table('services')
        //     ->select('id', 'service_name', 'service_image', 'cat_id', 'res_id', 'service_price')
        //     ->where('v_id', $provider_info->provider_id)
        //     ->orderBy('id', 'desc')
        //     ->get();

        $products = DB::table('services')
            ->leftJoin('service_images', 'services.id', '=', 'service_images.service_id')
            ->select('services.id', 'services.service_name', 'services.cat_id', 'services.res_id', 'services.service_price', DB::raw("GROUP_CONCAT(service_images.service_images) as service_image"))
            ->where('services.v_id', $provider_info->provider_id)
            ->groupBy('services.id')
            ->orderBy('services.id', 'desc')
            ->get();

        $total_reviews_count = 0;
        $total_reviews_sum = 0;
        $total_reviews_count = 0;
        $total_average_count = 0;
        $service_count = $products->count();

        if ($products->isNotEmpty()) {
            foreach ($products as $product) {

                $category = Category::where('id', $product->cat_id)->first();
                $product->cat_name = $category->c_name ?? "";


                $subcategory = SubCategory::where('id', $product->res_id)->first();

                $product->sub_cat_name = $subcategory->c_name ?? "";


                $product->service_name = $product->service_name ?? "";
                // $images = explode("::::", $product->service_image);
                // $imgsa = [];

                // foreach ($images as $image) {
                //     $imgsa[] =  $imgsa[] = url('/images/service_images/' . $image);
                // }

                // $product->service_image = $imgsa;

                $product->service_image = array_map(fn($image) => url('/images/service_images/' . $image), explode(',', $product->service_image));

                $total_reviews = ServiceReview::where('service_id', $product->id)->count();

                $average_review = ServiceReview::where('service_id', $product->id)->avg('star_count');

                $product->avg_review = (string)number_format($average_review, 1);

                $product->total_review = (string)$total_reviews;

                $total_reviews = ServiceReview::where('service_id', $product->id)->count();
                $average_review = ServiceReview::where('service_id', $product->id)->avg('star_count');

                $product->avg_review = (string)number_format($average_review, 1);
                $product->total_review = (string)$total_reviews;

                $total_reviews_count += $total_reviews;
                $total_average_count += $average_review;
                if ($total_reviews) {
                    $total_reviews_sum = $total_average_count / $total_reviews_count;
                }

                // $product->total_reviews_count = $total_reviews_count;
                // $product->total_reviews_sum = $total_reviews_sum;


            }
        }

        $all_services = Product::where('vid', $provider_info->provider_id)
            ->with('productImages')
            ->orderByDesc('product_id')
            ->get();


        $list_notification_done = [];

        foreach ($all_services as $done) {



            $questions_all_list['product_id'] = $done->product_id;
            $questions_all_list['cat_id'] = (string)$done->cat_id;
            $questions_all_list['vid'] = (string)$done->vid;
            $questions_all_list['product_name'] = $done->product_name;
            $questions_all_list['product_price'] = $done->product_price;
            $questions_all_list['product_discount_price'] = $done->product_discount_price ?? "";

            $product_category = ProductCategory::where('id', $done->cat_id)->first();
            $questions_all_list['cat_name'] = $product_category->c_name ?? "";

            $provider_search = CartItemsModel::where('user_id', $user_id)->where('checked', '0')->where('product_id', $done->product_id)->first();

            $questions_all_list['is_cart'] = $provider_search ? "1" : "0";

            // $images = explode("::::", $done->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_all_list['product_image'] = $imgsa;

            $imgsa = [];

            foreach ($done->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $questions_all_list['product_image'] = $imgsa;

            // $questions_all_list['product_review'] = "3.5";

            $total_reviews = ProductReview::where('product_id', $done->product_id)->count();

            $average_review = ProductReview::where('product_id', $done->product_id)->avg('star_count');

            $questions_all_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_all_list['total_review'] = (string)$total_reviews;

            $questions_all_list['is_featured'] = $done->is_features;

            $user = User::where('id', $done->vid)->first();
            $questions_all_list['provider_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : "";
            $list_notification_done[] = $questions_all_list;
        }

        if ($questions_list) {
            $result = [
                "response_code" => "1",
                "message" => "Provider Details..",
                "detail" => $questions_list,
                "service_list" => $products,
                "product_list" => $list_notification_done,
                "total_person_review" => $total_reviews_count,
                "total_avg_review" =>  $total_reviews_sum ? number_format($total_reviews_sum, 2) : "0.00",

                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Not found notification",
                "detail" => "",
                "service_list" => $products,
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }

    public function user_home(Request $request)
    {
        // $user_id = Auth::user()->token()->user_id;

        $user_id = Auth::id();

        $perPage = 10;
        $pageNo = $request->page_no ?? 1;
        // $notifications = Service::where('is_delete', "0")->where('status', "1")->where('is_features', '=', "1")
        //     ->orderByDesc('id')
        //     ->get();

        $notifications = Service::where('is_delete', "0")
            ->where('status', "1")
            ->where('is_features', '=', "1")
            ->with('serviceImages')
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], 'page', $pageNo);


        $all_service = Service::where('is_delete', "0")
            ->where('status', "1")
            ->where('is_features', '=', "1")->count();




        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ServiceReview::where('service_id', $notification->id)->count();

            $average_review = ServiceReview::where('service_id', $notification->id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;


            $user = User::where('id', $notification->v_id)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;



            if ($user) {

                $fullName = $user->firstname . ' ' . $user->lastname;
                $questions_list['provider_name'] = $fullName;
                // $questions_list['provider_name'] = $user->firstname;
                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $fullName = "";
                $questions_list['provider_name'] = $fullName;
                // $questions_list['provider_name'] = $user->firstname;
                $questions_list['profile_pic'] = "";
            }

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['service_image'] = $imgsa;

            $imgsa = [];

            // Fetch images from `service_images` table
            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            // Assign images to the array
            $questions_list['service_image'] = $imgsa;

            if ($user_id) {

                $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
                $questions_list['is_like'] = $user_like ? "1" : "0";
            } else {
                $questions_list['is_like'] = "0";
            }

            // $questions_list['is_likes'] = "1";

            $list_notification[] = $questions_list;
        }

        // $users_online = User::where('id', $user_id)->first();

        // $online = $users_online->is_online;

        // $all_services = Service::where('v_id', $user_id)
        //     ->orderByDesc('id')
        //     ->get();

        // ServiceReview::

        //         $reviews = ServiceReview::selectRaw('*, COUNT(*) as review_count')
        // ->groupBy('service_id')
        // ->orderByDesc('review_count')
        // ->get();

        // $reviews = ServiceReview::selectRaw('service_id, COUNT(*) as review_count')
        // ->groupBy('service_id')->get();

        // $reviews =  Product::where('is_delete', "0")->orderByDesc('product_id')->get();
        $reviews = Product::where('is_delete', "0")
            ->orderByDesc('product_id')
            ->with('productImages')
            ->paginate($perPage, ['*'], 'page', $pageNo);


        $all_product = Product::where('is_delete', "0")->count();



        $list_notification_done = [];

        foreach ($reviews as $done) {

            $questions_all_list['product_id'] = $done->product_id;
            $questions_all_list['cat_id'] = (string)$done->cat_id;
            $questions_all_list['vid'] = (string)$done->vid;
            $questions_all_list['product_name'] = $done->product_name;
            $questions_all_list['product_price'] = (string)$done->product_price;
            $questions_all_list['product_discount_price'] = (string)$done->product_discount_price ?? "";
            // $questions_all_list['avg_review'] = "4.5";
            // $questions_all_list['total_review'] = "200";

            $total_reviews = ProductReview::where('product_id', $done->product_id)->count();

            $average_review = ProductReview::where('product_id', $done->product_id)->avg('star_count');

            $questions_all_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_all_list['total_review'] = (string)$total_reviews;

            $product_like = ProductLike::where('product_id', $done->product_id)->where('user_id', $user_id)->first();
            $questions_all_list['is_like'] = $product_like ? "1" : "0";

            $user = User::where('id', $done->vid)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                // $questions_all_list['provider_name'] = $user->firstname ?? "";

                $questions_all_list['provider_name'] = $user->firstname . ' ' . $user->lastname;

                $questions_all_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $questions_all_list['provider_name'] = "";

                $questions_all_list['profile_pic'] =  "";
            }

            // $images = explode("::::", $done->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_all_list['product_image'] = $imgsa;
            $imgsa = [];

            foreach ($done->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image); // 'image_path' is the column name
            }

            // Assign images to the array
            $questions_all_list['product_image'] = $imgsa;

            // $list_notification[] = $questions_list;

            $list_notification_done[] = $questions_all_list;
        }

        $userservices = Service::where('is_delete', "0")
            ->where('status', "1")
            ->where('is_features', '=', "0")
            ->with('serviceImages')
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], 'page', $pageNo);

        $userlist_notification = [];

        foreach ($userservices as $usernotification) {
            $userquestions_list['id'] = $usernotification->id;
            $userquestions_list['cat_id'] = (string)$usernotification->cat_id;
            $userquestions_list['res_id'] = (string)$usernotification->res_id;
            $userquestions_list['v_id'] = (string)$usernotification->v_id;
            $userquestions_list['service_name'] = $usernotification->service_name;
            $userquestions_list['service_price'] = $usernotification->service_price;
            $userquestions_list['service_discount_price'] = $usernotification->service_discount_price ?? "";
            // $userquestions_list['avg_review'] = "4.5";
            // $userquestions_list['total_review'] = "200";

            $total_reviews = ServiceReview::where('service_id', $usernotification->id)->count();

            $average_review = ServiceReview::where('service_id', $usernotification->id)->avg('star_count');

            $userquestions_list['avg_review'] = (string)number_format($average_review, 1);

            $userquestions_list['total_review'] = (string)$total_reviews;


            $user = User::where('id', $usernotification->v_id)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;



            if ($user) {

                $fullName = $user->firstname . ' ' . $user->lastname;
                $userquestions_list['provider_name'] = $fullName;
                // $userquestions_list['provider_name'] = $user->firstname;
                $userquestions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $fullName = "";
                $userquestions_list['provider_name'] = $fullName;
                // $userquestions_list['provider_name'] = $user->firstname;
                $userquestions_list['profile_pic'] = "";
            }

            // $images = explode("::::", $usernotification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $userquestions_list['service_image'] = $imgsa;

            $imgsa = [];

            // Fetch images from `service_images` table
            foreach ($usernotification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            // Assign images to the array
            $userquestions_list['service_image'] = $imgsa;

            if ($user_id) {

                $user_like = ServiceLike::where('service_id', $usernotification->id)->where('user_id', $user_id)->first();
                $userquestions_list['is_like'] = $user_like ? "1" : "0";
            } else {
                $userquestions_list['is_like'] = "0";
            }

            // $userquestions_list['is_likes'] = "1";

            $userlist_notification[] = $userquestions_list;
        }

        $unread_message = (string)Chat::where('to_user', $user_id)->where('read_message', 0)->count();


        if ($list_notification_done || $list_notification) {
            $result['response_code'] = "1";
            $result['message'] = "Service List Found";
            $result['total_service_count'] = ceil($all_service / $perPage);
            $result['total_product_count'] = ceil($all_product / $perPage);
            $result['service_current_page'] = $notifications->currentPage();
            $result['product_current_page'] = $reviews->currentPage();
            $result['featured_service_list'] = $list_notification;
            $result['latest_product_list'] = $list_notification_done;
            $result['latest_service_list'] = $userlist_notification;
            $result['unread_message'] = $unread_message;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service List Not Found";
            $result['total_service_count'] = 0;
            $result['total_product_count'] = 0;
            $result['service_current_page'] = 0;
            $result['product_current_page'] = 0;
            $result['featured_service_list'] = [];
            $result['latest_product_list'] = [];
            $result['latest_service_list'] = [];
            $result['unread_message'] = $unread_message;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function banner()
    {
        $user_id = Auth::user()->token()->user_id;

        // $data = Banner::select('banner_image')->get();
        // $data = Banner::pluck('banner_image')->toArray();

        $data = Banner::get();

        $data_array = [];


        foreach ($data as $image) {
           
            $data_done['id'] = $image->id;
            $data_done['cat_id'] = $image->cat_id;

            // $data_done['cat_id'] = $image->category->cat_name;

            $catname = Category::where('id', $image->cat_id)->first();
            $data_done['cat_name'] = $catname->c_name;
            $data_done['image'] =  $image->banner_image ? url('/images/banner_images/' . $image->banner_image) : "";

            array_push($data_array, $data_done);

        }

        $unread_message = (string)Chat::where('to_user', $user_id)->where('read_message', 0)->count();

        if ($data_array) {
            return response()->json([
                'message' => 'Banner Image found',
                'data' => $data_array,
                'unread_message' => $unread_message,
            ]);
        } else {
            return response()->json([
                'message' => 'Image not found'
            ]);
        }
    }


    public function get_all_product(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;


        $notifications = Product::where('is_delete', '=', "0")->with('productImages')->orderByDesc('product_id')
            ->get();


        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['product_id'] = $notification->product_id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['vid'] = (string)$notification->vid;
            $questions_list['product_name'] = $notification->product_name;
            $questions_list['product_price'] = $notification->product_price;
            $questions_list['product_discount_price'] = $notification->product_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ProductReview::where('product_id', $notification->product_id)->count();

            $average_review = ProductReview::where('product_id', $notification->product_id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            $product_like = ProductLike::where('product_id', $notification->product_id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $product_like ? "1" : "0";

            $user = User::where('id', $notification->vid)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                // $questions_list['provider_name'] = $user->firstname ?? "";

                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;

                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $questions_list['provider_name'] = "";

                $questions_list['profile_pic'] =  "";
            }

            // $images = explode("::::", $notification->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['product_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image); // 'image_path' is the column name
            }

            // Assign images to the array
            $questions_list['product_image'] = $imgsa;

            $list_notification[] = $questions_list;
        }


        if (!empty($notifications)) {
            $result['response_code'] = "1";
            $result['message'] = "Product List Found";
            $result['all_product_list'] = $list_notification;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Product List Not Found";
            $result['all_product_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function get_all_product_with_pagination(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        // $all_product = Product::count();
        $perPage = 9;
        $pageNo = $request->page_no;

        $product_name = $request->input('product_name');

        if ($product_name) {

            $notifications = Product::where('product_name', 'like', "%$product_name%")->with('productImages')->where('is_delete', '=', "0")
                ->orderByDesc('product_id')
                ->paginate($perPage, ['*'], 'page', $pageNo);

            $all_product = Product::where('product_name', 'like', "%$product_name%")->where('is_delete', '=', "0")->count();
        } else {

            $notifications = Product::where('is_delete', '=', "0")->with('productImages')->orderByDesc('product_id')
                ->paginate($perPage, ['*'], 'page', $pageNo);


            $all_product = Product::where('is_delete', '=', "0")->count();
        }

        // $notifications = Product::where('is_delete', '=', "0")->orderByDesc('product_id')
        //     ->paginate($perPage, ['*'], 'page', $pageNo);

        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['product_id'] = $notification->product_id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['vid'] = (string)$notification->vid;
            $questions_list['product_name'] = $notification->product_name;
            $questions_list['product_price'] = $notification->product_price;
            $questions_list['product_discount_price'] = $notification->product_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ProductReview::where('product_id', $notification->product_id)->count();

            $average_review = ProductReview::where('product_id', $notification->product_id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;
            $questions_list['is_featured'] = (string)$notification->is_features;

            $product_like = ProductLike::where('product_id', $notification->product_id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $product_like ? "1" : "0";

            $user = User::where('id', $notification->vid)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                // $questions_list['provider_name'] = $user->firstname ?? "";

                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;



                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $questions_list['provider_name'] = "";

                $questions_list['profile_pic'] =  "";
            }

            // $images = explode("::::", $notification->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['product_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image); // 'image_path' is the column name
            }

            // Assign images to the array
            $questions_list['product_image'] = $imgsa;

            $list_notification[] = $questions_list;
        }


        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Product List Found";
            $result['all_product_list'] = $list_notification;
            $result['total_page'] = ceil($all_product / 9);
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Product List Not Found";
            $result['all_product_list'] = [];
            $result['total_page'] = 0;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }


    public function get_all_service(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;


        $notifications = Service::where('status', "1")->where('is_delete', '=', "0")->with('serviceImages')->orderByDesc('id')
            ->get();


        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ServiceReview::where('service_id', $notification->id)->count();

            $average_review = ServiceReview::where('service_id', $notification->id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            // $questions_list['is_like'] = "0";

            $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $user_like ? "1" : "0";


            $user = User::where('id', $notification->v_id)->first();
            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;
            // $questions_list['provider_name'] = $user->firstname ?? "";

            if ($user) {
                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {
                $questions_list['provider_name'] = "";
                $questions_list['profile_pic'] =  "";
            }

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            // Assign images to the array
            $questions_list['service_image'] = $imgsa;

            $list_notification[] = $questions_list;
        }

        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Service List Found";
            $result['all_service_list'] = $list_notification;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service List Not Found";
            $result['all_service_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function get_all_service_with_pagination_23_05(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $all_service = Service::count();

        $perPage = 9;
        $pageNo = $request->page_no;

        $notifications = Service::orderByDesc('id')
            ->paginate($perPage, ['*'], 'page', $pageNo);

        $list_notification = [];

        foreach ($notifications as $notification) {
            // Build your response array for each service...
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            $questions_list['avg_review'] = "4.5";
            $questions_list['total_review'] = "200";
            // $questions_list['is_like'] = "0";

            $questions_list['is_featured'] = (string)$notification->is_features;

            $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $user_like ? "1" : "0";


            $user = User::where('id', $notification->v_id)->first();
            $questions_list['provider_name'] = $user->firstname ?? "";
            $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : "";

            $images = explode("::::", $notification->service_image);
            $imgs = array();
            $imgsa = array();
            foreach ($images as $key => $image) {


                // $imgs =  asset('assets/images/post/'. $image);

                $imgs = asset('/images/service_images/' . $image);

                array_push($imgsa, $imgs);
            }
            // $user->service_image = $imgsa;

            $questions_list['service_image'] = $imgsa;

            $list_notification[] = $questions_list;
        }

        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Service List Found";
            $result['all_service_list'] = $list_notification;
            $result['total_page'] = ceil($all_service / 9);
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service List Not Found";
            $result['all_service_list'] = [];
            $result['total_page'] = 0;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function get_all_service_with_pagination(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $service_price = $request->input('service_price');
        $review = $request->input('review'); // Assuming this is the minimum average review rating

        //  $all_service = Service::count();

        $perPage = 9;
        $pageNo = $request->page_no;

        $service_name = $request->input('service_name');

        if ($service_name) {

            $notifications = Service::where('service_name', 'like', "%$service_name%")->where('is_delete', '=', "0")->with('serviceImages')
                ->orderByDesc('id')
                ->paginate($perPage, ['*'], 'page', $pageNo);

            $all_service = Service::where('service_name', 'like', "%$service_name%")->where('is_delete', '=', "0")->count();
        } else {

            $notifications = Service::where('is_delete', '=', "0")->orderByDesc('id')->with('serviceImages')
                ->paginate($perPage, ['*'], 'page', $pageNo);


            $all_service = Service::where('is_delete', '=', "0")->count();
        }
        $list_notification = [];

        foreach ($notifications as $notification) {
            // Build your response array for each service...
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";
            // $questions_list['is_like'] = "0";

            $total_reviews = ServiceReview::where('service_id', $notification->id)->count();

            $average_review = ServiceReview::where('service_id', $notification->id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            $questions_list['is_featured'] = (string)$notification->is_features;

            $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $user_like ? "1" : "0";


            $user = User::where('id', $notification->v_id)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;
            // $questions_list['provider_name'] = $user->firstname ?? "";
            $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
            $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $questions_list['service_image'] = $imgsa;


            $list_notification[] = $questions_list;
        }



        $service_price = $request->input('service_price');
        $review = $request->input('review'); // Assuming this is the minimum average review rating

        $servicesQuery = Service::query();

        //  $perPage = 9;
        // $pageNo = $request->page_no;

        // $notifications = Service::orderByDesc('id')
        //     ->paginate($perPage, ['*'], 'page', $pageNo);

        if ($service_price) {
            [$minPrice, $maxPrice] = explode(',', $service_price);
            $servicesQuery->whereBetween('service_price', [(int) $minPrice, (int) $maxPrice]);
        }

        // $all_services = $servicesQuery->orderByDesc('id')->get();

        $all_services = $servicesQuery->with('serviceImages')->orderByDesc('id')->get();

        $list_notification_done = [];

        foreach ($all_services as $service) {
            // Calculate the average review and total review count for each service
            $serviceReviews = ServiceReview::where('service_id', $service->id);
            $averageReview = round($serviceReviews->avg('star_count'), 1);
            $totalReview = $serviceReviews->count();

            // Filter by average review if provided
            if ($review && $averageReview < $review) {
                continue;
            }

            $serviceData = [
                'id' => $service->id,
                'cat_id' => (string) $service->cat_id,
                'res_id' => (string) $service->res_id,
                'v_id' => (string) $service->v_id,
                'service_name' => $service->service_name,
                'service_price' => $service->service_price,
                'service_discount_price' => $service->service_discount_price ?? '',
                'avg_review' => $averageReview,
                'total_review' => $totalReview,
                'is_featured' => (string) $service->is_features,
                'is_like' => ServiceLike::where('service_id', $service->id)
                    ->where('user_id', $user_id)
                    ->exists()
                    ? '1'
                    : '0',
            ];

            $user = User::find($service->v_id);
            //   $serviceData['provider_name'] = $user->firstname ?? '';
            $serviceData['provider_name'] = $user->firstname . ' ' . $user->lastname;

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            $serviceData['profile_pic'] = $user && $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);


            // $serviceData['service_image'] = array_map(function ($image) {
            //     return asset('/images/service_images/' . $image);
            // }, explode('::::', $service->service_image));

            $serviceData['service_image'] = $service->serviceImages->map(function ($image) {
                return asset('/images/service_images/' . $image->service_images); // Column name: `image_path`
            })->toArray();

            $list_notification_done[] = $serviceData;
        }

        if (!empty($user_id)) {
            $result['response_code'] = "1";
            $result['message'] = "Service List Found";
            $result['all_service_list'] = $service_price ? $list_notification_done  : $list_notification;
            $result['total_page'] = ceil($all_service / 9);
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service List Not Found";
            $result['all_service_list'] = [];
            $result['total_page'] = 0;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }



    public function service_details(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $service_id = $request->input('service_id');


        $notification = Service::where('id', $service_id)->with('serviceImages')->first();



        // $list_notification = [];

        if ($notification) {
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;

            $category = Category::where('id', $notification->cat_id)->first();
            $questions_list['cat_name'] = $category->c_name ?? "";
            // $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['is_features'] = $notification->is_features;

            // $subcategory = SubCategory::where('id', $notification->res_id)->first();
            // $questions_list['sub_cat_name'] = $subcategory->c_name ?? ""; 

            //     $res_ids = explode(',', $notification->res_id);
            // $subcategories = SubCategory::whereIn('id', $res_ids)->get();
            // $sub_cat_names = $subcategories->pluck('c_name')->toArray();
            // $questions_list['sub_cat_names'] = $sub_cat_names;
            $res_ids = explode(',', $notification->res_id);
            $res_ids_int = array_map('intval', $res_ids); // Convert to integers
            $subcategories = SubCategory::whereIn('id', $res_ids_int)->get();
            $sub_cat_names = $subcategories->pluck('c_name')->toArray();

            // Include both res_id and sub_cat_names
            $questions_list['res_id'] = $res_ids_int; // Array of integers
            $questions_list['sub_cat_name'] = $sub_cat_names; // Subcategory names
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            $questions_list['service_description'] = $notification->service_description;
            $questions_list['duration'] = $notification->duration;
            $questions_list['day'] = $notification->day ?? "";
            $questions_list['price_unit'] = $notification->price_unit ?? "";
            $questions_list['service_status'] = (string)$notification->status ?? "";
            $questions_list['start_time'] = $notification->start_time ?? "";
            $questions_list['end_time'] = $notification->end_time ?? "";
            $questions_list['start_time_period'] = $notification->start_time_period ?? "";
            $questions_list['end_time_period'] = $notification->end_time_period ?? "";
            $questions_list['lat'] = $notification->lat ?? "";
            $questions_list['lon'] = $notification->lon ?? "";
            $questions_list['address'] = $notification->address ?? "";
            // $questions_list['start_time'] = ($notification->start_time ?? '') . ($notification->start_time_period ?? '');
            // $questions_list['end_time'] = ($notification->end_time ?? '') . ($notification->end_time_period ?? '');
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ServiceReview::where('service_id', $service_id)->count();

            $average_review = ServiceReview::where('service_id', $service_id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            $questions_list['is_featured'] = $notification->is_features;

            // $questions_list['is_like'] = "0";

            $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $user_like ? "1" : "0";

            $questions_list['provider_id'] = (string)$notification->v_id;

            $provider_search = CartItemsModel::where('user_id', $user_id)->where('checked', '0')->where('service_id', $service_id)->first();

            $questions_list['is_cart'] = $provider_search ? "1" : "0";

            // $questions_list['my_id'] = $user_id;

            $service = Service::where('v_id', $notification->v_id)->count();

            $product = Product::where('vid', $notification->v_id)->count();

            $user = User::where('id', $notification->v_id)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {

                $fullName = $user->firstname . ' ' . $user->lastname;
                $questions_list['provider_name'] = $fullName ?? "";
                $questions_list['email'] = $user->email ?? "";
                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
                $questions_list['provider_address'] = $user->location ?? "";
            } else {

                $questions_list['provider_name'] = "";
                $questions_list['email'] = "";
                $questions_list['profile_pic'] = "";
                $questions_list['provider_address'] = "";
            }

            // $questions_list['provider_review'] = "3.0";
            // $questions_list['provider_total_review'] = "218";
            $questions_list['total_service'] = $service;
            $questions_list['total_product'] = $product;
            $questions_list['total_jod_done'] = "6";

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $questions_list['service_image'] = $imgsa;

            $productImages = ServiceImages::select('id', 'service_images')
                ->where('service_id', $service_id)
                ->get()
                ->map(function ($image) {
                    return [
                        'service_image_id' => $image->id,
                        'url' => asset('/images/service_images/' . $image->service_images),
                    ];
                })
                ->toArray();

            $questions_list['service_image_list'] = $productImages;


            $list_notification = $questions_list;
        }

        //   $all_services = Product::where('vid', $notification->v_id)
        //     ->orderByDesc('product_id')
        //     ->get();

        $all_services = AddonProduct::where('service_id', $service_id)
            ->with(['product.productImages'])
            ->orderByDesc('id')
            ->get();


        $list_notification_done = [];

        foreach ($all_services as $done_product) {

            $done = Product::where('product_id', $done_product->product_id)
                ->first();

            if ($done) {
                $questions_all_list['product_id'] = $done->product_id;
                $questions_all_list['cat_id'] = (string)$done->cat_id;
                $questions_all_list['vid'] = (string)$done->vid;
                $questions_all_list['product_name'] = $done->product_name;
                $questions_all_list['product_price'] = $done->product_price;
                $questions_all_list['product_discount_price'] = $done->product_discount_price ?? "";

                $provider_search = CartItemsModel::where('user_id', $user_id)->where('checked', '0')->where('product_id', $done->product_id)->first();

                $questions_all_list['is_cart'] = $provider_search ? "1" : "0";

                // $images = explode("::::", $done->product_image);
                // $imgs = array();
                // $imgsa = array();
                // foreach ($images as $key => $image) {


                //     // $imgs =  asset('assets/images/post/'. $image);

                //     $imgs = asset('/images/product_images/' . $image);

                //     array_push($imgsa, $imgs);
                // }
                // // $user->service_image = $imgsa;

                // $questions_all_list['product_image'] = $imgsa;

                $questions_all_list['product_image'] = $done->productImages->map(function ($image) {
                    return asset('/images/product_images/' . $image->product_image);
                })->toArray();

                $questions_all_list['product_review'] = "3.5";

                $questions_all_list['is_featured'] = $notification->is_features;

                $user = User::where('id', $done->vid)->first();

                $all_image = DefaultImage::where('people_id', "3")->first();
                $my_image = $all_image->image;
                $questions_all_list['provider_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
                $list_notification_done[] = $questions_all_list;
            }
        }


        $all_reviews = ServiceReview::where('service_id', $service_id)
            ->orderByDesc('id')
            ->limit('3')
            ->get();


        $list_review_done = [];

        foreach ($all_reviews as $review_done) {
            $review_all_list['review_id'] = $review_done->id;
            $review_all_list['user_id'] = (string)$review_done->user_id;
            $review_all_list['service_id'] = (string)$review_done->service_id;
            $review_all_list['text'] = $review_done->text ?? "";
            $review_all_list['star_count'] = $review_done->star_count;
            $review_all_list['created_at'] = $review_done->created_at ?? "";

            $user = User::where('id', $review_done->user_id)->first();

            $all_image = DefaultImage::where('people_id', "3")->first();
            $my_image = $all_image->image;

            $review_all_list['username'] = $user->firstname ?? "";
            $review_all_list['user_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            $list_review_done[] = $review_all_list;
        }

        $total_reviews_count = 0;
        $total_reviews_sum = 0;
        $average_review = 0;
        $total_average_count = 0;
        $all_service_review = DB::table('services')
            ->select('id', 'service_name', 'service_image', 'cat_id', 'res_id', 'service_price', 'v_id')
            ->where('v_id', $notification->v_id)
            ->get();

        foreach ($all_service_review as $all_service_review_done) {


            // $total_reviews = ServiceReview::where('service_id', $all_service_review_done->id)->count();
            // $average_review = ServiceReview::where('service_id', $all_service_review_done->id)->avg('star_count');

            $total_reviews = ServiceReview::where('provider_id', $all_service_review_done->v_id)->count();
            $average_review = ServiceReview::where('provider_id', $all_service_review_done->v_id)->sum('star_count');

            // $product->avg_review = (string)number_format($average_review, 1);
            // $product->total_review = (string)$total_reviews;

            // $total_reviews_count += $total_reviews;
            // $total_average_count += $average_review;
            if ($total_reviews) {
                $total_reviews_sum = $average_review / $total_reviews;
            }

            $provider_review = $total_reviews;
            $provider_total_review = $total_reviews_sum;
        }



        $all_services = Service::where('v_id', $notification->v_id)->where('id', "!=", $service_id)->with('serviceImages')
            ->orderByDesc('id')
            ->get();


        $list_service_done = [];

        foreach ($all_services as $done) {

            $ser_all_list['id'] = $done->id;
            $ser_all_list['cat_id'] = (string)$done->cat_id;

            $category = Category::where('id', $done->cat_id)->first();
            $ser_all_list['cat_name'] = $category->c_name ?? "";
            $ser_all_list['res_id'] = (string)$done->res_id;

            $subcategory = SubCategory::where('id', $done->res_id)->first();
            $ser_all_list['sub_cat_name'] = $subcategory->c_name ?? "";
            $ser_all_list['v_id'] = (string)$done->v_id;
            $ser_all_list['service_name'] = $done->service_name;
            $ser_all_list['service_price'] = $done->service_price;
            $ser_all_list['service_discount_price'] = $done->service_discount_price ?? "";
            $ser_all_list['service_description'] = $done->service_description;
            $ser_all_list['duration'] = $done->duration;
            // $ser_all_list['avg_review'] = "4.5";
            // $ser_all_list['total_review'] = "200";


            $total_reviews = ServiceReview::where('service_id', $done->id)->count();

            $average_review = ServiceReview::where('service_id', $done->id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            $ser_all_list['is_featured'] = $done->is_features;

            // $questions_list['is_like'] = "0";

            $user_like = ServiceLike::where('service_id', $done->id)->where('user_id', $user_id)->first();
            $ser_all_list['is_like'] = $user_like ? "1" : "0";

            $ser_all_list['provider_id'] = (string)$done->v_id;

            $provider_search = CartItemsModel::where('user_id', $user_id)->where('checked', '0')->where('service_id', $service_id)->first();

            $ser_all_list['is_cart'] = $provider_search ? "1" : "0";

            // $ser_all_list['provider_review'] = "3.0";
            // $ser_all_list['provider_total_review'] = "218";
            // $ser_all_list['total_service'] = $service;
            // $ser_all_list['total_product'] = $product;
            // $ser_all_list['total_jod_done'] = "6";

            // $images = explode("::::", $done->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $ser_all_list['service_image'] = $imgsa;


            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $ser_all_list['service_image'] = $imgsa;
            $list_service_done[] = $ser_all_list;
        }

        $total_reviews_count = ServiceReview::where('service_id', $service_id)->count();

        $all_services_faq = Faq::where('service_id', $service_id)
            ->orderByDesc('id')
            ->get();


        $list_service_faq = [];

        foreach ($all_services_faq as $done_faq) {

            $faq_all_list['faq_id'] = $done_faq->id;
            $faq_all_list['service_id'] = (string)$done_faq->service_id;

            $category = Category::where('id', $done_faq->cat_id)->first();
            $faq_all_list['cat_name'] = $category->c_name ?? "";
            $faq_all_list['cat_id'] = (string)$done_faq->cat_id;

            // $subcategory = SubCategory::where('id', $done->res_id)->first();
            // $ser_all_list['sub_cat_name'] = $subcategory->c_name ?? ""; 
            $faq_all_list['title'] = (string)$done_faq->title;
            $faq_all_list['description'] = $done_faq->description;



            $list_service_faq[] = $faq_all_list;
        }

        $total = $notification->service_discount_price ? $notification->service_discount_price : $notification->service_price;

        if (!empty($notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Service Details Found";
            $result['service_details'] = $list_notification;
            $result['addons_products'] = $list_notification_done;
            $result['review_list'] = $list_review_done;
            $result['other_services'] = $list_service_done;
            $result['total_reviews_count'] = $total_reviews_count;
            $result['total_service_price'] = $total;
            $result['faq_list'] = $list_service_faq;
            $result['provider_review'] = $provider_review;
            $result['provider_total_review'] = $provider_total_review ? number_format($provider_total_review, 1) : "0.0";
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service Details Not Found";
            $result['service_details'] = [];
            $result['addons_products'] = [];
            $result['review_list'] = [];
            $result['other_services'] = [];
            $result['total_reviews_count'] = $total_reviews_count;
            $result['total_service_price'] = $total;
            $result['faq_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function get_all_service_by_category(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $cat_id = $request->input('cat_id');
        $sub_cat_id = $request->input('sub_cat_id');

        if ($sub_cat_id) {

            $notifications = Service::where('cat_id', $cat_id)->where('res_id', $sub_cat_id)->where('is_delete', '=', "0")->with('serviceImages')->orderByDesc('id')
                ->get();
        } else {
            $notifications = Service::where('cat_id', $cat_id)->where('is_delete', '=', "0")->with('serviceImages')->orderByDesc('id')
                ->get();
        }


        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ServiceReview::where('service_id', $notification->id)->count();

            $average_review = ServiceReview::where('service_id', $notification->id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;
            // $questions_list['is_like'] = "0";

            $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $user_like ? "1" : "0";

            $user = User::where('id', $notification->v_id)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;
            // $questions_list['provider_name'] = $user->firstname ?? "";
            $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
            $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $questions_list['service_image'] = $imgsa;

            $list_notification[] = $questions_list;
        }

        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Service List Found";
            $result['all_service_list'] = $list_notification;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service List Not Found";
            $result['all_service_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function like_service(Request $request)
    {
        // Perform validation on the incoming request data

        $user_id = Auth::user()->token()->user_id;
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            // 'peer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        if (ServiceLike::where('user_id', $user_id)->where('service_id', $request->service_id)->exists()) {

            $like = ServiceLike::where('user_id', $user_id)->where('service_id', $request->service_id)->first();
            $like->delete();

            // return $this->sendError("User is UnLiked Service");
            return $this->sendMessage("Item get removed from wishlist");
        }

        // $user_id = $request->input('user_id');
        $service_id = $request->input('service_id');



        if (User::where('id', $user_id)->exists()) {

            try {
                ServiceLike::create([
                    'user_id' => $user_id,
                    'service_id' => $request->service_id,
                ]);
                // $FcmToken = User::select('device_token')->where('id', $peer_id)->first()->device_token;
                // $fuser = User::select('name')->where('id', $peer_id)->first()->name;
                // $tuser = User::select('name')->where('id', $user_id)->first()->name;
                // $fImage = User::select('primary_image')->where('id', $user_id)->first()->primary_image;
                // $age = User::select('age')->where('id', $user_id)->first()->age;
                // $relation_status = User::select('relation_status')->where('id', $user_id)->first()->relation_status;

                // $itemlat = User::select('latitude')->where('id', $peer_id)->first()->latitude;
                // $itemlon = User::select('longitude')->where('id', $peer_id)->first()->longitude;

                // $userlat = User::select('latitude')->where('id', $user_id)->first()->latitude;
                // $userlon = User::select('longitude')->where('id', $user_id)->first()->longitude;
                // $earth_radius = 3960.0; // Earth's radius in miles
                // $delta_lat = deg2rad($userlat - $itemlat);
                // $delta_lon = deg2rad($userlon - $itemlon);
                // $sin_lat = sin($delta_lat / 2);
                // $sin_lon = sin($delta_lon / 2);
                // $a = ($sin_lat * $sin_lat) + cos(deg2rad($itemlat)) * cos(deg2rad($userlat)) * ($sin_lon * $sin_lon);
                // $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                // $Itemdistance = $earth_radius * $c;


                // $data = [
                //     "registration_ids" => array($FcmToken),
                //     "notification" => [
                //         "title" => "Xingles",
                //         "body" => "You've received a buzz from $tuser.",
                //         "is_type" => $request->input('type'),
                //         "from_user" => $user_id,
                //         "to_user" => $peer_id,
                //     ],
                //     "data" => [
                //         "title" => "Xingles",
                //         "body" => "You've received a buzz from $tuser.",
                //         "is_type" => "like_user",
                //         "from_user" => $user_id,
                //         "to_user" => $peer_id,
                //         "username" => $tuser,
                //         "profile_image" => url('profile_pics/' . $fImage),
                //         "my_secondid" => $peer_id,
                //         "isType" => "like_user",
                //         "age" => $age,
                //         "relation_status" => $relation_status ?? "",
                //         "distance" => (string) round($Itemdistance),

                //     ]
                // ];
                // $this->sendNotification($data);

                // // print_r($data);


                // UserNotification::create([
                //     'user_id' => $request->peer_id,
                //     'data_id' => $request->user_id,
                //     'type' => "user_like",
                //     'message' => "You've received a buzz from $tuser.",
                //     'title' => "Message",
                // ]);

                return $this->sendMessage("Item added to wishlist");
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendError("User is not Liked Service", $th->getMessage());
            }
            // } 
        }
    }

    public function like_service_list(Request $request)
    {
        // Perform validation on the incoming request data

        $user_id = Auth::user()->token()->user_id;

        $service = ServiceLike::where('user_id', $user_id)->get();

        $list_notification = [];

        foreach ($service as $notifications) {

            $notification = Service::where('id', $notifications->service_id)->with('serviceImages')->first();

            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ServiceReview::where('service_id', $notification->id)->count();

            $average_review = ServiceReview::where('service_id', $notification->id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            $questions_list['is_like'] = "1";

            $user = User::where('id', $notification->v_id)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;
            // $questions_list['provider_name'] = $user->firstname ?? "";
            $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
            $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);;

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $questions_list['service_image'] = $imgsa;

            $list_notification[] = $questions_list;
        }

        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Service Like List Found";
            $result['service_like_list'] = $list_notification;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service Like List Not Found";
            $result['service_like_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function like_product(Request $request)
    {
        // Perform validation on the incoming request data

        $user_id = Auth::user()->token()->user_id;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            // 'peer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        if (ProductLike::where('user_id', $user_id)->where('product_id', $request->product_id)->exists()) {

            $like = ProductLike::where('user_id', $user_id)->where('product_id', $request->product_id)->first();
            $like->delete();

            // return $this->sendError("User is UnLiked Product");
            return $this->sendMessage("Item get removed from wishlist");
        }

        // $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');



        if (User::where('id', $user_id)->exists()) {

            try {
                ProductLike::create([
                    'user_id' => $user_id,
                    'product_id' => $request->product_id,
                ]);
                // $FcmToken = User::select('device_token')->where('id', $peer_id)->first()->device_token;
                // $fuser = User::select('name')->where('id', $peer_id)->first()->name;
                // $tuser = User::select('name')->where('id', $user_id)->first()->name;
                // $fImage = User::select('primary_image')->where('id', $user_id)->first()->primary_image;
                // $age = User::select('age')->where('id', $user_id)->first()->age;
                // $relation_status = User::select('relation_status')->where('id', $user_id)->first()->relation_status;

                // $itemlat = User::select('latitude')->where('id', $peer_id)->first()->latitude;
                // $itemlon = User::select('longitude')->where('id', $peer_id)->first()->longitude;

                // $userlat = User::select('latitude')->where('id', $user_id)->first()->latitude;
                // $userlon = User::select('longitude')->where('id', $user_id)->first()->longitude;
                // $earth_radius = 3960.0; // Earth's radius in miles
                // $delta_lat = deg2rad($userlat - $itemlat);
                // $delta_lon = deg2rad($userlon - $itemlon);
                // $sin_lat = sin($delta_lat / 2);
                // $sin_lon = sin($delta_lon / 2);
                // $a = ($sin_lat * $sin_lat) + cos(deg2rad($itemlat)) * cos(deg2rad($userlat)) * ($sin_lon * $sin_lon);
                // $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                // $Itemdistance = $earth_radius * $c;


                // $data = [
                //     "registration_ids" => array($FcmToken),
                //     "notification" => [
                //         "title" => "Xingles",
                //         "body" => "You've received a buzz from $tuser.",
                //         "is_type" => $request->input('type'),
                //         "from_user" => $user_id,
                //         "to_user" => $peer_id,
                //     ],
                //     "data" => [
                //         "title" => "Xingles",
                //         "body" => "You've received a buzz from $tuser.",
                //         "is_type" => "like_user",
                //         "from_user" => $user_id,
                //         "to_user" => $peer_id,
                //         "username" => $tuser,
                //         "profile_image" => url('profile_pics/' . $fImage),
                //         "my_secondid" => $peer_id,
                //         "isType" => "like_user",
                //         "age" => $age,
                //         "relation_status" => $relation_status ?? "",
                //         "distance" => (string) round($Itemdistance),

                //     ]
                // ];
                // $this->sendNotification($data);

                // // print_r($data);


                // UserNotification::create([
                //     'user_id' => $request->peer_id,
                //     'data_id' => $request->user_id,
                //     'type' => "user_like",
                //     'message' => "You've received a buzz from $tuser.",
                //     'title' => "Message",
                // ]);

                return $this->sendMessage("Item added to wishlist");
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendError("User is not Liked Product", $th->getMessage());
            }
            // } 
        }
    }

    public function like_product_list(Request $request)
    {
        // Perform validation on the incoming request data

        $user_id = Auth::user()->token()->user_id;

        $poduct = ProductLike::where('user_id', $user_id)->get();

        $list_notification = [];

        foreach ($poduct as $notifications) {

            $notification = Product::where('product_id', $notifications->product_id)->with('productImages')->first();

            $questions_list['product_id'] = $notification->product_id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['vid'] = (string)$notification->vid;
            $questions_list['product_name'] = $notification->product_name;
            $questions_list['product_price'] = $notification->product_price;
            $questions_list['product_discount_price'] = $notification->product_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ProductReview::where('product_id', $notification->product_id)->count();

            $average_review = ProductReview::where('product_id', $notification->product_id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            $questions_list['is_like'] = "1";

            $user = User::where('id', $notification->vid)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                // $questions_list['provider_name'] = $user->firstname ?? "";
                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;

                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $questions_list['provider_name'] = "";

                $questions_list['profile_pic'] =  "";
            }

            // $images = explode("::::", $notification->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['product_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image); // 'image_path' is the column name
            }

            // Assign images to the array
            $questions_list['product_image'] = $imgsa;

            $list_notification[] = $questions_list;
        }


        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Product Like List Found";
            $result['product_like_list'] = $list_notification;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Product Like List Not Found";
            $result['product_like_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }


    public function all_provider_list(Request $request)
    {
        // $result = [];
        // $users = [];

        $user_id = Auth::user()->token()->user_id;

        $handyman_list = User::where('user_role', "Provider")->get();

        // print_r($handyman_list);
        // die;

        $user_done = array();

        foreach ($handyman_list as $user) {

            $user_list['provider_id'] = $user->id;
            $user_list['firstname'] = $user->firstname ?? "";
            $user_list['lastname'] = $user->lastname ?? "";
            $user_list['is_online'] = $user->is_online ?? "";

            $user_like = ProviderLike::where('user_id', $user_id)->where('provider_id', $user->id)->first();
            $user_list['is_like'] = $user_like ? "1" : "0";

            // $user_list['is_like'] = "0";

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;


            if (!empty($user->profile_pic)) {
                $url = explode(":", $user->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $user_list['profile_pic'] = $user->profile_pic;
                } else {
                    $user_list['profile_pic'] =  url('/images/user/' . $user->profile_pic);
                }
            } else {
                $user_list['profile_pic'] = url('/images/user/' . $my_image);
            }

            array_push($user_done, $user_list);
        }

        if (!empty($user_id)) {
            $result['response_code'] = "1";
            $result['message'] = "Provider List Found";
            $result['all_provider_list'] = $user_done;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Provider List Not Found";
            $result['all_provider_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function like_provider(Request $request)
    {
        // Perform validation on the incoming request data

        $user_id = Auth::user()->token()->user_id;
        $validator = Validator::make($request->all(), [
            'provider_id' => 'required',
            // 'peer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        if (ProviderLike::where('user_id', $user_id)->where('provider_id', $request->provider_id)->exists()) {

            $like = ProviderLike::where('user_id', $user_id)->where('provider_id', $request->provider_id)->first();
            $like->delete();

            // return $this->sendError("User is UnLiked Service");
            return $this->sendMessage("User is UnLiked Provider");
        }

        // $user_id = $request->input('user_id');
        $provider_id = $request->input('provider_id');



        if (User::where('id', $user_id)->exists()) {

            try {
                ProviderLike::create([
                    'user_id' => $user_id,
                    'provider_id' => $request->provider_id,
                ]);
                // $FcmToken = User::select('device_token')->where('id', $peer_id)->first()->device_token;
                // $fuser = User::select('name')->where('id', $peer_id)->first()->name;
                // $tuser = User::select('name')->where('id', $user_id)->first()->name;
                // $fImage = User::select('primary_image')->where('id', $user_id)->first()->primary_image;
                // $age = User::select('age')->where('id', $user_id)->first()->age;
                // $relation_status = User::select('relation_status')->where('id', $user_id)->first()->relation_status;

                // $itemlat = User::select('latitude')->where('id', $peer_id)->first()->latitude;
                // $itemlon = User::select('longitude')->where('id', $peer_id)->first()->longitude;

                // $userlat = User::select('latitude')->where('id', $user_id)->first()->latitude;
                // $userlon = User::select('longitude')->where('id', $user_id)->first()->longitude;
                // $earth_radius = 3960.0; // Earth's radius in miles
                // $delta_lat = deg2rad($userlat - $itemlat);
                // $delta_lon = deg2rad($userlon - $itemlon);
                // $sin_lat = sin($delta_lat / 2);
                // $sin_lon = sin($delta_lon / 2);
                // $a = ($sin_lat * $sin_lat) + cos(deg2rad($itemlat)) * cos(deg2rad($userlat)) * ($sin_lon * $sin_lon);
                // $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                // $Itemdistance = $earth_radius * $c;


                // $data = [
                //     "registration_ids" => array($FcmToken),
                //     "notification" => [
                //         "title" => "Xingles",
                //         "body" => "You've received a buzz from $tuser.",
                //         "is_type" => $request->input('type'),
                //         "from_user" => $user_id,
                //         "to_user" => $peer_id,
                //     ],
                //     "data" => [
                //         "title" => "Xingles",
                //         "body" => "You've received a buzz from $tuser.",
                //         "is_type" => "like_user",
                //         "from_user" => $user_id,
                //         "to_user" => $peer_id,
                //         "username" => $tuser,
                //         "profile_image" => url('profile_pics/' . $fImage),
                //         "my_secondid" => $peer_id,
                //         "isType" => "like_user",
                //         "age" => $age,
                //         "relation_status" => $relation_status ?? "",
                //         "distance" => (string) round($Itemdistance),

                //     ]
                // ];
                // $this->sendNotification($data);

                // // print_r($data);


                // UserNotification::create([
                //     'user_id' => $request->peer_id,
                //     'data_id' => $request->user_id,
                //     'type' => "user_like",
                //     'message' => "You've received a buzz from $tuser.",
                //     'title' => "Message",
                // ]);

                return $this->sendMessage("User is Liked Provider");
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendError("User is not Liked Provider", $th->getMessage());
            }
            // } 
        }
    }

    public function like_provider_list(Request $request)
    {
        // $result = [];
        // $users = [];

        $user_id = Auth::user()->token()->user_id;

        // $handyman_list = User::where('user_role', "Provider")->get();

        $provider = ProviderLike::where('user_id', $user_id)->get();

        // print_r($handyman_list);
        // die;

        $user_done = array();

        foreach ($provider as $users) {


            $user = User::where('id', $users->provider_id)->first();

            $user_list['provider_id'] = $user->id;
            $user_list['firstname'] = $user->firstname ?? "";
            $user_list['lastname'] = $user->lastname ?? "";
            $user_list['is_online'] = $user->is_online ?? "";
            $user_list['is_like'] = "1";

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;


            if (!empty($user->profile_pic)) {
                $url = explode(":", $user->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $user_list['profile_pic'] = $user->profile_pic;
                } else {
                    $user_list['profile_pic'] =  url('/images/user/' . $user->profile_pic);
                }
            } else {
                $user_list['profile_pic'] = url('/images/user/' . $my_image);
            }

            array_push($user_done, $user_list);
        }

        if (!empty($user_id)) {
            $result['response_code'] = "1";
            $result['message'] = "Provider Like List Found";
            $result['all_provider_list'] = $user_done;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Provider Like List Not Found";
            $result['all_provider_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function user_info(Request $request)
    {

        // header('Content-Type: application/json');
        //  $agent = $this->input->request_headers();

        //   $id = $this->input->post('user_id');

        $user_id = Auth::user()->token()->user_id;

        $id = $request->input('user_id');

        if (empty($id)) {

            $temp["response_code"] = "0";

            $temp["message"] = "Enter Data";

            $temp["status"] = "failure";

            //  echo json_encode($temp);
            return response()->json($result);
        } else {

            $temp = array();

            $profile = array();

            //  $profile = $this->Profile_api_model->get_user($id);

            $profile = User::find($request->input('user_id'));

            $user = array();

            $user['id'] = (string)$profile->id;
            $user['firstname'] = $profile->firstname ?? "";
            $user['lastname'] = $profile->lastname ?? "";
            $user['email'] = $profile->email ?? "";
            $user['country_code'] = $profile->country_code ?? "";
            $user['mobile'] = $profile->mobile ?? "";
            $user['user_role'] = $profile->user_role ?? "";

            $profile_pic = "";

            $provider_details = User::where('id', $profile->id)->first();
            $pro_seen = $provider_details->people_id;

            if ($pro_seen == "1") {

                if (!empty($profile->profile_pic)) {

                    $profile_pic =  url('/images/user/' . $profile->profile_pic);
                } else {
                    $all_image = DefaultImage::where('people_id', "1")->first();
                    $my_image = $all_image->image;

                    $profile_pic =  url('/images/user/' . $my_image);
                }
            }

            if ($pro_seen == "2") {

                if (!empty($profile->profile_pic)) {

                    $profile_pic =  url('/images/user/' . $profile->profile_pic);
                } else {
                    $all_image = DefaultImage::where('people_id', "2")->first();
                    $my_image = $all_image->image;

                    $profile_pic =  url('/images/user/' . $my_image);
                }
            }

            if ($pro_seen == "3") {

                if (!empty($profile->profile_pic)) {

                    $profile_pic =  url('/images/user/' . $profile->profile_pic);
                } else {
                    $all_image = DefaultImage::where('people_id', "3")->first();
                    $my_image = $all_image->image;

                    $profile_pic =  url('/images/user/' . $my_image);
                }
            }

            $user['profile_pic'] = $profile_pic;
            $user['country_flag'] = $profile->country_flag ?? "";
            $user['device_token'] = $profile->device_token ?? "";
            $user['timestamp'] = $profile->created_at;
            $user['login_type'] = $profile->login_type ?? "";
            $user['location'] = $profile->location ?? "";

            $user_like = ProviderLike::where('user_id', $user_id)->where('provider_id', $id)->first();
            $user['is_like'] = $user_like ? "1" : "0";

            $total_reviews = ServiceReview::where('provider_id', $id)->count();

            $average_review = ServiceReview::where('provider_id', $id)->avg('star_count');

            $user['avg_review'] = (string)number_format($average_review, 1);

            $user['total_review']  = (string)$total_reviews;


            // $products = DB::table('services')
            //     ->select('id', 'service_name', 'service_image', 'cat_id', 'res_id', 'service_price', 'service_discount_price')
            //     ->where('v_id', $id)
            //     ->orderBy('id', 'desc')
            //     ->get();

            $products = DB::table('services')
                ->leftJoin('service_images', 'services.id', '=', 'service_images.service_id')
                ->select('services.id', 'services.service_name', 'services.cat_id', 'services.res_id', 'services.service_price', 'services.service_discount_price',  DB::raw("GROUP_CONCAT(service_images.service_images) as service_image"))
                ->where('services.v_id', $id)
                ->groupBy('services.id')
                ->orderBy('services.id', 'desc')
                ->get();

            if ($products->isNotEmpty()) {
                foreach ($products as $product) {

                    $category = Category::where('id', $product->cat_id)->first();
                    $product->cat_name = $category->c_name ?? "";

                    // $product->res_id = $product->res_id ?? 0;

                    $product->res_id = 0;

                    $subcategory = SubCategory::where('id', $product->res_id)->first();
                    $product->sub_cat_name = $subcategory->c_name ?? "";
                    $product->service_name = $product->service_name ?? "";
                    // $images = explode("::::", $product->service_image);
                    // $imgsa = [];

                    // foreach ($images as $image) {
                    //     $imgsa[] = url('/images/service_images/' . $image);
                    // }

                    // $product->service_image = $imgsa;
                    $product->service_image = array_map(fn($image) => url('/images/service_images/' . $image), explode(',', $product->service_image));

                    $product->service_discount_price = $product->service_discount_price ?? "";

                    // $product->total_review =  "200"; 
                    // $product->avg_review =  "4.4"; 

                    $total_reviews = ServiceReview::where('service_id', $product->id)->count();

                    $average_review = ServiceReview::where('service_id', $product->id)->avg('star_count');

                    $product->avg_review = (string)number_format($average_review, 1);

                    $product->total_review  = (string)$total_reviews;
                }
            }



            // $services = DB::table('products')
            //     ->select('product_id', 'cat_id', 'product_name', 'product_description', 'product_price', 'product_discount_price',  'product_image')
            //     ->where('vid', $id)
            //     ->orderBy('product_id', 'desc')
            //     ->get();


            $services = DB::table('products')
                ->leftJoin('product_images', 'products.product_id', '=', 'product_images.product_id')
                ->select('products.product_id', 'products.product_name', 'products.cat_id', 'products.product_description', 'products.product_price', 'products.product_discount_price',  DB::raw("GROUP_CONCAT(product_images.product_image) as product_image"))
                ->where('products.vid', $id)
                ->groupBy('products.product_id')
                ->orderBy('products.product_id', 'desc')
                ->get();
            if ($services->isNotEmpty()) {
                foreach ($services as $service) {


                    $category = ProductCategory::where('id', $service->cat_id)->first();
                    $service->cat_name = $category->c_name ?? "";


                    $service->product_name = $service->product_name ?? "";

                    $service->cat_id = $service->cat_id ?? 0;
                    // $images = explode("::::", $service->product_image);
                    // $imgsa = [];

                    // foreach ($images as $image) {
                    //     $imgsa[] = url('/images/product_images/' . $image);
                    // }

                    // $service->product_image = $imgsa;

                    $service->product_image = array_map(fn($image) => url('/images/product_images/' . $image), explode(',', $service->product_image));

                    $service->product_price = (string)$service->product_price ?? "";

                    $service->product_discount_price = $service->product_discount_price ?? "";

                    // $service->total_review =  "200"; 
                    // $service->avg_review =  "4.4"; 

                    $total_reviews = ProductReview::where('product_id', $service->product_id)->count();

                    $average_review = ProductReview::where('product_id', $service->product_id)->avg('star_count');

                    $service->avg_review = (string)number_format($average_review, 1);

                    $service->total_review = (string)$total_reviews;
                }
            }





            $temp["response_code"] = "200";

            $temp["message"] = "Success";

            $temp['user'] = $user;

            $temp['service_list'] = $products ?? [];

            $temp['product_list'] = $services ?? [];

            $temp["status"] = "success";

            return response()->json($temp);
        }
    }

    public function product_details(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $product_id = $request->input('product_id');

        // $notification = Product::where('product_id', $product_id)->first();

        $notification = Product::where('product_id', $product_id)->with('productImages')->first();



        $list_notification = [];

        // foreach ($notifications as $notification) {

        if ($notification) {
            $questions_list['product_id'] = $notification->product_id;
            $questions_list['cat_id'] = (string)$notification->cat_id;

            $category = ProductCategory::where('id', $notification->cat_id)->first();
            $questions_list['cat_name'] = $category->c_name ?? "";
            $questions_list['vid'] = (string)$notification->vid;
            $questions_list['product_name'] = $notification->product_name;
            $questions_list['product_price'] = $notification->product_price;
            $questions_list['product_discount_price'] = $notification->product_discount_price ?? "";
            $questions_list['product_description'] = $notification->product_description ?? "";

            $total_reviews = ProductReview::where('product_id', $product_id)->count();

            $average_review = ProductReview::where('product_id', $product_id)->avg('star_count');

            $questions_list['avg_review'] = $average_review ? (string)number_format($average_review, 1) : "0";

            $questions_list['total_review'] = (string)$total_reviews;
            // $questions_list['provider_total_review'] = "218";
            // $questions_list['provider_review'] = "3.0";
            $questions_list['is_featured'] = $notification->is_features;
            $questions_list['status'] = $notification->status;

            $ser_category_done = AddonProduct::where('product_id', $product_id)->get();

            $all_service_done = array();

            foreach ($ser_category_done as $key => $allpro) {

                $done_value['addon_id'] =  (string)$allpro->id;

                $done_value['service_id'] =  $allpro->service_id;

                $done_value['product_id'] =  $allpro->product_id;

                $category_done = Service::where('id', $allpro->service_id)->first();


                if (!empty($category_done)) {
                    $done_value['service_name'] =  $category_done->service_name;

                    $cat_id = $category_done->cat_id;

                    $ser_category_done = Category::where('id', $cat_id)->first();

                    $done_value['service_cat_name'] = $ser_category_done->c_name ?? "";
                } else {
                    $done_value['service_name'] =  "";
                    $done_value['service_cat_name'] = "";
                }

                array_push($all_service_done, $done_value);
            }

            $questions_list['service_details'] = $all_service_done;


            // $questions_list['service_id'] = (string)$notification->service_id ?? "";
            // if(!empty($notification->service_id)){

            // $category_done = Service::where('id', $notification->service_id)->first();
            // $cat_id = $category_done->cat_id;

            // $ser_category_done = Category::where('id', $cat_id)->first();
            // $questions_list['service_cat_name'] = $ser_category_done->c_name ?? ""; 
            // }else{

            // $questions_list['service_cat_name'] = ""; 
            // }

            $product_like = ProductLike::where('product_id', $notification->product_id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $product_like ? "1" : "0";

            $provider_search = CartItemsModel::where('user_id', $user_id)->where('checked', '0')->where('product_id', $product_id)->first();

            $questions_list['is_cart'] = $provider_search ? "1" : "0";

            $service = Service::where('v_id', $notification->vid)->count();

            $product = Product::where('vid', $notification->vid)->count();



            $user = User::where('id', $notification->vid)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {

                $questions_list['email'] = $user->email ?? "";

                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
                // $questions_list['provider_name'] = $user->firstname ?? "";
                $questions_list['provider_address'] = $user->location ?? "";

                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $questions_list['provider_name'] = "";

                $questions_list['profile_pic'] =  "";
            }

            $questions_list['total_service'] = $service;
            $questions_list['total_product'] = $product;
            $questions_list['total_jod_done'] = "6";

            // $images = explode("::::", $notification->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // $user->service_image = $imgsa;

            $imgsa = [];

            foreach ($notification->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $questions_list['product_image'] = $imgsa;

            $productImages = ProductImages::select('id', 'product_image')
                ->where('product_id', $product_id)
                ->get()
                ->map(function ($image) {
                    return [
                        'product_image_id' => $image->id,
                        'url' => asset('/images/product_images/' . $image->product_image),
                    ];
                })
                ->toArray();

            $questions_list['product_image_list'] = $productImages;

            // $questions_list['product_image'] = $imgsa;

            // $list_notification[] = $questions_list;

            $list_notification = $questions_list;
        }

        $all_services = Product::where('vid', $notification->vid)->where('product_id', "!=", $product_id)
            ->with('productImages')
            ->orderByDesc('product_id')
            ->get();


        $list_notification_done = [];

        foreach ($all_services as $done) {
            $questions_all_list['product_id'] = $done->product_id;
            $questions_all_list['cat_id'] = (string)$done->cat_id;
            $questions_all_list['vid'] = (string)$done->vid;
            $questions_all_list['product_name'] = $done->product_name;
            $questions_all_list['product_price'] = $done->product_price;
            $questions_all_list['product_discount_price'] = $done->product_discount_price ?? "";

            $provider_search = CartItemsModel::where('user_id', $user_id)->where('checked', '0')->where('product_id', $done->product_id)->first();

            $questions_all_list['is_cart'] = $provider_search ? "1" : "0";

            // $images = explode("::::", $done->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_all_list['product_image'] = $imgsa;

            $imgsa = [];

            foreach ($done->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $questions_all_list['product_image'] = $imgsa;

            $questions_all_list['product_review'] = "3.5";

            $questions_all_list['is_featured'] = $notification->is_features;
            $questions_all_list['status'] = $notification->status;

            $user = User::where('id', $done->vid)->first();
            $questions_all_list['provider_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : "";
            $list_notification_done[] = $questions_all_list;
        }

        $all_reviews = ProductReview::where('product_id', $product_id)
            ->orderByDesc('id')->limit('3')
            ->get();


        $list_review_done = [];

        foreach ($all_reviews as $review_done) {
            $review_all_list['review_id'] = $review_done->id;
            $review_all_list['user_id'] = (string)$review_done->user_id;
            $review_all_list['product_id'] = (string)$review_done->product_id;
            $review_all_list['text'] = $review_done->text;
            $review_all_list['star_count'] = $review_done->star_count;
            $review_all_list['created_at'] = $review_done->created_at ?? "";

            $user = User::where('id', $review_done->user_id)->first();

            $all_image = DefaultImage::where('people_id', "3")->first();
            $my_image = $all_image->image;

            $review_all_list['username'] = $user->firstname ?? "";
            $review_all_list['user_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            $list_review_done[] = $review_all_list;
        }

        $total_reviews_count = 0;
        $total_reviews_sum = 0;
        $average_review = 0;
        $total_average_count = 0;
        $provider_review = 0;
        $provider_total_review = 0;
        $all_service_review = DB::table('services')
            ->select('id', 'service_name', 'service_image', 'cat_id', 'res_id', 'service_price', 'v_id')
            ->where('v_id', $notification->vid)
            ->get();

        foreach ($all_service_review as $all_service_review_done) {

            $total_reviews = ServiceReview::where('provider_id', $all_service_review_done->v_id)->count();
            $average_review = ServiceReview::where('provider_id', $all_service_review_done->v_id)->sum('star_count');

            if ($total_reviews) {
                $total_reviews_sum = $average_review / $total_reviews;
            }

            $provider_review = $total_reviews;
            $provider_total_review = $total_reviews_sum;
        }

        $total_reviews_count = ProductReview::where('product_id', $product_id)->count();


        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Product Details Found";
            $result['product_details'] = $list_notification;
            $result['other_products'] = $list_notification_done;
            $result['review_list'] = $list_review_done;
            $result['total_reviews_count'] = $total_reviews_count;
            $result['provider_total_review'] = (string)$provider_review ?? "";
            $result['provider_review'] = $provider_total_review ? number_format($provider_total_review, 1) : "0.0";
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Product Details Not Found";
            $result['product_details'] = [];
            $result['other_products'] = [];
            $result['review_list'] = [];
            $result['total_reviews_count'] = $total_reviews_count;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function add_address(Request $request)
    {

        // $MYyid = $request->user()->token()->user_id;
        $MYyid = Auth::user()->token()->user_id;
        if (!empty($request->address_id)) {
            if (!UserAddressModel::where('user_id', $MYyid)->where('address_id', $request->address_id)->exists()) {
                return $this->sendError("Address not found.");
            }
            if (!empty($request->delete) && $request->delete == 1) {
                $delAdd = UserAddressModel::where('user_id', $MYyid)->where('address_id', $request->address_id)->first();
                if ($delAdd->as_default == 1) {
                    // $delAdd->delete();
                    $delAdd->update(['is_delete' => 1]);
                    $update = UserAddressModel::where('user_id', $MYyid)->orderByDesc('address_id')->first();
                    // print_r($update);
                    $update->update(['as_default' => 1]);
                }
                // $delAdd->delete();
                $delAdd->update(['is_delete' => 1]);
                $respons['success'] = "true";
                $respons['message'] = "Address removed successfully.";
                return response()->json($respons, 200);
            }
            $upAddress = UserAddressModel::where('user_id', $MYyid)->where('address_id', $request->address_id)->first();
            if ($request->as_default == 1) {
                // echo "1";
                UserAddressModel::where('user_id', $MYyid)->update(['as_default' => 0]);
            }

            $input = array(
                'full_name' => $request->full_name ? $request->full_name : $upAddress->full_name,
                'phone' => $request->phone ? $request->phone : $upAddress->phone,
                'address' => $request->address ? $request->address : $upAddress->address,
                'address_type' => $request->address_type ? $request->address_type : $upAddress->address_type,
                'landmark' => $request->landmark ? $request->landmark : $upAddress->landmark,
                'city' => $request->city ? $request->city : $upAddress->city,
                'state' => $request->state ? $request->state : $upAddress->state,
                'area_name' => $request->area_name ? $request->area_name : $upAddress->area_name,
                'country' => $request->country ? $request->country : $upAddress->country,
                'zip_code' => $request->zip_code ? $request->zip_code : $upAddress->zip_code,
                'as_default' => $request->as_default ? $request->as_default : $upAddress->as_default,
                'lat' => $request->lat ? $request->lat : $upAddress->lat,
                'lon' => $request->lon ? $request->lon : $upAddress->lon,

            );

            UserAddressModel::where('user_id', $MYyid)->where('address_id', $request->address_id)->update($input);
            // echo $upAddress->as_default;
            $respons['success'] = "true";
            $respons['message'] = "Address Update successfully.";
            return response()->json($respons, 200);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone' => 'required',
            // 'address' => 'required',
            'address_type' => 'required',
            // 'landmark' => 'required',
            // 'city' => 'required',
            // 'state' => 'required',
            // 'area_name' => 'required',
            // 'zip_code' => 'required',
            'as_default' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        if ($input['as_default'] == 1) {
            UserAddressModel::where('user_id', $MYyid)->update(['as_default' => 0]);
        }
        $input['user_id'] = $MYyid;
        UserAddressModel::create($input);

        $respons['success'] = "true";
        $respons['message'] = "Address added successfully.";
        return response()->json($respons, 200);
    }

    public function get_all_addresses(Request $request)
    {

        // $MYyid = $request->user()->token()->user_id;
        $MYyid = Auth::user()->token()->user_id;

        $all_address = UserAddressModel::where('user_id', $MYyid)->where('is_delete', "0")->Orderby('address_id', 'Asc')->get();
        return $this->sendResponse(UserAddressRes::collection($all_address), "Users all address.");
    }

    public function get_all_coupan(Request $request)
    {
        $MYyid = Auth::user()->token()->user_id;
        // $coupon_type = $request->coupon_type;

        $coupon = Coupon::where('coupon_for', "Product")->get();
        $coupon_arr = array();
        foreach ($coupon as $list) {
            $coupon_list['id'] = $list->id;
            $coupon_list['code'] = $list->code;
            $coupon_list['discount'] = $list->discount;
            $coupon_list['description'] = $list->description;
            $coupon_list['expire_date'] = $list->expire_date;
            $coupon_list['coupon_for'] = $list->coupon_for;
            $coupon_list['status'] = 1;
            $coupon_list['is_loading'] = 0;

            array_push($coupon_arr, $coupon_list);
        }
        // $plan_check = Event::find($event_id);

        // if (empty($coupon)) {
        //     return response()->json([
        //         'response_code' => 0,
        //         'message' => 0,
        //         'status' => 'success',
        //     ]);
        // }

        $coupon_done = Coupon::where('coupon_for', "Service")->get();
        $coupon_array = array();
        foreach ($coupon_done as $list_done) {
            $coupon_done_list['id'] = $list_done->id;
            $coupon_done_list['code'] = $list_done->code;
            $coupon_done_list['discount'] = $list_done->discount;
            $coupon_done_list['description'] = $list_done->description;
            $coupon_done_list['expire_date'] = $list_done->expire_date;
            $coupon_done_list['coupon_for'] = $list_done->coupon_for;
            $coupon_done_list['status'] = 1;
            $coupon_done_list['is_loading'] = 0;

            array_push($coupon_array, $coupon_done_list);
        }


        return response()->json([
            'response_code' => 1,
            'product_coupons' => $coupon_arr,
            'service_coupons' => $coupon_array,
            'status' => 'success',
        ]);
    }

    public function add_to_cart_old(Request $request)
    {
        $myId = Auth::user()->token()->user_id;
        // $validator = Validator::make($request->all(), [
        //     'product_id' => 'required|numeric'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        $product_id = $request->product_id;
        $service_id = $request->service_id;

        $booking_date = $request->booking_date;
        $booking_time = $request->booking_time;
        $notes = $request->notes;
        $cart_id = $request->cart_id;



        $provider_search = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('service_id', '!=', '')->first();

        // $provider_count = $provider_search->count();

        $provider_count = CartItemsModel::where('user_id', $myId)
            ->where('checked', '0')
            ->where('service_id', '!=', '')
            ->count();

        if ($service_id) {

            if (!$cart_id) {
                if ($provider_search) {
                    if ($provider_search->service_id != $service_id || $provider_search->service_id == $service_id) {

                        $result["response_code"] = "0";
                        $result["message"] = "Service is alreay Added to Cart";
                        $result["different_provider"] = "false";
                        $result["service_count"] = $provider_count;
                        $result['cart_id'] = $provider_search->cart_id ?? 0;
                        $result["status"] = "failure";
                        return response()->json($result);
                    }
                }
            }

            $product_search = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('product_id', '!=', '')->first();


            if ($product_search) {

                $product_provider_all = $product_search->product_id;

                if ($product_provider_all) {


                    $all_right = Product::where('product_id', $product_provider_all)->first();

                    $all_done = $all_right->vid;

                    $product_provider = Service::where('id', $request->service_id)->first();

                    if ($product_provider) {

                        $product_right = $product_provider->v_id;



                        if ($all_done != $product_right) {

                            $result["response_code"] = "0";
                            $result["message"] = "Service Provider & Product Provider is Difference";
                            $result["different_provider"] = "true";
                            $result["service_count"] = $provider_count;
                            // $result['users'] = $users;
                            $result["status"] = "failure";
                            return response()->json($result);
                        }
                    }
                }
            }
        }

        if ($provider_search) {

            $service_provider = $provider_search->service_id;


            $all_right = Service::where('id', $service_provider)->first();

            $all_done = $all_right->v_id;

            $product_provider = Product::where('product_id', $request->product_id)->first();

            if ($product_provider) {

                $product_right = $product_provider->vid;



                if ($all_done != $product_right) {

                    $result["response_code"] = "0";
                    $result["message"] = "Service Provider & Product Provider is Difference";
                    $result["different_provider"] = "true";
                    $result["service_count"] = $provider_count;
                    // $result['users'] = $users;
                    $result["status"] = "failure";
                    return response()->json($result);
                }
            }
        }

        $product_search = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('product_id', '!=', '')->first();


        if ($product_search) {

            $product_provider_all = $product_search->product_id;

            if ($product_provider_all) {


                $all_right = Product::where('product_id', $product_provider_all)->first();

                $all_done = $all_right->vid;

                $person_search = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('service_id', '!=', '')->first();


                $person_searchr_all = $product_search->service_id;

                $all_right_ews = Service::where('id', $person_searchr_all)->first();

                if ($all_right_ews) {

                    $all_done_umn = $all_right_ews->v_id;

                    if ($all_done_umn != $all_done) {

                        $result["response_code"] = "0";
                        $result["message"] = "Product Provider & Service Provider is Difference";
                        // $result['users'] = $users;

                        $result["different_provider"] = "true";
                        $result["service_count"] = $provider_count;
                        $result["status"] = "failure";
                        return response()->json($result);
                    }
                }
                $product_provider = Product::where('product_id', $request->product_id)->first();

                if ($product_provider) {
                    $product_right = $product_provider->vid;



                    if ($all_done != $product_right) {

                        $result["response_code"] = "0";
                        $result["message"] = "Product Provider & Product Provider is Difference";
                        // $result['users'] = $users;
                        $result["different_provider"] = "true";
                        $result["service_count"] = $provider_count;
                        $result["status"] = "failure";
                        return response()->json($result);
                    }
                }
            }
        }


        // $product_search_all = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('product_id', '!=', '')->first();


        // $product_provider_res = Product::where('product_id', $product_search_all->product_id)->first();

        //  $product_right_resource = $product_provider_res->vid;




        //  if($product_right_resource != $product_right){

        //     $result["response_code"] = "0";
        //     $result["message"] = "Service Provider & Product Provider is Difference";
        //     // $result['users'] = $users;
        //     $result["status"] = "failure";
        //     return response()->json($result);
        // }





        if ($product_id) {

            if (!Product::where('product_id', $request->product_id)->exists()) {
                return $this->sendError('Product not found.');
            }
        }

        if ($service_id) {

            if (!Service::where('id', $request->service_id)->exists()) {
                return $this->sendError('Service not found.');
            }
        }

        if ($request->cart_id && CartItemsModel::where('user_id', $myId)->where('cart_id', $request->cart_id)->exists()) {

            $itemDtl = CartItemsModel::where('user_id', $myId)->where('cart_id', $request->cart_id)->first();
            $input = [
                'quantity' => $request->quantity ? $request->quantity : $itemDtl->quantity,
                'booking_date' => $request->booking_date ? $request->booking_date : $itemDtl->booking_date,
                'booking_time' => $request->booking_time ? $request->booking_time : $itemDtl->booking_time,
                'notes' => $request->notes ? $request->notes : $itemDtl->notes,
                // 'colors' => $request->colors ? $request->colors : $itemDtl->colors,
                'checked' => $request->checked != 2 ? ($request->checked == 1 ? 1 : $itemDtl->checked) : 0,
                // 'address_id' => $request->address_id ? $request->address_id : $itemDtl->address_id,
            ];
            // print_r($input);
            // exit;

            CartItemsModel::where('user_id', $myId)->where('cart_id', $request->cart_id)->update($input);

            $Output = array();
            $total_price = 0;
            $discount_price = 0;
            $Output['products'] = [];
            $allItms = CartItemsModel::where('user_id', $myId)->where('checked', 1)->OrderByDesc('cart_id')->get();
            foreach ($allItms as $item) {
                $total_price += $item->price;
                // $Output['products'][] = new ProductRes(ProductModel::where('product_id', $item->product_id)->first());
            }
            $Output['products'] = CartRes::collection(CartItemsModel::where('user_id', $myId)->where('checked', 1)->OrderByDesc('cart_id')->get());
            $Output['total_mrp'] = (string)$total_price;
            $Output['discount'] = (string)$discount_price;
            $Output['sub_total'] = (string)($total_price - $discount_price);
            return $this->sendResponse($Output, 'Cart updeted.');
        }

        $input = $request->all();
        $product = Product::where('product_id', $request->product_id)->first();
        // $add_id = UserAddressModel::select('address_id')->where('as_default', 1)->where('user_id', $myId)->first()->address_id;
        $input['user_id'] = $myId;
        $input['quantity'] = $request->quantity ? $request->quantity : $product->mqty;

        // $input['address_id'] = $add_id ? $add_id : 0;
        $input['checked'] = $request->checked == 1 ? 1 : 0;

        if (CartItemsModel::create($input)) {
            $Output = array();
            $total_price = 0;
            $discount_price = 0;
            $Output['products'] = [];
            $allItms = CartItemsModel::where('user_id', $myId)->where('checked', 1)->OrderByDesc('cart_id')->get();
            foreach ($allItms as $item) {
                $total_price += $item->price;
                // $Output['products'][] = new ProductRes(ProductModel::where('product_id', $item->product_id)->first());
            }
            $Output['products'] = CartRes::collection(CartItemsModel::where('user_id', $myId)->where('checked', 1)->OrderByDesc('cart_id')->get());
            $Output['total_mrp'] = (string)$total_price;
            $Output['discount'] = (string)$discount_price;
            $Output['sub_total'] = (string)($total_price - $discount_price);
            // return $this->sendResponse($Output, 'Product Added to cart.');

            $result["response_code"] = "1";
            $result["message"] = "Product Added to cart.";
            // $result['output'] = $Output;
            $result["status"] = "true";
            return response()->json($result);
        }
    }


    public function add_to_cart(Request $request)
    {
        $myId = Auth::user()->token()->user_id;
        // $validator = Validator::make($request->all(), [
        //     'product_id' => 'required|numeric'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        $product_id = $request->product_id;
        $service_id = $request->service_id;

        $booking_date = $request->booking_date;
        $booking_time = $request->booking_time;
        $notes = $request->notes;
        $cart_id = $request->cart_id;



        $provider_search = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('service_id', '!=', '')->first();

        // $provider_count = $provider_search->count();

        $provider_count = CartItemsModel::where('user_id', $myId)
            ->where('checked', '0')
            ->where('service_id', '!=', '')
            ->count();

        if ($service_id) {

            if (!$cart_id) {
                if ($provider_search) {
                    if ($provider_search->service_id != $service_id || $provider_search->service_id == $service_id) {

                        $result["response_code"] = "0";
                        $result["message"] = "Service is alreay Added to Cart";
                        $result["different_provider"] = "false";
                        $result["service_count"] = $provider_count;
                        $result['cart_id'] = $provider_search->cart_id ?? 0;
                        $result["status"] = "failure";
                        return response()->json($result);
                    }
                }
            }

            //   $product_search = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('product_id', '!=', '')->first();


            //   if($product_search){

            //     $product_provider_all = $product_search->product_id;

            //     if($product_provider_all){


            //   $all_right = Product::where('product_id', $product_provider_all)->first();

            //   $all_done = $all_right->vid;

            //     $product_provider = Service::where('id', $request->service_id)->first();

            //   if($product_provider){

            //   $product_right = $product_provider->v_id;



            //     if($all_done != $product_right){

            //         $result["response_code"] = "0";
            //         $result["message"] = "Service Provider & Product Provider is Difference";
            //         $result["different_provider"] = "true";
            //         $result["service_count"] = $provider_count;
            //         // $result['users'] = $users;
            //         $result["status"] = "failure";
            //         return response()->json($result);
            //     }
            //   }
            //      }
            //   }
        }

        //   if($provider_search){

        //     $service_provider = $provider_search->service_id;


        //   $all_right = Service::where('id', $service_provider)->first();

        //   $all_done = $all_right->v_id;

        //   $product_provider = Product::where('product_id', $request->product_id)->first();

        //   if($product_provider){

        //   $product_right = $product_provider->vid;



        //     if($all_done != $product_right){

        //         $result["response_code"] = "0";
        //         $result["message"] = "Service Provider & Product Provider is Difference";
        //         $result["different_provider"] = "true";
        //         $result["service_count"] = $provider_count;
        //         // $result['users'] = $users;
        //         $result["status"] = "failure";
        //         return response()->json($result);
        //     }
        //   }
        //   }

        //      $product_search = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('product_id', '!=', '')->first();


        //   if($product_search){

        //     $product_provider_all = $product_search->product_id;

        //     if($product_provider_all){


        //   $all_right = Product::where('product_id', $product_provider_all)->first();

        //   $all_done = $all_right->vid;

        //   $person_search = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('service_id', '!=', '')->first();


        //     $person_searchr_all = $product_search->service_id;

        //     $all_right_ews = Service::where('id', $person_searchr_all)->first();

        //     if($all_right_ews){

        //   $all_done_umn = $all_right_ews->v_id;

        //     if($all_done_umn != $all_done){

        //         $result["response_code"] = "0";
        //         $result["message"] = "Product Provider & Service Provider is Difference";
        //         // $result['users'] = $users;

        //         $result["different_provider"] = "true";
        //         $result["service_count"] = $provider_count;
        //         $result["status"] = "failure";
        //         return response()->json($result);
        //     }
        //     }
        //   $product_provider = Product::where('product_id', $request->product_id)->first();

        //   if($product_provider){
        //   $product_right = $product_provider->vid;



        //     if($all_done != $product_right){

        //         $result["response_code"] = "0";
        //         $result["message"] = "Product Provider & Product Provider is Difference";
        //         // $result['users'] = $users;
        //         $result["different_provider"] = "true";
        //         $result["service_count"] = $provider_count;
        //         $result["status"] = "failure";
        //         return response()->json($result);
        //     }
        //   }
        //     }

        //   }


        // $product_search_all = CartItemsModel::where('user_id', $myId)->where('checked', '0')->where('product_id', '!=', '')->first();


        // $product_provider_res = Product::where('product_id', $product_search_all->product_id)->first();

        //  $product_right_resource = $product_provider_res->vid;




        //  if($product_right_resource != $product_right){

        //     $result["response_code"] = "0";
        //     $result["message"] = "Service Provider & Product Provider is Difference";
        //     // $result['users'] = $users;
        //     $result["status"] = "failure";
        //     return response()->json($result);
        // }





        if ($product_id) {

            if (!Product::where('product_id', $request->product_id)->exists()) {
                return $this->sendError('Product not found.');
            }
        }

        if ($service_id) {

            if (!Service::where('id', $request->service_id)->exists()) {
                return $this->sendError('Service not found.');
            }
        }

        if ($request->cart_id && CartItemsModel::where('user_id', $myId)->where('cart_id', $request->cart_id)->exists()) {

            $itemDtl = CartItemsModel::where('user_id', $myId)->where('cart_id', $request->cart_id)->first();
            $input = [
                'quantity' => $request->quantity ? $request->quantity : $itemDtl->quantity,
                'booking_date' => $request->booking_date ? $request->booking_date : $itemDtl->booking_date,
                'booking_time' => $request->booking_time ? $request->booking_time : $itemDtl->booking_time,
                'notes' => $request->notes ? $request->notes : $itemDtl->notes,
                // 'colors' => $request->colors ? $request->colors : $itemDtl->colors,
                'checked' => $request->checked != 2 ? ($request->checked == 1 ? 1 : $itemDtl->checked) : 0,
                // 'address_id' => $request->address_id ? $request->address_id : $itemDtl->address_id,
            ];
            // print_r($input);
            // exit;

            CartItemsModel::where('user_id', $myId)->where('cart_id', $request->cart_id)->update($input);

            $Output = array();
            $total_price = 0;
            $discount_price = 0;
            $Output['products'] = [];
            $allItms = CartItemsModel::where('user_id', $myId)->where('checked', 1)->OrderByDesc('cart_id')->get();
            foreach ($allItms as $item) {
                $total_price += $item->price;
                // $Output['products'][] = new ProductRes(ProductModel::where('product_id', $item->product_id)->first());
            }
            $Output['products'] = CartRes::collection(CartItemsModel::where('user_id', $myId)->where('checked', 1)->OrderByDesc('cart_id')->get());
            $Output['total_mrp'] = (string)$total_price;
            $Output['discount'] = (string)$discount_price;
            $Output['sub_total'] = (string)($total_price - $discount_price);
            return $this->sendResponse($Output, 'Cart updeted.');
        }

        $input = $request->all();
        $product = Product::where('product_id', $request->product_id)->first();
        // $add_id = UserAddressModel::select('address_id')->where('as_default', 1)->where('user_id', $myId)->first()->address_id;
        $service = Service::where('id', $request->service_id)->first();
        $input['user_id'] = $myId;
        $input['quantity'] = $request->quantity ? $request->quantity : $product->mqty;

        if ($product) {
            $input['provider_id'] = $product->vid;
        } else {
            $input['provider_id'] = $service->v_id;
        }

        if ($product) {
            $input['addon_service_id'] = $product->service_id;
        }

        // $input['address_id'] = $add_id ? $add_id : 0;
        $input['checked'] = $request->checked == 1 ? 1 : 0;

        if (CartItemsModel::create($input)) {
            $Output = array();
            $total_price = 0;
            $discount_price = 0;
            $Output['products'] = [];
            $allItms = CartItemsModel::where('user_id', $myId)->where('checked', 1)->OrderByDesc('cart_id')->get();
            foreach ($allItms as $item) {
                $total_price += $item->price;
                // $Output['products'][] = new ProductRes(ProductModel::where('product_id', $item->product_id)->first());
            }
            $Output['products'] = CartRes::collection(CartItemsModel::where('user_id', $myId)->where('checked', 1)->OrderByDesc('cart_id')->get());
            $Output['total_mrp'] = (string)$total_price;
            $Output['discount'] = (string)$discount_price;
            $Output['sub_total'] = (string)($total_price - $discount_price);
            // return $this->sendResponse($Output, 'Product Added to cart.');

            $result["response_code"] = "1";
            $result["message"] = "Product Added to cart.";
            // $result['output'] = $Output;
            $result["status"] = "true";
            return response()->json($result);
        }
    }

    public function get_cart_items_12_08(Request $request)
    {
        // $myId = $request->user()->token()->user_id;
        $myId = Auth::user()->token()->user_id;
        $coupon_code = $request->coupon_code;
        $coupon_type = $request->coupon_type;
        // if (!CartItemsModel::where('user_id', $myId)->exists()) {
        //     return $this->sendMessage("Cart Is empty");
        // }
        $cart_dtl = CartItemsModel::where('user_id', $myId)->where('product_id', '!=', "")->where('checked', "0")->OrderByDesc('cart_id')->get();

        $sub_total = 0;
        $totalPrice = 0;
        $coupon_discount = 0;
        $dis_sub_total = 0;
        $mrp_sub_total = 0;

        foreach ($cart_dtl as $item) {
            $product = Product::where('product_id', $item->product_id)->first();

            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;

            $sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : ($product->product_price * $item->quantity);

            $dis_sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : 0;

            $mrp_sub_total += $product->product_price ? ($product->product_price * $item->quantity) : 0;

            if ($coupon_type == "Product") {

                $dis = Coupon::where('code', $coupon_code)->where('coupon_for', $coupon_type)->first();

                $coupon_discount = $dis ? round((($sub_total) * $dis->discount) / 100) : 0;


                $totalPrice = $sub_total - $coupon_discount;
            } else {

                $totalPrice = $sub_total;
                // $coupon_discount = 0;
            }


            $user = User::where('id', $product->vid)->first();

            $user_id = $product->vid;
            $name = $user->firstname;

            $addess = UserAddressModel::where('address_id', $item->address_id)->first();


            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address = '';
            }


            $fullname = $addess->full_name ?? "";
            //  $user_address = $addess->address ?? "";
            //  $user_address = $addess;
            $user_address_id = $item->address_id;
        }




        $cart_dtl_done = CartItemsModel::where('user_id', $myId)->where('service_id', '!=', "")->where('checked', "0")->OrderByDesc('cart_id')->get();

        $service_sub_total = 0;
        $totalSerPrice = 0;
        $service_dis_sub_total = 0;
        $service_mrp_sub_total = 0;


        foreach ($cart_dtl_done as $items) {

            $service = Service::where('id', $items->service_id)->first();
            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;
            $service_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : ($service->service_price * $items->quantity);


            $service_dis_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : 0;

            $service_mrp_sub_total += $service->service_price ? ($service->service_price * $items->quantity) : 0;

            if ($coupon_type == "Service") {

                $dis = Coupon::where('code', $coupon_code)->where('coupon_for', $coupon_type)->first();

                $coupon_discount = $dis ? round((($service_sub_total) * $dis->discount) / 100) : 0;


                $totalSerPrice = $sub_total - $coupon_discount;
            } else {

                $totalSerPrice = $service_sub_total;
                // $coupon_discount = 0;
            }

            $user = User::where('id', $service->v_id)->first();
            $name = $user->firstname;

            $user_id = $service->v_id;

            $addess = UserAddressModel::where('address_id', $items->address_id)->first();

            //   $user_address = $addess->address ?? "";

            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address = '';
            }

            $fullname = $addess->full_name ?? "";

            // Concatenate address parts with commas
            $user_address = implode(', ', $addressParts);
            //     $user_address = $addess;
            $user_address_id = $items->address_id;
        }


        $all_address = CartItemsModel::where('user_id', $myId)->where('checked', 0)->OrderByDesc('cart_id')->first();

        if ($all_address) {
            $address = $all_address->address_id;

            $addess = UserAddressModel::where('address_id', $address)->first();

            //   $user_address = $addess->address ?? "";

            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address_donr = '';
            }


            if (!empty($addressParts)) {

                $user_address_donr = implode(', ', $addressParts);
            }
        }

        // $addess = UserAddressModel::where('address_id', $item->address_id)->first();
        $total_mrp_sub_total = $mrp_sub_total + $service_mrp_sub_total;
        $total_dis_sub_total = $dis_sub_total + $service_dis_sub_total;

        if ($total_dis_sub_total) {
            $saving_price = $total_mrp_sub_total - $total_dis_sub_total;
        } else {
            $saving_price = 0;
        }

        // $provider_info = User::where('id' , $cart_dtl_done->v_id)->first();

        if (!empty($myId)) {
            $result['response_code'] = "1";
            $result['message'] = "Cart Items Details Found";
            $result['product'] = CartRes::collection($cart_dtl);
            // $result['service'] = new CartSerRes($cart_dtl_done->first());
            $result['service'] = CartSerRes::collection($cart_dtl_done);
            $result['product_subtotal'] = $sub_total;
            $result['service_subtotal'] = $service_sub_total;
            $result['sub_total'] = $sub_total + $service_sub_total;
            $result['mrp_sub_total'] = $mrp_sub_total + $service_mrp_sub_total;
            $result['dis_sub_total'] = $dis_sub_total + $service_dis_sub_total;
            $result['saving_price'] = $saving_price;
            // $result['coupon'] = 0;
            $result['coupon'] = $coupon_discount;
            $result['tax'] = 0;
            $result['service_charge'] = 0;
            $result['total'] = $sub_total + $service_sub_total  - $coupon_discount;
            // $result['total'] = $totalPrice + $totalSerPrice - $coupon_discount;
            $result['provider_name'] = $name ?? "";
            $result['provider_id'] = $user_id ?? 0;
            $result['address'] = $user_address_donr ?? "";
            $result['address_id'] = $user_address_id ?? 0;
            $result['fullname'] = $fullname ?? "";
            $result["status"] = "success";
            return response()->json($result);
        }

        // return $this->sendResponse(CartRes::collection($cart_dtl), "User Cart Items.");
    }

    public function get_cart_items_23_08(Request $request)
    {
        // $myId = $request->user()->token()->user_id;
        $myId = Auth::user()->token()->user_id;
        $coupon_code = $request->coupon_code;
        $coupon_type = $request->coupon_type;
        // if (!CartItemsModel::where('user_id', $myId)->exists()) {
        //     return $this->sendMessage("Cart Is empty");
        // }
        $cart_dtl = CartItemsModel::where('user_id', $myId)->where('product_id', '!=', "")->where('checked', "0")->OrderByDesc('cart_id')->get();

        $sub_total = 0;
        $totalPrice = 0;
        $coupon_discount = 0;
        $dis_sub_total = 0;
        $mrp_sub_total = 0;

        foreach ($cart_dtl as $item) {
            $product = Product::where('product_id', $item->product_id)->first();

            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;

            $sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : ($product->product_price * $item->quantity);

            $dis_sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : 0;

            $mrp_sub_total += $product->product_price ? ($product->product_price * $item->quantity) : 0;

            if ($coupon_type == "Product") {

                $dis = Coupon::where('code', $coupon_code)->where('coupon_for', $coupon_type)->first();

                //  $coupon_discount = $dis ? round((($sub_total) * $dis->discount) / 100) : 0;


                $coupon_discount = $dis ? (($sub_total) * $dis->discount) / 100 : 0;


                $totalPrice = $sub_total - $coupon_discount;
            } else {

                $totalPrice = $sub_total;
                // $coupon_discount = 0;
            }


            $user = User::where('id', $product->vid)->first();

            $user_id = $product->vid;
            $name = $user->firstname;

            $addess = UserAddressModel::where('address_id', $item->address_id)->first();


            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address = '';
            }


            $fullname = $addess->full_name ?? "";
            //  $user_address = $addess->address ?? "";
            //  $user_address = $addess;
            $user_address_id = $item->address_id;
        }




        $cart_dtl_done = CartItemsModel::where('user_id', $myId)->where('service_id', '!=', "")->where('checked', "0")->OrderByDesc('cart_id')->get();

        $service_sub_total = 0;
        $totalSerPrice = 0;
        $service_dis_sub_total = 0;
        $service_mrp_sub_total = 0;


        foreach ($cart_dtl_done as $items) {

            $service = Service::where('id', $items->service_id)->first();
            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;
            $service_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : ($service->service_price * $items->quantity);


            $service_dis_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : 0;

            $service_mrp_sub_total += $service->service_price ? ($service->service_price * $items->quantity) : 0;

            if ($coupon_type == "Service") {

                $dis = Coupon::where('code', $coupon_code)->where('coupon_for', $coupon_type)->first();

                //  $coupon_discount = $dis ? round((($service_sub_total) * $dis->discount) / 100) : 0;

                $coupon_discount = $dis ? (($service_sub_total) * $dis->discount) / 100 : 0;


                $totalSerPrice = $sub_total - $coupon_discount;
            } else {

                $totalSerPrice = $service_sub_total;
                // $coupon_discount = 0;
            }

            $user = User::where('id', $service->v_id)->first();
            $name = $user->firstname;

            $user_id = $service->v_id;

            $addess = UserAddressModel::where('address_id', $items->address_id)->first();

            //   $user_address = $addess->address ?? "";

            //       if ($addess !== null) {
            // // Initialize an empty array to store address parts
            // $addressParts = [];

            // // Check if address exists and add it to the array
            // if (!empty($addess->address)) {
            //     $addressParts[] = $addess->address;
            // }

            // // Check if landmark exists and add it to the array
            // if (!empty($addess->landmark)) {
            //     $addressParts[] = $addess->landmark;
            // }

            // // Check if area_name exists and add it to the array
            // if (!empty($addess->area_name)) {
            //     $addressParts[] = $addess->area_name;
            // }
            //       }else{

            //           $user_address = '';
            //       }

            //       $fullname = $addess->full_name ?? "";

            // // Concatenate address parts with commas
            // $user_address = implode(', ', $addressParts);
            //     //     $user_address = $addess;
            //       $user_address_id = $items->address_id;
        }


        $all_address = CartItemsModel::where('user_id', $myId)->where('checked', 0)->OrderByDesc('cart_id')->first();

        if ($all_address) {
            $address = $all_address->address_id;

            $addess = UserAddressModel::where('address_id', $address)->first();

            //   $user_address = $addess->address ?? "";

            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address_donr = '';
            }


            if (!empty($addressParts)) {

                $user_address_donr = implode(', ', $addressParts);
            }
        }

        // $addess = UserAddressModel::where('address_id', $item->address_id)->first();
        $total_mrp_sub_total = $mrp_sub_total + $service_mrp_sub_total;
        $total_dis_sub_total = $dis_sub_total + $service_dis_sub_total;

        if ($total_dis_sub_total) {
            $saving_price = $total_mrp_sub_total - $total_dis_sub_total;
        } else {
            $saving_price = 0;
        }

        // $provider_info = User::where('id' , $cart_dtl_done->v_id)->first();

        if (!empty($myId)) {
            $result['response_code'] = "1";
            $result['message'] = "Cart Items Details Found";
            $result['product'] = CartRes::collection($cart_dtl);
            // $result['service'] = new CartSerRes($cart_dtl_done->first());
            $result['service'] = CartSerRes::collection($cart_dtl_done);
            $result['product_subtotal'] = number_format((float)$sub_total, 1, '.', '');
            // $result['product_subtotal'] = (float)$sub_total;
            $result['service_subtotal'] = number_format((float)$service_sub_total, 1, '.', '');
            $result['sub_total'] = number_format((float)$sub_total + $service_sub_total, 1, '.', '');
            // $result['sub_total'] = $sub_total + $service_sub_total;
            $result['mrp_sub_total'] = number_format((float)$mrp_sub_total + $service_mrp_sub_total, 1, '.', '');
            // $result['mrp_sub_total'] = $mrp_sub_total + $service_mrp_sub_total;
            $result['dis_sub_total'] = number_format((float)$dis_sub_total + $service_dis_sub_total, 1, '.', '');
            // $result['dis_sub_total'] = $dis_sub_total + $service_dis_sub_total;
            $result['saving_price'] = number_format((float)$saving_price, 1, '.', '');
            // $result['saving_price'] = $saving_price;
            // $result['coupon'] = 0;
            $result['coupon'] = number_format((float)$coupon_discount, 1, '.', '');
            // $result['coupon'] = $coupon_discount;
            $result['tax'] = "0.0";
            $result['service_charge'] = "0.0";
            $result['total'] = number_format((float)$sub_total + $service_sub_total - $coupon_discount, 1, '.', '');
            // $result['total'] = $sub_total + $service_sub_total  - $coupon_discount;
            // $result['total'] = $totalPrice + $totalSerPrice - $coupon_discount;
            $result['provider_name'] = $name ?? "";
            $result['provider_id'] = $user_id ?? 0;
            $result['address'] = $user_address_donr ?? "";
            $result['address_id'] = $user_address_id ?? 0;
            $result['fullname'] = $fullname ?? "";
            $result["status"] = "success";
            return response()->json($result);
        }

        // return $this->sendResponse(CartRes::collection($cart_dtl), "User Cart Items.");
    }

    public function get_cart_items_do(Request $request)
    {
        // $myId = $request->user()->token()->user_id;
        $myId = Auth::user()->token()->user_id;
        $coupon_code = $request->coupon_code;
        $coupon_type = $request->coupon_type;
        // if (!CartItemsModel::where('user_id', $myId)->exists()) {
        //     return $this->sendMessage("Cart Is empty");
        // }
        $cart_dtl = CartItemsModel::where('user_id', $myId)->where('product_id', '!=', "")->where('checked', "0")->OrderByDesc('cart_id')->get();

        $sub_total = 0;
        $totalPrice = 0;
        $coupon_discount = 0;
        $dis_sub_total = 0;
        $mrp_sub_total = 0;

        foreach ($cart_dtl as $item) {
            $product = Product::where('product_id', $item->product_id)->first();

            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;

            $sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : ($product->product_price * $item->quantity);

            $dis_sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : 0;

            $mrp_sub_total += $product->product_price ? ($product->product_price * $item->quantity) : 0;

            if ($coupon_type == "Product") {

                $dis = Coupon::where('code', $coupon_code)->where('coupon_for', $coupon_type)->first();

                //  $coupon_discount = $dis ? round((($sub_total) * $dis->discount) / 100) : 0;


                $coupon_discount = $dis ? (($sub_total) * $dis->discount) / 100 : 0;


                $totalPrice = $sub_total - $coupon_discount;
            } else {

                $totalPrice = $sub_total;
                // $coupon_discount = 0;
            }


            $user = User::where('id', $product->vid)->first();

            $user_id = $product->vid;
            $name = $user->firstname;

            $addess = UserAddressModel::where('address_id', $item->address_id)->first();


            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address = '';
            }


            $fullname = $addess->full_name ?? "";
            //  $user_address = $addess->address ?? "";
            //  $user_address = $addess;
            $user_address_id = $item->address_id;
        }




        $cart_dtl_done = CartItemsModel::where('user_id', $myId)->where('service_id', '!=', "")->where('checked', "0")->OrderByDesc('cart_id')->get();

        $service_sub_total = 0;
        $totalSerPrice = 0;
        $service_dis_sub_total = 0;
        $service_mrp_sub_total = 0;


        foreach ($cart_dtl_done as $items) {

            $service = Service::where('id', $items->service_id)->first();
            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;
            $service_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : ($service->service_price * $items->quantity);


            $service_dis_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : 0;

            $service_mrp_sub_total += $service->service_price ? ($service->service_price * $items->quantity) : 0;

            if ($coupon_type == "Service") {

                $dis = Coupon::where('code', $coupon_code)->where('coupon_for', $coupon_type)->first();

                //  $coupon_discount = $dis ? round((($service_sub_total) * $dis->discount) / 100) : 0;

                $coupon_discount = $dis ? (($service_sub_total) * $dis->discount) / 100 : 0;


                $totalSerPrice = $sub_total - $coupon_discount;
            } else {

                $totalSerPrice = $service_sub_total;
                // $coupon_discount = 0;
            }

            $user = User::where('id', $service->v_id)->first();
            $name = $user->firstname;

            $user_id = $service->v_id;

            $addess = UserAddressModel::where('address_id', $items->address_id)->first();

            //   $user_address = $addess->address ?? "";

            //       if ($addess !== null) {
            // // Initialize an empty array to store address parts
            // $addressParts = [];

            // // Check if address exists and add it to the array
            // if (!empty($addess->address)) {
            //     $addressParts[] = $addess->address;
            // }

            // // Check if landmark exists and add it to the array
            // if (!empty($addess->landmark)) {
            //     $addressParts[] = $addess->landmark;
            // }

            // // Check if area_name exists and add it to the array
            // if (!empty($addess->area_name)) {
            //     $addressParts[] = $addess->area_name;
            // }
            //       }else{

            //           $user_address = '';
            //       }

            //       $fullname = $addess->full_name ?? "";

            // // Concatenate address parts with commas
            // $user_address = implode(', ', $addressParts);
            //     //     $user_address = $addess;
            //       $user_address_id = $items->address_id;
        }


        $all_address = CartItemsModel::where('user_id', $myId)->where('checked', 0)->OrderByDesc('cart_id')->first();

        if ($all_address) {
            $address = $all_address->address_id;

            $addess = UserAddressModel::where('address_id', $address)->first();

            //   $user_address = $addess->address ?? "";

            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address_donr = '';
            }


            if (!empty($addressParts)) {

                $user_address_donr = implode(', ', $addressParts);
            }
        }

        // $addess = UserAddressModel::where('address_id', $item->address_id)->first();
        $total_mrp_sub_total = $mrp_sub_total + $service_mrp_sub_total;
        $total_dis_sub_total = $dis_sub_total + $service_dis_sub_total;

        if ($total_dis_sub_total) {
            $saving_price = $total_mrp_sub_total - $total_dis_sub_total;
        } else {
            $saving_price = 0;
        }

        // $provider_info = User::where('id' , $cart_dtl_done->v_id)->first();

        if (!empty($myId)) {
            $result['response_code'] = "1";
            $result['message'] = "Cart Items Details Found";
            $result['product'] = CartRes::collection($cart_dtl);
            // $result['service'] = new CartSerRes($cart_dtl_done->first());
            $result['service'] = CartSerRes::collection($cart_dtl_done);
            $result['product_subtotal'] = number_format((float)$sub_total, 1, '.', '');
            // $result['product_subtotal'] = (float)$sub_total;
            $result['service_subtotal'] = number_format((float)$service_sub_total, 1, '.', '');
            $result['sub_total'] = number_format((float)$sub_total + $service_sub_total, 1, '.', '');
            // $result['sub_total'] = $sub_total + $service_sub_total;
            $result['mrp_sub_total'] = number_format((float)$mrp_sub_total + $service_mrp_sub_total, 1, '.', '');
            // $result['mrp_sub_total'] = $mrp_sub_total + $service_mrp_sub_total;
            $result['dis_sub_total'] = number_format((float)$dis_sub_total + $service_dis_sub_total, 1, '.', '');
            // $result['dis_sub_total'] = $dis_sub_total + $service_dis_sub_total;
            $result['saving_price'] = number_format((float)$saving_price, 1, '.', '');
            // $result['saving_price'] = $saving_price;
            // $result['coupon'] = 0;
            $result['coupon'] = number_format((float)$coupon_discount, 1, '.', '');
            // $result['coupon'] = $coupon_discount;
            $result['tax'] = "0.0";
            $result['service_charge'] = "0.0";
            $result['total'] = number_format((float)$sub_total + $service_sub_total - $coupon_discount, 1, '.', '');
            // $result['total'] = $sub_total + $service_sub_total  - $coupon_discount;
            // $result['total'] = $totalPrice + $totalSerPrice - $coupon_discount;
            $result['provider_name'] = $name ?? "";
            $result['provider_id'] = $user_id ?? 0;
            $result['address'] = $user_address_donr ?? "";
            $result['address_id'] = $user_address_id ?? 0;
            $result['fullname'] = $fullname ?? "";
            $result["status"] = "success";
            return response()->json($result);
        }

        // return $this->sendResponse(CartRes::collection($cart_dtl), "User Cart Items.");
    }


    public function get_cart_items(Request $request)
    {
        $myId = Auth::user()->token()->user_id;
        $coupon_code = $request->coupon_code;
        $coupon_type = $request->coupon_type;
        $coupon_percentage = $request->coupon_percentage;

        $all_service = 0;
        $addon_cart_details = [];


        $cart_add_service = CartItemsModel::where('user_id', $myId)
            ->where('service_id', '!=', "")
            ->where('checked', "0")
            ->first();

        if ($cart_add_service) {

            $all_service = $cart_add_service->service_id;

            if ($all_service) {


                $addonProducts = AddonProduct::where('service_id', $all_service)->pluck('product_id')->toArray();

                //   dd($addonProducts);

                $addon_cart_details = [];

                if (!empty($addonProducts)) {
                    // Fetch cart details for products that are in the addon products list
                    $addon_cart_details = CartItemsModel::where('user_id', $myId)
                        ->whereIn('product_id', $addonProducts) // Check if the product_id exists in the addon products
                        // ->where('addon_service_id', $all_service)
                        ->where('checked', "0")
                        ->orderByDesc('cart_id')
                        ->get();
                }
            }
        }

        $cart_dtl_al = CartItemsModel::where('user_id', $myId)
            ->where('product_id', '!=', "")
            //  ->where('addon_service_id', null) 
            // ->where('addon_service_id', "!=", $all_service)
            ->where('checked', "0")
            ->orderByDesc('cart_id')
            ->get();


        $sub_total = 0;
        $totalPrice = 0;
        $coupon_discount = 0;
        $dis_sub_total = 0;
        $mrp_sub_total = 0;
        $total_result = "0.0";
        $total_merge = "0.0";

        foreach ($cart_dtl_al as $item_or) {
            $product = Product::where('product_id', $item_or->product_id)->first();

            $sub_total += $product->product_discount_price ? ($product->product_discount_price * $item_or->quantity) : ($product->product_price * $item_or->quantity);
            $dis_sub_total += $product->product_discount_price ? ($product->product_discount_price * $item_or->quantity) : 0;
            $mrp_sub_total += $product->product_price ? ($product->product_price * $item_or->quantity) : 0;

            // if ($coupon_type == "Product") {
            //     $dis = Coupon::where('code', $coupon_code)
            //                  ->where('coupon_for', $coupon_type)
            //                  ->first();
            //     $coupon_discount = $dis ? (($sub_total) * $dis->discount) / 100 : 0;
            //     $totalPrice = $sub_total - $coupon_discount;
            // } else {
            //     $totalPrice = $sub_total;
            // }

            if (!empty($item_or->coupon_code)) {
                $dis = Coupon::where('code', $item_or->coupon_code)->where('coupon_for', "Product")->first();
                $coupon_discount = $dis ? (($sub_total) * $dis->discount) / 100 : 0;

                $coupon_code_list = $item_or->coupon_code;
                $coupon_percentage_done = $item_or->coupon_percentage;
                $coupon_type_done = $item_or->coupon_type;
            } elseif ($coupon_type == "Product") {
                $dis = Coupon::where('code', $coupon_code)->where('coupon_for', $coupon_type)->first();
                $coupon_discount = $dis ? (($sub_total) * $dis->discount) / 100 : 0;

                CartItemsModel::where('cart_id', $item_or->cart_id)->update(['coupon_code' => $coupon_code, 'coupon_percentage' => $coupon_percentage, 'coupon_type' => $coupon_type]);

                $coupon_code_list = $coupon_code;
                $coupon_percentage_done = $coupon_percentage;
                $coupon_type_done = $coupon_type;
            }

            $totalPrice = $sub_total - $coupon_discount;
        }

        $addon_cart_ids = $addon_cart_details ? $addon_cart_details->pluck('cart_id')->toArray() : 0;

        if ($addon_cart_ids) {

            $cart_dtl = CartItemsModel::where('user_id', $myId)
                ->where('product_id', '!=', "")
                //  ->where('addon_service_id', null) 
                // ->where('addon_service_id', "!=", $all_service)
                ->where('checked', "0")
                ->whereNotIn('cart_id', $addon_cart_ids) // Exclude items based on cart_id

                ->orderByDesc('cart_id')
                ->get();
        } else {

            $cart_dtl = CartItemsModel::where('user_id', $myId)
                ->where('product_id', '!=', "")
                //  ->where('addon_service_id', null) 
                // ->where('addon_service_id', "!=", $all_service)
                ->where('checked', "0")
                ->orderByDesc('cart_id')
                ->get();
        }



        // Group products by provider
        $grouped_products = [];

        foreach ($cart_dtl as $item) {
            $product = Product::where('product_id', $item->product_id)->first();

            // $sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : ($product->product_price * $item->quantity);
            // $dis_sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : 0;
            // $mrp_sub_total += $product->product_price ? ($product->product_price * $item->quantity) : 0;

            // if ($coupon_type == "Product") {
            //     $dis = Coupon::where('code', $coupon_code)
            //                  ->where('coupon_for', $coupon_type)
            //                  ->first();
            //     $coupon_discount = $dis ? (($sub_total) * $dis->discount) / 100 : 0;
            //     $totalPrice = $sub_total - $coupon_discount;
            // } else {
            //     $totalPrice = $sub_total;
            // }

            $user = User::where('id', $product->vid)->first();
            $user_id = $product->vid;
            $provider_name = $user->firstname;

            // Group products by provider ID
            if (!isset($grouped_products[$user_id])) {
                $grouped_products[$user_id] = [
                    'provider_name' => $provider_name,
                    'provider_id' => $user_id,
                    'products' => []
                ];
            }

            $grouped_products[$user_id]['products'][] = new CartRes($item);
        }

        // You can now use $grouped_products to structure your response
        $final_products = [];
        foreach ($grouped_products as $provider) {
            $final_products[] = $provider;
        }

        $cart_dtl_done = CartItemsModel::where('user_id', $myId)
            ->where('service_id', '!=', "")
            ->where('checked', "0")
            ->orderByDesc('cart_id')
            ->get();

        $service_sub_total = 0;
        $totalSerPrice = 0;
        $service_dis_sub_total = 0;
        $service_mrp_sub_total = 0;

        foreach ($cart_dtl_done as $items) {
            $service = Service::where('id', $items->service_id)->with('serviceImages')->first();
            $service_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : ($service->service_price * $items->quantity);
            $service_dis_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : 0;
            $service_mrp_sub_total += $service->service_price ? ($service->service_price * $items->quantity) : 0;

            // if ($coupon_type == "Service") {
            //     $dis = Coupon::where('code', $coupon_code)
            //                  ->where('coupon_for', $coupon_type)
            //                  ->first();
            //     $coupon_discount = $dis ? (($service_sub_total) * $dis->discount) / 100 : 0;
            //     $totalSerPrice = $service_sub_total - $coupon_discount;
            // } else {
            //     $totalSerPrice = $service_sub_total;
            // }


            if (!empty($items->coupon_code)) {
                $dis = Coupon::where('code', $items->coupon_code)->where('coupon_for', "Service")->first();
                $coupon_discount = $dis ? (($service_sub_total) * $dis->discount) / 100 : 0;

                $coupon_code_list = $items->coupon_code;
                $coupon_percentage_done = $items->coupon_percentage;
                $coupon_type_done = $items->coupon_type;
                $totalSerPrice = $service_sub_total - $coupon_discount;
            } elseif ($coupon_type == "Service") {
                $dis = Coupon::where('code', $coupon_code)->where('coupon_for', $coupon_type)->first();
                $coupon_discount = $dis ? (($service_sub_total) * $dis->discount) / 100 : 0;

                CartItemsModel::where('cart_id', $items->cart_id)->update(['coupon_code' => $coupon_code, 'coupon_percentage' => $coupon_percentage, 'coupon_type' => $coupon_type]);

                $coupon_code_list = $coupon_code;
                $coupon_percentage_done = $coupon_percentage;
                $coupon_type_done = $coupon_type;
                $totalSerPrice = $service_sub_total - $coupon_discount;
            } else {
                $totalSerPrice = $service_sub_total;
            }

            // if ($coupon_discount) {

            //     $totalSerPrice = $service_sub_total - $coupon_discount;
            // } else {
            //     $totalSerPrice = $service_sub_total;
            // }

            $user = User::where('id', $service->v_id)->first();

            $user_id = $service->v_id;
            $name = $user->firstname;
        }

        $total_mrp_sub_total = $mrp_sub_total + $service_mrp_sub_total;
        // $total_dis_sub_total = $dis_sub_total + $service_dis_sub_total;
        $total_dis_sub_total = $sub_total + $service_sub_total;
        $saving_price = $total_mrp_sub_total - $total_dis_sub_total;

        $all_address = CartItemsModel::where('user_id', $myId)->where('checked', 0)->OrderByDesc('cart_id')->first();

        if ($all_address) {
            $address = $all_address->address_id;

            $addess = UserAddressModel::where('address_id', $address)->first();

            //   $user_address = $addess->address ?? "";

            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address_donr = '';
            }


            if (!empty($addressParts)) {

                $user_address_donr = implode(', ', $addressParts);
            }
        }

        $razorpay = PaymentGatewayKey::where('id', "1")->first();
        $flutterwave = PaymentGatewayKey::where('id', "2")->first();
        $stripe = PaymentGatewayKey::where('id', "3")->first();
        $paypal = PaymentGatewayKey::where('id', "4")->first();
        $googlepay = PaymentGatewayKey::where('id', "5")->first();
        $wallet = PaymentGatewayKey::where('id', "6")->first();
        $applepay = PaymentGatewayKey::where('id', "7")->first();

        $tax_done = TaxRate::where('id', "1")->first();
        $tax_status = $tax_done->status;

        if ($tax_status == "1") {
            $tax_value = $tax_done->type;
            $tax_rate = $tax_done->tax_rate;

            if ($tax_value == "0") {

                $total_ask = number_format((float)$sub_total + $service_sub_total - $coupon_discount, 1, '.', '');
                $total_result = number_format((float)$total_ask * $tax_rate / 100, 1, '.', '');
                $total_merge = number_format((float)$total_ask + $total_result, 1, '.', '');
            } else {
                $total_ask = number_format((float)$sub_total + $service_sub_total - $coupon_discount, 1, '.', '');
                $total_result = number_format((float)$tax_rate, 1, '.', '');
                $total_merge = number_format((float)$total_ask + $total_result, 1, '.', '');
            }
        } else {
            $total_merge = number_format((float)$sub_total + $service_sub_total - $coupon_discount, 1, '.', '');
            $total_result = "0.000";
        }

        $service_charge = SiteSetup::where('id', "1")->first();
        $service_charg_value = $service_charge->platform_fees;

        $total_fully = $total_merge + $service_charg_value;

        $min_price = SiteSetup::where('id', "1")->first();
        $min_booking_price = $min_price->min_amountbook;

        $result = [
            'response_code' => "1",
            'message' => "Cart Items Details Found",
            'products' => $final_products,
            'services' => CartSerRes::collection($cart_dtl_done),
            'addon_products' => $addon_cart_details ? CartRes::collection($addon_cart_details) : [],
            'product_subtotal' => number_format((float)$totalPrice, 1, '.', ''),
            // 'service_subtotal' => number_format((float)$service_sub_total, 1, '.', ''),
            'service_subtotal' => number_format((float)$totalSerPrice, 1, '.', ''),
            // 'product_subtotal' => $coupon_type === "Product" ? number_format((float)($sub_total - $coupon_discount), 1, '.', '') : number_format((float)$sub_total, 1, '.', ''),
            // 'service_subtotal' => $coupon_type === "Service" ? number_format((float)($service_sub_total - $coupon_discount), 1, '.', '') : number_format((float)$service_sub_total, 1, '.', ''),
            // 'sub_total' => number_format((float)$sub_total + $service_sub_total, 1, '.', ''),
            'sub_total' => number_format((float)$totalPrice + $totalSerPrice + $coupon_discount, 1, '.', ''),
            // 'sub_total' => number_format((float)$totalPrice + $totalSerPrice, 1, '.', ''),
            'mrp_sub_total' => number_format((float)$total_mrp_sub_total, 1, '.', ''),
            'dis_sub_total' => number_format((float)$total_dis_sub_total, 1, '.', ''),
            'saving_price' => number_format((float)$saving_price, 1, '.', ''),
            'coupon' => number_format((float)$coupon_discount, 1, '.', ''),
            // 'tax' => "0.0",
            'tax' => $total_result,
            'service_charge' => $service_charg_value ?? "0",
            // 'total' => number_format((float)$sub_total + $service_sub_total - $coupon_discount, 1, '.', ''),
            // 'total' => $total_merge,
            'total' => (string)$total_fully,
            'name' => $name ?? "",
            'provider_id' => $user_id ?? 0,
            'address' => $user_address_donr ?? "",
            'address_id' => $address ?? 0,
            'razorpay' => (string)$razorpay->status,
            'flutterwave' => (string)$flutterwave->status,
            'stripe' => (string)$stripe->status,
            'paypal' => (string)$paypal->status,
            'googlepay' => (string)$googlepay->status,
            'wallet' => (string)$wallet->status,
            'applepay' => (string)$applepay->status,
            'coupon_code' => $coupon_code_list ?? "",
            'coupon_percentage' => $coupon_percentage_done ?? "",
            'coupon_type' => $coupon_type_done ?? "",
            'min_amount_booking' => $min_booking_price,
            "status" => "success"
        ];

        return response()->json($result);
    }

    public function paymentsend(Request $request)
    {

        // $myId = $request->user()->token()->user_id;
        $myId = Auth::user()->token()->user_id;

        $total = $request->total;

        $cart_dtl = CartItemsModel::where('user_id', $myId)->where('product_id', '!=', "")->where('checked', "0")->OrderByDesc('cart_id')->get();

        $sub_total = 0;
        $totalPrice = 0;
        $coupon_discount = 0;
        // $total = 0;


        foreach ($cart_dtl as $item) {
            $product = Product::where('product_id', $item->product_id)->first();

            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;

            $sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : ($product->product_price * $item->quantity);


            // if($coupon_type == "Product"){

            //      $dis = Coupon::where('code', $coupon_code)->where('coupon_for' ,$coupon_type)->first();

            //      $coupon_discount = $dis ? round((($sub_total) * $dis->discount) / 100) : 0;


            //     $totalPrice = $sub_total - $coupon_discount;                        

            // }else{

            //     $totalPrice = $sub_total;
            //     // $coupon_discount = 0;
            // }


            $user_address_id = $item->address_id;
        }


        $cart_dtl_done = CartItemsModel::where('user_id', $myId)->where('service_id', '!=', "")->where('checked', "0")->OrderByDesc('cart_id')->get();

        $service_sub_total = 0;
        $totalSerPrice = 0;


        foreach ($cart_dtl_done as $items) {

            $service = Service::where('id', $items->service_id)->first();
            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;
            $service_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : ($service->service_price * $items->quantity);


            //   if($coupon_type == "Service"){

            //      $dis = Coupon::where('code', $coupon_code)->where('coupon_for' ,$coupon_type)->first();

            //      $coupon_discount = $dis ? round((($service_sub_total) * $dis->discount) / 100) : 0;


            //     $totalSerPrice = $sub_total - $coupon_discount;                        

            // }else{

            //     $totalSerPrice = $service_sub_total;
            //     // $coupon_discount = 0;
            // }

            $user_address_id = $items->address_id;
        }

        //  $total = $sub_total + $service_sub_total;
        //  $total = $sub_total + $service_sub_total  - $coupon_discount;



        try {
            //code... payment intent
            $stripe = new \Stripe\StripeClient('sk_test_51OP303SJayPbST1lMDr6nn6WieehdLmIpiG2pgVil38DVNPjDqKcFG87d1GMOk10WWtoqZIxvSx2WLAP7G1GMkWu00SJWzq7cn');
            // $jsonStr = file_get_contents('php://input');
            // print_r($jsonStr);
            // header('Content-Type: application/json');
            // die();
            // retrieve JSON from POST body
            // $jsonStr = file_get_contents('php://input');
            // $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            // $stripe->customers->create([
            //     'name' => 'Jenny Rosen',
            //     'address' => [
            //         'line1' => '510 Townsend St',
            //         'postal_code' => '98140',
            //         'city' => 'San Francisco',
            //         'state' => 'CA',
            //         'country' => 'US',
            //     ],
            // ]);

            $res = $stripe->paymentIntents->create([
                'amount' => (int)$total * 100,
                'currency' => "usd",
                'description' => "for amazon-clone project",

                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'shipping' => [
                    'name' => "Random Singh",
                    'address' => [
                        'line1' => "510 Townsend St",
                        'postal_code' => "98140",
                        'city' => "San Francisco",
                        'state' => "CA",
                        'country' => "US",
                    ],
                ],
            ]);
            $output = [
                'clientSecret' =>  $res->client_secret,
            ];

            return $this->sendresponse($output, 'Responce');
            // echo json_encode($output);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError("SolvThisError", $th->getMessage());
        }
    }


    public function del_fromCart(Request $request)
    {
        // $myId = $request->user()->token()->user_id;
        $myId = Auth::user()->token()->user_id;

        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (!CartItemsModel::where('user_id', $myId)->where('cart_id', $request->cart_id)->exists()) {
            return $this->sendMessage("Cart Item not Found.");
            // return response()->json([
            //     'message' => 'Cart not found..!'
            // ]);
        }

        BookingOrders::where('cart_id', $request->cart_id)->delete();
        CartItemsModel::where('user_id', $myId)->where('cart_id', $request->cart_id)->delete();
        return $this->sendMessage("Item removed from cart.");
        // return response()->json([
        //     'message' => 'Cart removed successuly..!',
        // ]);
    }

    public function delete_all_cart(Request $request)
    {
        // $myId = $request->user()->token()->user_id;
        $myId = Auth::user()->token()->user_id;

        if (!CartItemsModel::where('user_id', $myId)->where('checked', "0")->exists()) {
            return $this->sendMessage("Cart Item not Found.");
            // return response()->json([
            //     'message' => 'Cart not found..!'
            // ]);
        }

        $cartItems = CartItemsModel::where('user_id', $myId)->where('checked', "0")->get();

        $cartIds = $cartItems->pluck('id')->toArray();

        BookingOrders::whereIn('cart_id', $cartIds)->delete();

        CartItemsModel::where('user_id', $myId)->where('checked', "0")->delete();
        return $this->sendMessage("All Item removed from cart.");
        // return response()->json([
        //     'message' => 'Cart removed successuly..!',
        // ]);
    }

    public function remove_coupon(Request $request)
    {
        // $myId = $request->user()->token()->user_id;
        $myId = Auth::user()->token()->user_id;

        if (!CartItemsModel::where('user_id', $myId)->where('checked', "0")->exists()) {
            return $this->sendMessage("Cart Item not Found.");
            // return response()->json([
            //     'message' => 'Cart not found..!'
            // ]);
        }

        $cartItems = CartItemsModel::where('user_id', $myId)->where('checked', "0")->get();

        CartItemsModel::where('user_id', $myId)->where('checked', "0")->update(['coupon_code' => ""]);
        return $this->sendMessage("coupon is removed from cart.");
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

            $user_name =  User::where('id', $myId)->first();
            $my_name = $user_name->firstname;

            $address = UserAddressModel::where('address_id', $address_id)->first();
            $add_name = $address->address;
            $landmark = $address->landmark;
            $area_name = $address->area_name;
            $city = $address->city;
            $state = $address->state;
            $country = $address->country;
            $zip_code = $address->zip_code;

            $addressString = $add_name . ', ' . $landmark . ', ' . $area_name . ', ' . $city . ', ' . $state . ', ' . $country . ', ' . $zip_code;




            // $product_name = $product->product_name;


            // //    print_r($mailData);
            // //    die;

            $user_all_done =  User::where('id', $myId)->first();
            $email = $user_all_done->email;
            $firstname = $user_all_done->firstname;

            // $order_date = Carbon::now()->format('d M, Y - h:i A');

            $order_date = now();

            $order_id = $orderID->id;

            $emailPreference = UserEmailOrderPlacedService::where('get_email', 1)->first();

            if ($emailPreference) {
                // Send email on successful OTP verification
                Mail::to($email)->send(
                    new UserOrderPlacedService($email, $product_subtotal, $service_subtotal, $sub_total, $total, $coupon, $tax, $service_charge, $firstname, $order_id, $order_date, $addressString, $my_name, $allItms_done, $booking_services_name, $final_price, $productItms_done)
                );
            }

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

    public function allcart_address_update(Request $request)
    {
        try {
            //code...

            // $myId = $request->user()->token()->user_id;
            $myId = Auth::user()->token()->user_id;
            $address_id = $request->input('address_id');

            $total_items = 0;
            $shipping_charge = 0;
            $address = 0;
            $allItms = CartItemsModel::where('user_id', $myId)->where('checked', 0)->get();
            // print_r($allItms);

            if (count($allItms) <= 0) {
                return $this->sendError('Order items not found.');
            }


            if ($address_id) {

                $update =  CartItemsModel::where('user_id', $myId)->where('checked', 0)->update([
                    'address_id' => $address_id,
                ]);
                // return $this->sendMessage('Order Placed success.');

                if (!empty($update)) {


                    foreach ($allItms as $item) {
                        BookingOrders::where('cart_id', $item->cart_id)->update([
                            'location' => $address_id,
                        ]);
                    }
                    $result['response_code'] = "1";
                    $result['message'] = "All Cart Address Update.";
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


    public function cart_time_slot_booking(Request $request)
    {
        try {
            //code...

            // $myId = $request->user()->token()->user_id;
            $myId = Auth::user()->token()->user_id;
            $cart_id = $request->input('cart_id');
            $booking_date = $request->input('booking_date');
            $booking_time = $request->input('booking_time');
            $notes = $request->input('notes');

            // $total_items = 0;
            // $shipping_charge = 0;
            $address = 0;
            $allItms = CartItemsModel::where('cart_id', $cart_id)->where('user_id', $myId)->where('checked', 0)->first();
            // print_r($allItms);

            // if (count($allItms) <= 0) {
            //     return $this->sendError('Order items not found.');
            // }


            if ($allItms) {

                $update =  CartItemsModel::where('cart_id', $cart_id)->where('user_id', $myId)->where('checked', 0)->update([
                    'booking_date' => $booking_date,
                    'booking_time' => $booking_time,
                    'notes' => $notes,
                ]);
                // return $this->sendMessage('Order Placed success.');

                //  if (!empty($update)) {


                //       foreach ($allItms as $item) {
                //     BookingOrders::where('cart_id', $item->cart_id)->update([
                //         'location' => $address_id,
                //     ]);
                // }
                $result['response_code'] = "1";
                $result['message'] = "Time Slot Update.";
                $result["status"] = "success";
                return response()->json($result);
                // }
            } else {
                return $this->sendError('Failed.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th);
            return $this->sendError('SolveThisError', $th->getMessage());
        }
    }


    public function all_booking_service_by_user(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;


        $users = BookingOrders::where('user_id', $user_id)
            ->where('service_id', '!=', "")
            ->orderByDesc('id')
            ->get();

        foreach ($users as $user) {

            $date = date('d D Y', strtotime($user->created_at));

            $time = date('h:i', strtotime($user->created_at));

            $user->cat_name = $user->cat_name ?? "";
            // $user->location = $user->location ?? "";
            // $user->booking_status = $user->handyman_status ?? "";
            $user->on_status = $user->on_status ?? "";
            $user->work_assign_id = (string)$user->work_assign_id ?? "";
            // $user->handyman_status = $user->handyman_status ?? "";
            $user->otp = $user->otp ?? "";

            $user->booking_status = (string)$user->handyman_status ?? "";
            if ($user->handyman_status == "5") {
                $user->booking_status = "8";
            } elseif ($user->handyman_status == "8") {
                $user->booking_status = "1";
            }


            if ($user->handyman_status == "3") {
                $user->booking_status = "1";
            }

            $user->handyman_status = (string)$user->handyman_status ?? "";
            if ($user->handyman_status == "5") {
                $user->handyman_status = "8";
            } elseif ($user->handyman_status == "8") {
                $user->handyman_status = "1";
            }

            if ($user->handyman_status == "3") {
                $user->handyman_status = "1";
            }

            $user->payment_method = $user->payment_method ?? "";
            // $user->date = $date;
            // $user->time = $time;

            if ($user->cart_id) {
                $cart = CartItemsModel::where('cart_id', $user->cart_id)->first();

                $user->date = $cart->booking_date ?? "";
                $user->time = $cart->booking_time ?? "";
            } else {

                $user->date = "";
                $user->time = "";
            }
            $user->product_id = "";

            $location = $user->location;

            $address_data = UserAddressModel::where('address_id', $location)->first();
            if ($address_data) {
                $fields = [
                    $address_data->address,
                    $address_data->address_type,
                    $address_data->landmark,
                    $address_data->city,
                    $address_data->state,
                    $address_data->country,
                    $address_data->area_name,
                    $address_data->zip_code
                ];

                $filtered_fields = array_filter($fields);
                $user->location = implode(', ', $filtered_fields);
            } else {
                $user->location  = '';
            }

            $quantity = CartItemsModel::where('cart_id', $user->cart_id)->first();

            $user->quantity = $quantity->quantity ?? 0;

            $user->order_id = $quantity->order_id ?? 0;

            $services_all = Service::where('id', $user->service_id)->with('serviceImages')->first();

            $user->service_name = $services_all->service_name;
            $user->service_price = $services_all->service_price;

            // $images = explode("::::", $services_all->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // $user->service_image = $imgsa;

            $imgsa = [];

            foreach ($services_all->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $user->service_image = $imgsa;

            $done = ServiceReview::where('service_id', $user->service_id)->where('booking_id', $user->id)->where('user_id', $user_id)->first();


            $user->isRated = $done ? "1" : "0";

            $users_all = User::where('id', $user->provider_id)->first();

            $user->firstname = $users_all->firstname . ' ' . $users_all->lastname;

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if (!empty($users_all->profile_pic)) {
                $url = explode(":", $users_all->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $user->profile_pic = $users_all->profile_pic;
                } else {
                    $user->profile_pic =  url('/images/user/' . $users_all->profile_pic);
                }
            } else {
                $user->profile_pic = url('/images/user/' . $my_image);
            }
        }





        if (!empty($users)) {
            $result['response_code'] = "1";
            $result['message'] = "Service Booking List Found";
            $result['service_booking_list'] = $users;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service Booking List Not Found";
            $result['service_booking_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function all_booking_product_by_user(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;


        $users = BookingOrders::where('user_id', $user_id)
            ->where('product_id', '!=', "")
            ->orderByDesc('id')
            ->get();

        foreach ($users as $user) {

            $date = date('d D Y', strtotime($user->created_at));

            $time = date('h:i', strtotime($user->created_at));

            $user->payment_method = $user->payment_method ?? "";
            $user->date = $date;
            $user->time = $time;
            $user->service_id = "";
            $user->cat_name = $user->cat_name ?? "";
            // $user->location = $user->location ?? "";
            $user->booking_status = (string)$user->handyman_status ?? "";
            $user->on_status = $user->on_status ?? "";
            $user->work_assign_id = (string)$user->work_assign_id ?? "";
            $user->handyman_status = (string)$user->handyman_status ?? "";
            $user->otp = $user->otp ?? "";

            $location = $user->location;

            $address_data = UserAddressModel::where('address_id', $location)->first();
            if ($address_data) {
                $fields = [
                    $address_data->address,
                    $address_data->address_type,
                    $address_data->landmark,
                    $address_data->city,
                    $address_data->state,
                    $address_data->country,
                    $address_data->area_name,
                    $address_data->zip_code
                ];

                $filtered_fields = array_filter($fields);
                $user->location = implode(', ', $filtered_fields);
            } else {
                $user->location  = '';
            }

            $quantity = CartItemsModel::where('cart_id', $user->cart_id)->first();

            $user->quantity = $quantity->quantity;

            $user->order_id = $quantity->order_id;

            $services_all = Product::where('product_id', $user->product_id)->with('productImages')->first();

            $user->product_name = $services_all->product_name;
            $user->product_price = $services_all->product_price;

            // $images = explode("::::", $services_all->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // $user->product_image = $imgsa;

            $imgsa = [];

            foreach ($services_all->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $user->product_image = $imgsa;


            $done = ProductReview::where('product_id', $user->product_id)->where('user_id', $user_id)->first();


            $user->isRated = $done ? "1" : "0";

            $users_all = User::where('id', $user->provider_id)->first();

            $user->provider_name = $users_all->firstname . ' ' . $users_all->lastname;

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if (!empty($users_all->profile_pic)) {
                $url = explode(":", $users_all->profile_pic);

                if ($url[0] == "https" || $url[0] == "http") {
                    $user->profile_pic = $users_all->profile_pic;
                } else {
                    $user->profile_pic =  url('/images/user/' . $users_all->profile_pic);
                }
            } else {
                $user->profile_pic =  url('/images/user/' . $my_image);
            }
        }





        if (!empty($users)) {
            $result['response_code'] = "1";
            $result['message'] = "Product Booking List Found";
            $result['product_booking_list'] = $users;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Product Booking List Not Found";
            $result['product_booking_list'] = [];
        }

        return response()->json($result);
    }

    public function service_booking_details_by_booking_id(Request $request)
    {
        try {
            $booking_id = $request->input('booking_id');
            $user_id = Auth::user()->id;

            $bookingOrder = BookingOrders::where('id', $booking_id)->first();

            if (!$bookingOrder) {
                return response()->json([
                    "response_code" => "0",
                    "message" => "Booking List Not Found..!",
                    "status" => "failure",
                    'booking' => [],
                ], 200);
            }

            $restaurant = [
                'id' => (string)$bookingOrder->id,
                'cat_name' => $bookingOrder->cat_name ?? "",
                'service_id' => (string)$bookingOrder->service_id ?? "",
                // 'cat_image' => "",
                'payment' => $bookingOrder->payment ?? "",
                // 'location' => $bookingOrder->location ?? "",
                // 'booking_status' => $bookingOrder->handyman_status ?? "",
                'payment_method' => $bookingOrder->payment_method ?? "",
                'user_id' => $bookingOrder->user_id ?? "",
                'on_status' => $bookingOrder->on_status ?? "",
                'work_assign_id' => (string)$bookingOrder->work_assign_id ?? "",
                'otp' => $bookingOrder->otp ?? "",
                // 'date' => date('d D Y', strtotime($bookingOrder->created_at)),
                // 'time' => date('h:i', strtotime($bookingOrder->created_at)),
            ];

            $restaurant['booking_status'] = (string)$bookingOrder->handyman_status ?? "";
            if ($bookingOrder->handyman_status == "5") {
                $restaurant['booking_status'] = "8";
            } elseif ($bookingOrder->handyman_status == "8") {
                $restaurant['booking_status'] = "1";
            }

            if ($bookingOrder->handyman_status == "3") {
                $restaurant['booking_status'] = "1";
            }


            $handyman = User::find($bookingOrder->work_assign_id);
            $restaurant['assigned_by'] = $bookingOrder->work_assign_id ? $handyman->firstname . ' ' . $handyman->lastname : "";

            $all_image = DefaultImage::where('people_id', "2")->first();
            $my_image = $all_image->image;


            // $restaurant['handyman_name'] = $bookingOrder->work_assign_id ? $handyman->firstname . ' ' . $handyman->lastname : "";
            $restaurant['handyman_id'] = $bookingOrder->work_assign_id ? (string)$bookingOrder->work_assign_id : "0";
            $restaurant['handyman_email'] = $bookingOrder->work_assign_id ? $handyman->email : "";
            $restaurant['handyman_phone'] = $bookingOrder->work_assign_id ? $handyman->mobile : "";
            $restaurant['handyman_image'] = $bookingOrder->work_assign_id ? $handyman->profile_pic ? url('/images/user/' . $handyman->profile_pic) : url('/images/user/' . $my_image) :  url('/images/user/' . $my_image);

            $services_all = CartItemsModel::where('cart_id', $bookingOrder->cart_id)->first();

            $order_id = $services_all->order_id;

            $restaurant['order_id'] = (string)$services_all->order_id ?? "";
            $restaurant['notes'] = $services_all->notes ?? "";
            $restaurant['booking_date'] = $services_all->booking_date ?? "";
            $restaurant['booking_time'] = $services_all->booking_time ?? "";

            $done = ServiceReview::where('service_id', $bookingOrder->service_id)->where('user_id', $user_id)->first();


            $restaurant['isRated'] = $done ? "1" : "0";



            $location = $bookingOrder->location;

            $address_data = UserAddressModel::where('address_id', $location)->first();
            if ($address_data) {
                $fields = [
                    $address_data->address,
                    $address_data->address_type,
                    $address_data->landmark,
                    $address_data->city,
                    $address_data->state,
                    $address_data->country,
                    $address_data->area_name,
                    $address_data->zip_code
                ];

                $restaurant['contact_number'] = $address_data->phone ?? "";
                $filtered_fields = array_filter($fields);
                $restaurant['location'] = implode(', ', $filtered_fields);
            } else {
                $restaurant['location'] = '';
            }

            $restaurant['lat'] = $address_data->lat ?? "";
            $restaurant['lon'] = $address_data->lon ?? "";

            $user = User::find($bookingOrder->provider_id);

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                $restaurant['provider_id'] = (string)$user->id ?? "";
                $restaurant['provider_name'] = $user->firstname . ' ' . $user->lastname;
                $restaurant['email'] = $user->email ?? "";
                $restaurant['profile_pic'] = $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);;
                $restaurant['provider_location'] = $user->location ?? "";
                // $restaurant['mobile'] = $user->mobile ?? "";
                $restaurant['mobile'] = ($user->country_code ?? '') . ($user->mobile ?? '');
            } else {
                $restaurant['provider_id'] = "";
                $restaurant['provider_name'] = "";
                $restaurant['email'] = "";
                $restaurant['profile_pic'] = "";
                $restaurant['provider_location'] = "";
                $restaurant['mobile'] = "";
            }

            // $cart_items = CartItemsModel::where('order_id', $order_id)->first();

            $order = OrdersModel::where('id', $order_id)->first();

            if ($order) {
                // $restaurant['price'] = $cart_items->price ?? "";
                $restaurant['coupon'] = $order->coupon ?? "";
                $restaurant['tax'] = $order->tax ?? "";
                $restaurant['service_charge'] = $order->service_charge ?? "";
                $restaurant['sub_total'] =  $order->sub_total;
                $restaurant['mrp_sub_total'] =  $order->mrp_sub_total ?? "0.0";
                $restaurant['total'] =  $order->total;
                $restaurant['quantity'] = (string)$services_all->quantity ?? "";
            } else {
                // $restaurant['price'] = $cart_items->price;
                $restaurant['coupon'] = $order->coupon ?? "";
                $restaurant['tax'] = $order->tax ?? "";
                $restaurant['service_charge'] = $order->service_charge ?? "";
                $restaurant['sub_total'] =  $order->sub_total;
                $restaurant['mrp_sub_total'] =  $order->mrp_sub_total ?? "0.0";
                $restaurant['total'] =  $order->total;
                $restaurant['quantity'] = (string)$services_all->quantity ?? "";
            }

            $service_proof = ServiceProof::where('booking_id', $booking_id)->first();

            $restaurant['service_proof_status'] = $service_proof ? "1" : "0";

            $services_all = Service::where('id', $bookingOrder->service_id)->with('serviceImages')->first();

            $restaurant['service_name'] = $services_all->service_name;
            $restaurant['service_price'] = $services_all->service_price;
            $restaurant['service_discount_price'] = $services_all->service_discount_price ?? "";
            $restaurant['service_description'] = $services_all->service_description ?? "";

            $don_all = BookingOrdersStatus::where('booking_id', $booking_id)->first();
            $restaurant['reason'] = $don_all->reason ?? "";


            // $images = explode("::::", $services_all->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // $restaurant['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($services_all->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $restaurant['service_image'] = $imgsa;


            $review_list = ServiceReview::where('service_id', $bookingOrder->service_id)->get();


            foreach ($review_list as $row) {
                $res = [];
                $res['id'] = (string)$row->id;
                $res['user_id'] = $row->user_id ?  $row->user_id : "";
                $res['text'] = $row->text  ?  $row->text : "";
                $res['star_count'] = $row->star_count ?  $row->star_count : "";
                $res['service_id'] = $row->service_id ?  $row->service_id : "";

                $date = date('d D Y', strtotime($row->created_at));

                $time = date('h:i', strtotime($row->created_at));


                $res['date'] = $date;
                $res['time'] = $time;


                $users_all = User::where('id', $row->user_id)->first();

                $res['firstname'] = $users_all->firstname . ' ' . $users_all->lastname;

                $all_image = DefaultImage::where('people_id', "3")->first();
                $my_image = $all_image->image;


                if (!empty($users_all->profile_pic)) {
                    $url = explode(":", $users_all->profile_pic);

                    if ($url[0] == "https" || $url[0] == "http") {
                        $res['profile_pic'] = $users_all->profile_pic;
                    } else {
                        $res['profile_pic'] =  url('/images/user/' . $users_all->profile_pic);
                    }
                } else {
                    $res['profile_pic'] = url('/images/user/' . $my_image);
                }



                $array[] = $res;
            }


            $total_review_count = ServiceReview::where('service_id', $bookingOrder->service_id)->count();

            $response = [
                "response_code" => "1",
                "message" => "Booking List Found",
                "status" => "success",
                'booking' => $restaurant,
                'review' => $array ?? [],
                'total_review_count' => $total_review_count,
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return $this->sendError("Booking List not Found", $th->getMessage());
        }
    }


    public function product_booking_details_by_booking_id(Request $request)
    {
        try {
            $booking_id = $request->input('booking_id');
            $user_id = Auth::user()->id;

            $bookingOrder = BookingOrders::where('id', $booking_id)->first();

            if (!$bookingOrder) {
                return response()->json([
                    "response_code" => "0",
                    "message" => "Booking List Not Found..!",
                    "status" => "failure",
                    'booking' => [],
                ], 200);
            }

            $restaurant = [
                'id' => (string)$bookingOrder->id,
                'cat_name' => $bookingOrder->cat_name ?? "",
                // 'cat_image' => "",
                'product_id' => (string)$bookingOrder->product_id ?? "",
                'payment' => $bookingOrder->payment ?? "",
                // 'location' => $bookingOrder->location ?? "",
                'booking_status' => (string)$bookingOrder->handyman_status ?? "",
                'payment_method' => $bookingOrder->payment_method ?? "",
                'user_id' => $bookingOrder->user_id ?? "",
                'on_status' => $bookingOrder->on_status ?? "",
                'work_assign_id' => (string)$bookingOrder->work_assign_id ?? "",
                // 'date' => date('d D Y', strtotime($bookingOrder->created_at)),
                // 'time' => date('h:i', strtotime($bookingOrder->created_at)),
            ];

            $services_all = CartItemsModel::where('cart_id', $bookingOrder->cart_id)->first();

            $order_id = $services_all->order_id;

            $total_item = CartItemsModel::where('order_id', $order_id)->count();

            $restaurant['total_items'] = $total_item;

            $done = ProductReview::where('product_id', $bookingOrder->product_id)->where('user_id', $user_id)->first();


            $restaurant['isRated'] = $done ? "1" : "0";


            $location = $bookingOrder->location;

            $address_data = UserAddressModel::where('address_id', $location)->first();
            if ($address_data) {
                $fields = [
                    $address_data->address,
                    $address_data->address_type,
                    $address_data->landmark,
                    $address_data->city,
                    $address_data->state,
                    $address_data->country,
                    $address_data->area_name,
                    $address_data->zip_code
                ];

                $restaurant['contact_number'] = $address_data->phone ?? "";
                $filtered_fields = array_filter($fields);
                $restaurant['location'] = implode(', ', $filtered_fields);
            } else {
                $restaurant['location'] = '';
            }

            $restaurant['lat'] = $address_data->lat ?? "";
            $restaurant['lon'] = $address_data->lon ?? "";

            $restaurant['order_id'] = (string)$services_all->order_id ?? "";
            $restaurant['notes'] = $services_all->notes ?? "";
            $dateTime = $services_all->created_at ?? "";
            $formattedDate = $dateTime->format('d D Y');
            $restaurant['booking_date'] = $formattedDate;

            $formattedTime = $dateTime->format('H:i');
            $restaurant['booking_time'] = $formattedTime ?? "";

            $user = User::find($bookingOrder->provider_id);
            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                $restaurant['provider_id'] = (string)$user->id ?? "";
                $restaurant['provider_name'] = $user->firstname . ' ' . $user->lastname;
                $restaurant['email'] = $user->email ?? "";
                $restaurant['profile_pic'] = $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
                // $restaurant['location'] = $user->location ?? "";
                // $restaurant['mobile'] = $user->mobile ?? "";
                $restaurant['mobile'] = ($user->country_code ?? '') . ($user->mobile ?? '');
            } else {
                $restaurant['provider_id'] = "";
                $restaurant['provider_name'] = "";
                $restaurant['email'] = "";
                $restaurant['profile_pic'] = "";
                // $restaurant['location'] = "";
                $restaurant['mobile'] = "";
            }

            // $cart_items = CartItemsModel::where('order_id', $order_id)->first();
            $cart_items = OrdersModel::where('id', $order_id)->first();

            if ($cart_items) {
                // $restaurant['price'] = $cart_items->price ?? "";
                $restaurant['coupon'] = $cart_items->coupon ?? "";
                $restaurant['service_charge'] = $cart_items->service_charge ?? "";
                $restaurant['tax'] = $cart_items->tax ?? "";
                $restaurant['sub_total'] =  $cart_items->sub_total;
                $restaurant['mrp_sub_total'] =  $cart_items->mrp_sub_total ?? "0.0";
                $restaurant['total'] =  $cart_items->total;
                $restaurant['quantity'] = (string)$services_all->quantity ?? "";
            } else {
                // $restaurant['price'] = $cart_items->price;
                $restaurant['coupon'] = $cart_items->coupon ?? "";
                $restaurant['service_charge'] = $cart_items->service_charge ?? "";
                $restaurant['tax'] = $cart_items->tax ?? "";
                $restaurant['sub_total'] =  $cart_items->sub_total;
                $restaurant['mrp_sub_total'] =  $cart_items->mrp_sub_total ?? "0.0";
                $restaurant['total'] =  $cart_items->total;
                $restaurant['quantity'] = (string)$services_all->quantity ?? "";
            }

            $service_proof = ServiceProof::where('booking_id', $booking_id)->first();

            $restaurant['service_proof_status'] = $service_proof ? "1" : "0";

            // $services_all = Service::where('id', $cart_items->service_id)->first();

            // $restaurant['service_name'] = $services_all->service_name;
            // $restaurant['service_price'] = $services_all->service_price;

            // $images = explode("::::", $services_all->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // $restaurant['service_image'] = $imgsa;


            $product_all = Product::where('product_id', $bookingOrder->product_id)->with('productImages')->first();

            $restaurant['product_name'] = $product_all->product_name;
            $restaurant['product_price'] = $product_all->product_price;
            $restaurant['product_discount_price'] = $product_all->product_discount_price ?? "";
            $restaurant['product_description'] = $product_all->product_description ?? "";

            // $images = explode("::::", $product_all->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $restaurant['product_image'] = $imgsa;
            $imgsa = [];

            foreach ($product_all->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $restaurant['product_image'] = $imgsa;





            $review_list = ProductReview::where('product_id', $bookingOrder->product_id)->get();


            foreach ($review_list as $row) {
                $res = [];
                $res['id'] = (string)$row->id;
                $res['user_id'] = $row->user_id ?  $row->user_id : "";
                $res['text'] = $row->text  ?  $row->text : "";
                $res['star_count'] = $row->star_count ?  $row->star_count : "";
                $res['product_id'] = $row->product_id ?  $row->product_id : "";

                $date = date('d D Y', strtotime($row->created_at));

                $time = date('h:i', strtotime($row->created_at));


                $res['date'] = $date;
                $res['time'] = $time;


                $users_all = User::where('id', $row->user_id)->first();

                $res['firstname'] = $users_all->firstname . ' ' . $users_all->lastname;

                $all_image = DefaultImage::where('people_id', "3")->first();
                $my_image = $all_image->image;

                if (!empty($users_all->profile_pic)) {
                    $url = explode(":", $users_all->profile_pic);

                    if ($url[0] == "https" || $url[0] == "http") {
                        $res['profile_pic'] = $users_all->profile_pic;
                    } else {
                        $res['profile_pic'] =  url('/images/user/' . $users_all->profile_pic);
                    }
                } else {
                    $res['profile_pic'] = url('/images/user/' . $my_image);
                }



                $array[] = $res;
            }

            $review_list = ProductReview::where('product_id', $bookingOrder->product_id)->count();

            $response = [
                "response_code" => "1",
                "message" => "Booking List Found",
                "status" => "success",
                'booking' => $restaurant,
                'review' => $array ?? [],
                'total_review_count' => $total_review_count,
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            // return $this->sendError("Booking List not Found", $th->getMessage());

            $response = [
                "response_code" => "1",
                "message" => "Booking List Found",
                "status" => "success",
                'booking' => $restaurant,
                'review' => [],
                'total_review_count' => 0,
            ];

            return response()->json($response, 200);
        }
    }


    public function all_booking_details_by_orderid(Request $request)
    {
        // $myId = $request->user()->token()->user_id;
        $myId = Auth::user()->token()->user_id;

        $order_id = $request->input('order_id');


        // $cart_dtl = CartItemsModel::where('user_id', $myId)->where('order_id', $order_id)->where('product_id', '!=', "")->where('checked',"1")->OrderByDesc('cart_id')->get();

        $cart_dtl = CartItemsModel::where('order_id', $order_id)->where('product_id', '!=', "")->where('checked', "1")->OrderByDesc('cart_id')->get();

        $sub_total = 0;


        foreach ($cart_dtl as $item) {
            $product = Product::where('product_id', $item->product_id)->first();

            // $booking_id = BookingOrders::where('id', $item->cart_id)->first();

            //  $user_address_id = $booking_id->id;
            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;
            //         $sub_total += $product->product_discount_price ? ($product->product_discount_price * $item->quantity) : ($product->product_price * $item->quantity);

            //         $user = User::where('id', $product->vid)->first();

            //         $user_id = $product->vid;
            //         $name = $user->firstname;

            //   $addess = UserAddressModel::where('address_id', $item->address_id)->first();

            //      $user_address = $addess->address ?? "";
            //      $user_address_id = $item->address_id;

            $user = User::where('id', $product->vid)->first();

            $user_id = $product->vid;
            $name = $user->firstname;
            $user_profile_pic =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : "";

            $addess = UserAddressModel::where('address_id', $item->address_id)->first();


            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address = '';
            }


            $fullname = $addess->full_name ?? "";

            //  $user_address = $addess->address ?? "";
            //  $user_address = $addess;
            $user_address_id = $item->address_id;
        }




        // $cart_dtl_done = CartItemsModel::where('user_id', $myId)->where('order_id', $order_id)->where('service_id', '!=', "")->where('checked',"1")->OrderByDesc('cart_id')->get();

        $cart_dtl_done = CartItemsModel::where('order_id', $order_id)->where('service_id', '!=', "")->where('checked', "1")->OrderByDesc('cart_id')->get();

        //  $service_sub_total = 0;


        foreach ($cart_dtl_done as $items) {

            $service = Service::where('id', $items->service_id)->first();
            // $total_items += $item->quantity;
            // $sub_total += $product->product_price * $item->quantity;
            //         $service_sub_total += $service->service_discount_price ? ($service->service_discount_price * $items->quantity) : ($service->service_price * $items->quantity);

            //         $addess = UserAddressModel::where('address_id', $items->address_id)->first();

            //   $user_address = $addess->address ?? "";
            //   $user_address_id = $items->address_id;

            $addess = UserAddressModel::where('address_id', $items->address_id)->first();

            $fullname = $addess->full_name ?? "";
            $user_address_id = $items->address_id;


            if ($addess !== null) {
                // Initialize an empty array to store address parts
                $addressParts = [];

                // Check if address exists and add it to the array
                if (!empty($addess->address)) {
                    $addressParts[] = $addess->address;
                }

                // Check if landmark exists and add it to the array
                if (!empty($addess->landmark)) {
                    $addressParts[] = $addess->landmark;
                }

                // Check if area_name exists and add it to the array
                if (!empty($addess->area_name)) {
                    $addressParts[] = $addess->area_name;
                }
            } else {

                $user_address = '';
            }

            if (!empty($addressParts)) {
                $user_address = implode(', ', $addressParts);
            }

            $user = User::where('id', $service->v_id)->first();
            $user_id = $service->v_id;
            $name = $user->firstname;
            $user_profile_pic =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : "";
        }

        $all_order = OrdersModel::where('id', $order_id)->first();

        // $addess = UserAddressModel::where('address_id', $item->address_id)->first();


        // $provider_info = User::where('id' , $cart_dtl_done->v_id)->first();

        if (!empty($myId)) {
            $result['response_code'] = "1";
            $result['message'] = "Cart Items Details Found";
            $result['product'] = CartRes::collection($cart_dtl);
            // $result['service'] = new CartSerRes($cart_dtl_done->first());
            $result['service'] = CartSerRes::collection($cart_dtl_done);
            // $result['product_subtotal'] = $sub_total;
            // $result['service_subtotal'] = $service_sub_total;

            // $result['coupon'] = 0;
            // $result['tax'] = 0;
            $result['payment_method'] = $all_order->payment_mode ?? "";
            $result['sub_total'] = $all_order->sub_total ?? "";
            $result['service_charge'] = $all_order->service_charge ?? "";
            $result['coupon'] = $all_order->coupon ?? "";
            $result['tax'] = $all_order->tax ?? "";
            $result['total'] = $all_order->total ?? "";
            $result['provider_name'] = $name ?? "";
            $result['provider_image'] = $user_profile_pic ?? "";
            $result['provider_id'] = $user_id ?? 0;
            $result['address'] = $user_address ?? "";
            $result['address_id'] = $user_address_id ?? 0;
            $result["status"] = "success";
            return response()->json($result);
        }

        // return $this->sendResponse(CartRes::collection($cart_dtl), "User Cart Items.");
    }


    public function create_ticket(Request $request)
    {
        $myId = Auth::user()->token()->user_id;
        $input = $request->all();

        $validator = Validator::make($input, [
            // 'to_user' => 'required',
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $new_ticket = OrdersModel::where('id', $request->order_id)->first();

        if (empty($new_ticket)) {

            return response()->json(['success' => "false", 'message' => "Order Id is not Exist.."]);
        }
        // if (request('message') == "" || request('url') == "") {
        //     return $this->sendError(['error' => "message, url is required."]);
        // }

        // $to_user = request('to_user');
        // $user_id = request('user_id');
        $order_id = request('order_id');
        $subject = request('subject');
        $type = request('type');

        $res_image = array();

        if (request()->hasFile('image')) {
            $files = request()->file('image');

            foreach ($files as $file) {
                $validator = Validator::make(['image' => $file], [
                    'image' => 'required|mimes:gif,jpg,png,jpeg',
                ]);

                if ($validator->fails()) {
                    $temp["response_code"] = "0";
                    $temp["message"] = $validator->errors()->first();
                    $temp["status"] = "failure";
                    return response()->json($temp);
                }

                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                // $filePath = 'assets/images/posts';

                $file->move(public_path('/images/support_chat_images'), $fileName);

                // Move the uploaded file to the desired location
                // $file->move($filePath, $fileName);

                array_push($res_image, $fileName);
            }
        }


        $input['user_id'] = $myId;
        // $input['to_user'] = $to_user;
        $input['order_id'] = $order_id;
        $input['description'] = (request('description')) ? request('description') : "";
        // $input['image'] = (request('image')) ? request('image') : "";

        $input['image'] = implode('::::', $res_image);
        $input['subject'] = $subject;
        $input['type'] = $type;
        // $input['thumbnail'] = (request('thumbnail')) ? request('thumbnail') : "";
        // $input['time'] = (request('time')) ? request('time') : "";
        // if ($request->file('image')) {
        //     if ($request->file('image')) {
        //         $file = $request->file('image');
        //         $filename = "chat_" . uniqid() . '.' . $file->getClientOriginalExtension();
        //         // $file->move(public_path('/files/chat_images'), $filename);

        //         $file->move(public_path('public/support_chat_images/'), $filename);
        //         $input['image'] = $filename;
        //     }
        // } 
        // else {
        //     $input['message'] = request('message');
        // }

        // $user = User::where('id' ,$to_user)->first();
        // $status = $user->is_status;

        // $input['msg_delivered'] = $status;

        $chat = Ticket::create($input);

        $done['from_user'] = $myId;
        $done['to_user'] = "1";
        $done['order_number'] = $order_id;
        $done['message'] = (request('description')) ? request('description') : "";
        // $input['image'] = (request('image')) ? request('image') : "";

        $done['url'] = implode('::::', $res_image);
        $done['subject'] = $subject;
        $done['type'] = $type;

        $chat_all = SupportChat::create($done);

        $all['from_user'] = "1";
        $all['to_user'] = $myId;
        $all['order_number'] = $order_id;
        $all['status'] = "0";

        $chat_all_done = SupportChatstatus::create($all);

        if (!empty($chat)) {

            // $user = Auth::guard('sanctum')->user();

            // $fUser = User::select('name')->where('id',  Auth::guard('sanctum')->user()->id)->first()->name;
            // $FcmToken = User::select('device_token')->where('id', $request->to_user)->first()->device_token;
            // $data = [
            //     "registration_ids" => array($FcmToken),
            //     "notification" => [
            //         "title" => "Message",
            //         "body" => "$fUser send you message.",
            //     ]
            // ];
            // $this->sendNotification($data);

            return response()->json(['success' => "true", 'message' => "Message Send successfully..!"]);
        } else {
            return response()->json(['error' => "message not send"]);
        }
    }

    public function all_ticket_by_user(Request $request)
    {
        // $validator = FacadesValidator::make($request->all(), [
        //     'user_id' => 'required',
        // ]);

        // $user_id = request('user_id'); 

        // if ($validator->fails()) {
        //     return $this->sendError("Enter this field", $validator->errors(), 422);
        // }

        $myId = Auth::user()->token()->user_id;

        $like = Ticket::where('user_id', $myId)->exists();
        if (empty($like)) {
            //  return $this->sendError("User is Not Liked");
            $result['response_code'] = "1";
            $result['message'] = "User Found";
            $result["status"] = "success";
            $result["Users"] = [];

            return response()->json($result);
        }


        if (Ticket::where('user_id', $myId)->exists()) {
            try {
                $approve = Ticket::where('user_id', $myId)->orderBy('id', 'desc')->get();
                $convo_list_arr = [];

                foreach ($approve as $row) {
                    // $approveId = $list->event_id;
                    // $result = Event::where('id', $approveId)->get();

                    // foreach ($result as $row) {
                    $restaurant = [];
                    $restaurant['id'] = (string)$row->id;
                    $restaurant['subject'] = $row->subject ?  $row->subject : "";
                    $restaurant['description'] = $row->description  ?  $row->description : "";
                    $restaurant['user_id'] = $row->user_id ?  $row->user_id : "";
                    $restaurant['type'] = $row->type ?  $row->type : "";

                    $restaurant['order_id'] = $row->order_id ?  (string)$row->order_id : "";


                    // $approve = Event::where('id', $row->event_id)->first();

                    //                          if (!empty($row->image)) {
                    //     $imageUrls = explode("::::", $row->image);

                    //     if (!empty($imageUrls[0])) {
                    //         $restaurant['image'] = url('public/support_chat_images/' . $imageUrls[0]);
                    //     } else {
                    //         $restaurant['image'] = ""; // Handle the case when there are no images.
                    //     }
                    // } else {
                    //     $restaurant['image'] = ""; // Handle the case when $approve->image is empty.
                    // }

                    if (!empty($row->image)) {
                        $images = explode("::::", $row->image);
                        $imgs = array();
                        $imgsa = array();
                        foreach ($images as $key => $image) {


                            // $imgs =  asset('assets/images/post/'. $image);

                            $imgs = asset('/images/support_chat_images/' . $image);

                            array_push($imgsa, $imgs);
                        }
                        // $user->service_image = $imgsa;

                        $restaurant['image'] = $imgsa;
                    } else {
                        $restaurant['image'] = [];
                    }


                    // $currentDate = Carbon::now();
                    // $expireDate = Carbon::parse($approve->date);

                    $createdTimestamp = $row->created_at;

                    // $createdDate = new DateTime($createdTimestamp);

                    $formattedCreatedDate = $createdTimestamp->format('d/m/Y');


                    $restaurant['date'] = $formattedCreatedDate;


                    $event = SupportChatstatus::where('order_number', $row->order_id)->first();

                    $status = $event->status;
                    $restaurant['status'] = (string)$status ?? "1";

                    $array[] = $restaurant;
                    // }
                }

                $temp = [
                    "response_code" => "1",
                    "message" => "User All Ticket Found",
                    "status" => "success",
                    "Users" => $array
                ];

                return response()->json($temp);


                // if (!empty($convo_list_arr)) {
                //     $result['response_code'] = "1";
                //     $result['message'] = "Chat Found";
                //     $result['messages_list'] = $array;
                //     $result["status"] = "success";
                // } else {
                //     $result['response_code'] = "0";
                //     $result['message'] = "Chat Not Found";
                //     $result['messages_list'] = [];
                //     $result["status"] = "success";
                // }

                // return response()->json($result);
            } catch (\Throwable $th) {
                return $this->sendError("Otp not send", $th->getMessage());
            }
        }
    }
    public function support_chat_api(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'to_user' => 'required',
            'from_user' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // if (request('message') == "" || request('url') == "") {
        //     return $this->sendError(['error' => "message, url is required."]);
        // }

        $to_user = request('to_user');
        $from_user = request('from_user');
        $order_number = request('order_number');
        $subject = request('subject');


        $input['from_user'] = $from_user;
        $input['to_user'] = $to_user;
        $input['order_number'] = $order_number;
        $input['message'] = (request('message')) ? request('message') : "";
        $input['url'] = (request('url')) ? request('url') : "";
        $input['subject'] = $subject;
        // $input['thumbnail'] = (request('thumbnail')) ? request('thumbnail') : "";
        // $input['time'] = (request('time')) ? request('time') : "";
        if ($request->file('url')) {
            if ($request->file('url')) {
                $file = $request->file('url');
                $filename = "chat_" . uniqid() . '.' . $file->getClientOriginalExtension();
                // $file->move(public_path('/files/chat_images'), $filename);

                $file->move(public_path('/images/support_chat_images/'), $filename);
                $input['url'] = $filename;
            }
        } else {
            $input['message'] = request('message');
        }

        // $user = User::where('id' ,$to_user)->first();
        // $status = $user->is_status;

        // $input['msg_delivered'] = $status;

        $chat = SupportChat::create($input);
        if (!empty($chat)) {

            $FcmToken = User::where('id', $to_user)->value('device_token');
            $username =  User::where('id', $from_user)->first();

            $firstname = $username->firstname;

            $data = [
                'title' => "Message",
                'message' => "$firstname is support chat now.",
                'type' => "Support Chat",
                'booking_id' => $from_user,
                'order_id' => $to_user,
            ];

            //  dd($data);

            //  $this->sendNotification(new Request($data), $FcmToken);

            if ($FcmToken) {

                $this->sendNotification(new Request($data), $FcmToken);
            } else {

                // \Log::warning("Provider with ID {$to_user} has no valid device token.");
            }

            return response()->json(['success' => "true", 'message' => "Message Send successfully..!"]);
        } else {
            return response()->json(['error' => "message not send"]);
        }
    }

    public function support_message_list(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'peer_id' => 'required',
            'order_number' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        $result = [];
        // if (!$request->filled('user_id')) {
        //     $result['response_code'] = '0';
        //     $result['message'] = 'Enter Data';
        //     $result['status'] = 'failure';
        //     return response()->json($result);
        // }

        $from_user = $request->input('user_id');
        $to_user = $request->input('peer_id');
        $order_id = $request->input('order_number');


        $fcount = User::where('id', $to_user)->count();

        if ($fcount > 0) {



            $user = SupportChat::where(function ($query) use ($from_user, $to_user, $order_id) {
                $query->where('from_user', $from_user)->where('to_user', $to_user)->where('order_number', $order_id);
            })
                ->orWhere(function ($query) use ($from_user, $to_user, $order_id) {
                    $query->where('to_user', $from_user)->where('from_user', $to_user)->where('order_number', $order_id);
                })->get()->transform(function ($ts) use ($from_user, $to_user, $order_id) {

                    // if(SupportChat::where('from_user', $from_user)->where('to_user', $to_user)->exists()) {
                    //   $ts['is_message_me'] = "1";
                    // } else {
                    //     $ts['is_message_me'] = "0";
                    // }

                    if (SupportChat::where('from_user', $from_user)->where('to_user', $to_user)->where('id', $ts['id'])->exists()) {
                        $ts['is_message_me'] = "1";
                    } else {
                        $ts['is_message_me'] = "0";
                    }


                    return $ts;
                });

            // $user = DB::select("SELECT * FROM chats WHERE (from_user = ? AND to_user = ?) OR (to_user = ? AND from_user = ?)", [$from_user, $to_user, $from_user, $to_user]);

            // $messages = [];


            // foreach ($user as $list) {
            //     $to_user_profile = User::find($list->to_user);

            //     $user_list = [
            //         'id' => (string)$list->id,
            //         'user_id' => $list->from_user,
            //         'peer_id' => $list->to_user,
            //         'timestamp' => substr($list->timestamp, 11, 5),
            //         'lat' => $list->lat ?: "",
            //         'long' => $list->long ?: "",
            //         'video_thumbnail' => !empty($list->video_thumbnail) ? url('/video_thumbnail/' . $list->video_thumbnail) : "",
            //         // 'call_type' => $list->call_type ?: "",
            //         'message' => $list->message ?: "",
            //         'audio_string' => $list->audio_string ?: "",
            //         'isplaying' => "0",
            //         'isway' => "0",
            //         'url' => !empty($list->url) ? url('/chat_images/' . $list->url) : "",
            //     ];

            //     if (!empty($list->message) || !empty($list->url) || !empty($list->audio_string)) {
            //         if (!empty($list->message)) {
            //             $user_list['type'] = "text";
            //             $user_list['text'] = $list->message;
            //         } elseif (!empty($list->url)) {
            //             $extension = pathinfo($list->url, PATHINFO_EXTENSION);
            //             $image_ar = ['tif', 'jpg', 'jpeg', 'png'];
            //             $video_ar = ['mp4', 'mkv', 'MKV'];
            //             $gif_ar = ['gif'];
            //             $audio_ar = ['mp3'];

            //             if (in_array($extension, $image_ar)) {
            //                 $user_list['type'] = 'image';
            //             } elseif (in_array($extension, $video_ar)) {
            //                 $user_list['type'] = 'video';
            //             } elseif (in_array($extension, $gif_ar)) {
            //                 $user_list['type'] = 'gif';
            //             } elseif (in_array($extension, $audio_ar)) {
            //                 $user_list['type'] = 'voicemessage';
            //             }
            //         }
            //     } else {
            //         $user_list['type'] = 'location';
            //         $user_list['text'] = '';
            //     }

            //     if (!empty($to_user_profile)) {
            //         $url = explode(':', $to_user_profile->profile_pic);
            //         if ($url[0] == 'https' || $url[0] == 'http') {
            //             $user_list['profile_image'] = $to_user_profile->profile_pic;
            //         } else {
            //             $user_list['username'] = $to_user_profile->username ?? '';
            //             $user_list['profile_image'] = url('/profile_pic/' . $to_user_profile->profile_pic);
            //         }
            //     } else {
            //         $user_list['username'] = "";
            //         $user_list['profile_image'] = '';
            //     }

            //     $messages[] = $user_list;
            // }



            $result['response_code'] = '1';
            $result['message'] = 'Chat List Found';
            $result['message_list'] = SupportchatResouece::collection($user);

            // $event = SupportChatstatus::where('order_number', $request->input('order_number'))->first();

            // $result['chat_status'] = $event ? "1" : "0";

            $event = SupportChatstatus::where('order_number', $request->input('order_number'))->first();

            $status = $event->status;
            $result['chat_status'] = (string)$status ?? "1";

            $result['status'] = 'success';
            return response()->json($result);
        }
    }

    public function support_chat_status(Request $request)
    {
        // Perform validation on the incoming request data
        $validator = Validator::make($request->all(), [
            // 'name' => 'required',
            'user_id' => 'required',
            'peer_id' => 'required',
            'order_number' => 'required',
            'is_status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError("Enter this field", $validator->errors(), 422);
            //     return response()->json([
            //         'errors' => $validator->errors(),
            //     ], 422); // Return a HTTP status code 422 (Unprocessable Entity)
        }

        $admin = User::where('id', $request->user_id)->first();

        if ($admin) {

            $user = $admin->is_admin;

            if ($user = "0") {

                $temp = [
                    "response_code" => "0",
                    "message" => "This is not Access.",
                    "status" => "failure",
                ];

                return response()->json($temp);
            }
        }

        // if (!empty($request->peer_id)) {

        // if (User::where('id', $request->user_id)->exists()) {

        try {

            $event = SupportChatstatus::where('from_user', $request->user_id)->where('to_user', $request->peer_id)->where('order_number', $request->order_number)->first();

            if (!empty($event)) {

                // return $this->sendResponse(new UserResource($user),"Successfully login");
                // return $this->sendRespon(new EventdescResource($event), "Tickets is already closed");

                $temp = [
                    "response_code" => "0",
                    "message" => "Tickets is already closed.",
                    "status" => "failure",
                ];

                return response()->json($temp);
            }

            SupportChatstatus::create([
                'from_user' => $request->user_id,
                'to_user' => $request->peer_id,
                'order_number' => $request->order_number,
                'status' => $request->is_status,
            ]);


            $FcmToken = User::where('id', $request->peer_id)->value('device_token');

            $data = [
                'title' => "Message",
                'message' => "Ticket support notification once Open to closed.",
                'type' => "Support Chat",
                'booking_id' => $request->user_id,
                'order_id' => $request->peer_id,
            ];

            //  dd($data);

            //  $this->sendNotification(new Request($data), $FcmToken);

            if ($FcmToken) {

                $this->sendNotification(new Request($data), $FcmToken);
            } else {

                // \Log::warning("Provider with ID {$request->peer_id} has no valid device token.");
            }


            // return $this->sendResponse(new UserResource(User::where('email', $request->email)->first()), "User registered successfully");
            // return $this->sendResponse("", "User registered");
            // return response()->json([
            //     'message' => 'User registered  ',
            //     // 'access_token' => $accessToken,
            // ]);

            return $this->sendMessage("Ticket Status Close Successfully");
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError("Ticket is not Create", $th->getMessage());
            // return response()->json([
            //     'message' => $th->getMessage(),
            //     // 'access_token' => $accessToken,
            // ]);
            // }
            // } 
        }
    }

    public function search_services(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;
        $text = $request->input('text');

        // if (empty($text)) {
        //     $result["response_code"] = "0";
        //     $result["message"] = "Service Not Found";
        //     $result['users'] = $users;
        //     $result["status"] = "failure";
        //     return response()->json($result);
        // }

        $all_services = Service::where('service_name', 'like', "%$text%")->with('serviceImages')
            ->orderByDesc('id')
            ->get();


        $list_notification_done = [];

        foreach ($all_services as $notification) {
            // Build your response array for each service...
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price ?? "";
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ServiceReview::where('service_id', $notification->id)->count();

            $average_review = ServiceReview::where('service_id', $notification->id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            // $questions_list['is_like'] = "0";

            $questions_list['is_featured'] = (string)$notification->is_features;

            $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $user_like ? "1" : "0";


            $user = User::where('id', $notification->v_id)->first();
            // $questions_list['provider_name'] = $user->firstname ?? "";
            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {
                $questions_list['provider_name'] = "";
                $questions_list['profile_pic'] =  "";
            }

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $questions_list['service_image'] = $imgsa;

            $list_notification_done[] = $questions_list;
        }


        if (!empty($user_id)) {
            $result['response_code'] = "1";
            $result['message'] = "Service List Found";
            $result['all_service_list'] = $list_notification_done;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service List Found";
            $result['all_service_list'] = $list_notification_done;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }


    public function search_products(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;
        $text = $request->input('text');

        // if (empty($text)) {
        //     $result["response_code"] = "0";
        //     $result["message"] = "Product Not Found";
        //     $result['users'] = $users;
        //     $result["status"] = "failure";
        //     return response()->json($result);
        // }

        $all_products = Product::where('product_name', 'like', "%$text%")->with('productImages')
            ->orderByDesc('product_id')
            ->get();


        $list_notification_done = [];

        foreach ($all_products as $notification) {
            $questions_list['product_id'] = $notification->product_id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['vid'] = (string)$notification->vid;
            $questions_list['product_name'] = $notification->product_name;
            $questions_list['product_price'] = $notification->product_price;
            $questions_list['product_discount_price'] = $notification->product_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ProductReview::where('product_id', $notification->product_id)->count();

            $average_review = ProductReview::where('product_id', $notification->product_id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;
            $questions_list['is_featured'] = (string)$notification->is_features;

            $product_like = ProductLike::where('product_id', $notification->product_id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $product_like ? "1" : "0";

            $user = User::where('id', $notification->vid)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                // $questions_list['provider_name'] = $user->firstname ?? "";

                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;

                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $questions_list['provider_name'] = "";

                $questions_list['profile_pic'] =  "";
            }

            // $images = explode("::::", $notification->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['product_image'] = $imgsa;
            $imgsa = [];

            foreach ($notification->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $questions_list['product_image'] = $imgsa;

            $list_notification_done[] = $questions_list;
        }


        if (!empty($user_id)) {
            $result['response_code'] = "1";
            $result['message'] = "Product List Found";
            $result['all_product_list'] = $list_notification_done;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Product List Found";
            $result['all_product_list'] = $list_notification_done;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function filter_products(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;
        $product_price = $request->input('product_price');
        $review = $request->input('review');

        $products = Product::query();

        if ($product_price) {
            $priceRange = explode(',', $product_price);
            $minPrice = (int)$priceRange[0];
            $maxPrice = (int)$priceRange[1];
            $products->whereBetween('product_price', [$minPrice, $maxPrice]);
        }

        if ($review) {
            $productIdsWithReview = ProductReview::where('star_count', $review)
                ->pluck('product_id')
                ->toArray();
            $products->whereIn('product_id', $productIdsWithReview);
        }

        $all_products = $products->with('productImages')->orderByDesc('product_id')->get();

        $list_notification_done = [];

        foreach ($all_products as $notification) {
            $questions_list['product_id'] = $notification->product_id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['vid'] = (string)$notification->vid;
            $questions_list['product_name'] = $notification->product_name;
            $questions_list['product_price'] = $notification->product_price;
            $questions_list['product_discount_price'] = $notification->product_discount_price ?? "";
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ProductReview::where('product_id', $notification->product_id)->count();

            $average_review = ProductReview::where('product_id', $notification->product_id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            $questions_list['is_featured'] = (string)$notification->is_features;

            $product_like = ProductLike::where('product_id', $notification->product_id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $product_like ? "1" : "0";

            $user = User::where('id', $notification->vid)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {
                // $questions_list['provider_name'] = $user->firstname ?? "";
                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
                $questions_list['profile_pic'] = $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {
                $questions_list['provider_name'] = "";
                $questions_list['profile_pic'] = "";
            }

            // $images = explode("::::", $notification->product_image);
            // $imgsa = array();
            // foreach ($images as $image) {
            //     $imgs = asset('/images/product_images/' . $image);
            //     array_push($imgsa, $imgs);
            // }
            // $questions_list['product_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $questions_list['product_image'] = $imgsa;

            $list_notification_done[] = $questions_list;
        }

        if (!empty($user_id)) {
            $result['response_code'] = "1";
            $result['message'] = "Product List Found";
            $result['filter_product_list'] = $list_notification_done;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Product List Found";
            $result['filter_product_list'] = $list_notification_done;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function filter_services2(Request $request)
    {
        $result = [];
        $users = [];

        $user_id = Auth::user()->token()->user_id;


        //  $all_services = Service::where('service_name', 'like', "%$text%")
        //  ->orderByDesc('id')
        //     ->get();


        $service_price = $request->input('service_price');
        $review = $request->input('review');

        $products = Service::query();

        if ($service_price) {
            $priceRange = explode(',', $service_price);
            $minPrice = (int)$priceRange[0];
            $maxPrice = (int)$priceRange[1];
            $products->whereBetween('service_price', [$minPrice, $maxPrice]);
        }

        if ($review) {
            $productIdsWithReview = ServiceReview::where('star_count', $review)
                ->pluck('service_id')
                ->toArray();
            $products->whereIn('id', $productIdsWithReview);
        }

        $all_services = $products->orderByDesc('id')->get();



        $list_notification_done = [];

        foreach ($all_services as $notification) {
            // Build your response array for each service...
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;
            $questions_list['res_id'] = (string)$notification->res_id;
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            $questions_list['avg_review'] = "4.5";
            $questions_list['total_review'] = "200";
            // $questions_list['is_like'] = "0";

            $questions_list['is_featured'] = (string)$notification->is_features;

            $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $user_like ? "1" : "0";


            $user = User::where('id', $notification->v_id)->first();
            // $questions_list['provider_name'] = $user->firstname ?? "";
            $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
            $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : "";

            $images = explode("::::", $notification->service_image);
            $imgs = array();
            $imgsa = array();
            foreach ($images as $key => $image) {


                // $imgs =  asset('assets/images/post/'. $image);

                $imgs = asset('/images/service_images/' . $image);

                array_push($imgsa, $imgs);
            }
            // $user->service_image = $imgsa;

            $questions_list['service_image'] = $imgsa;

            $list_notification_done[] = $questions_list;
        }


        if (!empty($user_id)) {
            $result['response_code'] = "1";
            $result['message'] = "Service List Found";
            $result['all_service_list'] = $list_notification_done;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service List Found";
            $result['all_service_list'] = $list_notification_done;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function filter_services(Request $request)
    {
        $result = [];
        $user_id = Auth::user()->token()->user_id;

        $service_price = $request->input('service_price');
        $review = $request->input('review'); // Assuming this is the minimum average review rating
        $res_id = $request->input('res_id');
        $cat_id = $request->input('cat_id');

        $text = $request->input('text');

        $servicesQuery = Service::query();

        if ($text) {
            $servicesQuery->where('service_name', 'like', "$text%");
        }

        if ($service_price) {
            [$minPrice, $maxPrice] = explode(',', $service_price);
            $servicesQuery->whereBetween('service_price', [(int)$minPrice, (int)$maxPrice]);
        }

        if ($cat_id) {
            if ($cat_id != 'All') {
                $servicesQuery->where('cat_id', $cat_id);
            }
        }

        // if ($res_id) {
        //     // Convert comma-separated res_id to an array
        //     $resIds = explode(',', $res_id);

        //     if (!in_array('All', $resIds)) {
        //         // Handle the comma-separated res_id in the database
        //         foreach ($resIds as $id) {
        //             $servicesQuery->orWhere('res_id', 'like', "%$id%");
        //         }
        //     }
        // }

        if ($res_id) {
            $resIds = explode(',', $res_id);
            if (!in_array('All', $resIds)) {
                $servicesQuery->where(function ($query) use ($resIds) {
                    foreach ($resIds as $id) {
                        $query->orWhere('res_id', 'like', "%$id%");
                    }
                });
            }
        }

        $all_services = $servicesQuery->with('serviceImages')->orderByDesc('id')->get();

        $list_notification_done = [];

        foreach ($all_services as $service) {
            // Calculate the average review and total review count for each service
            $serviceReviews = ServiceReview::where('service_id', $service->id);
            $averageReview = round($serviceReviews->avg('star_count'), 1);
            $totalReview = $serviceReviews->count();

            // Filter by average review if provided
            // if ($review && $averageReview < $review) {
            //     continue;
            // }

            // Filter by average review if provided
            if ($review) {
                // Calculate the range
                $minReview = $review;
                $maxReview = $review + 1;

                // Check if the average review is within the specified range
                if ($averageReview < $minReview || $averageReview >= $maxReview) {
                    continue;
                }
            }

            $serviceData = [
                'id' => $service->id,
                'cat_id' => (string)$service->cat_id,
                'res_id' => (string)$service->res_id,
                'v_id' => (string)$service->v_id,
                'service_name' => $service->service_name,
                'service_price' => $service->service_price,
                'service_discount_price' => $service->service_discount_price ?? "",
                'avg_review' => (string)$averageReview,
                'total_review' => (string)$totalReview,
                'is_featured' => (string)$service->is_features,
                'is_like' => ServiceLike::where('service_id', $service->id)->where('user_id', $user_id)->exists() ? "1" : "0",
            ];

            $user = User::find($service->v_id);
            // $serviceData['provider_name'] = $user->firstname ?? "";

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            $serviceData['provider_name'] = $user->firstname . ' ' . $user->lastname;
            $serviceData['profile_pic'] = $user && $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);

            // $serviceData['service_image'] = array_map(function ($image) {
            //     return asset('/images/service_images/' . $image);
            // }, explode("::::", $service->service_image));

            $imgsa = [];

            foreach ($service->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $serviceData['service_image'] = $imgsa;

            $list_notification_done[] = $serviceData;
        }

        $result['response_code'] = !empty($user_id) ? "1" : "0";
        $result['message'] = "Service List Found";
        $result['all_service_list'] = $list_notification_done;
        $result["status"] = !empty($user_id) ? "success" : "failure";

        return response()->json($result);
    }



    public function user_update_wallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            // 'device_token' => 'required',
        ]);
        if ($validator->fails()) {

            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        $user_id = Auth::user()->token()->user_id;

        $amount = $request->input('amount');
        $payment_method = $request->input('payment_method');

        try {

            // $data = array(
            //     "amount" => $amount,
            // );
            // User::where('id', $user_id)->update($data);

            $v_store = User::where('id', $user_id)->first();


            $v_store->update([
                'wallet_balance' => $v_store->wallet_balance + $request->amount
            ]);



            $data = [
                'user_id' => $user_id,
                'payment_method' => $request->input('payment_method'),
                'amount' => $request->input('amount'),
                'status' => "add",
                'success' => "true",
                'created_at' => now(),
            ];

            $done = DB::table('wallet')->insert($data);


            $temp = [
                "response_code" => "1",
                "message" => "User Amount Update successfully",
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

    public function transition_list2(Request $request)
    {
        try {
            //code...
            // $myId = $request->user()->token()->user_id;
            //  $myId = $request->input('user_id');
            $myId = Auth::user()->token()->user_id;
            $payReq = Wallet::where('user_id', $myId)->orderby('id', 'desc')->get()->transform(function ($tr) {

                $showcurrency =  "$";
                $tr->user_id = (string)$tr->user_id;
                $tr->amount = (string)$showcurrency . $tr->amount;
                $tr->status = (string)$tr->status ?? "";
                $tr->payment_method = (string)$tr->payment_method;
                $tr->success = (string)$tr->success ?? "";
                $tr->req_at = $tr->created_at->format('d F Y');
                $tr->updated_at = $tr->updated_at ?? "";
                $tr->month = $tr->created_at->format('M');
                $tr->date = $tr->created_at->format('d');

                return $tr;
            });


            $v_store = User::where('id', $myId)->first();
            if ($v_store) {
                $available_bal = $v_store->wallet_balance;
            } else {
                $available_bal = 0;
            }

            $temp = [
                "message" => "Withdrawl List Found",
                "success" => "true",
                "available_bal" => (int)$available_bal,
                "data" => $payReq

            ];

            return response()->json($temp);
            // return $this->sendResponse($payReq, "Store details");
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError("SolveThisError", $th->getMessage());
        }
    }

    public function transition_list_old(Request $request)
    {
        try {
            // Getting the user ID
            $myId = Auth::user()->token()->user_id;

            // Fetching and transforming wallet transactions
            $payReq = Wallet::where('user_id', $myId)->orderBy('id', 'desc')->get()->map(function ($tr) {
                $showcurrency = "$";
                return [
                    'user_id' => (string)$tr->user_id,
                    'amount' => (string)$showcurrency . $tr->amount,
                    'status' => (string)$tr->status ?? "",
                    'payment_method' => (string)$tr->payment_method,
                    'success' => (string)$tr->success ?? "",
                    'req_at' => $tr->created_at->format('d F Y'),
                    'updated_at' => $tr->updated_at ?? "",
                    'month' => $tr->created_at->format('M'),
                    'date' => $tr->created_at->format('d')
                ];
            });

            // Grouping transactions by month
            $groupedByMonth = $payReq->groupBy('month');

            // Fetching user's available balance
            $v_store = User::find($myId);
            $available_bal = $v_store ? $v_store->wallet_balance : 0;

            // Preparing the response
            $temp = [
                "message" => "Withdrawl List Found",
                "success" => "true",
                "available_bal" => (int)$available_bal,
                "data" => $groupedByMonth
            ];

            return response()->json($temp);
        } catch (\Throwable $th) {
            return $this->sendError("SolveThisError", $th->getMessage());
        }
    }

    public function transition_list_new(Request $request)
    {
        try {
            // Getting the user ID
            $myId = Auth::user()->token()->user_id;

            // Fetching and transforming wallet transactions
            $payReq = Wallet::where('user_id', $myId)->orderBy('id', 'desc')->get()->map(function ($tr) {
                $showcurrency = "$";
                return [
                    'id' => (string)$tr->id,
                    'user_id' => (string)$tr->user_id,
                    'amount' => (string)$showcurrency . $tr->amount,
                    'status' => (string)$tr->status ?? "",
                    'payment_method' => (string)$tr->payment_method,
                    'success' => (string)$tr->success ?? "",
                    'req_at' => $tr->created_at->format('d F Y'),
                    'updated_at' => $tr->updated_at ?? "",
                    'month' => $tr->created_at->format('M'),
                    'date' => $tr->created_at->format('d')
                ];
            });

            // Grouping transactions by month
            $groupedByMonth = $payReq->groupBy('month');

            // Formatting the grouped data
            $formattedData = [];
            foreach ($groupedByMonth as $month => $transactions) {
                $formattedData[] = [
                    $month => $transactions
                ];
            }

            // Fetching user's available balance
            $v_store = User::find($myId);
            $available_bal = $v_store ? $v_store->wallet_balance : 0;

            // Preparing the response
            $temp = [
                "message" => "Withdrawal List Found",
                "success" => "true",
                "available_bal" => (int)$available_bal,
                "data" => $formattedData
            ];

            return response()->json($temp);
        } catch (\Throwable $th) {
            return $this->sendError("SolveThisError", $th->getMessage());
        }
    }

    public function transition_list(Request $request)
    {
        try {
            // Getting the user ID
            $myId = Auth::user()->token()->user_id;

            // Fetching and transforming wallet transactions
            $payReq = Wallet::where('user_id', $myId)->orderBy('id', 'desc')->get()->map(function ($tr) {
                $showcurrency = "$";
                return [
                    'id' => (string)$tr->id,
                    'user_id' => (string)$tr->user_id,
                    'amount' => (string)$tr->amount,
                    'status' => (string)$tr->status ?? "",
                    'payment_method' => (string)$tr->payment_method,
                    'success' => (string)$tr->success ?? "",
                    'req_at' => $tr->created_at->format('d F Y'),
                    'updated_at' => $tr->updated_at ?? "",
                    'month' => $tr->created_at->format('M'),
                    // 'date' => $tr->created_at->format('d'),
                    'time' => $tr->created_at->format('H:i'),
                    'date' => $tr->created_at,
                ];
            });

            // Grouping transactions by month
            $groupedByMonth = $payReq->groupBy('month');

            // Formatting the grouped data with month and list keys
            $formattedData = [];
            foreach ($groupedByMonth as $month => $transactions) {
                $formattedData[] = [
                    'month' => $month,
                    'list' => $transactions
                ];
            }

            // Fetching user's available balance
            $v_store = User::find($myId);
            $available_bal = $v_store ? $v_store->wallet_balance : 0;

            // Preparing the response
            $temp = [
                "message" => "Withdrawal List Found",
                "success" => "true",
                "available_bal" => (int)$available_bal,
                "data" => $formattedData
            ];

            return response()->json($temp);
        } catch (\Throwable $th) {
            return $this->sendError("SolveThisError", $th->getMessage());
        }
    }


    public function transition_details(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $transition_id = $request->input('transition_id');

        // $notification = Product::where('product_id', $product_id)->first();

        $notification = Wallet::where('id', $transition_id)->first();


        $list_notification = [];

        // foreach ($notifications as $notification) {

        if ($notification) {
            $questions_list['transition_id'] = $notification->id;
            $questions_list['user_id'] = (string)$notification->user_id;
            $questions_list['payment_method'] = (string)$notification->payment_method;
            $questions_list['amount'] = (string)$notification->amount;
            $questions_list['status'] = (string)$notification->status;
            $questions_list['success'] = (string)$notification->success;
            $questions_list['created_at'] = (string)$notification->created_at;



            $list_notification = $questions_list;
        }



        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Wallet Details Found";
            $result['wallet_details'] = $questions_list;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Wallet Details Not Found";
            $result['wallet_details'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }





    public function nearby_services(Request $request)
    {
        $myId = Auth::user()->token()->user_id;
        $lat = $request->lat;
        $long = $request->lon;
        // $distance = "50";

        $items = Service::get();

        $nearby = NearbyDistance::where('id', "1")->first();
        $distance = $nearby->distance;

        foreach ($items as $itm) {
            // Assuming you have a 'distance' field in your items table
            // $distanceMin = (int)substr($distance, 1, strpos($distance, ',') - 1);
            // $distanceMax = (int)substr($distance, strpos($distance, ',') + 1, -1);
            $itm_lat = User::where('id', $itm->v_id)->first();

            //   dd($itm_lat);

            //   $itemlat = $itm->latitude ? $itm->latitude : "23.0714";
            //   $itemlon = $itm->longitude ? $itm->longitude : "72.5168";

            $itemlat = $itm->lat ? $itm->lat : "23.0714";
            $itemlon = $itm->lon ? $itm->lon : "72.5168";

            $userlat = $request->lat ? ($request->lat != 'null' ? $request->lat : 0) : 0;
            $userlon = $request->lon ? ($request->lon != 'null' ? $request->lon : 0) : 0;
            // $request->longitude;

            $earth_radius = 3960.0; // Earth's radius in miles
            $delta_lat = deg2rad($userlat - $itemlat);
            $delta_lon = deg2rad($userlon - $itemlon);
            $sin_lat = sin($delta_lat / 2);
            $sin_lon = sin($delta_lon / 2);
            $a = $sin_lat * $sin_lat + cos(deg2rad($itemlat)) * cos(deg2rad($userlat)) * ($sin_lon * $sin_lon);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $Itemdistance = $earth_radius * $c;

            // if($Itemdistance <= $distance){
            //     $ifarray[] = round($Itemdistance);
            // }else{
            //     $elsearray[] = round($Itemdistance);
            // }

            if ($Itemdistance <= $distance) {
                // $userdata = User::where('id', $itm->id)->first();


                $done = Service::where('id', $itm->id)->with('serviceImages')->first();

                $restaurant = [];
                $restaurant['id'] = $done->id;
                $restaurant['cat_id'] = (string)$done->cat_id;
                $restaurant['res_id'] = (string)$done->res_id;
                $restaurant['v_id'] = (string)$done->v_id;
                $restaurant['service_name'] = $done->service_name;
                $restaurant['service_price'] = $done->service_price;
                $restaurant['service_discount_price'] = $done->service_discount_price ?? "";
                $restaurant['distance'] = round($Itemdistance);
                // $restaurant['avg_review'] = "4.5";
                // $restaurant['total_review'] = "200";

                $total_reviews = ServiceReview::where('service_id', $done->id)->count();

                $average_review = ServiceReview::where('service_id', $done->id)->avg('star_count');

                $restaurant['avg_review'] = (string)number_format($average_review, 1);

                $restaurant['total_review'] = (string)$total_reviews;

                $user = User::where('id', $done->v_id)->first();

                $all_image = DefaultImage::where('people_id', "1")->first();
                $my_image = $all_image->image;
                // $restaurant['provider_name'] = $user->firstname;
                $restaurant['provider_name'] = $user->firstname . ' ' . $user->lastname;
                $restaurant['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);

                // $images = explode("::::", $done->service_image);
                // $imgs = array();
                // $imgsa = array();
                // foreach ($images as $key => $image) {


                //     // $imgs =  asset('assets/images/post/'. $image);

                //     $imgs = asset('/images/service_images/' . $image);

                //     array_push($imgsa, $imgs);
                // }
                // // $user->service_image = $imgsa;

                // $restaurant['service_image'] = $imgsa;

                $imgsa = [];

                foreach ($done->serviceImages as $image) {
                    $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
                }

                $restaurant['service_image'] = $imgsa;




                $user_like = ServiceLike::where('service_id', $done->id)->where('user_id', $myId)->first();
                $restaurant['is_like'] = $user_like ? "1" : "0";

                // $list_notification_done[] = $questions_all_list;

                $filter_array[] = $restaurant;
            }
        }

        if (!empty($filter_array)) {
            $result['response_code'] = "1";
            $result['message'] = "Service List Found";
            $result['all_service_list'] = $filter_array;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service List Not Found";
            $result['all_service_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function nearby_services_new(Request $request)
    {
        $myId = Auth::user()->token()->user_id;
        $lat = floatval($request->lat);
        $long = floatval($request->lon);
        $distance = 50; // 50 KM
        $earth_radius = 6371.0; // KM

        $items = Service::get();
        $filter_array = [];

        foreach ($items as $itm) {
            $itemlat = floatval($itm->latitude ?? "23.0714");
            $itemlon = floatval($itm->longitude ?? "72.5168");

            if (!$lat || !$long) {
                continue;
            }

            // Haversine Formula
            $delta_lat = deg2rad($lat - $itemlat);
            $delta_lon = deg2rad($long - $itemlon);
            $a = sin($delta_lat / 2) * sin($delta_lat / 2) +
                cos(deg2rad($itemlat)) * cos(deg2rad($lat)) *
                sin($delta_lon / 2) * sin($delta_lon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $Itemdistance = $earth_radius * $c;

            if ($Itemdistance <= $distance) {
                $done = Service::find($itm->id);

                $restaurant = [];
                $restaurant['id'] = $done->id;
                $restaurant['service_name'] = $done->service_name;
                $restaurant['service_price'] = $done->service_price;
                $restaurant['service_discount_price'] = $done->service_discount_price ?? "";
                $restaurant['distance'] = round($Itemdistance, 2);

                $total_reviews = ServiceReview::where('service_id', $done->id)->count();
                $average_review = ServiceReview::where('service_id', $done->id)->avg('star_count') ?? 0;
                $restaurant['avg_review'] = number_format($average_review, 1);
                $restaurant['total_review'] = (string) $total_reviews;

                $user = User::find($done->v_id);
                $default_image = DefaultImage::where('people_id', "1")->value('image') ?? 'default.jpg';
                $restaurant['provider_name'] = $user ? $user->firstname . ' ' . $user->lastname : "Unknown";
                $restaurant['profile_pic'] = $user && $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $default_image);

                $images = explode("::::", $done->service_image ?? '');
                $restaurant['service_image'] = array_map(fn($img) => asset('/images/service_images/' . $img), $images);

                $restaurant['is_like'] = ServiceLike::where('service_id', $done->id)->where('user_id', $myId)->exists() ? "1" : "0";

                $filter_array[] = $restaurant;
            }
        }

        return response()->json([
            "response_code" => !empty($filter_array) ? "1" : "0",
            "message" => !empty($filter_array) ? "Service List Found" : "Service List Not Found",
            "all_service_list" => $filter_array,
            "status" => !empty($filter_array) ? "success" : "failure"
        ]);
    }


    public function add_service_review(Request $request)
    {

        $user_id = Auth::user()->id;

        $data = [
            'service_id' => $request->input('service_id'),
            'booking_id' => $request->input('booking_id'),
            'text' => $request->input('text'),
            'user_id' => $user_id,
            'star_count' => $request->input('star_count'),
            'created_at' => now(),
        ];

        $service_id = $request->input('service_id');
        $booking_id = $request->input('booking_id');
        $rating = $request->input('star_count');
        $text = $request->input('text');

        $handyman = BookingOrders::where('user_id', $user_id)->where('id', $booking_id)->first();

        //  $handyman = BookingOrders::where('user_id', $user_id)
        // ->where('service_id', $service_id)
        // ->latest('created_at') // Get the latest entry by 'created_at'
        // ->first();

        // dd($handyman);

        // print_r($handyman);

        if (!$handyman) {
            return response()->json([
                'response_code' => '0',
                'message' => 'No booking found for this service.',
                'status' => 'failure'
            ]);
        }

        $handyman_id = $handyman->work_assign_id;

        $provider_id = $handyman->provider_id;

        $user = User::where('id', $handyman_id)->first();

        $email = $user->email;

        $firstname = $user->firstname;

        $booking_date_all = now();

        $dateTime = new \DateTime($booking_date_all);

        $booking_date = $dateTime->format('d M, Y - h:i A');

        $review_name = User::where('id', $user_id)->first();

        $provider_name = $review_name->firstname;

        // $provider_new = User::where('id', $provider_id)->first();

        // $firstname = $provider_new->firstname;


        $provider = Service::where('id', $service_id)->first();

        $booking_service_name = $provider->service_name;

        $provider_id = $provider->v_id;

        $emailPreference = HandymanEmailReviewReceived::where('get_email', 1)->first();

        if ($emailPreference) {
            // Send email on successful OTP verification
            Mail::to($email)->send(
                new HandymanReviewReceived($email, $booking_id, $provider_name, $booking_date, $firstname, $rating, $text)
            );
        }

        $provider_id = $handyman->provider_id;

        $user = User::where('id', $provider_id)->first();

        $email = $user->email;

        $firstname = $user->firstname;

        $booking_date_all = now();

        $dateTime = new \DateTime($booking_date_all);

        $booking_date = $dateTime->format('d M, Y - h:i A');

        $review_name = User::where('id', $user_id)->first();

        $provider_name = $review_name->firstname;

        // $provider_new = User::where('id', $provider_id)->first();

        // $firstname = $provider_new->firstname;


        $provider = Service::where('id', $service_id)->first();

        $booking_service_name = $provider->service_name;

        $service_name = $provider->service_name;

        $provider_id = $provider->v_id;

        $emailPreference = ProviderEmailReviewReceived::where('get_email', 1)->first();

        if ($emailPreference) {
            // Send email on successful OTP verification
            Mail::to($email)->send(
                new ProviderReviewReceived($email, $provider_name, $booking_date, $firstname, $rating, $text, $service_name, $booking_id)
            );
        }


        HandymanReview::create([

            'handyman_id' => $handyman_id,
            'booking_id' => $request->input('booking_id'),
            'service_id' => $request->input('service_id'),
            'provider_id' => $provider_id,
            'user_id' => $user_id,
            'star_count' => $request->input('star_count'),
            'text' => $request->input('text'),
            'created_at' => now(),
        ]);


        $datas = [
            'service_id' => $request->input('service_id'),
            'booking_id' => $request->input('booking_id'),
            'text' => $request->input('text'),
            'user_id' => $user_id,
            'provider_id' => $provider_id,
            'star_count' => $request->input('star_count'),
            'created_at' => now(),
        ];

        $FcmToken = User::where('id', $provider_id)->value('device_token');

        $FcmToken_done = User::where('id', $handyman_id)->value('device_token');

        $proviver_noti = NotificationsPermissions::where('id', "32")->where('status', "1")->first();

        $username =  User::where('id', $user_id)->first();

        // $firstname = $username->firstname;
        $firstname = $username->firstname . ' ' . $username->lastname;

        $type = "Service";




        // Replace placeholders with actual values
        $message = str_replace(
            ['[[ booking_id ]]', '[[ rating ]]', '[[ booking_service_name ]]'],
            ['#' . $booking_id, $rating, $booking_service_name],
            $proviver_noti->description
        );

        $all_cart_id = $handyman->cart_id;
        $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
        $order_id = $all_order__id->order_id;


        $data = [
            'title' => $proviver_noti->title,
            // 'message' =>  $rating . ' ' . $proviver_noti->description . ' '.  $service_name.'.',
            'message' => $message,
            'type' => $type,
            'booking_id' => $booking_id,
            'order_id' => $order_id,
        ];

        $this->sendNotification(new Request($data), $FcmToken);

        $this->sendNotification(new Request($data), $FcmToken_done);

        $type = "Service";

        $not_all_done_exit = [
            'booking_id' => $booking_id,
            'handyman_id' => $handyman_id,
            'provider_id' => $provider_id,
            'user_id' => $user_id,
            'title' => $proviver_noti->title,
            // 'message' => '$'.$payment_all    . ' ' . $proviver_all_noti->description . ' '.  $service_name,
            'review_noti' => 1,
            'message' => $message,
            'type' => $type,
            'created_at' => now(),
            'requests_status' => "1",
        ];

        $done = DB::table('user_notification')->insert($not_all_done_exit);

        // dd($data);

        //     $not_all = [
        //     'booking_id' => $request->input('booking_id'),
        //     'handyman_id' => $handyman_id,
        //     'provider_id' => $provider_id,
        //     'user_id' => $user_id,
        //     'title' => $proviver_noti->title,
        //     'message' => $rating . ' ' . $proviver_noti->description . ' '.  $service_name.'.',
        //     'type' => "Service",
        //     'created_at' => now(),
        // ];

        // $done = DB::table('user_notification')->insert($not_all);



        if (DB::table('service_review')->insert($datas)) {
            return response()->json([
                'response_code' => '1',
                'message' => 'Service Review Added Success',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'response_code' => '0',
                'message' => 'Database Error',
                'status' => 'failure'
            ]);
        }
    }

    public function add_product_review(Request $request)
    {

        $user_id = Auth::user()->id;
        // $request->validate([
        //     'service_id' => 'required|integer',
        //     'store_id' => 'required|integer',
        //     'service_name' => 'required|string|max:255',
        //     'service_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max file size is 2MB
        //     'v_id' => 'nullable|integer',
        //     'service_price' => 'nullable|numeric',
        //     'service_description' => 'nullable|string',
        //     'price_unit' => 'nullable|string',
        //     'duration' => 'nullable|string',
        // ]);
        $product_id = $request->input('product_id');

        $provider = Product::where('product_id', $product_id)->first();

        $provider_id = $provider->vid;


        $datas = [
            'product_id' => $request->input('product_id'),
            'booking_id' => $request->input('booking_id'),
            'text' => $request->input('text'),
            'user_id' => $user_id,
            'provider_id' => $provider_id,
            'star_count' => $request->input('star_count'),
            'created_at' => now(),
        ];

        $product_id = $request->input('product_id');
        $booking_id = $request->input('booking_id');

        $handyman = BookingOrders::where('user_id', $user_id)->where('id', $booking_id)->first();

        //  $handyman = BookingOrders::where('user_id', $user_id)
        // ->where('service_id', $service_id)
        // ->latest('created_at') // Get the latest entry by 'created_at'
        // ->first();

        // dd($handyman);

        // print_r($handyman);

        if (!$handyman) {
            return response()->json([
                'response_code' => '0',
                'message' => 'No booking found for this product.',
                'status' => 'failure'
            ]);
        }

        $handyman_id = $handyman->work_assign_id;

        $provider = Product::where('product_id', $product_id)->first();

        // $booking_services_name = $provider->product_name;

        $product_name = $provider->product_name;

        $provider_id = $provider->vid;

        $FcmToken = User::where('id', $provider_id)->value('device_token');

        $proviver_noti = NotificationsPermissions::where('id', "33")->where('status', "1")->first();

        $username =  User::where('id', $user_id)->first();

        // $firstname = $username->firstname;
        $firstname = $username->firstname . ' ' . $username->lastname;

        $type = "Product";


        $rating = $request->input('star_count');

        $all_cart_id = $handyman->cart_id;
        $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
        $order_id = $all_order__id->order_id;


        // Replace placeholders with actual values
        $message = str_replace(
            ['[[ booking_id ]]', '[[ rating ]]', '[[ product_name ]]'],
            ['#' . $booking_id, $rating, $product_name],
            $proviver_noti->description
        );


        $data = [
            'title' => $proviver_noti->title,
            // 'message' =>  $rating . ' ' . $proviver_noti->description . ' '.  $service_name.'.',
            'message' => $message,
            'type' => $type,
            'booking_id' => $booking_id,
            'order_id' => $order_id,
        ];

        $this->sendNotification(new Request($data), $FcmToken);

        $type = "Product";

        $not_all_done_exit = [
            'booking_id' => $booking_id,
            'handyman_id' => 0,
            'provider_id' => $provider_id,
            'user_id' => $user_id,
            'title' => $proviver_noti->title,
            'review_noti' => 1,
            'message' => $message,
            'type' => $type,
            'created_at' => now(),
            'requests_status' => "1",
        ];

        $done = DB::table('user_notification')->insert($not_all_done_exit);

        if (DB::table('product_review')->insert($datas)) {
            return response()->json([
                'response_code' => '1',
                'message' => 'Product Review Added Success',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'response_code' => '0',
                'msg' => 'Database Error',
                'status' => 'failure'
            ]);
        }
    }

    public function handyman_review_given(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $convo_list_arr = [];
        $service = HandymanReview::where('handyman_id', $user_id)
            ->orderByDesc('id')
            ->get();

        foreach ($service as $key => $ro) {

            $user_list = [];
            $user_list['id'] = (string)$ro->id;
            $user_list['service_id'] = (string)$ro->service_id;
            $user_list['text'] = $ro->text ?? "";
            $user_list['star_count'] = (string)$ro->star_count;
            $user_list['user_id'] = (string)$ro->user_id;
            $user_list['booking_id'] = (string)$ro->booking_id;
            $user_list['type'] = "service";

            $user_ser = BookingOrders::where('id', $ro->booking_id)->first();
            $all_cart_id = $user_ser->cart_id;
            $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
            $order_id = $all_order__id->order_id;
            $user_list['order_id'] = (string)$order_id;

            $createdDate = Carbon::createFromFormat('Y-m-d H:i:s', $ro->created_at)
                ->format('Y-m-d\TH:i:s.u\Z');

            $user_list['created_time'] = $createdDate;
            $notification = Service::where('id', $ro->service_id)->with('serviceImages')->first();

            $user_list['service_name'] = $notification->service_name ?? "";

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $user_list['service_image'] = $imgsa;



            $user_list['product_id'] = "";
            $user_list['product_name'] = "";
            $user_list['product_image'] = [];

            $user = User::where('id', $ro->user_id)->first();

            $all_image = DefaultImage::where('people_id', "3")->first();
            $my_image = $all_image->image;
            // $restaurant['provider_name'] = $user->firstname;
            $user_list['user_name'] = $user->firstname . ' ' . $user->lastname;
            $user_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);

            $convo_list_arr[] = $user_list;
        }


        // $product = ProductReview::where('user_id', $user_id)
        //     ->orderByDesc('id')
        //     ->get();

        // foreach ($product as $key => $row) {

        //     $product_list = [];
        //     $product_list['id'] = (string)$row->id;
        //     $product_list['product_id'] = (string)$row->product_id;
        //     $product_list['text'] = $row->text ?? "";
        //     $product_list['star_count'] = (string)$row->star_count;
        //     $product_list['type'] = "product";


        //     $createdDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)
        //         ->format('Y-m-d\TH:i:s.u\Z');

        //     $product_list['created_time'] = $createdDate;

        //     $notification_done = Product::where('product_id', $row->product_id)->with('productImages')->first();

        //     $product_list['product_name'] = $notification_done->product_name ?? "";


        //     // $images = explode("::::", $notification_done->product_image);
        //     // $imgs = array();
        //     // $imgsa = array();
        //     // foreach ($images as $key => $image) {


        //     //     // $imgs =  asset('assets/images/post/'. $image);

        //     //     $imgs = asset('/images/product_images/' . $image);

        //     //     array_push($imgsa, $imgs);
        //     // }
        //     // // $user->service_image = $imgsa;

        //     // $product_list['product_image'] = $imgsa;

        //     $imgsa = [];

        //     foreach ($notification_done->productImages as $image) {
        //         $imgsa[] = asset('/images/product_images/' . $image->product_image);
        //     }

        //     $product_list['product_image'] = $imgsa;

        //     $product_list['service_id'] = "";
        //     $product_list['service_name'] = "";
        //     $product_list['service_image'] = [];

        //     $convo_list_arr[] = $product_list;
        // }

        // $chat = array();
        // foreach ($convo_list_arr as $key => $rows) {
        //     $chat[$key] = $rows['created_time'];
        // }
        // array_multisort($chat, SORT_DESC, $convo_list_arr);

        if (!empty($convo_list_arr)) {
            $result['response_code'] = "1";
            $result['message'] = "Handyman Review Found";
            $result['handyman_review'] = $convo_list_arr;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Handyman Review Not Found";
            $result['handyman_review'] = $convo_list_arr;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }


    public function review_given(Request $request)
    {
        // $result = [];
        // $users = [];

        $user_id = Auth::user()->token()->user_id;

        $convo_list_arr = [];
        $service = ServiceReview::where('user_id', $user_id)
            ->orderByDesc('id')
            ->get();

        foreach ($service as $key => $ro) {

            $user_list = [];
            $user_list['id'] = (string)$ro->id;
            $user_list['service_id'] = (string)$ro->service_id;
            $user_list['text'] = $ro->text ?? "";
            $user_list['star_count'] = (string)$ro->star_count;
            $user_list['type'] = "service";

            $createdDate = Carbon::createFromFormat('Y-m-d H:i:s', $ro->created_at)
                ->format('Y-m-d\TH:i:s.u\Z');

            $user_list['created_time'] = $createdDate;
            $notification = Service::where('id', $ro->service_id)->with('serviceImages')->first();

            $user_list['service_name'] = $notification->service_name ?? "";

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }

            // $user_list['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $user_list['service_image'] = $imgsa;

            $user_list['product_id'] = "";
            $user_list['product_name'] = "";
            $user_list['product_image'] = [];

            $convo_list_arr[] = $user_list;
        }


        $product = ProductReview::where('user_id', $user_id)
            ->orderByDesc('id')
            ->get();

        foreach ($product as $key => $row) {

            $product_list = [];
            $product_list['id'] = (string)$row->id;
            $product_list['product_id'] = (string)$row->product_id;
            $product_list['text'] = $row->text ?? "";
            $product_list['star_count'] = (string)$row->star_count;
            $product_list['type'] = "product";


            $createdDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)
                ->format('Y-m-d\TH:i:s.u\Z');

            $product_list['created_time'] = $createdDate;

            $notification_done = Product::where('product_id', $row->product_id)->with('productImages')->first();

            $product_list['product_name'] = $notification_done->product_name ?? "";


            // $images = explode("::::", $notification_done->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $product_list['product_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification_done->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $product_list['product_image'] = $imgsa;

            $product_list['service_id'] = "";
            $product_list['service_name'] = "";
            $product_list['service_image'] = [];

            $convo_list_arr[] = $product_list;
        }

        $chat = array();
        foreach ($convo_list_arr as $key => $rows) {
            $chat[$key] = $rows['created_time'];
        }
        array_multisort($chat, SORT_DESC, $convo_list_arr);

        if (!empty($convo_list_arr)) {
            $result['response_code'] = "1";
            $result['message'] = "Users Found";
            $result['users'] = $convo_list_arr;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Users Not Found";
            $result['users'] = $convo_list_arr;
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function edit_all_review(Request $request)
    {

        $user_id = Auth::user()->token()->user_id;
        $validator = FacadesValidator::make($request->all(), [
            'id' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Enter this field', $validator->errors(), 422);
            //     return response()->json([
            //         'errors' => $validator->errors(),
            //     ], 422); // Return a HTTP status code 422 (Unprocessable Entity)
        }

        try {
            $type = $request->input('type');
            // $otp = $request->input('otp');
            // $where = 'mobile_no="' . $mob_no . '"';

            if ($type == "service") {
                $data = [
                    'id' => $request->id,
                    'service_id' => $request->service_id,
                    'text' => $request->text,
                    'star_count' => $request->star_count,
                ];
                $done = ServiceReview::where('id', $request->id)->where('user_id', $user_id)->update($data);
            } else {

                $data_all = [
                    'id' => $request->id,
                    'product_id' => $request->product_id,
                    'text' => $request->text,
                    'star_count' => $request->star_count,
                ];
                $done = ProductReview::where('id', $request->id)->where('user_id', $user_id)->update($data_all);
            }

            //   return $this->sendResponse(
            //     new EducationResource(Education::where('id', $request->id)->first()),
            //     'User registered successfully'
            //   );
            if ($done) {
                $result['response_code'] = "1";
                $result['message'] = "User Update Review Success";
                // $result['users'] = $convo_list_arr;
                $result["status"] = "success";
            } else {

                $result['response_code'] = "0";
                $result['message'] = "User Not Update Review Success";
                // $result['users'] = $convo_list_arr;
                $result["status"] = "success";
            }
            return response()->json($result);
            // print_r($user_data);
            // echo $user_data['mobile_no'];
            // if (isset($user_data['mobile_no'])) {echo"yes";}else{echo "no";}

            // exit;
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('User not Successfully', $th->getMessage());
            // return response()->json([
            //     'message' => $th->getMessage(),
            //     // 'access_token' => $accessToken,
            // ]);
        }
    }

    public function review_all_delete(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $validator = FacadesValidator::make($request->all(), [
            'id' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Enter this field', $validator->errors(), 422);
            //     return response()->json([
            //         'errors' => $validator->errors(),
            //     ], 422); // Return a HTTP status code 422 (Unprocessable Entity)
        }

        try {
            $type = $request->input('type');
            // $otp = $request->input('otp');
            // $where = 'mobile_no="' . $mob_no . '"';

            if ($type == "service") {

                $done = ServiceReview::where('id', $request->id)->where('user_id', $user_id)->delete();
            } else {


                $done = ProductReview::where('id', $request->id)->where('user_id', $user_id)->delete();
            }

            //   return $this->sendResponse(
            //     new EducationResource(Education::where('id', $request->id)->first()),
            //     'User registered successfully'
            //   );
            if ($done) {
                $result['response_code'] = "1";
                $result['message'] = "User Delete Review Success";
                // $result['users'] = $convo_list_arr;
                $result["status"] = "success";
            } else {

                $result['response_code'] = "0";
                $result['message'] = "User Not Delete Review Success";
                // $result['users'] = $convo_list_arr;
                $result["status"] = "success";
            }
            return response()->json($result);
            // print_r($user_data);
            // echo $user_data['mobile_no'];
            // if (isset($user_data['mobile_no'])) {echo"yes";}else{echo "no";}

            // exit;
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('User not Successfully', $th->getMessage());
            // return response()->json([
            //     'message' => $th->getMessage(),
            //     // 'access_token' => $accessToken,
            // ]);
        }
    }

    public function referal_code_check(Request $request)
    {

        // $user_id = Auth::user()->id;

        $user_refer_code = $request->input('user_refer_code');

        $use_refer_user = User::where('refer_code', $request->user_refer_code)->first();

        if (!empty($use_refer_user)) {
            return response()->json([
                'response_code' => '1',
                'message' => 'Referal Code Verified',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'response_code' => '0',
                'message' => 'Referal Code Not Verified',
                'status' => 'failure'
            ]);
        }
    }

    public function service_all_review(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $service_id = $request->input('service_id');


        $notification = Service::where('id', $service_id)->with('serviceImages')->first();



        // $list_notification = [];

        if ($notification) {
            $questions_list['id'] = $notification->id;
            $questions_list['cat_id'] = (string)$notification->cat_id;

            $category = Category::where('id', $notification->cat_id)->first();
            $questions_list['cat_name'] = $category->c_name ?? "";
            $questions_list['res_id'] = (string)$notification->res_id;

            $subcategory = SubCategory::where('id', $notification->res_id)->first();
            $questions_list['sub_cat_name'] = $subcategory->c_name ?? "";
            $questions_list['v_id'] = (string)$notification->v_id;
            $questions_list['service_name'] = $notification->service_name;
            $questions_list['service_price'] = $notification->service_price;
            $questions_list['service_discount_price'] = $notification->service_discount_price ?? "";
            $questions_list['service_description'] = $notification->service_description;
            $questions_list['duration'] = $notification->duration;
            $questions_list['day'] = $notification->day ?? "";
            $questions_list['start_time'] = $notification->start_time ?? "";
            $questions_list['end_time'] = $notification->end_time ?? "";
            // $questions_list['start_time'] = ($notification->start_time ?? '') . ($notification->start_time_period ?? '');
            // $questions_list['end_time'] = ($notification->end_time ?? '') . ($notification->end_time_period ?? '');
            // $questions_list['avg_review'] = "4.5";
            // $questions_list['total_review'] = "200";

            $total_reviews = ServiceReview::where('service_id', $service_id)->count();

            $average_review = ServiceReview::where('service_id', $service_id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;

            $questions_list['is_featured'] = $notification->is_features;

            // $questions_list['is_like'] = "0";

            $user_like = ServiceLike::where('service_id', $notification->id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $user_like ? "1" : "0";

            $questions_list['provider_id'] = (string)$notification->v_id;

            $provider_search = CartItemsModel::where('user_id', $user_id)->where('checked', '0')->where('service_id', $service_id)->first();

            $questions_list['is_cart'] = $provider_search ? "1" : "0";

            // $questions_list['my_id'] = $user_id;

            $service = Service::where('v_id', $notification->v_id)->count();

            $product = Product::where('vid', $notification->v_id)->count();

            $user = User::where('id', $notification->v_id)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;
            // $questions_list['provider_name'] = $user->firstname ?? "";
            $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
            $questions_list['email'] = $user->email ?? "";
            $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            $questions_list['provider_address'] = $user->location ?? "";

            $questions_list['provider_review'] = "3.0";
            $questions_list['provider_total_review'] = "218";
            $questions_list['total_service'] = $service;
            $questions_list['total_product'] = $product;
            $questions_list['total_jod_done'] = "6";

            // $images = explode("::::", $notification->service_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/service_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['service_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->serviceImages as $image) {
                $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
            }

            $questions_list['service_image'] = $imgsa;

            $list_notification = $questions_list;
        }



        $all_reviews = ServiceReview::where('service_id', $service_id)
            ->orderByDesc('id')
            ->get();


        $list_review_done = [];

        foreach ($all_reviews as $review_done) {
            $review_all_list['review_id'] = $review_done->id;
            $review_all_list['user_id'] = (string)$review_done->user_id;
            $review_all_list['service_id'] = (string)$review_done->service_id;
            $review_all_list['text'] = $review_done->text;
            $review_all_list['star_count'] = $review_done->star_count;
            // $review_all_list['created_at'] = $review_done->created_at ?? "";

            $created_at = $review_done->created_at;
            $date = ($created_at);
            $formatted_date = $date->format('M j, Y');

            $review_all_list['created_at'] = $formatted_date ?? "";

            $user = User::where('id', $review_done->user_id)->first();

            $all_image = DefaultImage::where('people_id', "3")->first();
            $my_image = $all_image->image;

            $review_all_list['username'] = $user->firstname . " " . $user->lastname ?? "";
            $review_all_list['user_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            $list_review_done[] = $review_all_list;
        }


        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Service All Review Found";
            $result['service_details'] = $list_notification;
            // $result['addons_products'] = $list_notification_done;
            $result['review_list'] = $list_review_done;
            // $result['other_services'] = $list_service_done;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Service Review Not Found";
            $result['service_details'] = [];
            // $result['addons_products'] = [];
            $result['review_list'] = [];
            // $result['other_services'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function product_all_review(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $product_id = $request->input('product_id');

        $notification = Product::where('product_id', $product_id)->with('productImages')->first();


        $list_notification = [];

        // foreach ($notifications as $notification) {

        if ($notification) {
            $questions_list['product_id'] = $notification->product_id;
            $questions_list['cat_id'] = (string)$notification->cat_id;

            $category = ProductCategory::where('id', $notification->cat_id)->first();
            $questions_list['cat_name'] = $category->c_name ?? "";
            $questions_list['vid'] = (string)$notification->vid;
            $questions_list['product_name'] = $notification->product_name;
            $questions_list['product_price'] = $notification->product_price;
            $questions_list['product_discount_price'] = $notification->product_discount_price ?? "";
            $questions_list['product_description'] = $notification->product_description ?? "";

            $total_reviews = ProductReview::where('product_id', $product_id)->count();

            $average_review = ProductReview::where('product_id', $product_id)->avg('star_count');

            $questions_list['avg_review'] = (string)number_format($average_review, 1);

            $questions_list['total_review'] = (string)$total_reviews;
            $questions_list['provider_total_review'] = "218";
            $questions_list['provider_review'] = "3.0";
            $questions_list['is_featured'] = $notification->is_features;

            $product_like = ProductLike::where('product_id', $notification->product_id)->where('user_id', $user_id)->first();
            $questions_list['is_like'] = $product_like ? "1" : "0";

            $provider_search = CartItemsModel::where('user_id', $user_id)->where('checked', '0')->where('product_id', $product_id)->first();

            $questions_list['is_cart'] = $provider_search ? "1" : "0";

            $service = Service::where('v_id', $notification->vid)->count();

            $product = Product::where('vid', $notification->vid)->count();



            $user = User::where('id', $notification->vid)->first();

            $all_image = DefaultImage::where('people_id', "1")->first();
            $my_image = $all_image->image;

            if ($user) {

                $questions_list['email'] = $user->email ?? "";
                // $questions_list['provider_name'] = $user->firstname ?? "";
                $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
                $questions_list['provider_address'] = $user->location ?? "";

                $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
            } else {

                $questions_list['provider_name'] = "";

                $questions_list['profile_pic'] =  "";
            }

            $questions_list['total_service'] = $service;
            $questions_list['total_product'] = $product;
            $questions_list['total_jod_done'] = "6";

            // $images = explode("::::", $notification->product_image);
            // $imgs = array();
            // $imgsa = array();
            // foreach ($images as $key => $image) {


            //     // $imgs =  asset('assets/images/post/'. $image);

            //     $imgs = asset('/images/product_images/' . $image);

            //     array_push($imgsa, $imgs);
            // }
            // // $user->service_image = $imgsa;

            // $questions_list['product_image'] = $imgsa;

            $imgsa = [];

            foreach ($notification->productImages as $image) {
                $imgsa[] = asset('/images/product_images/' . $image->product_image);
            }

            $questions_list['product_image'] = $imgsa;


            // $list_notification[] = $questions_list;

            $list_notification = $questions_list;
        }


        $all_reviews = ProductReview::where('product_id', $product_id)
            ->orderByDesc('id')
            ->get();


        $list_review_done = [];

        foreach ($all_reviews as $review_done) {
            $review_all_list['review_id'] = $review_done->id;
            $review_all_list['user_id'] = (string)$review_done->user_id;
            $review_all_list['product_id'] = (string)$review_done->product_id;
            $review_all_list['text'] = $review_done->text;
            $review_all_list['star_count'] = $review_done->star_count;

            $created_at = $review_done->created_at;
            $date = ($created_at);
            $formatted_date = $date->format('M j, Y');

            $review_all_list['created_at'] = $formatted_date ?? "";

            $user = User::where('id', $review_done->user_id)->first();

            $all_image = DefaultImage::where('people_id', "3")->first();
            $my_image = $all_image->image;

            // $review_all_list['username'] = $user->firstname ?? "";
            $review_all_list['username'] = $user->firstname . " " . $user->lastname ?? "";
            $review_all_list['user_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);;
            $list_review_done[] = $review_all_list;
        }


        if (!empty($list_notification)) {
            $result['response_code'] = "1";
            $result['message'] = "Product All Review Found";
            $result['product_details'] = $list_notification;
            // $result['other_products'] = $list_notification_done;
            $result['review_list'] = $list_review_done;
            $result["status"] = "success";
        } else {
            $result["response_code"] = "0";
            $result["message"] = "Product Review Not Found";
            $result['product_details'] = [];
            // $result['other_products'] = [];
            $result['review_list'] = [];
            $result["status"] = "failure";
        }

        return response()->json($result);
    }

    public function sendCustomNotification(Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id', // Ensure each user ID exists in the users table
        ]);

        $title = $request->input('title');
        $message = $request->input('message');
        $data = ['key' => 'value']; // Custom data
        $userIds = $request->input('user_ids'); // Array of user IDs

        $report = $this->sendNotification($title, $message, $data, $userIds);

        if ($report) {
            return response()->json([
                'success' => $report->successes()->count(),
                'failures' => $report->failures()->count()
            ]);
        }

        return response()->json(['message' => 'No device tokens found for the provided user IDs.'], 400);
    }

    public function all_booking_status_history(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;
        $booking_id = $request->input('booking_id');

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        // $notifications = user_notification::where('booking_id', $booking_id)->orderBy('not_id', 'ASC')->get();

        $notifications = user_notification::where('booking_id', $booking_id)->where('user_id', $user_id)->where('review_noti', 0)->orderBy('not_id', 'ASC')->get();

        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['not_id'] = $notification->not_id;
            $questions_list['handyman_id'] = $notification->handyman_id ?? "";
            $questions_list['provider_id'] = $notification->provider_id ?? "";
            $questions_list['type'] = $notification->type;
            $questions_list['booking_id'] = $notification->booking_id ?? "";
            $questions_list['title'] = $notification->title;
            $questions_list['user_id'] = $notification->user_id ?? "";
            $questions_list['message'] = $notification->message;
            $questions_list['date'] = $notification->created_at;
            $questions_list['last_status'] = $notification->requests_status;

            if ($notification->title == "Update Booking") {

                $questions_list['color_code'] = "FFD428";
            }
            if ($notification->title == "Assigned Booking") {
                $questions_list['color_code'] = "0DA31C";
            }

            if ($notification->title == "Cancel Booking") {
                $questions_list['color_code'] = "FF2828";
            }

            if ($notification->title == "Hold Booking") {

                $questions_list['color_code'] = "FFD428";
            }

            if ($notification->title == "Refund Amount") {

                $questions_list['color_code'] = "FFD428";
            }

            if ($notification->title == "Product In Progress") {

                $questions_list['color_code'] = "FFD428";
            }

            if ($notification->title == "Product Delivered") {

                $questions_list['color_code'] = "FFD428";
            }

            if ($notification->title == "Order Placed") {

                $questions_list['color_code'] = "0DA31C";
            }

            if ($notification->title == "Order Received") {

                $questions_list['color_code'] = "0DA31C";
            }

            $questions_list['color_code'] = "0DA31C";

            $list_notification[] = $questions_list;
        }

        if ($list_notification) {
            $result = [
                "response_code" => "1",
                "message" => "All Booking Status List Done",
                "all_status" => $list_notification,
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Not Booking Status List Found",
                "all_status" => $list_notification,
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }


    public function handyman_booking_status_history(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;
        $booking_id = $request->input('booking_id');

        if (!$user_id) {
            $result = [
                "response_code" => "0",
                "message" => "Enter Data",
                "status" => "failure",
            ];
            return response()->json($result);
        }

        $notifications = user_notification::where('booking_id', $booking_id)->where('handyman_id', $user_id)->where('review_noti', 0)->orderBy('not_id', 'ASC')->get();

        $list_notification = [];

        foreach ($notifications as $notification) {
            $questions_list['not_id'] = $notification->not_id;
            $questions_list['handyman_id'] = $notification->handyman_id ?? "";
            $questions_list['provider_id'] = $notification->provider_id ?? "";
            $questions_list['type'] = $notification->type;
            $questions_list['booking_id'] = $notification->booking_id ?? "";
            $questions_list['title'] = $notification->title;
            $questions_list['user_id'] = $notification->user_id ?? "";
            $questions_list['message'] = $notification->message;
            $questions_list['date'] = $notification->created_at;
            $questions_list['last_status'] = $notification->requests_status;

            if ($notification->title == "Update Booking") {

                $questions_list['color_code'] = "FFD428";
            }
            if ($notification->title == "Assigned Booking") {
                $questions_list['color_code'] = "0DA31C";
            }

            if ($notification->title == "Cancel Booking") {
                $questions_list['color_code'] = "FF2828";
            }

            if ($notification->title == "Hold Booking") {

                $questions_list['color_code'] = "FFD428";
            }

            $questions_list['color_code'] = "0DA31C";

            $list_notification[] = $questions_list;
        }

        if ($list_notification) {
            $result = [
                "response_code" => "1",
                "message" => "All Booking Status List Done",
                "all_status" => $list_notification,
                "status" => "success",
            ];
        } else {
            $result = [
                "response_code" => "0",
                "message" => "Not Booking Status List Found",
                "all_status" => $list_notification,
                "status" => "failure",
            ];
        }

        return response()->json($result);
    }

    public function user_cancel_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required',
            'booking_id' => 'required',
        ]);
        if ($validator->fails()) {

            return $this->sendError("Enter this field", $validator->errors(), 422);
        }

        $user_id = Auth::user()->token()->user_id;

        $booking_id = $request->input('booking_id');

        try {

            $booking_status = BookingOrders::where('id', $booking_id)->first();

            $status = $booking_status->handyman_status;

            if ($status == "0") {
                $data = array(
                    "handyman_status" => "12",
                );
                BookingOrders::where('id', $booking_id)->where('user_id', $user_id)->update($data);


                $cart_value_done = BookingOrders::where('id', $booking_id)->first();
                // $payment_all = $payment->payment;

                if ($cart_value_done->service_id !== null) {

                    $cart_id = $cart_value_done->cart_id;
                    $order_value = CartItemsModel::where('cart_id', $cart_id)->first();

                    $order_id = $order_value->order_id;

                    $service_value = OrdersModel::where('id', $order_id)->first();

                    $payment_all = $service_value->service_subtotal;
                } else {
                    // $payment_all = $cart_value_done->payment;

                    $payment = $cart_value_done->payment;
                    $cart_id = $cart_value_done->cart_id;

                    $order_value = CartItemsModel::where('cart_id', $cart_id)->first();

                    $order_id = $order_value->order_id;

                    $service_value = OrdersModel::where('id', $order_id)->first();

                    if ($service_value->coupon_type == "Product") {

                        $product_percentage = $service_value->coupon_percentage;

                        if ($product_percentage) {

                            $payment_all_done = ($payment * $product_percentage / 100);

                            $payment_all = $payment - $payment_all_done;

                        } else {

                            $payment_all = $payment;
                        }
                    } else {
                        $payment_all = $payment;
                    }

                    // $order_value_ask = CartItemsModel::where('order_id', $order_id)->wherenotnull('product_id', "")->count();

                    // $payment_all = $product_subtotal / $order_value_ask;
                }

                $user = User::where('id', $user_id)->first();



                if ($user) {

                    $user->update([
                        'wallet_balance' => $user->wallet_balance + $payment_all,
                    ]);
                }

                if ($user) {

                    $all_type = BookingOrders::where('id', $booking_id)->first();

                    $data_old = [
                        'user_id' => $user_id,
                        'payment_method' => "Refund",
                        'amount' => $payment_all,
                        'status' => "Refund",
                        'success' => "true",
                        'created_at' => now(),
                    ];

                    $done = DB::table('wallet')->insert($data_old);

                    $cart_value_done = BookingOrders::where('id', $booking_id)->first();

                    $provider_id_done = $cart_value_done->provider_id;

                    $all_cart_id = $cart_value_done->cart_id;
                    $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                    $order_id = $all_order__id->order_id;


                    $service = $cart_value_done->service_id;



                    if ($service) {

                        $name  = Service::where('id', $service)->first();
                        $service_name = $name->service_name;
                        $type = "Service";
                    }

                    $product = $all_type->product_id;

                    if ($product) {
                        $name  = Product::where('product_id', $product)->first();
                        $service_name = $name->product_name;
                        $type = "Product";
                    }


                    $emailPreference = ProviderEmailAssignHandyman::where('get_email', 1)->first();

                    // $booking_date_all = now();
                    $booking_date_all = $cart_value_done->created_at;

                    $user_all_done =  User::where('id', $user_id)->first();
                    //  $email = $user_all_done->email;
                    $user_name = $user_all_done->firstname;

                    $provider_all_done =  User::where('id', $provider_id_done)->first();
                    $email = $provider_all_done->email;
                    $firstname = $provider_all_done->firstname;

                    $dateTime = new \DateTime($booking_date_all);

                    // Format the date and time
                    $booking_date = $dateTime->format('d M, Y - h:i A');

                    if ($emailPreference) {
                        // Send email on successful OTP verification
                        Mail::to($email)->send(
                            new ProviderOrderCancelled($email, $booking_id, $user_name, $booking_date, $firstname)
                        );
                    }



                    $FcmToken = User::where('id', $provider_id_done)->value('device_token');

                    $proviver_noti = NotificationsPermissions::where('id', "5")->where('status', "1")->first();

                    $username =  User::where('id', $user_id)->first();

                    // $firstname = $username->firstname;
                    $user_name = $username->firstname . ' ' . $username->lastname;

                    $message = str_replace(
                        ['[[ booking_id ]]', '[[ user_name ]]'],
                        ['#' . $booking_id, $user_name],
                        $proviver_noti->description
                    );

                    // $type = "Service";


                    $data = [
                        'title' => $proviver_noti->title,
                        // 'message' => '#'.$booking_id . ' ' . $proviver_noti->description . ' '.  $firstname,
                        'message' => $message,
                        'type' => $type,
                        'booking_id' => $booking_id,
                        'order_id' => $order_id,
                    ];

                    if ($FcmToken) {

                        $this->sendNotification(new Request($data), $FcmToken);
                    } else {
                        // Handle the case where FcmToken is not available
                        // return $this->sendError("Notification not sent", "Device token is missing or invalid.");

                        // \Log::warning("Provider with ID {$provider_id_done} has no valid device token.");
                    }




                    $not_all_done = [
                        'booking_id' => $request->input('booking_id'),
                        'handyman_id' => 0,
                        'provider_id' => $provider_id_done,
                        'user_id' => 0,
                        'title' => $proviver_noti->title,
                        // 'message' => '#'.$booking_id . ' ' . $proviver_noti->description,
                        'message' => $message,
                        'type' => $type,
                        'created_at' => now(),
                        'requests_status' => "0",
                    ];

                    $done = DB::table('user_notification')->insert($not_all_done);

                    $FcmToken = User::where('id', $user_id)->value('device_token');

                    $proviver_noti = NotificationsPermissions::where('id', "34")->where('status', "1")->first();

                    $username =  User::where('id', $user_id)->first();

                    $all_type = BookingOrders::where('id', $booking_id)->first();

                    $all_cart_id = $all_type->cart_id;
                    $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
                    $order_id = $all_order__id->order_id;

                    $service = $all_type->service_id;





                    if ($service) {

                        $name  = Service::where('id', $service)->first();
                        $service_name = $name->service_name;
                        $type = "Service";
                    }

                    $product = $all_type->product_id;

                    if ($product) {
                        $name  = Product::where('product_id', $product)->first();
                        $service_name = $name->product_name;
                        $type = "Product";
                    }

                    $cart_value_done = BookingOrders::where('id', $booking_id)->first();

                    if ($cart_value_done->service_id !== null) {

                        $cart_id = $cart_value_done->cart_id;
                        $order_value = CartItemsModel::where('cart_id', $cart_id)->first();

                        $order_id = $order_value->order_id;

                        $service_value = OrdersModel::where('id', $order_id)->first();

                        $amount = $service_value->service_subtotal;
                    } else {
                        // $payment_all = $cart_value_done->payment;

                        $payment = $cart_value_done->payment;
                        $cart_id = $cart_value_done->cart_id;

                        $order_value = CartItemsModel::where('cart_id', $cart_id)->first();

                        $order_id = $order_value->order_id;

                        $service_value = OrdersModel::where('id', $order_id)->first();

                        // $product_percentage = $service_value->coupon_percentage;

                        // $amount = ($payment * $product_percentage / 100);

                        if ($service_value->coupon_type == "Product") {

                            $product_percentage = $service_value->coupon_percentage;

                            // $payment_all = ($payment * $product_percentage / 100);

                            if ($product_percentage) {

                                $amount = ($payment * $product_percentage / 100);
                            } else {

                                $amount = $payment;
                            }
                        } else {

                            $amount = $payment;
                        }

                        // $order_value_ask = CartItemsModel::where('order_id', $order_id)->wherenotnull('product_id', "")->count();

                        // $payment_all = $product_subtotal / $order_value_ask;
                    }

                    // $payment_all = $amount;

                    // $firstname = $username->firstname;
                    $firstname = $username->firstname . ' ' . $username->lastname;

                    $currency_done = SiteSetup::where('id', "1")->first();

                    $currency = $currency_done->default_currency;


                    $user_all_done =  User::where('id', $user_id)->first();
                    $email = $user_all_done->email;
                    $firstname = $user_all_done->firstname;

                    $emailPreference = UserRefundbyProvider::where('get_email', 1)->first();

                    $provider_all_done =  User::where('id', $user_id)->first();
                    $provider_name = $provider_all_done->firstname;

                    $dateTime = new \DateTime($booking_date_all);

                    // Format the date and time
                    $date = $dateTime->format('d M, Y - h:i A');

                    if ($emailPreference) {
                        // Send email on successful OTP verification
                        Mail::to($email)->send(
                            new UserRefundbyallProvider($email, $firstname, $booking_id, $service_name, $currency, $amount, $date)
                        );
                    }

                    $message = str_replace(
                        ['[[ booking_id ]]', '[[ service_name ]]', '[[ amount ]]', '[[ currency ]]'],
                        ['#' . $booking_id, $service_name, $amount, $currency],
                        $proviver_noti->description
                    );




                    $data = [
                        'title' => $proviver_noti->title,
                        // 'message' => '$'.$payment_all    . ' ' . $proviver_noti->description . ' '.  $service_name,
                        'message' => $message,
                        'type' => $type,
                        'booking_id' => $booking_id,
                        'order_id' => $order_id,
                    ];

                    //  $this->sendNotification(new Request($data), $FcmToken);

                    if ($FcmToken) {

                        $this->sendNotification(new Request($data), $FcmToken);
                    } else {
                        // Handle the case where FcmToken is not available
                        // return $this->sendError("Notification not sent", "Device token is missing or invalid.");

                        // \Log::warning("Provider with ID {$provider_id_done} has no valid device token.");
                    }


                    $not_all_done = [
                        'booking_id' => $request->input('booking_id'),
                        'handyman_id' => 0,
                        'provider_id' => 0,
                        'user_id' => $user_id,
                        'title' => $proviver_noti->title,
                        // 'message' => '$'.$payment_all    . ' ' . $proviver_noti->description . ' '.  $service_name,
                        'message' => $message,
                        'type' => $type,
                        'created_at' => now(),
                        'requests_status' => "1",
                    ];

                    $done = DB::table('user_notification')->insert($not_all_done);
                }




                $temp = [
                    "response_code" => "1",
                    "message" => "User Cancel Order Successfully",
                    "status" => "success"
                    // "unread_count" => $approve,
                ];

                return response()->json($temp);
            } else {

                $temp = [
                    "response_code" => "1",
                    "message" => "User is Not Cancel Order",
                    "status" => "success"
                    // "unread_count" => $approve,
                ];

                return response()->json($temp);
            }

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

    public function all_payment_gateway_key(Request $request)
    {

        $canceledBookings = [];
        $category = PaymentGatewayKey::get();

        foreach ($category as $category_done) {

            $result["text"] = (string)$category_done->text;


            $result["public_key"] = (string)$category_done->public_key;

            $result["secret_key"] = (string)$category_done->secret_key;

            $result["mode"] = (string)$category_done->mode;

            $result["country_code"] = (string)$category_done->country_code ?? "";

            $result["currency_code"] = (string)$category_done->currency_code ?? "";

            $canceledBookings[] = $result;
        }

        return $this->sendResponse($canceledBookings, "Payment Gateway Key Done");
    }

    public function all_login_status(Request $request)
    {

        // $canceledBookings = [];
        // $category = UserLoginStatus::get();

        // foreach($category as $category_done){

        // $result["text"] = (string)$category_done->text;

        // $result["status"] = (string)$category_done->status;

        //  $canceledBookings[] = $result;

        // }

        // return $this->sendResponse($canceledBookings, "User Login Status Successfull");

        $twilio = UserLoginStatus::where('id', "1")->first();
        $google = UserLoginStatus::where('id', "2")->first();
        $apple = UserLoginStatus::where('id', "3")->first();
        $email = UserLoginStatus::where('id', "4")->first();

        $temp = [
            "response_code" => "1",
            "message" => "User Login Status Successfully",
            "status" => "success",
            "twilio" => (string)$twilio->status,
            "apple" => (string)$apple->status,
            "google" => (string)$google->status,
            "email" => "0",
        ];

        return response()->json($temp);
    }

    public function all_role(Request $request)
    {

        $twilio = PeopoleRole::get();


        $temp = [
            "response_code" => "1",
            "message" => "All Role List Found",
            "status" => "success",
            "role_list" => $twilio,
        ];

        return response()->json($temp);
    }

    public function provider_handyman_login_status(Request $request)
    {

        $twilio = UserLoginStatus::where('id', "1")->first();
        $google = UserLoginStatus::where('id', "2")->first();
        $apple = UserLoginStatus::where('id', "3")->first();
        $email = UserLoginStatus::where('id', "7")->first();

        $temp = [
            "response_code" => "1",
            "message" => "User Login Status Successfully",
            "status" => "success",
            "twilio" => (string)$twilio->handyman_status,
            "apple" => (string)$apple->handyman_status,
            "google" => (string)$google->handyman_status,
            "email" => (string)$email->handyman_status,
        ];

        return response()->json($temp);
    }

    public function get_currency_and_colour(Request $request)
    {

        $default_currency = SiteSetup::where('id', "1")->first();

        $temp = [
            "response_code" => "1",
            "message" => "Default Currency And Default Colour Successfully Done",
            "status" => "success",
            "default_currency" => (string)$default_currency->default_currency,
            "default_currency_name" => (string)$default_currency->default_currency_name,
            "color_code" => (string)$default_currency->color_code,
            "app_name" => (string)$default_currency->name,
        ];

        return response()->json($temp);
    }

    public function get_privacy_policy(Request $request)
    {

        $canceledBookings = [];
        $category = PrivacyPolicy::first();
        $terms = TermsCondition::first();
        $about = About::first();

        // foreach ($category as $category_done) {

        //     $result["text"] = (string)$category_done->text;

        //     $canceledBookings[] = $result;
        // }

        // return $this->sendResponse($canceledBookings, "Payment Gateway Key Done");

        $temp = [
            "response_code" => "1",
            "message" => "Privacy Policy Done",
            "status" => "success",
            "privacy_policy" => $category ? $category->text : "",
            "terms" => $terms ? $terms->text : "",
            "about" => $about ? $about->text : "",
           
        ];

        return response()->json($temp);
    }
}
