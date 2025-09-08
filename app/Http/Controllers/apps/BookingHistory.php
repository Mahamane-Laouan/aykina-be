<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\BookHistory;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingHistory extends Controller
{
  public function index()
  {
    $users = BookHistory::all();
    return view('content.apps.booking-history', compact('users'));
  }

  // Datatables
  public function getBookingData(Request $request)
  {

    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length");

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column'];
    $columnName = $columnName_arr[$columnIndex]['data'];
    $columnSortOrder = $order_arr[0]['dir'];

    $searchValue = $search_arr['value'];
    $totalRecords = BookHistory::select('count(*) as allcount')->count();
    $totalRecordswithFilter = BookHistory::select('count(*) as allcount')->where('booking_status', 'like', '%' . $searchValue . '%')->count();

    $records = BookHistory::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('booking_status', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();


    $data_arr = array();
    foreach ($records as $record) {
      $provider = User::find($record->provider_id);
      if ($provider) {
        $provider_name = $provider->firstname . ' ' . $provider->lastname;
        $provider_profile_pic = $provider->profile_pic;
        $provider_email = $provider->email;
      } else {
        $provider_name = null;
        $provider_profile_pic = null;
        $provider_email = null;
      }

      $user = User::find($record->user_id);
      if ($user) {
        $user_name = $user->firstname . ' ' . $user->lastname;
        $user_profile_pic = $user->profile_pic;
        $user_email = $user->email;
      } else {
        $user_name = null;
        $user_profile_pic = null;
        $user_email = null;
      }

      $servicename = Service::where('id', $record->service_id)->value('service_name');
      $createdAt = Carbon::parse($record->created_at)->format('d M, Y / g:i A');

      $data_arr[] = array(
        "id" => $record->id,
        "order_id" => $record->order_id,
        "service_id" => $servicename,
        "created_at" => $createdAt,
        "user_id" => $user_name,
        "user_profile_pic" => $user_profile_pic,
        "user_email" => $user_email,
        "provider_id" => $provider_name,
        "provider_profile_pic" => $provider_profile_pic,
        "provider_email" => $provider_email,
        "booking_status" => $record->booking_status,
        "payment" => $record->payment,
        "payment_status" => $record->payment_status,
        "action" => ''
      );
    }

    $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordswithFilter,
      "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
  }


  // Delete Book History
  public function deleteHistory($id)
  {
    $users = BookHistory::find($id);

    if (!$users) {
      return response()->json(['success' => false]);
    }

    $users->delete();
    return response()->json(['success' => true]);
  }



  // public function BookingView($id)
  // {
  //   // Fetch booking details
  //   $booking = BookHistory::find($id);

  //   // Fetch customer details using the user_id from the booking table
  //   $customerDetails = User::select('firstname', 'email', 'mobile', 'lastname')
  //     ->where('id', $booking->user_id)
  //     ->first();

  //   // Fetch provider details using the provider_id from the booking table
  //   $providerDetails = User::select('firstname', 'email', 'mobile', 'lastname')
  //     ->where('id', $booking->provider_id)
  //     ->first();

  //   // Fetch handyman details using the handyman_id from the booking table
  //   $handymanDetails = User::select('firstname', 'email', 'mobile', 'lastname')
  //     ->where('id', $booking->handyman_id)
  //     ->first();

  //   // Fetch services associated with the booking
  //   $services = Service::select('service_name', 'service_price', 'service_discount_price', 'quantity')
  //     ->join('booking_orders', 'services.id', '=', 'booking_orders.service_id')
  //     ->where('booking_orders.id', $id)
  //     ->get();

  //   // Calculate subtotal
  //   $subTotal = $services->sum(function ($service) {
  //     return $service->service_price * $service->quantity;
  //   });

  //   // Calculate total discount amount
  //   $discount_amount = $services->sum(function ($service) {
  //     return ($service->service_price * $service->quantity - $service-> service_discount_price * $service->quantity) ;
  //   });

  //   // Calculate total amount after discount
  //   $total = $subTotal - $discount_amount;

  //   return view('content.apps.booking-view', compact('booking', 'customerDetails', 'providerDetails', 'handymanDetails', 'services', 'subTotal', 'discount_amount', 'total'));
  // }
  public function BookingView($id)
  {
    // Fetch booking details
    $booking = BookHistory::find($id);

    // Fetch customer details using the user_id from the booking table
    $customerDetails = User::select('firstname', 'email', 'mobile', 'lastname')
      ->where('id', $booking->user_id)
      ->first();

    // Fetch provider details using the provider_id from the booking table
    $providerDetails = User::select('firstname', 'email', 'mobile', 'lastname')
    ->where('id', $booking->provider_id)
    ->first();

    // Fetch handyman details using the handyman_id from the booking table
    $handymanDetails = User::select('firstname', 'email', 'mobile', 'lastname')
    ->where('id', $booking->handyman_id)
    ->first();

    // Fetch services associated with the booking
    $services = Service::select('service_name', 'service_price', 'service_discount_price', 'quantity')
    ->join('booking_orders', 'services.id', '=', 'booking_orders.service_id')
    ->where('booking_orders.id', $id)
    ->get();

    // Calculate subtotal
    $subTotal = $services->sum(function ($service) {
      return $service->service_price * $service->quantity;
    });

    // Calculate total discount amount
    $discount_amount = $services->sum(function ($service) {
      return ($service->service_price * $service->quantity - $service->service_discount_price * $service->quantity);
    });

    // Calculate total amount after discount
    $total = $subTotal - $discount_amount;

    // Fetch all handymen
    $handymen = User::where('user_role', 'handyman')->get();

    return view('content.apps.booking-view', compact('booking', 'customerDetails', 'providerDetails', 'handymanDetails', 'services', 'subTotal', 'discount_amount', 'total', 'handymen'));
  }



  public function assignHandyman(Request $request, $id)
  {
    // Validate the request
    $request->validate([
      'handyman_id' => 'required|exists:users,id',
    ]);

    // Find the booking order
    $booking = BookHistory::find($id);
    if (!$booking) {
      return redirect()->back()->with('error', 'Booking not found');
    }

    // Assign the handyman
    $booking->handyman_id = $request->handyman_id;
    $booking->save();

    return redirect()->route('booking-view', ['id' => $id])->with('message', 'Handyman assigned successfully');
  }
}
