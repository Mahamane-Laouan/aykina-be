<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
  public function index()
  {
    $coupons = Coupon::all();
    return view('content.apps.coupons-list', compact('coupons'));
  }


  // Datatables
  public function getCouponData(Request $request)
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
    $totalRecords = Coupon::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Coupon::select('count(*) as allcount')->where('code', 'like', '%' . $searchValue . '%')->count();

    $records = Coupon::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('code', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();

    $data_arr = array();
    foreach ($records as $record) {
      $createdAt = Carbon::parse($record->expire_date)->format('d M, Y / g:i A');
      $data_arr[] = array(
        "id" => $record->id,
        "code" => $record->code,
        "discount" => $record->discount,
        "type" => $record->type,
        "coupon_for" => $record->coupon_for,
        "status" => $record->status,
        "expire_date" => $createdAt,
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


  // Add Coupon
  public function saveCoupon(Request $request)
  {
    $rules = [
      'code' => 'required',
      'discount' => 'required',
      'type' => 'required',
      'expire_date' => 'required',
    ];

    $customMessages = [
      'code.required' => 'Please enter coupon code.',
      'discount.required' => 'Please enter discount.',
    ];

    $this->validate($request, $rules, $customMessages);

    $coupon = new Coupon();
    $coupon->code = $request->input('code');
    $coupon->discount = $request->input('discount');
    $coupon->type = $request->input('type');
    $coupon->coupon_for = $request->input('coupon_for');

    // Set status based on checkbox
    $status = $request->has('status') ? 1 : 0;
    $coupon->status = $status;

    $coupon->expire_date = $request->input('expire_date');

    $coupon->save();
    return redirect()->route('coupons-list')->with('message', 'Coupon added successfully');
  }


  // Delete Coupon
  public function deleteCoupon($id)
  {
    Coupon::find($id)->delete();
    return response()->json(['message' => 'Coupon deleted successfully', 'id' => $id]);
  }


  // ChangeCouponStatus
  public function ChangeCouponStatus($id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = Coupon::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = Coupon::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }
}
