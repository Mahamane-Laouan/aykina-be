<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
  public function index()
  {
    $notifications = Notifications::all();
    return view('content.apps.notifications-list', compact('notifications'));
  }

  // Datatables
  public function getNotificationData(Request $request)
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
    $totalRecords = Notifications::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Notifications::select('count(*) as allcount')->where('title', 'like', '%' . $searchValue . '%')->count();

    $records = Notifications::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('title', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();


    $data_arr = array();
    foreach ($records as $record) {
      $data_arr[] = array(
        "id" => $record->id,
        "title" => $record->title,
        "message" => $record->message,
        "created_at" => $record->created_at,
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


  // Add Notification
  public function addNotification()
  {
    return view('content.apps.notifications-add');
  }

  public function saveNotification(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'message' => 'required',
    ], [
      'title.required' => 'Please enter notification title.',
      'message.required' => 'Please enter message.',
    ]);

    // Create a new notification
    $notification = Notifications::create([
      'title' => $request->input('title'),
      'message' => $request->input('message'),
    ]);

    // Get all users
    // $users = User::all();

    // Associate the new notification with each user
    // foreach ($users as $user) {
    //   Notifications::create([
    //     'user_id' => $user->id,
    //     'title' => $request->input('title'),
    //     'message' => strip_tags($request->input('message')),
    //   ]);
    // }
    $notification->save();
    return redirect()->route('notifications-list')->with('message', 'Notification added successfully');
  }

  // Delete Notification
  public function deleteNotification($id)
  {
    $notification = Notifications::find($id);

    if (!$notification) {
      return response()->json(['success' => false]);
    }

    $notification->delete();
    return response()->json(['success' => true]);
  }
}
