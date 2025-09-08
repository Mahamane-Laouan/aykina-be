<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
  public function index()
  {
    $reviews = Review::all();
    return view('content.apps.reviews-list', compact('reviews'));
  }


  // Datatables
  public function getReviewData(Request $request)
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
    $totalRecords = Review::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Review::select('count(*) as allcount')->where('rev_user', 'like', '%' . $searchValue . '%')->count();

    $records = Review::select('reviews.*', 'restaurants.res_image')
      ->join('restaurants', 'reviews.rev_res', '=', 'restaurants.res_id')
      ->orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('restaurants.res_name', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();


    $data_arr = array();
    foreach ($records as $record) {
      $username = User::where('id', $record->rev_user)->value('username');
      $restaurantname = Service::where('res_id', $record->rev_res)->value('res_name');
      $data_arr[] = array(
        "rev_id" => $record->rev_id,
        "rev_user" => $username,
        "rev_res" => $restaurantname,
        "rev_date" => $record->rev_date,
        "rev_stars" => $record->rev_stars,
        "rev_text" => $record->rev_text,
        "res_image" => $record->res_image,
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


  // Delete Review
  public function deleteReview($id)
  {
    $review = Review::find($id);

    if (!$review) {
      return response()->json(['success' => false]);
    }

    $review->delete();
    return response()->json(['success' => true]);
  }
}
