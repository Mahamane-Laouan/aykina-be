<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ReelResource;
use App\Http\Resources\ServiceRes;
use App\Http\Resources\ProductRes;
use App\Http\Resources\TagResource;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Models\BookingOrders;
use App\Models\CartItems;
use App\Models\Review;
use App\Models\Service;
use App\Models\Product;
use App\Models\CartItemsModel;
use App\Models\Profile_blocklist;
use App\Models\Comment_report;
use App\Models\OrdersModel;
use App\Models\ServiceProof;
use App\Models\ServiceReview;
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
use Carbon\Carbon;
use App\Models\ProductReview;
use App\Models\UserAddressModel;
use App\Models\Faq;
use App\Models\ProviderHistory;
use App\Models\ProviderReqModel;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\Bankdetails;
use App\Models\ProviderBankdetails;
use App\Models\Commissions;
use App\Models\NotificationsPermissions;
use App\Models\user_notification;
use App\Models\HandymanReview;
use App\Models\BookingProviderHistory;
use App\Models\AddonProduct;
use App\Models\BookingOrdersStatus;
use App\Models\BookingHandymanHistory;
use App\Models\HandymanHistory;
use App\Mail\UserProductInProgress;
use App\Models\UserEmailProductInProgress;
use App\Models\UserEmailBookingAccepted;
use App\Mail\UserBookingAccepted;
use App\Models\UserEmailProductDelivered;
use App\Mail\UserProductDelivered;
use App\Models\UserEmailBookingCancelled;
use App\Mail\UserBookingCancelled;
use App\Models\HandymanEmailAssignforOrder;
use App\Mail\HandymanAssignforOrder;
use App\Models\ProviderEmailOrderDelivered;
use App\Mail\ProviderOrderDelivered;
use App\Models\ProviderEmailAssignHandyman;
use App\Mail\ProviderAssignHandyman;
use App\Models\ProviderEmailPaymentRequestSent;
use App\Mail\ProviderPaymentRequestSent;
use App\Models\DefaultImage;
use App\Models\SiteSetup;
use App\Models\HandymanEmailBookingAccepted;
use App\Mail\HandymanPaymentRequestAccepted;
use App\Models\HandymanEmailBookingRejected;
use App\Mail\HandymanPaymentRequestCancelled;
use App\Models\UserRefundbyProvider;
use App\Mail\UserRefundbyallProvider;
use App\Models\ServiceImages;
use App\Models\ProductImages;
use App\Models\ServiceLike;


class ProviderController extends BaseController
{


  public function booking_list_provider(Request $request)
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

  public function home_provider_by_services(Request $request)
  {
    $result = [];
    $users = [];

    $user_id = Auth::user()->token()->user_id;


    $users = BookingOrders::where('provider_id', $user_id)
      ->where('service_id', '!=', "")
      ->orderByDesc('id')
      ->get();

    foreach ($users as $user) {

      $date = date('d D Y', strtotime($user->created_at));

      $time = date('h:i', strtotime($user->created_at));

      $user->payment_method = $user->payment_method ?? "";
      $user->date = $date;
      $user->time = $time;
      $user->product_id = "";

      $services_all = Service::where('id', $user->service_id)->with('serviceImages')->first();

      $user->service_name = $services_all->service_name;
      $user->service_price = $services_all->service_price;

      // $images = explode("::::", $services_all->service_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/service_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // $user->service_image = $imgsa;

      $imgsa = [];

      foreach ($services_all->serviceImages as $image) {
        $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
      }

      $user->service_image = $imgsa;

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
        $user->profile_pic = url('/images/user/' . $my_image);
      }
    }
    $users_all_count = Review::where('send_user_review_id', $user_id)->count();

    // $users_online = User::where('id', $user_id)->first();

    // $online = $users_online->is_online;

    $handyman_list = User::where('provider_id', $user_id)->get();

    $user_done = array();

    foreach ($handyman_list as $user) {

      $user_list['handyman_id'] = $user->id;
      $user_list['firstname'] = $user->firstname ?? "";
      $user_list['lastname'] = $user->lastname ?? "";
      $user_list['is_online'] = $user->is_online ?? "";

      $all_image = DefaultImage::where('people_id', "3")->first();
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





    if (!empty($users)) {
      $result['response_code'] = "1";
      $result['message'] = "Users Found";
      $result['booking_list'] = $users;
      $result['handyman_list'] = $user_done;
      // $result['is_online'] = $online;
      $result['today_earning'] = "400";
      $result['total_job_done'] = "40";
      $result['total_ratings'] = "4.6";
      $result['total_earned'] = "150";
      $result['total_members_rating'] = $users_all_count;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "Users Not Found";
      $result['booking_list'] = [];
      $result['is_online'] = "";
      $result['today_earning'] = "";
      $result['total_job_done'] = "";
      $result['total_ratings'] = "";
      $result['total_earned'] = "";
      $result['total_members_rating'] = 0;
      $result["status"] = "failure";
    }

    return response()->json($result);
  }

  public function home_provider_by_products(Request $request)
  {
    $result = [];
    $users = [];

    $user_id = Auth::user()->token()->user_id;


    $users = BookingOrders::where('provider_id', $user_id)
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

      $services_all = Product::where('product_id', $user->product_id)->with('productImages')->first();

      $user->product_name = $services_all->product_name;
      $user->product_price = $services_all->product_price;

      // $images = explode("::::", $services_all->product_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/product_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // $user->product_image = $imgsa;

      $imgsa = [];

      foreach ($services_all->productImages as $image) {
        $imgsa[] = asset('/images/product_images/' . $image->product_image);
      }

      $user->product_image = $imgsa;

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
    $users_all_count = Review::where('send_user_review_id', $user_id)->count();

    // $users_online = User::where('id', $user_id)->first();

    // $online = $users_online->is_online;

    $handyman_list = User::where('provider_id', $user_id)->get();

    $user_done = array();

    foreach ($handyman_list as $user) {

      $user_list['handyman_id'] = $user->id;
      $user_list['firstname'] = $user->firstname ?? "";
      $user_list['lastname'] = $user->lastname ?? "";
      $user_list['is_online'] = $user->is_online ?? "";


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





    if (!empty($users)) {
      $result['response_code'] = "1";
      $result['message'] = "Users Found";
      $result['users'] = $users;
      $result['handyman_list'] = $user_done;
      // $result['is_online'] = $online;
      $result['today_earning'] = "400";
      $result['total_job_done'] = "40";
      $result['total_ratings'] = "4.6";
      $result['total_earned'] = "150";
      $result['total_members_rating'] = $users_all_count;
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
      $result["status"] = "failure";
    }

    return response()->json($result);
  }

  public function booking_filter_by_provider(Request $request)
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

        $restaurant['firstname'] = $users_all->firstname . ' ' . $users_all->lastname;

        $all_image = DefaultImage::where('people_id', "3")->first();
        $my_image = $all_image->image;

        if (!empty($users_all->profile_pic)) {
          $url = explode(":", $users_all->profile_pic);

          if ($url[0] == "https" || $url[0] == "http") {
            $restaurant['profile_pic'] = $users_all->profile_pic;
          } else {
            $restaurant['profile_pic'] =  url('/images/user/' . $users_all->profile_pic);
          }
        } else {
          $restaurant['profile_pic'] = url('/images/user/' . $my_image);
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

  public function booking_details3(Request $request)
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
  public function booking_details_by_provider(Request $request)
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
        'cat_image' => "",
        'payment' => $bookingOrder->payment ?? "",
        'location' => $bookingOrder->location ?? "",
        'booking_status' => $bookingOrder->booking_status ?? "",
        'payment_method' => $bookingOrder->payment_method ?? "",
        'user_id' => $bookingOrder->user_id ?? "",
        'on_status' => $bookingOrder->on_status ?? "",
        'work_assign_id' => $bookingOrder->work_assign_id ?? "",
        'date' => date('d D Y', strtotime($bookingOrder->created_at)),
        'time' => date('h:i', strtotime($bookingOrder->created_at)),
      ];

      $user = User::find($bookingOrder->user_id);

      $all_image = DefaultImage::where('people_id', "1")->first();
      $my_image = $all_image->image;

      if ($user) {
        $restaurant['firstname'] = $user->firstname . ' ' . $user->lastname;
        $restaurant['email'] = $user->email ?? "";
        $restaurant['profile_pic'] = $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
      } else {
        $restaurant['firstname'] = "";
        $restaurant['email'] = "";
        $restaurant['profile_pic'] = "";
      }

      $cart_items = CartItems::where('order_id', $booking_id)->first();

      if ($cart_items) {
        $restaurant['price'] = $cart_items->price ?? "";
        $restaurant['coupon'] = $cart_items->coupon ?? "";
        $restaurant['tax'] = $cart_items->tax ?? "";
        $restaurant['sub_total'] =  $cart_items->price;
        $restaurant['total'] =  $cart_items->price;
        $restaurant['quantity'] = $cart_items->quantity ?? "";
      } else {
        $restaurant['price'] = $cart_items->price;
        $restaurant['coupon'] = $cart_items->coupon ?? "";
        $restaurant['tax'] = $cart_items->tax ?? "";
        $restaurant['sub_total'] =  $cart_items->price;
        $restaurant['total'] =  $cart_items->price;
        $restaurant['quantity'] = $cart_items->quantity ?? "";
      }

      $review_list = Review::where('cat_id', $bookingOrder->cat_name)->get();

      foreach ($review_list as $key => $value) {
      }

      foreach ($review_list as $row) {
        $res = [];
        $res['id'] = (string)$row->id;
        $res['user_id'] = $row->user_id ?  $row->user_id : "";
        $res['text'] = $row->text  ?  $row->text : "";
        $res['star_count'] = $row->star_count ?  $row->star_count : "";
        $res['cat_id'] = $row->cat_id ?  $row->cat_id : "";

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

      $response = [
        "response_code" => "1",
        "message" => "Booking List Found",
        "status" => "success",
        'booking' => $restaurant,
        'review' => $array ?? [],
      ];

      return response()->json($response, 200);
    } catch (\Throwable $th) {
      return $this->sendError("Booking List not Found", $th->getMessage());
    }
  }

  public function add_service_by_provider(Request $request)
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

    // if (request()->hasFile('service_image')) {
    //   $files = request()->file('service_image');

    //   foreach ($files as $file) {
    //     $validator = Validator::make(['image' => $file], [
    //       'image' => 'required|mimes:gif,jpg,png,jpeg',
    //     ]);

    //     if ($validator->fails()) {
    //       $temp["response_code"] = "0";
    //       $temp["message"] = $validator->errors()->first();
    //       $temp["status"] = "failure";
    //       return response()->json($temp);
    //     }

    //     $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    //     // $filePath = 'assets/images/posts';

    //     $file->move(public_path('/images/service_images'), $fileName);

    //     // Move the uploaded file to the desired location
    //     // $file->move($filePath, $fileName);

    //     array_push($res_image, $fileName);
    //   }
    // }

    if ($request->hasFile('service_image')) {
      $files = $request->file('service_image');

      foreach ($files as $file) {
        $validator = Validator::make(['image' => $file], [
          'image' => 'required|mimes:gif,jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
          return response()->json([
            "response_code" => "0",
            "message" => $validator->errors()->first(),
            "status" => "failure"
          ]);
        }

        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('/images/service_images'), $fileName);
        $res_image[] = $fileName;
      }
    }

    $user = User::where('id', $user_id)->first();

    $data = [
      'cat_id' => $request->input('cat_id'),
      'res_id' => $request->input('sub_cat_id'),
      'v_id' => $user_id,
      'service_name' => $request->input('service_name'),
      'service_price' => $request->input('service_price'),
      'service_description' => $request->input('service_description'),
      // 'price_unit' => $request->input('price_unit'),
      'duration' => $request->input('duration'),
      'service_image' => implode('::::', $res_image),
      // 'day' => $request->input('day'),
      // 'start_time' => $request->input('start_time'),
      // 'end_time' => $request->input('end_time'),
      'service_discount_price' => $request->input('service_discount_price'),
      'is_features' => $request->input('is_features'),
      'status' => $request->input('status'),
      // 'start_time_period' => $request->input('start_time_period'),
      // 'end_time_period' => $request->input('end_time_period'),
      // 'lat' => $user->latitude ? $user->latitude : "23.0714",
      // 'lon' => $user->longitude ? $user->longitude : "72.5168",

      'lat' => $request->input('lat') ?? "23.0714",
      'lon' => $request->input('lon') ?? "72.5168",
      'address' => $request->input('address'),
      // 'created_date' => now()->timestamp,
    ];

    $product_ids = explode(',', $request->input('product_id'));

    $service_id = DB::table('services')->insertGetId($data);

    if (!empty($res_image)) {
      foreach ($res_image as $image) {
        DB::table('service_images')->insert([
          'service_id' => $service_id,
          'service_images' => $image,
        ]);
      }
    }

    foreach ($product_ids as $product_id) {
      if (!empty($product_id)) {
        $data_all = [
          'service_id' => $service_id,
          'product_id' => $product_id,
          'vid' => $user_id,
        ];

        if (!DB::table('addon_product')->insert($data_all)) {
          return response()->json([
            'response_code' => '0',
            'msg' => 'Database Error',
            'status' => 'failure'
          ]);
        }
      }
    }

    // if (DB::table('services')->insert($data)) {
    //   return response()->json([
    //     'response_code' => '1',
    //     'message' => 'Service Added Success',
    //     'status' => 'success'
    //   ]);
    // } else {
    //   return response()->json([
    //     'response_code' => '0',
    //     'msg' => 'Database Error',
    //     'status' => 'failure'
    //   ]);
    // }
    return response()->json([
      'response_code' => '1',
      'message' => 'Service Added Success',
      'status' => 'success'
    ]);
  }

  public function edit_service_by_provider(Request $request)
  {

    try {
      //code...

      $service_id = $request->input('service_id');
      $provider_id = Auth::user()->token()->user_id;
      // $user = User::find($user_id);
      $addon_id = $request->input('addon_id');
      $user = Service::where('id', $service_id)->where('v_id', $provider_id)->first();


      // $user = User::where('id', $request->input('user_id'))->first();
      if (!$user) {
        $response = [
          'status' => 'failed',
          'data' => 'Service is not found',
        ];
        return response()->json($response);
      }

      $updates = [
        'cat_id' => $request->input('cat_id', $user->cat_id),
        'res_id' => $request->input('sub_cat_id', $user->res_id),
        'service_name' => $request->input('service_name', $user->service_name),
        'service_description' => $request->input('service_description', $user->service_description),
        // 'price_unit' => $request->input('price_unit', $user->price_unit),
        'duration' => $request->input('duration', $user->duration),
        // 'day' => $request->input('day', $user->day),
        // 'start_time' => $request->input('start_time', $user->start_time),
        // 'end_time' => $request->input('end_time', $user->end_time),
        'service_price' => $request->input('service_price', $user->service_price),
        'service_discount_price' => $request->input('service_discount_price', $user->service_discount_price),
        'is_features' => $request->input('is_features', $user->is_features),
        'status' => $request->input('status', $user->status),
        // 'start_time_period' => $request->input('start_time_period', $user->start_time_period),
        // 'end_time_period' => $request->input('end_time_period', $user->end_time_period),
        'lat' => $request->input('lat', $user->lat),
        'lon' => $request->input('lon', $user->lon),
        'address' => $request->input('address', $user->address),
      ];

      if ($request->hasFile('service_image')) {
        $files = $request->file('service_image');
        $allowed_exts = ['gif', 'jpg', 'png', 'jpeg'];
        $res_image = [];

        foreach ($files as $file) {
          $extension = $file->getClientOriginalExtension();
          if (!in_array($extension, $allowed_exts)) {
            return response()->json([
              'response_code' => '0',
              'message' => 'Invalid image type for file: ' . $file->getClientOriginalName(),
              'status' => 'failure',
            ]);
          }

          $fileName = uniqid() . '.' . $extension;
          $file->move(public_path('/images/service_images'), $fileName);
          $res_image[] = $fileName;
        }

        // Naye images ko product_images table me insert karna
        foreach ($res_image as $image) {
          DB::table('service_images')->insert([
            'service_id' => $service_id,
            'service_images' => $image,
          ]);
        }
      }


      $user->update($updates);

      $product_ids = explode(',', $request->input('product_id'));

      // if ($addon_id) {

      //   $addpro = AddonProduct::where('id', $addon_id)->where('product_id', $product_id)->where('vid', $provider_id)->first();


      //   $update_addon = [
      //     'id' => $request->input('addon_id', $addpro->id),
      //     'product_id' => $request->input('product_id', $addpro->product_id),
      //     'service_id' => $request->input('service_id', $addpro->service_id),
      //   ];

      //   $addpro->update($update_addon);
      // }
      if ($product_ids) {

        AddonProduct::where('service_id', $service_id)
          ->whereNotIn('product_id', $product_ids)
          ->delete();

        foreach ($product_ids as $product_id) {
          if (!empty($product_id)) {
            // Check if the product already exists for the service
            $existing_product = AddonProduct::where('service_id', $service_id)
              ->where('product_id', $product_id)
              ->first();

            if (!$existing_product) {
              // Prepare the data for the new entry
              $data = [
                'service_id' => $service_id,
                'product_id' => $product_id,
                'vid' => $provider_id,
              ];

              // Insert the new product entry
              if (!DB::table('addon_product')->insert($data)) {
                return response()->json([
                  'response_code' => '0',
                  'msg' => 'Database Error',
                  'status' => 'failure'
                ]);
              }
            }
          }
        }
      }




      // return $this->sendResponse(new UserResource($user), "User Details");
      $response = [
        'status' => 'success',
        'data' => new ServiceRes($user),
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

  public function edit_service_image(Request $request)
  {
    $provider_id = Auth::user()->token()->user_id;
    $service_id = $request->service_id;
    $service_image_id = $request->service_image_id;

    // $user = TicketType::where('user_id', $user_id)
    //   ->where('id', $ticket_type_id)
    //   ->first();

    // $data = [
    //   'type' => $request->input('type', $user->type),
    //   'price' => $request->input('price', $user->price),
    //   'quantity' => $request->input('quantity', $user->quantity),
    // ];

    if ($request->hasFile('service_image')) {
      $file = $request->file('service_image');
      $image_exts = ['tif', 'jpg', 'jpeg', 'gif', 'png'];
      $extension = $file->getClientOriginalExtension();
      if (!in_array($extension, $image_exts)) {
        $response = [
          'status' => 'failure',
          'message' => 'Image Type Error',
        ];
        return response()->json($response);
      }
      $fileName = uniqid() . '.' . $extension;
      // $file->move(public_path('profile_pics/'), $fileName);
      $file->move(public_path('/images/service_images'), $fileName);
      $data['service_images'] = $fileName;
      // File::delete(public_path('profile_pics/') . $user->profile_pic);
    }

    $datas = ServiceImages::where('id', $service_image_id)->update($data);
    return response([
      'success' => true,
      'message' => 'Service Image updated successfully ...!',
      // 'data' => $datas,
    ]);
  }

  public function old_service_image_delete(Request $request)
  {
    $provider_id = Auth::user()->token()->user_id;

    $service_id = $request->input('service_id');
    $service_image_id = $request->input('service_image_id');
    // $user = Event::find($request->input('event_id'));

    $user = ServiceImages::where('id', $service_image_id)->delete();

    if ($user) {
      // $user->delete();

      return response()->json(['success' => true, 'message' => 'Service Image deleted successfully']);
    } else {
      return response()->json(['success' => false, 'message' => 'Service Image already deleted']);
    }
  }

  public function service_image_delete(Request $request)
  {
    $provider_id = Auth::user()->token()->user_id;
    $service_id = $request->input('service_id');
    $service_image_ids = $request->input('service_image_id'); // Expecting comma-separated values

    if (!$service_image_ids) {
      return response()->json(['success' => false, 'message' => 'No service images selected']);
    }

    // Convert comma-separated IDs into an array
    $imageIdsArray = explode(',', $service_image_ids);

    // Find and delete images
    $deletedImages = ServiceImages::whereIn('id', $imageIdsArray)->delete();

    if ($deletedImages) {
      return response()->json(['success' => true, 'message' => 'Service Images deleted successfully']);
    } else {
      return response()->json(['success' => false, 'message' => 'Service Images not found or already deleted']);
    }
  }



  public function get_all_category()
  {
    $categories = DB::table('categories')->select('id', 'c_name', 'img')->get();

    if ($categories->isNotEmpty()) {
      foreach ($categories as $category) {
        // $category->icon = url('uploads/') . '/' . $category->icon;
        $category->img = url('/images/category_images/') . '/' . $category->img;
        $service = Service::where('cat_id', $category->id)->count();

        $category->count = $service;
      }

      $result = [
        'status' => 1,
        'msg' => 'Categories Found',
        'categories' => $categories,
      ];
    } else {
      $result = [
        'status' => 0,
        'msg' => 'No categories found',
        'categories' => [],
      ];
    }

    return response()->json($result);
  }

  public function get_service_by_provider(Request $request)
  {
    $user_id = Auth::user()->token()->user_id;


    $notifications = Service::where('v_id', $user_id)
      ->where('is_features', '=', "1")
      ->where('is_delete', '=', "0")
      ->with('serviceImages')
      ->orderByDesc('id')
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
      $questions_list['is_features'] = $notification->is_features;
      // $questions_list['avg_review'] = "4.5";
      // $questions_list['total_review'] = "200";

      $total_reviews = ServiceReview::where('service_id', $notification->id)->count();

      $average_review = ServiceReview::where('service_id', $notification->id)->avg('star_count');

      $questions_list['avg_review'] = (string)number_format($average_review, 1);

      $questions_list['total_review'] = (string)$total_reviews;


      $user = User::where('id', $notification->v_id)->first();

      $all_image = DefaultImage::where('people_id', "1")->first();
      $my_image = $all_image->image;

      $questions_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
      // $questions_list['provider_name'] = $user->firstname;
      $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);;
      $questions_list['provider_image'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);

      // $images = explode("::::", $notification->service_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/service_images/' . $image);

      //   array_push($imgsa, $imgs);
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

    // $users_online = User::where('id', $user_id)->first();

    // $online = $users_online->is_online;

    $all_services = Service::where('v_id', $user_id)
      ->where('is_delete', '=', "0")
      ->with('serviceImages')
      ->orderByDesc('id')
      ->get();


    $list_notification_done = [];

    foreach ($all_services as $done) {
      $questions_all_list['id'] = $done->id;
      $questions_all_list['cat_id'] = (string)$done->cat_id;
      $questions_all_list['res_id'] = (string)$done->res_id;
      $questions_all_list['v_id'] = (string)$done->v_id;
      $questions_all_list['service_name'] = $done->service_name;
      $questions_all_list['service_price'] = $done->service_price;
      $questions_all_list['service_discount_price'] = $done->service_discount_price ?? "";
      $questions_all_list['is_features'] = $done->is_features;
      // $questions_all_list['avg_review'] = "4.5";
      // $questions_all_list['total_review'] = "200";

      $total_reviews = ServiceReview::where('service_id', $done->id)->count();

      $average_review = ServiceReview::where('service_id', $done->id)->avg('star_count');

      $questions_all_list['avg_review'] = (string)number_format($average_review, 1);

      $questions_all_list['total_review'] = (string)$total_reviews;


      $user = User::where('id', $done->v_id)->first();

      $all_image = DefaultImage::where('people_id', "1")->first();
      $my_image = $all_image->image;

      $questions_all_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
      // $questions_all_list['provider_name'] = $user->firstname;
      $questions_all_list['profile_pic'] =  $user->profile_pic ? url('images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
      $questions_all_list['provider_image'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);

      // $images = explode("::::", $done->service_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/service_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // // $user->service_image = $imgsa;

      // $questions_all_list['service_image'] = $imgsa;

      $imgsa = [];

      foreach ($done->serviceImages as $image) {
        $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
      }

      $questions_all_list['service_image'] = $imgsa;

      $list_notification_done[] = $questions_all_list;
    }






    if (!empty($user_id)) {
      $result['response_code'] = "1";
      $result['message'] = "Service List Found";
      $result['featured_service_list'] = $list_notification;
      $result['all_service_list'] = $list_notification_done;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "Service List Not Found";
      $result['featured_service_list'] = [];
      $result['all_service_list'] = [];
      $result["status"] = "failure";
    }

    return response()->json($result);
  }


  public function get_all_service_by_category_provider(Request $request)
  {
    $user_id = Auth::user()->token()->user_id;

    $cat_id = $request->input('cat_id');
    // $sub_cat_id = $request->input('sub_cat_id');

    // $sub_cat_ids = explode(',', $request->input('sub_cat_id')); // Convert "1,2" to ["1", "2"]
    $sub_cat_ids = $request->input('sub_cat_id') ? explode(',', $request->input('sub_cat_id')) : [];



    if ($sub_cat_ids) {

      // $notifications = Service::where('cat_id', $cat_id)->where('res_id', $sub_cat_id)->where('is_delete', '=', "0")->where('v_id', $user_id)->with('serviceImages')->orderByDesc('id')
      //     ->get();
      // $notifications = Service::where('cat_id', $cat_id)
      //   ->whereRaw("FIND_IN_SET(?, res_id)", [$sub_cat_id])
      //   ->where('is_delete', '=', "0")
      //   ->where('v_id', $user_id)
      //   ->with('serviceImages')
      //   ->orderByDesc('id')
      //   ->get();

      $notifications = Service::where('cat_id', $cat_id)
        ->where(function ($query) use ($sub_cat_ids) {
          foreach ($sub_cat_ids as $sub_cat_id) {
            $query->orWhereRaw("FIND_IN_SET(?, res_id)", [$sub_cat_id]);
          }
        })
        ->where('is_delete', '=', "0")
        ->where('v_id', Auth::id())
        ->with('serviceImages')
        ->orderByDesc('id')
        ->get();
    } else {
      $notifications = Service::where('cat_id', $cat_id)->where('is_delete', '=', "0")->where('v_id', $user_id)->with('serviceImages')->orderByDesc('id')
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

  public function get_all_service_sub_category_old()
  {
    $categories = DB::table('sub_categories')->select('id', 'c_name as sub_cat_name', 'img')->get();

    if ($categories->isNotEmpty()) {
      foreach ($categories as $category) {
        // $category->icon = url('uploads/') . '/' . $category->icon;
        $category->img = url('/images/category_images/') . '/' . $category->img;

        // $category->sub_cat_name = $category->c_name;
      }


      $result = [
        'status' => 1,
        'msg' => 'Sub Categories Found',
        'sub_categories' => $categories,
      ];
    } else {
      $result = [
        'status' => 0,
        'msg' => 'No Sub Categories found',
        'sub_categories' => [],
      ];
    }

    return response()->json($result);
  }


  public function get_all_service_sub_category(Request $request)
  {

    $cat_id = $request->input('cat_id');
    $categories = DB::table('sub_categories')->select('id', 'c_name as sub_cat_name', 'img')->where('cat_id', $cat_id)->get();

    if ($categories->isNotEmpty()) {
      foreach ($categories as $category) {
        // $category->icon = url('uploads/') . '/' . $category->icon;
        $category->img = url('/images/category_images/') . '/' . $category->img;

        // $category->sub_cat_name = $category->c_name;
      }


      $result = [
        'status' => 1,
        'msg' => 'Sub Categories Found',
        'sub_categories' => $categories,
      ];
    } else {
      $result = [
        'status' => 0,
        'msg' => 'No Sub Categories found',
        'sub_categories' => [],
      ];
    }

    return response()->json($result);
  }

  public function all_subcategory_by_category(Request $request)
  {

    $cat_id = $request->input('cat_id');
    $categories = DB::table('sub_categories')->select('id', 'c_name as sub_cat_name', 'img')->where('cat_id', $cat_id)->get();

    if ($categories->isNotEmpty()) {
      foreach ($categories as $category) {
        // $category->icon = url('uploads/') . '/' . $category->icon;
        $category->img = $category->img ? url('/images/subcategory_icon/') . '/' . $category->img : "";

        // $category->sub_cat_name = $category->c_name;
      }


      $result = [
        'status' => 1,
        'msg' => 'Sub Categories Found',
        'sub_categories' => $categories,
      ];
    } else {
      $result = [
        'status' => 0,
        'msg' => 'No Sub Categories found',
        'sub_categories' => [],
      ];
    }

    return response()->json($result);
  }


  public function add_product_by_provider_old(Request $request)
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

    if (request()->hasFile('product_image')) {
      $files = request()->file('product_image');

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

        $file->move(public_path('/images/product_images'), $fileName);

        // Move the uploaded file to the desired location
        // $file->move($filePath, $fileName);

        array_push($res_image, $fileName);
      }
    }

    $data = [
      'cat_id' => $request->input('cat_id'),
      'vid' => $user_id,
      'product_name' => $request->input('product_name'),
      'product_price' => $request->input('product_price'),
      'product_description' => $request->input('product_description'),
      'product_image' => implode('::::', $res_image),
      'product_discount_price' => $request->input('product_discount_price'),
      'is_features' => $request->input('is_features'),
      'status' => $request->input('status'),
      // 'created_date' => now()->timestamp,
    ];


    if (DB::table('products')->insert($data)) {
      return response()->json([
        'response_code' => '1',
        'message' => 'Product Added Success',
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

  public function add_product_by_provider(Request $request)
  {
    $user_id = Auth::user()->id;

    $res_image = array();

    if (request()->hasFile('product_image')) {
      $files = request()->file('product_image');

      foreach ($files as $file) {
        $validator = Validator::make(['image' => $file], [
          'image' => 'required|mimes:gif,jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'response_code' => '0',
            'message' => $validator->errors()->first(),
            'status' => 'failure'
          ]);
        }

        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('/images/product_images'), $fileName);
        array_push($res_image, $fileName);
      }
    }

    $service_ids = explode(',', $request->input('service_id'));

    $data_service = [
      'cat_id' => $request->input('cat_id'),
      'vid' => $user_id,
      'service_id' => $request->input('service_id'),
      'product_name' => $request->input('product_name'),
      'product_price' => $request->input('product_price'),
      'product_description' => $request->input('product_description'),
      'product_image' => implode('::::', $res_image),
      'product_discount_price' => $request->input('product_discount_price'),
      'is_features' => $request->input('is_features'),
      'status' => $request->input('status'),
      'created_at' => now(),
    ];

    // $all = DB::table('products')->insert($data_service);

    $product_id = DB::table('products')->insertGetId($data_service);

    if (!empty($res_image)) {
      foreach ($res_image as $image) {
        DB::table('product_images')->insert([
          'product_id' => $product_id,
          'product_image' => $image,
        ]);
      }
    }

    foreach ($service_ids as $service_id) {
      if (!empty($service_id)) {
        $data = [
          'service_id' => $service_id,
          'product_id' => $product_id,
          'vid' => $user_id,
        ];

        if (!DB::table('addon_product')->insert($data)) {
          return response()->json([
            'response_code' => '0',
            'msg' => 'Database Error',
            'status' => 'failure'
          ]);
        }
      }
    }

    return response()->json([
      'response_code' => '1',
      'message' => 'Product Added Successfully',
      'status' => 'success'
    ]);
  }


  public function edit_product_by_provider(Request $request)
  {

    try {
      //code...

      $product_id = $request->input('product_id');
      $addon_id = $request->input('addon_id');
      $provider_id = Auth::user()->token()->user_id;
      // $user = User::find($user_id);
      $user = Product::where('product_id', $product_id)->where('vid', $provider_id)->first();


      // $user = User::where('id', $request->input('user_id'))->first();
      if (!$user) {
        $response = [
          'status' => 'failed',
          'data' => 'Product is not found',
        ];
        return response()->json($response);
      }

      $updates = [
        'cat_id' => $request->input('cat_id', $user->cat_id),
        'product_name' => $request->input('product_name', $user->product_name),
        'product_price' => $request->input('product_price', $user->product_price),
        'product_description' => $request->input('product_description', $user->product_description),
        'product_discount_price' => $request->input('product_discount_price', $user->product_discount_price),
        'is_features' => $request->input('is_features', $user->is_features),
        'status' => $request->input('status', $user->status),
      ];


      // if ($request->hasFile('product_image')) {
      //   $files = $request->file('product_image');
      //   $allowed_exts = ['gif', 'jpg', 'png', 'jpeg'];
      //   $res_image = [];

      //   foreach ($files as $file) {
      //     $extension = $file->getClientOriginalExtension();
      //     if (!in_array($extension, $allowed_exts)) {
      //       return response()->json([
      //         'response_code' => '0',
      //         'message' => 'Invalid image type for file: ' . $file->getClientOriginalName(),
      //         'status' => 'failure',
      //       ]);
      //     }

      //     $fileName = uniqid() . '.' . $extension;
      //     $file->move(public_path('/images/product_images'), $fileName);
      //     $res_image[] = $fileName;
      //   }

      //   // Concatenate file names with '::::'
      //   $product_image = implode('::::', $res_image);

      //   // Add to updates array
      //   $updates['product_image'] = $product_image;
      // }

      if ($request->hasFile('product_image')) {
        $files = $request->file('product_image');
        $allowed_exts = ['gif', 'jpg', 'png', 'jpeg'];
        $res_image = [];

        foreach ($files as $file) {
          $extension = $file->getClientOriginalExtension();
          if (!in_array($extension, $allowed_exts)) {
            return response()->json([
              'response_code' => '0',
              'message' => 'Invalid image type for file: ' . $file->getClientOriginalName(),
              'status' => 'failure',
            ]);
          }

          $fileName = uniqid() . '.' . $extension;
          $file->move(public_path('/images/product_images'), $fileName);
          $res_image[] = $fileName;
        }

        // Naye images ko product_images table me insert karna
        foreach ($res_image as $image) {
          DB::table('product_images')->insert([
            'product_id' => $product_id,
            'product_image' => $image,
          ]);
        }
      }

      $user->update($updates);

      if ($addon_id) {

        $addpro = AddonProduct::where('id', $addon_id)->where('product_id', $product_id)->where('vid', $provider_id)->first();


        $update_addon = [
          'id' => $request->input('addon_id', $addpro->id),
          'product_id' => $request->input('product_id', $addpro->product_id),
          'service_id' => $request->input('service_id', $addpro->service_id),
        ];

        $addpro->update($update_addon);
      }



      // return $this->sendResponse(new UserResource($user), "User Details");
      $response = [
        'status' => 'success',
        'data' => new ProductRes($user),
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

  public function edit_product_image(Request $request)
  {
    $provider_id = Auth::user()->token()->user_id;
    $product_id = $request->product_id;
    $product_image_id = $request->product_image_id;

    // $user = TicketType::where('user_id', $user_id)
    //   ->where('id', $ticket_type_id)
    //   ->first();

    // $data = [
    //   'type' => $request->input('type', $user->type),
    //   'price' => $request->input('price', $user->price),
    //   'quantity' => $request->input('quantity', $user->quantity),
    // ];

    if ($request->hasFile('product_image')) {
      $file = $request->file('product_image');
      $image_exts = ['tif', 'jpg', 'jpeg', 'gif', 'png'];
      $extension = $file->getClientOriginalExtension();
      if (!in_array($extension, $image_exts)) {
        $response = [
          'status' => 'failure',
          'message' => 'Image Type Error',
        ];
        return response()->json($response);
      }
      $fileName = uniqid() . '.' . $extension;
      // $file->move(public_path('profile_pics/'), $fileName);
      $file->move(public_path('/images/product_images'), $fileName);
      $data['product_image'] = $fileName;
      // File::delete(public_path('profile_pics/') . $user->profile_pic);
    }

    $datas = ProductImages::where('id', $product_image_id)->update($data);
    return response([
      'success' => true,
      'message' => 'Product Image updated successfully ...!',
      // 'data' => $datas,
    ]);
  }

  public function old_product_image_delete(Request $request)
  {
    $provider_id = Auth::user()->token()->user_id;

    $product_id = $request->input('product_id');
    $product_image_id = $request->input('product_image_id');
    // $user = Event::find($request->input('event_id'));

    $user = ProductImages::where('id', $product_image_id)->delete();

    if ($user) {
      // $user->delete();

      return response()->json(['success' => true, 'message' => 'Product Image deleted successfully']);
    } else {
      return response()->json(['success' => false, 'message' => 'Product Image already deleted']);
    }
  }

  public function product_image_delete(Request $request)
  {
    $provider_id = Auth::user()->token()->user_id;
    $product_id = $request->input('product_id');
    $product_image_ids = $request->input('product_image_id'); // Expecting comma-separated values

    if (!$product_image_ids) {
      return response()->json(['success' => false, 'message' => 'No product images selected']);
    }

    // Convert comma-separated IDs into an array
    $imageIdsArray = explode(',', $product_image_ids);

    // Find and delete images
    $deletedImages = ProductImages::whereIn('id', $imageIdsArray)->delete();

    if ($deletedImages) {
      return response()->json(['success' => true, 'message' => 'Product Images deleted successfully']);
    } else {
      return response()->json(['success' => false, 'message' => 'Product Images not found or already deleted']);
    }
  }




  public function edit_addon_product_old(Request $request)
  {
    $product_id = $request->input('product_id');
    $service_ids = explode(',', $request->input('service_id'));

    foreach ($service_ids as $service_id) {
      if (!empty($service_id)) {

        $allready_product = AddonProduct::where('service_id', $service_id)->where('product_id', $product_id)->first();

        if (!empty($allready_product)) {


          $data = [
            // 'cat_id' => $request->input('cat_id'),
            // 'vid' => $user_id,
            'service_id' => $service_id,
            'product_id' => $product_id,
            'vid' => $user_id,
          ];

          if (!DB::table('addon_product')->insert($data)) {
            return response()->json([
              'response_code' => '0',
              'msg' => 'Database Error',
              'status' => 'failure'
            ]);
          }
        }
      }
    }
  }

  public function edit_addon_product(Request $request)
  {
    $user_id = Auth::user()->id;
    $product_id = $request->input('product_id');
    $service_ids = explode(',', $request->input('service_id'));

    // Delete all entries for the product that are not in the provided service_ids
    AddonProduct::where('product_id', $product_id)
      ->whereNotIn('service_id', $service_ids)
      ->delete();

    foreach ($service_ids as $service_id) {
      if (!empty($service_id)) {
        // Check if the product already exists for the service
        $existing_product = AddonProduct::where('service_id', $service_id)
          ->where('product_id', $product_id)
          ->first();

        if (!$existing_product) {
          // Prepare the data for the new entry
          $data = [
            'service_id' => $service_id,
            'product_id' => $product_id,
            'vid' => $user_id,
          ];

          // Insert the new product entry
          if (!DB::table('addon_product')->insert($data)) {
            return response()->json([
              'response_code' => '0',
              'msg' => 'Database Error',
              'status' => 'failure'
            ]);
          }
        }
      }
    }

    return response()->json([
      'response_code' => '1',
      'msg' => 'Addon Product Updated successfully',
      'status' => 'success'
    ]);
  }

  public function get_all_product_category()
  {
    $categories = DB::table('product_category')->select('id', 'c_name as product_category_name')->get();

    if ($categories->isNotEmpty()) {
      // foreach ($categories as $category) {
      //     // $category->icon = url('uploads/') . '/' . $category->icon;
      //     // $category->img = url('images/category_images/') . '/' . $category->img;

      //     $category->sub_cat_name = $category->c_name;
      // }


      $result = [
        'status' => 1,
        'msg' => 'Product Categories Found',
        'product_categories' => $categories,
      ];
    } else {
      $result = [
        'status' => 0,
        'msg' => 'No Product Categories found',
        'product_categories' => [],
      ];
    }

    return response()->json($result);
  }

  public function get_product_by_provider(Request $request)
  {
    $user_id = Auth::user()->token()->user_id;


    $notifications = Product::where('vid', $user_id)
      ->where('is_features', '=', "1")
      ->where('is_delete', '=', "0")
      ->with('productImages')
      ->orderByDesc('product_id')
      ->get();


    $list_notification = [];

    foreach ($notifications as $notification) {
      $questions_list['product_id'] = $notification->product_id;
      $questions_list['cat_id'] = (string)$notification->cat_id;
      $questions_list['vid'] = (string)$notification->vid;
      $questions_list['product_name'] = $notification->product_name;
      $questions_list['product_price'] = $notification->product_price;
      $questions_list['product_discount_price'] = $notification->product_discount_price ?? "";
      $questions_list['is_features'] = $notification->is_features ?? "";
      $questions_list['status'] = $notification->status ?? "";
      // $questions_list['avg_review'] = "4.5";
      // $questions_list['total_review'] = "200";

      $total_reviews = ProductReview::where('product_id', $notification->product_id)->count();

      $average_review = ProductReview::where('product_id', $notification->product_id)->avg('star_count');

      $questions_list['avg_review'] = (string)number_format($average_review, 1);

      $questions_list['total_review'] = (string)$total_reviews;

      $user = User::where('id', $notification->vid)->first();

      $all_image = DefaultImage::where('people_id', "1")->first();
      $my_image = $all_image->image;

      $fullName = $user->firstname . ' ' . $user->lastname;
      $questions_list['provider_name'] = $fullName ?? "";

      $questions_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
      $questions_list['provider_image'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);

      // $images = explode("::::", $notification->product_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/product_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // // $user->service_image = $imgsa;

      // $questions_list['product_image'] = $imgsa;

      $imgsa = [];

      foreach ($notification->productImages as $image) {
        $imgsa[] = asset('/images/product_images/' . $image->product_image);
      }

      $questions_list['product_image'] = $imgsa;

      $list_notification[] = $questions_list;
    }

    // $users_online = User::where('id', $user_id)->first();

    // $online = $users_online->is_online;

    $all_services = Product::where('vid', $user_id)
      ->where('is_delete', '=', "0")
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
      $questions_all_list['is_features'] = $done->is_features ?? "";
      $questions_all_list['status'] = $done->status ?? "";

      // $questions_all_list['avg_review'] = "4.5";
      // $questions_all_list['total_review'] = "200";

      $total_reviews = ProductReview::where('product_id', $done->product_id)->count();

      $average_review = ProductReview::where('product_id', $done->product_id)->avg('star_count');

      $questions_all_list['avg_review'] = (string)number_format($average_review, 1);

      $questions_all_list['total_review'] = (string)$total_reviews;

      $user = User::where('id', $done->vid)->first();

      $all_image = DefaultImage::where('people_id', "1")->first();
      $my_image = $all_image->image;

      $fullName = $user->firstname . ' ' . $user->lastname;

      $questions_all_list['provider_name'] = $fullName ?? "";

      $questions_all_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
      $questions_all_list['provider_image'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);

      // $images = explode("::::", $done->product_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/product_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // // $user->service_image = $imgsa;

      // $questions_all_list['product_image'] = $imgsa;

      $imgsa = [];

      foreach ($done->productImages as $image) {
        $imgsa[] = asset('/images/product_images/' . $image->product_image);
      }

      $questions_all_list['product_image'] = $imgsa;

      $list_notification_done[] = $questions_all_list;
    }






    if (!empty($user_id)) {
      $result['response_code'] = "1";
      $result['message'] = "Product List Found";
      $result['featured_product_list'] = $list_notification;
      $result['all_product_list'] = $list_notification_done;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "Product List Not Found";
      $result['featured_product_list'] = [];
      $result['all_product_list'] = [];
      $result["status"] = "failure";
    }

    return response()->json($result);
  }

  public function handyman_list_by_provider(Request $request)
  {
    // $result = [];
    // $users = [];

    $user_id = Auth::user()->token()->user_id;

    $handyman_list = User::where('provider_id', $user_id)->get();

    // print_r($handyman_list);
    // die;

    $user_done = array();
    $total_avg_count = "0";

    foreach ($handyman_list as $user) {

      $user_list['handyman_id'] = $user->id;
      $user_list['firstname'] = $user->firstname ?? "";
      $user_list['lastname'] = $user->lastname ?? "";
      $user_list['is_online'] = $user->is_online ?? "";
      $user_list['email'] = $user->email ?? "";
      $user_list['mobile'] = $user->mobile ?? "";
      $user_list['country_code'] = $user->country_code ?? "";
      $user_list['country_flag'] = $user->country_flag ?? "";
      $user_list['password'] = $user->main_password ?? "";

      $createdTimestamp = $user->created_at;

      // $createdDate = new DateTime($createdTimestamp);

      $formattedCreatedDate = $createdTimestamp->format('Y');
      $user_list['joined_at'] = $formattedCreatedDate;

      $ServiceReview = HandymanReview::where('handyman_id', $user->id);

      $totalStarCount = $ServiceReview->sum('star_count');

      // $total_members = HandymanReview::where('handyman_id', $user->id)->count();

      $totalReviewCount = $ServiceReview->count();

      if ($totalReviewCount) {
        $total_avg_count = $totalStarCount / $totalReviewCount;
      }

      $user_list['averge_ratings'] = $totalReviewCount ? number_format($total_avg_count, 1) : "0.0";
      $user_list['total_members_review'] = $totalReviewCount;

      $provider = Bankdetails::where('user_id', $user->id)->first();

      $user_list['bank_mobile_number'] = $provider->mobile_number ?? "";
      $user_list['bank_name'] = $provider->bank_name ?? "";
      $user_list['branch_name'] = $provider->branch_name ?? "";
      $user_list['acc_number'] = $provider->acc_number ?? "";
      $user_list['ifsc_code'] = $provider->ifsc_code ?? "";

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
      $result['message'] = "Handyman List Found";
      $result['all_handyman_list'] = $user_done;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "Handyman List Not Found";
      $result['all_handyman_list'] = [];
      $result["status"] = "failure";
    }

    return response()->json($result);
  }

  public function handyman_profile_with_review(Request $request)
  {
    // $result = [];
    // $users = [];

    $user_id = Auth::user()->token()->user_id;
    $handyman_id = $request->input('handyman_id');

    $handyman_list = User::where('provider_id', $user_id)->where('id', $handyman_id)->get();

    // print_r($handyman_list);
    // die;

    $user_done = array();
    $total_avg_count = "0";

    foreach ($handyman_list as $user) {

      $user_list['handyman_id'] = $user->id;
      $user_list['firstname'] = $user->firstname ?? "";
      $user_list['lastname'] = $user->lastname ?? "";
      $user_list['is_online'] = $user->is_online ?? "";
      $user_list['email'] = $user->email ?? "";
      $user_list['mobile'] = $user->mobile ?? "";
      $user_list['country_code'] = $user->country_code ?? "";
      $user_list['country_flag'] = $user->country_flag ?? "";
      $user_list['password'] = $user->main_password ?? "";

      $createdTimestamp = $user->created_at;

      // $createdDate = new DateTime($createdTimestamp);

      $formattedCreatedDate = $createdTimestamp->format('Y');
      $user_list['joined_at'] = $formattedCreatedDate;

      $ServiceReview = HandymanReview::where('handyman_id', $user->id);

      $totalStarCount = $ServiceReview->sum('star_count');

      // $total_members = HandymanReview::where('handyman_id', $user->id)->count();

      $totalReviewCount = $ServiceReview->count();

      if ($totalReviewCount) {
        $total_avg_count = $totalStarCount / $totalReviewCount;
      }

      $user_list['averge_ratings'] = $totalReviewCount ? number_format($total_avg_count, 1) : "0.0";
      $user_list['total_members_review'] = $totalReviewCount;

      $provider = Bankdetails::where('user_id', $user->id)->first();

      $user_list['bank_mobile_number'] = $provider->mobile_number ?? "";
      $user_list['bank_name'] = $provider->bank_name ?? "";
      $user_list['branch_name'] = $provider->branch_name ?? "";
      $user_list['acc_number'] = $provider->acc_number ?? "";
      $user_list['ifsc_code'] = $provider->ifsc_code ?? "";

      $all_image = DefaultImage::where('people_id', "2")->first();
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

      // array_push($user_done, $user_list);
    }

    $all_reviews = HandymanReview::where('handyman_id', $handyman_id)
      ->orderByDesc('id')
      ->get();


    $list_review_done = [];

    foreach ($all_reviews as $review_done) {
      $review_all_list['review_id'] = $review_done->id;
      $review_all_list['user_id'] = (string)$review_done->user_id;
      $review_all_list['handyman_id'] = (string)$review_done->handyman_id;
      $review_all_list['provider_id'] = (string)$review_done->provider_id;
      $review_all_list['text'] = $review_done->text;
      $review_all_list['star_count'] = $review_done->star_count;
      $review_all_list['created_at'] = $review_done->created_at ?? "";

      $user = User::where('id', $review_done->user_id)->first();

      $all_image = DefaultImage::where('people_id', "2")->first();
      $my_image = $all_image->image;

      $review_all_list['username'] = $user->firstname ?? "";
      $review_all_list['user_profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) : url('/images/user/' . $my_image);
      $list_review_done[] = $review_all_list;
    }

    if (!empty($user_id)) {
      $result['response_code'] = "1";
      $result['message'] = "Handyman List Found";
      $result['handyman_profile'] = $user_list;
      $result['handyman_review'] = $list_review_done;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "Handyman List Not Found";
      $result['handyman_profile'] = "";
      $result['handyman_review'] = [];
      $result["status"] = "failure";
    }

    return response()->json($result);
  }

  public function provider_add_handyman(Request $request)
  {
    $validator = Validator::make($request->all(), [
      // 'user_id' => 'required',
      'handyman_id' => 'required',
    ]);
    if ($validator->fails()) {

      return $this->sendError("Enter this field", $validator->errors(), 422);
    }

    $user_id = Auth::user()->token()->user_id;

    $handyman_id = $request->input('handyman_id');

    $done = User::where('id', $handyman_id)->where('provider_id', '==', "")->first();

    if (!empty($done)) {

      $temp = [
        "response_code" => "0",
        "message" => "Handyman Already Exist Other Provider",
        "status" => "failure",
        // "unread_count" => $approve,
      ];

      return response()->json($temp);
    }

    try {
      // $phone = $request->input('phone');
      // $otp = $request->input('otp');
      // $where = 'mobile_no="' . $mob_no . '"';
      $data = array(
        "provider_id" => $user_id,
        "people_id" => "2",
        // "updated_at" => now(),
        //  "device_token" => $device_token,
      );
      User::where('id', $handyman_id)->update($data);

      // $approve = Chat::where('to_user', $request->user_id)->where('message_read', '0')->count();

      $temp = [
        "response_code" => "1",
        "message" => "Provider Added Handyman successfully",
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

  public function all_products_booking_by_provider(Request $request)
  {
    $result = [];
    $users = [];

    $user_id = Auth::user()->token()->user_id;


    $users = BookingOrders::where('provider_id', $user_id)
      ->where('product_id', '!=', "")
      ->orderByDesc('id')
      ->get();

    foreach ($users as $user) {

      $date = date('d D Y', strtotime($user->created_at));

      $time = date('h:i', strtotime($user->created_at));

      $user->payment_method = $user->payment_method ?? "";
      $user->cat_name = $user->cat_name ?? "";
      // $user->location = $user->location ?? "";
      $user->booking_status = (string)$user->handyman_status ?? "";
      $user->handyman_status = (string)$user->handyman_status ?? "";
      $user->on_status = $user->on_status ?? "";
      $user->work_assign_id = $user->work_assign_id ?? "";
      $user->otp = $user->otp ?? "";
      $user->cart_id = $user->cart_id ?? "";
      $user->date = $date;
      $user->time = $time;
      $user->service_id = "";

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

      $services_all = CartItemsModel::where('cart_id', $user->cart_id)->first();

      $user->quantity = $services_all->quantity;

      $user->order_id = (string)$services_all->order_id ?? "";

      $services_all = Product::where('product_id', $user->product_id)->with('productImages')->first();

      $user->product_name = $services_all->product_name;
      $user->product_price = $services_all->product_price;

      // $images = explode("::::", $services_all->product_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/product_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // $user->product_image = $imgsa;

      $imgsa = [];

      foreach ($services_all->productImages as $image) {
        $imgsa[] = asset('/images/product_images/' . $image->product_image);
      }

      $user->product_image = $imgsa;

      $users_all = User::where('id', $user->user_id)->first();

      $user->firstname = $users_all->firstname . ' ' . $users_all->lastname;

      $user->mobile = $users_all->mobile ?? "";

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
        $user->profile_pic = url('/images/user/' . $my_image);
      }
    }
    // $users_all_count = Review::where('send_user_review_id', $user_id)->count();





    if (!empty($users)) {
      $result['response_code'] = "1";
      $result['message'] = "All Products Booking Found";
      $result['product_booking_list'] = $users;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "Products Booking Not Found";
      $result['product_booking_list'] = [];
      $result["status"] = "failure";
    }

    return response()->json($result);
  }


  public function all_services_booking_by_provider(Request $request)
  {
    $result = [];
    $users = [];

    $user_id = Auth::user()->token()->user_id;


    $users = BookingOrders::where('provider_id', $user_id)
      ->where('service_id', '!=', "")
      ->orderByDesc('id')
      ->get();

    foreach ($users as $user) {

      $date = date('d D Y', strtotime($user->created_at));

      $time = date('h:i', strtotime($user->created_at));

      $user->payment_method = $user->payment_method ?? "";
      $user->cat_name = $user->cat_name ?? "";
      // $user->location = $user->location ?? "";
      // $user->booking_status = $user->booking_status ?? "";
      $user->work_assign_id = (string)$user->work_assign_id ?? "";
      $user->on_status = $user->on_status ?? "";
      $user->booking_status = (string)$user->handyman_status ?? "";
      $user->handyman_status = (string)$user->handyman_status ?? "";
      $user->otp = $user->otp ?? "";
      $user->cart_id = $user->cart_id ?? "";
      if ($user->cart_id) {
        $cart = CartItemsModel::where('cart_id', $user->cart_id)->first();

        $user->date = $cart->booking_date ?? "";
        $user->time = $cart->booking_time ?? "";
      } else {

        $user->date = "";
        $user->time = "";
      }
      // $user->date = $date;
      // $user->time = $time;
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

      $services_all = CartItemsModel::where('cart_id', $user->cart_id)->first();

      $user->order_id = (string)$services_all->order_id ?? "";

      $handyman = User::find($user->work_assign_id);
      $user->assigned_by = $user->work_assign_id ? $handyman->firstname . ' ' . $handyman->lastname : "";

      $services_all = Service::where('id', $user->service_id)->with('serviceImages')->first();

      $user->service_name = $services_all->service_name;
      $user->service_price = $services_all->service_price;

      // $images = explode("::::", $services_all->service_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/service_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // $user->service_image = $imgsa;

      $imgsa = [];

      foreach ($services_all->serviceImages as $image) {
        $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
      }

      $user->service_image = $imgsa;

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
        $user->profile_pic = url('/images/user/' . $my_image);
      }
    }





    if (!empty($users)) {
      $result['response_code'] = "1";
      $result['message'] = "All Servives Booking Found";
      $result['service_booking_list'] = $users;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "Servives Booking Not Found";
      $result['service_booking_list'] = [];
      $result["status"] = "failure";
    }

    return response()->json($result);
  }

  public function get_all_service_by_provider(Request $request)
  {
    $user_id = Auth::user()->token()->user_id;


    $all_services = Service::where('v_id', $user_id)
      ->with('serviceImages')
      ->orderByDesc('id')
      ->get();


    $list_notification_done = [];

    foreach ($all_services as $done) {
      $questions_all_list['id'] = $done->id;
      $questions_all_list['cat_id'] = (string)$done->cat_id;
      $questions_all_list['res_id'] = (string)$done->res_id;
      $questions_all_list['v_id'] = (string)$done->v_id;
      $questions_all_list['service_name'] = $done->service_name;
      $questions_all_list['service_price'] = $done->service_price;
      $questions_all_list['service_discount_price'] = $done->service_discount_price ?? "";
      $questions_all_list['avg_review'] = "4.5";
      $questions_all_list['total_review'] = "200";

      $user = User::where('id', $done->v_id)->first();
      // $questions_all_list['provider_name'] = $user->firstname;

      $all_image = DefaultImage::where('people_id', "1")->first();
      $my_image = $all_image->image;

      $questions_all_list['provider_name'] = $user->firstname . ' ' . $user->lastname;
      $questions_all_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);
      $questions_all_list['provider_image'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);

      // $images = explode("::::", $done->service_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/service_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // // $user->service_image = $imgsa;

      // $questions_all_list['service_image'] = $imgsa;

      $imgsa = [];

      foreach ($done->serviceImages as $image) {
        $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
      }

      $questions_all_list['service_image'] = $imgsa;

      $list_notification_done[] = $questions_all_list;
    }






    if (!empty($user_id)) {
      $result['response_code'] = "1";
      $result['message'] = "Service List Found";
      $result['all_service_list'] = $list_notification_done;
      $result["status"] = "success";
    } else {
      $result["response_code"] = "0";
      $result["message"] = "Service List Not Found";
      $result['all_service_list'] = [];
      $result["status"] = "failure";
    }

    return response()->json($result);
  }
  public function edit_profile_handyman_by_provider(Request $request)
  {

    try {
      //code...

      $user_id = $request->input('user_id');
      $provider_id = Auth::user()->token()->user_id;
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
        // 'branch_name' => $request->input('branch_name', $user->branch_name),
        // 'bank_name' => $request->input('bank_name', $user->bank_name),
        // 'acc_number' => $request->input('acc_number', $user->acc_number),
        // 'ifsc_code' => $request->input('ifsc_code', $user->ifsc_code),
      ];

      $bank = Bankdetails::where('user_id', $user_id)->first();

      if ($bank) {

        $all_updates = [
          'mobile_number' => $request->input('mobile_number', $bank->mobile_number),
          'branch_name' => $request->input('branch_name', $bank->branch_name),
          'bank_name' => $request->input('bank_name', $bank->bank_name),
          'acc_number' => $request->input('acc_number', $bank->acc_number),
          'ifsc_code' => $request->input('ifsc_code', $bank->ifsc_code),
        ];


        $bank->update($all_updates);
      } else {

        $done['branch_name'] = $request->input('branch_name');
        $done['bank_name'] = $request->input('bank_name');
        $done['acc_number'] = $request->input('acc_number');
        $done['ifsc_code'] = $request->input('ifsc_code');
        $done['mobile_number'] = $request->input('mobile_number');
        $done['user_id'] = $user_id;
        $done['provider_id'] = $provider_id;

        $provider = Bankdetails::create($done);
      }



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

  public function handyman_account_delete_by_provider(Request $request)
  {
    $user_id = $request->input('user_id');
    $provider_id = Auth::user()->token()->user_id;

    $user = User::where('id', $user_id)->where('provider_id', $provider_id)->delete();

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

  public function home_provider_info(Request $request)
  {

    // header('Content-Type: application/json');
    //  $agent = $this->input->request_headers();

    //   $id = $this->input->post('user_id');

    $user_id = Auth::user()->token()->user_id;

    $id = $request->input('user_id');

    if (empty($user_id)) {

      $temp["response_code"] = "0";

      $temp["message"] = "Enter Data";

      $temp["status"] = "failure";

      //  echo json_encode($temp);
      return response()->json($result);
    } else {

      $temp = array();

      $profile = array();

      //  $profile = $this->Profile_api_model->get_user($id);

      $profile = User::find($user_id);

      $all_image = DefaultImage::where('people_id', "1")->first();
      $my_image = $all_image->image;

      $user = array();

      $user['id'] = (string)$profile->id;
      $user['firstname'] = $profile->firstname ?? "";
      $user['lastname'] = $profile->lastname ?? "";
      $user['email'] = $profile->email ?? "";
      $user['profile_pic'] = $profile->profile_pic ? url('/images/user/' . $profile->profile_pic) : url('/images/user/' . $my_image);

      // $commission = Commissions::where('user_role', "Provider")->where('type', "Service")->first();

      $commission = Commissions::where('people_id', "1")->where('type', "Service")->first();

      $user['comission'] = (string)$commission->value .  "%" ?? "";

      $todayBookingsCount = BookingOrders::where('provider_id', $user_id)->where('handyman_status', "6")
        ->whereDate('updated_at', Carbon::today())
        ->count();

      $user['total_job_done'] = (string)$todayBookingsCount;

      $todayBookingsCount = BookingOrders::where('provider_id', $user_id)
        ->whereDate('created_at', Carbon::today())
        ->count();
      $user['today_booking'] = (string)$todayBookingsCount;


      $total_bal = ProviderHistory::where('provider_id', $user_id)->first();
      $earn_val = $total_bal ? $total_bal->available_bal : "0";

      $user['total_earned'] = $earn_val ?? "";


      $total_reviews_count = 0;
      $total_reviews_sum = 0;
      $total_reviews_count = 0;
      $total_average_count = 0;

      $products = DB::table('services')
        ->select('id', 'service_name', 'service_image', 'cat_id', 'res_id', 'service_price')
        ->where('v_id', $user_id)
        ->orderBy('id', 'desc')
        ->get();

      foreach ($products as $product) {


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
      }

      $user['today_rating'] = $total_reviews_sum ? number_format($total_reviews_sum, 1) : "0.0";

      $todayAmount = BookingProviderHistory::where('provider_id', $user_id)->whereDate('created_at', Carbon::today())
        ->sum('amount');

      //  $user['today_earning'] = "0";

      //   $result['saving_price'] = number_format((float)$saving_price, 1, '.', '');

      $user['today_earning'] = number_format((float)$todayAmount, 1, '.', '');

      //  $product = Product::where('vid', $user_id)->where('is_delete', "0")->count();

      $product = BookingOrders::where('provider_id', $user_id)->whereNotnull('product_id')->count();

      $user['total_product'] = (string)$product;

      //  $service = Service::where('v_id', $user_id)->where('is_delete', "0")->count();

      $service = BookingOrders::where('provider_id', $user_id)->whereNotnull('service_id')->count();

      //  $service = BookingOrders::where('provider_id', $user_id)->count();

      $user['total_service'] = (string)$service;




      //  $user['user_role'] = $profile->user_role ?? "";

      //  $user['country_flag'] = $profile->country_flag ?? "";
      //  $user['device_token'] = $profile->device_token ?? "";
      //  $user['timestamp'] = $profile->created_at;
      //  $user['login_type'] = $profile->login_type ?? "";
      //  $user['location'] = $profile->location ?? "";

      //  $user_like = ProviderLike::where('user_id', $user_id)->where('provider_id', $id)->first();
      //  $user['is_like'] = $user_like ? "1" : "0";


      // $products = DB::table('services')
      //     ->select('id', 'service_name', 'service_image', 'cat_id', 'res_id', 'service_price')
      //     ->where('v_id', $id)
      //     ->orderBy('id', 'desc')
      //     ->get();

      // if ($products->isNotEmpty()) {
      //     foreach ($products as $product) {


      //         $product->service_name = $product->service_name ?? "";
      //         $images = explode("::::", $product->service_image);
      //         $imgsa = [];

      //         foreach ($images as $image) {
      //             $imgsa[] = url('images/service_images/' . $image);
      //         }

      //         $product->service_image = $imgsa;
      //     }
      // }





      $temp["response_code"] = "200";

      $temp["message"] = "Success";

      $temp['user'] = $user;

      //  $temp['service_list'] = $products ?? [];

      $temp["status"] = "success";

      return response()->json($temp);
    }
  }

  public function service_booking_details_by_provider(Request $request)
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
        'payment' => $bookingOrder->payment ?? "",
        // 'location' => $bookingOrder->location ?? "",
        'booking_status' => (string)$bookingOrder->handyman_status ?? "",
        'payment_method' => $bookingOrder->payment_method ?? "",
        'user_id' => $bookingOrder->user_id ?? "",
        'on_status' => $bookingOrder->on_status ?? "",
        'work_assign_id' => (string)$bookingOrder->work_assign_id ?? "",
        'otp' => $bookingOrder->otp ?? "",
        'service_id' => $bookingOrder->service_id ?? "",
        // 'booking_date' => $bookingOrder->booking_date ?? "",
        // 'booking_time' => $bookingOrder->booking_time ?? "",
        // 'booking_date' => date('d D Y', strtotime($bookingOrder->created_at)),
        // 'booking_time' => date('h:i', strtotime($bookingOrder->created_at)),
      ];


      $location = $bookingOrder->location;

      $don_all = BookingOrdersStatus::where('booking_id', $booking_id)->first();
      $restaurant['reason'] = $don_all->reason ?? "";

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
        $restaurant['location'] = implode(', ', $filtered_fields);
      } else {
        $restaurant['location'] = '';
      }

      $services_all = CartItemsModel::where('cart_id', $bookingOrder->cart_id)->first();

      $order_id = $services_all->order_id;

      $qty_total = CartItemsModel::where('order_id', $order_id)->sum('quantity');



      // $date = Carbon::createFromFormat('d-m-Y', $services_all->booking_date);

      // Format the date to "19 Fri 2024"
      // $formattedDate = $date->format('d D Y');
      $restaurant['order_id'] = (string)$services_all->order_id ?? "";
      $restaurant['notes'] = $services_all->notes ?? "";
      $restaurant['booking_date'] = $services_all->booking_date ?? "";
      $restaurant['booking_time'] = $services_all->booking_time ?? "";

      $handyman = User::find($bookingOrder->work_assign_id);
      $restaurant['assigned_by'] = $bookingOrder->work_assign_id ? $handyman->firstname . ' ' . $handyman->lastname : "";

      $all_image = DefaultImage::where('people_id', "2")->first();
      $my_image = $all_image->image;
      // $restaurant['handyman_name'] = $bookingOrder->work_assign_id ? $handyman->firstname . ' ' . $handyman->lastname : "";
      $restaurant['handyman_id'] = $bookingOrder->work_assign_id ? (string)$bookingOrder->work_assign_id : "0";
      $restaurant['handyman_email'] = $bookingOrder->work_assign_id ? $handyman->email : "";
      $restaurant['handyman_phone'] = $bookingOrder->work_assign_id ? $handyman->mobile : "";
      $restaurant['handyman_image'] = $bookingOrder->work_assign_id ? url('/images/user/' . $handyman->profile_pic) :  url('/images/user/' . $my_image);

      $user = User::find($bookingOrder->user_id);

      $all_image = DefaultImage::where('people_id', "3")->first();
      $my_image = $all_image->image;

      // $result = array();

      if ($user) {
        $works['user_id'] = (string)$user->id ?? "";
        $works['user_name'] = $user->firstname . ' ' . $user->lastname;
        $works['email'] = $user->email ?? "";
        $works['profile_pic'] = $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);

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

          $filtered_fields = array_filter($fields);
        }
        $works['location'] =  $address_data ? implode(', ', $filtered_fields) : "";
        // $restaurant['mobile'] = $user->mobile ?? "";
        $works['mobile'] = ($user->country_code ?? '') . ($user->mobile ?? '');

        $works['lat'] = $address_data->lat ?? "";
        $works['lon'] = $address_data->lon ?? "";
      } else {
        $works['user_id'] = "";
        $works['user_name'] = "";
        $works['email'] = "";
        $works['profile_pic'] = "";
        $works['location'] = "";
        $works['mobile'] = "";
        $works['lat'] = "";
        $works['lon'] = "";

        // $result = $works;
      }

      $restaurant['about_customer'] = $works;

      // $cart_items = CartItemsModel::where('order_id', $order_id)->first();

      $order = OrdersModel::where('id', $order_id)->first();

      if ($order) {
        $orders['price'] = $order->sub_total ?? "";
        $orders['coupon'] = $order->coupon ?? "";
        $orders['tax'] = $order->tax ?? "";
        $orders['sub_total'] =  $order->sub_total;
        $orders['total'] =  $order->total;
        // $orders['quantity'] = (string)$services_all->quantity ?? "";
        $orders['quantity'] = (string)$qty_total ?? "";
        $orders['service_charge'] =  $order->service_charge;
      } else {
        $orders['price'] = $order->sub_total;
        $orders['coupon'] = $order->coupon ?? "";
        $orders['tax'] = $order->tax ?? "";
        $orders['sub_total'] =  $order->sub_total;
        $orders['total'] =  $order->total;
        $orders['quantity'] = (string)$services_all->quantity ?? "";
        $orders['service_charge'] =  $order->service_charge;
      }

      $restaurant['price_details'] = $orders;

      $service_proof = ServiceProof::where('booking_id', $booking_id)->first();

      $restaurant['service_proof_status'] = $service_proof ? "1" : "0";

      $services_all = Service::where('id', $bookingOrder->service_id)->with('serviceImages')->first();

      $restaurant['service_name'] = $services_all->service_name;
      $restaurant['service_price'] = $services_all->service_price;
      $restaurant['service_description'] = $services_all->service_description ?? "";

      // $images = explode("::::", $services_all->service_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/service_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // $restaurant['service_image'] = $imgsa;


      $imgsa = [];

      foreach ($services_all->serviceImages as $image) {
        $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
      }

      $restaurant['service_image'] = $imgsa;


      $review_list = ServiceReview::where('service_id', $bookingOrder->service_id)->limit('3')->get();


      foreach ($review_list as $row) {
        $res = [];
        $res['review_id'] = (string)$row->id;
        $res['user_id'] = $row->user_id ?  $row->user_id : "";
        $res['text'] = $row->text  ?  $row->text : "";
        $res['star_count'] = $row->star_count ?  $row->star_count : "";
        $res['service_id'] = $row->service_id ?  $row->service_id : "";

        $date = date('M d, Y', strtotime($row->created_at));

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
          $res['profile_pic'] =  url('/images/user/' . $my_image);
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


  public function product_booking_details_by_provider(Request $request)
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
        'payment' => $bookingOrder->payment ?? "",
        // 'location' => $bookingOrder->location ?? "",
        'booking_status' => (string)$bookingOrder->handyman_status ?? "",
        'payment_method' => $bookingOrder->payment_method ?? "",
        'user_id' => $bookingOrder->user_id ?? "",
        'on_status' => $bookingOrder->on_status ?? "",
        'work_assign_id' => $bookingOrder->work_assign_id ?? "",
        'otp' => $bookingOrder->otp ?? "",
        'product_id' => $bookingOrder->product_id ?? "",
        'booking_date' => date('d D Y', strtotime($bookingOrder->created_at)),
        'booking_time' => date('h:i', strtotime($bookingOrder->created_at)),
      ];

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

        $filtered_fields = array_filter($fields);
        $restaurant['location'] = implode(', ', $filtered_fields);
      } else {
        $restaurant['location'] = '';
      }


      $services_all = CartItemsModel::where('cart_id', $bookingOrder->cart_id)->first();

      $order_id = $services_all->order_id;

      $qty_total = CartItemsModel::where('order_id', $order_id)->sum('quantity');



      // $date = Carbon::createFromFormat('d-m-Y', $services_all->booking_date);

      // Format the date to "19 Fri 2024"
      // $formattedDate = $date->format('d D Y');
      $restaurant['order_id'] = (string)$services_all->order_id ?? "";
      $restaurant['notes'] = $services_all->notes ?? "";
      // $restaurant['booking_date'] = $formattedDate ?? "";
      // $restaurant['booking_time'] = $services_all->booking_time ?? "";

      $handyman = User::find($bookingOrder->work_assign_id);
      $restaurant['assigned_by'] = $bookingOrder->work_assign_id ? $handyman->firstname . ' ' . $handyman->lastname : "";


      $user = User::find($bookingOrder->user_id);

      $all_image = DefaultImage::where('people_id', "3")->first();
      $my_image = $all_image->image;

      // $result = array();

      if ($user) {
        $works['user_id'] = (string)$user->id ?? "";
        $works['user_name'] = $user->firstname . ' ' . $user->lastname;
        $works['email'] = $user->email ?? "";
        $works['profile_pic'] = $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);

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

          $filtered_fields = array_filter($fields);
        }
        $works['location'] =  $address_data ? implode(', ', $filtered_fields) : "";
        // $works['location'] = $user->location ?? "";
        // $restaurant['mobile'] = $user->mobile ?? "";
        $works['mobile'] = ($user->country_code ?? '') . ($user->mobile ?? '');
        $works['lat'] = $address_data->lat ?? "";
        $works['lon'] = $address_data->lon ?? "";
      } else {
        $works['user_id'] = "";
        $works['user_name'] = "";
        $works['email'] = "";
        $works['profile_pic'] = "";
        $works['location'] = "";
        $works['mobile'] = "";
        $works['lat'] = "";
        $works['lon'] = "";

        // $result = $works;
      }

      $restaurant['about_customer'] = $works;

      // $cart_items = CartItemsModel::where('order_id', $order_id)->first();

      $order = OrdersModel::where('id', $order_id)->first();

      if ($order) {
        $orders['price'] = $order->sub_total ?? "";
        $orders['coupon'] = $order->coupon ?? "";
        $orders['tax'] = $order->tax ?? "";
        $orders['sub_total'] =  $order->sub_total;
        $orders['total'] =  $order->total;
        $orders['service_charge'] =  $order->service_charge;
        // $orders['quantity'] = (string)$services_all->quantity ?? "";
        $orders['quantity'] = (string)$qty_total ?? "";
      } else {
        $orders['price'] = $order->sub_total;
        $orders['coupon'] = $order->coupon ?? "";
        $orders['tax'] = $order->tax ?? "";
        $orders['sub_total'] =  $order->sub_total;
        $orders['total'] =  $order->total;
        $orders['service_charge'] =  $order->service_charge;
        $orders['quantity'] = (string)$services_all->quantity ?? "";
      }

      $restaurant['price_details'] = $orders;

      $service_proof = ServiceProof::where('booking_id', $booking_id)->first();

      $restaurant['service_proof_status'] = $service_proof ? "1" : "0";

      $services_all = Product::where('product_id', $bookingOrder->product_id)->with('productImages')->first();

      $restaurant['product_name'] = $services_all->product_name;
      $restaurant['product_price'] = (string)$services_all->product_price;
      $restaurant['product_description'] = $services_all->product_description ?? "";

      // $images = explode("::::", $services_all->product_image);
      // $imgs = array();
      // $imgsa = array();
      // foreach ($images as $key => $image) {


      //   // $imgs =  asset('assets/images/post/'. $image);

      //   $imgs = asset('/images/product_images/' . $image);

      //   array_push($imgsa, $imgs);
      // }
      // $restaurant['product_image'] = $imgsa;

      $imgsa = [];

      foreach ($services_all->productImages as $image) {
        $imgsa[] = asset('/images/product_images/' . $image->product_image);
      }

      $restaurant['product_image'] = $imgsa;


      $review_list = ProductReview::where('product_id', $bookingOrder->product_id)->limit('3')->get();


      foreach ($review_list as $row) {
        $res = [];
        $res['review_id'] = (string)$row->id;
        $res['user_id'] = $row->user_id ?  $row->user_id : "";
        $res['text'] = $row->text  ?  $row->text : "";
        $res['star_count'] = $row->star_count ?  $row->star_count : "";
        $res['product_id'] = $row->product_id ?  $row->product_id : "";

        $date = date('M d, Y', strtotime($row->created_at));

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

      $total_review_count = ProductReview::where('product_id', $bookingOrder->product_id)->count();


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

  public function provider_update_status(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'booking_id' => 'required',
      'booking_status' => 'required',
    ]);
    if ($validator->fails()) {

      return $this->sendError("Enter this field", $validator->errors(), 422);
    }

    $user_id = Auth::user()->token()->user_id;

    $booking_status = $request->input('booking_status');
    $booking_id = $request->input('booking_id');

    try {

      $booking_status_al = BookingOrders::where('id', $booking_id)->first();

      $status = $booking_status_al->handyman_status;


      if ($status == "12") {

        $temp = [
          "response_code" => "1",
          "message" => "Provider Status Not Update successfully",
          "status" => "success",
          // "unread_count" => $approve,
        ];

        return response()->json($temp);
      }

      $data = array(
        "handyman_status" => $booking_status,
      );
      BookingOrders::where('provider_id', $user_id)->where('id', $booking_id)->update($data);


      //      $data = [
      //     'booking_id' => $request->input('booking_id'),
      //     'provider_id' => $user_id,
      //     'product_name' => $request->input('product_name'),
      //     'product_price' => $request->input('product_price'),
      //     'product_description' => $request->input('product_description'),
      //     'product_image' => implode('::::', $res_image),
      //     'product_discount_price' => $request->input('product_discount_price'),
      //     'is_features' => $request->input('is_features'),
      //     'status' => $request->input('status'),
      //     // 'created_date' => now()->timestamp,
      // ];

      // if (DB::table('products')->insert($data))

      if ($booking_status == "5") {

        $booking_id = $request->input('booking_id');
        $cart_value_done = BookingOrders::where('id', $booking_id)->first();

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

            // $payment_all = ($payment * $product_percentage / 100);

            if ($product_percentage) {

              $payment_all = ($payment * $product_percentage / 100);
            } else {

              $payment_all = $payment;
            }
          } else {

            $payment_all = $payment;
          }


          // $order_value_ask = CartItemsModel::where('order_id', $order_id)->wherenotnull('product_id', "")->count();

          // $payment_all = $product_subtotal / $order_value_ask;
        }

        $user_id_done = $cart_value_done->user_id;

        // $user = User::where('id', $user_id)->first();
        $user = User::where('id', $user_id_done)->first();

        $booking_date_all = $cart_value_done->created_at;

        $user_all_done =  User::where('id', $user_id_done)->first();
        $email = $user_all_done->email;
        $firstname = $user_all_done->firstname;

        $emailPreference = UserEmailBookingCancelled::where('get_email', 1)->first();

        $provider_all_done =  User::where('id', $user_id)->first();
        $provider_name = $provider_all_done->firstname;

        $dateTime = new \DateTime($booking_date_all);

        // Format the date and time
        $booking_date = $dateTime->format('d M, Y - h:i A');

        if ($emailPreference) {
          // Send email on successful OTP verification
          Mail::to($email)->send(
            new UserBookingCancelled($email, $booking_id, $provider_name, $booking_date, $firstname)
          );
        }

        if ($user) {

          $user->update([
            'wallet_balance' => $user->wallet_balance + $payment_all,
          ]);
        }

        $data_old = [
          'user_id' => $user_id_done,
          'payment_method' => "Refund",
          'amount' => $payment_all,
          'status' => "Refund",
          'success' => "true",
          'created_at' => now(),
        ];

        $done = DB::table('wallet')->insert($data_old);

        $provider_id_done = $cart_value_done->provider_id;
        // $handyman_id_done = $cart_value_done->work_assign_id;
        $user_id_done = $cart_value_done->user_id;
        $all_cart_id = $cart_value_done->cart_id;
        $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();

        $order_id = $all_order__id->order_id;



        $FcmToken = User::where('id', $user_id_done)->value('device_token');



        $proviver_all_noti = NotificationsPermissions::where('id', "31")->where('status', "1")->first();


        $username =  User::where('id', $provider_id_done)->first();

        // $firstname = $username->firstname;

        $providername = $username->firstname . ' ' . $username->lastname;
        // $type = "Service";

        $all_type = BookingOrders::where('id', $booking_id)->first();

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


        // Replace placeholders with actual values
        $message = str_replace(
          ['[[ booking_id ]]', '[[ providername ]]'],
          ['#' . $booking_id, $providername],
          $proviver_all_noti->description
        );

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

        $user_ser_done = BookingOrders::where('id', $booking_id)->first();

        //  $all_user_id = $user_ser_done->user_id;
        //  $provider_id = $user_ser_done->provider_id;


        $not_all_done = [
          'booking_id' => $request->input('booking_id'),
          // 'handyman_id' => $handyman_id_done,
          'provider_id' => "0",
          'user_id' => $user_id_done,
          'title' => $proviver_all_noti->title,
          // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description. ' '.  $firstname,
          'message' => $message,
          'type' => $type,
          'created_at' => now(),
          'requests_status' => "1",
        ];

        $done = DB::table('user_notification')->insert($not_all_done);

        // $not_all_done_abc = [
        //   'booking_id' => $request->input('booking_id'),
        //   // 'handyman_id' => $handyman_id_done,
        //   'provider_id' => 0,
        //   'user_id' => $user_id_done,
        //   'title' => $proviver_all_noti->title,
        //   // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description. ' '.  $firstname,
        //   'message' => $message,
        //   'type' => "Service",
        //   'created_at' => now(),
        //   'requests_status' => "0",
        // ];

        // $done = DB::table('user_notification')->insert($not_all_done_abc);

        $proviver_all_notifi = NotificationsPermissions::where('id', "34")->where('status', "1")->first();

        $all_type = BookingOrders::where('id', $booking_id)->first();

        if ($all_type->service_id !== null) {


          $cart_id = $all_type->cart_id;
          $order_value = CartItemsModel::where('cart_id', $cart_id)->first();

          $order_id = $order_value->order_id;

          $payment_all = OrdersModel::where('id', $order_id)->first();

          $amount = $service_value->service_subtotal;
        } else {
          $amount = $all_type->payment;
        }

        $all_cart_id = $all_type->cart_id;
        // $amount = $all_type->payment;
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

        // $payment_all = $amount;

        $currency_done = SiteSetup::where('id', "1")->first();

        $currency = $currency_done->default_currency;

        $user_all_done =  User::where('id', $user_id_done)->first();
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
        // Replace placeholders with actual values
        $message = str_replace(
          ['[[ booking_id ]]', '[[ service_name ]]', '[[ amount ]]', '[[ currency ]]'],
          ['#' . $booking_id, $service_name, $amount, $currency],
          $proviver_all_notifi->description
        );

        // $firstname = $username->firstname;
        $firstname = $username->firstname . ' ' . $username->lastname;




        $data_done = [
          'title' => $proviver_all_notifi->title,
          // 'message' => '$'.$payment_all    . ' ' . $proviver_all_notifi->description . ' '.  $service_name,
          'message' => $message,
          'type' => $type,
          'booking_id' => $booking_id,
          'order_id' => $order_id,
        ];

        $this->sendNotification(new Request($data_done), $FcmToken);


        $not_all_done_exit = [
          'booking_id' => $request->input('booking_id'),
          'handyman_id' => 0,
          'provider_id' => 0,
          'user_id' => $user_id_done,
          'title' => $proviver_all_notifi->title,
          // 'message' => '$'.$payment_all    . ' ' . $proviver_all_noti->description . ' '.  $service_name,
          'message' => $message,
          'type' => $type,
          'created_at' => now(),
          'requests_status' => "1",
        ];

        $dones = DB::table('user_notification')->insert($not_all_done_exit);
      }

      if ($booking_status == "1") {

        $booking_id = $request->input('booking_id');
        $cart_value_done = BookingOrders::where('id', $booking_id)->first();

        $provider_id_done = $cart_value_done->provider_id;
        // $handyman_id_done = $cart_value_done->work_assign_id;
        $user_id_done = $cart_value_done->user_id;
        $all_cart_id = $cart_value_done->cart_id;
        $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
        $order_id = $all_order__id->order_id;

        $emailPreference = UserEmailBookingAccepted::where('get_email', 1)->first();

        $booking_date_all = $cart_value_done->created_at;

        $user_all_done =  User::where('id', $user_id_done)->first();
        $email = $user_all_done->email;
        $firstname = $user_all_done->firstname;

        $provider_all_done =  User::where('id', $user_id)->first();
        $provider_name = $provider_all_done->firstname;
        $handyman_name = $provider_all_done->firstname;

        $dateTime = new \DateTime($booking_date_all);

        // Format the date and time
        $booking_date = $dateTime->format('d M, Y - h:i A');

        if ($emailPreference) {
          // Send email on successful OTP verification
          Mail::to($email)->send(
            new UserBookingAccepted($email, $booking_id, $handyman_name, $booking_date, $firstname)
          );
        }




        $FcmToken = User::where('id', $user_id_done)->value('device_token');

        $proviver_all_noti = NotificationsPermissions::where('id', "4")->where('status', "1")->first();


        $username =  User::where('id', $user_id)->first();

        // $firstname = $username->firstname;
        $firstname = $username->firstname . ' ' . $username->lastname;
        $type = "Service";

        // Replace placeholders with actual values
        $message = str_replace(
          ['[[ booking_id ]]'],
          ['#' . $booking_id],
          $proviver_all_noti->description
        );


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



        $user_ser_done = BookingOrders::where('id', $booking_id)->first();

        //  $all_user_id = $user_ser_done->user_id;
        //  $provider_id = $user_ser_done->provider_id;


        $not_all_done = [
          'booking_id' => $request->input('booking_id'),
          // 'handyman_id' => $handyman_id_done,
          'provider_id' => $provider_id_done,
          'user_id' => $user_id_done,
          'title' => $proviver_all_noti->title,
          // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
          'message' => $message,
          'type' => "Service",
          'created_at' => now(),
          // 'requests_status' => "1",
        ];

        $done = DB::table('user_notification')->insert($not_all_done);
      }


      if ($booking_status == "10") {

        $booking_id = $request->input('booking_id');
        $cart_value_done = BookingOrders::where('id', $booking_id)->first();

        $provider_id_done = $cart_value_done->provider_id;
        // $handyman_id_done = $cart_value_done->work_assign_id;
        $user_id_done = $cart_value_done->user_id;
        $all_cart_id = $cart_value_done->cart_id;
        $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
        $order_id = $all_order__id->order_id;


        $fetch_user = User::where('id', $user_id_done)->first();
        $email = $fetch_user->email;
        $firstname = $fetch_user->firstname;

        $product_name_all = Product::where('product_id', $cart_value_done->product_id)->first();
        $product_name = $product_name_all->product_name;

        $emailPreference = UserEmailProductDelivered::where('get_email', 1)->first();

        $formattedDateTime = $cart_value_done->created_at;

        $dateTime = new \DateTime($formattedDateTime);

        // Format the date and time
        $date = $dateTime->format('d M, Y - h:i A');



        if ($emailPreference) {
          // Send email on successful OTP verification
          Mail::to($email)->send(
            new UserProductDelivered($email, $firstname, $booking_id, $product_name, $date)
          );
        }


        // $emailPreference = ProviderEmailOrderDelivered::where('get_email', 1)->first();

        // $formattedDateTime = $cart_value_done->created_at;

        // $fetch_provider = User::where('id', $provider_id_done)->first();
        // $email = $fetch_provider->email;
        // $firstname = $fetch_provider->firstname;

        // $provider_name = $fetch_provider->firstname;

        // $dateTime = new \DateTime($formattedDateTime);

        // // Format the date and time
        // $date = $dateTime->format('d M, Y - h:i A');

        // $booking_date = $dateTime->format('d M, Y - h:i A');


        // if ($emailPreference) {
        //   // Send email on successful OTP verification
        //   Mail::to($email)->send(
        //     new ProviderOrderDelivered($email, $booking_id, $provider_name, $booking_date, $firstname)
        //   );
        // }


        $price = Product::where('product_id', $all_order__id->product_id)->first();
        $final_price = $price->product_discount_price ? $price->product_discount_price : $price->product_price;

        $provider_id = $price->vid;


        $sub_total = $price->product_discount_price ? ($price->product_discount_price * $all_order__id->quantity) : ($price->product_price * $all_order__id->quantity);


        // $commissions_value_pro = Commissions::where('user_role', "Provider")->where('type', "Product")->first();

        $commissions_value_pro = Commissions::where('people_id', "1")->where('type', "Product")->first();

        $commissions_done_pro = $commissions_value_pro->value;

        // $calculation_pro = ($commissions_done_pro * $sub_total / 100);

        $prvider_new = ProviderHistory::where('provider_id', $provider_id)->first();

        $cart_value_done_do = BookingOrders::where('id', $booking_id)->first();

        $payment = $cart_value_done_do->payment;
        $cart_id = $cart_value_done_do->cart_id;

        $order_value = CartItemsModel::where('cart_id', $cart_id)->first();

        $order_id_do = $order_value->order_id;

        $service_value = OrdersModel::where('id', $order_id_do)->first();



        if ($service_value->coupon_type == "Product") {

          $cart_value_done_do = BookingOrders::where('id', $booking_id)->first();

          $payment = $cart_value_done_do->payment;

          $product_percentage = $service_value->coupon_percentage;

          $amount_all = ($payment * $product_percentage / 100);

          $commissions_value_pro = Commissions::where('people_id', "1")->where('type', "Product")->first();

          $commissions_done_pro = $commissions_value_pro->value;

          $calculation_pro = ($commissions_done_pro * $amount_all / 100);
        } else {

          $cart_value_done_do = BookingOrders::where('id', $booking_id)->first();

          $payment = $cart_value_done_do->payment;

          $amount_all = $payment;

          $commissions_value_pro = Commissions::where('people_id', "1")->where('type', "Product")->first();

          $commissions_done_pro = $commissions_value_pro->value;

          $calculation_pro = ($commissions_done_pro * $amount_all / 100);
        }


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

        $commissions_value_pro = Commissions::where('people_id', "1")->where('type', "Product")->first();

        $commissions_done_pro = $commissions_value_pro->value;

        $calculation_pro = ($commissions_done_pro * $calculation_pro / 100);


        BookingProviderHistory::create([
          'handyman_id' => 0,
          'provider_id' => $provider_id,
          'booking_id' => $booking_id,
          'amount' => $calculation_pro,
          'service_id' => 0,
          'user_id' => $user_id_done,
          'commision_persontage' => $commissions_done_pro,
        ]);


        $cart_value_done = BookingOrders::where('id', $booking_id)->first();


        $user_id_done = $cart_value_done->user_id;
        $all_cart_id = $cart_value_done->cart_id;
        $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
        $order_id = $all_order__id->order_id;


        $FcmToken = User::where('id', $user_id_done)->value('device_token');

        $proviver_all_noti = NotificationsPermissions::where('id', "22")->where('status', "1")->first();


        $username =  User::where('id', $user_id)->first();

        // $firstname = $username->firstname;
        $firstname = $username->firstname . ' ' . $username->lastname;
        $type = "Product";

        $message = str_replace(
          ['[[ booking_id ]]'],
          ['#' . $booking_id],
          $proviver_all_noti->description
        );


        $data = [
          'title' => $proviver_all_noti->title,
          // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
          'message' => $message,
          'type' => $type,
          'booking_id' => $booking_id,
          'order_id' => $order_id,
        ];

        //  dd($data);

        $this->sendNotification(new Request($data), $FcmToken);

        $user_ser_done = BookingOrders::where('id', $booking_id)->first();

        //  $all_user_id = $user_ser_done->user_id;
        //  $provider_id = $user_ser_done->provider_id;


        $not_all_done = [
          'booking_id' => $request->input('booking_id'),
          // 'handyman_id' => $handyman_id_done,
          'provider_id' => $provider_id_done,
          'user_id' => $user_id_done,
          'title' => $proviver_all_noti->title,
          // 'message' =>  '#'.$booking_id . ' ' . $proviver_all_noti->description,
          'message' => $message,
          'type' => "Product",
          'created_at' => now(),
          'requests_status' => "1",
        ];

        $done = DB::table('user_notification')->insert($not_all_done);
      }

      if ($booking_status == "9") {

        $booking_id = $request->input('booking_id');
        $cart_value_done = BookingOrders::where('id', $booking_id)->first();

        $provider_id_done = $cart_value_done->provider_id;
        // $handyman_id_done = $cart_value_done->work_assign_id;
        $user_id_done = $cart_value_done->user_id;
        $all_cart_id = $cart_value_done->cart_id;
        $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
        $order_id = $all_order__id->order_id;

        $fetch_user = User::where('id', $user_id_done)->first();
        $email = $fetch_user->email;
        $firstname = $fetch_user->firstname;

        $product_name_all = Product::where('product_id', $cart_value_done->product_id)->first();
        $product_name = $product_name_all->product_name;

        $emailPreference = UserEmailProductInProgress::where('get_email', 1)->first();

        $formattedDateTime = $cart_value_done->created_at;

        $dateTime = new \DateTime($formattedDateTime);

        // Format the date and time
        $date = $dateTime->format('d M, Y - h:i A');


        if ($emailPreference) {
          // Send email on successful OTP verification
          Mail::to($email)->send(
            new UserProductInProgress($email, $firstname, $booking_id, $product_name, $date)
          );
        }

        $FcmToken = User::where('id', $user_id_done)->value('device_token');

        $proviver_all_noti = NotificationsPermissions::where('id', "35")->where('status', "1")->first();

        $message = str_replace(
          ['[[ booking_id ]]'],
          ['#' . $booking_id],
          $proviver_all_noti->description
        );


        $username =  User::where('id', $user_id)->first();

        // $firstname = $username->firstname;
        $firstname = $username->firstname . ' ' . $username->lastname;
        $type = "Product";


        $data = [
          'title' => $proviver_all_noti->title,
          // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description,
          'message' => $message,
          'type' => $type,
          'booking_id' => $booking_id,
          'order_id' => $order_id,
        ];

        //  dd($data);

        $this->sendNotification(new Request($data), $FcmToken);

        $user_ser_done = BookingOrders::where('id', $booking_id)->first();

        //  $all_user_id = $user_ser_done->user_id;
        //  $provider_id = $user_ser_done->provider_id;


        $not_all_done = [
          'booking_id' => $request->input('booking_id'),
          // 'handyman_id' => $handyman_id_done,
          'provider_id' => $provider_id_done,
          'user_id' => $user_id_done,
          'title' => $proviver_all_noti->title,
          // 'message' =>  '#'.$booking_id . ' ' . $proviver_all_noti->description,
          'message' => $message,
          'type' => "Product",
          'created_at' => now(),
          'requests_status' => "0",
        ];

        $done = DB::table('user_notification')->insert($not_all_done);
      }


      $temp = [
        "response_code" => "1",
        "message" => "Provider Status Update successfully",
        "status" => "success",
        // "unread_count" => $approve,
      ];

      return response()->json($temp);
    } catch (\Throwable $th) {
      //throw $th;
      return $this->sendError("User not Successfully", $th->getMessage());
    }
  }

  public function provider_assign_work_handyman(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'booking_id' => 'required',
      'work_assign_id' => 'required',
    ]);
    if ($validator->fails()) {

      return $this->sendError("Enter this field", $validator->errors(), 422);
    }

    $user_id = Auth::user()->token()->user_id;

    $work_assign_id = $request->input('work_assign_id');
    $booking_id = $request->input('booking_id');

    try {

      $is_user = User::where('id', $work_assign_id)->first();

      $is_online = $is_user->is_online;

      $datas = array(
        "work_assign_id" => $work_assign_id,
        "handyman_status" => "1",
        "is_online" => $is_online,
      );
      BookingOrders::where('provider_id', $user_id)->where('id', $booking_id)->update($datas);



      $data_all = [
        'booking_id' => $request->input('booking_id'),
        'provider_id' => $user_id,
        'work_assign_id' => $request->input('work_assign_id'),
        'status' => $request->input('status'),
        'created_at' => now(),
      ];

      $done = DB::table('booking_orders_status')->insert($data_all);


      $booking_id = $request->input('booking_id');

      $FcmToken = User::where('id', $work_assign_id)->value('device_token');



      $handyman_name  = User::where('id', $work_assign_id)->value('firstname');

      $handyman_email  = User::where('id', $work_assign_id)->value('email');

      $booking_date_all = now();

      $email = $handyman_email;
      $firstname = $handyman_name;

      $emailPreference = HandymanEmailAssignforOrder::where('get_email', 1)->first();

      $provider_all_done =  User::where('id', $user_id)->first();
      $provider_name = $provider_all_done->firstname;

      $dateTime = new \DateTime($booking_date_all);

      // Format the date and time
      $booking_date = $dateTime->format('d M, Y - h:i A');

      if ($emailPreference) {
        // Send email on successful OTP verification
        Mail::to($email)->send(
          new HandymanAssignforOrder($email, $booking_id, $provider_name, $booking_date, $firstname)
        );
      }

      // $emailPreference = ProviderEmailAssignHandyman::where('get_email', 1)->first();

      // $provider_all_done =  User::where('id', $user_id)->first();
      // $email = $provider_all_done->email;
      // $provider_name = $provider_all_done->firstname;

      // $provider_name = $handyman_name;
      // $dateTime = new \DateTime($booking_date_all);

      // // Format the date and time
      // $booking_date = $dateTime->format('d M, Y - h:i A');

      // if ($emailPreference) {
      //   // Send email on successful OTP verification
      //   Mail::to($email)->send(
      //     new ProviderAssignHandyman($email, $booking_id, $provider_name, $booking_date, $firstname)
      //   );
      // }


      $proviver_noti = NotificationsPermissions::where('id', "29")->where('status', "1")->first();

      $user_ser = BookingOrders::where('provider_id', $user_id)->where('id', $booking_id)->first();

      // $FcmToken_done = User::where('id', $user_ser->user_id)->value('device_token');

      $all_user_id = $user_ser->user_id;
      $all_cart_id = $user_ser->cart_id;
      $service = $user_ser->service_id;
      $name  = Service::where('id', $service)->first();
      $service_name = $name->service_name;
      $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
      $order_id = $all_order__id->order_id;

      $type = "Service";

      // Replace placeholders with actual values
      $message = str_replace(
        ['[[ booking_id ]]', '[[ service_name ]]'],
        ['#' . $booking_id, $service_name],
        $proviver_noti->description
      );

      $data = [
        'title' => $proviver_noti->title,
        // 'message' => '#'.$booking_id . ' ' . $proviver_noti->description . ' '.  $fromUser,
        'message'   => $message,
        'type' => $type,
        'booking_id' => $booking_id,
        'order_id' => $order_id,
      ];

      //  dd($data);
      $this->sendNotification(new Request($data), $FcmToken);

      // $this->sendNotification(new Request($data), $FcmToken_done);


      $not_all = [
        'booking_id' => $request->input('booking_id'),
        'provider_id' => 0,
        'handyman_id' => $request->input('work_assign_id'),
        'user_id' => 0,
        'title' => $proviver_noti->title,
        // 'message' => '#'.$booking_id . ' ' . $proviver_noti->description . ' '.  $fromUser,
        'message'   => $message,
        'type' => "Service",
        'created_at' => now(),
      ];

      $done = DB::table('user_notification')->insert($not_all);



      // $data = [
      //     'title' => "Assigned Booking",
      //     'message' => "Your booking $booking_id has been assigned to $fromUser. Check your booking for details and updates.",
      // ];



      // $this->sendNotification(new Request($data), $FcmToken);


      $temp = [
        "response_code" => "1",
        "message" => "Provider Work Assign successfully",
        "status" => "success",
        // "unread_count" => $approve,
      ];

      return response()->json($temp);
    } catch (\Throwable $th) {
      //throw $th;
      return $this->sendError("User not Successfully", $th->getMessage());
    }
  }

  public function add_faq_by_provider(Request $request)
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


    $all_service = $request->input('all_service');

    if (!empty($all_service)) {

      $all_id = Service::where('v_id', $user_id)->get();

      foreach ($all_id as $all_done) {

        $all_data['service_id'] = $all_done->id;
        $all_data['cat_id'] = $request->input('cat_id');
        $all_data['user_id'] = $user_id;
        $all_data['title'] = $request->input('title');
        $all_data['description'] = $request->input('description');
        $all_data['sub_cat_id'] = $request->input('sub_cat_id');
        $all_data['all_service'] = $request->input('all_service');
        $all_data['created_at'] = now();

        $done = DB::table('faq')->insert($all_data);
      }
    } else {

      $data = [
        'service_id' => $request->input('service_id'),
        'cat_id' => $request->input('cat_id'),
        'user_id' => $user_id,
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'sub_cat_id' => $request->input('sub_cat_id'),
        'created_at' => now(),
      ];

      $done = DB::table('faq')->insert($data);
    }

    if ($done) {
      return response()->json([
        'response_code' => '1',
        'message' => 'Faq Added Success',
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

  public function edit_faq_by_provider(Request $request)
  {
    $user_id = Auth::user()->id;

    $faq_id = $request->input('faq_id');

    $faq = DB::table('faq')->where('id', $faq_id)->where('user_id', $user_id)->first();

    if (!$faq) {
      return response()->json([
        'response_code' => '0',
        'message' => 'FAQ Not Found or Unauthorized',
        'status' => 'failure'
      ]);
    }

    // Update the FAQ data
    $updated = DB::table('faq')->where('id', $faq_id)->update([

      'cat_id' => $request->input('cat_id', $faq->cat_id),
      'title' => $request->input('title', $faq->title),
      'description' => $request->input('description', $faq->description),
      'sub_cat_id' => $request->input('sub_cat_id', $faq->sub_cat_id),
      // 'cat_id' => $request->input('cat_id'),
      // 'title' => $request->input('title'),
      // 'description' => $request->input('description'),
      'updated_at' => now(),
    ]);

    if ($updated) {
      return response()->json([
        'response_code' => '1',
        'message' => 'FAQ Updated Successfully',
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

  public function delete_faq_by_provider(Request $request)
  {
    $user_id = Auth::user()->token()->user_id;

    $faq_id = $request->input('faq_id');

    $user = Faq::where('id', $faq_id)->where('user_id', $user_id)->delete();

    if ($user) {
      // $user->delete();

      $result["response_code"] = "1";
      $result["message"] = "Faq deleted sucess..!";
      $result["status"] = "sucess";
      // return json_encode($result);
      return response()->json($result);

      // return response()->json(['message' => 'User account deleted successfully']);
    } else {
      // return response()->json(['message' => 'User already deleted']);
      $result["response_code"] = "0";
      $result["message"] = "Data base error.. Faq not deleted..!";
      $result["status"] = "fail";

      return response()->json($result);
    }
  }


  public function withdrawMoney_provider(Request $request)
  {
    try {
      //code...
      $validator = FacadesValidator::make($request->all(), [
        'amount' => 'required',
      ]);
      if ($validator->fails()) {
        return $this->sendError('error', $validator->errors(), 401);
      }

      //   $myId = $request->input('user_id');
      $myId = Auth::user()->id;
      $v_store = ProviderHistory::where('provider_id', $myId)->first();
      //   if (
      //     ProviderReqModel::where('provider_id', $myId)
      //       ->where('status', 0)
      //       ->exists()
      //   ) {
      //     $response = [
      //       'success' => 'false',
      //       'message' => 'Maximum Request Added.',
      //     ];
      //     return response()->json($response, 200);
      //   }

      if ($request->amount < 100) {
        $response = [
          'success' => 'false',
          'message' => 'Enter Minimum amount $100.',
        ];
        return response()->json($response, 200);
      }

      if ($request->amount <= $v_store->available_bal) {
        $totalreq = ProviderReqModel::where('provider_id', $myId)->sum('amount');
        // $totalreq = VendorReqModel::where('v_id', $myId)->where('status', 0)->sum('amount');

        if ($request->amount <= $v_store->available_bal) {
          ProviderReqModel::create([
            'provider_id' => $myId,
            'amount' => $request->amount,
            'status' => 0,
          ]);
          $v_store->update([
            'available_bal' => $v_store->available_bal - $request->amount,
            // 'total_bal' => $v_store->total_bal - $request->amount,
          ]);

          // $emailPreference = ProviderEmailPaymentRequestSent::where('get_email', 1)->first();

          // $provider_all_done =  User::where('id', $v_store->provider_id)->first();
          // $booking_date_all = now();
          // $firstname = $provider_all_done->firstname;
          // $email = $provider_all_done->email;

          // $user_all_done =  User::where('id', $myId)->first();

          // $provider_name = $user_all_done->firstname;

          // $dateTime = new \DateTime($booking_date_all);
          // $amount = $request->amount;

          // // Format the date and time
          // $booking_date = $dateTime->format('d M, Y - h:i A');

          // if ($emailPreference) {
          //   // Send email on successful OTP verification
          //   Mail::to($email)->send(
          //     new ProviderPaymentRequestSent($email, $provider_name, $booking_date, $firstname, $amount)
          //   );
          // }
          return $this->sendMessage('Requset send successfully.');
        }
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


  public function payReqList_provider_old(Request $request)
  {
    try {
      //code...
      // $myId = $request->user()->token()->user_id;
      //   $myId = $request->input('user_id');
      $myId = Auth::user()->id;
      $payReq = ProviderReqModel::where('provider_id', $myId)
        ->orderby('id', 'desc')
        ->get()
        ->transform(function ($tr) {
          $showcurrency = "$";
          $tr->provider_id = (string) $tr->provider_id;
          $tr->amount = (string) $showcurrency . $tr->amount;
          $tr->status = (string) $tr->status;
          $tr->req_at = $tr->created_at->format('d F Y');
          $tr->month = $tr->created_at->format('M');
          $tr->date = $tr->created_at->format('d');

          return $tr;
        });

      $v_store = ProviderHistory::where('provider_id', $myId)->first();
      if ($v_store) {
        $available_bal = $v_store->available_bal;
      } else {
        $available_bal = 0;
      }

      $temp = [
        'message' => 'Withdrawl List Found',
        'success' => 'true',
        'available_bal' => (int) $available_bal,
        'data' => $payReq,
      ];

      return response()->json($temp);
      // return $this->sendResponse($payReq, "Store details");
    } catch (\Throwable $th) {
      //throw $th;
      return $this->sendError('SolveThisError', $th->getMessage());
    }
  }

  public function payReqList_provider_new(Request $request)
  {
    try {
      $myId = Auth::user()->id;
      $today = Carbon::now()->startOfDay();
      $sevenDaysAgo = Carbon::now()->subDays(7)->startOfDay();
      $startOfLastMonth = Carbon::now()->subMonthNoOverflow()->startOfMonth();
      $endOfLastMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth()->endOfDay();

      $payReq = ProviderReqModel::where('provider_id', $myId)
        ->orderby('id', 'desc')
        ->get()
        ->transform(function ($tr) {
          $showcurrency = "$";
          $tr->provider_id = (string) $tr->provider_id;
          $tr->amount = (string) $showcurrency . $tr->amount;
          $tr->status = (string) $tr->status;
          $tr->req_at = $tr->created_at->format('d F Y');
          $tr->month = $tr->created_at->format('M');
          $tr->date = $tr->created_at->format('d');

          return $tr;
        });

      $todayRequests = $payReq->filter(function ($tr) use ($today) {
        return $tr->created_at->greaterThanOrEqualTo($today);
      });

      $last7DaysRequests = $payReq->filter(function ($tr) use ($today, $sevenDaysAgo) {
        return $tr->created_at->lessThan($today) && $tr->created_at->greaterThanOrEqualTo($sevenDaysAgo);
      });

      $lastMonthRequests = $payReq->filter(function ($tr) use ($startOfLastMonth, $endOfLastMonth) {
        return $tr->created_at->between($startOfLastMonth, $endOfLastMonth);
      });

      $v_store = ProviderHistory::where('provider_id', $myId)->first();
      if ($v_store) {
        $available_bal = $v_store->available_bal;
      } else {
        $available_bal = 0;
      }

      $temp = [
        'message' => 'Withdrawl List Found',
        'success' => 'true',
        'available_bal' => (int) $available_bal,
        'today' => $todayRequests->values(),
        'last7days' => $last7DaysRequests->values(),
        'lastmonth' => $lastMonthRequests->values(),
      ];

      return response()->json($temp);
    } catch (\Throwable $th) {
      return $this->sendError('SolveThisError', $th->getMessage());
    }
  }

  public function payReqList_provider_04_07(Request $request)
  {
    try {
      $myId = Auth::user()->id;
      $today = Carbon::now()->startOfDay();
      $sevenDaysAgo = Carbon::now()->subDays(7)->startOfDay();
      $startOfMonth = Carbon::now()->startOfMonth()->startOfDay();
      $startOfLastMonth = Carbon::now()->subMonthNoOverflow()->startOfMonth()->startOfDay();
      $endOfLastMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth()->endOfDay();

      $payReq = ProviderReqModel::where('provider_id', $myId)
        ->orderby('id', 'desc')
        ->get()
        ->transform(function ($tr) {
          $showcurrency = "$";
          $tr->provider_id = (string) $tr->provider_id;
          $tr->amount = (string) $showcurrency . $tr->amount;
          $tr->status = (string) $tr->status;
          $tr->req_at = $tr->created_at->format('d F Y');
          $tr->month = $tr->created_at->format('M');
          $tr->date = $tr->created_at->format('d');

          return $tr;
        });

      $todayRequests = $payReq->filter(function ($tr) use ($today) {
        return $tr->created_at->greaterThanOrEqualTo($today);
      });

      $last7DaysRequests = $payReq->filter(function ($tr) use ($today, $sevenDaysAgo) {
        return $tr->created_at->lessThan($today) && $tr->created_at->greaterThanOrEqualTo($sevenDaysAgo);
      });

      $lastMonthRequests = $payReq->filter(function ($tr) use ($startOfLastMonth, $endOfLastMonth) {
        return $tr->created_at->between($startOfLastMonth, $endOfLastMonth);
      });

      $olderRequests = $payReq->filter(function ($tr) use ($startOfLastMonth) {
        return $tr->created_at->lessThan($startOfLastMonth);
      })->groupBy(function ($tr) {
        return $tr->created_at->format('F');
      });

      $v_store = ProviderHistory::where('provider_id', $myId)->first();
      if ($v_store) {
        $available_bal = $v_store->available_bal;
      } else {
        $available_bal = 0;
      }

      $temp = [
        'message' => 'Withdrawl List Found',
        'success' => 'true',
        'available_bal' => (int) $available_bal,
        'today' => $todayRequests->values(),
        'last7days' => $last7DaysRequests->values(),
        'lastmonth' => $lastMonthRequests->values(),
        'older' => $olderRequests,
      ];

      return response()->json($temp);
    } catch (\Throwable $th) {
      return $this->sendError('SolveThisError', $th->getMessage());
    }
  }


  public function payReqList_provider(Request $request)
  {
    try {
      $myId = Auth::user()->id;

      // Fetch and group payment requests by date

      $payReq = ProviderReqModel::where('provider_id', $myId)
        ->orderby('id', 'desc')
        ->get();



      foreach ($payReq as $row) {

        $res = [];
        $res['id'] = (string)$row->id;
        $res['provider_id'] = $row->provider_id ?  (string)$row->provider_id : "";
        $res['amount'] = $row->amount  ?  (string)$row->amount : "";
        $res['status'] = (string)$row->status ?? "";
        $date = date('d M Y', strtotime($row->created_at));

        // $time = date('h:i', strtotime($row->created_at));


        $res['created_at_done'] = $date;
        // $res['time'] = $time;
        $res['created_at'] = $row->created_at ? $row->created_at : "";



        $users_all = ProviderBankdetails::where('provider_id', $row->provider_id)->first();

        $res['bank_name'] = $users_all->bank_name ?? "";
        $res['acc_number'] = $users_all->acc_number ?? "";




        $array[] = $res;
      }



      $data = ProviderReqModel::where('provider_id', $myId)
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($message) {
          return $message->created_at->format('Y-m-d');
        })
        ->map(function ($groupedMessages, $date) {
          $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d\TH:i:s.u\Z');
          return [
            'date' => $formattedDate,
            'messages' => $groupedMessages->map(function ($message) {

              $to_user_profile = ProviderBankdetails::select('bank_name', 'branch_name', 'acc_number', 'ifsc_code', 'mobile_number')->where('provider_id', $message->provider_id)->first();

              return [
                'id' => (string)$message->id,
                'provider_id' => (string)$message->provider_id,
                'amount' => (string)$message->amount,
                'status' => (string)$message->status ?? "",
                // 'created_at' => $message->created_at ? $message->created_at->toDateTimeString() : "",
                'created_at_done' => $message->created_at ? $message->created_at->format('d M Y') : "",
                'bank_name' => $to_user_profile ? ($to_user_profile->bank_name) : "",
                'acc_number' => $to_user_profile ? ($to_user_profile->acc_number) : "",
                'created_at' => $message->created_at ? $message->created_at : "",

              ];
            }),
          ];
        });

      $v_store = ProviderHistory::where('provider_id', $myId)->first();
      $available_bal = $v_store ? $v_store->available_bal : 0;

      $temp = [
        'message' => 'Withdrawal List Found',
        'success' => 'true',
        'available_bal' => (int) $available_bal,
        'latest_transaction' => $array ?? [],
        'transaction' => $data->values()->all(),
      ];

      return response()->json($temp);
    } catch (\Throwable $th) {
      return $this->sendError('SolveThisError', $th->getMessage());
    }
  }

  public function faq_list_done(Request $request)
  {
    $user_id = Auth::user()->id;
    $faq_list = Faq::where('user_id', $user_id)->get();

    $user_done = array();

    foreach ($faq_list as $faq_list_done) {

      $user_list['faq_id'] = $faq_list_done->id;
      $user_list['cat_id'] = (string)$faq_list_done->cat_id ?? "";
      $user_list['user_id'] = (string)$faq_list_done->user_id ?? "";
      $user_list['title'] = $faq_list_done->title ?? "";
      $user_list['description'] = $faq_list_done->description ?? "";

      array_push($user_done, $user_list);
    }

    if ($user_done) {

      $temp = [
        "response_code" => "1",
        "message" => "Faq List Find successfully",
        "status" => "success",
        "faq_list" => $user_done,
      ];

      return response()->json($temp);
    } else {

      $temp = [
        "response_code" => "0",
        "message" => "Faq List Not Find successfully",
        "status" => "failure",
        "faq_list" => [],
      ];

      return response()->json($temp);
    }
  }

  public function faq_list(Request $request)
  {
    $user_id = Auth::user()->id;
    $faq_list = Faq::where('user_id', $user_id)->get();

    $user_done = array();
    $titles_seen = array();

    foreach ($faq_list as $faq_list_done) {
      // if (!in_array($faq_list_done->title, $titles_seen)) {
      $user_list['faq_id'] = $faq_list_done->id;
      $user_list['cat_id'] = (string)$faq_list_done->cat_id ?? "";
      $user_list['user_id'] = (string)$faq_list_done->user_id ?? "";
      $user_list['title'] = $faq_list_done->title ?? "";
      $user_list['description'] = $faq_list_done->description ?? "";
      $user_list['service_id'] = (string)$faq_list_done->service_id ?? "";
      $user_list['sub_cat_id'] = (string)$faq_list_done->sub_cat_id ?? "";
      $user_list['all_service'] = (string)$faq_list_done->all_service ?? "";

      array_push($user_done, $user_list);
      //   array_push($titles_seen, $faq_list_done->title);
      // }
    }

    if ($user_done) {
      $temp = [
        "response_code" => "1",
        "message" => "Faq List Find successfully",
        "status" => "success",
        "faq_list" => $user_done,
      ];
    } else {
      $temp = [
        "response_code" => "0",
        "message" => "Faq List Not Find successfully",
        "status" => "failure",
        "faq_list" => [],
      ];
    }

    return response()->json($temp);
  }

  public function provider_add_bank_details(Request $request)
  {
    // dd($request->all());

    $user_id = Auth::user()->token()->user_id;
    // $id = $request->input('id');

    // if($id){

    $handyman = ProviderBankdetails::where('provider_id', $user_id)->first();

    if ($handyman) {
      $itemDtl = ProviderBankdetails::where('provider_id', $user_id)->first();

      $input = [
        // 'bank_name' => $request->bank_name ? $request->bank_name : $itemDtl->bank_name,
        // 'branch_name' => $request->branch_name ? $request->branch_name : $itemDtl->branch_name,
        // 'acc_number' => $request->acc_number ? $request->acc_number : $itemDtl->acc_number,
        // 'ifsc_code' => $request->ifsc_code ? $request->ifsc_code : $itemDtl->ifsc_code,
        // 'mobile_number' => $request->mobile_number ? $request->mobile_number : $itemDtl->mobile_number,

        'bank_name' => $request->bank_name ?? $itemDtl->bank_name ?? "",
        'branch_name' => $request->branch_name ?? $itemDtl->branch_name ?? "",
        'acc_number' => $request->acc_number ?? $itemDtl->acc_number ?? "",
        'ifsc_code' => $request->ifsc_code ?? $itemDtl->ifsc_code ?? "",
        'mobile_number' => $request->mobile_number ?? $itemDtl->mobile_number ?? "",

      ];
      // print_r($input);
      // exit;

      ProviderBankdetails::where('provider_id', $user_id)->update($input);

      return $this->sendResponse($input, 'Provider Bank Details Added successfully.');
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

    // $validator = Validator::make($request->all(), [
    //     'branch_name' => 'required',
    //     'bank_name' => 'required',
    //     'acc_number' => 'required',
    //     'ifsc_code' => 'required',
    //     'mobile_number' => 'required',

    // ]);

    // if ($validator->fails()) {
    //     return $this->sendError('Error validation', $validator->errors());
    // }




    // $input = $request->all();

    $done['branch_name'] = $request->input('branch_name') ?? "";
    $done['bank_name'] = $request->input('bank_name') ?? "";
    $done['acc_number'] = $request->input('acc_number') ?? "";
    $done['ifsc_code'] = $request->input('ifsc_code') ?? "";
    // $done['mobile_number'] = $request->input('mobile_number') ?? "";
    $done['provider_id'] = $user_id;

    $provider = ProviderBankdetails::create($done);

    return $this->sendResponse($done, 'Provider Bank Details Added successfully.');
  }

  public function provider_notification_list(Request $request)
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



    $notifications = user_notification::where('provider_id', $user_id)
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
            $questions_list['to_user'] = (int)$notification->provider_id;
            $questions_list['type'] = $notification->type;
            $questions_list['booking_id'] = $notification->booking_id;
            $questions_list['title'] = $notification->title;

            $questions_list['message'] = $notification->message;
            $questions_list['read_status'] = (int)$notification->read_provider;
            $questions_list['inside_date'] = $notification->created_at;
            $cart_id = BookingOrders::where('id', $notification->booking_id)->first();



            if ($cart_id) {

              $all_cart_id = $cart_id->cart_id;
              $booking_id = CartItemsModel::where('cart_id', $all_cart_id)->first();
              $questions_list['order_id'] = $booking_id->order_id;
            } else {
              $questions_list['order_id'] = 0;
            }

            $user = User::find($notification->from_user);

            $all_image = DefaultImage::where('people_id', "1")->first();
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
                $questions_list['profile_pic'] = url('/images/user/' . $my_image);
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
    //   "read_provider" =>  "1",
    // );

    // user_notification::where('provider_id', $user_id)
    //   ->update($data);

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

  public function provider_notification_verified(Request $request)
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
      "read_provider" =>  "1",
    );

    $seen_notification =  user_notification::where('not_id', $not_id)->where('provider_id', $user_id)
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

  public function provider_booking_status_history(Request $request)
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

    $notifications = user_notification::where('booking_id', $booking_id)->where('provider_id', $user_id)->where('review_noti', 0)->orderBy('not_id', 'ASC')->get();

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

  public function admin_booking_status_history(Request $request)
  {
    // $user_id = Auth::user()->token()->user_id;
    $booking_id = $request->input('booking_id');
    $user_id = $request->input('provider_id');

    if (!$user_id) {
      $result = [
        "response_code" => "0",
        "message" => "Enter Data",
        "status" => "failure",
      ];
      return response()->json($result);
    }

    $notifications = user_notification::where('booking_id', $booking_id)->where('provider_id', $user_id)->orderBy('not_id', 'ASC')->get();

    $list_notification = [];

    foreach ($notifications as $notification) {
      $questions_list['not_id'] = $notification->not_id;
      $questions_list['handyman_id'] = $notification->handyman_id;
      $questions_list['provider_id'] = $notification->provider_id;
      $questions_list['type'] = $notification->type;
      $questions_list['booking_id'] = $notification->booking_id;
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


  public function delete_service(Request $request)
  {
    // $myId = $request->user()->token()->user_id;
    $myId = Auth::user()->token()->user_id;
    $service_id = $request->input('service_id');

    if (!Service::where('v_id', $myId)->where('id', $service_id)->exists()) {
      return $this->sendMessage("Service is not Found.");
      // return response()->json([
      //     'message' => 'Cart not found..!'
      // ]);
    }


    $data = array(
      "is_delete" => "1",
    );

    Service::where('v_id', $myId)->where('id', $service_id)->update($data);
    return $this->sendMessage("Service removed Successfully.");
    // return response()->json([
    //     'message' => 'Cart removed successuly..!',
    // ]);
  }

  public function delete_product(Request $request)
  {
    // $myId = $request->user()->token()->user_id;
    $myId = Auth::user()->token()->user_id;
    $product_id = $request->input('product_id');

    if (!Product::where('vid', $myId)->where('product_id', $product_id)->exists()) {
      return $this->sendMessage("Product is not Found.");
      // return response()->json([
      //     'message' => 'Cart not found..!'
      // ]);
    }


    $data = array(
      "is_delete" => "1",
    );

    Product::where('vid', $myId)->where('product_id', $product_id)->update($data);
    return $this->sendMessage("Product removed Successfully.");
    // return response()->json([
    //     'message' => 'Cart removed successuly..!',
    // ]);
  }

  public function provider_handyman_payreq_list(Request $request)
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

    $notifications = BookingHandymanHistory::where('provider_id', $user_id)->orderByRaw("CASE WHEN handman_status = '1' THEN 0 ELSE 1 END")->orderBy('id', 'DESC')->get();

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
      $questions_list['status'] = $notification->handman_status;
      $questions_list['payment_method'] = $notification->payment_method ?? "";

      // Fetch user details
      $user = User::find($notification->user_id);
      if ($user) {
        $questions_list['customer_name'] = $user->firstname . ' ' . $user->lastname;
      } else {
        $questions_list['customer_name'] = 'Unknown Customer';
      }

      // Fetch provider details
      $provider = User::find($notification->handyman_id);
      if ($provider) {
        $questions_list['handyman_name'] = $provider->firstname . ' ' . $provider->lastname;
      } else {
        $questions_list['handyman_name'] = 'Unknown Provider';
      }

      $all_image = DefaultImage::where('people_id', "2")->first();
      $my_image = $all_image->image;



      $questions_list['handyman_profile_pic'] =  $provider->profile_pic ? url('/images/user/' . $provider->profile_pic) :  url('/images/user/' . $my_image);

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
    //               ->orWhere('handman_status', '1');
    //     })
    //     ->sum('amount');

    // // Check if bank details exist
    // $login_status = Bankdetails::where('user_id', $user_id)
    //     ->whereNotNull('bank_name')
    //     ->whereNotNull('branch_name')
    //     ->whereNotNull('acc_number')
    //     ->whereNotNull('ifsc_code')
    //     ->whereNotNull('mobile_number')
    //     ->exists() ? "1" : "0";

    // // Fetch bank details
    // $bank_details = Bankdetails::where('user_id', $user_id)->first();

    if ($list_notification) {
      $result = [
        "response_code" => "1",
        "message" => "All Handyman Payment Request List Found.",
        "detail" => $list_notification,
        // "totalAmount" => (string)$totalAmount,
        // "add_bank_details" => $login_status,
        // "bank_details" => $bank_details,
        "status" => "success",
      ];
    } else {
      $result = [
        "response_code" => "0",
        "message" => "All Handyman Payment Request List Not Found",
        "detail" => $list_notification,
        // "totalAmount" => (string)$totalAmount,
        // "add_bank_details" => $login_status,
        // "bank_details" => $bank_details,
        "status" => "failure",
      ];
    }

    return response()->json($result);
  }

  public function provider_update_handyman_payreq(Request $request)
  {
    $validator = Validator::make($request->all(), [
      // 'user_id' => 'required',
      'id' => 'required',
      'status' => 'required',
    ]);
    if ($validator->fails()) {

      return $this->sendError("Enter this field", $validator->errors(), 422);
    }

    $user_id = Auth::user()->token()->user_id;

    $id = $request->input('id');
    $status = $request->input('status');
    $payment_method = $request->input('payment_method');

    $done = BookingHandymanHistory::where('id', $id)->where('provider_id', $user_id)->first();

    if (empty($done)) {

      $temp = [
        "response_code" => "0",
        "message" => "This Provider is not updated status.",
        "status" => "failure",
        // "unread_count" => $approve,
      ];

      return response()->json($temp);
    }

    try {
      $data = array(
        "provider_id" => $user_id,
        "handman_status" => $status,
        "payment_method" => $payment_method,
      );
      BookingHandymanHistory::where('id', $id)->where('provider_id', $user_id)->update($data);

      if ($status == "2") {
        $prvider_new = HandymanHistory::where('handyman_id', $done->handyman_id)->first();

        if ($prvider_new) {

          $prvider_new->update([
            'total_bal' => $prvider_new->total_bal - $done->amount,
            'available_bal' => $prvider_new->available_bal - $done->amount,
          ]);
        } else {

          HandymanHistory::create([
            'handyman_id' => $done->handyman_id,
            'total_bal' => $done->amount,
            'available_bal' => $done->amount,
          ]);
        }

        $emailPreference = HandymanEmailBookingAccepted::where('get_email', 1)->first();

        $done_id = BookingHandymanHistory::where('id', $id)->first();
        $provider_id = $done_id->provider_id;
        $booking_id = $done_id->booking_id;
        $provider_all_done =  User::where('id', $done_id->handyman_id)->first();
        $service_name =  Service::where('id', $done_id->service_id)->value('service_name');
        $booking_date_all = now();
        $firstname = $provider_all_done->firstname;
        $email = $provider_all_done->email;

        $user_all_done =  User::where('id', $user_id)->first();

        $currency_done = SiteSetup::where('id', "1")->first();

        $currency = $currency_done->default_currency;

        $provider_name = $user_all_done->firstname;
        $handyman_name = $user_all_done->firstname;
        $dateTime = new \DateTime($booking_date_all);
        $amount = $done_id->amount;

        // Format the date and time
        $booking_date = $dateTime->format('d M, Y - h:i A');

        if ($emailPreference) {
          // Send email on successful OTP verification
          Mail::to($email)->send(
            new HandymanPaymentRequestAccepted($email, $booking_id, $handyman_name, $booking_date, $firstname, $amount, $service_name, $currency)
          );
        }



        $FcmToken = User::where('id', $done->handyman_id)->value('device_token');

        $proviver_all_noti = NotificationsPermissions::where('id', "40")->where('status', "1")->first();

        $booking_services_name =  Service::where('id', $done->service_id)->value('service_name');

        $currency_done = SiteSetup::where('id', "1")->first();

        $currency = $currency_done->default_currency;

        $amount = $done->amount;

        $message = str_replace(
          ['[[ booking_services_name ]]', '[[ amount ]]', '[[ currency ]]'],
          [$booking_services_name, $amount, $currency],
          $proviver_all_noti->description
        );


        //     $username =  User::where('id', $user_id)->first();

        // $firstname = $username->firstname;
        $type = "handyman_wallet";


        $data = [
          'title' => $proviver_all_noti->title,
          // 'message' => $servicename . ' ' . $proviver_all_noti->description . ' '. '$'.$done->amount,
          'message' => $message,
          'type' => $type,
          'booking_id' => $done->booking_id,
          'order_id' => 0,
        ];

        $this->sendNotification(new Request($data), $FcmToken);

        $not_all_done = [
          'booking_id' => $done->booking_id,
          'handyman_id' => $done->handyman_id,
          'provider_id' => "0",
          'user_id' => "0",
          'title' => $proviver_all_noti->title,
          // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description. ' '.  $firstname,
          'message' => $message,
          'type' => "handyman_wallet",
          'created_at' => now(),
          'requests_status' => "0",
          'review_noti' => "1",
        ];

        $dones = DB::table('user_notification')->insert($not_all_done);
      }


      if ($status == "3") {
        $done_id = BookingHandymanHistory::where('id', $id)->where('provider_id', $user_id)->first();

        $prvider_new = HandymanHistory::where('handyman_id', $done_id->handyman_id)->first();

        $emailPreference = HandymanEmailBookingRejected::where('get_email', 1)->first();

        // $done_id = BookingHandymanHistory::where('id', $id)->first();
        $provider_id = $done_id->provider_id;
        $booking_id = $done_id->booking_id;
        $provider_all_done =  User::where('id', $done_id->handyman_id)->first();
        $service_name =  Service::where('id', $done_id->service_id)->value('service_name');
        $booking_date_all = now();
        $firstname = $provider_all_done->firstname;
        $email = $provider_all_done->email;

        $user_all_done =  User::where('id', $user_id)->first();

        $currency_done = SiteSetup::where('id', "1")->first();

        $currency = $currency_done->default_currency;

        $provider_name = $user_all_done->firstname;
        $handyman_name = $user_all_done->firstname;
        $dateTime = new \DateTime($booking_date_all);
        $amount = $done_id->amount;

        // Format the date and time
        $booking_date = $dateTime->format('d M, Y - h:i A');

        if ($emailPreference) {
          // Send email on successful OTP verification
          Mail::to($email)->send(
            new HandymanPaymentRequestCancelled($email, $booking_id, $handyman_name, $booking_date, $firstname, $amount, $service_name, $currency)
          );
        }


        $FcmToken = User::where('id', $done->handyman_id)->value('device_token');

        $proviver_all_noti = NotificationsPermissions::where('id', "41")->where('status', "1")->first();

        $booking_services_name =  Service::where('id', $done->service_id)->value('service_name');

        $amount = $done->amount;

        $message = str_replace(
          ['[[ booking_services_name ]]', '[[ amount ]]'],
          [$booking_services_name, $amount],
          $proviver_all_noti->description
        );


        //     $username =  User::where('id', $user_id)->first();

        // $firstname = $username->firstname;
        $type = "handyman_wallet";


        $data = [
          'title' => $proviver_all_noti->title,
          // 'message' => $servicename . ' ' . $proviver_all_noti->description . ' '. '$'.$done->amount,
          'message' => $message,
          'type' => $type,
          'booking_id' => $done->booking_id,
          'order_id' => 0,
        ];

        $this->sendNotification(new Request($data), $FcmToken);


        $not_all_done = [
          'booking_id' => $done->booking_id,
          'handyman_id' => $done->handyman_id,
          'provider_id' => "0",
          'user_id' => "0",
          'title' => $proviver_all_noti->title,
          // 'message' => '#'.$booking_id . ' ' . $proviver_all_noti->description. ' '.  $firstname,
          'message' => $message,
          'type' => "handyman_wallet",
          'created_at' => now(),
          'requests_status' => "0",
          'review_noti' => "1",
        ];

        $done = DB::table('user_notification')->insert($not_all_done);

        $v_store = BookingHandymanHistory::where('provider_id', $user_id)
          ->where('id', $id)
          ->update(['handman_status' => "0"]);
      }
      $temp = [
        "response_code" => "1",
        "message" => "Provider Payment Updated Status Successfully",
        "status" => "success",
      ];

      return response()->json($temp);
    } catch (\Throwable $th) {
      //throw $th;
      return $this->sendError("User not Successfully", $th->getMessage());
    }
  }
  public function provider_wallet_list(Request $request)
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

    $notifications = BookingProviderHistory::where('provider_id', $user_id)->orderBy('id', 'DESC')->get();

    $list_notification = [];

    foreach ($notifications as $notification) {
      $questions_list = [];
      $questions_list['id'] = $notification->id;
      $questions_list['handyman_id'] = $notification->handyman_id ?? "";
      $questions_list['provider_id'] = $notification->provider_id ?? "";
      $questions_list['booking_id'] = $notification->booking_id ?? "";
      $questions_list['service_id'] = $notification->service_id ?? "";
      $questions_list['user_id'] = $notification->user_id ?? "";
      $questions_list['commision_persontage'] = $notification->commision_persontage;
      $questions_list['amount'] = $notification->amount;
      $questions_list['created_at'] = $notification->created_at;
      $questions_list['order_id'] = $notification->order_id ?? "";
      $questions_list['payment_method'] = $notification->payment_method ?? "";

      // Fetch user details
      $user = User::find($notification->user_id);
      if ($user) {
        $questions_list['customer_name'] = $user->firstname . ' ' . $user->lastname;
      } else {
        $questions_list['customer_name'] = 'Unknown Customer';
      }

      // Fetch provider details
      $provider = User::find($notification->handyman_id);
      if ($provider) {
        $questions_list['handyman_name'] = $provider->firstname . ' ' . $provider->lastname;
      } else {
        $questions_list['handyman_name'] = 'Unknown Provider';
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

    $totalAmount = ProviderHistory::where('provider_id', $user_id)->value('available_bal');


    if ($list_notification) {
      $result = [
        "response_code" => "1",
        "message" => "Provider Earning List Found.",
        "provider_earning" => $list_notification,
        "total_amount" => $totalAmount,
        "status" => "success",
      ];
    } else {
      $result = [
        "response_code" => "0",
        "message" => "Handyman Wallet List Not Found",
        "provider_earning" => $list_notification,
        "total_amount" => $totalAmount,
        "status" => "failure",
      ];
    }

    return response()->json($result);
  }

  public function provider_review_given(Request $request)
  {

    $user_id = Auth::user()->token()->user_id;

    $convo_list_arr = [];
    $service = ServiceReview::where('provider_id', $user_id)
      ->orderByDesc('id')
      ->get();

    foreach ($service as $key => $ro) {

      $user_list = [];
      $user_list['id'] = (string)$ro->id;
      $user_list['service_id'] = (string)$ro->service_id;
      $user_list['text'] = $ro->text ?? "";
      $user_list['star_count'] = (string)$ro->star_count;
      $user_list['type'] = "service";

      $user_list['user_id'] = (string)$ro->user_id;
      $user_list['booking_id'] = (string)$ro->booking_id;
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

      $user = User::where('id', $ro->user_id)->first();

      $all_image = DefaultImage::where('people_id', "3")->first();
      $my_image = $all_image->image;
      // $restaurant['provider_name'] = $user->firstname;
      $user_list['user_name'] = $user->firstname . ' ' . $user->lastname;
      $user_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);

      $user_list['product_id'] = "";
      $user_list['product_name'] = "";
      $user_list['product_image'] = [];

      $convo_list_arr[] = $user_list;
    }


    $product = ProductReview::where('provider_id', $user_id)
      ->orderByDesc('id')
      ->get();

    foreach ($product as $key => $row) {

      $product_list = [];
      $product_list['id'] = (string)$row->id;
      $product_list['product_id'] = (string)$row->product_id;
      $product_list['text'] = $row->text ?? "";
      $product_list['star_count'] = (string)$row->star_count;
      $product_list['type'] = "product";
      $product_list['booking_id'] = (string)$row->booking_id;;
      $product_list['user_id'] = (string)$row->user_id;

      $user_ser = BookingOrders::where('id', $row->booking_id)->first();
      $all_cart_id = $user_ser->cart_id;
      $all_order__id = CartItemsModel::where('cart_id', $all_cart_id)->first();
      $order_id = $all_order__id->order_id;
      $product_list['order_id'] = (string)$order_id;


      $createdDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)
        ->format('Y-m-d\TH:i:s.u\Z');

      $product_list['created_time'] = $createdDate;

      $notification_done = Product::where('product_id', $row->product_id)->with('productImages')->first();

      $product_list['product_name'] = $notification_done->product_name ?? "";

      $imgsa = [];

      foreach ($notification_done->productImages as $image) {
        $imgsa[] = asset('/images/product_images/' . $image->product_image);
      }

      $product_list['product_image'] = $imgsa;

      $product_list['service_id'] = "";
      $product_list['service_name'] = "";
      $product_list['service_image'] = [];

      $user = User::where('id', $row->user_id)->first();

      $all_image = DefaultImage::where('people_id', "3")->first();
      $my_image = $all_image->image;
      // $restaurant['provider_name'] = $user->firstname;
      $product_list['user_name'] = $user->firstname . ' ' . $user->lastname;
      $product_list['profile_pic'] =  $user->profile_pic ? url('/images/user/' . $user->profile_pic) :  url('/images/user/' . $my_image);


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
}
